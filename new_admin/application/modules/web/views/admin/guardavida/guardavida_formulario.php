<section  class='content mayus' >
    <?php if (!isset($guardavida)): ?> 
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Guardavida cargados</h3>
                <button type="button" class="btn btn-box-tool pull-right" data-widget="collapse">
                    <i class="fa fa-minus"></i>
                </button>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table id="tabla_consorcio" data-show-toggle="true" data-toggle="table" data-url="getGuardavidaAjax" 
                           data-side-pagination="server" data-search="true" data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]" data-show-refresh="true" 
                           data-cache="false" data-height="auto" data-show-columns="true"  data-search-time-out="750" 
                           class="table table-responsive table-striped" data-page-size="20">
                        <thead>
                            <tr>
                                <th class="col-md-1" data-field="email" data-align="left" data-sortable="true">email</th>
                                <th class="col-md-1" data-field="nombre" data-align="left" data-sortable="true">nombre</th>
                                <th class="col-md-1" data-field="apellido" data-align="left" data-sortable="true">apellido</th>
                                <th class="col-md-1" data-field="dni" data-align="left" data-sortable="true">dni</th>
                                <th class="col-md-1" data-field="domicilio" data-align="left" data-sortable="true">domicilio</th>
                                <th class="col-md-1" data-field="provincia" data-align="left" data-sortable="true">provincia</th>
                                <th class="col-md-1" data-field="localidad" data-align="left" data-sortable="true">localidad</th>
                                <th class="col-md-1" data-field="codpostal" data-align="left" data-sortable="true">codpostal</th>
                                <th class="col-md-1" data-field="telfijo" data-align="left" data-sortable="true">telfijo</th>
                                <th class="col-md-1" data-field="telcelular" data-align="left" data-sortable="true">telcelular</th>
                                <th class="col-md-1" data-field="foto" data-align="left" data-sortable="true">foto</th>
                                <th class="col-md-1" data-field="password" data-align="left" data-sortable="true">password</th>
                                <th class="col-md-1" data-field="nosconocio" data-align="left" data-sortable="true">nosconocio</th>
                                <th class="col-md-1" data-field="tipousuario" data-align="left" data-sortable="true">tipousuario</th>
                                <th class="col-md-1" data-field="acciones" data-align="left">Acciones</th>

                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <button type="button" <?= isset($guardavida) ? "style='display:none'" : "" ?> class="btn btn-success" onclick="$('#form_guardavida').show()" >Nuevo Guardavida</button>
    <?= form_open_multipart(base_url("admin-guardavida")) ?>
    <div  class='box box-primary' id="form_guardavida" <?= !isset($guardavida) ? "style='display:none'" : "" ?>>
        <div  class='box-header' >
            <h3 class='box-title'><?= isset($guardavida) ? "Editar" : "Nuevo" ?> Guardavida</h3>
        </div>
        <div  class='box-body' >
            <div  class='col-md-3' >
                <div  class='form-group' >
                    <label >nombre</label>

                    <input  class='form-control'  type='text'  value='<?= (isset($guardavida) ? $guardavida->getNombre() : "") ?>'  name='gua_nombre' ></input>

                </div>

            </div>
            <div  class='col-md-3' >
                <div  class='form-group' >
                    <label >apellido</label>

                    <input  class='form-control'  type='text'  value='<?= (isset($guardavida) ? $guardavida->getApellido() : "") ?>'  name='gua_apellido' ></input>

                </div>

            </div>
            <div  class='col-md-3' >
                <div  class='form-group' >
                    <label >dni</label>

                    <input  class='form-control'  type='text'  value='<?= (isset($guardavida) ? $guardavida->getDni() : "") ?>'  name='gua_dni' ></input>

                </div>

            </div>
            <div  class='col-md-3' >
                <div  class='form-group' >
                    <label >domicilio</label>

                    <input  class='form-control'  type='text'  value='<?= (isset($guardavida) ? $guardavida->getDomicilio() : "") ?>'  name='gua_domicilio' ></input>

                </div>

            </div>
            <div  class='col-md-3' >
                <div  class='form-group' >
                    <label >provincia</label>

                    <input  class='form-control'  type='text'  value='<?= (isset($guardavida) ? $guardavida->getProvincia() : "") ?>'  name='gua_provincia' ></input>

                </div>

            </div>
            <div  class='col-md-3' >
                <div  class='form-group' >
                    <label >localidad</label>

                    <input  class='form-control'  type='text'  value='<?= (isset($guardavida) ? $guardavida->getLocalidad() : "") ?>'  name='gua_localidad' ></input>

                </div>

            </div>
            <div  class='col-md-3' >
                <div  class='form-group' >
                    <label >codpostal</label>

                    <input  class='form-control'  type='text'  value='<?= (isset($guardavida) ? $guardavida->getCodpostal() : "") ?>'  name='gua_codpostal' ></input>

                </div>

            </div>
            <div  class='col-md-3' >
                <div  class='form-group' >
                    <label >telfijo</label>

                    <input  class='form-control'  type='text'  value='<?= (isset($guardavida) ? $guardavida->getTelfijo() : "") ?>'  name='gua_telfijo' ></input>

                </div>

            </div>
            <div  class='col-md-3' >
                <div  class='form-group' >
                    <label >telcelular</label>

                    <input  class='form-control'  type='text'  value='<?= (isset($guardavida) ? $guardavida->getTelcelular() : "") ?>'  name='gua_telcelular' ></input>

                </div>

            </div>
            <div  class='col-md-3' >
                <div  class='form-group' >
                    <label >foto</label>

                    <input  class='form-control'  type='file'  value='<?= (isset($guardavida) ? $guardavida->getFoto() : "") ?>'  name='gua_foto' ></input>

                </div>

            </div>
            <div  class='col-md-3' >
                <div  class='form-group' >
                    <label >email</label>

                    <input  class='form-control'  type='text'  value='<?= (isset($guardavida) ? $guardavida->getEmail() : "") ?>'  name='gua_email' ></input>

                </div>

            </div>
            <div  class='col-md-3' >
                <div  class='form-group' >
                    <label >password</label>

                    <input  class='form-control'  type='text'  value='<?= (isset($guardavida) ? $guardavida->getPassword() : "") ?>'  name='gua_password' ></input>

                </div>

            </div>
            <div  class='col-md-3' >
                <div  class='form-group' >
                    <label >nosconocio</label>

                    <input  class='form-control'  type='text'  value='<?= (isset($guardavida) ? $guardavida->getNosconocio() : "") ?>'  name='gua_nosconocio' ></input>

                </div>

            </div>
            <div  class='col-md-3' >
                <div  class='form-group' >
                    <label >tipousuario</label>

                    <select  class='form-control'  name='gua_tipousuario' ><option  selected='true'  value='interesado' >interesado</option>
                        <option  value='aspirante' >aspirante</option>
                        <option  value='egresado' >egresado</option>
                        <option  value='guardavida' >guardavida</option>
                    </select>

                </div>

            </div>

            
        </div>
    </div>
    <?php $this->load->view("admin/guardavida/atributos")?>
    <div  class='col-md-12 pull-right' ><input  class='btn-sm btn-primary pull-right'  type='submit'  value='guardar' />            </div>
    <input  type='hidden'  value='<?= (isset($guardavida) ? $guardavida->getId() : "") ?>'  name='gua_id' ></input>
    <?= form_close() ?>
</section>
