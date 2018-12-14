<?php
error_reporting(-1);
include dirname(__FILE__) . '/../general/db.php';

if ($_GET) {
	$mec_id = addslashes($_GET['mec_id']);
	$dni = addslashes($_GET['usu_id']);
	$parameters['meu_u_dni'] = $dni;
	$parameters['meu_mec_id'] = $mec_id;
	$parameters['meu_importe'] = 0;
	$parameters['meu_fecha'] = date('Y-m-d h:i:s');
	insertRow('mensualidad_cuota_usuario',$parameters,$mysqli);
	
  header('Location:../usuariosMensualidades.php');
}

