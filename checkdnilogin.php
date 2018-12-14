<? include_once 'inc.config.php';

if ($_GET['dni'] == "") $_GET['dni'] = 'ac98';

$result1 = mysql_query('SELECT * FROM '.pftables.'usuarios WHERE dni = "'.$_GET['dni'].'" LIMIT 1 ');
if (mysql_num_rows($result1) > 0) {
  echo 0;
  //'document.getElementById(seccionaactualizar).innerHTML='."'".'CLAVE <input type="password" name="passw" id="inputpassw" value="" class="search" maxlength="18"/>'."';document.getElementById(".'"'."formdelogin".'"'.").action='';";
  //echo 'location.href="quepagar"';
} else {
  echo 1;
  //'location.href="registrate"';
}

if (is_resource($result1)) mysql_free_result($result1);
mysql_close();
?>

