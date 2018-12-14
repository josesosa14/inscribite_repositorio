<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html lang="es">
    <!--<![endif]-->
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />	
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />

        <title>Inscribite</title>     
        <!--css -->
        <base href="http://www.inscribiteonline.com.ar/newsite2014/argit/">
        <link rel="stylesheet" href="../css/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href="../css/style.css" />

        <script src="../js/jquery-1.10.2.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
        <script src="../js/jquery.placeholder.js"></script>
        <script src="../js/main.js"></script>
    </head>
    <body>
        <div class="container">


            <?php if (isset($_GET['success'])) { ?>
                <script>
                    $(function() {
                        $(".alert").css("background-color", "rgb(255,0,0)");
                        $('.modalMessage').modal();
                    });
                </script>
            <?php } ?>

            <!-- Modal -->
            <div class="modal fade modalMessage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="alert" style="background:green;">
                                <h2><span id="mensaje1">Registro de empresa exitoso!!</span></h2>
                                <h3><span id="mensaje2">Por favor ingrese a su casilla de mail para confirmar el contrato!</span></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- /.modal -->

            <div class="top bg-7 row">
                <div class="login-container company">
                    <a href="#" class="logo"><img class="img-responsive" src="../images/logo-empresas.png" alt=""/></a>
                    <div class="head">
                        <?php
                        if (isset($_GET['registrado'])) {
                            if ($_GET['registrado']) {
                                echo 'Fue confirmada tu inscripci&oacute;n.';
                            } else {
                                echo 'Inicia sesi&oacute;n con tu empresa';
                            }
                        } else {
                            echo 'Inicia sesi&oacute;n con tu empresa';
                        }
                        ?>


                    </div>
                    <form method="POST" action="/empresas/login.php">
                        <input type="text" id="usuario" name="usuario" placeholder="Ingresar empresa" class="form-control">
                        <input type="password" id="password" name="password" placeholder="Ingresar contraseña" class="form-control">

                        <div class="left">
                            <!--<div>Olvidaste tu contraseña?</div>-->
                            <a href="http://www.inscribiteonline.com.ar/empresas/recuperaCuenta.php" >Recupera Cuenta</a><br>
                            <a href="http://www.inscribiteonline.com.ar/empresa.php">No tengo cuenta. Registrarme</a>
                        </div>
                        <div class="right">
                            <input type="submit" value="ingresar" class="btn green">
                        </div>
                        <div class="clear"></div>
                    </form>
                </div>
            </div>
            <div class="footer row">
                © Copyright 2014 / Inscribite Online es un producto de MARITIMO SRL <a href="#">consultas@inscribiteonline.com.ar</a>
            </div>
        </div>

    </body>
</html>
