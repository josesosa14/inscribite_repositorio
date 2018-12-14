<?
include_once "../inc.config.php";

$id = $_GET['id'];
if ($_GET['tabla'] == 'inscribite_eventos'){
	$query = 'SELECT codigo,imagen,logo FROM `'.$_GET['tabla'].'` WHERE id = '.$id.' LIMIT 1 ';
}else{
	$query = 'SELECT codigo FROM `'.$_GET['tabla'].'` WHERE id = '.$id.' LIMIT 1 ';
}
$result1 = mysqli_query($coneccion,$query);
if ($result1){ 
	$row1 = mysqli_fetch_array($result1);
}else{
	echo $query;
	die('no se encontraron datos para eliminar');
}


if ($_GET['tabla'] == 'inscribite_eventos'){
	if (file_exists('../imagenes/media_'.$row1['imagen'])) unlink('../imagenes/media_'.$row1['imagen']);
	if (file_exists('../imagenes/logo_'.$row1['logo']))    unlink('../imagenes/logo_'.$row1['logo']);
  $codevent = $row1['codigo'];
  mysqli_query($coneccion,"DELETE FROM inscribite_categorias WHERE deevento = '$codevent' ");
}
mysqli_query($coneccion,"DELETE FROM `".$_GET['tabla']."` WHERE `id` = $id LIMIT 1");

//mysqli_query ("ALTER TABLE `bellaflor_banners` DROP `id` ");
//mysqli_query ("ALTER TABLE `bellaflor_banners` ADD `id` INT( 6 ) NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST ");
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
if (is_resource($result1)) mysqli_free_result($result1);
mysqli_close($coneccion);
?>