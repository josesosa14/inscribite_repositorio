<?
$conexio = mysql_connect("localhost", "inscribite_user", "iW7zNKpRWkSHHwplBhUO");
mysql_select_db("inscribite_base", $conexio);
$id = $_GET['id'];
$result1 = mysql_query('SELECT * FROM inscribite_eventos WHERE id = '.$id.' LIMIT 1 ');
if (is_resource($result1)) $row1 = mysql_fetch_array($result1);
$codigoanterior = $row1['codigo'];

$result2 = mysql_query('SELECT id,orden FROM inscribite_eventos ORDER BY orden LIMIT '.$row1['orden'].', 100 ');
if (is_resource($result2)){
  while ($row2 = mysql_fetch_array($result2))
    mysql_query('UPDATE inscribite_eventos SET orden = "'.($row2['orden']+1).'" WHERE id = '.$row2['id'].' ');
}

mysql_query("INSERT INTO inscribite_eventos ( `id`, `orden`, `ver`, `nombre`, `codigo`, `descripcion`, `imagen`, `tipo`, `empresa`, `logo`, `eventodelmes`, `pubdate`)
VALUES ( '',".($row1['orden']+1).",'".$row1['ver']."', '".$row1['nombre']."', '".$row1['codigo']."bis', '".$row1['descripcion']."', '".$row1['imagen']."', '".$row1['tipo']."', '".$row1['empresa']."', '".$row1['logo']."', '".$row1['eventodelmes']."', '".date("D, d M Y H:i:s")."');");

$result2 = mysql_query('SELECT * FROM inscribite_categorias WHERE deevento = "'.$codigoanterior.'" ');
if (is_resource($result2)){
  while ($row2 = mysql_fetch_array($result2)){
    mysql_query("INSERT INTO inscribite_categorias ( `id`, `deevento`, `opcion`, `nombre`, `codigo`, `descripcion`, `limitedeedad`, `edadminima`, `edadmaxima`, `fechadecomputo`, `sexo`, `precio1`, `precio2`, `precio3`, `fechavenc1`, `fechavenc2`, `fechavenc3`)
    VALUES ( '', '".$codigoanterior."bis', '".$row2['opcion']."', '".$row2['nombre']."', '".$row2['codigo']."', '".$row2['descripcion']."', '".$row2['limitedeedad']."', '".$row2['edadminima']."', '".$row2['edadmaxima']."', '".$row2['fechadecomputo']."', '".$row2['sexo']."', '".$row2['precio1']."', '".$row2['precio2']."', '".$row2['precio3']."', '".$row2['fechavenc1']."', '".$row2['fechavenc2']."', '".$row2['fechavenc3']."');");
  }
}
?>
<html>
<head>
<?php /*<meta http-equiv="refresh" content="0;URL = <?php echo $_SERVER[HTTP_REFERER]; ?>"> */ ?>
</head>
<body>
<script type="text/javascript">
<!--
    location.href = './';
-->
</script>
</body>
</html><?
if (is_resource($result1)) mysql_free_result($result1);
if (is_resource($result2)) mysql_free_result($result2);
if (is_resource($result3)) mysql_free_result($result3);
mysql_close();
?>