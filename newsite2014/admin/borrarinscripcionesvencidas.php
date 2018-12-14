<?php
include_once "../inc.config.php";

$result1 = mysqli_query($coneccion,'SELECT * FROM inscribite_inscripciones WHERE pagado = 0 AND venceeldia != 0 AND venceeldia < '.date("Ymd").' ');
while ($row1 = mysqli_fetch_array($result1)) {
  mysqli_query($coneccion,"UPDATE inscribite_eventos SET cuporestanteop".$row1['opcion']." = cuporestanteop".$row1['opcion']."+1 WHERE codigo = '".$row1['deevento']."' ");

  mysqli_query($coneccion,"UPDATE inscribite_opciones SET cuporestante = cuporestante + 1 WHERE evento = '".$row1['deevento']."' AND nombre = '".$row1['opcion']."' ");
}

mysqli_query($coneccion,"UPDATE inscribite_inscripciones SET eliminada=1 WHERE pagado = 0 AND venceeldia!= 0 AND venceeldia<".date("Ymd"));

if (is_resource($result1)) mysqli_free_result($result1);
if (is_resource($result2)) mysqli_free_result($result2);
if (is_resource($result3)) mysqli_free_result($result3);
mysqli_close($coneccion);
?>
<script type="text/javascript">
<!--
    location.href = './';
-->
</script>