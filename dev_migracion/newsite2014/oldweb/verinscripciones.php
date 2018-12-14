<?php
include 'includes/_soloheader.php';
?>
<style type="text/css">
<!--
.contenidoseccioncentral{
 color:#000000;
}
td{
 border:none;
 border-left:1px black solid;
 border-bottom:1px black solid;
 margin:0px;
 padding:0px;
 padding-left:6px;
 padding-right:6px;
 text-align:center;
}
table{
 border-top:1px black solid;
 border-right:1px black solid;
 font-size: 83%;
}
.titulos td{
 padding-bottom:3px;
 padding-top:2px;
 font-size:13px;
 font-weight:bold;
 background-color:#EEEEEE;
}
-->
</style>
		<div class="columnacentral" style="overflow:visible;width:100%;height:auto;">
<?php
//$result1 = mysql_query('SELECT * FROM inscribite_eventos WHERE empresa="'.$_POST['empresa'].'" AND ver = 1 ');
//while ($row = mysql_fetch_array($result1)) {
?>
			<br/>
			<strong><?=$row['nombre']?></strong>
			<div>
			<a href="javascript:mostrar('codeinscr<?=$row['id']?>')">Crear botón con enlace a la inscripción del evento <?=$row['nombre']?> para su sitio web</a>
			</div>
			<div style="display:none;" id="codeinscr<?=$row['id']?>">
			Copie y pegue el siguiente código en su sitio web
			<div>
			<textarea style="width:600px;height:100px;"><a href="http://www.inscribiteonline.com.ar/iniciainscri?evento=<?=str_replace(" ","_",$row['nombre'])?>">Inscribirse mediante Inscribite Online</a>
			</textarea>
			</div>
			el resultado será un enlace como este: <a href="http://www.inscribiteonline.com.ar/iniciainscri?evento=<?=str_replace(" ","_",$row['nombre'])?>">Inscribirse mediante Inscribite Online</a>
			</div>
<?php
//$result2 = mysql_query('SELECT * FROM inscribite_inscripciones WHERE deevento="'.$row['codigo'].'" ORDER BY codigo ');
$result2 = mysql_query('SELECT * FROM inscribite_inscripciones WHERE deevento="'.$_GET['evento'].'" ORDER BY codigo ');
if (mysql_num_rows($result2)>0) {
  $hayuninscripto = true;
?>
<br/>
<table cellpadding="0" cellspacing="0">
<tr class="titulos">
<td>DNI Usuario</td>
<td>Nombre</td>
<td>Evento</td>
<td>Categoría</td>
<td>Pagado</td>
<td>el día</td>
<?php if ($row['pregunta'] != '') echo'<td>'.$row['pregunta'].'</td>';
   while ($row2 = mysql_fetch_array($result2)) { ?>
<tr>
<td>&nbsp;<?=($row2['deusuario']*1)?>&nbsp;</td>
<td>&nbsp;<?php
$result3 = mysql_query('SELECT * FROM inscribite_usuarios WHERE dni="'.($row2['deusuario']*1).'" LIMIT 1 ');
while($row3 = mysql_fetch_array($result3)) {
  echo $row3['apellido'].', '.$row3['nombre'];
}
?>&nbsp;</td>
<td><?=$row2['deevento']?></td>
<td><?=$row2['categoria']?></td>
<td><input type="checkbox" onclick="return false;"<?php if ($row2['pagado'] == 1) echo ' checked="checked"'?> style="width:auto;height:auto;"/></td>
<td><?php if ($row2['pagado'] == 1) echo $row2['pagoeldia']?></td>
<?
 if ($row2['respuestapart1'] != '') echo '<tr><td colspan="3">'.$row['pregunta1'].'</td><td colspan="4">'.$row2['respuestapart1'].'</td></tr>';
 if ($row2['respuestapart2'] != '') echo '<tr><td colspan="3">'.$row['pregunta2'].'</td><td colspan="4">'.$row2['respuestapart2'].'</td></tr>';
 if ($row2['respuestapart3'] != '') echo '<tr><td colspan="3">'.$row['pregunta3'].'</td><td colspan="4">'.$row2['respuestapart3'].'</td></tr>';

?>
</tr>
<?php } ?>
</table>
<?php }
if (!($hayuninscripto)) echo 'Aún no hay inscriptos<br/>';
 //}
?>
		</div>
<?php
include 'includes/_solofooter.php';
?>