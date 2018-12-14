<?php
$pagar = "blue";
require_once dirname(__FILE__) . '/general/header_admin2.php';
echo '</div>';

if($_SESSION['admin'] == 'inscribite'){

$limit = 9999;
$page = filter_input(INPUT_GET,'page');
$page = ($page)?$page:1;
$from = ($page-1)*$limit;
$to = $limit*$page;


$query = "SELECT facp_dni,facp_id,facp_fac_id,i.precio precio,categoria,nombre,apellido,empresa,CASE WHEN pmc >= 2 THEN 0 ELSE deevento END deevento,codigo,opcion,pagoeldia,
facp_avisado,facp_monto,facp_categoria,facp_fecha_aplicacion,precio,i.id as ins_id,i.iniciadoeldia as creado
FROM facturas_rp_pagas 
LEFT JOIN inscribite_inscripciones i ON facp_fac_id = i.id
INNER JOIN inscribite_usuarios ON dni = facp_dni
ORDER BY facp_id DESC LIMIT $from,$to";
$pagos = getArrayQuery($query, $mysqli);


/*$query = "SELECT facp_dni,facp_id,i.precio precio,categoria,nombre,apellido,empresa,deevento,codigo,opcion,pagoeldia,
facp_avisado,facp_monto,facp_categoria,facp_fecha_aplicacion,precio,i.id as ins_id,i.iniciadoeldia as creado,mec_nro_cuota,men_codigo,emp_nombre
FROM inscribite_inscripciones i
INNER JOIN facturas_rp_pagas ON facp_fac_id = i.id
INNER JOIN inscribite_usuarios ON dni = facp_dni
INNER JOIN mensualidad_cuotas ON mec_id = facp_categoria
INNER JOIN mensualidades ON men_id = mec_men_id
INNER JOIN empresa ON emp_id = men_empresa
WHERE deevento = facp_categoria
ORDER BY facp_id DESC LIMIT $from,$to";
$mensualidades = getArrayQuery($query, $mysqli);*/

?>


<?php if ($pagos): ?>
<h3>Facturas de Rapi Pago</h3>
		<div class="table-responsive">
	<table  class="table table-bordered table-responsive" 
	data-toggle="table" data-height="auto" 
	data-show-refresh="true" 
	data-show-toggle="true" 
	data-show-export="true"
    data-export-types = "['excel','txt']"
	data-search="true"  data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]" data-page-size="80">
		<thead>
			<tr>
				<th data-field="id" data-align="left" data-sortable="true">Id</th>
				<th data-field="sistema" data-align="left" data-sortable="true">Sistema</th>
				<th data-field="creado" data-align="left" data-sortable="true">Creado</th>
				<th data-field="usuario" data-align="left" data-sortable="true">Usuario</th>
				<th data-field="evento" data-align="left" data-sortable="true">Evento</th>
				<th data-field="cat" data-align="left" data-sortable="true">Cat</th>
				<th data-field="organizador" data-align="left" data-sortable="true">Organizador</th>
				<th data-field="moneda" data-align="left" data-sortable="true">Moneda</th>
				<th data-field="monto" data-align="left" data-sortable="true">Monto</th>
				<th data-field="pagado" data-align="left" data-sortable="true">Pagado</th>
				<th data-field="terminal" data-align="left" data-sortable="true">Terminal</th>
				<th data-field="fecha" data-align="left" data-sortable="true">Fecha</th>
				<th data-field="hora" data-align="left" data-sortable="true">Hora</th>
				<th data-field="aviso" data-align="left" data-sortable="true">Aviso</th>
			</tr>
			</thead>
			
			<tbody>

			<?php
			foreach ($pagos as $pago) {
				$mensualidad = null;
				if(strlen($pago['deevento'])<2){

				$query = "SELECT mec_nro_cuota,men_codigo,emp_nombre
							FROM facturas
							INNER JOIN inscribite_usuarios ON id = fac_usu_id
							INNER JOIN mensualidad_cuotas ON mec_id = fac_mensualidad
							INNER JOIN mensualidades ON men_id = mec_men_id
							INNER JOIN empresa ON emp_id = men_empresa
							WHERE dni = {$pago['facp_dni']} AND fac_mensualidad = {$pago['facp_categoria']}
							";						

				$mensualidad = getRowQuery($query,$mysqli);
				}
			echo '<tr>
				<td>'.$pago['facp_id'].'</td>                
				<td>Inscribite Online</td>                
				<td>'.date('d/m/Y',strtotime(($pago['creado'])?$pago['creado']:$pago['facp_fecha_aplicacion'])).'</td>
				<td>'.$pago['facp_dni'].' '.$pago['nombre'].' '.$pago['apellido'].'</td>
				<td>'.(($mensualidad['men_codigo'])?$mensualidad['men_codigo']:$pago['deevento']).'</td>
				<td>'.(($mensualidad['mec_nro_cuota'])?$mensualidad['mec_nro_cuota']:$pago['facp_categoria']).'</td>
				<td>'.(($mensualidad['emp_nombre'])?$mensualidad['emp_nombre']:$pago['empresa']).'</td>
				<td>$</td>
				<td>'.number_format( ((($pago['precio'] == 0)?$pago['facp_monto']:$pago['precio'])) , 2, ',', '.').'</td>
				<td>'.number_format($pago['facp_monto'], 2, ',', '.').'</td>
				<td></td>
				<td>'.date('d/m/Y',strtotime($pago['facp_fecha_aplicacion'])).'</td>
				<td>00:00</td>
				<td>'.(($pago['facp_avisado'])?'Si':'No').'</td>
				<!--<td>'.$pago['facp_archivo'].'</td>-->
			';
				echo "</tr>";
			}
		
			?>
			</tbody>
		</table>
		</div>
    <?php

else:
    echo '<h3>No tiene archivos facturados</h3>';
endif;
?>

<script src="../js/export/bootstrap-table-export.min.js"></script>
<script src="../js/export/tableExport.min.js"></script> 


<br><br><br>
<h3>Subir Archivo de Cobranza</h3>
 <div class="row">
	<form method="post" action="rapiPago/leerCobranza.php" id="formx" enctype="multipart/form-data">
		 <div class="col-sm-7 col-md-6">
				<div class="row">
					<div class="select-file">
						<input type="file" name="cobranza" />
					</div>
				</div>                                        
		</div>
		<input type="submit" value="Enviar" />
	</form>
</div>


<script src="../js/jquery.validate.min.js"></script>
<script>
                $(window).load(function() {

                    
					
                    $("#formx").validate({
                        rules: {
                            "facturas[]": {
                                required: true,
                                minlength: 1,
                                
                            }
                        },
                        messages: {
                            "facturas[]": {
                                required:"M&iacute;nimo 1 seleccionado",
                                minlength: "M&iacute;nimo 1 seleccionado",
                                
                            }
                        }
                    });
                });
</script>



<?php

}else{
echo 'No se encuentra logeado, <a href="http://www.inscribiteonline.com.ar/newsite2014/admin/">iniciar sesion</a>';
}

require_once dirname(__FILE__) . '/general/footer.php';
