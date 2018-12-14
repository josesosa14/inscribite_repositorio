<?php
require_once dirname(__FILE__) . '/general/db.php';


if ($_GET) {
	$mec_id =addslashes($_GET['mec_id']);
	$query = "UPDATE facturas SET fac_anulado = 1 WHERE fac_mensualidad = $mec_id AND fac_usu_id = {$_SESSION['user_id']}";
	runQuery($query, $mysqli);
}
header("Location:http://www.inscribiteonline.com.ar/miCuenta.php");
?>