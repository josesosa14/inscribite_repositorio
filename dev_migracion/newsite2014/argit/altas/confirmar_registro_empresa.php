<?php
require_once dirname(__FILE__) . '/../general/db.php';
$general_path = "http://www.inscribiteonline.com.ar/empresas/";
$general_path2 = "http://www.inscribiteonline.com.ar/empresas/";
$emp_id = $_GET['emp_id'];

$query = 'UPDATE empresa SET emp_estado=1 WHERE emp_id = '. $emp_id;
runQuery($query,$mysqli);

 header('Location:' . $general_path2.'?registrado=true');

?>