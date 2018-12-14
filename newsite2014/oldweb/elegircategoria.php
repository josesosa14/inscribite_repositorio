<?php
include 'includes/head.php';
?>
		<div class="columnacentral" style="overflow:visible;">
			<div class="contenidoseccioncentral">
			Evento: <?=$_POST['evento']?><br/>
			<br/>
			Categorías:<br/>
<?php
	$result1 = mysql_query('SELECT * FROM inscribite_categorias WHERE deevento="'.$_POST['evento'].'" AND opcion="'.$_POST['opcion'].'" ');
	while($row=mysql_fetch_array($result1)){
		echo'<a href="">';
		echo $row['nombre'].'<br/>';
		echo preg_replace("(\r\n|\n|\r)","<br/>",$row['descripcion']).'</a><br/>';
		echo'<br/>';
	}
?>
			</div>
		</div>
<?php
include 'includes/colder.php';
?>