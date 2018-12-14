<?
$msg = "";
$msg .= "Nombre: ".$_POST['nombre'].'<br/>'.chr(13);
$msg .= "Empresa: ".$_POST['empresa'].'<br/>'.chr(13);
$msg .= "Email: ".$_POST['email'].'<br/>'.chr(13);
$msg .= "Teléfono: ".$_POST['telefono'].'<br/>'.chr(13);
$msg .= '<br/>'.chr(13);
$msg .= "Empresa: ". $_POST['consulta'].'<br/>'.chr(13);
mail('consultas@inscribiteonline.com.ar', "Consulta desde Inscribite Online", $msg, "From: Inscribite Online <consultas@inscribiteonline.com.ar>\r\nContent-Type: text/html; charset=utf-8\r\n");

include_once 'includes/header.php'?>
<div class="left">
<h1>Contacte  Inscribite on line</h1>
<br/>
<h2> Su consulta fue enviada, nos comunicaremos con usted para responderle. </h2>
<h2>Muchas Gracias.</h2>
<br/>
<?php include_once 'includes/footerfull.php'?>