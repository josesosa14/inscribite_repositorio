<?php
error_reporting(-1);
include dirname(__FILE__) . '/../general/db.php';
if ($_GET['id']){
	$men_id = addslashes($_GET['id']);
	
	$query = "UPDATE mensualidades SET men_activo = CASE WHEN men_activo = 0 THEN 1 ELSE 0 END WHERE men_id = $men_id";
	runQuery($query,$mysqli);
	
  header('Location:../mensualidades.php');
}

