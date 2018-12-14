<?php header("Content-type: text/html; charset=UTF-8");

include_once "../inc.config.php";

$idActual = $_GET['id'];

mysqli_query ("UPDATE inscribite_inscripciones SET pagado = 1 WHERE id = $idActual");

if (is_resource($result1))  mysqli_free_result($result1);
if (is_resource($result2)) mysqli_free_result($result2);
if (is_resource($result3)) mysqli_free_result($result3);
mysqli_close($coneccion);
?>
document.getElementById("inpagado<?=$_GET['id']?>").checked="checked";
