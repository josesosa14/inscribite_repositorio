<?php
$pagar = "blue";
require_once dirname(__FILE__) . '/general/header_admin.php';
echo '</div>';

if($_SESSION['admin'] == 'inscribite'){

$limit = 50;
$page = filter_input(INPUT_GET,'page');
$page = ($page)?$page:1;
$from = ($page-1)*$limit;
$to = $limit*$page;


$query = "SELECT * FROM  empresa WHERE emp_estado = 1 ORDER BY emp_nombre ASC";
$empresas = getArrayQuery($query, $mysqli);

$query = "SELECT meu_importe,meu_fecha,emp_nombre,CONCAT(nombre,' ',apellido) as nombre,dni,CONCAT(mec_nro_cuota,' (mes ',MONTH(mec_venc_1),')') mec_nro_cuota,mec_id,men_nombre 
			FROM mensualidades			
			inner join mensualidad_usuario meu on men_id = meu.meu_men_id
			INNER JOIN inscribite_usuarios ON dni = meu.meu_u_dni
			inner join mensualidad_cuotas on mec_men_id = men_id
			INNER join facturas on mec_id = fac_mensualidad and fac_usu_id = id
			inner join empresa on emp_id = men_empresa
			left join mensualidad_cuota_usuario meuc on mec_id = meuc.meu_mec_id and dni = meuc.meu_u_dni
			GROUP BY mec_id,men_nombre,mec_nro_cuota,dni,nombre,apellido,emp_nombre,meu_fecha,meu_importe
			ORDER BY men_id,mec_id DESC";
$mensualidades = getArrayQuery($query, $mysqli);
?>

<h3>Mensualidades de usuarios</h3>
<?php if ($mensualidades): ?>
<div class="table-responsive">
	<table  class="table table-bordered table-responsive" 
	data-toggle="table" data-height="auto" 
	data-show-refresh="true" 
	data-show-toggle="true" 
	data-show-export="true"
    data-export-types = "['excel','txt']"
	data-search="true"  data-pagination="true" data-page-list="[50, 100, 800]" data-page-size="50">
		<thead>
			<tr>
				<th data-field="usuario" data-align="left" data-sortable="true">Nombre</th>   
				<th data-field="dni" data-align="left" data-sortable="true">Dni</th>   
				<th data-field="nro_cuota" data-align="left" data-sortable="true">Cuota</th>   
				<th data-field="mensualidad" data-align="left" data-sortable="true">Mensualidad</th>
				<th data-field="empresa" data-align="left" data-sortable="true">Empresa</th>
				<th data-field="importe" data-align="left" data-sortable="true">Importe</th>
				<th data-field="fecha" data-align="left" data-sortable="true">Fecha</th>
				<th data-field="cuota" data-align="left" data-sortable="true">Acciones</th>
			</tr>
		</thead>
		<tbody>
			<?php
			foreach ($mensualidades as $mensualidad) {
				echo '<tr>
					<td>' . $mensualidad['nombre'] . '</td>
					<td>' . $mensualidad['dni'] . '</td>
					<td>' . $mensualidad['mec_nro_cuota'] . '</td>
					<td>' . $mensualidad['men_nombre'] . '</td>
					<td>' . $mensualidad['emp_nombre'] . '</td>
					<td>' . $mensualidad['meu_importe'] . '</td>
					<td>' . (($mensualidad['meu_fecha'])?date('d/m/Y',strtotime($mensualidad['meu_fecha'])):"") . '</td>';
					if(!$mensualidad['meu_fecha']){
						echo '<td ><button onclick="quierePagar('.$mensualidad['dni'].','.$mensualidad['mec_id'].')" >Pagar</button></td>';
					}else{
						echo '<td><span>Pagado</span></td>';
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
	var url = "http://www.inscribiteonline.com.ar/mensualidades/pagar.php?usu_id="+dni+"&mec_id="+mec_id;
	var result = confirm("quiere pagar?");
	if (result == true) {
		location.href = url;
	} 
}
</script>           

 <?php

else:
    echo '<h3>No tiene mensualidades cargadas</h3>';
endif;
?>

<?php

}else{
echo 'No se encuentra logeado, <a href="http://www.inscribiteonline.com.ar/newsite2014/admin/">iniciar sesion</a>';
}
?>

<?php
require_once dirname(__FILE__) . '/general/footer_admin.php';
