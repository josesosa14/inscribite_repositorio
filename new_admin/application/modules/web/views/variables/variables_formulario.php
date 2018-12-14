<section  class='content mayus' >

    <?php if (!isset($variables)): ?> 

        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Variabless</h3>
                <button type="button" class="btn btn-box-tool pull-right" data-widget="collapse">
                    <i class="fa fa-minus"></i>
                </button>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table id="tabla_variables" data-show-toggle="true" data-toggle="table" data-url="getVariablesAjax" 
                           data-side-pagination="server" data-search="true" data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]" data-show-refresh="true" 
                           data-cache="false" data-height="auto" data-show-columns="true" data-search-on-enter-key="true" data-search-time-out="750" class="table table-responsive 
                           table-striped" data-page-size="20">
                        <thead>
                            <tr>
                                <th class="col-md-1" data-field="var_porc_comision_rp" data-align="left" data-sortable="true">var_porc_comision_rp</th>
                                <th class="col-md-1" data-field="var_porc_comision_pf" data-align="left" data-sortable="true">var_porc_comision_pf</th>
                                <th class="col-md-1" data-field="var_porc_comision_pmc" data-align="left" data-sortable="true">var_porc_comision_pmc</th>
                                <th class="col-md-1" data-field="var_porc_efectivo_rp" data-align="left" data-sortable="true">var_porc_efectivo_rp</th>
                                <th class="col-md-1" data-field="var_porc_efectivo_pf" data-align="left" data-sortable="true">var_porc_efectivo_pf</th>
                                <th class="col-md-1" data-field="var_porc_efectivo_pmc" data-align="left" data-sortable="true">var_porc_efectivo_pmc</th>
                                <th class="col-md-1" data-field="var_porc_iva" data-align="left" data-sortable="true">var_porc_iva</th>
                                <th class="col-md-1" data-field="acciones" data-align="left" data-formatter="actionFormatter" data-events="actionEvents">Acciones</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <?php if (isset($variables)): ?> 
        <?= form_open("variables") ?>

        <div  class='box box-primary' >
            <div  class='box-header' >
                <h3 class='box-title'>Variables</h3></div>

            <div  class='box-body' >
                <div  class='col-md-3' >
                    <div  class='form-group' >
                        <label >porc_comision_rp</label>

                        <input  class='form-control'  type='text'  placeholder='ingreseporc_comision_rp'  value='<?= (isset($variables) ? $variables->getPorc_comision_rp() : "") ?>'  name='var_porc_comision_rp' ></input>
                    </div>
                </div>
                <div  class='col-md-3' >
                    <div  class='form-group' >
                        <label >porc_comision_pf</label>

                        <input  class='form-control'  type='text'  placeholder='ingreseporc_comision_pf'  value='<?= (isset($variables) ? $variables->getPorc_comision_pf() : "") ?>'  name='var_porc_comision_pf' ></input>
                    </div>
                </div>
                <div  class='col-md-3' >
                    <div  class='form-group' >
                        <label >porc_comision_pmc</label>

                        <input  class='form-control'  type='text'  placeholder='ingreseporc_comision_pmc'  value='<?= (isset($variables) ? $variables->getPorc_comision_pmc() : "") ?>'  name='var_porc_comision_pmc' ></input>
                    </div>
                </div>
                <div  class='col-md-3' >
                    <div  class='form-group' >
                        <label >porc_efectivo_rp</label>

                        <input  class='form-control'  type='text'  placeholder='ingreseporc_efectivo_rp'  value='<?= (isset($variables) ? $variables->getPorc_efectivo_rp() : "") ?>'  name='var_porc_efectivo_rp' ></input>
                    </div>
                </div>
                <div  class='col-md-3' >
                    <div  class='form-group' >
                        <label >porc_efectivo_pf</label>

                        <input  class='form-control'  type='text'  placeholder='ingreseporc_efectivo_pf'  value='<?= (isset($variables) ? $variables->getPorc_efectivo_pf() : "") ?>'  name='var_porc_efectivo_pf' ></input>
                    </div>
                </div>
                <div  class='col-md-3' >
                    <div  class='form-group' >
                        <label >porc_efectivo_pmc</label>

                        <input  class='form-control'  type='text'  placeholder='ingreseporc_efectivo_pmc'  value='<?= (isset($variables) ? $variables->getPorc_efectivo_pmc() : "") ?>'  name='var_porc_efectivo_pmc' ></input>
                    </div>
                </div>
                <div  class='col-md-3' >
                    <div  class='form-group' >
                        <label >porc_iva</label>

                        <input  class='form-control'  type='text'  placeholder='ingreseporc_iva'  value='<?= (isset($variables) ? $variables->getPorc_iva() : "") ?>'  name='var_porc_iva' ></input>
                    </div>
                </div>
                <div  class='col-md-12 pull-right' >
                    <input  class='btn-sm btn-primary'  type='submit'  value='guardar' ></input>
                </div>
            </div>
        </div>
        <input  type='hidden'  value='<?= (isset($variables) ? $variables->getId() : "") ?>'  name='var_id' ></input>
        <?= form_close() ?>
    <?php endif; ?>
</section>
