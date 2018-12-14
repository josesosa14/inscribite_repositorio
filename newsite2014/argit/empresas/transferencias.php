<?php
$transferencia = "blue";
require_once dirname(__FILE__) . '/../general/header_empresa.php';
echo '</div>';

?>


    <div class="box box-primary">
		<div class="box-header">
			<h3 class="box-title">Liquidaciones Realizadas</h3>
			<button type="button" class="btn btn-box-tool pull-right" data-widget="collapse">
				<i class="fa fa-minus"></i>
			</button>
		</div>
		<div class="box-body">
			<div class="table-responsive">
				<table id="tabla_liquidacion" data-show-toggle="true" data-toggle="table" data-url="http://www.inscribiteonline.com.ar/new_admin/getLiquidacionAjax/<?=$_SESSION['empresa']?>" 
					   data-side-pagination="server" data-search="true" data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]" data-show-refresh="true" 
					   data-cache="false" data-height="auto" data-show-columns="true" data-search-on-enter-key="true" data-search-time-out="750" class="table table-responsive 
					   table-striped" data-page-size="20">
					<thead>
						<tr>
							<th class="col-md-2" data-field="liq_periodo" data-align="left" data-sortable="true">Periodo</th>
							<th class="col-md-3" data-field="liq_cliente" data-align="left" data-sortable="true">Cliente</th>
							<th class="col-md-4" data-field="liq_codigo" data-align="left" data-sortable="true">C&oacute;digo</th>
							<th class="col-md-4" data-field="liq_evento" data-align="left" data-sortable="true">Concepto</th>
							<th class="col-md-1" data-field="liq_total" data-align="left" data-sortable="true">Total</th>
							<th class="col-md-1" data-field="liq_acciones" data-align="left" >Acciones</th>
						</tr>
					</thead>
				</table>
			</div>
		</div>
	</div>
   

<?php
require_once dirname(__FILE__) . '/general/footer.php';
