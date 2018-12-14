<?
include_once 'includes/head.php';
?>
		<div class="columnacentral" style="overflow:visible;">
			<div class="contenidoseccioncentral">
			Evento: <?=$_POST['evento']?><br/>
			<br/>
			Categorías:<br/>
<?
	$result1 = mysql_query('SELECT * FROM '.pftables.'categorias WHERE deevento="'.$_POST['evento'].'" AND opcion="'.$_POST['opcion'].'" ');
	while ($row1 =mysql_fetch_array($result1)) {
		echo'<a href="">';
		echo $row1['nombre'].'<br/>';
		echo preg_replace("(\r\n|\n|\r)","<br/>",$row1['descripcion']).'</a><br/>';
		echo'<br/>';
	}
?>
			</div>
		</div>
<? include_once 'includes/colder.php'; ?>