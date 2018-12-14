<?php
$pagar = "blue";
?>
<?php
require_once dirname(__FILE__) . '/general/header.php';

//info del usuario
$evento = filter_input(INPUT_GET,'evento');
$query = "SELECT nombre,apellido,opcion,categoria FROM `inscribite_inscripciones`
			INNER JOIN inscribite_usuarios ON dni = deusuario
			WHERE codigo = $evento";
$inscripciones = getRowQuery($query, $mysqli);

?>

<div class="left" style="width:710px;">
<h1>Competidores Inscriptos a: 
Evento nombre</h1>
<table cellpadding="2" cellspacing="0" style="width:700px;">
	<tr>
		<td width="120"><span style="font-weight: bold">Apellido</span></td>
		<td width="114"><span style="font-weight: bold">Nombre</span></td>
		<td width="91"><span style="font-weight: bold">Grupo</span></td>
		<td width="140"><span style="font-weight: bold">Categoría</span></td>
	</tr>
	
	<?php foreach($inscripciones as $inscripcion){
		echo '<tr>';
		echo '<td>'.$inscripcion['apellido'].'</td>';
		echo '<td>'.$inscripcion['nombre'].'</td>';
		echo '<td>'.$inscripcion['opcion'].'</td>';
		echo '<td>'.$inscripcion['categoria'].'</td>';
		echo '/<tr>';
		}
	?>


</table>
<?php include_once dirname(__FILE__) . '/general/footer.php'; ?>					