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
		height:100px;
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
  <div class="centrado">
   <div class="lineainicioyfinal"></div>
    <div class="header">
     <div class="separacionsolapas">
      <a href="http://www.inscribiteonline.com.ar/" class="logolinkalhome" ></a>
     </div>
     <div class="gruposolapas">
      <a href="http://www.inscribiteonline.com.ar/servicio" class="solapa<?php if($_SERVER['PHP_SELF']!='/servicio.php')echo 'no'?>seleccionada">Servicios</a>
      <a href="http://www.inscribiteonline.com.ar/eventos" class="solapa<?php if($_SERVER['PHP_SELF']!='/eventos.php')echo 'no'?>seleccionada">Eventos</a>
      <a href="http://www.inscribiteonline.com.ar/pagos" class="solapa<?php if($_SERVER['PHP_SELF']!='/pagos.php')echo 'no'?>seleccionada">Pagos</a>
      <a href="http://www.inscribiteonline.com.ar/promociones" class="solapa<?php if($_SERVER['PHP_SELF']!='/promociones.php')echo 'no'?>seleccionada">Promociones</a>
      <a href="http://www.inscribiteonline.com.ar/contacto" class="solapa<?php if($_SERVER['PHP_SELF']!='/contacto.php')echo 'no'?>seleccionada">Contacto</a>
      <a href="http://www.inscribiteonline.com.ar/faq" class="solapa<?php if($_SERVER['PHP_SELF']!='/faq.php')echo 'no'?>seleccionada">Ayuda</a>
     </div>
    </div>
    <div class="content">
	<br/><h1>Log In para Empresas</h1>	
<div class="cabezal"> 

  <form name="form" id="form" method="post" action="login.php">
    Usuario 
    <input name="usuario" type="text" id="usuario" />
    Clave 
    <input name="clave" type="password" id="clave" />
