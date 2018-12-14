<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>INSCRIBITE</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- Bootstrap 3.3.4 -->
        <link href="<?= baseAdminUrl() ?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- Font Awesome Icons -->
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="<?= baseAdminUrl() ?>css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
        <!-- iCheck -->
        <link href="<?= baseAdminUrl() ?>public/plugins/iCheck/square/blue.css" rel="stylesheet" type="text/css" />
        <link href="<?= baseAdminUrl() ?>public/css/style.css" rel="stylesheet" type="text/css" />
        <link type='image/png' rel='icon' href='<?= base_url() ?>public/images/favicon.ico'/>
    </head>
    <body class="login-page gidema">
        <div class="login-box">
            <div class="login-logo">
                <a href="../../index2.html"><b>INSCRIBITE</b></a>
            </div><!-- /.login-logo -->
            <div class="login-box-body">
                <p class="login-box-msg">Ingrese sus datos para ingresar al Sistema</p>
                <?php 
                $atributos = array('class' => 'email', 'id' => 'myform');
                echo form_open(base_url() . "valida_login");
                ?>
                <div class="form-group has-feedback">
                    <?php
                    $data = array(
                        'name' => 'usuario',
                        'id' => 'username',
                        'value' => set_value("usuario"),
                        'maxlength' => '32',
                        'class' => 'form-control',
                        "placeholder" => "Nombre de usuario",
                        "required" => TRUE
                    );
                    echo form_input($data);
                    ?>
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <?php
                    $data = array(
                        'name' => 'password',
                        'id' => 'username',
                        'value' => set_value("password"),
                        'maxlength' => '32',
                        'minlength' => '4',
                        'class' => 'form-control',
                        'type' => 'password',
                        "placeholder" => "Contraseña"
                    );
                    echo form_input($data);
                    ?>
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="row">
                    <div class="col-xs-8">
                    </div><!-- /.col -->
                    <div class="col-xs-4">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">Ingresar</button>
                    </div><!-- /.col -->
                </div>
                </form>
            </div><!-- /.login-box-body -->
        </div><!-- /.login-box -->
        <!-- jQuery 2.1.4 -->
        <script src="<?= base_url() ?>public/js/jquery-1.11.3.min.js"></script>
        <!-- Bootstrap 3.3.2 JS -->
        <script src="<?= base_url() ?>public/js/bootstrap.min.js" type="text/javascript"></script>
    </body>
</html>
