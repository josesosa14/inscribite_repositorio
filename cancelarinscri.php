<?
//header("Content-type: text/html; charset=UTF-8");
//header("Cache-Control: no-cache, must-revalidate");  // HTTP/1.1
//header("Pragma: no-cache");                          // HTTP/1.0
ob_start();
include_once 'inc.config.php';

$id = $_GET['id'];

$result1 = mysql_query('SELECT * FROM '.pftables.'inscripciones WHERE id = '.$id.' LIMIT 1 ');
$row1 = mysql_fetch_array($result1);

//mysql_query('UPDATE '.pftables.'eventos SET cuporestanteop'.$row1['opcion'].'=cuporestanteop'.$row1['opcion'].'+1 WHERE codigo = "'.$row1['deevento'].'" ');

mysql_query('UPDATE '.pftables.'opciones SET cuporestante = cuporestante+1 WHERE (evento = "'.$row1['deevento'].'" OR evento = "'.($row1['deevento']*1).'") AND nombre = "'.$row1['opcion'].'" ');

mysql_query('DELETE FROM `'.pftables.'inscripciones` WHERE `id` = '.$id.' LIMIT 1');

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
location.href = 'usuario';
-->
</script>
</body>
</html>