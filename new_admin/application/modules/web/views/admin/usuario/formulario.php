<?php 
if(!isset($usuario)) {
    $usuario = new Usuario;
    
}
?>
<!-- Main content -->
<section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">Usuarios</h3>
                    <div class="col-md-4">
                        <?php
                        $atributos = array(
                            "id" => "form1"
                        );
                        echo form_open("admin/tipo_barco_controller/editar", $atributos);
                        ?>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Usuario Nombre</label>
                            <?php
                            $data = array(
                                'name' => 'nombre',
                                'id' => 'nombre',
                                'value' => strtoupper($usuario->getNombre()),
                                'maxlength' => '32',
                                'class' => 'form-control',
                                "placeholder" => "Nombre de la marca",
                                "required" => TRUE,
                            );
                            echo form_input($data);
                            ?>

                        </div>
                        <?php echo form_close();
                        ?>
                    </div>

                </div><!-- /.box-header -->
                <div class="box-body">

                </div>
            </div>
        </div>
    </div>
</section>

