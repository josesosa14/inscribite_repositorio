<section  class='content mayus' >
    <?php if (!isset($liquidacion)): ?> 
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Liquidaciones</h3>
                <button type="button" class="btn btn-box-tool pull-right" data-widget="collapse">
                    <i class="fa fa-minus"></i>
                </button>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table id="tabla_liquidacion" data-show-toggle="true" data-toggle="table" data-url="getLiquidacionAjax" 
                           data-side-pagination="server" data-search="true" data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]" data-show-refresh="true" 
                           data-cache="false" data-height="auto" data-show-columns="true" data-search-on-enter-key="true" data-search-time-out="750" class="table table-responsive 
                           table-striped" data-page-size="20">
                        <thead>
                            <tr>
                                <th class="col-md-1" data-field="liq_fecha" data-align="left" data-sortable="true">Carga</th>
                                <th class="col-md-2" data-field="liq_periodo" data-align="left" data-sortable="true">Periodo</th>
                                <th class="col-md-3" data-field="liq_cliente" data-align="left" data-sortable="true">Cliente</th>
                                <th class="col-md-4" data-field="liq_evento" data-align="left" data-sortable="true">Concepto</th>
                                <th class="col-md-1" data-field="liq_total" data-align="left" data-sortable="true">Total</th>
                                <th class="col-md-1" data-field="liq_cant_registros" data-align="left" data-sortable="true">Registros</th>
                                <th class="col-md-1" data-field="liq_acciones" data-align="left" >Acciones</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <?php /* @var $liquidacion Liquidacion */ ?>
    <?php /* @var $cliente Empresa */ ?>
    <?php /* @var $evento Evento */ ?>
    <?= form_open("liquidacion") ?>

    <div  class='box box-primary' >
        <div  class='box-header' >
            <h3 class='box-title'>Liquidacion</h3></div>

        <div  class='box-body' >
            <div  class='col-md-3' >
                <div  class='form-group' >
                    <label >Hasta</label>
                    <input  class='form-control'  type='date'  placeholder='ingresefecha'  value='<?= (isset($liquidacion) ? $liquidacion->getFecha_hasta()->format("d/m/Y") : "") ?>'  name='liq_fecha_hasta' ></input>
                </div>
            </div>
            <div  class='col-md-12 pull-right' >
                <input  class='btn-sm btn-primary pull-right'  type='submit'  value='guardar' ></input>
            </div>
        </div>
    </div>
    <input  type='hidden'  value='<?= (isset($liquidacion) ? $liquidacion->getId() : "") ?>'  name='liq_id' ></input>
    <?= form_close() ?>
</section>
