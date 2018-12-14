<?php
error_reporting(-1);
include dirname(__FILE__) . '/../general/db.php';
if ($_POST) {
	$parameters = $_POST;

	$men_id = addslashes($_POST['men_id']);
	$parameters['men_activo'] = 1;
	$parameters['men_cuotas'] = count($_POST['mes']);
	if($_FILES['mensualidad_logo']['name']){
		$parameters['men_imagen'] = $_FILES['mensualidad_logo']['name'];
		subirImagen($_FILES,$men_id);
	}else{
		$data = getRowQuery("SELECT men_imagen FROM mensualidades WHERE men_id= $men_id ",$mysqli);
		$parameters['men_imagen'] = $data['men_imagen'];
	}
	actualizarRow('mensualidades',$parameters,array("men_id" => $men_id),$mysqli);	
	$nro_cuota = 1;
	foreach ($_POST['mes'] as $key => $cuota_actualizar) {
		if (isset($cuota_actualizar['mec_id'])) {
			$cuota_actualizar['mec_nro_cuota'] = $nro_cuota;
			$cuota_actualizar['mec_men_id'] = $men_id;
			actualizarRow('mensualidad_cuotas', $cuota_actualizar, array("mec_id" => $cuota_actualizar['mec_id']),$mysqli);
			if ($key == 0) {
				$cuotas_salvadas .= $cuota_actualizar['mec_id'];
			} else {
				$cuotas_salvadas .= ',' . $cuota_actualizar['mec_id'];
			}
			$nro_cuota++;
		}
	}
	runQuery("delete from mensualidad_cuotas where mec_men_id = $men_id and mec_id not in($cuotas_salvadas)",$mysqli);
	foreach ($_POST['mes'] as $key => $cuota_insertar) {
		if (!isset($cuota_insertar['mec_id'])) {
			$cuota_insertar['mec_men_id'] = $men_id;
			$cuota_insertar['mec_nro_cuota'] = $nro_cuota;
			insertRow('mensualidad_cuotas',$cuota_insertar,$mysqli);
			$nro_cuota++;
		}
	}
	
  header('Location:../mensualidades.php');
}

