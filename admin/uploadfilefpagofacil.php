<?
$evento = array();
$marcadospagados = array();
$nroarev = 0;
function agceros($nombreag, $cantceros) {
	while (strlen($nombreag) < $cantceros) $nombreag = "0".$nombreag;
	return $nombreag;
}
include_once "../inc.config.php";

$listamails = Array();
$listaids   = Array();
$listacods  = Array();

//mysql_query("DELETE FROM inscribite_inscripciones WHERE pagado = 0 AND venceeldia!= 0 AND venceeldia<".date("Ymd"));

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<style type="text/css">
	<!--
	body{
		font-family:Arial, Helvetica, sans-serif;
		font-size:12px;
		background-repeat:no-repeat;
		background-position:right top;
		background-attachment:fixed;
	}
	table{
		font-family:Arial, Helvetica, sans-serif;
		font-size:12px;
		margin-top:10px;
		margin-bottom:10px;
		display:block;
	}
	tr{
		border:1px black solid;
	}
	td{
		border:1px #DDD solid;
	}
	.textoidcliente{
		color:#AAA;
	}
	.nombredato{
		color:#999;
	}
	a{
		color:blue;
		text-decoration:none;
	}
	a:hover{
		text-decoration:underline;
	}
	-->
	</style>
</head>
<body>
<? $nrodconfml = 0;
$directorio = 'filepfacil/';
$newnombre = $_FILES['archivo_usuario']['name'];
if (move_uploaded_file($_FILES['archivo_usuario']['tmp_name'], $directorio.$_FILES['archivo_usuario']['name'])) {
	$archivo = $directorio.$newnombre;
	$fp = fopen($archivo,'r');
	if (filesize($archivo) > 0)
		$conte = fread($fp, filesize($archivo));
	fclose($fp);
	$correccion = 0; ?>
	<div>
<? 		/*Record Code:<br/>
		echo substr($conte,0,1)?><br/> */ ?>
		<span class="nombredato">Fecha:</span><br/>
		<?=substr($conte, 7, 2).'/'.substr($conte,5,2).'/'.substr($conte,1,4)?><br/>
		<span class="nombredato">Origin Name:</span><br/>
		<?=substr($conte, 9, 25)?><br/>
		<span class="nombredato">ID Empresa:</span><br/>
		<?=substr($conte, 34, 9)?><br/>
		<span class="nombredato">Empresa</span>:<br/>
		<?=substr($conte, 43, 15)?><br/><br/>
<? //echo substr($conte,78,50);
 		/*Record Code:<br/>
		<?=substr($conte,130,1)?><br/> */ ?>
		<span class="nombredato">Fecha:</span><br/>
<? // algunos archivos vienen con un caracter corrido, si la fecha no es correcta se hace una correccion de -1
if ((substr($conte, 137, 2) > 31) || (substr($conte, 135+$correccion, 2) > 12) || (substr($conte, 131+$correccion, 4) < 1990))
	$correccion = -1?>
		<?=substr($conte, 137+$correccion, 2).'/'.substr($conte, 135+$correccion, 2).'/'.substr($conte, 131+$correccion, 4)?><br/>
		<span class="nombredato">Lote:</span><br/>
		<?=substr($conte, 139+$correccion, 6)?><br/>
		<span class="nombredato">Empresa:</span><br/>
		<?=substr($conte, 145+$correccion, 15).chr(13); /* = substr($conte,180,78) */ ?>
	</div>
	<br/>
	<table style="border:1px black solid; margin-top:0px; float:left; width:100%;">
		<tr>
<? /* 		<td>Record Code:</td> */ ?>
			<td>Nro.</td>
<? /*		<td>Código de Transacción:</td>
			<td>Fecha de proceso:</td> */ ?>
			<td>Fecha de creación:</td>
			<td>Usuario:</td>
			<td>Evento:</td>
			<td>Categ.:</td>
			<td>&nbsp;</td>
			<td>Monto:</td>
			<td>Terminal</td>
			<td>Fecha:</td>
			<td>Hora:</td>
			<td>&nbsp;</td>
<? /*		<td><? // Número de secuencia en terminal: ?></td>
<td><? // Código de barras: ?></td>
<td><? // Moneda: ?></td>
<td><? // Efectivo o Cheque ?></td>
<? */ ?>
		</tr>
<?	if ($correccion == -1)
		$correccion = -2;

$posant = 260+$correccion;
//echo substr($conte, $posant,1);
//while ((substr($conte, $posant,1) == 5)||(substr($conte, $posant-3,1) == 5)) {
while (substr($conte, $posant, 1) == 5) {
	//while (2 == 5) {
	//echo substr($conte, $posant,1);
	$result1 = mysql_query('SELECT * FROM inscribite_usuarios WHERE dni = "'.trim((substr($conte, $posant+30,15)+0)).'" LIMIT 1 ');
	$row1 = mysql_fetch_array($result1);
?>
		<tr class="cadaoperacion">
<? 			/*<td><?=substr($conte, $posant,1)?></td> */ ?>
			<td><?=(substr($conte, $posant+1, 5)+0)?></td>
<? /*		<td><? // echo substr($conte, $posant+6,2) ?></td>
			<td><? // echo substr($conte, $posant+14,2)?>/<?=substr($conte, $posant+12,2)?>/<?=substr($conte, $posant+8,4); ?></td>*/ ?>
			<td><?=substr($conte, $posant+22, 2).'/'.substr($conte, $posant+20, 2).'/'.substr($conte, $posant+16, 4); $eldni = (substr($conte, $posant+30, 15)+0);?></td>
			<td><a href="usuarios?busqueda=<?=$eldni?>" style="margin-right:5px;"><?=$eldni?></a><?
//echo substr($conte, $posant+24,20);
echo $row1['apellido'].", ".$row1['nombre'];

$fechvencenjul = substr($conte, $posant+143, 5);
$primeros4cod  = substr($conte, $posant+24, 4);
$cateencod     = substr($conte, $posant+28, 2);
$elcodigoes    = $primeros4cod.$cateencod.agceros($eldni, 8);

$dejulianaagreg = JDToGregorian(gregoriantojd(1, 1, (2000+substr($fechvencenjul, 0 , 2)*1))+substr($fechvencenjul, 2, 3));
// formato 8/25/2009
$arrayfechgreg = Array();
$arrayfechgreg = split('/', $dejulianaagreg);
$diavenc = $arrayfechgreg[2].agceros($arrayfechgreg[0], 2).agceros($arrayfechgreg[1], 2);

  //$result2 = mysql_query('SELECT id, deevento, selemandomail, venceeldia, cargopuntos FROM inscribite_inscripciones WHERE codigo = "'.$elcodigoes.'" AND ((venceeldia < '.($diavenc+5).' AND venceeldia > '.($diavenc-5).') OR venceeldia = "0") LIMIT 1 ');
  $result2 = mysql_query('SELECT id, deevento, selemandomail, venceeldia, cargopuntos FROM inscribite_inscripciones WHERE codigo = "'.$elcodigoes.'" ORDER BY id DESC LIMIT 1 ');
  if ($row2 = mysql_fetch_array($result2)) {
    $iddeinscr = $row2['id'];
    $selemandomail = $row2['selemandomail'];
    $cargopuntos = $row2['cargopuntos'];
  }

  $result3 = mysql_query('SELECT nombre, tipo FROM inscribite_eventos WHERE codigo = "'.$primeros4cod.'" LIMIT 1 ');
  $row3 = mysql_fetch_array($result3);
  $nombreevento = $row3['nombre'];
  if ($row3['tipo'] == 'Capacitación') $selemandomail = 0;
  if ($row3['tipo'] == 'Servicios')    $selemandomail = 0;

  if (mysql_num_rows($result2) == 0) {
    $result3 = mysql_query('SELECT nombre, empresa FROM inscribite_eventos WHERE codigo = "'.$primeros4cod.'" LIMIT 1 ');
    $row3 = mysql_fetch_array($result3);
    $empresa = $row3['empresa'];
    $nombreevento = $row3['nombre'];

    $result3 = mysql_query('SELECT opcion FROM inscribite_categorias WHERE deevento = "'.$primeros4cod.'" AND codigo = "'.$cateencod.'" LIMIT 1 ');
    $row3 = mysql_fetch_array($result3);
    mysql_query("INSERT INTO inscribite_inscripciones ( `id`, `deusuario`, `empresa`, `deevento`, `categoria`, `opcion`, `codigo`) VALUES ( '', '".agceros((substr($conte, $posant+30,15)+0),8)."', '".$empresa."', '".$primeros4cod."', '".$cateencod."', '".$row3['opcion']."', '".$elcodigoes."');");
    $result2 = mysql_query('SELECT * FROM inscribite_inscripciones ORDER BY id DESC LIMIT 1 ');
    $row2 = mysql_fetch_array($result2);
    $iddeinscr = $row2['id'];
    echo ' (agregado)';
  }

$precioenteros = substr($conte, $posant+48, 8)*1;

$fechadpagodia     = substr($conte, $posant+70, 2);
$fechadpagomes     = substr($conte, $posant+68, 2);
$fechadpagoanio    = substr($conte, $posant+64, 4);
$fechadpagohora    = substr($conte, $posant+72, 2);
$fechadpagominutos = substr($conte, $posant+74, 2);

mysql_query('UPDATE inscribite_inscripciones SET pagado = 1 WHERE id = '.$iddeinscr.' ');
mysql_query('UPDATE inscribite_inscripciones SET pagoeldia = "'.$fechadpagoanio."-".$fechadpagomes."-".$fechadpagodia.' '.$fechadpagohora.':'.$fechadpagominutos.':00" WHERE id = '.$iddeinscr.' ');
mysql_query('UPDATE inscribite_inscripciones SET precio = "'.$precioenteros.', '.substr($conte, 316, 2).'" WHERE id = '.$iddeinscr.' ');

if ($cargopuntos != 1) {
  $result3 = mysql_query('SELECT puntos FROM inscribite_eventos WHERE codigo = "'.$primeros4cod.'" LIMIT 1 ');
  $row3 = mysql_fetch_array($result3);
  $puntosqcarga = $row3['puntos'];
  mysql_query("UPDATE inscribite_usuarios SET puntos = puntos+".$puntosqcarga." WHERE dni = '".(substr($conte, $posant+30,15)+0)."' OR dni = '".agceros((substr($conte, $posant+30,15)+0),8)."' ");
  mysql_query('UPDATE inscribite_inscripciones SET cargopuntos = 0 WHERE id = '.$iddeinscr.' ');
}
?></td>
			<td><?/*  = $nombreevento.' '.$primeros4cod */ ?><?=$primeros4cod?></td>
			<td><? $evento[$nroarev] = $primeros4cod; $nroarev++; echo $cateencod?></td>
<? /* echo '<span class="textoidcliente">edad computada: </span>'.$cateencod." ";</td> */ ?>
			<td><?=(substr($conte, $posant+45, 3) == "PES")?"$":substr($conte, $posant+45, 3)?></td>
			<td><?=$precioenteros?>,<?=agceros((substr($conte, $posant+56, 2)+0), 2)?><? /* = substr($conte,316,2)*/ ?></td>
			<td><?=substr($conte, $posant+58,  6); // Termnal ?></td>
			<td><?=$fechadpagodia.'/'.$fechadpagomes.'/'.$fechadpagoanio?></td>
			<td><?=$fechadpagohora?>:<?=$fechadpagominutos?></td>
			<td><? if ($selemandomail != 1) {
	array_push($listamails, $row1['email']);
	array_push($listaids, 'cnfml'.$nrodconfml);
	array_push($listacods, $elcodigoes);
	?><span id="cnfml<?=$nrodconfml?>"><a href="javascript:emldusr = '<?=$row1['email']?>'; iddelcso = 'cnfml<?=$nrodconfml?>'; codamandar = '<?=$elcodigoes?>'; mandamailausr();">Enviar email</a></span><?
	} else { ?><span>Mail enviado</span><? }
	$nrodconfml++;
	//echo substr($conte, $posant+76,4); ?></td>
<? /*
            <? //echo substr($conte, $posant+78,48);
               // echo substr($conte, $posant+130,1)?> // Record Code ?>
          <td>
            <? // echo (substr($conte, $posant+131,80)) ?>
          </td>
            <? // echo substr($conte, $posant+211,46) ?>
          <? // <td>
            // <?=substr($conte, $posant+260,1)?>
          // </td>  ?>
          <td>
            <? // echo substr($conte, $posant+261,3) ?>
          </td>
          <td>
            <? // echo substr($conte, $posant+264,1) ?>
          </td>
*/ ?>
		</tr>
<? /* } */
$posant = $posant+390;
//correccion de un archivo con 3 caracteres menos
if ((substr($conte, $posant, 1) != 5) && (substr($conte, $posant-3, 1) == 5)) $posant -= 3;
}
//echo '123 '.substr($conte, $posant,10);
?>
	</table>
<?
$fechadelarchivo = '20'.substr($newnombre, 6, 2).'/'.substr($newnombre, 4, 2).'/'.substr($newnombre, 2, 2);
$result3 = mysql_query('SELECT * FROM inscribite_archivospfacil WHERE nombre = "'.$newnombre.'" LIMIT 1 ');
if (mysql_num_rows($result3) == 0) {
	mysql_query("INSERT INTO `inscribite_archivospfacil` ( `id`, `nombre`, `fecha`) VALUES ( '', '".$newnombre."', '".$fechadelarchivo."');");
}

// marcar como pagos en base de inscripciones

// Enviar email a cada inscripto <-- mejor asi no porque es spam

// Enviar mail a la empresa organizadora

/* Record Code:<br/>
<?=substr($conte, $posant,1)?><br/>
*/ ?>
<span class="nombredato">Fecha:</span><br/>
<?
// arregla fecha en algunos archivos
if (!(substr($conte, $posant+1, 4) > 2000)) $posant -= 3;

$totalentero  = (substr($conte, $posant+22, 10)+0);
$totaldecimal = substr($conte, $posant+32, 2);

echo substr($conte, $posant+7, 2).'/'.substr($conte, $posant+5, 2).'/'.substr($conte, $posant+1, 4)?>
<br/>
<span class="nombredato">Número Batch:</span><br/>
<?=substr($conte, $posant+9, 6)?><br/>
<span class="nombredato">Cantidad de transacciones del lote:</span><br/>
<?=substr($conte, $posant+15, 7)?><br/>
<span class="nombredato">Importe total cobrado del lote:</span><br/>
<?=$totalentero.', '.$totaldecimal?><br/>
<br/>
<?
  // Aca toma todos los mails de las empresas y se fija si no se repiten
  $arraydeempresas = array();
  $nrodarempr = 0;
  foreach ($evento as $value) {
    $result1 = mysql_query('SELECT * FROM inscribite_eventos WHERE codigo = "'.$value.'" LIMIT 1 ');
    while ($row1 = mysql_fetch_array($result1)) {
      $nrodarempr++;
      $arraydeempresas[$nrodarempr] = $row1['empresa'];
    }
  }
  sort($arraydeempresas);
  reset($arraydeempresas);
  $cuentamndmlempr = 0;
  foreach ($arraydeempresas as $value2) {
  	$evnorep = $value2;
  	if ($evnorep != $antevrep) {
      $result1 = mysql_query('SELECT * FROM inscribite_empresas WHERE nombre = "'.$evnorep.'" LIMIT 1 ');
      while ($row1 = mysql_fetch_array($result1)) {

$msg = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Inscribite Online</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>
<div align="center">
  <p><a href="http://www.inscribiteonline.com.ar/" target="_blank"><img src="http://www.inscribiteonline.com.ar/webimages/bannermail.jpg" width="600" height="100" border="0"></a></p>
  <table width="600" border="0" cellspacing="5" cellpadding="0">
    <tr>
      <td><p><font color="#666666" size="2" face="Verdana, Arial, Helvetica, sans-serif">Estimado '.$row1['contacto'].':</font></p>
        <p><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#666666">Pagofacil ha confirmado el pago de inscripciones, para ver los datos completos ingrese en <a href="http://www.inscribiteonline.com.ar/empresas/?empresa = '.str_replace(" ", "_", $evnorep).'">http://www.inscribiteonline.com.ar/empresas/?empresa = '.str_replace(" ", "_", $evnorep).'</a> con la contraseña: '.$row1['password'].' </font></p>

        <p><font color="#666666" size="2" face="Verdana, Arial, Helvetica, sans-serif">Saludos
          cordiales, y gracias por utilizar nuestro servicio<br/>
          Inscribite on line.</font><font color="#666666" size="2" face="Verdana, Arial, Helvetica, sans-serif"><br/>
          </font></p>
        </td>
    </tr>
  </table><br/>
  <table width="600" height="25" border="0" cellpadding="0" cellspacing="5" background="http://www.inscribiteonline.com.ar/webimages/footer.gif">
    <tr>
      <td><font color="#FFFFFF" size="1" face="Verdana, Arial, Helvetica, sans-serif">MARITIMO SRL / 4641-4423 4643-1124 / comercial@maritimopro.com.ar </font></td>
    </tr>
  </table>
  <p>&nbsp;</p>
</div>
</body>
</html>';
//mail($row1['email'], "Inscripciones confirmadas desde: Inscribite Online", $msg, "From: info@maritimopro.com.ar\r\nContent-Type: text/html; charset=utf-8\r\n");
//mail('pato@iW7zNKpRWkSHHwplBhUO.com.ar',"Inscripciones confirmadas desde: Inscribite Online", $msg,"From: Inscribite Online <info@maritimopro.com.ar>\r\nContent-Type: text/html; charset=utf-8\r\n");
  $cuentamndmlempr++; ?>
		<div id="mndmailempr<?=$cuentamndmlempr?>"><a href="#" onclick="iddelcso = this.parentNode.id; mandamailempresa('<?=$evnorep?>'); return false;">Enviar email a la empresa organizadora: <?=$evnorep?> &lt;<?=$row1['email']?>&gt;</a></div>
<?
      }
    }
    $antevrep = $value2;
  }
} else {
  print "Error al intentar subir el archivo.";
}
?>
    <br/>
<?
$result1 = mysql_query('SELECT * FROM inscribite_inscripciones WHERE pagado = 0 AND venceeldia!= 0 AND venceeldia<'.date("Ymd").' ');
//$result1 = mysql_query('SELECT * FROM inscribite_inscripciones WHERE pagado = 0 AND venceeldia!= 0 ');
if (mysql_num_rows($result1) > 0) echo 'Inscripciones vencidas a borrar: ('.mysql_num_rows($result1).')<br/>';
while ($row1 = mysql_fetch_array($result1)) {
  echo 'Usuario: '.$row1['deusuario'].' Evento: '.$row1['deevento'].' Iniciada el día: '.$row1['iniciadoeldia'].' Pagado: ';
  if ($row1['pagado'] == 1) echo 'Si'; else echo 'No';
  echo '<br/>';
}
if (mysql_num_rows($result1) > 0) echo '<a href="borrarinscripcionesvencidas.php">Confirmar</a>'.'<br/><br/>';
if (is_resource($result1)) mysql_free_result($result1);
if (is_resource($result2)) mysql_free_result($result2);
if (is_resource($result3)) mysql_free_result($result3);
mysql_close();
$segundosdeespera = 15000;
if (count($listamails) != 0) { ?>
    <a href="#" onclick="iniciarenviobulk();return false;">Enviar emails a usuarios en cadena (tiempo de envío: <?=floor((($segundosdeespera/1000)*count($listamails))/60).':'.((($segundosdeespera/1000)*count($listamails))%60)?>)</a><br/><br/>
<? } ?>
    <a href="./?sec=feedback.pagofacil">Volver</a>
<script type="text/javascript">
<!--
var http = getHTTPObject();
var estadoajax="libre";

function getHTTPObject() {
   var xmlhttp;
  /*@cc_on
  @if (@_jscript_version >= 5)
  	try {
  		xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
  	} catch (e) {
  	try {
  		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
  	} catch (E) {
  	xmlhttp = false;
  	}
  }
  @else xmlhttp = false;
  @end @*/
  if (!xmlhttp && typeof XMLHttpRequest != 'undefined') {
  		try { xmlhttp = new XMLHttpRequest();
  	} catch (e) {
  		xmlhttp = false;
  	}
  }
  return xmlhttp;
}

function handleHttpResponse() {
  if (http.readyState == 4) {
    estadoajax = 'libre';
    document.body.style.backgroundImage = 'none';
	if (document.getElementById(iddelcso))
		document.getElementById(iddelcso).innerHTML = http.responseText;
	else
		todosenviados = true;
  }
}

function mandamailempresa(nombre) {
  if (estadoajax == 'libre') {
    document.body.style.backgroundImage = 'url(images/rotating_arrow.gif)';
    estadoajax = 'laburando';
    var mandvalue = '?vars=';
    var mandvalue = mandvalue+'&nombre = '+nombre;
    var mandvalue = mandvalue+'&rand = '+Math.random();

    http.open('GET', 'mandamailaempr.php'+mandvalue, true);
    http.onreadystatechange = handleHttpResponse;
    http.send(null);
  }
}

emldusr    = '';
iddelcso   = '';
codamandar = '';
function mandamailausr() {
	if (estadoajax == 'libre') {
		document.body.style.backgroundImage = 'url(images/rotating_arrow.gif)';
		estadoajax = 'laburando';
		var mandvalue = '?vars=';
		var mandvalue = mandvalue+'&eml='+emldusr;
		var mandvalue = mandvalue+'&cod='+codamandar;
		var mandvalue = mandvalue+'&rand='+Math.random();

		http.open('GET', 'mandamailausr5'+mandvalue, true);
		http.onreadystatechange = handleHttpResponse;
		http.send(null);
	}
}
armails = new Array();
arids   = new Array();
arcods  = new Array();
<? $cuenta = 0;
   foreach($listamails as $cadamail) { ?>
  armails[<?=$cuenta?>] = '<?=$cadamail?>';
  arids[<?=$cuenta?>]   = '<?=$listaids[$cuenta]?>';
  arcods[<?=$cuenta?>]  = '<?=$listacods[$cuenta]?>';
<? $cuenta++; } ?>
ctaenvxbulk = 0;
relojIniciado = false;
todosenviados = false;
function iniciarenviobulk() {
	if (!todosenviados) {
		emldusr    = armails[ctaenvxbulk];
		iddelcso   = arids[ctaenvxbulk];
		codamandar = arcods[ctaenvxbulk];
		mandamailausr();
		ctaenvxbulk++;
		mytime = setTimeout('enviobulk()', <?=$segundosdeespera?>)
		cuentaUp = 0;
		if (!relojIniciado) {
			relojIniciado = true;
			idReloj = setInterval("reloj()", 1000);
		}
	}
}
function enviobulk() {
	iniciarenviobulk();
}
cuentaUp = 0;
function reloj(){
	cuentaUp += 1000;
	nroSegundo = Math.floor((<?=$segundosdeespera?>-cuentaUp)/1000);
	if ((document.getElementById('muestraReloj').innerHTML.replace(/^\s+/g,'').replace(/\s+$/g,'') != 'Mail enviado') && (nroSegundo > 0))
		document.getElementById('muestraReloj').innerHTML = nroSegundo;
}
-->
</script>
	<div style="position:absolute;top:0;right:0;width:auto;" id="muestraReloj"></div>
  </body>
</html>