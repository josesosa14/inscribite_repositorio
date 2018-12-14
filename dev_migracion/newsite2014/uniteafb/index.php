<?
include_once '../inc.config.php';
//include_once 'fbconnect/lib/config.php';

/*$horasdesesion = 8;
$todaviaNoCompartio = true;
$user = User::fbc_getLoggedIn();
($user) ? $fb_active_session = $user->fbc_is_session_active() : $fb_active_session = FALSE;
if ($user) {
	if ($user->fbc_is_facebook_user()) {
	$status_success = $user->fbc_setStatus('participando');
	if ($status_success) { $status_result = ""; } else { $status_result = ""; }
		$todaviaNoCompartio = false;
		$hash = dechex(time());
		setcookie($q = "participante_uneteafb1", $hash, (time()+(3600*$horasdesesion)), "/");
		mysql_query("INSERT INTO ".$pftables."defacebook ( `id`, `cookiehash` ) VALUES ( '', '".$hash."' );");
	} else {
	}
}*/
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
<head>
	<title>Inscribite Online, la forma de pago más fácil, cómoda y segura que te brinda Pago Fácil</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<link href="http://www.inscribiteonline.com.ar/inscribite.css" rel="stylesheet" type="text/css"/>
		<link rel="shortcut icon" href="http://www.inscribiteonline.com.ar/webimages/favicon.ico" type="image/x-icon"/>
	<link rel="icon" href="http://www.inscribiteonline.com.ar/webimages/favicon.gif" type="image/gif"/>
</head>
<body>
<div id="content">

	<div id="header">
		<div id="top_info">
		<a href="http://www.pagofacil.com.ar/espanol/site/default.php"><img src="/images/slogan.gif" alt="" style="width:361px;height:70px;"/></a> </div>
		<div id="logo"><a href="http://www.inscribiteonline.com.ar/"><img src="/images/logo.gif" alt="" style="width:361px;height:70px;"/></a></div>
	</div>

	<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol)?"https://ssl.":"http://www.");
document.write(unescape("%3Cscript src='"+gaJsHost+"google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-6614438-1");
pageTracker._trackPageview();
} catch(err) {}
</script>

<div class="gboxtop" style="margin-top:20px;"></div>
<div class="gbox">
<h2><strong>Inscribite on line</strong> es un sistema de <span style="font-weight:bold">GESTION y COBRANZA</span> de inscripción a eventos, cursos, congresos, consorcios, pago de reservas o servicios organizados y/o administrados por empresas o instituciones que están adheridas al sistema, de la manera más fácil, segura y con toda la facilidad y comodidad de pago que te brida <span style="font-weight: bold">PAGO FACIL</span>. <strong><a href="http://www.pagofacil.com.ar/espanol/site/donde_pago.php">Empresas adheridas</a></strong></h2>
</div>

	<div style="padding:10px 0 0px 0;font-size:15px;text-align:center;">
<?php /*$user = User::fbc_getLoggedIn();
($user) ? $fb_active_session = $user->fbc_is_session_active() : $fb_active_session = FALSE;
if (!$user) {*/ ?>
Seguinos en Facebook y obtené 50% de descuento en la matrícula y la bonificación de la última cuota de la escuela.
	<div style="text-align:center;margin-top:15px;">
       <iframe src="http://www.facebook.com/plugins/like.php?href=<?=urlencode('http://www.facebook.com/institutoepsa')?>"
        scrolling="no" frameborder="0"
        style="border:none; width:450px; height:80px"></iframe>
<?php /*
<a href="#" onclick="FB.Connect.showPermissionDialog('status_update', function(accepted) { window.location.reload(); } ); return false;"><img src="compartirconfacebook.gif" alt="" style="vertical-align:middle;"/></a>
<script src="http://static.ak.connect.facebook.com/js/api_lib/v0.4/FeatureLoader.js.php" type="text/javascript"></script>
<script type="text/javascript">
FB.init("245533208842802", "xd_receiver.php");
</script>
<script src="fbconnect/javascript/fbconnect.js" type="text/javascript"></script><script type="text/javascript">window.onload = function() { facebook_onload(true); };</script>
*/ ?>
	</div>
<?	/*}*/ ?>
	</div>
	<div style="border:4px #666 dashed;padding:20px;margin-bottom:20px;">
		Presenta este cupón para obtener lorem ipsum lorem ipsum lorem ipsum lorem ipsum.  lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum
		 lorem ipsum lorem ipsum lorem ipsum lorem ipsum.  lorem ipsum lorem ipsum lorem ipsum lorem ipsum.  lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum  lorem ipsum lorem ipsum<br/>
		 <br/>
		 lorem ipsum lorem ipsum lorem ipsum.  lorem ipsum lorem ipsum lorem ipsum lorem ipsum.  lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum  lorem ipsum lorem ipsum<br/>
		 
	</div>

	<div class="footer">
		<p><a href="http://www.inscribiteonline.com.ar/">Home</a> &middot; <a href="http://www.inscribiteonline.com.ar/acerca">Acerca Inscribite on line</a> &middot; <a href="http://www.inscribiteonline.com.ar/quepagar">Qu&eacute; pagar con  Inscribite on line</a> &middot; <a href="http://www.inscribiteonline.com.ar/faqs">Preguntas frecuentes</a> &middot; <a href="http://www.inscribiteonline.com.ar/contacto">Contacto</a>
			<br/>
			&copy; Copyright 2011 / Inscribite on line es un producto de MARITIMO SRL / 4641-4423 4643-1124 /
			<a href="mailto:comercial@inscribiteonline.com.ar">comercial@inscribiteonline.com.ar</a>
		</p>
	</div>
</div>
</body>
</html><?
//ob_end_flush();
if (is_resource($result1)) mysql_free_result($result1);
if (is_resource($result2)) mysql_free_result($result2);
if (is_resource($result3)) mysql_free_result($result3);
mysql_close($coneccion);
?>