<section  class='content mayus' >

    <?php if (!isset($solicitudtransferencia)): ?> 

        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Solicitudtransferencias</h3>
                <button type="button" class="btn btn-box-tool pull-right" data-widget="collapse">
                    <i class="fa fa-minus"></i>
                </button>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table id="tabla_solicitudtransferencia" data-show-toggle="true" data-toggle="table" data-url="getSolTransTableAjax" 
                           data-side-pagination="server" data-search="true" data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]" data-show-refresh="true" 
                           data-cache="false" data-height="auto" data-show-columns="true" data-search-on-enter-key="true" data-search-time-out="750" class="table table-responsive 
                           table-striped" data-page-size="20">
                        <thead>
                            <tr>
                                <th class="col-md-1" data-field="str_importe" data-align="left" data-sortable="true">Importe</th>
                                <th class="col-md-1" data-field="emp_nombre" data-align="left" data-sortable="true">Cliente</th>
                                <th class="col-md-1" data-field="sot_pago" data-align="left" data-sortable="true">Número de Pago</th>
                                <th class="col-md-1" data-field="sot_observaciones" data-align="left" data-sortable="true">Observaciones</th>
                                <th class="col-md-1" data-field="acciones" data-align="left" data-formatter="actionFormatter" data-events="actionEvents">Acciones</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <!--<form action="http://localhost/back_inscribite/solicitudtransferencia" method="post" accept-charset="utf-8">-->
    <?php
    $atributos = array("id" => "formSolicitudTransferencia");
    echo form_open("solicitudtransferencia", $atributos);
    ?>
    <div class="row">
        <input id="sot_id" type="hidden" class="form-control" name="sot_id" value="<?php echo (isset($solicitudtransferencia) ? $solicitudtransferencia->getId() : '0'); ?>" />
        <div class="col-md-12">
            <div  class='box box-primary' >
                <div  class='box-header' >
                    <h3 class='box-title'>Solicitud de transferencia</h3></div>

                <div  class='box-body' >
                    <div  class='col-md-3' >
                        <div  class='form-group' >
                            <label>Pago</label>
                            <select id="pagoId" required="true" class='form-control'  name='sot_pago'>
                                <?php if (isset($solicitudtransferencia)): ?>
                                    <option selected="true" value="<?= $solicitudtransferencia->getPago()->getId() ?>"><?= $solicitudtransferencia->getPago()->getId() ?></option>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>
                    <div  class='col-md-9'>
                        <div  class='form-group' >
                            <label>Observaciones</label>
                            <textarea id="sot_observaciones" name="sot_observaciones" class="form_control">
                                <?= isset($solicitudtransferencia) ? $solicitudtransferencia->getObservaciones() : "" ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">Detalles de la transferencia</h3>
                </div>
                <div class="box box-body" style="border-top: none;">
                    <table id="table" class="table_grilla" 
                           <?php if (isset($solicitudtransferencia)): ?>data-url="<?= base_url("renglonesTransferenciaDetalle/" . $solicitudtransferencia->getId()) ?>"
                           <?php else: ?>
                               data-url="<?= base_url("renglonesTransferenciaDetalle") ?>"
                           <?php endif; ?>
                           data-side-pagination="server"
                           data-height="500"
                           data-show-refresh="true"
                           data-search="true">
                        <thead>
                            <tr>
                                <th data-field="forma" data-sortable="true">Forma</th>
                                <th data-field="banco" data-sortable="true">Banco</th>
                                <th data-field="cbu" data-sortable="true">Cbu</th>
                                <th data-field="cuit" data-sortable="true">CUIT</th>
                                <th data-field="importe" data-sortable="true">Importe</th>
                                <th class="col-xs-1" data-sortable="true" data-formatter="formatoBtnBorrar" data-events="btnBorrar">Borrar</th>
                            </tr>
                        </thead>
                    </table>
                    <input type="hidden" value="0" id="control">
                    <!--<div  class='col-md-12 pull-right' >
                        <input  class='btn-sm btn-primary'  type='submit'  value='guardar' ></input>
                    </div>-->
                    <button type="submit" class="btn btn-primary pull-right" onclick="<?php echo (!isset($solicitudtransferencia) ? 'guardar(); return false;' : '') ?>">Guardar</button>
                </div>
            </div>
        </div>
    </div>
    <?php
    echo form_close();
    ?>
</section>
