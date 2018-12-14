<?php require_once dirname(__FILE__).'/db.php';
//require classes
require_once dirname(__FILE__).'/../Classes/PHPExcel.php';
require_once dirname(__FILE__).'/../Classes/PHPExcel/IOFactory.php';

if (!isset($_SESSION['empresa'])) {
    header('Location:../empresas/empresa.php');
}
?>

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
		<base href="http://www.inscribiteonline.com.ar/newsite2014/argit/">
        <link rel="stylesheet" href="../css/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href="../css/style.css" />

        <!--<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">-->
        <script src="../js/jquery-1.10.2.min.js"></script>
        <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
        <script src="../js/bootstrap.min.js"></script>
        <script src="../js/jquery.placeholder.js"></script>
        <script src="../js/jquery-validate.min.js"></script>
		
		<script src="../js/tables/bootstrap-table.min.js"></script>
		<link rel="stylesheet" type="text/css" href="../js/tables/bootstrap-table.css">
		<script src="../js/tables/bootstrap-table-es-AR.min.js"></script>
		<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <div class="container">
            <div class="row">
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
                            <a href="<?php echo $unirse_path?>" class="col-xs-8 col-sm-11 logo"><img class="img-responsive" src="../images/logo.png" alt=""/></a> 
                        </div>

                        <?php include_once dirname(__FILE__).'/menu_empresa.php'; ?>

                    </nav>
                </div>