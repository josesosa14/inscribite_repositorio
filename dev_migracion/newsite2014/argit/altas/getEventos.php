<?php

require_once dirname(__FILE__) . '/../general/db.php';

if (isset($_GET['emp_id'])) {
    $emp_id = addslashes(filter_input(INPUT_GET,'emp_id'));
    
	$query = "SELECT nombre,id FROM inscribite_eventos WHERE empresa = (SELECT emp_nombre FROM empresa WHERE emp_id = $emp_id)";
	
	$eventos = getArrayQuery($query,$mysqli);	
	
	foreach ($eventos as $evento) {
		$out .= '<option value="'.$evento['id'].'">'.($evento['nombre']).'</option>';
	}
	
	echo $out;	
}




