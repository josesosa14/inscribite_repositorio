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

$query = "SELECT *,(SELECT empresa FROM inscribite_eventos WHERE codigo = fac_evento_id LIMIT 1) as organizador 
FROM facturas_pagas INNER JOIN facturas ON fac_id = facp_fac_id 
INNER JOIN inscribite_usuarios ON id = fac_usu_id 
ORDER BY facp_id DESC LIMIT $from,$to";
$pagos = getArrayQuery($query, $mysqli);

$query = "SELECT *,CASE WHEN fac_tipo > 1 THEN 1 ELSE 0 END as es_mensualidad FROM  facturas INNER JOIN inscribite_usuarios ON id = fac_usu_id WHERE fac_pedido <> 1 AND fac_tipo <> 2 AND fac_tipo <> 3 ORDER BY fac_id DESC";
$facturas = getArrayQuery($query, $mysqli);


//AMD STAFF
/*$es_amd = false;
$amd_dbuser = "aptomedico_user";
$amd_dbpassword = "Urudata25267!";
$amd_dbhost = "localhost";
$amd_dbname = "aptomedico_base";
$amd_db = new mysqli($amd_dbhost, $amd_dbuser, $amd_dbpassword, $amd_dbname);
$query = "SELECT * FROM  facturas WHERE fac_id NOT IN(select facp_fac_id from facturas_pagas) AND fac_tipo = 1 ORDER BY fac_id DESC";
$facturas_amd = getArrayQuery($query, $amd_db);

foreach($facturas_amd as $factura_amd){
	$facturas[] = $factura_amd;
}*/

?>


<?php if ($pagos): ?>
<h3>Pagos registrados</h3>
	<div class="table-responsive">
	<table  class="table table-bordered" 
	data-toggle="table" data-height="auto" 
	data-show-refresh="true" 
	data-show-toggle="true" 
	data-show-export="true"
    data-export-types = "['excel','txt']"
	data-search="true"  data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]" data-page-size="50">
	<thead>
			<tr>
				<th data-sortable="true" data-field="id" data-align="left">Id</th>
				<th data-sortable="true" data-field="sistema" data-align="left">Sistema</th>
				<th data-sortable="true" data-field="creado" data-align="left">Creado</th>
                <th data-sortable="true" data-field="usuario" data-align="left">Usuario</th>
				<th data-sortable="true" data-field="evento" data-align="left" >Evento</th>
				<th data-sortable="true" data-field="cat" data-align="left" >Cat</th>
				<th data-sortable="true" data-field="organizador" data-align="left" >Organizador</th>
				<th data-sortable="true" data-field="moneda" data-align="left">Moneda</th>
				<th data-sortable="true" data-field="monto" data-align="left">Monto</th>
                <th data-sortable="true" data-field="pagado" data-align="left">Pagado</th>
                <th data-sortable="true" data-field="terminal" data-align="left">Terminal</th>
				<th data-sortable="true" data-field="fecha" data-align="left">Fecha</th>
                <th data-sortable="true" data-field="hora" data-align="left">Hora</th>
				<th data-sortable="true" data-field="aviso" data-align="left">Aviso</th>
			</tr>
</thead>
<tbody>
			<?php
			foreach ($pagos as $pago) {
				$mensualidad = null;
				if($pago['fac_evento_id'] ==$pago['fac_cat_id'] ){
				$query = "SELECT mec_nro_cuota,men_codigo,emp_nombre
							FROM facturas
							INNER JOIN facturas_pagas ON facp_fac_id = fac_id
							INNER JOIN inscribite_usuarios ON id = fac_usu_id
							INNER JOIN mensualidad_cuotas ON mec_id = fac_mensualidad
							INNER JOIN mensualidades ON men_id = mec_men_id
							INNER JOIN empresa ON emp_id = men_empresa
							WHERE fac_id = {$pago['facp_fac_id']}
							";

				$mensualidad = getRowQuery($query,$mysqli);
				}
			echo '<tr>
				<td>'.$pago['facp_id'].'</td>                
				<td>Inscribite Online</td>                
				<td>'.date('d/m/Y',strtotime($pago['facp_fecha_in'])).'</td>
                                <td>'.$pago['dni'].' '.$pago['nombre'].' '.$pago['apellido'].'</td>
				<td>'.(($mensualidad)?$mensualidad['men_codigo']:$pago['fac_evento_id']).'</td>
				<td>'.(($mensualidad)?$mensualidad['mec_nro_cuota']:$pago['fac_cat_id']).'</td>
				<td>'.(($mensualidad)?$mensualidad['emp_nombre']:$pago['organizador']).'</td>
				<td>$</td>
				<td>'.number_format($pago['facp_monto'], 2, ',', '.').'</td>
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
    <?php
	
echo '</div>';
else:
    echo '<h3>No tiene archivos facturados</h3>';
endif;
?>


<?php if ($facturas): ?>
<h3>Inscripciones para enviar a PMC</h3>
    <div class="row">
        <form method="post" action="http://www.inscribiteonline.com.ar/newsite2014/argit/pagoMisCuentas/archivoFactura.php" id="formx">
            <table border="1" style="width:100%;text-align:center">
                <tr>
                    <th style="text-align:center">Seleccionar</th>
                    <th style="text-align:center">Id</th>
                    <th style="text-align:center" >Usuario</th>
                    <th style="text-align:center">Evento</th>
                    <th style="text-align:center">Categoria</th>
                    <th style="text-align:center">Opcion</th>            
                    <th style="text-align:center">Vencimiento</th>
                </tr>

                <?php
                foreach ($facturas as $factura) {
					$es_amd = "";
					if($factura['fac_evento_id'] == 5555){
						$es_amd = "_amd";
					}
					
					if($factura['fac_evento_id'] == 0){
						$mensualidad = getRowQuery("SELECT men_codigo,men_nombre,mec_nro_cuota FROM mensualidades INNER JOIN mensualidad_cuotas ON mec_men_id = men_id WHERE mec_id = {$factura['fac_mensualidad']}",$mysqli);
						$factura['fac_evento_id'] = $mensualidad['men_codigo'];
					}
                    echo "<tr>
                <td><input style='visibility:visible' type='checkbox' name='facturas[]' value='$factura[fac_id]$es_amd' /></td>                
                <td>$factura[fac_id]</td>
                <td>$factura[nombre]</td>";
				if($factura['es_mensualidad']){
					echo "<td>$mensualidad[men_nombre]</td>";	
				}else{
					echo "<td>$factura[fac_evento_id]</td>";
				}
			
				if($factura['es_mensualidad']){
					echo "<td>$mensualidad[mec_nro_cuota]</td>";	
				}else{
					echo "<td>$factura[fac_cat_id]</td>";
				}
				echo "
                <td>$factura[fac_op_id]</td>
                <td>$factura[fac_venc3]</td>
				";
                    echo "</tr>";
                }
                ?>
            </table>
            <input type="submit" value="Enviar" />
        </form>
    </div>
    <?php
else:
    echo '<h3>No tiene archivos para facturar</h3>';
endif;
?>
<br><br><br>
<h3>Subir Archivo de Cobranza</h3>
 <div class="row">
	<form method="post" action="/pagoMisCuentas/leerCobranza.php" id="formx" enctype="multipart/form-data">
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

<script src="../js/export/bootstrap-table-export.min.js"></script>
<script src="../js/export/tableExport.min.js"></script>         
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
