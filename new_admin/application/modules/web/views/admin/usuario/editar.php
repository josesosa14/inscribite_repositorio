<!-- Main content -->
<section class="content">
    <?php
    $atributos = array("id" => "formUsuarios");
    echo form_open("editarUsuario", $atributos);
    ?>
    <input id="cli_id" type="hidden" class="form-control" name="usuario_id" value="0"/>
    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">Usuario</h3>
        </div>
        <div class="box-body">
            <div class="row">
                <div class=" col-md-12">
                    <div class=" col-md-3">
                        <div class="form-group">
                            <label for="">Usuario</label>
                            <input  type="hidden" class="form-control" name="user_id" value="<?= $usuario->getId() ?>" />
                            <input required="true" type="text" class="form-control" name="usuario_nombre" value="<?= $usuario->getNombreUsuario() ?>" />
                        </div>
                    </div>
                    <div class=" col-md-3">
                        <div class="form-group">
                            <label for="">Password</label>
                            <input required="true" type="text" class="form-control" name="usuario_password" value="<?= $this->encryption->decrypt($usuario->getPassword()) ?>" />
                        </div>
                    </div>
                    <div class=" col-md-3">
                        <div class="form-group">
                            <label for="">Apellido</label>
                            <input required="true" type="text" class="form-control" name="persona_apellidos" value="<?= $usuario->getPersona()->getApellidos() ?>" />
                        </div>
                    </div>
                    <div class=" col-md-3">
                        <div class="form-group">
                            <label for="">Nombre</label>
                            <input required="true" type="text" class="form-control" name="persona_nombres" value="<?= $usuario->getPersona()->getNombres() ?>"  />
                        </div>
                    </div>
                    <div class=" col-md-3">
                        <div class="form-group">
                            <label for="">Email</label>
                            <input required="true" type="text" class="form-control" name="usuario_email" value="<?= $usuario->getEmail() ?>"/>
                        </div>
                    </div>
                    <div class=" col-md-2">
                        <div class="form-group">
                            <label for="">Rol</label>
                            <select   class="form-control"  name="usuario_rol">
                                <option disabled selected>Seleccione rol</option>
                                <?php foreach ($roles as $rol): ?>
                                    <option <?= ($rol->getId() == $usuario->getRoles()[0]->getId()) ? "selected" : "" ?> value="<?= $rol->getId() ?>"><?= $rol->getNombre() ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class=" col-md-2">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <div class="checkbox">
                                <label><input id="cli_activo"  type="checkbox" value="1" <?= ( $usuario->getActivo()) ? "checked" : "" ?> name="cli_activo" />¿Esta Activo?</label>
                            </div>
                        </div>
                    </div>
                    <div class=" col-md-2">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <div class="checkbox">
                                <label><input id="vendedor" type="checkbox" value="1" <?= ( $usuario->getPersona()) ? "checked" : "" ?> name="cli_activo" />¿Esta Activo?</label>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <?php if ($edita): ?>
                            <button type="submit" id="guarda"   class="btn btn-primary margen15 pull-right" value="formUsuarios">Guardar</button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php form_close(); ?>
    </section>
