<?php

require_once dirname(__FILE__) . '/../general/db.php';

if ($_POST) {
    $parameters = parseParameters($_POST);
    $parameters['puntos'] = 0;
    $parameters['entrenador'] = "";
    $parameters['pileta'] = "";
    
	$user_info = getRowQuery("SELECT fechanac,dni,nombre,apellido FROM inscribite_usuarios WHERE dni = '{$_SESSION['usuario']}'",$mysqli);
	$parameters['fechanac'] = $user_info['fechanac'];
	$parameters['dni'] = $user_info['dni'];
	$parameters['nombre'] = $user_info['nombre'];
	$parameters['apellido'] = $user_info['apellido'];	

    $where = array("id" => $_SESSION['user_id']);
    //usuario
    actualizarRow('inscribite_usuarios', $parameters,$where, $mysqli);
    header('Location:' . $general_path . 'miCuenta.php');
} else {
    header('Location:' . $general_path . 'index_argit.php');
}
