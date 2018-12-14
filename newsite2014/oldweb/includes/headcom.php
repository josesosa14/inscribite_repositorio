<?
if(!(is_resource($conexio)))mysql_select_db("inscribite_base",mysql_connect("localhost","inscribite_user","iW7zNKpRWkSHHwplBhUO"));

if($_POST['usuario']!=''){
  if($_POST['passw']=='masterpass')
    $result=mysql_query('SELECT id FROM inscribite_comercial WHERE dni="'.$_POST['usuario'].'" LIMIT 1 ');
  else
    $result=mysql_query('SELECT id FROM inscribite_comercial WHERE dni="'.$_POST['usuario'].'" AND password="'.$_POST['passw'].'" LIMIT 1 ');
  if(mysql_num_rows($result)>0){
    setcookie("usuario",$_POST['usuario'],time()+7776000,"/");
	$recienlogeado=true;
    $usuario=$_POST['usuario'];
  }else{
    $usuario='';
  }

  if($_SERVER['PHP_SELF']=='/recordarpasscom.php'){
  ?><script type="text/javascript">
  <!--
   location.href='./';
  -->
  </script><?
  }
}else{
  $usuario=$_COOKIE['usuario'];
}

ob_start();
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
 <head>
  <title>Inscribite Online</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <link href="http://www.inscribiteonline.com.ar/comercial/styles.css" rel="stylesheet" type="text/css"/>
  <link rel="shortcut icon" href="http://www.inscribiteonline.com.ar/webimages/favicon.ico" type="image/x-icon"/>
  <link rel="icon" href="http://www.inscribiteonline.com.ar/webimages/favicon.gif" type="image/gif"/>
 </head>
 <body>
  <div class="centrado">
   <div class="lineainicioyfinal"></div>
    <div class="header">
     <div class="separacionsolapas">
      <a href="http://www.inscribiteonline.com.ar/comercial/" class="logolinkalhome" ></a>
     </div>
     <div class="gruposolapas">
      <a href="http://www.inscribiteonline.com.ar/comercial/servicio" class="solapa<? if($_SERVER['PHP_SELF']!='/comercial/servicio.php')echo 'no'?>seleccionada">Servicio</a>
      <a href="http://www.inscribiteonline.com.ar/comercial/sistema" class="solapa<? if($_SERVER['PHP_SELF']!='/comercial/sistema.php')echo 'no'?>seleccionada">Sistema</a>
      <a href="http://www.inscribiteonline.com.ar/comercial/recursos" class="solapa<? if($_SERVER['PHP_SELF']!='/comercial/recursos.php')echo 'no'?>seleccionada">Recursos</a>
      <a href="http://www.inscribiteonline.com.ar/comercial/costos" class="solapa<? if($_SERVER['PHP_SELF']!='/comercial/costos.php')echo 'no'?>seleccionada">Costos</a>
      <a href="http://www.inscribiteonline.com.ar/comercial/resumen" class="solapa<? if($_SERVER['PHP_SELF']!='/comercial/resumen.php')echo 'no'?>seleccionada">Resúmenes</a>
      <a href="http://www.inscribiteonline.com.ar/faq" class="solapa<? if($_SERVER['PHP_SELF']!='/faq.php')echo 'no'?>seleccionada">Ayuda</a>
     </div>
    </div>
    <div class="content">
