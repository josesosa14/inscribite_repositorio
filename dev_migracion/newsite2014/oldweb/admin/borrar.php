<?
$conexio = mysql_connect("localhost", "inscribite_user", "iW7zNKpRWkSHHwplBhUO");
mysql_select_db("inscribite_base", $conexio);
$id = $_GET['id'];
$result1 = mysql_query('SELECT codigo,imagen,logo FROM `'.$_GET['tabla'].'` WHERE id = '.$id.' LIMIT 1 ');
if (is_resource($result1)) $row1 = mysql_fetch_array($result1);

if (file_exists('../imagenes/media_'.$row1['imagen'])) unlink('../imagenes/media_'.$row1['imagen']);
if (file_exists('../imagenes/logo_'.$row1['logo']))    unlink('../imagenes/logo_'.$row1['logo']);

if ($_GET['tabla'] == 'inscribite_eventos'){
  $codevent = $row1['codigo'];
  mysql_query("DELETE FROM inscribite_categorias WHERE deevento = $codevent ");
}
mysql_query("DELETE FROM `".$_GET['tabla']."` WHERE `id` = $id LIMIT 1");

//mysql_query ("ALTER TABLE `bellaflor_banners` DROP `id` ");
//mysql_query ("ALTER TABLE `bellaflor_banners` ADD `id` INT( 6 ) NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST ");
$volvera = str_replace("amp;", "&", $_GET['volvera']);
?>
<html>
<head>
<?php /*<meta http-equiv="refresh" content="0;URL = <?php echo $_SERVER[HTTP_REFERER]; ?>"> */ ?>
</head>
<body>
<script type="text/javascript">
<!--
<?php if (substr($_GET['volvera'], 0, 3) == '../'){ ?>
    location.href = '<?=str_replace("idcreada", $idActual,str_replace('amp;', '&', $_GET['volvera']))?>';
<?php } else { ?>
    location.href = './?sec=<?=str_replace("idcreada", $idActual,str_replace('amp;', '&', $_GET['volvera']))?>';
<?php } ?>
-->
</script>
</body>
</html><?
if (is_resource($result1)) mysql_free_result($result1);
mysql_close();
?>