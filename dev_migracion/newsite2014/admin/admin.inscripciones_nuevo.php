<?	
$dni = filter_input(INPUT_GET,'busqueda');



$query = "SET SQL_BIG_SELECTS=1";
$setup = mysql_query($query);


$query = "SELECT e.nombre evento_nombre, e.fecha evento_fecha,e.codigo evento_codigo,i.pagado evento_pagado,
            i.categoria inscripcion_categoria,i.opcion inscripcion_opcion,i.id inscripcion_id,e.tipo evento_tipo
            FROM inscribite_inscripciones i
            INNER JOIN inscribite_eventos e ON e.codigo = i.deevento
			INNER JOIN inscribite_categorias c ON c.deevento = i.deevento AND c.nombre = i.categoria 
            WHERE i.deusuario = '$dni'
            GROUP BY i.id
            ";
$result1 = mysql_query($query);

$query = "SELECT * FROM inscribite_usuarios WHERE dni = '$dni'";	
$result2 = mysql_query($query);
$row2 = mysql_fetch_array($result2); ?>
     <div>
       <div style="margin-left:10px;margin-top:16px;font-size:12px;width:100%;">
         <div class="titulosec">Inscripciones de: <?=strtoupper($row2['nombre']).','.strtoupper($row2['apellido'])?>
         </div>
       </div>
	     <div>

	<br/>
	
	<style>
	table{
		
	}
	th{text-align:center}
	td{text-align:center}
	</style>

	<table>
		<tr>
			<th style="width:5px">Nro</th>
			<th>Evento</th>
			<th>Tipo</th>
			<th>Categoria</th>
			<th>Opcion</th>
			<th>Pagado</th>
			<th>&nbsp;</th>
		</tr>
<?php
	while ($row1 = mysql_fetch_array($result1)) {
		echo '<tr>
			<td>'.$row1['inscripcion_id'].'</td>
			<td>'.$row1['evento_nombre'].'</td>
			<td>'.$row1['evento_tipo'].'</td>
			<td>'.$row1['inscripcion_categoria'].'</td>
			<td>'.$row1['inscripcion_opcion'].'</td>
			<td>'.$row1['evento_pagado'].'</td>
		</tr>';
			
	} 
?>
	</table>
			</div>
		</div>
	</div>
