<?php

require_once dirname(__FILE__) . '/../general/db.php';

if ($_POST && !isset($_SESSION['empresa'])) {

//print_r($_POST);die;    
//parceamos y traemos info del user
	//$empresa = $_POST['usuario'];
	//$password = $_POST['password'];
    $empresa = addslashes(filter_input(INPUT_POST, 'usuario'));
    $password = addslashes(filter_input(INPUT_POST, 'password'));
	
    $query = 'SELECT emp_password,emp_id,emp_nombre,emp_estado FROM empresa WHERE emp_usuario = "'. $empresa.'"';
    $empresa_info = getRowQuery($query, $mysqli);
	//print_r($empresa_info);die;	
    if ($empresa_info) {
        if ($empresa_info['emp_password'] == $password && $empresa_info['emp_estado'] == 1) {
            $_SESSION['empresa'] = $empresa_info['emp_id'];
            $_SESSION['empresa_nombre'] = $empresa_info['emp_nombre'];
			
            header('Location:'.$general_path.'empresas/empresa.php');
        } else {
            header('Location:'.$general_path.'empresas/index.php');
        }
    }else {
        header('Location:' . $general_path . 'empresa.php');
    }
}
elseif (isset($_SESSION['empresa'])){
    header('Location:'.$general_path .'empresas/empresa.php');
}
