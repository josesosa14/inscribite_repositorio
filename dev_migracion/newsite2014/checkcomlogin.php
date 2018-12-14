<?
include_once 'inc.config.php';

if ($_GET['dni'] == "") $_GET['dni'] = 'ac98';

$result1 = mysql_query('SELECT * FROM '.pftables.'comercial WHERE dni="'.$_GET['dni'].'" LIMIT 1 ');
if (mysql_num_rows($result1) > 0)
	echo 'document.getElementById(seccionaactualizar).innerHTML='."'".'<label>Contraseña</label><input type="password" name="passw" id="inputpassw" value="" maxlength="18"/>'."';document.getElementById(".'"'."formdelogin".'"'.").action='';";
else
	echo 'location.href="registrate"';

if (is_resource($result1)) mysql_free_result($result1);
mysql_close();
?>