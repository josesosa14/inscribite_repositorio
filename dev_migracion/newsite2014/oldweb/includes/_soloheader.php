<?
if(!headers_sent()){
header('content-type: text/html; charset=utf-8');
header('Cache-Control: no-cache, must-revalidate');  // HTTP/1.1
header('Pragma: no-cache');
}                          // HTTP/1.0
ob_start();
//session_start();
$conexio=mysql_connect("localhost","inscribite_user","iW7zNKpRWkSHHwplBhUO");
mysql_select_db ("inscribite_base",$conexio);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
  <head>
    <title>Inscribite Online</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link href="http://www.inscribiteonline.com.ar/estilo.css" rel="stylesheet" type="text/css"/>
  <link rel="shortcut icon" href="http://www.inscribiteonline.com.ar/webimages/favicon.ico" type="image/x-icon"/>
  <link rel="icon" href="http://www.inscribiteonline.com.ar/webimages/favicon.gif" type="image/gif"/>
  </head>
  <body>
    <div class="centrado">
	<div class="lineainicioyfinal">
	</div>
	<div class="header">
	  <div class="separacionsolapas">
        <a href="./" class="logolinkalhome" ></a>
	  </div>
	  <div class="gruposolapas">
        <a href="acercade" class="solapa<?php if($_SERVER['PHP_SELF']!='/acercade.php')echo 'no'?>seleccionada">Acerca de</a>
        <a href="inscripciones" class="solapa<?php if($_SERVER['PHP_SELF']!='/inscripciones.php')echo 'no'?>seleccionada">Inscripciones</a>
        <a href="pagos" class="solapa<?php if($_SERVER['PHP_SELF']!='/pagos.php')echo 'no'?>seleccionada">Pagos</a>
        <a href="promociones" class="solapa<?php if($_SERVER['PHP_SELF']!='/promociones.php')echo 'no'?>seleccionada">Promociones</a>
        <a href="contacto" class="solapa<?php if($_SERVER['PHP_SELF']!='/contacto.php')echo 'no'?>seleccionada">Contacto</a>
	  </div>
	</div>