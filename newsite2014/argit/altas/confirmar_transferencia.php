<?php

require_once dirname(__FILE__) . '/../general/db.php';
$general_path = "http://127.0.0.1/";
$general_path2 = "http://127.0.0.1/";

if (isset($_GET['tra_id'])) {
    $tra_id = addslashes(filter_input(INPUT_GET,'tra_id'));
    
    runQuery("UPDATE transferencias SET tra_recibida = 1 WHERE tra_id = $tra_id",$mysqli);
	
	if(isset($_SESSION['empresa'])){
		header('Location:../empresas/transferencias.php#toShow');
	}
	else{
		header('Location:../index.php');
	}
} else {
    header('Location:../index.php');
}




