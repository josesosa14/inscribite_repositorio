<?php
$conexio = mysql_connect("localhost", "inscribite_user", "iW7zNKpRWkSHHwplBhUO");
mysql_select_db("inscribite_base", $conexio);

$result1 = mysql_query('SELECT * FROM inscribite_inscripciones WHERE pagado = 0 AND venceeldia != 0 AND venceeldia < '.date("Ymd").' ');
while ($row1 = mysql_fetch_array($result1)) {
  mysql_query("UPDATE inscribite_eventos SET cuporestanteop".$row1['opcion']." = cuporestanteop".$row1['opcion']."+1 WHERE codigo = '".$row1['deevento']."' ");

  mysql_query("UPDATE inscribite_opciones SET cuporestante = cuporestante + 1 WHERE evento = '".$row1['deevento']."' AND nombre = '".$row1['opcion']."' ");
}

mysql_query("DELETE FROM inscribite_inscripciones WHERE pagado = 0 AND venceeldia!= 0 AND venceeldia<".date("Ymd"));

if (is_resource($result1)) mysql_free_result($result1);
if (is_resource($result2)) mysql_free_result($result2);
if (is_resource($result3)) mysql_free_result($result3);
mysql_close();
?>
<script type="text/javascript">
<!--
    location.href = './';
-->
</script>