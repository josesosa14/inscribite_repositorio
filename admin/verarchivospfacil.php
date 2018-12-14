<?
$evento = array();
$marcadospagados = array();
$nroarev = 0;
function agceros($nombreag, $cantceros){
  while (strlen($nombreag) < $cantceros) $nombreag = "0".$nombreag;
  return $nombreag;
}

include_once "../inc.config.php";

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
	border:1px #DDDDDD solid;
}
.textoidcliente{
	color:#AAAAAA;
}
.nombredato{
	color:#999999;
}
div{
	/*float:left;*/
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
<?
	$directorio = "filepfacil/";

if ($_GET['archivo']!= '') $_POST = $_GET;
foreach ($_POST as $nombrevariable => $valorvariable){
if ($nombrevariable!= 'volvera') {
  $archivo = $directorio.$valorvariable;
  $newnombre = $valorvariable;
  $fp = fopen($archivo,'r');
  if (filesize($archivo)>0){
    $texto = fread($fp,filesize($archivo));
    fclose($fp);
  }
  $conte = $texto;
//$fechadelarchivo = '20'.substr($newnombre,6,2).'/'.substr($newnombre,4,2).'/'.substr($newnombre,2,2);
//mysql_query('UPDATE inscribite_archivospfacil SET fecha = "'.$fechadelarchivo.'" WHERE nombre = "'.$newnombre.'" ');
//$fechadelarchivo = substr($conte,7,2).'/'.substr($conte,5,2).'/'.substr($conte,1,4);
?>
    <table style="border:1px black solid; margin-top:0px; float:left; width:100%;">
      <tr/>
        <td>Nro.</td>
        <td></td>
        <td></td>
        <td></td>
        <td style="width:245px;">Cliente:</td>
        <td>Evento:</td>
        <td>Codigo:</td>
        <td>&nbsp;</td>
        <td>Monto:</td>
        <td>Realizado en Terminal:</td>
        <td>Fecha:</td>
        <td>Hora:</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
<? 
$posant = 260;
while (substr($conte, $posant,1) == 5){
    $result1 = mysql_query('SELECT * FROM inscribite_usuarios WHERE dni = "'.(substr($conte, $posant+30,15)+0).'" LIMIT 1 ');
    $row1 = mysql_fetch_array($result1);
?>
      <tr class="cadaoperacion">
        <td><?=(substr($conte, $posant+1,5)+0)?></td>
        <td></td>
        <td></td>
        <td></td>
        <td>
<? /* <a href="usuarios?busqueda=<?=(substr($conte, $posant+30,15)+0)?>"> */ ?>

<?=(substr($conte, $posant+30,15)+0)?>

<? /* </a> */ ?>
<?=$row1['apellido'].", ".$row1['nombre'];
$elcodigoes = substr(substr($conte, $posant+24,20),0,4).substr(substr($conte, $posant+24,20),4,2).agceros((substr($conte, $posant+30,15)+0),8);

  $result2 = mysql_query('SELECT id FROM inscribite_inscripciones WHERE codigo = "'.$elcodigoes.'" LIMIT 1 ');
  if (mysql_num_rows($result2) == 0){
    $result3 = mysql_query('SELECT empresa FROM inscribite_eventos WHERE codigo = "'.substr(substr($conte, $posant+24,20),0,4).'" LIMIT 1 ');
    $row3 = mysql_fetch_array($result3);
    $empresa = $row3['empresa'];
    $result3 = mysql_query('SELECT opcion FROM inscribite_categorias WHERE deevento = "'.substr(substr($conte, $posant+24,20),0,4).'" AND codigo = "'.substr(substr($conte, $posant+24,20),4,2).'" LIMIT 1 ');
    $row3 = mysql_fetch_array($result3);
    mysql_query("INSERT INTO inscribite_inscripciones ( `id`, `deusuario`, `empresa`, `deevento`, `categoria`, `opcion`, `codigo`) VALUES ( '', '".agceros((substr($conte, $posant+30,15)+0),8)."', '".$empresa."', '".substr(substr($conte, $posant+24,20),0,4)."', '".substr(substr($conte, $posant+24,20),4,2)."', '".$row3['opcion']."', '".$elcodigoes."');");
    echo ' (agregado)';
  }

mysql_query('UPDATE inscribite_inscripciones SET pagado = 1 WHERE codigo = "'.$elcodigoes.'" ');
mysql_query('UPDATE inscribite_inscripciones SET pagoeldia = "'.substr($conte, $posant+64,4)."-".substr($conte, $posant+68,2)."-".substr($conte, $posant+70,2).' '.substr($conte, $posant+72,2).':'.substr($conte, $posant+74,2).':00" WHERE codigo = "'.$elcodigoes.'" ');
mysql_query('UPDATE inscribite_inscripciones SET precio = "'.(substr($conte, $posant+48,8)+0).', '.substr($conte,316,2).'" WHERE codigo = "'.$elcodigoes.'" ');

?></td>
        <td><?=substr(substr($conte, $posant+24,20),0,4);
$evento[$nroarev] = substr(substr($conte, $posant+24,20),0,4);
$nroarev++;
?></td>
        <td><?=substr(substr($conte, $posant+24,20),0,14)?></td>
        <td><?=(substr($conte, $posant+45,3) == "PES")?'$':substr($conte, $posant+45,3)?></td>
        <td><?=(substr($conte, $posant+48,8)+0)?>,<?=substr($conte,316,2)?></td>
        <td><?=substr($conte, $posant+58,6)?></td>
        <td><?=substr($conte, $posant+70,2)?>/<?=substr($conte, $posant+68,2)?>/<?=substr($conte, $posant+64,4)?></td>
        <td><?=substr($conte, $posant+72,2)?>:<?=substr($conte, $posant+74,2)?></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
<? $posant = $posant+390;
//correccion de un archivo con 3 caracteres menos
if ((substr($conte, $posant,1)!= 5)&&(substr($conte, $posant-3,1) == 5)) $posant-= 3;
}}}
?>
    </table>
    <br/>
    <a href="./?sec=<?=str_replace('amp;', '&', $_GET['volvera']).str_replace('amp;', '&', $_POST['volvera'])?>">Volver</a>
  </body>
</html><?
if (is_resource($result1))mysql_free_result($result1);
if (is_resource($result2))mysql_free_result($result2);
if (is_resource($result3))mysql_free_result($result3);
mysql_close();
?>
