<?
$evento=array();
$marcadospagados=array();
$nroarev=0;
function agceros($nombreag,$cantceros){
	while(strlen($nombreag)<$cantceros)$nombreag="0".$nombreag;
	return $nombreag;
}
$conexio=mysql_connect("localhost","inscribite_user","iW7zNKpRWkSHHwplBhUO");
mysql_select_db("inscribite_base",$conexio);

mysql_query("DELETE FROM inscribite_inscripciones WHERE pagado=0 AND venceeldia!=0 AND venceeldia<".date("Ymd"));

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
<?
$nrodconfml=0;
$directorio='filepfacil/';
$newnombre=$_FILES['archivo_usuario']['name'];
if(move_uploaded_file($_FILES['archivo_usuario']['tmp_name'],$directorio.$_FILES['archivo_usuario']['name'])){
	$archivo=$directorio.$newnombre;
	$fp=fopen($archivo,'r');

    if(filesize($archivo)>0)
	  $texto=fread($fp,filesize($archivo));
	fclose($fp);

	$conte=$texto;
    $correccion=0;
    ?>
    <div>
      <?php /*Record Code:<br/>
      echo substr($conte,0,1)?><br/> */ ?>
      <span class="nombredato">Fecha:</span><br/>
      <?=substr($conte,7,2)?>/<?=substr($conte,5,2)?>/<?=substr($conte,1,4)?>
      <br/>
      <span class="nombredato">Origin Name:</span><br/>
      <?=substr($conte,9,25)?><br/>
      <span class="nombredato">ID Empresa:</span><br/>
      <?=substr($conte,34,9)?><br/>
      <span class="nombredato">Empresa</span>:<br/>
      <?=substr($conte,43,15)?><br/>
      <?php //echo substr($conte,78,50)?><br/>

      <?php /*Record Code:<br/>
      <?=substr($conte,130,1)?><br/>
      */ ?>
      <span class="nombredato">Fecha:</span><br/>
      <?
      if(substr($conte,137,2)>31){
        $correccion=-1;
      }
      echo substr($conte,137+$correccion,2)?>/<?=substr($conte,135+$correccion,2)?>/<?=substr($conte,131+$correccion,4)?>
      <br/>
      <span class="nombredato">Lote:</span><br/>
      <?=substr($conte,139+$correccion,6)?><br/>
      <span class="nombredato">Empresa:</span><br/>
      <?=substr($conte,145+$correccion,15)?>
      <?php /* =substr($conte,180,78) */?>
      </div>
      <br/>
      <table style="border:1px black solid; margin-top:0px; float:left; width:100%;">
        <tr>
          <?php /*<td>
            Record Code:
          </td> */ ?>
          <td>
            Nro.
          </td>
          <td>
            <?php /* Código de Transacción: */ ?>
          </td>
          <td>
            <?php /* Fecha de proceso: */ ?>
          </td>
          <td>
            <?php /* Fecha de creación: */ ?>
          </td>
          <td>
            Cliente:
          </td>
          <td>
            Evento:
          </td>
          <td>
            Categ.:
          </td>
          <td>
            &nbsp;
          </td>
          <td>
            Monto:
          </td>
          <td>
            Realizado en Terminal:
          </td>
          <td>
            Fecha:
          </td>
          <td>
            Hora:
          </td>
          <td>
            <?php /* Número de secuencia en terminal: */ ?>
          </td>
          <td>
            <?php /* Código de barras: */ ?>
          </td>
          <td>
            <?php /* Moneda: */ ?>
          </td>
          <td>
            <?php /* Efectivo o Cheque */ ?>
          </td>
        </tr>
<?
      if(substr($conte,137,2)>31){
        $correccion=-2;
      }
          $posant=260+$correccion;
          while(substr($conte,$posant,1)==5){

          $result1=mysql_query('SELECT * FROM inscribite_usuarios WHERE dni="'.trim((substr($conte,$posant+30,15)+0)).'" LIMIT 1 ');
          $row=mysql_fetch_array($result1);
?>
        <tr class="cadaoperacion">
          <?php /*<td>
          <?=substr($conte,$posant,1)?>
          </td> */ ?>
          <td>
            <?=(substr($conte,$posant+1,5)+0)?>
          </td>
          <td>
            <?php /* echo substr($conte,$posant+6,2) */ ?>
          </td>
          <td>
            <?php /*echo substr($conte,$posant+14,2)?>/<?=substr($conte,$posant+12,2)?>/<?=substr($conte,$posant+8,4); */?>
          </td>
          <td>
            <?php /*echo substr($conte,$posant+22,2)?>/<?=substr($conte,$posant+20,2)?>/<?=substr($conte,$posant+16,4); */?>
          </td>
          <td>
            <a href="usuarios?busqueda=<?=(substr($conte,$posant+30,15)+0)?>"><?=(substr($conte,$posant+30,15)+0)?></a>
            <?
//echo substr($conte,$posant+24,20); 
echo $row['apellido'].", ".$row['nombre'];

$elcodigoes=substr(substr($conte,$posant+24,20),0,4).substr(substr($conte,$posant+24,20),4,2).agceros((substr($conte,$posant+30,15)+0),8);

  $result2=mysql_query('SELECT id FROM inscribite_inscripciones WHERE codigo = "'.$elcodigoes.'" LIMIT 1 ');
  if(mysql_num_rows($result2)==0){
    $result3=mysql_query('SELECT empresa, opcion1, opcion2, opcion3, opcion4 FROM inscribite_eventos WHERE codigo = "'.substr(substr($conte,$posant+24,20),0,4).'" LIMIT 1 ');
    $row3=mysql_fetch_array($result3);
    $empresa=$row3['empresa'];
    $opcion1=$row3['opcion1'];
    $opcion2=$row3['opcion2'];
    $opcion3=$row3['opcion3'];
    $opcion4=$row3['opcion4'];

    $result3=mysql_query('SELECT opcion FROM inscribite_categorias WHERE deevento = "'.substr(substr($conte,$posant+24,20),0,4).'" AND codigo = "'.substr(substr($conte,$posant+24,20),4,2).'" LIMIT 1 ');
    $row3=mysql_fetch_array($result3);
    if($row3['opcion']==$opcion1)$nrodeopcion=1;
    if($row3['opcion']==$opcion2)$nrodeopcion=2;
    if($row3['opcion']==$opcion3)$nrodeopcion=3;
    if($row3['opcion']==$opcion4)$nrodeopcion=4;
    mysql_query("INSERT INTO inscribite_inscripciones ( `id`,`deusuario`,`empresa`,`deevento`,`categoria`,`opcion`,`codigo`) VALUES ( '','".agceros((substr($conte,$posant+30,15)+0),8)."','".$empresa."','".substr(substr($conte,$posant+24,20),0,4)."','".substr(substr($conte,$posant+24,20),4,2)."','".$nrodeopcion."','".$elcodigoes."');");
    echo ' (agregado)';
  }
  echo ' '.(substr($conte,$posant+48,8)+0).','.substr($conte,316,2).' ';

mysql_query('UPDATE inscribite_inscripciones SET pagado = 1 WHERE codigo = "'.$elcodigoes.'" ');
mysql_query('UPDATE inscribite_inscripciones SET pagoeldia = "'.substr($conte,$posant+64,4)."-".substr($conte,$posant+68,2)."-".substr($conte,$posant+70,2).'" WHERE codigo = "'.$elcodigoes.'" ');
mysql_query('UPDATE inscribite_inscripciones SET precio = "'.(substr($conte,$posant+48,8)+0).','.substr($conte,316,2).'" WHERE codigo = "'.$elcodigoes.'" ');

  $result2=mysql_query('SELECT puntos FROM inscribite_eventos WHERE codigo = "'.substr(substr($conte,$posant+24,20),0,4).'" LIMIT 1 ');
  $row2=mysql_fetch_array($result2);
  $puntosqcarga=$row2['puntos'];

mysql_query("UPDATE inscribite_usuarios SET puntos=puntos+".$puntosqcarga." WHERE dni='".(substr($conte,$posant+30,15)+0)."' OR dni='".agceros((substr($conte,$posant+30,15)+0),8)."' ");
?>
          </td>
          <td>
            <?=substr(substr($conte,$posant+24,20),0,4)?>
          </td>
            <?
            $evento[$nroarev]=substr(substr($conte,$posant+24,20),0,4);
            $nroarev++;
            ?>
          <td>
            <?=substr(substr($conte,$posant+24,20),0,14)?>
          </td>
            <?
          /*
          echo '<span class="textoidcliente">edad computada: </span>'.substr(substr($conte,$posant+24,20),4,2)." ";
          */
            ?>
          </td>
          <td>
            <?=(substr($conte,$posant+45,3)=="PES")?"$":substr($conte,$posant+45,3)?>
          </td>
          <td>
            <?=(substr($conte,$posant+48,8)+0)?>,<?=substr($conte,316,2)?>
          </td>
          <td>
            <?=substr($conte,$posant+58,6)?>
          </td>
          <td>
            <?=substr($conte,$posant+70,2)?>/<?=substr($conte,$posant+68,2)?>/<?=substr($conte,$posant+64,4)?>
          </td>
          <td>
            <?=substr($conte,$posant+72,2)?>:<?=substr($conte,$posant+74,2)?>
          </td>
          <td>
<?
$result2=mysql_query('SELECT * FROM inscribite_inscripciones WHERE codigo = "'.substr(substr($conte,$posant+24,20),0,4).substr(substr($conte,$posant+24,20),4,2).(substr($conte,$posant+30,15)+0).'" LIMIT 1 ');
while($row2=mysql_fetch_array($result2)){ $selemandomail=$row2['selemandomail']; }
if($selemandomail!=1){ ?>
<span id="cnfml<?=$nrodconfml?>">
<a href="javascript:emldusr='<?=$row['email']?>';iddelcso='cnfml<?=$nrodconfml?>';codamandar='<?=$elcodigoes?>';mandamailausr();">
Enviar email</a>
</span>
<?php }else{ ?>
<span >
Mail enviado
</span>
<?php } 
$nrodconfml++;
          /* echo substr($conte,$posant+76,4) */ ?>
          </td>
            <?php /* echo substr($conte,$posant+78,48) */ ?>
            <?php /* echo substr($conte,$posant+130,1)?> */ /* Record Code */ ?>
          <td>
            <?php /* echo (substr($conte,$posant+131,80)) */ ?>
          </td>
            <?php /* echo substr($conte,$posant+211,46) */ ?>
          <?php /* <td>
            <?=substr($conte,$posant+260,1)?>
          </td> */ ?>
          <td>
            <?php /* echo substr($conte,$posant+261,3) */ ?>
          </td>
          <td>
            <?php /* echo substr($conte,$posant+264,1) */ ?>
          </td>
        </tr>
<?php /* } */
$posant=$posant+390;
}
?>
      </table>
<?
$fechadelarchivo='20'.substr($newnombre,6,2).'/'.substr($newnombre,4,2).'/'.substr($newnombre,2,2);
$result3=mysql_query('SELECT * FROM inscribite_archivospfacil WHERE nombre = "'.$newnombre.'" LIMIT 1 ');
if(mysql_num_rows($result3)==0){
	mysql_query("INSERT INTO `inscribite_archivospfacil` ( `id`,`nombre`,`fecha`) VALUES ( '', '".$newnombre."', '".$fechadelarchivo."');");
}

// marcar como pagos en base de inscripciones

// Enviar email a cada inscripto <-- mejor asi no porque es spam

// Enviar mail a la empresa organizadora

/* Record Code:<br/>
<?=substr($conte,$posant,1)?><br/>
*/ ?>
<span class="nombredato">Fecha:</span><br/>
<?=substr($conte,$posant+7,2)?>/<?=substr($conte,$posant+5,2)?>/<?=substr($conte,$posant+1,4)?>
<br/>
<span class="nombredato">Número Batch:</span><br/>
<?=substr($conte,$posant+9,6)?></span><br/>
<span class="nombredato">Cantidad de transacciones del lote:</span><br/>
<?=substr($conte,$posant+15,7)?></span><br/>
<span class="nombredato">Importe total cobrado del lote:</span><br/>
<?=(substr($conte,$posant+22,10)+0)?>,<?=substr($conte,$posant+32,2)?><br/>

<br/>
<?
// Aca toma todos los mails de las empresas y se fija si no se repiten
$arraydeempresas=array();
$nrodarempr=0;
foreach($evento as $value){
  $result1=mysql_query('SELECT * FROM inscribite_eventos WHERE codigo = "'.$value.'" LIMIT 1 ');
  while($row=mysql_fetch_array($result1)){
	$nrodarempr++;
	$arraydeempresas[$nrodarempr]=$row['empresa'];
  }
} 
sort($arraydeempresas);
reset($arraydeempresas);
foreach($arraydeempresas as $value2){
	$evnorep = $value2;
	if($evnorep!=$antevrep){
$result1=mysql_query('SELECT * FROM inscribite_empresas WHERE nombre="'.$evnorep.'" LIMIT 1 ');
while($row=mysql_fetch_array($result1)){

$msg='<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
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
      <td><p><font color="#666666" size="2" face="Verdana, Arial, Helvetica, sans-serif">Estimado '.$row['contacto'].':</font></p>
        <p><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#666666">Pagofacil ha confirmado el pago de inscripciones, para ver los datos completos ingrese en <a href="http://www.inscribiteonline.com.ar/empresas/'.str_replace(" ","_",$evnorep).'">http://www.inscribiteonline.com.ar/empresas/'.str_replace(" ","_",$evnorep).'</a> con la contraseña: '.$row[password].' </font></p>

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
//$email = $row[email];
$email=$_GET['eml'];
mail($row['email'],"Inscripciones confirmadas desde: Inscribite Online",$msg,"From: info@maritimopro.com.ar\r\nContent-Type: text/html; charset=utf-8\r\n");
?>
		Se envió email a la empresa organizadora: <?=$evnorep?> &lt;<?=$row['email']?>&gt;<br/>
<?
}
	}
	$antevrep=$value2;
}


    if(is_resource($result1))mysql_free_result($result1);
    if(is_resource($result2))mysql_free_result($result2);
    if(is_resource($result3))mysql_free_result($result3);
    mysql_close();
}else{
    print "Error al intentar subir el archivo.";
}

?>
    <br/>
    <a href="./?sec=feedback.pagofacil">Volver</a>
<script type="text/javascript">
<!--
var http=getHTTPObject();
var estadoajax="libre";

function getHTTPObject(){ var xmlhttp;
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
	if(!xmlhttp && typeof XMLHttpRequest !='undefined'){
			try { xmlhttp = new XMLHttpRequest();
		} catch (e) {
			xmlhttp=false;
		}
	}
	return xmlhttp;
}

function handleHttpResponse(){
	if(http.readyState==4){
		estadoajax='libre';
		document.body.style.backgroundImage='none';
		document.getElementById(iddelcso).innerHTML=http.responseText;
	}
}

emldusr='';
iddelcso='';
codamandar='';
function mandamailausr(){
	if(estadoajax=='libre'){
		document.body.style.backgroundImage='url(images/rotating_arrow.gif)';
		estadoajax='laburando';
		var mandValue='?vars=';
		var mandValue=mandValue+'&eml='+emldusr;
		var mandValue=mandValue+'&cod='+codamandar;

		http.open('GET','mandamailausr5'+mandValue, true);
		http.onreadystatechange=handleHttpResponse;
		http.send(null);
	}
}
-->
</script>
  </body>
</html>