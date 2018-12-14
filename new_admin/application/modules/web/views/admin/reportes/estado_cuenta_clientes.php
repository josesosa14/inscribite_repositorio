<section  class='content mayus' >
    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">Seleccione la empresa</h3>
            <button type="button" class="btn btn-box-tool pull-right" data-widget="collapse">
                <i class="fa fa-minus"></i>
            </button>
        </div>
        <div class="box-body">
            <div class="col-md-6">
                <div class="form-inline" role="form">
                    <div class="form-group">
                        <select class="form-control" id="fil_cliente">
                            <?php /* @var $cliente Empresa */ ?>
                            <?php foreach ($clientes as $cliente): ?>
                                <option value="<?= $cliente->getId() ?>"><?= $cliente->getNombre() ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <!--<div class="form-group">
                        <select class="form-control" id="fil_eventos" multiple>
                    <?php /* @var $evento Evento */ ?>
                    <?php foreach ($eventos as $evento): ?>
                                        <option value="<?= $evento->getId() ?>"><?= $evento->getNombre() ?></option>
                    <?php endforeach; ?>
                        </select>
                    </div>-->
                    <button id="ok" type="submit" class="btn btn-info">Filtrar</button>
                </div>
            </div>
            <div class="col-md-6" id="estado_cuenta_totales">
                
            </div>
        </div>
    </div>
</section>
<section  class='content mayus' >
    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">Empresas</h3>
            <button type="button" class="btn btn-box-tool pull-right" data-widget="collapse">
                <i class="fa fa-minus"></i>
            </button>
        </div>
        <div class="box-body">
            <div class="table-responsive">
                <table id="tabla_reporte" data-show-toggle="true" data-toggle="table" data-url="<?= base_url("reporte-estado-cuenta-cliente-ajax") ?>" 
                       data-side-pagination="server" data-search="true" data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]" data-show-refresh="true" 
                       data-cache="false" data-height="auto" data-query-params="queryParams" data-show-columns="true" data-search-on-enter-key="true" data-search-time-out="750" class="table table-responsive 
                       table-striped" data-page-size="10">
                    <thead>
                        <tr>
                            <th class="col-md-1" data-field="codigo" data-align="left" data-sortable="true">Cod</th>
                            <th class="col-md-3" data-field="nombre" data-align="left" data-sortable="true">Evento</th>
                            <th class="col-md-3" data-field="cliente" data-align="left" data-sortable="true">Cliente</th>
                            <th class="col-md-2" data-field="importe" data-align="left" data-sortable="true">Importe</th>
                            <th class="col-md-3" data-field="tipo" data-align="left" data-sortable="true">Estado</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</section>