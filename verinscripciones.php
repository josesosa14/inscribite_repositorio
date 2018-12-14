<?	$mostrarSoloHead = true;
	include_once 'includes/head.php'?>
<style type="text/css">
<!--
body{
	font-size:13px;
}
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
}
.titulos td{
	padding-bottom:3px;
	padding-top:2px;
	font-weight:bold;
	background-color:#EEEEEE;
}
-->
</style>
<div class="columnacentral" style="overflow:visible;width:100%;height:auto;">
<?	//$result1 = mysql_query('SELECT * FROM '.pftables.'eventos WHERE empresa="'.$_POST['empresa'].'" AND ver = 1 ');
	//while ($row1 = mysql_fetch_array($result1)) { ?>
	<br/>
	<strong><?=$row1['nombre']?></strong>
	<div>
		<a href="javascript:document.getElementById('codeinscr<?=$row1['id']?>').style.display = 'block'">Crear botón con enlace a la inscripción del evento <?=$row1['nombre']?> para su sitio web</a>
	</div>
	<div style="display:none;" id="codeinscr<?=$row1['id']?>">
		Copie y pegue el siguiente código en su sitio web
		<div>
			<textarea style="width:600px;height:100px;" id="codigotarea" cols="20" rows="1"></textarea>
		</div>
		<script type="text/javascript">
		<!--
		document.getElementById('codigotarea').value = '<a href="<?=url?>iniciainscri?evento=<?=$_GET['evento']?>">Inscribirse mediante Inscribite Online</a>';
		-->
		</script>
		el resultado será un enlace como este: <a href="<?=url?>iniciainscri?evento=<?=str_replace(" ","_",$row1['nombre'])?>">Inscribirse mediante Inscribite Online</a>
	</div>
<?	//$result2 = mysql_query('SELECT * FROM '.pftables.'inscripciones WHERE deevento="'.$row1['codigo'].'" ORDER BY codigo ');
	$cuenta = 0;
	$result2 = mysql_query('SELECT * FROM '.pftables.'inscripciones WHERE deevento="'.$_GET['evento'].'" ORDER BY codigo');
	if (mysql_num_rows($result2) > 0) {
		$hayuninscripto = true; ?>
	<br/>
	<table cellpadding="0" cellspacing="0">
		<tr class="titulos">
			<td style="width:5px;"></td>
			<td>DNI Usuario</td>
			<td>Nombre</td>
			<td>Evento</td>
			<td>Categoría</td>
			<td>Inscripción</td>
			<td>Pagado</td>
			<td>el día</td>
		</tr>
<?		if ($row1['pregunta'] != '') echo '<td>'.$row1['pregunta'].'</td>';
		while ($row2 = mysql_fetch_array($result2)) {
			$cuenta++;
			$result3 = mysql_query('SELECT * FROM '.pftables.'usuarios WHERE dni="'.($row2['deusuario']*1).'" LIMIT 1')?>
		<tr>
			<td style="font-size:12px;vertical-align:middle;"><?=$cuenta?></td>
			<td>&nbsp;<?=($row2['deusuario']*1)?>&nbsp;</td>
			<td>&nbsp;<? if ($row3 = mysql_fetch_array($result3)) echo $row3['apellido'].', '.$row3['nombre']?>&nbsp;</td>
			<td><?=$row2['deevento']?></td>
			<td><?=$row2['categoria']?></td>
			<td><?=$row2['iniciadoeldia']?></td>
			<td><input type="checkbox" onclick="return false;"<? if ($row2['pagado'] == 1) echo ' checked="checked"'?> style="width:auto;height:auto;"/></td>
			<td><? if ($row2['pagado'] == 1) echo $row2['pagoeldia']?></td>
		</tr>
<?			if ($row2['respuestapart1'] != '') echo '<tr><td colspan="3">'.$row1['pregunta1'].'</td><td colspan="4">'.$row2['respuestapart1'].'</td></tr>';
			if ($row2['respuestapart2'] != '') echo '<tr><td colspan="3">'.$row1['pregunta2'].'</td><td colspan="4">'.$row2['respuestapart2'].'</td></tr>';
			if ($row2['respuestapart3'] != '') echo '<tr><td colspan="3">'.$row1['pregunta3'].'</td><td colspan="4">'.$row2['respuestapart3'].'</td></tr>';?>
<?		} ?>
	</table>
<?	}
	if (!($hayuninscripto)) echo 'Aún no hay inscriptos<br/>';
	//} ?>
</div>
<?	include_once 'includes/_solofooter.php'; ?>