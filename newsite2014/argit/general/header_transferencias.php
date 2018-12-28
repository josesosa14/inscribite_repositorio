<?php require_once dirname(__FILE__) . '/db.php'; ?>

<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html lang="es">
    <!--<![endif]-->
    <head>
        <meta http-equiv="Content-Type" content="text/html" charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />

        <title>Inscribite</title>
        <!--css -->
        <base href="<?PHP echo $general_path;?>newsite2014/argit/">
        <link rel="stylesheet" href="../css/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href="../css/style.css" />
        <link rel="shortcut icon" href="../images/favicon.ico">

        <!--<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">-->
        <script src="../js/jquery-1.10.2.min.js"></script>
        <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
        <script src="../js/bootstrap.min.js"></script>
        <script src="../js/jquery.placeholder.js"></script>
        <script src="../js/jquery-validate.min.js"></script>
    </head>
    <body>
        <div class="container">
            <?php
            if (isset($pagar) && $pagar == "blue" && !isset($inscripcion)) {
                echo '<div class="top bg-5 row">';
            } elseif (isset($inscripcion) && $inscripcion == "blue") {
                echo '<div class="top bg-6 row">';
            } elseif (isset($login) && $login == "blue") {
                echo '<div class="top bg-2 row">';
            } elseif (isset($contacto) && $contacto == "blue") {
                echo '<div class="top bg-3 row">';
            } elseif (isset($nosotros) && $nosotros == "blue") {
                echo '<div class="top bg-4 row">';
            } else {
                echo '<div class="top bg-1 row">';
            }
            ?>

            <div class="header">
                <nav class="navbar navbar-default" role="navigation">
                    <div class="navbar-header">
                        <!-- responsive navigation -->
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a href="<?php echo $unirse_path ?>" style="padding-left:25px;" class="col-xs-8 col-sm-11 logo"><img class="img-responsive" src="../images/logo.png" alt=""/></a>
                    </div>

                    <div class="collapse navbar-collapse" id="fixed-menu">
                        <!-- Main navigation -->
                        <ul class="nav navbar-nav menu">
                            <li >
                                <a href="<?PHP echo $general_path;?>newsite2014/admin" class="<?php echo $inicio ?>">Volver al admin</a>
                            </li>
                        </ul>
                    </div>

                </nav>
            </div>

