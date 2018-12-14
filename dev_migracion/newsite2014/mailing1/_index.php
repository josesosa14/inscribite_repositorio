<?php include_once '../inc.config.php';
?><!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
<head>
	<title></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js"></script>
</head>
<body>
<?
$cuenta = 0;
$result1 = mysql_query($q = 'SELECT * FROM '.pftables.'usuarios GROUP BY email ORDER BY apellido ASC LIMIT 100');
?>
<div id="mensaje1" style="margin-bottom:15px;">Enviando email <span id="nroenviado">1</span> de <?=mysql_num_rows($result1)?></div>
<?
while ($row1 = mysql_fetch_array($result1)) {
	$cuenta++;
	echo $cuenta.': '.$row1['nombre'].', '.$row1['nombre'].' : <span id="email'.$cuenta.'">'.$row1['email'].'</span><br/>'.chr(13);
}

if (isset($result1)){ if (is_resource($result1)) mysql_free_result($result1); }
if (isset($result2)){ if (is_resource($result2)) mysql_free_result($result2); }
mysql_close();
?>
<script type="text/javascript">
nroenviado = 1;
function iniciarEnvio() {
	$.ajax({
		url: "ajx.enviaemail?email="+$('#email'+nroenviado).html(),
		context: document.body,
		success: function(){
			nroenviado++;
			$('#nroenviado').html(nroenviado);
			setTimeout("reiniciarEnvio()", 5000);
		}
	});
}
iniciarEnvio();
function reiniciarEnvio() {
	iniciarEnvio();
}
</script>
</body>
</html>