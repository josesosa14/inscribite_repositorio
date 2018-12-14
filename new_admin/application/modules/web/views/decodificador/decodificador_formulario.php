<section  class='content mayus' >

    <?php if (!isset($decodificador)): ?> 

        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Decodificadors</h3>
                SYNC DATA:
                <a href="<?= base_url("sync_db") ?>" target="_BLANK" >Sync</a>
                ACUMULADOS:
                <a href="<?= base_url("xls_acumulado/pf") ?>" target="_BLANK" >PF</a>
                /
                <a href="<?= base_url("xls_acumulado/rp") ?>" target="_BLANK" >RP</a>
                /
                <a href="<?= base_url("xls_acumulado/pmc") ?>" target="_BLANK" >PMC</a>

                <button type="button" class="btn btn-box-tool pull-right" data-widget="collapse">
                    <i class="fa fa-minus"></i>
                </button>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table id="tabla_decodificador" data-show-toggle="true" data-toggle="table" data-url="getDecodificadorAjax" 
                           data-side-pagination="server" data-search="true" data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]" data-show-refresh="true" 
                           data-cache="false" data-height="auto" data-show-columns="true" data-search-on-enter-key="true" data-search-time-out="750" class="table table-responsive 
                           table-striped" data-page-size="20">
                        <thead>
                            <tr>
                                <th class="col-md-3" data-field="dec_pagofacil" data-align="left" data-sortable="true">PFC</th>
                                <th class="col-md-3" data-field="dec_pagofacilinterior" data-align="left" data-sortable="true">PFI</th>
                                <th class="col-md-3" data-field="dec_rapipago" data-align="left" data-sortable="true">Rapi Pago</th>
                                <th class="col-md-3" data-field="dec_pagomiscuentas" data-align="left" data-sortable="true">Pago Mis Cuentas</th>
                                <th class="col-md-2" data-field="dec_observaciones" data-align="left" data-sortable="true">Observaciones</th>
                                <th class="col-md-1" data-field="acciones" data-align="left" >Acciones</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <?= form_open_multipart("decodificador") ?>
    <div  class='box box-primary' >
        <div  class='box-header' >
            <h3 class='box-title'>Decodificador</h3></div>

        <div  class='box-body' >
            <div  class='col-md-3' >
                <div  class='form-group' >
                    <label >Archivos a decodificar</label>
                    <input type="file" multiple="" name="archivos[]" class="form-control"/>
                </div>
            </div>
            <div  class='col-md-3' >
                <div  class='form-group' >
                    <label >observaciones</label>

                    <input  class='form-control'  type='text'  placeholder='ingreseobservaciones'  value='<?= (isset($decodificador) ? $decodificador->getObservaciones() : "") ?>'  name='dec_observaciones' ></input>
                </div>
            </div>
            <div  class='col-md-1' >
                <div class="form-group">
                    <label>&nbsp;</label>
                    <input  class='btn-sm btn-primary form-control'  type='submit'  value='guardar' ></input>
                </div>
            </div>
        </div>
    </div>
    <input  type='hidden'  value='<?= (isset($decodificador) ? $decodificador->getId() : "") ?>'  name='dec_id' ></input>
    <?= form_close() ?>
</section>
