<?php //header("Content-type: text/html; charset=UTF-8"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es" >
<head>
<?php //<link rel="SHORTCUT ICON" href="" /> ?>
<title>decoder</title>

<meta name="ROBOTS" content="NOARCHIVE" />

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style type="text/css" >
<!--
-->
</style>
<script type="text/javascript" >
<!--
	function muestraborrar(nro) {
		nuevoestado = 'visible';
		if ( document.getElementById('borra'+nro).style.visibility == 'visible' )
			nuevoestado = 'hidden';
			
		document.getElementById('borra'+nro).style.visibility = nuevoestado;
	}
	function muestra(nro) {
		nuevoestado = 'block';
		if ( document.getElementById('masinfo'+nro).style.display == 'block' )
			nuevoestado = 'none';
			
		document.getElementById('masinfo'+nro).style.display = nuevoestado;
	}
-->
</script>
</head>
<body>
<a href="items">Volver</a><br />

<form action="deco.php" method="post">
<textarea name="conte" rows="20" cols="60"></textarea>
<input type="submit" />
</form>

</body>
</html>
