<? header("Content-type: text/html; charset=UTF-8");

$conexio = mysql_connect("localhost", "inscribite_user", "iW7zNKpRWkSHHwplBhUO");
mysql_select_db("inscribite_base", $conexio);

$idActual = $_GET['id'];

mysql_query ("UPDATE inscribite_inscripciones SET pagado = 1 WHERE id = $idActual");

if (is_resource($result1))  mysql_free_result($result1);
if (is_resource($result2)) mysql_free_result($result2);
if (is_resource($result3)) mysql_free_result($result3);
mysql_close();
?>
document.getElementById("inpagado<?=$_GET['id']?>").checked="checked";
