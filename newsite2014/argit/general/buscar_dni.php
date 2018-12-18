<?php

require_once dirname(__FILE__) . '/../general/db.php';

header('Access-Control-Allow-Origin: *');

if(isset($_POST['action'])) {
	if($_POST['action'] == "checkDni") {
	
	$dni = $_POST['dni'];	
	$query = 'SELECT dni FROM inscribite_usuarios WHERE dni = '. $dni;
	$user_info = getRowQuery($query, $mysqli);
	if($user_info) {
	$respuesta = 1;
	echo json_encode($respuesta);
	exit();
	} else {
	$respuesta = 0;
	echo json_encode($respuesta);
	exit();
	
	}
	} else {
	$respuesta = "Sal de aqui maldito instruso";
	echo json_encode($respuesta);
	exit();
	}


} else {
	$respuesta = "Sal de aqui maldito instruso";
	echo json_encode($respuesta);
	exit();
}