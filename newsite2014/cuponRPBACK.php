<?
header("Content-type:text/html;charset=utf-8");

include_once 'inc.config.php';
require_once 'inc.config_argit.php';
require_once dirname(__FILE__) . '/argit/general/funciones.php';
session_start();
$mesactual = date("m");
$diaactual = date("d");
$agnoactual = date("Y");
$mec_id = addslashes($_GET['mec_id']);

if(!$mec_id){
	die('datos incorrectos');
}

if($_GET['tipo'] == "rp"){
$logo = "rapi-pago.png";	
}else{
$logo = "pago_facil.jpg";		
}


function ledad($dob, $diax, $mesx, $agnox) {
    list($d, $m, $y) = explode("/", $dob);
    $hoy = mktime(0, 0, 0, $diax, $mesx, $agnox);
    $cumple = mktime(0, 0, 0, "$d", "$m", "$y");
    $age = intval(($hoy - $cumple) / (60 * 60 * 24 * 365));
    return $age;
}

function agceros($nombreag, $cantceros) {
    while (strlen($nombreag) < $cantceros) {
        $nombreag = "0" . $nombreag;
    }
    return $nombreag;
}

$query = "SELECT * FROM inscribite_usuarios WHERE dni= '{$_SESSION['usuario']}' LIMIT 1";
$row1 = getRowQuery($query,$mysqli);
$nombredelusuario = $row1['nombre'];
$apellidodelusuario = $row1['apellido'];
$dniinscripto = $row1['dni'];
if ((!($dniinscripto >= 0)) || ($dniinscripto == '')){
		die('Ha ocurrido un error de sistema, por favor reinicie su inscripción <a href="http://www.inscribiteonline.com.ar/">desde aqui</a>. Disculpe las molestias');
	}
$dniinscripto = agceros($dniinscripto, 8);
$maildelusuario = $row1['email'];
$fechanac = $row1['fechanac'];
$query = "SELECT *,men_texto_cupon as textoencupon,mec_venc_3 as fecha
			FROM mensualidad_cuotas 
			INNER JOIN mensualidades ON men_id = mec_men_id
			INNER JOIN empresa ON emp_id = men_empresa
			WHERE mec_id= $mec_id and mec_id not in(SELECT meu_mec_id FROM `mensualidad_cuota_usuario`  where meu_mec_id = $mec_id and meu_u_dni = {$_SESSION['usuario']})";
		
$row2 = getRowQuery($query,$mysqli);

if(!$row2){
	echo '<html><body><h3>Cuota Paga</h3></body></html>';
	die();
}


$empresa = $row2['emp_nombre'];
$idevento = $row2['mec_id'];
$nombreevento = $row2['men_nombre'];
$tipoevento = 'Mensualidades';
//$puntosqcarga= $row2['puntos'];
$idevento = agceros($idevento, 4);


$row1 = $row2;
if($row1) {
    $row1['mec_venc_1'] = date('Ymd',strtotime($row1['mec_venc_1']));
	$row1['mec_venc_2'] = date('Ymd',strtotime($row1['mec_venc_2']));
	$row1['mec_venc_3'] = date('Ymd',strtotime($row1['mec_venc_3']));
	
	if ($row1['mec_venc_1'] == 0)
        $row1['mec_venc_1'] = 99999999;
    if ($row1['mec_venc_2'] == 0)
        $row1['mec_venc_2'] = 99999999;
    if ($row1['mec_venc_3'] == 0)
        $row1['mec_venc_3'] = 99999999;
    //$agnodefechavenc = '20' . substr('0' . $_GET['mes'], 3, 2);
	$agnodefechavenc = date('Y',strtotime($row1['mec_venc_3']));
	$mes = date('m',strtotime($row1['mec_venc_3']));

    if ($row1['mec_venc_1'] < 100)
        $row1['mec_venc_1'] = $agnodefechavenc . substr('0' . substr($mes, 0, 2), -2, 2) . substr('0' . $row1['mec_venc_1'], -2, 2);
    if ($row1['mec_venc_2'] < 100)
        $row1['mec_venc_2'] = $agnodefechavenc . substr('0' . substr($mes, 0, 2), -2, 2) . substr('0' . $row1['mec_venc_2'], -2, 2);
    if ($row1['mec_venc_3'] < 100)
        $row1['mec_venc_3'] = $agnodefechavenc . substr('0' . substr($mes, 0, 2), -2, 2) . substr('0' . $row1['mec_venc_3'], -2, 2);
    $diadehoymas7 = date("Ymd", (mktime(1, 1, 1, $mesactual, $diaactual, $agnoactual) + 60 * 60 * 24 * 7));

    if (($agnoactual . $mesactual . $diaactual) * 1 <= $row1['mec_venc_1'] * 1) {
        $precio1 = $row1['mec_imp_1'];
        $precio2 = $row1['mec_imp_2'];
        $fechavencimiento1 = $diadehoymas7;
        if ($row1['mec_venc_1'] < $diadehoymas7)
            $fechavencimiento1 = $row1['mec_venc_1'];
        $fechavencimiento2 = $diadehoymas7;
        if ($row1['mec_venc_2'] < $diadehoymas7)
            $fechavencimiento2 = $row1['mec_venc_2'];
    } elseif (($agnoactual . $mesactual . $diaactual) * 1 <= $row1['mec_venc_2'] * 1) {
        $precio1 = $row1['mec_imp_2'];
        $precio2 = $row1['mec_imp_3'];
        $fechavencimiento1 = $diadehoymas7;
        if ($row1['mec_venc_2'] < $diadehoymas7)
            $fechavencimiento1 = $row1['mec_venc_2'];
        $fechavencimiento2 = $diadehoymas7;
        if ($row1['mec_venc_3'] < $diadehoymas7)
            $fechavencimiento2 = $row1['mec_venc_3'];
    } else{
        //si el tipo de evento es servicios puede ser una mensualidad que se paga la del mes pasado ya vencida pasado el 3cer venc
        $precio1 = $row1['mec_imp_3'];
        $precio2 = $row1['mec_imp_3'];
        $fechavencimiento1 = $diadehoymas7;
        if (($agnoactual . $mesactual . $diaactual) * 1 <= $row1['mec_venc_3'] * 1){
            $fechavencimiento1 = $row1['mec_venc_3'];
		}else{
			$fechavencimiento1 = $diadehoymas7;
		}
        $fechavencimiento2 = $fechavencimiento1;
    } 
	
	/*PUNITORIO*/
	$hoy = date('Ymd');
	if ($row1['mec_venc_3'] < $hoy){
		$punitorio =  $row1['mec_imp_3']*$row1['men_punitorio'];
		$precio2 = $precio2+$punitorio;
		$precio1 = $precio1+$punitorio;
	}

    $desdeel1ervh2do = $fechavencimiento2 - $fechavencimiento1;
    $diasparav = gregoriantojd(substr($fechavencimiento1, 4, 2), substr($fechavencimiento1, 6, 2), substr($fechavencimiento1, 0, 4)) - gregoriantojd(1, 1, $agnoactual);
    $diasparav++;
    $desdeel1ervh2do = agceros($desdeel1ervh2do, 2);
    $diasparav = agceros($diasparav, 3);
    $montopesos = floor($precio1);
    $montopesos = agceros($montopesos, 6);
    $montocenta = $precio1 - floor($precio1);
	$montocenta = str_replace("0.","0",agceros($montocenta, 2));
	
	
    $montoven1 = floor($precio2) - $montopesos;
    $montoven1 = agceros($montoven1, 4);
    $montoven1cent = abs($precio2 - floor($precio2)) * 100;
    $montoven1cent = agceros($montoven1cent, 2);
    $categoria = $row1['mec_id'];
    $categoria = agceros($categoria, 2);
    $idcliente = $idevento . $categoria . $dniinscripto;

    $agnoactualfxd = $agnoactual;
    $diasparavfxd = $diasparav;
    if ($diasparavfxd > 365) {
        $diasparavfxd -= 365;
        $agnoactualfxd++;
        $diasparavfxd = agceros($diasparavfxd, 3);
        $agnoactualfxd = agceros($agnoactualfxd, 2);
    }

    $barcode1 = array(1, 2, 1, 2, 1, 2, 1, 1, 2, 1);
    $barcode2 = array(1, 1, 2, 2, 1, 1, 2, 1, 1, 2);
    $barcode3 = array(2, 1, 1, 1, 2, 2, 2, 1, 1, 1);
    $barcode4 = array(2, 1, 1, 1, 1, 1, 1, 2, 2, 2);
    $barcode5 = array(1, 2, 2, 1, 2, 1, 1, 2, 1, 1);
    // 4: nro fijo que identifica a la empresa
    $a = array("0", "2", "4", "6", " ");
    // 6: monto enteros
    for ($z = 0; $z <= 5; $z++)
        array_push($a, substr($montopesos, $z, 1));
    array_push($a, " ");
    // 2: monto decimales
    for ($z = 0; $z <= 1; $z++)
        array_push($a, substr($montocenta, $z, 1));
    array_push($a, " ");
    // fecha primer vencimiento AAJJJ (JJJ son la cantidad de dias desde el 1 de enero del año corriente
    for ($z = 2; $z <= 3; $z++)
        array_push($a, substr($agnoactualfxd, $z, 1));
    for ($z = 0; $z <= 2; $z++)
        array_push($a, substr($diasparavfxd, $z, 1));
    array_push($a, " ");
    // id del cliente (DNI?) 15 cifras o 14 ???
    for ($z = 0; $z <= 13; $z++)
        array_push($a, substr($idcliente, $z, 1));
    array_push($a, " ");
    // tipo de moneda (0 si es en pesos)
    array_push($a, "0");
    array_push($a, " ");
    // monto segundo vencimiento (no:=al 1ero / TODOS CERO) / enteros
    for ($z = 0; $z <= 3; $z++)
        array_push($a, substr($montoven1, $z, 1));
    array_push($a, " ");
    // decimales
    for ($z = 0; $z <= 1; $z++)
        array_push($a, substr($montoven1cent, $z, 1));
    array_push($a, " ");
    // fecha segundo vencimiento (no:=al 1ero / CANT DE DIAS DESDE EL 1ERO)
    for ($z = 0; $z <= 1; $z++)
        array_push($a, substr($desdeel1ervh2do, $z, 1));
    array_push($a, " ");
    $secuencia = array(9, 3, 5, 7);
    // digito verificador 1
    $b = array();
    foreach ($a as $val) {
        if ($val != ' ')
            array_push($b, $val);
    }
    $verif = 0;
    for ($i = 1; $i <= count($b); $i++)
        $verif += $b[$i] * $secuencia[$i % 4];
    array_push($a, intval($verif / 2) % 10);
    array_push($b, end($a));
    // digito verificador 2
    $verif = 0;
    for ($i = 1; $i <= count($b); $i++)
        $verif += $b[$i] * $secuencia[$i % 4];
    array_push($a, intval($verif / 2) % 10);
    array_push($b, end($a));
}
$yaseinscribio = false;


if ($_GET['reimpr'] != "" || !$yaseinscribio) {
	//include_once 'mails/mailinscripto_servic.php';
    
    //mail($maildelusuario, "Para ver nuevamente el cupon de pago ingrese a http://inscribiteonline.com.ar, ingrese con su dni y password, ver mi cuenta y podrá reimprimir el cup&oacute;n.Inscripcion reservada", $msg, "From: Inscribite Online <info@inscribiteonline.com.ar>\r\nContent-Type: text/html;charset=utf-8\r\n");
    ?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
            <title>Inscribite Online, cupon de pago</title>
<style type="text/css">
  <!--
  body{
    font-family:Arial, sans-serif;
    font-size:10px;
    background:white;
    margin-left:0px;
    margin-top:0px;
    margin-right:0px;
    margin-bottom:0px;
  }
  img{
    border:0px;
    margin:0px;
    padding:0px;
    vertical-align:middle;
  }
  a{
    text-decoration:none;
  }
  a img{
    border:0px;
  }
  .codebar{
    float:left;
    text-align:right;
    padding-left:244px;
  }
  .codebar img{
    float:left;
    clear:none;
    width:1px;
    height:40px;
    margin:0px;
    display:block;
  }
  #factura{
    height:650px;
    text-align:center;
    height:auto;
    border-style:groove;
    border-width:1px;
    border-spacing:2px;
    padding:2px;
  }
  table{
    font-size:10px;
    border-collapse:collapse;
    border:none;
  }
  td{
    border:none;
  }
  .Estilo2{
    font-size:12px;
    font-weight:bold;
    color:#FF6600;
  }
  .Estilo3{
    font-size:10px;
  }
  .Estilo4{
    color:#EB177D;
    font-weight:bold;
    font-size:11px;
  }
  #Layer1{
    position:absolute;
    width:100px;
    height:100px;
    z-index:1;
    left:711px;
    top:7px;
    background-color:#FFFFFF;
    border:#333333 double;
  }
  .datos{
    font-size:12px;
    float:left;
    clear:none;
    width:500px;
    margin-left:100px;
    margin-bottom:10px;
  }
  .columna1datos{
    font-weight:bold;
    width:250px;
  }
  div{
    float:left;
  }
  .avisopartesticket{
    text-align:left;
    font-size:11px;
    color:#FF6600;
    padding-bottom:3px;
    width:100%;
  }
  -->
  </style>
        </head>
        <body>
            <div style="float:none;width:780px;margin:0px auto;">
                <div class="avisopartesticket">
                    Comprobante para Pagar Para el Usuario
                </div>
                <div style="float:left;width:100%;margin-bottom:13px;">
                    <img src="images/pago_rapi.png" alt="logo_pagofacil" style="float:left;"/>
                    <div style="float:right;clear:none;width:364px;text-align:center;">
                        <img src="images/logo.png" alt="" width="47%" border="0"/>
                    </div>
                </div>
                <div class="Estilo2" style="float:left;">Datos de la operaci&oacute;n</div>
                <table class="datos">
                    <tr>
                        <td class="columna1datos">Mensualidad:</td>
                        <td><?= $nombreevento ?></td>
                    </tr>
					<tr>
                        <td class="columna1datos">Nro cuota:</td>
                        <td><?= $row2['mec_nro_cuota'] ?></td>
                    </tr>
                    <tr>
                        <td class="columna1datos">Id. Inscripto </td>
                        <td><?= $idcliente ?></td>
                    </tr>
                    <tr>
                        <td class="columna1datos">Participante: </td>
                        <td><?= $nombredelusuario . ' ' . $apellidodelusuario ?></td>
                    </tr>
                    <tr>
                        <td class="columna1datos">Importe</td>
						<?php
						//echo 'pesos'.intval($montopesos).' centavos'.intval($montocenta);die('asd');
						?>
                        <td><?= intval($montopesos) . '.' . str_replace("0.","",$montocenta) ?></td>
                    </tr>
                    <tr>
                        <td class="columna1datos">Moneda</td>
                        <td>PESOS</td>
                    </tr>
                    <tr>
                        <td class="columna1datos">Fecha de emisi&oacute;n</td>
                        <td>(<?= $diaactual . "/" . $mesactual . "/" . $agnoactual ?>)</td>
                    </tr>
                    <tr>
                        <td class="columna1datos"><?= ($fechavencimiento1 != $fechavencimiento2) ? 'Primer ' : '' ?>Vencimiento</td>
                        <td>(<?= substr($fechavencimiento1, 6, 2) . "/" . substr($fechavencimiento1, 4, 2) . "/" . substr($fechavencimiento1, 0, 4) ?>)</td>
                    </tr>
                        <? if ($fechavencimiento2 != $fechavencimiento1) { ?>
                        <tr>
                            <td class="columna1datos">Segundo Vencimiento</td>
                            <td>(<?= substr($fechavencimiento2, 6, 2) . "/" . substr($fechavencimiento2, 4, 2) . "/" . substr($fechavencimiento2, 0, 4) ?>)</td>
                        </tr>
                        <tr>
                            <td class="columna1datos">Recargo</td>
                            <td><?= ($montoven1 + 0) . ',' . $montoven1cent ?></td>
                        </tr>
                        <? } ?>
                </table>
                <div style="float:left;width:100%;">
                    <div style="float:left;width:100%;margin:2px 0px 2px 0px;" class="Estilo4">IMPORTANTE:</div>
                    Verifique en los datos de la operaci&oacute;n que abonara la mensualidad correcta	
Usted recibir&aacute; un mail a la direcci&oacute;n ingresada con el detalle de esta operaci&oacute;n y copia del presente comprobante Busque su Pago F&aacute;cil o Rapi Pago 
m&aacute;s cercano en www.pagofacil.com.ar/ o www.rapipago.com.ar.<br>
							<?=$row2['textoencupon']?>
                            <?php
								$edaddelusuarioaldiadelev = ledad(substr($fechanac, 6, 2) . '/' . substr($fechanac, 4, 2) . '/' . substr($fechanac, 0, 4), substr($row2['fecha'], 0, 2), substr($row2['fecha'], 3, 2), '20' . substr($row2['fecha'], 6, 2)) - 1;
								if ($edaddelusuarioaldiadelev < 18){
                                echo '<br/><br/><span style="color:black;font-weight:bold;font-size:11px;">ESTE CUPON DEBE SER FIRMADO POR PADRE, MADRE O TUTOR, aclarando firma y numero de DNI.</span>';
								}
							?>
                </div>
                <div style="float:left;width:100%;font-size:12px;padding:12px 0px 7px 0px;">
                    Firma _________________________________
                    &nbsp;&nbsp;&nbsp;&nbsp;Aclaraci&oacute;n _________________________________
                </div>
                <div>
                    <img src="webimages/tijera.gif" alt=".................................................." style="margin-left:57px;margin-bottom:12px;"/>
                </div>
                <div>
                    <div class="avisopartesticket">
                        Para el agente
                    </div>

                    <div class="codebar">
                        <img src="webimages/negro.gif"  alt=""/>
                        <img src="webimages/blanco.gif" alt=""/>
                        <img src="webimages/negro.gif"  alt=""/>
                        <img src="webimages/blanco.gif" alt=""/>
    <?
    for ($i = 0; $i < count($b); $i += 2) {
        if ($i <= count($b)) {
            for ($n = 0; $n < $barcode1[$b[$i]]; $n++)
                echo'        <img src="webimages/negro.gif"  alt=""/>' . "\n";
            for ($n = 0; $n < $barcode1[$b[$i + 1]]; $n++)
                echo'        <img src="webimages/blanco.gif" alt=""/>' . "\n";
            for ($n = 0; $n < $barcode2[$b[$i]]; $n++)
                echo'        <img src="webimages/negro.gif"  alt=""/>' . "\n";
            for ($n = 0; $n < $barcode2[$b[$i + 1]]; $n++)
                echo'        <img src="webimages/blanco.gif" alt=""/>' . "\n";
            for ($n = 0; $n < $barcode3[$b[$i]]; $n++)
                echo'        <img src="webimages/negro.gif"  alt=""/>' . "\n";
            for ($n = 0; $n < $barcode3[$b[$i + 1]]; $n++)
                echo'        <img src="webimages/blanco.gif" alt=""/>' . "\n";
            for ($n = 0; $n < $barcode4[$b[$i]]; $n++)
                echo'        <img src="webimages/negro.gif"  alt=""/>' . "\n";
            for ($n = 0; $n < $barcode4[$b[$i + 1]]; $n++)
                echo'        <img src="webimages/blanco.gif" alt=""/>' . "\n";
            for ($n = 0; $n < $barcode5[$b[$i]]; $n++)
                echo'        <img src="webimages/negro.gif"  alt=""/>' . "\n";
            for ($n = 0; $n < $barcode5[$b[$i + 1]]; $n++)
                echo'        <img src="webimages/blanco.gif" alt=""/>' . "\n";
        }
    }
    ?>
                        <img src="webimages/negro.gif"  alt=""/>
                        <img src="webimages/negro.gif"  alt=""/>
                        <img src="webimages/blanco.gif" alt=""/>
                        <img src="webimages/negro.gif"  alt=""/>
                        <div style="float:left;clear:both;width:100%;">
    <?= implode($a) . "\n" ?>
                        </div>
                    </div>
                    <div style="width:100%;text-align:center;margin-top:9px;">
                        <a href="javascript:self.print()" style="margin-right:8px;">
                            <img src="webimages/image004.gif" alt="cerrar" style="margin-right:5px;"/><strong>Imprimir</strong></a>
                        <a href="<?= url ?>" style="margin-left:8px;">
                            <img src="webimages/image004.gif" alt="imprimir" style="margin-right:5px;"/><strong>Cerrar</strong></a>
                        <div style="width:100%;margin-top:5px;">
                            Por favor, imprima esta p&aacute;gina y dir&iacute;jase al Pago F&aacute;cil m&aacute;s cercano para realizar su pago.
                        </div>
    <?
    //$result1 = mysql_query('SELECT * FROM '.pftables.'banners WHERE ver = 1 AND ( evento = "'.$_GET['evento'].'" OR evento = "0" ) AND ( ubicacion = 0 OR ubicacion = 2 ) ');
    /*$result1 = mysql_query('SELECT * FROM ' . pftables . 'banners WHERE ver = 1 AND (eventos LIKE "%_' . $row2['id'] . ',%" OR eventos LIKE "_0,%") AND ( ubicacion = 0 OR ubicacion = 2 ) ');
    while ($row1 = mysql_fetch_array($result1)) {
        echo '       <div style="width:576px;height:60px;margin:9px 0px 9px 123px;">' . "\n";
        echo '         <a href="http://www.inscribiteonline.com.ar/"><img src="http://www.inscribiteonline.com.ar/newsite2014/images/logo.png" alt="" style="float:left;clear:none;margin-right:32px"/></a>' . "\n";
        echo '       </div>' . "\n";
    }*/
    ?>
                    </div>
                </div>
            </div>
            <script src="http://www.google-analytics.com/urchin.js" type="text/javascript"></script>
            <script type="text/javascript">
                <!--
              _uacct = "UA-1091133-1";
                urchinTracker();
                // <?= '123 ' . $errorpvver ?>
    -->
            </script>
        </body>
    </html>
    <?
    if (is_resource($result1))
        mysql_free_result($result1);
    if (is_resource($result2))
        mysql_free_result($result2);
    if (is_resource($result3))
        mysql_free_result($result3);
    mysql_close();
} else {
    include_once 'insccerrada.php';
}
?>