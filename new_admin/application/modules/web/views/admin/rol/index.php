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
                           data-striped="true">
                        <thead>
                            <tr>
                                <th class="col-xs-1" data-field="nro" data-sortable="true">Id</th>
                                <th data-field="nombre" data-sortable="true">Nombre</th>
                                <th data-field="descripcion" data-sortable="true">Descripcion</th>
                                <th data-field="email" data-sortable="true">Cantidad de usuarios</th>
                                <th data-field="ultimoIngreso" data-sortable="true">Cantidad de permisos</th>
                                <th data-field="acciones" data-sortable="true">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (isset($roles)) {
                                foreach ($roles as $rol) {
                                    echo '<tr>';
                                    echo '<td>' . $rol->getId() . '</td>';
                                    echo '<td>' . $rol->getNombre() . '</td>';
                                    echo '<td>' . $rol->getDescripcion() . '</td>';
                                    echo '<td>' . $rol->getUsuarios()->count() . '</td>';
                                    echo '<td>' . $rol->getPermisos()->count() . '</td>';
                                    echo '<td >
                                                <a class="editar" href="' . $rol->getId() . '"><i class="fa fa-edit"></i></a>
                                            </td>';
                                    echo '</tr>';
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
    $atributos = array("id" => "formRoles");
    echo form_open("roles", $atributos);
    ?>


    <input id="rol_id" type="hidden" class="form-control" name="rol_id" value="0"/>
    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">Rol</h3>
        </div>
        <div class="box-body">
            <div class="row">
                <div class=" col-md-12">
                    <div class=" col-md-2">
                        <div class="form-group">
                            <label for="">Nombre</label>
                            <input required="true" type="text" class="form-control" id="rol_nombre" name="rol_nombre" />
                        </div>
                    </div>
                    <div class=" col-md-4">
                        <div class="form-group">
                            <label for="">Descripcion</label>
                            <input required="true" type="text" class="form-control" id="rol_descripcion" name="rol_descripcion" />
                        </div>
                    </div>
                    <div class=" col-md-4">
                        <div class="form-group">
                            <label for="">Permisos</label>
                            <select  size="8" multiple class="form-control" id="permisos"  name="permisos[]">
                                <option disabled selected>Seleccione rol</option>
                                <?php foreach ($permisos as $permiso): ?>
                                    <option value="<?= $permiso->getId() ?>"><?= $permiso->getNombre() ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <button type="submit" id="guarda"   class="btn btn-primary margen15 pull-right" value="formUsuarios">Guardar</button>
                </div>
            </div>
        </div>
        <?php form_close(); ?>
</section>

