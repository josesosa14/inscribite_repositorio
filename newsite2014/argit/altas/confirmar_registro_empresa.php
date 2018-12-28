<?php
require_once dirname(__FILE__) . '/../general/db.php';
$general_path = "http://127.0.0.1/empresas/";
$general_path2 = "http://127.0.0.1/empresas/";
$emp_id = $_GET['emp_id'];

$query = 'UPDATE empresa SET emp_estado=1 WHERE emp_id = '. $emp_id;
runQuery($query,$mysqli);

 header('Location:' . $general_path2.'?registrado=true');

?>