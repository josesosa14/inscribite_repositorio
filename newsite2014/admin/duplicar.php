<?php
include_once "../inc.config.php";
error_reporting(E_ALL);

$id = $_GET['id'];
$result1 = mysqli_query($coneccion, 'SELECT * FROM inscribite_eventos WHERE id = ' . $id . ' LIMIT 1 ');
$row1 = mysqli_fetch_array($result1);
if (!$row1) {
    die('falta data');
}
$codigoanterior = $row1['codigo'];

$result2 = mysqli_query($coneccion, 'SELECT id,orden FROM inscribite_eventos ORDER BY orden LIMIT ' . $row1['orden'] . ', 100 ');

while ($row2 = mysqli_fetch_array($result2)) {
    mysqli_query($coneccion, 'UPDATE inscribite_eventos SET orden = "' . ($row2['orden'] + 1) . '" WHERE id = ' . $row2['id'] . ' ');
}


mysqli_query($coneccion, "INSERT INTO inscribite_eventos ( `id`, `orden`, `ver`, `nombre`, `codigo`, `descripcion`, `imagen`, `tipo`, `empresa`, `logo`, `eventodelmes`, `pubdate`)
VALUES ( ''," . ($row1['orden'] + 1) . ",'" . $row1['ver'] . "', '" . $row1['nombre'] . "', '" . $row1['codigo'] . "bis', '" . $row1['descripcion'] . "', '" . $row1['imagen'] . "', '" . $row1['tipo'] . "', '" . $row1['empresa'] . "', '" . $row1['logo'] . "', '" . $row1['eventodelmes'] . "', '" . date("D, d M Y H:i:s") . "');");


$query ="insert into inscribite_categorias(deevento,opcion,nombre,codigo,descripcion,limitedeedad,edadminima,edadmaxima,fechadecomputo,sexo,precio1,precio2,precio3,fechavenc1,fechavenc2,fechavenc3 )
SELECT CONCAT(deevento,'bis'),opcion,nombre,codigo,descripcion,limitedeedad,edadminima,edadmaxima,fechadecomputo,sexo,precio1,precio2,precio3,fechavenc1,fechavenc2,fechavenc3 
FROM `inscribite_categorias`
where deevento='$codigoanterior'";
mysqli_query($coneccion, $query);


if (isset($result1) && is_resource($result1)){
    mysqli_free_result($result1);
}
if (isset($result2) && is_resource($result2)){
		mysqli_free_result($result2);
}
if(isset($coneccion)){
	mysqli_close($coneccion);
}

header("Location:http://www.inscribiteonline.com.ar/newsite2014/admin/?sec=eventos.admin");
