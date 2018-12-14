<?php
/* @var $empresa Empresa */
?>
<section  class='content mayus' >
    <!--
    El siguiente if es por si el cliente decidió editar una empresa,
    si es así, la pág recibe una empresa y mostraría sólo los datos de edición
    -->
    <?php if (!isset($empresa)): ?>
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Empresas</h3>
                <button type="button" class="btn btn-box-tool pull-right" data-widget="collapse">
                    <i class="fa fa-minus"></i>
                </button>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table id="tabla_empresa" data-show-toggle="true" data-toggle="table" data-url="getEmpresaTableAjax" 
                           data-side-pagination="server" data-search="true" data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]" data-show-refresh="true" 
                           data-cache="false" data-height="auto" data-show-columns="true" data-search-on-enter-key="true" data-search-time-out="750" class="table table-responsive 
                           table-striped" data-page-size="10">
                        <thead>
                            <tr>
                                <th class="col-md-1" data-field="emp_nombre" data-align="left" data-sortable="true">nombre</th>
                                <th class="col-md-1" data-field="emp_cuit" data-align="left" data-sortable="true">cuit</th>
                                <th class="col-md-1" data-field="emp_cond_iva" data-align="left" data-sortable="true">Condición IVA</th>
                                <th class="col-md-1" data-field="emp_mail" data-align="left" data-sortable="true">mail</th>
                                <th class="col-md-1" data-field="emp_domicilio" data-align="left" data-sortable="true">domicilio</th>
                                <th class="col-md-1" data-field="emp_cp" data-align="left" data-sortable="true">código postal</th>
                                <th class="col-md-1" data-field="emp_localidad" data-align="left" data-sortable="true">localidad</th>
                                <th class="col-md-1" data-field="emp_provincia" data-align="left" data-sortable="true">provincia</th>
                                <th class="col-md-1" data-field="emp_usuario" data-align="left" data-sortable="true">usuario</th>
                                <th class="col-md-1" data-field="emp_estado" data-align="left" data-sortable="true">estado</th>
                                <th class="col-md-1" data-field="acciones" data-align="left" data-formatter="actionFormatter" data-events="actionEvents">Acciones</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <?php if (isset($empresa)): ?>
        <?= form_open_multipart("cliente") ?>
        <div  class='box box-primary' >
            <div  class='box-header' >
                <h3 class='box-title'>Empresa</h3></div>

            <div  class='box-body'>
                <div  class='col-md-3'>
                    <div  class='form-group'>
                        <label>Nombre de la empresa</label>
                        <input  class='form-control'  type='text' maxlength="120"  placeholder='Ingrese el nombre'  value='<?= (isset($empresa) ? $empresa->getNombre() : "") ?>'  name='emp_nombre'></input>
                    </div>
                </div>
                <div  class='col-md-3'>
                    <div  class='form-group'>
                        <label>CUIT</label>
                        <input  class='form-control'  type='text' maxlength="11"  placeholder='Ingrese el CUIT'  value='<?= (isset($empresa) ? $empresa->getCuit() : "") ?>'  name='emp_cuit'></input>
                    </div>
                </div>
                <div  class='col-md-3'>
                    <div  class='form-group'>
                        <label>Condición IVA</label>
                        <select class="form-control" name="emp_cond_iva">
                            <?php
                            for ($i = 1; $i <= 8; $i++) {
                                if (isset($empresa) && $empresa->getCondIva() == $i):
                                    ?>
                                    <option value="<?= $arrayNombreCondIvas[$i] ?>" selected><?= $arrayNombreCondIvas[$i] ?></option>
                                <?php else: ?>
                                    <option value="<?= $arrayNombreCondIvas[$i] ?>"><?= $arrayNombreCondIvas[$i] ?></option>
                                <?php
                                endif;
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div  class='col-md-3'>
                    <div  class='form-group'>
                        <label>Email</label>
                        <input  class='form-control'  type='text' maxlength="120"  placeholder='Ingrese el correo electrónico'  value='<?= (isset($empresa) ? $empresa->getMail() : "") ?>'  name='emp_mail'></input>
                    </div>
                </div>
                <div  class='col-md-3'>
                    <div  class='form-group'>
                        <label>Domicilio</label>
                        <input class='form-control'  type='text' maxlength="120" placeholder='Ingrese el domicilio'  value='<?= (isset($empresa) ? $empresa->getDomicilio() : "") ?>'  name='emp_domicilio'></input>
                    </div>
                </div>
                <div  class='col-md-3'>
                    <div  class='form-group' >
                        <label>Código Postal</label>
                        <input class='form-control'  type='text' maxlength="6"  placeholder='Ingrese el código postal'  value='<?= (isset($empresa) ? $empresa->getCodigoPostal() : "") ?>'  name='emp_cp'></input>
                    </div>
                </div>
                <div  class='col-md-3'>
                    <div  class='form-group' >
                        <label>Provincia</label><br>
                        <select class="form-control" id="provincias" name="emp_provincia">
                            <option disabled selected >Seleccione</option>
                            <?php
                            foreach ($provincias as $provincia):
                                if (isset($empresa) && $empresa->getProvincia()):
                                    ?>
                                    <option value="<?= $provincia->getId() ?>" selected><?= utf8_encode($provincia->getNombre()) ?></option>
                                <?php else: ?>
                                    <option value="<?= $provincia->getId() ?>"><?= utf8_encode($provincia->getNombre()) ?></option>
                                <?php
                                endif;
                            endforeach;
                            ?>
                        </select>
                    </div>
                </div>
                <div  class='col-md-3'>
                    <div  class='form-group'>
                        <label>Localidad</label><br>
                        <select class="form-control" id="localidades" name="emp_localidad">
                            <?php if (isset($localidad) && $localidad): ?>
                                <option value="<?= $localidad[0]->getId() ?>"> <?= $localidad[0]->getNombre() ?> </option>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>
                <div  class='col-md-3'>
                    <div  class='form-group'>
                        <label>Nombre de usuario</label>
                        <input class='form-control'  type='text' maxlength="120" placeholder='Ingrese el nombre de usuario'  value='<?= (isset($empresa) ? $empresa->getCodigoPostal() : "") ?>'  name='emp_usuario'></input>
                    </div>
                </div>
                <div  class='col-md-3'>
                    <div  class='form-group'>
                        <label>Contraseña</label>
                        <input class='form-control' maxlength="120" type='text'  placeholder='Ingrese la contraseña'  value='<?= (isset($empresa) ? $empresa->getPassword() : "") ?>'  name='emp_password'></input>
                    </div>
                </div>
                <div  class='col-md-3'>
                    <div  class='form-group'>
                        <label>Comision</label>
                        <input class='form-control'  type='text'  placeholder='0.054'  value='<?= (isset($empresa) ? $empresa->getComisionACobrar() : "") ?>'  name='emp_comision'></input>
                    </div>
                </div>
                <?php if (isset($empresa)): ?>
                    <div  class='col-md-3'>
                        <div  class='form-group'>
                            <label>Estado</label>
                            <select name="emp_estado">
                                <option value="1" selected>Activo</option>
                                <option value="0">Inactivo</option>
                            </select>
                        </div>
                    </div>
                <?php endif; ?>


                <input  class='btn-sm btn-primary pull-right'  type='submit'  value='guardar' /> 
            </div>
        </div>
        <input  type='hidden'  value='<?= (isset($empresa) ? $empresa->getId() : "") ?>'  name='emp_id' ></input>
        <?= form_close() ?>
    <?php endif; ?>

</section>