<?
header ("Cache-Control: no-cache, must-revalidate");  // HTTP/1.1
header ("Pragma: no-cache");                          // HTTP/1.0
ob_start();

$conexio = mysql_connect("localhost","maritimo_beebee","beebee");
mysql_select_db ("maritimo_login", $conexio) OR die ("No se puede conectar");

$usuario = $_POST["usuario"];
if ( $_POST["usuario"] != "" ) {

	$result = mysql_query('SELECT * FROM inscribite_comercial WHERE dni = "'.$usuario.'" AND clave = "'.$_POST["clave"].'" LIMIT 1 ');
	while($row = mysql_fetch_array($result)) {
		$nombreusuario = $row['nombre'];
	}
	$cantresultados = mysql_num_rows($result);
	if ( $cantresultados > 0)
	setcookie("usuario", $_POST["usuario"], time()+7776000, "/");
	
	mysql_free_result($result);
}

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
		height:50px;
		background-color:#F7F7F7;
		border:1px #999999 solid;
		text-align:center;
		line-height: 50px;
		font-size: xx-small;
		padding: 10px 0;
		margin: 10px 0;
		}
	</style>
 </head>
<body>
<? if ( $cantresultados > 0) { ?>
<script type="text/javascript">
<!--
location.href='servicio.php';
// location.href='<? echo $_SERVER['HTTP_REFERER']; ?>';
-->
</script>

<? } else { ?>
<body onLoad="no_Focus();">

<div class="cabezal"><a href="<? echo $_SERVER['HTTP_REFERER']; ?>">Inscribite on line</a> | El usuario o la clave 
  es errónea</div>

</body>

</html>

<? }

mysql_close();

?>