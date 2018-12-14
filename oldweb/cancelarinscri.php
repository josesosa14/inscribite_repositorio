<?php
//header("Content-type: text/html; charset=UTF-8");
//header("Cache-Control: no-cache, must-revalidate");  // HTTP/1.1
//header("Pragma: no-cache");                          // HTTP/1.0
ob_start();
$conexio = mysql_connect("localhost", "inscribite_user", "iW7zNKpRWkSHHwplBhUO");
mysql_select_db("inscribite_base", $conexio);
$id = $_GET['id'];

$result1 = mysql_query('SELECT * FROM inscribite_inscripciones WHERE id='.$id.' LIMIT 1 ');
$row = mysql_fetch_array($result1);

//mysql_query("UPDATE inscribite_eventos SET cuporestanteop".$row['opcion']."=cuporestanteop".$row['opcion']."+1 WHERE codigo='".$row['deevento']."' ");

mysql_query("UPDATE inscribite_opciones SET cuporestante=cuporestante+1 WHERE (evento='".$row['deevento']."' OR evento='".($row['deevento']*1)."') AND nombre='".$row['opcion']."' ");

mysql_query("DELETE FROM `inscribite_inscripciones` WHERE `id`=$id LIMIT 1");

if (is_resource($result1)) mysql_free_result($result1);
//if (is_resource($result2)) mysql_free_result($result2);
//if (is_resource($result3)) mysql_free_result($result3);
mysql_close();
?><html>
<head>
<? /*<meta http-equiv="refresh" content="0;URL=<?=$_SERVER[HTTP_REFERER]?>"> */ ?>
</head>
<body>
<script type="text/javascript">
<!--
location.href='usuario/<?=$_GET['dni']?>';
-->
</script>
</body>
</html>