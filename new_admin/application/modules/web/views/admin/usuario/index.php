<!-- Main content -->
<section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-body">
                    <table data-toggle="table"
                           data-classes="table table-hover table-condensed"
                           data-search="true"
                           data-search="true"
                           data-pagination="true"
                           data-page-list="[5, 10, 20, 50, 100, 200]"
                           data-show-refresh="true"
                           data-show-columns="true"
                           data-page-size="20"
                           data-striped="true">
                        <thead>
                            <tr>
                                <th data-field="nombre" data-sortable="true">Nick</th>
                                <th data-field="descripcion" data-sortable="true">Nombre y Apellido</th>
                                <th data-field="email" data-sortable="true">E-mail</th>
                                <th data-field="ultimoIngreso" data-sortable="true">Ultimo ingreso</th>
                                <th data-field="fechaCreacion" data-sortable="true">Fecha creación</th>
                                <th data-field="rol" data-sortable="true">Rol</th>
                                <th data-field="activo" data-sortable="true">Activo</th>
                                <th data-field="acciones" data-sortable="true">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $contador = 1;
                            if (isset($usuarios)) {
                                foreach ($usuarios as $usuario) {
                                    echo '<tr>';
                                    echo '<td>' . $usuario->getNombreUsuario() . '</td>';
                                    echo '<td> ' . ucfirst($usuario->getPersona()->getApellidos()) . " " . ucfirst($usuario->getPersona()->getNombres()) . '</td>';
                                    echo '<td>' . $usuario->getEmail() . '</td>';
                                    echo '<td> ' . $usuario->getLastLogin() . '</td>';
                                    echo '<td> ' . $usuario->getFechaCreacion() . '</td>';
                                    echo '<td>' . $usuario->getRoles()[0]->getNombre() . '</td>';
                                    echo '<td>' . (($usuario->getActivo() == 1) ? "SI" : "NO") . '</td>';
                                    echo '<td class="col-md-1">

                                <a id="' . $usuario->getId() . '" class="editarUSuario" href="editarUsuario/' . $usuario->getId() . '"><i class="fa fa-edit"></i></a>

                            </td>';
                                    echo '</tr>';
                                    $contador++;
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <?php
    $atributos = array("id" => "formUsuarios");
    echo form_open("usuarios", $atributos);
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
                            <input required="true" type="text" class="form-control" name="usuario_nombre" />
                        </div>
                    </div>
                    <div class=" col-md-3">
                        <div class="form-group">
                            <label for="">Password</label>
                            <input required="true" type="text" class="form-control" name="usuario_password" />
                        </div>
                    </div>
                    <div class=" col-md-3">
                        <div class="form-group">
                            <label for="">Apellido</label>
                            <input required="true" type="text" class="form-control" name="persona_apellidos" />
                        </div>
                    </div>
                    <div class=" col-md-3">
                        <div class="form-group">
                            <label for="">Nombre</label>
                            <input required="true" type="text" class="form-control" name="persona_nombres" />
                        </div>
                    </div>
                    <div class=" col-md-3">
                        <div class="form-group">
                            <label for="">Email</label>
                            <input required="true" type="text" class="form-control" name="usuario_email" />
                        </div>
                    </div>
                    <div class=" col-md-2">
                        <div class="form-group">
                            <label for="">Rol</label>
                            <select   class="form-control"  name="usuario_rol">
                                <option disabled selected>Seleccione rol</option>
                                <?php foreach ($roles as $rol): ?>
                                    <option value="<?= $rol->getId() ?>"><?= $rol->getNombre() ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class=" col-md-2">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <div class="checkbox">
                                <label><input id="cli_activo"  type="checkbox" value="1" name="cli_activo" />¿Esta Activo?</label>
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
