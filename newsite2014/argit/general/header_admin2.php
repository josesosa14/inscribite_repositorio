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
        <meta property="og:title" content="Eventos Inscribite Online"/>
        <meta property="og:site_name" content="Inscribite Online"/>
        <meta property="og:url" content="http://www.inscribiteonline.com.ar/miCuenta.php"/>
        <meta property="og:type" content="sport"/>
        <meta property="og:image" content="http://www.inscribiteonline.com.ar/newsite2014/imagenes/face_logo.jpg"/>
        <meta property="og:description" content="Más de 200 empresas y productoras conf&iacute;an la inscripci&oacute;n de sus eventos en nuestro sistema."/>
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->

        <title>Inscribite</title>

        <!--css -->
        <base href="http://www.inscribiteonline.com.ar/newsite2014/argit/">
        <link rel="stylesheet" href="../css/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="../css/style.css" />
        <link rel="shortcut icon" href="../images/favicon.ico">

        <!--<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">-->
        <script src="../js/jquery-1.10.2.min.js"></script>
        <!--<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>-->
        <script src="../js/bootstrap.min.js"></script>
        <script src="../js/jquery.placeholder.js"></script>
        <script src="../js/jquery-validate.min.js"></script>
        <!--<script src="../js/jquery.sharrre.min.js"></script>
		<script src="../js/bootstrap.min.js"></script>-->
		<link rel="stylesheet" type="text/css" href="../js/tables/bootstrap-table.css"> 
		<script src="../js/tables/bootstrap-table.min.js"></script>
		<script src="../js/tables/bootstrap-table-es-AR.min.js"></script>

    </head>
	
	<noscript>
		 <meta http-equiv="refresh" content="0;URL='http://www.inscribiteonline.com.ar/newsite2014/argit/general/ie8_problem.php'" />
	</noscript>
    <body>
        <div class="container">			
            <?php
           
                echo '<div class="row">';
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

                    <?php
                    include_once dirname(__FILE__) . '/menu_admin.php';
                    ?>

                </nav>
            </div>

