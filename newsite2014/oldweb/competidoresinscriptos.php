<?php
include 'includes/_soloheader.php';
?>
		<div class="columnacentral" style="height:auto;width:100%;">
		Competidores Inscriptos a: <?php
$result1 = mysql_query('SELECT * FROM inscribite_eventos WHERE codigo="'.$_GET['evento'].'" LIMIT 1 ');
$row = mysql_fetch_array($result1);
echo $row['nombre'];
?>
	<table style="width:auto;font-size:10px;">
	<tr>
	 <td style="font-weight:bold;text-align:center;">DNI</td>
     <td style="font-weight:bold;text-align:center;">Apellido</td>
     <td style="font-weight:bold;text-align:center;">Nombre</td>
     <td style="font-weight:bold;text-align:center;">Grupo</td>
     <td style="font-weight:bold;text-align:center;">Categoría</td>
     <td style="font-weight:bold;text-align:center;">Condición</td>
	</tr>
<?php
$result1 = mysql_query('SELECT * FROM inscribite_inscripciones WHERE deevento="'.$_GET['evento'].'" ORDER BY deusuario ');
while ($row = mysql_fetch_array($result1)) {
  if ($row['deusuario'] != '00000000') {
    $result2 = mysql_query('SELECT * FROM inscribite_usuarios WHERE dni="'.$row['deusuario'].'" OR dni="'.($row['deusuario']*1).'" LIMIT 1 ');
    $row2 = mysql_fetch_array($result2);
    $result3 = mysql_query('SELECT * FROM inscribite_categorias WHERE codigo="'.substr($row['codigo'],4,2).'" AND deevento="'.$evento.'" LIMIT 1 ');
    $row3 = mysql_fetch_array($result3);
    if ($ultimodni != ($row['deusuario']*1)) {
      $ultimodni = ($row['deusuario']*1);
?>
	<tr>
	 <td style="text-align:right"><?=($row['deusuario']*1)?></td><td><?=$row2['apellido']?></td><td><?=$row2['nombre']?></td><td>&nbsp;<?=$row3['opcion']?></td><td><?=$row3['nombre']?></td><td><?=($row['pagado']==0)?'Reservada':'<span style="color:green">Confirmada</span>'?></td>
	</tr>
<?php
    }
  }
}
?>
	</table>
		</div>
<?php
include 'includes/_solofooter.php';
?>