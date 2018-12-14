<?php
//require_once dirname(__FILE__) . '/../general/header_empresa.php';
require_once dirname(__FILE__).'/../general/db.php';
//require classes
require_once dirname(__FILE__).'/../Classes/PHPExcel.php';
require_once dirname(__FILE__).'/../Classes/PHPExcel/IOFactory.php';

$path = "descuentos/";

//si no hay error en la subida
if ($_FILES['descuentos']['error'] == 0) {

	//verifico si es repetido
	if (file_exists($path . $_FILES['descuentos']['name'])) {
		die('ya existe');
	} else {
		if (move_uploaded_file($_FILES['descuentos']["tmp_name"], $path . $_FILES['descuentos']["name"])) {
			//echo 'lindo';
		} else {
			die('No se pudo cargar el archivo');
		}
	}
}

$full_path = dirname(__FILE__).'/'.$path.$_FILES['descuentos']['name'];


//cargamos el archivo
$objPHPExcel = PHPExcel_IOFactory::load($full_path);
$worksheet = $objPHPExcel->setActiveSheetIndex(0);

	$worksheetTitle     = $worksheet->getTitle();
	$highestRow         = $worksheet->getHighestRow(); // e.g. 10
	$highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
	$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
	$nrColumns = ord($highestColumn) - 64;  


for ($row = 2; $row <= $highestRow; ++ $row) {
	$val=array();
	
	for ($col = 0; $col < $highestColumnIndex; ++ $col) {
		$cell = $worksheet->getCellByColumnAndRow($col, $row)->getValue();
		$val[] = $cell;
	}
		$val2=array();
		
		foreach ($val as $rwx) {
			$mx = $mysqli->real_escape_string($rwx);
			$val2[]=$mx;
		}
		//$fecha = date("d/m/Y");
		$query_array[] = '("'.$val2[0].'","'.$val2[1].'","'.$fecha.'","'.$val2[2].'")';
}
		
$query = "INSERT INTO inscribite_descuentos(`codevento`,`coddni`, `fechausado`, `porcentajedescuento`) 
			VALUES "; 
$i=0;

foreach($query_array as $key => $value) {
	if(++$i === count($query_array))$query .= $value .';';
	else $query .= $value .',';
}

//query y verificamos si todo bien

runQuery($query,$mysqli);
header("Location: http://www.inscribiteonline.com.ar/empresas/descuentos.php?envio=1");
