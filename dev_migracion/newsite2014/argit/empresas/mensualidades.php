<?php
$transferencia = "blue";
require_once dirname(__FILE__) . '/../general/header_empresa.php';
echo '</div>';

$query = "SELECT meu_importe,mec_nro_cuota,meu_u_dni,mec_id,CASE WHEN men_activo = 1 THEN 'Si' ELSE 'No' END men_activa,meu_fecha,men_nombre,concat(nombre,' ',apellido) as usuario,dni
			FROM `mensualidades` 
			INNER join mensualidad_cuotas on mec_men_id = men_id
			INNER join facturas on mec_id = fac_mensualidad
			INNER join inscribite_usuarios on id = fac_usu_id
			LEFT join mensualidad_cuota_usuario on meu_mec_id = mec_id AND meu_u_dni = dni
			where men_empresa = {$_SESSION['empresa']} ";
			
		

$mensualidades = getArrayQuery($query, $mysqli);

$query = "SELECT *,CASE WHEN men_activo = 1 THEN 'Si' ELSE 'No' END men_activa,(SELECT count(*) FROM mensualidad_usuario where meu_men_id = men_id) cant_usuarios FROM  mensualidades
			where men_empresa = {$_SESSION['empresa']} ";

$misMensualidades = getArrayQuery($query, $mysqli);
?>

<?php if ($misMensualidades): ?>
<h3>Mensualidades</h3>
<div class="table-responsive">
	<table  class="table table-bordered table-responsive" 
	data-toggle="table" data-height="auto" 
	data-show-refresh="true" 
	data-show-toggle="true" 
	
	data-search="true" data-select-item-name="toolbar1" data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]" data-page-size="20">
		<thead>
			<tr>
				<th class="col-md-2" data-field="dni" data-align="left" data-sortable="true">Mensualidad</th>   
				<th class="col-md-2" data-field="cuota" data-align="left" data-sortable="true">Cuotas</th>
				<th class="col-md-2" data-field="usuarios" data-align="left" data-sortable="true">Usuarios inscriptos</th>
				<th class="col-md-2" data-field="men_activa" data-align="left" data-sortable="true">Activa</th>
			</tr>
		</thead>
		<tbody>
			<?php
			foreach ($misMensualidades as $men) {
				echo '<tr>
					<td class="col-md-2">' . $men['men_nombre'] . '</td>
					<td class="col-md-2">' . $men['men_cuotas'] . '</td>
					<td class="col-md-2">' . $men['cant_usuarios'] . '</td>
					<td class="col-md-2">' . $men['men_activa'] . '</td>
				</tr>';
			}
			?>
		</tbody>
	</table>
</div> 
    <?php
else:
    echo '<h3>No tiene mensualidades de su empresa</h3>';
endif;
?>



<?php if ($mensualidades): ?>
<h3>Mensualidades de usuarios</h3>
<div class="table-responsive">
	<table  class="table table-bordered table-responsive" 
	data-toggle="table" data-height="auto" 
	data-show-refresh="true" 
	data-show-toggle="true" 
	data-show-export="true"
    data-export-types = "['excel','txt']"
	data-search="true" data-select-item-name="toolbar1" data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]" data-page-size="20">
		<thead>
			<tr>
				<th data-field="usuario" data-align="left" data-sortable="true">Deportista</th>   
				<th data-field="dni" data-align="left" data-sortable="true">Dni</th>   
				<th data-field="men_nombre" data-align="left" data-sortable="true">Mensualidad</th>
				<th data-field="mec_nro_cuota" data-align="left" data-sortable="true">Cuota</th>
				<th data-field="meu_importe" data-align="left" data-sortable="true">Importe</th>
				<th data-field="meu_fecha" data-align="left" data-sortable="true">Fecha</th>
				<th data-field="men_activa" data-align="left" data-sortable="true">Activa</th>
				<th data-field="estado" data-align="left" data-sortable="true">Estado</th>
			</tr>
		</thead>
		<tbody>
			<?php
			foreach ($mensualidades as $mensualidad) {
				echo '<tr>
					<td>' . $mensualidad['usuario'] . '</td>
					<td>' . $mensualidad['dni'] . '</td>
					<td>' . $mensualidad['men_nombre'] . '</td>
					<td>' . $mensualidad['mec_nro_cuota'] . '</td>
					<td>' . $mensualidad['meu_importe'] . '</td>
					<td>' . date('d/m/Y',strtotime($mensualidad['meu_fecha'])) . '</td>
					<td>' . $mensualidad['men_activa'] . '</td>';
					if(!$mensualidad['meu_fecha']){
						echo '<td ><button onclick="quierePagar('.$mensualidad['dni'].','.$mensualidad['mec_id'].')" >Pagar</button></td>';
					}else{
						echo '<td ><span>Pagado</span></td>';
					}
					echo '</tr>';
			}
			?>
		</tbody>
	</table>
</div> 
<script src="../js/export/bootstrap-table-export.min.js"></script>
<script src="../js/export/tableExport.min.js"></script>   
<script>
function quierePagar(dni,mec_id){
	var url = "http://www.inscribiteonline.com.ar/empresas/pagar.php?usu_id="+dni+"&mec_id="+mec_id;
	var result = confirm("quiere pagar?");
	if (result == true) {
		location.href = url;
	} 
}
</script> 


    <?php
else:
    echo '<h3>No tiene usuarios inscriptos a sus mensualidades</h3>';
endif;
?>

<?php
require_once dirname(__FILE__) . '/general/footer.php';
