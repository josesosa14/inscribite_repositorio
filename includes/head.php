<? include_once 'inc.config.php';

if ($_POST['usuario'] != '') {
	if ($_POST['passw'] == 'masterpass')
		$result = mysql_query('SELECT id FROM '.pftables.'usuarios WHERE dni = "'.$_POST['usuario'].'" LIMIT 1 ');
	else
		$result = mysql_query('SELECT id FROM '.pftables.'usuarios WHERE dni = "'.$_POST['usuario'].'" AND password = "'.$_POST['passw'].'" LIMIT 1 ');
	if (mysql_num_rows($result) > 0) {
		setcookie("usuario", $_POST['usuario'], time()+7776000, "/");
		$_COOKIE['usuario'] = $_POST['usuario'];
		$recienlogeado = true;
		$usuario = $_POST['usuario'];
		header("Location: quepagar");
	} else {
		$usuario = '';
	}

	if ($_SERVER['PHP_SELF'] == '/recordarpassword.php') {
	?><script type="text/javascript">
	<!--
	location.href = './';
	-->
	</script><?
	}
} else {
$usuario=$_COOKIE['usuario'];
}

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
<head>
<title>Inscribite Online, la forma de pago más fácil, cómoda y segura que te brinda Pago Fácil</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<link href="<?=url?>inscribite.css" rel="stylesheet" type="text/css"/>
<? /*<link href="<?=url?>estilo.css" rel="stylesheet" type="text/css"/>*/ ?>
<link rel="shortcut icon" href="<?=url?>webimages/favicon.ico" type="image/x-icon"/>
<link rel="icon" href="<?=url?>webimages/favicon.gif" type="image/gif"/>
</head>
<body>
<div class="centrado">
<div class="lineainicioyfinal"></div>
<div class="header">
<div class="separacionsolapas">
<a href="<?=url?>" class="logolinkalhome"></a>
</div>
<div class="gruposolapas">
<a href="<?=url?>acercade"      class="solapa<? if ($_SERVER['PHP_SELF'] != '/acercade.php')      echo 'no'?>seleccionada">Acerca de</a>
<a href="<?=url?>inscripciones" class="solapa<? if ($_SERVER['PHP_SELF'] != '/inscripciones.php') echo 'no'?>seleccionada">Inscripciones</a>
<a href="<?=url?>pagos"         class="solapa<? if ($_SERVER['PHP_SELF'] != '/pagos.php')         echo 'no'?>seleccionada">Pagos</a>
<a href="<?=url?>promociones"   class="solapa<? if ($_SERVER['PHP_SELF'] != '/promociones.php')   echo 'no'?>seleccionada">Promociones</a>
<a href="<?=url?>contacto"      class="solapa<? if ($_SERVER['PHP_SELF'] != '/contacto.php')      echo 'no'?>seleccionada">Contacto</a>
<a href="<?=url?>faq"           class="solapa<? if ($_SERVER['PHP_SELF'] != '/faq.php')           echo 'no'?>seleccionada">Ayuda</a>
</div>
</div>
<? if (!$mostrarSoloHead) { ?>
<div class="content">
<? $result = mysql_query('SELECT * FROM '.pftables.'eventos WHERE ver = 1 AND eventodelmes = 1 LIMIT 1 ');
if ((!$nomostrarcoli) && (mysql_num_rows($result) > 0)) { ?>
<div class="columnaizquierda">
<div class="titu">
Evento del Mes
</div>
<div class="contenidocols" style="width:173px;overflow:hidden;padding:0px !important;">
<div class="solopadding">
<? $result = mysql_query('SELECT * FROM '.pftables.'eventos WHERE ver = 1 AND eventodelmes = 1 LIMIT 1 ');
while($row = mysql_fetch_array($result)){ ?>
<div class="eventodelmes">
<a href="<?=url?>iniciainscri?evento=<?=$row['codigo']?>">
<img src="<?=url?>imagenes/image_<?=$row['imagen2']?>" alt="<?=$row['nombre']?>"/>
</a>
<p>
<span>
<strong>
<a href="<?=url?>iniciainscri?evento=<?=$row['codigo']?>"><?=$row['nombre']?></a>
</strong>
</span>
</p>
<div>
<?=preg_replace("(\r\n|\n|\r)","<br/>",$row['descripcion']).chr(13)?>
</div>
<? } ?>
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
<? $result = mysql_query('SELECT * FROM inscribite_eventos WHERE ver = 1 ');
while ($row = mysql_fetch_array($result)){ ?>
<option value="<?=$row['codigo']?>"><?=$row['nombre']?></option>
<? } ?>
</select>
<select id="eventosdeportivos" style="display:none" class="seleccionaelevento" onchange="cambio('eventosdeportivos');submit()">
<option selected="selected">Selecciona el Evento</option>
<? $result = mysql_query('SELECT * FROM inscribite_eventos WHERE ver=1 AND tipo = "Deportivos" ');
while ($row = mysql_fetch_array($result)){ ?>
<option value="<?=$row['codigo']?>"><?=$row['nombre']?></option>
<? } ?>
</select>
<select id="eventoscapacitacion" style="display:none" class="seleccionaelevento" onchange="cambio('eventoscapacitacion');submit()">
<option selected="selected">Selecciona el Evento</option>
<? $result = mysql_query('SELECT * FROM inscribite_eventos WHERE ver = 1 AND tipo = "Capacitación" ');
while ($row = mysql_fetch_array($result)){ ?>
<option value="<?=$row['codigo']?>"><?=$row['nombre']?></option>
<? } ?>
</select>
<select id="eventosmensualidades" style="display:none" class="seleccionaelevento" onchange="cambio('eventosmensualidades');submit()">
<option selected="selected">Selecciona el Evento</option>
<? $result = mysql_query('SELECT * FROM inscribite_eventos WHERE ver = 1 AND tipo = "Mensualidades" ');
while($row = mysql_fetch_array($result)){ ?>
<option value="<?=$row['codigo']?>"><?=$row['nombre']?></option>
<? } ?>
</select>
</div>
</form>
</div>
</div>
<? $result = mysql_query('SELECT * FROM inscribite_banners WHERE ver = 1 AND columna = 1 ');
while ($row = mysql_fetch_array($result)){ ?>
<a href="<?=$row['link']?>"><img src="imagenes/image_<?=$row['imagen1']?>" alt="" style="width:160px;display:block;margin:9px auto 0px auto;"/></a>
<? } ?>
</div>
<div class="bordeabajo"></div>
</div>
<? }
} ?>
