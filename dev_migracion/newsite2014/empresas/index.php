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
        <link rel="stylesheet" href="../css/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href="../css/style.css" />

        <script src="../js/jquery-1.10.2.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
        <script src="../js/jquery.placeholder.js"></script>
        <script src="../js/main.js"></script>
    </head>
    <body>
        <div class="container">

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
                    <form method="POST" action="login.php">
                        <input type="text" name="usuario" placeholder="Ingresar empresa" class="form-control">
                        <input type="password" name="password" placeholder="Ingresar contraseña" class="form-control">

                        <div class="left">
                            <!--<div>Olvidaste tu contraseña?</div>-->
                            <a href="http://www.arg-it.com/inscribite/argit/empresa.php">No tengo cuenta. Registrarme</a>
                        </div>
                        <div class="right">
                            <input type="submit" value="ingresar" class="btn green">
                        </div>
                        <div class="clear"></div>
                    </form>
                </div>
            </div>
            <div class="footer row">
                © Copyright 2014 / Inscribite Online es un producto de MARITIMO SRL / 4641-4423 4643-1124 / <a href="#">consultas@inscribiteonline.com.ar</a>
            </div>
        </div>

    </body>
</html>
