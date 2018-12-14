<section  class='content mayus' >

    <?php if (!isset($user)): ?> 

        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Users</h3>
                <button type="button" class="btn btn-box-tool pull-right" data-widget="collapse">
                    <i class="fa fa-minus"></i>
                </button>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table id="tabla_user" data-show-toggle="true" data-toggle="table" data-url="getUserAjax" 
                           data-side-pagination="server" data-search="true" data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]" data-show-refresh="true" 
                           data-cache="false" data-height="auto" data-show-columns="true" data-search-on-enter-key="true" data-search-time-out="750" class="table table-responsive 
                           table-striped" data-page-size="20">
                        <thead>
                            <tr>
                                <th class="col-md-1" data-field="usr_nombre" data-align="left" data-sortable="true">Usuario</th>
                                <th class="col-md-1" data-field="usr_email" data-align="left" data-sortable="true">Email</th>
                                <th class="col-md-1 no_transform" data-field="usr_clave" data-align="left" data-sortable="true">Clave</th>
                                <th class="col-md-1" data-field="usr_telefono" data-align="left" data-sortable="true">Teléfono</th>
                                <th class="col-md-1" data-field="usr_direccion_completa" data-align="left" data-sortable="true">Dirección</th>
                                <th class="col-md-1" data-field="usr_last_logeo" data-align="left" data-sortable="true">Último acceso</th>
                                <th class="col-md-1" data-field="usr_activo" data-align="left" data-sortable="true">Activo</th>
                                <th class="col-md-1" data-field="acciones" data-align="left" data-formatter="actionFormatter" data-events="actionEvents">Acciones</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <form action="http://localhost/wine_fwk/user" method="post" accept-charset="utf-8">
        <div  class='box box-primary' ><div  class='box-header' ><h3 class='box-title'>User</h3></div>

            <div  class='box-body' ><div  class='row' >
                    <div  class='col-md-3' ><div  class='form-group' ><label >nombre</label>
                            <input  class='form-control'  type='text'  placeholder='ingresenombre'  value='<?= (isset($user) ? $user->getNombre() : "") ?>'  name='usr_nombre' ></input>
                        </div>
                    </div>
                    <div  class='col-md-3' ><div  class='form-group' ><label >fbid</label>
                            <input  class='form-control'  type='text'  placeholder='ingresefbid'  value='<?= (isset($user) ? $user->getFbid() : "") ?>'  name='usr_fbid' ></input>
                        </div>
                    </div>
                    <div  class='col-md-3' ><div  class='form-group' ><label >fbuser</label>
                            <input  class='form-control'  type='text'  placeholder='ingresefbuser'  value='<?= (isset($user) ? $user->getFbuser() : "") ?>'  name='usr_fbuser' ></input>
                        </div>
                    </div>
                    <div  class='col-md-3' ><div  class='form-group' ><label >email</label>
                            <input  class='form-control'  type='text'  placeholder='ingreseemail'  value='<?= (isset($user) ? $user->getEmail() : "") ?>'  name='usr_email' ></input>
                        </div>
                    </div>
                    <div  class='col-md-3' ><div  class='form-group' ><label >clave</label>
                            <input  class='form-control'  type='text'  placeholder='ingreseclave'  value='<?= (isset($user) ? $user->getClave() : "") ?>'  name='usr_clave' ></input>
                        </div>
                    </div>
                    <div  class='col-md-3' ><div  class='form-group' ><label >telefono</label>
                            <input  class='form-control'  type='text'  placeholder='ingresetelefono'  value='<?= (isset($user) ? $user->getTelefono() : "") ?>'  name='usr_telefono' ></input>
                        </div>
                    </div>
                    <div  class='col-md-3' ><div  class='form-group' ><label >direccion</label>
                            <input  class='form-control'  type='text'  placeholder='ingresedireccion'  value='<?= (isset($user) ? $user->getDireccion() : "") ?>'  name='usr_direccion' ></input>
                        </div>
                    </div>
                    <div  class='col-md-3' ><div  class='form-group' ><label >barrio</label>
                            <input  class='form-control'  type='text'  placeholder='ingresebarrio'  value='<?= (isset($user) ? $user->getBarrio() : "") ?>'  name='usr_barrio' ></input>
                        </div>
                    </div>
                    <div  class='col-md-3' ><div  class='form-group' ><label >localidad</label>
                            <input  class='form-control'  type='text'  placeholder='ingreselocalidad'  value='<?= (isset($user) ? $user->getLocalidad() : "") ?>'  name='usr_localidad' ></input>
                        </div>
                    </div>
                    <div  class='col-md-3' ><div  class='form-group' ><label >horario_entrega</label>
                            <input  class='form-control'  type='text'  placeholder='ingresehorario_entrega'  value='<?= (isset($user) ? $user->getHorario_entrega() : "") ?>'  name='usr_horario_entrega' ></input>
                        </div>
                    </div>
                    <div  class='col-md-3' ><div  class='form-group' ><label >direccion_secundaria</label>
                            <input  class='form-control'  type='text'  placeholder='ingresedireccion_secundaria'  value='<?= (isset($user) ? $user->getDireccion_secundaria() : "") ?>'  name='usr_direccion_secundaria' ></input>
                        </div>
                    </div>
                    <div  class='col-md-3' ><div  class='form-group' ><label >fecha_in</label>
                            <input  class='form-control'  type='text'  placeholder='ingresefecha_in'  value='<?= (isset($user) ? $user->getFecha_in() : "") ?>'  name='usr_fecha_in' ></input>
                        </div>
                    </div>
                    <div  class='col-md-3' ><div  class='form-group' ><label >cant_logeo</label>
                            <input  class='form-control'  type='text'  placeholder='ingresecant_logeo'  value='<?= (isset($user) ? $user->getCant_logeo() : "") ?>'  name='usr_cant_logeo' ></input>
                        </div>
                    </div>
                    <div  class='col-md-3' ><div  class='form-group' ><label >last_logeo</label>
                            <input  class='form-control'  type='text'  placeholder='ingreselast_logeo'  value='<?= (isset($user) ? $user->getLast_logeo() : "") ?>'  name='usr_last_logeo' ></input>
                        </div>
                    </div>
                    <div  class='col-md-3' ><div  class='form-group' ><label >activo </label>
                            <input  class='form-group'  type='checkbox'  value='1' <?= (isset($user) && $user->getActivo() ? "checked" : "") ?>  name='usr_activo' >si</input>
                        </div>
                    </div>
                    <div  class='col-md-12 pull-right' ><input  class='btn-sm btn-primary'  type='submit'  value='guardar' ></input>
                    </div>
                </div>
            </div>
        </div>
        <input  type='hidden'  value='<?= (isset($user) ? $user->getId() : "") ?>'  name='usr_id' ></input>
    </form>
</section>
