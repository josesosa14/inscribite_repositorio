
<section  class='content mayus' >
    <?php $this->load->view("admin/general/estado_cuenta") ?>
    <?php if (!isset($cobro)): ?> 

        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Cobros</h3>
                <button type="button" class="btn btn-box-tool pull-right" data-widget="collapse">
                    <i class="fa fa-minus"></i>
                </button>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table id="tabla_cobro" data-show-toggle="true" data-toggle="table" data-url="getCobroAjax" 
                           data-side-pagination="server" data-search="true" data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]" data-show-refresh="true" 
                           data-cache="false" data-height="auto" data-show-columns="true" data-search-on-enter-key="true" data-search-time-out="750" class="table table-responsive 
                           table-striped" data-page-size="20">
                        <thead>
                            <tr>
                                <th class="col-md-1" data-field="cob_fecha" data-align="left" data-sortable="true">Fecha</th>
                                <th class="col-md-1" data-field="cob_cantregistros" data-align="left" data-sortable="true">Cant Registros</th>
                                <th class="col-md-1" data-field="cob_importe" data-align="left" data-sortable="true">Total</th>
                                <th class="col-md-1" data-field="cob_neto" data-align="left" data-sortable="true">Neto</th>
                                <th class="col-md-1" data-field="cob_comisiones" data-align="left" data-sortable="true">Comisiones</th>
                                <th class="col-md-1" data-field="cob_iva" data-align="left" data-sortable="true">Iva</th>
                                <th class="col-md-1" data-field="cob_diferencia" data-align="left" data-sortable="true">Diferencia</th>
                                <th class="col-md-1" data-field="cob_mediopago" data-align="left" data-sortable="true">Medio</th>
                                <th class="col-md-1" data-field="cob_cant_pagos" data-align="left" data-sortable="true">Cant. Pagos</th>
                                <th class="col-md-1" data-field="acciones" data-align="left" >Acciones</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    <?php endif; ?>



    <?= form_open_multipart("cobro") ?>
    <div  class='box box-primary' >
        <div  class='box-header' >
            <h3 class='box-title'>Cobro</h3></div>

        <div  class='box-body' >
            <div  class='col-md-2' >
                <div  class='form-group' >
                    <label >mediopago</label>

                    <select  class='form-control'  name='cob_mediopago' >
                        <option value='pf' >Pago Fácil</option>
                        <option value='rp' >Rapi Pago</option>
                        <option value='pmc' >Pago Mis Cuentas</option>
                    </select>
                </div>
            </div>
            <div  class='col-md-2' >
                <div  class='form-group' >
                    <label >fecha</label>
                    <input  class='form-control'  type='date'  placeholder='ingresefecha'  value='<?= (isset($cobro) ? $cobro->getFecha() : "") ?>'  name='cob_fecha' ></input>
                </div>
            </div>
            
            <div  class='col-md-2' >
                <div  class='form-group' >
                    <label >neto</label>
                    <input  class='form-control'  type='text'  placeholder='ingreseimporte'  value='<?= (isset($cobro) ? $cobro->getImporte() : "") ?>'  name='cob_importe' ></input>
                </div>
            </div>
            <div  class='col-md-2' >
                <div  class='form-group' >
                    <label >retenciones</label>
                    <input  class='form-control'  type='text'  placeholder='ingreseretenciones'  value='<?= (isset($cobro) ? $cobro->getRetenciones() : "") ?>'  name='cob_retenciones' ></input>
                </div>
            </div>
            <div  class='col-md-2' >
                <div  class='form-group' >
                    <label >ajustes</label>

                    <input  class='form-control'  type='text'  placeholder='ingreseajustes'  value='<?= (isset($cobro) ? $cobro->getAjustes() : "") ?>'  name='cob_ajustes' ></input>
                </div>
            </div>
            <div  class='col-md-12 pull-right' >
                <input  class='btn-sm btn-primary'  type='submit'  value='guardar' ></input>
            </div>
        </div>
    </div>
    <input  type='hidden'  value='<?= (isset($cobro) ? $cobro->getId() : "") ?>'  name='cob_id' ></input>
    <?= form_close() ?>
</section>
