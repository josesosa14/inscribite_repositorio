<?
include_once 'inc.funciones.php';
setcookie("alogin_hash", "", time()-3600, "/");
mysql_query('DELETE FROM '.pftables.'sesiones WHERE hash = "'.chash($localPass.$loginhash).'" LIMIT 1');
mysql_close();
?><script type="text/javascript">
  location.href = '<?=($_SERVER['HTTP_REFERER'] != '')?$_SERVER['HTTP_REFERER']:'./'?>';
</script>