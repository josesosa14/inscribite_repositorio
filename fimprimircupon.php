<? include_once 'inc.config.php';

//session_start();
$mesactual = date("m");
$diaactual = date("d");
$agnoactual = date("Y");
//$diaactual = "31";
//$mesactual = "08";
$fechaactual = $agnoactual.$mesactual.$diaactual;

header("Content-type:text/html;charset=utf-8");
function ledad($dob,$diax,$mesx,$agnox) {
	// El formato es dd/mm/yy
	list($d,$m,$y)=explode("/",$dob);
	$hoy=mktime(0,0,0,$diax,$mesx,$agnox);
	$cumple=mktime(0,0,0,"$d","$m","$y");
	$age=intval(($hoy-$cumple)/(60*60*24*365));
	return $age;
}
function agceros($nombreag,$cantceros) {
	while (strlen($nombreag)<$cantceros)$nombreag="0".$nombreag;
	return $nombreag;
}

$usuario = $_COOKIE['usuario'];
$result1 = mysql_query('SELECT * FROM '.pftables.'usuarios WHERE dni="'.$usuario.'" LIMIT 1 ');
$row1 = mysql_fetch_array($result1);
$nombredelusuario = $row1['nombre'];
$apellidodelusuario = $row1['apellido'];
$sexodelusuario = $row1['sexo'];
$diadenacusuario = $row1['dianacimiento'];
$mesdenacusuario = $row1['mesnacimiento'];
$agnodenacusuario = $row1['agnonacimiento'];
$dniinscripto = $row1['dni'];
$dniinscripto = agceros($dniinscripto,8);
$maildelusuario = $row1['email'];
if (strlen($dniinscripto) == 0) echo '<script type="text/javascript">location.href="'.url.'iniciainscri?evento='.$_GET['evento'].'"; </script>';

$result1 = mysql_query('SELECT * FROM '.pftables.'categorias WHERE((nombre="'.$_GET['cat'].'")AND(deevento="'.$_GET['evento'].'")AND(codigo="'.$_GET['cod'].'")) LIMIT 1 ');
if (mysql_num_rows($result1) == 0)
    $result1 = mysql_query('SELECT * FROM '.pftables.'categorias WHERE((nombre="'.$_GET['cat'].'")AND(deevento="'.$_GET['evento'].'")) LIMIT 1 ');
while ($row1 = mysql_fetch_array($result1)) {

	$precioarray = array();
	$precio2dovarray = array();

    if ($row1['fechavenc1'] == 0) $row1['fechavenc1'] = 99999999;
    if ($row1['fechavenc2'] == 0) $row1['fechavenc2'] = 99999999;
    if ($row1['fechavenc3'] == 0) $row1['fechavenc3'] = 99999999;
	// Antes del 1er vencimiento
	if ((gregoriantojd($mesactual,$diaactual,$agnoactual)<gregoriantojd(substr($row1['vencimiento1'],5,2),substr($row1['vencimiento1'], 8, 2),substr($row1['vencimiento1'],0,4))) || ($row1['vencimiento1']=='0000-00-00')) {
    //if ($fechaactual*1<$row1['fechavenc1']*1) {
    	$precioarray = explode(',',$row1['precio1']);
		$precio2dovarray = explode(',',$row1['precio2']);
		$diasparav = gregoriantojd(substr($row1['vencimiento1'],5,2),substr($row1['vencimiento1'],8,2),substr($row1['vencimiento1'],0,4))-gregoriantojd(1,1,$agnoactual);
		$diasparav++;
		$desdeel1ervh2do = gregoriantojd(substr($row1['vencimiento2'],5,2),substr($row1['vencimiento2'],8,2),substr($row1['vencimiento2'],0,4))-gregoriantojd(substr($row1['vencimiento1'],5,2),substr($row1['vencimiento1'],8,2),substr($row1['vencimiento1'],0,4));
        //$desdeel1ervh2do++;
        //echo $desdeel1ervh2do;
		$desdeel1ervh2do = agceros($desdeel1ervh2do,2);

		$diaquevence = substr($row1['vencimiento1'],8,2);
		$mesquevence = substr($row1['vencimiento1'],5,2);
		$agnoquevence = substr($row1['vencimiento1'],0,4);
		if (($diaquevence-1) == 0) {
			$diaquevence = (gregoriantojd($mesquevence,1,$agnoactual)-gregoriantojd($mesquevence-1,1,$agnoactual))+1;
			$mesquevence--;
		}
		$diaquevence = ($diaquevence-1);
		$diaquevence = agceros($diaquevence,2);
		$mesquevence = agceros($mesquevence,2);
        if ($row1['vencimiento1'] == '0000-00-00') {
		    $mesquevence = date('m');
		    $diaquevence = date('d')+7;
            if ($diaquevence>29) { $diaquevence -= 29; $mesquevence++; }
		    $agnoquevence = date('Y');
            $diasparav = gregoriantojd($mesquevence,$diaquevence,$agnoquevence)-gregoriantojd(1,1,$agnoactual);
            $diasparav++;
            $desdeel1ervh2do = 1;
        }
		$fechaquevence = $diaquevence."/".$mesquevence."/".$agnoquevence;
    } elseif (gregoriantojd($mesactual,$diaactual,$agnoactual)<gregoriantojd(substr($row1['vencimiento2'],5,2),substr($row1['vencimiento2'],8,2),substr($row1['vencimiento2'],0,4))) {
    //}elseif ($fechaactual*1<$row1['fechavenc2']*1) {

		//"Antes del 2do vencimiento";
		$precioarray = explode(',',$row1['precio2']);
		$precio2dovarray = explode(',',$row1['precio3']);
		$diasparav = gregoriantojd(substr($row1['vencimiento2'],5,2),substr($row1['vencimiento2'],8,2),substr($row1['vencimiento2'], 0, 4))-gregoriantojd(1,1,$agnoactual);
		$diasparav++;
		$desdeel1ervh2do = gregoriantojd(substr($row1['vencimiento3'],5,2),substr($row1['vencimiento3'],8,2),substr($row1['vencimiento3'],0,4))-gregoriantojd(substr($row1['vencimiento2'],5,2),substr($row1['vencimiento2'],8,2),substr($row1['vencimiento2'],0,4));
		//$desdeel1ervh2do++;
		$desdeel1ervh2do = agceros($desdeel1ervh2do,2);
		$diaquevence = substr($row1['vencimiento2'],8,2);
		$mesquevence = substr($row1['vencimiento2'],5,2);
		$agnoquevence = substr($row1['vencimiento2'],0,4);
		if (($diaquevence-1) == 0) {
			$diaquevence = $diaquevence=(gregoriantojd($mesquevence,1,$agnoactual)-gregoriantojd($mesquevence-1,1,$agnoactual))+1;
			$mesquevence--;
		}
		$diaquevence = ($diaquevence-1);
		$diaquevence = agceros($diaquevence,2);
		$mesquevence = agceros($mesquevence,2);
		$fechaquevence = $diaquevence."/".$mesquevence."/".$agnoquevence;
	}elseif (gregoriantojd($mesactual,$diaactual,$agnoactual)<gregoriantojd(substr($row1['vencimiento3'],5,2),substr($row1['vencimiento3'],8,2),substr($row1['vencimiento3'],0,4))) {
    //}elseif ($fechaactual*1<$row1['fechavenc2']*1) {
    	//Antes del 3er vencimiento
		$precioarray = explode(',',$row1['precio3']);
		$precio2dovarray = explode(',',$row1['precio3']);
		$diasparav = gregoriantojd(substr($row1['vencimiento3'],5,2),substr($row1['vencimiento3'],8,2),substr($row1['vencimiento3'],0,4))-gregoriantojd(1,1,$agnoactual);
		$diasparav++;
		$desdeel1ervh2do = 00;
		$diaquevence = substr($row1['vencimiento3'],8,2);
		$mesquevence = substr($row1['vencimiento3'],5,2);
		$agnoquevence = substr($row1['vencimiento3'],0,4);
		if (($diaquevence-1) == 0) {
			$diaquevence=$diaquevence=(gregoriantojd($mesquevence,1,$agnoactual)-gregoriantojd($mesquevence-1,1,$agnoactual))+1;
			$mesquevence--;
		}
		$diaquevence   = ($diaquevence-1);
		$diaquevence   = agceros($diaquevence,2);
		$mesquevence   = agceros($mesquevence,2);
		$fechaquevence = $diaquevence."/".$mesquevence."/".$agnoquevence;
	} else {
		$fechaquevence="Inscripción Cerrada";
		$inscripcioncerrada=true;
	}
	$desdeel1ervh2do = agceros($desdeel1ervh2do,2);
	$diasparav = agceros($diasparav,3);
	//
	$montopesos = $precioarray[0];

	$montopesos = agceros($montopesos,6);
	$montocenta = $precioarray[1];
	$montocenta = agceros($montocenta,2);

	//
	$montoven1 = $precio2dovarray[0]-$precioarray[0];
	$montoven1 = agceros($montoven1,4);
	$montoven1cent = $precio2dovarray[1]-$precioarray[1];
	$montoven1cent = agceros($montoven1cent,2);
	//
    $result2 = mysql_query('SELECT * FROM '.pftables.'eventos WHERE codigo="'.$_GET['evento'].'" LIMIT 1 ');
    $row2 = mysql_fetch_array($result2);

	$empresa = $row2['empresa'];
	$idevento = $row2['codigo'];
    $nombreevento = $row2['nombre'];
	$idevento = agceros($idevento,4);

	$result3 = mysql_query('SELECT * FROM '.pftables.'descuentos WHERE codevento='.$_GET['evento'].' AND coddni='.$usuario.' LIMIT 1 ');
	$row3 = mysql_fetch_array($result3);
	if (($_GET['codigodedescuento']!='')&&(mysql_num_rows($result3)!=0)&&($_GET['codigodedescuento']==$_GET['evento'].agceros($usuario,8).agceros($row3['porcentajedescuento'],3))) {
		$montopesos = $montopesos-(($montopesos*$row3['porcentajedescuento'])/100);
		$montocenta = ($montopesos-floor($montopesos))*100;
		$montopesos = floor($montopesos);
		mysql_query('UPDATE '.pftables.'descuentos SET fechausado = "'.date("d/m/Y").'" WHERE id = '.$row3['id']);
	}

	$categoria = $row1['codigo'];
	$categoria = agceros($categoria,2);

	$idcliente = $idevento.$categoria.$dniinscripto;

/*
	$barcode1[0]="1";
	$barcode2[0]="1";
	$barcode3[0]="2";
	$barcode4[0]="2";
	$barcode5[0]="1";

	$barcode1[1]="2";
	$barcode2[1]="1";
	$barcode3[1]="1";
	$barcode4[1]="1";
	$barcode5[1]="2";

	$barcode1[2]="1";
	$barcode2[2]="2";
	$barcode3[2]="1";
	$barcode4[2]="1";
	$barcode5[2]="2";

	$barcode1[3]="2";
	$barcode2[3]="2";
	$barcode3[3]="1";
	$barcode4[3]="1";
	$barcode5[3]="1";

	$barcode1[4]="1";
	$barcode2[4]="1";
	$barcode3[4]="2";
	$barcode4[4]="1";
	$barcode5[4]="2";

	$barcode1[5]="2";
	$barcode2[5]="1";
	$barcode3[5]="2";
	$barcode4[5]="1";
	$barcode5[5]="1";

	$barcode1[6]="1";
	$barcode2[6]="2";
	$barcode3[6]="2";
	$barcode4[6]="1";
	$barcode5[6]="1";

	$barcode1[7]="1";
	$barcode2[7]="1";
	$barcode3[7]="1";
	$barcode4[7]="2";
	$barcode5[7]="2";

	$barcode1[8]="2";
	$barcode2[8]="1";
	$barcode3[8]="1";
	$barcode4[8]="2";
	$barcode5[8]="1";

	$barcode1[9]="1";
	$barcode2[9]="2";
	$barcode3[9]="1";
	$barcode4[9]="2";
	$barcode5[9]="1";
*/

  $barcode1 = array(1, 2, 1, 2, 1, 2, 1, 1, 2, 1);
  $barcode2 = array(1, 1, 2, 2, 1, 1, 2, 1, 1, 2);
  $barcode3 = array(2, 1, 1, 1, 2, 2, 2, 1, 1, 1);
  $barcode4 = array(2, 1, 1, 1, 1, 1, 1, 2, 2, 2);
  $barcode5 = array(1, 2, 2, 1, 2, 1, 1, 2, 1, 1);

	$z=0;
	// 4: nro fijo que identifica a la empresa
	$a[$z] = "0"; $z++;
	$a[$z] = "2"; $z++;
	$a[$z] = "4"; $z++;
	$a[$z] = "6"; $z++;
	$spa[$z] = " ";
	// 6: monto enteros
	$a[$z] = substr($montopesos,0,1);$z++;
	$a[$z] = substr($montopesos,1,1);$z++;
	$a[$z] = substr($montopesos,2,1);$z++;
	$a[$z] = substr($montopesos,3,1);$z++;
	$a[$z] = substr($montopesos,4,1);$z++;
	$a[$z] = substr($montopesos,5,1);$z++;
	$spa[$z] = " ";
	// 2: monto decimales
	$a[$z] = substr($montocenta,0,1);$z++;
	$a[$z] = substr($montocenta,1,1);$z++;
	$spa[$z] = " ";
	// fecha primer vencimiento AAJJJ (JJJ son la cantidad de dias desde el 1 de enero del ao corriente
	$a[$z] = substr($agnoactual,2,1);$z++;
	$a[$z] = substr($agnoactual,3,1);$z++;
	$a[$z] = substr($diasparav,0,1);$z++;
	$a[$z] = substr($diasparav,1,1);$z++;
	$a[$z] = substr($diasparav,2,1);$z++;
	$spa[$z]=" ";
	// id del cliente (DNI?) 15 cifras o 14 ???
	$a[$z] = substr($idcliente,0,1);$z++;
	$a[$z] = substr($idcliente,1,1);$z++;
	$a[$z] = substr($idcliente,2,1);$z++;
	$a[$z] = substr($idcliente,3,1);$z++;
	$a[$z] = substr($idcliente,4,1);$z++;
	$a[$z] = substr($idcliente,5,1);$z++;
	$a[$z] = substr($idcliente,6,1);$z++;
	$a[$z] = substr($idcliente,7,1);$z++;
	$a[$z] = substr($idcliente,8,1);$z++;
	$a[$z] = substr($idcliente,9,1);$z++;
	$a[$z] = substr($idcliente,10,1);$z++;
	$a[$z] = substr($idcliente,11,1);$z++;
	$a[$z] = substr($idcliente,12,1);$z++;
	$a[$z] = substr($idcliente,13,1);$z++;
	$spa[$z] = " ";
	// tipo de moneda (0 si es en pesos)
	$a[$z] = "0";$z++;
	$spa[$z] = " ";
	// monto segundo vencimiento (no:=al 1ero / TODOS CERO)
	// monto enteros
	$a[$z] = substr($montoven1,0,1);$z++;
	$a[$z] = substr($montoven1,1,1);$z++;
	$a[$z] = substr($montoven1,2,1);$z++;
	$a[$z] = substr($montoven1,3,1);$z++;
	//$a[$z] = "0";$z++;
	//$a[$z] = "0";$z++;
	$spa[$z] = " ";
	// monto decimales
	//$a[$z] = substr($montocenta,0,1);$z++;
	//$a[$z] = substr($montocenta,1,1);$z++;
	$a[$z] = substr($montoven1cent,0,1);$z++;
	$a[$z] = substr($montoven1cent,1,1);$z++;
	$spa[$z] = " ";
	// fecha segundo vencimiento (no:=al 1ero / CANT DE DIAS DESDE EL 1ERO)
	//$a[$z] = substr($agnoactual,2,1);$z++;
	//$a[$z] = substr($agnoactual,3,1);$z++;
	//$a[$z] = substr($diasparav,0,1);$z++;
	//$a[$z] = substr($diasparav,1,1);$z++;
	//$a[$z] = substr($diasparav,2,1);$z++;
	//$a[$z] = "0"; $z++;
	//$a[$z] = "0"; $z++;
	$a[$z] = substr($desdeel1ervh2do,0,1);$z++;
	$a[$z] = substr($desdeel1ervh2do,1,1);$z++;
	$spa[$z] = " ";
    $secuencia = array();
	$secuencia[0] = 9;
	$secuencia[1] = 3;
	$secuencia[2] = 5;
	$secuencia[3] = 7;
	// digito verificador 1
	$verif = 0;
	for($i = 1; $i <= count($a); $i++)
		$verif += $a[$i]*$secuencia[$i%4];

	$verif = $verif/2;
	$verif = intval($verif)%10;
	$a[$z] = $verif;
	$z++;
	// digito verificador 2
	$verif = 0;
	for($i = 1; $i <= count($a); $i++)
		$verif += $a[$i]*$secuencia[$i%4];

	$verif = $verif/2;
	$verif = intval($verif)%10;
	$a[$z] = $verif;
	$z++;
}
if ($nombreevento == "") die("evento no disponible");
$yaseinscribio = false;
$result1 = mysql_query('SELECT id FROM '.pftables.'inscripciones WHERE((deusuario="'.$dniinscripto.'")AND(deevento="'.$_GET['evento'].'")AND(categoria="'.$_GET['cat'].'")AND(codigo="'.$idevento.$categoria.$edadcomputable.$dniinscripto.'")) LIMIT 1 ');
while ($row1 = mysql_fetch_array($result1)) $yaseinscribio=true;
if (!($yaseinscribio)) {
    mysql_query('INSERT INTO `'.pftables.'inscripciones` (`id`) VALUES (NULL);');
    $result1 = mysql_query('SELECT id FROM '.pftables.'inscripciones ORDER BY id DESC LIMIT 1 ');
    $row1 = mysql_fetch_array($result1);
    $idActual = $row1[id];
	mysql_query('UPDATE '.pftables.'inscripciones SET deusuario = "'.$dniinscripto.'" WHERE id = '.$idActual);
	mysql_query('UPDATE '.pftables.'inscripciones SET empresa = "'.$empresa.'" WHERE id = '.$idActual);
	mysql_query('UPDATE '.pftables.'inscripciones SET deevento = "'.$_GET['evento'].'" WHERE id = '.$idActual);
	mysql_query('UPDATE '.pftables.'inscripciones SET categoria = "'.$_GET['cat'].'" WHERE id = '.$idActual);
    mysql_query('UPDATE '.pftables.'inscripciones SET opcion = "'.$_GET['opcion'].'" WHERE id = '.$idActual);
	mysql_query('UPDATE '.pftables.'inscripciones SET codigo = "'.$idevento.$categoria.$edadcomputable.$dniinscripto.'" WHERE id = '.$idActual);
	mysql_query('UPDATE '.pftables.'inscripciones SET iniciadoeldia = "'.date("Y-m-d").'" WHERE id = '.$idActual);
	mysql_query('UPDATE '.pftables.'inscripciones SET venceeldia = "'.date("Ymd",(mktime(1,1,1,date("m"),date("d"),date("Y"))+60*60*24*7)).'" WHERE id = '.$idActual);
	mysql_query('UPDATE '.pftables.'opciones SET cuporestante = cuporestante-1 WHERE nombre = "'.$_GET['opcion'].'" AND (evento = "'.$_GET['evento'].'" OR evento = "'.($_GET['evento']*1).'") ');
}
$fechaacmbformto = JDToGregorian(($diasparav+gregoriantojd(1,1,$agnoactual))+$desdeel1ervh2do);
$fechaacmbformto = split('/',$fechaacmbformto);

$cantdias = array("", 31, 29, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);

$messdov = ($fechaacmbformto[0]*1);
$undiaantes = ($fechaacmbformto[1]*1)-2;
if ($undiaantes < 0) {
    $undiaantes = $cantdias[($messdov-1)];
    $messdov--;
}

if ((!($inscripcioncerrada)) || ($_GET['reimpr']!="")) {
    include_once 'mailinscripto.php';
    //mail($maildelusuario,"Inscripcion reservada",$msg,"From: Inscribite Online <consultas@inscribiteonline.com.ar>\r\nContent-Type: text/html;charset=utf-8\r\n");

    if ($_GET['modinscr']!="") { 
	    $result1 = mysql_query('SELECT pagado,pagoeldia,precio FROM '.pftables.'inscripciones WHERE id='.$modinscr.' LIMIT 1 ');
	    $row1 = mysql_fetch_array($result1);
	    mysql_query('UPDATE '.pftables.'inscripciones SET pagado = "'.$row1['pagado'].'" WHERE id = '.$idActual);
	    mysql_query('UPDATE '.pftables.'inscripciones SET pagoeldia = "'.$row1['pagoeldia'].'" WHERE id = '.$idActual);
	    mysql_query('UPDATE '.pftables.'inscripciones SET precio = "'.$row1['precio'].'" WHERE id = '.$idActual);

	    mysql_query('DELETE FROM `'.pftables.'inscripciones` WHERE `id` = '.$modinscr.' LIMIT 1');

	    if ($row1['pagado'] == 1) die('<script type="text/javascript">location.href="'.url.'usuario";</script>');
    }
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Inscribite online</title>
    <style type="text/css">
    <!--
    body{
    	font-family:Arial;
    	font-size:10px;
    	/*border:0px;
    	margin:0px;
    	padding:0px;*/
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
    	float:left;
    }
    a img{
    	border:0px;
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
    	font-family:Arial;
    	font-size:10px;
        border-collapse:collapse;
        border:none;
    }
    td{
        border:none;
    }
    .Estilo1{font-size:12px}
    .Estilo2{
    	font-size:12px;
    	font-weight:bold;
    	color:#FF6600;
    }
    .Estilo3{font-size:10px;}
    .Estilo4{
    	color:#EB177D;
    	font-weight:bold;
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
    -->
    </style>
  </head>
  <body>
                <div id=factura align="center">
                    <table width="630" align="center" cellspacing="0">
                      <tr>
                        <td height="98" colspan="2">
                          <div align="center" style="font-size:11.0pt;font-family:Verdana;color:#FF6600;font-weight:bold">
                            Comprobante para Pagar<br/>
                            Para el Usuario<br/>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td height="34" colspan="2">
                          <p align="center">&nbsp;
                          </p>
                        </td>
                      </tr>
                      <tr>
                        <td width="512" height="70">
                          <img src="webimages/pago_facil.jpg" alt="logo_pagofacil" width="275" height="56"/>
                        </td>
                        <td width="164">
                          <div align="center">
                            <img src="webimages/'.pftables.'fac.jpg" alt="d" width="164" height="70" align="middle"/>
                            <br/>
                            <br/>
                            <br/>
                            <br/>
                            <br/>
                            "Un producto de Mar&iacute;timo SRL"
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td colspan="2"><div align="center" class="Estilo2">Datos de la operaci&oacute;n </div></td>
                      </tr>
                      <tr>
                        <td height="123" colspan="2"><table width="420" align="center" cellspacing="0">
                      </tr>
                      <tr>
                        <td width="213" bgcolor="#FFCC00" class="Estilo1"><strong>Evento:</strong></td>
                        <td width="207" bgcolor="#FFCC00" class="Estilo1"><span class="Estilo1" style="background:#FFCC66;"><?=$nombreevento?></span></td>
                      </tr>
                      <tr>
                        <td bgcolor="#FFEDA6" class="Estilo1"><strong>Id. Inscripto </strong></td>
                        <td bgcolor="#FFEDA6" class="Estilo1"><span class="Estilo1" style="background:#FFFFCC;"><?=$idcliente?></span></td>
                      </tr>
                      <tr>
                        <td bgcolor="#FFCC00" class="Estilo1"><strong>Participante: </strong></td>
                        <td bgcolor="#FFCC00" class="Estilo1"><span class="Estilo1" style="background:#FFCE63;"><?=$nombredelusuario.' '.$apellidodelusuario?></span></td>
                      </tr>
                      <tr>
                        <td bgcolor="#FFEDA6" class="Estilo1"><strong>Importe hasta el primer vencimiento</strong></td>
                        <td bgcolor="#FFEDA6" class="Estilo1"><span class="Estilo1" style="background:#FFFFCC;"><?=intval($montopesos)?>.00</span></td>
                      </tr>
                      <tr>
                        <td bgcolor="#FFCC00" class="Estilo1"><strong>Moneda</strong></td>
                        <td bgcolor="#FFCC00" class="Estilo1"><span class="Estilo1" style="background:#FFCC66;">PESOS</span></td>
                      </tr>
                      <tr>
                        <td bgcolor="#FFEDA6" class="Estilo1"><strong>Fecha de emisi&oacute;n </strong></td>
                        <td bgcolor="#FFEDA6" class="Estilo1"><span class="Estilo1" style="background:#FFFFCC;">(<?=$diaactual."/".$mesactual."/".$agnoactual?>)</span></td>
                      </tr>
                      <tr>
                        <td bgcolor="#FFCC00" class="Estilo1"><strong>Primer Vencimiento</strong></td>
                        <td bgcolor="#FFCC00" class="Estilo1">(<?=$fechaquevence?>)</td>
                      </tr>
                      <tr>
                        <td bgcolor="#FFEDA6" class="Estilo1"><strong>Segundo Vencimiento</strong></td>
                        <td bgcolor="#FFEDA6" class="Estilo1"><span class="Estilo1" style="background:#FFFFCC;">(<?=$undiaantes.'/'.substr("0".$messdov,-2,2).'/'.$fechaacmbformto[2]?>)</span></td>
                      </tr>
                      <tr>
                        <td bgcolor="#FFCC00" class="Estilo1"><strong>Recargo</strong></td>
                        <td bgcolor="#FFCC00" class="Estilo1"><span class="Estilo1" style="background:#FFFFCC;"><?=($montoven1+0).','.$montoven1cent?></td>
                      </tr>
                      <tr>
                        <td bgcolor="#FFEDA6" class="Estilo1"><strong>C&oacute;digo de barras </strong>
                        </td>
                        <td bgcolor="#FFEDA6" class="Estilo1">
                          <span style="font-size:8.0pt;font-family:Verdana;color:#003399">
  <? for($i=0;$i<count($a);$i++)echo$spa[$i].$a[$i]?>
                          </span>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <tr>
                  <td colspan="2"><div align="center" class="Estilo4"></div></td>
                </tr>
                <tr>
                  <td colspan="2" class="Estilo1">
                    <div>
                      <div align="left"><span class="Estilo4">IMPORTANTE:</span><br/></div>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td colspan="2" class="Estilo1"><div align="center" class="Estilo3">
                    <div align="left">
                      <p>Usted recibir&aacute;un mail a la direcci&oacute;n ingresada con el detalle de esta operaci&oacute;n y copia del presente comprobante<br/>
                        Busque su Pago F&aacute;cil m&aacute;s cercano en e-pagofacil.com y conozca nuestro nuevo servicio de agenda.<br/>
                        Para montos superiores a $1000 dirigirse &uacute;nicamente a Centros exclusivos Pago Facil;Suc. Correo Arg. adheridas. Si el presente recibo fue abonado dentro de las 48 horas previas al evento, el mismo deber&aacute;ser validado en la administraci&oacute;n de la organizaci&oacute;n, previo a la participaci&oacute;n en el mismo.
                      </p>
                      <p><strong class="Estilo4">Deslinde de responsabilidades:</strong><br/>
                        Manifiesto y declaro bajo juramento que me encuentro en perfectas condiciones de salud para competir en la prueba <?=$nombreevento?>. Por la presente y en mi propio nombre y de mis herederos, albacea y cesionarios RENUNCIO A LA INDEMNIZACION POR DA&Ntilde;OS Y/O PERJUICIOS y LIBERO PARA SIEMPRE DE TODA RESPONSABILIDAD a <?=$empresa?> y a cada una de las empresas y marcas auspiciantes, que participen de alguna manera conectada con la competencia <?=$nombreevento?>, en la cual habr&eacute;de participar, respecto a toda acci&oacute;n, reclamo, demanda que haya hecho, que intente actualmente hacer o que en el futuro pueda hacer , debido a &oacute;por motivos de haberme inscripto y/&oacute;participado en esta competencia deportiva, o por cualquier p&eacute;rdida de equipo o efectos personales antes, durante y despu&eacute;s del desarrollo de la misma.<br/>
                        <br/>
                        Es indispensable la presentaci&oacute;n de este cup&oacute;n debidamente impreso el registro de pago en cajeros o centros de Pago F&aacute;cil antes del inicio del evento seg&uacute;n requisito de la empresa o instituci&oacute;n organizadora.

                        <div><?=$row2['textoencupon']?></div>
                      </p>
                    </div>
                  </div>
                </td>
              </tr>
              <tr>
                <td colspan="2" class="Estilo1"><table width="672" height="56" cellspacing="0">
                  <tr>
                    <td width="354" height="56" align="center" valign="bottom">
                      <table width="200" cellspacing="0">
                        <tr>
                          <td>_________________________________</td>
                        </tr>
                        <tr>
                          <td>
                            <div align="center">
                              Firma
                            </div>
                          </td>
                        </tr>
                      </table>
                    </td>
                    <td width="318" align="center" valign="bottom">
                      <table width="200" align="center" cellspacing="0">
                        <tr>
                          <td>_________________________________</td>
                        </tr>
                        <tr>
                          <td>
                            <div align="center">
                              Aclaracion
                            </div>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
            <tr>
              <td colspan="2" class="Estilo1">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="2" class="Estilo1">
                <img src="webimages/tijera.gif" width="676" height="31" alt=".................................................."/>
              </td>
            </tr>
            <tr>
              <td height="38" colspan="2" class="Estilo1">
                <div align="center" style="font-size:11.0pt;font-family:Verdana;color:#FF6600;font-weight:bold;">
                  Para el agente<br/><br/>
                </div>
              </td>
            </tr>
<tr>
                      <td>
                        <img src="webimages/negro.gif" alt="" hspace="0"/>
                        <img src="webimages/blanco.gif" alt="" hspace="0"/>
                        <img src="webimages/negro.gif" alt="" hspace="0"/>
                        <img src="webimages/blanco.gif" alt="" hspace="0"/>
<?
    $b=array();
	for($i=0;$i<count($a);$i++) {
      if ($a[$i]!=' ')array_push($b,$a[$i]);
    }
	for($i=0;$i<count($b);$i+=2) {
		if ($i<=count($b)) {
            for($n=0;$n<$barcode1[$b[$i]];$n++)  echo'           <img src="webimages/negro.gif"  alt="" hspace="0"/>'.chr(13);
			for($n=0;$n<$barcode1[$b[$i+1]];$n++)echo'           <img src="webimages/blanco.gif" alt="" hspace="0"/>'.chr(13);
			for($n=0;$n<$barcode2[$b[$i]];$n++)  echo'           <img src="webimages/negro.gif"  alt="" hspace="0"/>'.chr(13);
			for($n=0;$n<$barcode2[$b[$i+1]];$n++)echo'           <img src="webimages/blanco.gif" alt="" hspace="0"/>'.chr(13);
			for($n=0;$n<$barcode3[$b[$i]];$n++)  echo'           <img src="webimages/negro.gif"  alt="" hspace="0"/>'.chr(13);
			for($n=0;$n<$barcode3[$b[$i+1]];$n++)echo'           <img src="webimages/blanco.gif" alt="" hspace="0"/>'.chr(13);
			for($n=0;$n<$barcode4[$b[$i]];$n++)  echo'           <img src="webimages/negro.gif"  alt="" hspace="0"/>'.chr(13);
			for($n=0;$n<$barcode4[$b[$i+1]];$n++)echo'           <img src="webimages/blanco.gif" alt="" hspace="0"/>'.chr(13);
			for($n=0;$n<$barcode5[$b[$i]];$n++)  echo'           <img src="webimages/negro.gif"  alt="" hspace="0"/>'.chr(13);
			for($n=0;$n<$barcode5[$b[$i+1]];$n++)echo'           <img src="webimages/blanco.gif" alt="" hspace="0"/>'.chr(13);
		}
	}
?>
                        <img src="webimages/negro.gif" alt="" hspace="0"/>
                        <img src="webimages/negro.gif" alt="" hspace="0"/>
                        <img src="webimages/blanco.gif" alt="" hspace="0"/>
                        <img src="webimages/negro.gif" alt="" hspace="0"/>
                      </td>
                    </tr>
                    <tr>
                      <td align="center">
           <?=implode($b).chr(13)?>
                      </td>
                    </tr>
                  </table>
                </div>
              <p>&nbsp;</p>
            </td>
          </tr>
          <tr>
            <td colspan="2" class="Estilo1"></td>
          </tr>
          <tr>
            <td colspan="2" class="Estilo1"><div align="center">Por favor, imprima esta p&aacute;gina y dir&iacute;jase al Pago F&aacute;cil m&aacute;s cercano para realizar su pago.</div></td>
          </tr>
          <tr>
            <td colspan="2" class="Estilo1">
              <div align="center">
              </div>
            </td>
          </tr>
          <tr>
            <td colspan="2" class="Estilo1"><div align="center">
              <table cellspacing="0" width="150" style='width:112.5pt'>
                <tr>
                  <td>
                    <p>
                      <a href="javascript:self.print()"><strong>
                          <span style='font-size:7.0pt;font-family:Verdana;color:#CC0099;text-decoration:none;'>
                            <img src="webimages/image004.gif" alt="cerrar" width="20" height="20"/>
                          </span>
                        </strong>
                      </a>
                    </p>
                  </td>
                  <td>
                    <p>
                      <a href="javascript:self.print()"><strong>Imprimir</strong></a>
                    </p>
                  </td>
                  <td>
                    <p>
                      <a href="<?=url?>">
                        <strong>
                            <img src="webimages/image004.gif" alt="imprimir" width="20" height="20"/>
                        </strong>
                      </a>
                    </p>
                  </td>
                  <td>
                    <p>
                      <a href="<?=url?>">
                        <span style='font-size:7.0pt;font-family:Verdana;color:#CC0099;font-weight:bold;'>Cerrar</span>
                      </a>
                    </p>
                  </td>
                </tr>
              </table>
            </div>
          </td>
        </tr>
      </table>
    </div>
<script src="http://www.google-analytics.com/urchin.js" type="text/javascript"></script>
<script type="text/javascript">
<!--
  _uacct="UA-1091133-1";
  urchinTracker();
  // <?='123 '.$errorpvver?>
-->
</script>

  </body>
</html><?
	if (is_resource($result1)) mysql_free_result($result1);
	if (is_resource($result2)) mysql_free_result($result2);
	if (is_resource($result3)) mysql_free_result($result3);
	mysql_close();
} else {
	include_once 'insccerrada.php';
} ?>