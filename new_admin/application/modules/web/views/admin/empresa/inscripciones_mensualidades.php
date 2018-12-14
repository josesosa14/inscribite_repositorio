<?php
/* @var $empresa Empresa */
?>
<section  class='content mayus' >
    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">Estado Empresa - <?= $empresa->getNombre() ?></h3>
            <button type="button" class="btn btn-box-tool pull-right" data-widget="collapse">
                <i class="fa fa-minus"></i>
            </button>
        </div>
        <div class="box-body">
            <div class="table-responsive">
                <table id="tabla_empresa" data-show-toggle="true" data-toggle="table" data-url="<?= base_url("getEmpresaEventos?emp_id=" . $empresa->getId()) ?>" 
                       data-side-pagination="server" data-search="true" data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]" data-show-refresh="true" 
                       data-cache="false" data-height="auto" data-show-columns="true" data-search-on-enter-key="true" data-search-time-out="750" class="table table-responsive 
                       table-striped" data-page-size="10">
                    <thead>
                        <tr>
                            <th class="col-md-1" data-field="empresa" data-align="left" data-sortable="true">Empresa</th>
                            <th class="col-md-1" data-field="evento" data-align="left" data-sortable="true">Evento</th>
                            <th class="col-md-1" data-field="codigo" data-align="left" data-sortable="true">Código</th>
                            <th class="col-md-1" data-field="decodificado" data-align="left" data-sortable="true">Ingreso bruto</th>
                            <th class="col-md-1" data-field="cobrado" data-align="left" data-sortable="true">Liquidado</th>
                            <th class="col-md-1" data-field="iva_comision" data-align="left" data-sortable="true">Comisión</th>
                            <th class="col-md-1" data-field="saldo" data-align="left" data-sortable="true">Saldo</th>
                            <th class="col-md-1" data-field="acciones" data-align="left">Acciones</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</section>