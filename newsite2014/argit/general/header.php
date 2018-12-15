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
        <meta property="og:description" content="M&aacute;s de 200 empresas y productoras conf&iacute;an la inscripci&oacute;n de sus eventos en nuestro sistema."/>
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->

        <title>Inscribite</title>

        <!--css -->
        <base href="inscribitetest.rhind.com.ar/inscribite_repositorio/newsite2014/argit/">
        <link rel="stylesheet" href="../css/bootstrap.min.css" />       
		<link rel="stylesheet" type="text/css" href="../css/styleNew.css" />
		        <link rel="shortcut icon" href="../images/favicon.ico">

        <!--<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">-->
        <script src="../js/jquery-1.10.2.min.js"></script>
        <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
        <script src="../js/bootstrap.min.js"></script>
        <script src="../js/jquery.placeholder.js"></script>
        <script src="../js/jquery-validate.min.js"></script>
        <script src="../js/jquery.sharrre.min.js"></script>

    </head>
	
	<noscript>
		 <meta http-equiv="refresh" content="0;URL=http://www.inscribiteonline.com.ar/newsite2014/argit/general/ie8_problem.php" />
	</noscript>
    <body>
        <?php if (isset($miCuenta)) { ?>
            <div id="fb-root"></div>
            <script>
                window.fbAsyncInit = function () {
                    FB.init({appId: '765538030173289', status: true, cookie: true,
                        xfbml: true});
                };
                (function () {
                    var e = document.createElement('script');
                    e.async = true;
                    e.src = document.location.protocol +
                            '//connect.facebook.net/en_US/all.js';
                    document.getElementById('fb-root').appendChild(e);
                }());
            </script>
        <?php } ?>
        <div class="container">

            <?php
            //if ($_SERVER['REMOTE_ADDR'] == "190.55.94.190") {

                //print_r($_SERVER);
                ?>
				
				
                <script>
                    function msieversion() {

                        var ua = window.navigator.userAgent;
                        var msie = ua.indexOf("MSIE ");

                        if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))   {
                            if(parseInt(ua.substring(msie + 5, ua.indexOf(".", msie))) <= 8) {
                                return true;
                            }
                            
                        }
                        // If another browser, return 0


                        return false;
                    };
                    $(function () {
                        if (msieversion()) {
                            var url = "http://www.inscribiteonline.com.ar/newsite2014/argit/general/ie8_problem.php";
                            $(location).attr('href', url);
                        }

                    });
                </script>

                <?php
           // }
            ?>
            <?php
            //            preg_match('/MSIE (.*?);/', $_SERVER['HTTP_USER_AGENT'], $matches);
            //            if (count($matches) < 2) {
            //                preg_match('/Trident\/\d{1,2}.\d{1,2}; rv:([0-9]*)/', $_SERVER['HTTP_USER_AGENT'], $matches);
            //            }
            //
            //            if (count($matches) > 1) {
            //                //Then we're using IE
            //                $version = $matches[1];
            //                if ($version < 9) {
            //                    echo '
            //	<div class="row">
            //	<h3>Usted está usando una versión de Internet Explorer no compatible con este sitio. Descargue una nueva versión <a target="_blank" href="http://windows.microsoft.com/es-xl/internet-explorer/download-ie">Internet Explorer</a></h3>
            //	</div>
            //	';
            //                    die;
            //                }
            //            }
            ?>


            <?php
            if (isset($pagar) && $pagar == "blue" && !isset($inscripcion)) {
                echo '<div class="top bg-5 row">';
            }
            elseif (isset($inscripcion) && $inscripcion == "blue") {
                echo '<div class="top bg-6 row">';
            }
            elseif (isset($login) && $login == "blue") {
                echo '<div class="top bg-2 row">';
            }
            elseif (isset($contacto) && $contacto == "blue") {
                echo '<div class="top bg-3 row">';
            }
            elseif (isset($nosotros) && $nosotros == "blue") {
                echo '<div class="top bg-4 row">';
            }
            elseif (isset($inicio) && $inicio == "blue") {
                echo '<div class="top bg-2 row">';
            }
            elseif (isset($dudas) && $dudas == "blue") {
                echo '<div class=" row">';
            }
            else {
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

                    <?php
                    include_once dirname(__FILE__) . '/menu.php';
                    ?>

                </nav>
            </div>

