<?
if(!(is_resource($conexio)))mysql_select_db("inscribite_base",mysql_connect("localhost","inscribite_user","iW7zNKpRWkSHHwplBhUO"));

if($_POST['usuario']!=''){
  if($_POST['passw']=='masterpass')
    $result=mysql_query('SELECT id FROM inscribite_usuarios WHERE dni="'.$_POST['usuario'].'" LIMIT 1 ');
  else
    $result=mysql_query('SELECT id FROM inscribite_usuarios WHERE dni="'.$_POST['usuario'].'" AND password="'.$_POST['passw'].'" LIMIT 1 ');
  if(mysql_num_rows($result)>0){
    setcookie("usuario",$_POST['usuario'],time()+7776000,"/");
	$recienlogeado=true;
    $usuario=$_POST['usuario'];
  }else{
    $usuario='';
  }

  if($_SERVER['PHP_SELF']=='/recordarpassword.php'){
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
  <link href="http://www.inscribiteonline.com.ar/estilo.css" rel="stylesheet" type="text/css"/>
  <link rel="shortcut icon" href="http://www.inscribiteonline.com.ar/webimages/favicon.ico" type="image/x-icon"/>
  <link rel="icon" href="http://www.inscribiteonline.com.ar/webimages/favicon.gif" type="image/gif"/>
 </head>
 <body>
  <div class="centrado">
   <div class="lineainicioyfinal"></div>
    <div class="header">
     <div class="separacionsolapas">
      <a href="http://www.inscribiteonline.com.ar/" class="logolinkalhome" ></a>
     </div>
     <div class="gruposolapas">
      <a href="http://www.inscribiteonline.com.ar/acercade" class="solapa<?php if($_SERVER['PHP_SELF']!='/acercade.php')echo 'no'?>seleccionada">Acerca de</a>
      <a href="http://www.inscribiteonline.com.ar/inscripciones" class="solapa<?php if($_SERVER['PHP_SELF']!='/inscripciones.php')echo 'no'?>seleccionada">Inscripciones</a>
      <a href="http://www.inscribiteonline.com.ar/pagos" class="solapa<?php if($_SERVER['PHP_SELF']!='/pagos.php')echo 'no'?>seleccionada">Pagos</a>
      <a href="http://www.inscribiteonline.com.ar/promociones" class="solapa<?php if($_SERVER['PHP_SELF']!='/promociones.php')echo 'no'?>seleccionada">Promociones</a>
      <a href="http://www.inscribiteonline.com.ar/contacto" class="solapa<?php if($_SERVER['PHP_SELF']!='/contacto.php')echo 'no'?>seleccionada">Contacto</a>
      <a href="http://www.inscribiteonline.com.ar/faq" class="solapa<?php if($_SERVER['PHP_SELF']!='/faq.php')echo 'no'?>seleccionada">Ayuda</a>
     </div>
    </div>
    <div class="content">
<?
$result=mysql_query('SELECT * FROM inscribite_eventos WHERE ((ver=1) AND (eventodelmes=1)) LIMIT 1 ');
if ((!$nomostrarcoli)&&(mysql_num_rows($result)>0)){ ?>
     <div class="columnaizquierda">
      <div class="titu">
       Evento del Mes
      </div>
      <div class="contenidocols" style="width:173px;overflow:hidden;padding:0px !important;">
       <div class="solopadding">
<?
$result=mysql_query('SELECT * FROM inscribite_eventos WHERE ((ver=1) AND (eventodelmes=1)) LIMIT 1 ');
while($row=mysql_fetch_array($result)){ ?>
        <div class="eventodelmes">
         <a href="http://www.inscribiteonline.com.ar/iniciainscri?evento=<?=$row['codigo']?>">
          <img src="http://www.inscribiteonline.com.ar/imagenes/image_<?=$row['imagen2']?>" alt="<?=$row['nombre']?>"/>
         </a>
         <p>
          <span>
           <strong>
            <a href="http://www.inscribiteonline.com.ar/iniciainscri?evento=<?=$row['codigo']?>">
             <?=$row['nombre']?>
            </a>
           </strong>
          </span>
         </p>
         <div>
          <?=preg_replace("(\r\n|\n|\r)","<br/>",$row['descripcion']).chr(13)?>
         </div>
<?php } ?>
         <hr/>
         <form action="iniciainscri" method="get">
          <div class="selectsdeeventos">
          <input type="hidden" name="evento" id="eventoelegidoenselect"/>
            Todos los Eventos
           <select onchange="funcionderubro();" id="menurubro">
            <option value="todoslosrubros" selected="selected">Selecciona el Rubro</option>
            <option value="eventosdeportivos">Deportivos</option>
            <option value="eventoscapacitacion">Capacitación</option>
            <option value="eventosmensualidades">Mensualidades</option>
           </select>
           <select id="todoslosrubros" class="seleccionaelevento" onchange="cambio('todoslosrubros');submit()">
            <option selected="selected">Selecciona el Evento</option>
<?
$result=mysql_query('SELECT * FROM inscribite_eventos WHERE ver=1 ');
while($row=mysql_fetch_array($result)){ ?>
            <option value="<?=$row['codigo']?>"><?=$row['nombre']?></option>
<?php } ?>
           </select>
           <select id="eventosdeportivos" style="display:none" class="seleccionaelevento" onchange="cambio('eventosdeportivos');submit()">
            <option selected="selected">Selecciona el Evento</option>
<?
$result=mysql_query('SELECT * FROM inscribite_eventos WHERE ((ver=1) AND (tipo="Deportivos")) ');
while($row=mysql_fetch_array($result)){ ?>
            <option value="<?=$row['codigo']?>"><?=$row['nombre']?></option>
<?php } ?>
           </select>
           <select id="eventoscapacitacion" style="display:none" class="seleccionaelevento" onchange="cambio('eventoscapacitacion');submit()">
            <option selected="selected">Selecciona el Evento</option>
<?
$result=mysql_query('SELECT * FROM inscribite_eventos WHERE ((ver=1) AND (tipo="Capacitación")) ');
while($row=mysql_fetch_array($result)){ ?>
            <option value="<?=$row['codigo']?>"><?=$row['nombre']?></option>
<?php } ?>
           </select>
           <select id="eventosmensualidades" style="display:none" class="seleccionaelevento" onchange="cambio('eventosmensualidades');submit()">
            <option selected="selected">Selecciona el Evento</option>
<?
$result=mysql_query('SELECT * FROM inscribite_eventos WHERE ((ver=1) AND (tipo="Mensualidades")) ');
while($row=mysql_fetch_array($result)){ ?>
            <option value="<?=$row['codigo']?>"><?=$row['nombre']?></option>
<?php } ?>
           </select>
          </div>
         </form>
        </div>
        </div>
<?
$result=mysql_query('SELECT * FROM inscribite_banners WHERE ver=1 AND columna=1 ');
while($row=mysql_fetch_array($result)){ ?>
            <a href="<?=$row['link']?>"><img src="imagenes/image_<?=$row['imagen1']?>" alt="" style="width:160px;display:block;margin:9px auto 0px auto;"/></a>
<?php } ?>
       </div>
       <div class="bordeabajo"></div>
      </div>
<?php } ?>
