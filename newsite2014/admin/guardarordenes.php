<?php header("Content-type: text/html; charset=UTF-8");

include_once "../inc.config.php";

foreach($_POST as $nombrevariable => $valorvariable) {
  if (($nombrevariable!= 'id') && ($nombrevariable!= 'tabla') && ($nombrevariable!= 'imagen') && (substr($nombrevariable, 0, 11) != 'vencimiento')){
    $idActual = substr($nombrevariable, 5, 100);
    mysqli_query ("UPDATE ".$_POST['tabla']." SET orden = \"".$valorvariable."\" WHERE id = $idActual");
  }
}

if (is_resource($result1))mysqli_free_result($result1);
if (is_resource($result2))mysqli_free_result($result2);
if (is_resource($result3))mysqli_free_result($result3);
mysqli_close($coneccion);
?>
<script type="text/javascript">
<!--
location.href = './?sec=<?=$_POST['volvera']?>';
-->
</script>
<a href="./?sec=<?=$_POST['volvera']?>">Volver</a>