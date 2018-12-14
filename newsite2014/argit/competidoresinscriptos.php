<?php
$pagar = "blue";
?>
<?php
require_once dirname(__FILE__) . '/general/header.php';

//info del usuario
$evento = filter_input(INPUT_GET,'evento');
$query = "SELECT nombre,apellido,opcion,categoria FROM `inscribite_inscripciones`
			INNER JOIN inscribite_usuarios ON dni = deusuario
			WHERE deevento = $evento";
$inscripciones = getArrayQuery($query, $mysqli);



?>
</div>

<div class="container">

<h1>Competidores Inscriptos a: Evento nombre</h1>
<div class="panel-group accordion" id="accordion-events">
<table class="table" border="1" >
	<thead>
	<tr>
		<th ><span style="font-weight: bold">Apellido</span></td>
		<th ><span style="font-weight: bold">Nombre</span></td>
		<th ><span style="font-weight: bold">Grupo</span></td>
		<th ><span style="font-weight: bold">Categoría</span></td>
	</tr>
	</thead>
	<tbody style="text-align:center">
	<?php foreach($inscripciones as $inscripcion){
		echo '<tr>';
		echo '<td>'.$inscripcion['apellido'].'</td>';
		echo '<td>'.$inscripcion['nombre'].'</td>';
		echo '<td>'.$inscripcion['opcion'].'</td>';
		echo '<td>'.$inscripcion['categoria'].'</td>';
		echo '<tr>';
		}
	?>
	<tbody>


</table>
</div>

</div>
<?php include_once dirname(__FILE__) . '/general/footer.php'; ?>					