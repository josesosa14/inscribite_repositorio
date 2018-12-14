<?php header("Content-type: text/html; charset=UTF-8");

function conectar(&$bd)
{
$bd="maritimo_login";
$host="localhost";
$usuario="maritimo_beebee";
$password="beebee";
mysql_connect($host,$usuario,$password);
}
conectar($bd);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
 <head>
  <title>Inscribite Online</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <link href="http://www.inscribiteonline.com.ar/comercial/styles.css" rel="stylesheet" type="text/css"/>
  <link rel="shortcut icon" href="http://www.inscribiteonline.com.ar/webimages/favicon.ico" type="image/x-icon"/>
  <link rel="icon" href="http://www.inscribiteonline.com.ar/webimages/favicon.gif" type="image/gif"/>
  	<style type="text/css" >
		.cabezal{
	width:100%;
	height:200px;
	background-color:#F7F7F7;
	border:1px #999999 solid;
	text-align:center;
	line-height: 50px;
	font-size: xx-small;
	margin-top: 10px;
	margin-right: 0;
	margin-bottom: 10px;
	margin-left: 0;
	padding-top: 10px;
	padding-right: 0;
	padding-bottom: 10px;
	padding-left: 0;
		}
	</style>
 </head>
 <body>
  <div class="centrado">
   <div class="lineainicioyfinal"></div>
    <div class="header">
     <div class="separacionsolapas">
      <a href="http://www.inscribiteonline.com.ar/" class="logolinkalhome" ></a>
     </div>
     <div class="gruposolapas">
      <a href="http://www.inscribiteonline.com.ar/comercial/servicio" class="solapa<?php if($_SERVER['PHP_SELF']!='/comercial/servicio.php')echo 'no'?>seleccionada">Servicio</a>
      <a href="http://www.inscribiteonline.com.ar/comercial/sistema" class="solapa<?php if($_SERVER['PHP_SELF']!='/comercial/sistema.php')echo 'no'?>seleccionada">Sistema</a>
      <a href="http://www.inscribiteonline.com.ar/comercial/recursos" class="solapa<?php if($_SERVER['PHP_SELF']!='/comercial/recursos.php')echo 'no'?>seleccionada">Recursos</a>
      <a href="http://www.inscribiteonline.com.ar/comercial/costos" class="solapa<?php if($_SERVER['PHP_SELF']!='/comercial/costos.php')echo 'no'?>seleccionada">Costos</a>
      <a href="http://www.inscribiteonline.com.ar/comercial/resumen" class="solapa<?php if($_SERVER['PHP_SELF']!='/comercial/resumen.php')echo 'no'?>seleccionada">Resúmenes</a>
      <a href="http://www.inscribiteonline.com.ar/faq" class="solapa<?php if($_SERVER['PHP_SELF']!='/faq.php')echo 'no'?>seleccionada">Ayuda</a>
     </div>
    </div>
    <div class="content">
	<br/>
	<h1>Registrese como  Empresa</h1>	
    <div class="cabezal"> 
	<?
              //$nro=mt_rand(0,9);
              //echo $nro;
              mysql_connect("localhost","maritimo_beebee","beebee");
              $bd="maritimo_login";
              $ssql="INSERT INTO inscribite_comercial (apellido,nombre,telefono,email,numero,dni,codigo)
                    VALUES ('$_POST[apellido]','$_POST[nombre]','$_POST[telefono]',
                    '$_POST[email]','$nro','$_POST[dni]','$_POST[codigo]'";
              $forma="";
              for($i=1;$i<8;$i++)
                    {
                    if ($_POST[$i]!="")
                       {
                       $forma=$forma."- $_POST[$i] ";
                       }
                    }
              if ($_POST[otro]!="")
                 {$forma=$forma.": $_POST[otro]";}
              $ssql=$ssql.",'$forma')";
              mysql_db_query($bd,$ssql);
              ?>
	</div>
<script type="text/javascript">
<!--
//location.href='servicio.php';
// location.href='<?php echo $_SERVER['HTTP_REFERER']; ?>';
-->
</script>
<?php include '../includes/footer.php'?>