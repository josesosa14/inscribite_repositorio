<?	include_once "inc.config.php";
	include_once "inc.funciones.php";
	//checklogin();
?><!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
<head>
	<title><?=$pagetitle?>Inscribite Online, la forma de pago más fácil, cómoda y segura que te brinda Pago Fácil</title>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
	<meta name="description" content=""/>
	<meta name="keywords" content=""/>
	<link rel="stylesheet" href="<?=url?>style.css" type="text/css"/>
	<link rel="shortcut icon" href="<?=url?>images/favicon.ico" type="image/x-icon"/>
	<script type="text/javascript" src="<?=url?>js/html_multi_nav.js"></script>
	<script type="text/javascript" src="<?=url?>js/jquery.min.js"></script>
	<script type="text/javascript" src="<?=url?>js/jquery.numeric.js"></script>
<?=$otrosMeta?>
</head>
<body>
	<header>
		<a href="<?=url?>"><img src="<?=url?>images/logo.gif" alt="InscribiteOnline.com.ar" class="logo"/></a>
		<img src="<?=url?>images/slogan.gif" alt="fácil, cómodo y seguro" class="slogan"/>
		<nav>
			<ul>
				<li><a href="<?=url?>"<?                if ($perfilenurl == '')         echo ' style="color:#444"'?>>Home</a></li>
				<li><a href="<?=url?>acercade"<?        if ($perfilenurl == 'acercade') echo ' style="color:#444"'?>>Acerca de</a></li>
				<li><a href="<?=url?>quepagar#rubros"<? if ($perfilenurl == 'quepagar') echo ' style="color:#444"'?>>Qué pagar</a></li>
				<li><a href="<?=url?>contacto"<?        if ($perfilenurl == 'contacto') echo ' style="color:#444"'?>>Contacto</a></li>
			</ul>
			<form action="<?=url?>" method="post">
				<div>
					<label>
						DNI
						<input type="text" name="login_dni" id="login_dni" class="typetext"/>
					</label>
					<input type="submit" value="Ingresar" class="typesubmit"/>
				</div>
				<div class="ops_contrasena">
					<a href="<?=url?>registrate">¿Nunca usaste el servicio?</a> |
					<a href="<?=url?>recordarpassword">¿Olvidaste tu contraseña?</a>
				</div>
			</form>
			<script type="text/javascript">
			<!--
				$('[name="login_dni"]').numeric();
			-->
			</script>
		</nav>
	</header>
	<section>
		<div style="height:80px;padding-bottom:20px;">
			<div style="padding:30px 0 0 20px;">
				<a href="#" onclick="$('#login_dni').focus(); return false;"><img src="<?=url?>images/paso-1.gif" alt="" style="float:left;clear:none;"/></a>
				<a href="#"><img src="<?=url?>images/paso-2.gif" alt="" style="float:left;clear:none;"/></a>
				<a href="#"><img src="<?=url?>images/paso-3.gif" alt="" style="float:left;clear:none;"/></a>
				<a href="#"><img src="<?=url?>images/paso-4.gif" alt="" style="float:left;clear:none;"/></a>
			</div>
		</div>
		
