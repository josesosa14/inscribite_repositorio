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

	<form name="form1" method="post" action="registrar.php">
  	<table width="500" height="150">
      <tr>
        <td width="245"><p>Apellido
          <input name="apellido" type="text" id="apellido" onblur="MM_validateForm('apellido','','R','nombre','','R','telefono','','R','email','','RisEmail','dni','','RisNum');return document.MM_returnValue" />
        </p></td>
        <td width="243"><p>Nombre
          <input name="nombre" type="text" id="nombre" />
        </p></td>
      </tr>
      <tr>
        <td><p>Tel&eacute;fono
            <input name="telefono" type="text" id="telefono" />
        </p></td>
        <td><p>E-mail
          <input name="email" type="text" id="email" />
        </p></td>
      </tr>
      <tr>
          <td height="24"> <p>DNI  
              <input name="codigo" type="text" id="dni" size="7" maxlength="7" />
            </p></td>
        <td><p>CLAVE 
              <input name="clave" type="text" id="codigo" size="7" maxlength="7" />
          </p></td>
      </tr>
    </table>
  	    <input type="submit" name="Submit" value="Regístrese">
	 </form>
	</div>
<?php include '../includes/footer.php'?>