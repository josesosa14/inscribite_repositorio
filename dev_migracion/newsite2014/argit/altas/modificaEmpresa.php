<?php

require_once dirname(__FILE__) . '/../general/db.php';

//if ($_POST && $_SESSION['empresa_id']) {
if ($_POST) {
    $parameters = parseParameters($_POST);

    //autocommit off
	$mysqli->autocommit(false);

	try {
	
		$where = array("emp_id" => $parameters['emp_id']);
		//empresa
		actualizarRow('empresa', $parameters,$where, $mysqli);
		
		$where = array("empc_emp_id" => $parameters['emp_id']);
		$parameters['empc_emp_id'] = $parameters['emp_id'];
		//empresa
		actualizarRow('empresa_contacto', $parameters,$where, $mysqli);
		
		$where = array("empb_emp_id" => $parameters['emp_id']);
		$parameters['empb_emp_id'] = $parameters['emp_id'];
		/*$parameters['empb_fecha_alta'] = date("Y-m-d",strtotime($parameters['empb_fecha_alta']));
		$parameters['empb_fecha_mod'] = date("Y-m-d",strtotime($parameters['empb_fecha_mod']));*/
		
		//empresa
		actualizarRow('empresa_banco', $parameters,$where, $mysqli);
		
		//si no hubieron errores ejecutamos todas las queries
		$mysqli->commit();
		
		$email = "info@inscribiteonline.com.ar";
		$asunto = "Inscribite Online - Datos Empresa Modificados";
		$info_adicional = "From: Inscribite Online <info@inscribiteonline.com.ar>\r\nContent-Type: text/html;charset=utf-8\r\n";
		$mensaje = "";
		
		include 'mail_modificaEmpresa.php';		
		
		mail($email, $asunto, $mensaje, $info_adicional);
		
		header('Location:' . $general_path . 'modificaEmpresa.php?empresa_id='.$parameters['emp_id']);
	
	} catch (Exception $e) {
		// Ejecutamos el rollback para deshacer los cambios.
		$mysqli->rollback();
		echo 'Excepción capturada: ', $e->getMessage(), "\n";
	}
} else {
    header('Location:' . $general_path . 'index_argit.php');
}
