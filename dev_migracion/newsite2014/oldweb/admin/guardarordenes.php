<?php header("Content-type: text/html; charset=UTF-8");

$conexio = mysql_connect("localhost", "inscribite_user", "iW7zNKpRWkSHHwplBhUO");
mysql_select_db("inscribite_base", $conexio);

foreach($_POST as $nombrevariable => $valorvariable) {
  if (($nombrevariable!= 'id') && ($nombrevariable!= 'tabla') && ($nombrevariable!= 'imagen') && (substr($nombrevariable, 0, 11) != 'vencimiento')){
    $idActual = substr($nombrevariable, 5, 100);
    mysql_query ("UPDATE ".$_POST['tabla']." SET orden = \"".$valorvariable."\" WHERE id = $idActual");
  }
}

if (is_resource($result1))mysql_free_result($result1);
if (is_resource($result2))mysql_free_result($result2);
if (is_resource($result3))mysql_free_result($result3);
mysql_close();
?>
<script type="text/javascript">
<!--
location.href = './?sec=<?=$_POST['volvera']?>';
-->
</script>
<a href="./?sec=<?=$_POST['volvera']?>">Volver</a>