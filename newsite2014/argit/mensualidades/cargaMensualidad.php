<?php
error_reporting(-1);
include dirname(__FILE__) . '/../general/db.php';
if ($_POST) {
	$parameters['men_imagen'] = $_FILES['mensualidad_logo']['name'];
	$parameters['men_nombre'] = addslashes($_POST['men_nombre']);
	$parameters['men_descripcion'] = addslashes($_POST['men_descripcion']);
	$parameters['men_texto_cupon'] = addslashes($_POST['men_texto_cupon']);
	$parameters['men_precio'] = addslashes($_POST['men_precio']);
	$parameters['men_dias_recargo'] = addslashes($_POST['men_dias_recargo']);
	$parameters['men_recargo'] = addslashes($_POST['men_recargo']);
	$parameters['men_activo'] = 1;
	$parameters['men_tipo_pago'] = addslashes($_POST['men_tipo_pago']);
	$parameters['men_codigo'] = addslashes($_POST['men_codigo']);
	$parameters['men_empresa'] = addslashes($_POST['men_empresa']);
	$parameters['men_cuotas'] = addslashes($_POST['men_cuotas']);
	$parameters['men_punitorio'] = addslashes($_POST['men_punitorio']);


	insertRow('mensualidades', $parameters, $mysqli);
	$men_id = $mysqli->insert_id;
	
	subirImagen($_FILES,$men_id);

	foreach($_POST['mes'] as $key => $mes){
		$out[$key] = $mes;
		$out[$key]['mec_men_id'] = $men_id;
		$out[$key]['mec_nro_cuota'] = $key;
	}
		
	insertArray('mensualidad_cuotas',$out,$mysqli);
	
	
  header('Location:../mensualidades.php');
}

