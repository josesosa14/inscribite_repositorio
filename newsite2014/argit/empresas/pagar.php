<?php
require_once dirname(__FILE__) . '/../general/header_empresa.php';
if (!isset($_SESSION['empresa'])) {
    $destino = $general_path.'empresas/index.php';
}else if($_GET) {
	$destino = $general_path.'empresas/mensualidades.php';
	$mec_id = addslashes($_GET['mec_id']);
	$dni = addslashes($_GET['usu_id']);
	$yaPago = getRowQuery("SELECT meu_id FROM mensualidad_cuota_usuario WHERE meu_u_dni = $dni AND meu_mec_id = $mec_id",$mysqli);
	if(!$yaPago){
		$parameters['meu_u_dni'] = $dni;
		$parameters['meu_mec_id'] = $mec_id;
		$parameters['meu_importe'] = 0;
		$parameters['meu_fecha'] = date('Y-m-d h:i:s');
		insertRow('mensualidad_cuota_usuario',$parameters,$mysqli);
	}
	
	echo 'cuota paga <a href="http://www.inscribiteonline.com.ar/empresas/mensualidades.php" >Volver</a>';
}


