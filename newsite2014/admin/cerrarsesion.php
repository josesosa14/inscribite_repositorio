<?php
include_once 'inc.funciones.php';
setcookie("alogin_hash", "", time()-3600, "/");
mysqli_query($coneccion,'DELETE FROM '.pftables.'sesiones WHERE hash = "'.chash($localPass.$loginhash).'" LIMIT 1');
mysqli_close($coneccion);
session_start();
session_unset();
session_destroy();
$_SESSION = array();
?><script type="text/javascript">
  location.href = '<?=($_SERVER['HTTP_REFERER'] != '')?$_SERVER['HTTP_REFERER']:'./'?>';
</script>