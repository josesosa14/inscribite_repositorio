<?php
error_reporting(0);
include dirname(__FILE__) . '/../general/db.php';
if ($_POST) {
    foreach ($_POST['facturas'] as $key => $factura) {
        if ($key == 0) {
            $facturas_id = $factura;
        } else {
            $facturas_id .= ',' . $factura;
        }
    }
    $query = "UPDATE facturas SET fac_pedido = 0 WHERE fac_id in ($facturas_id)";
    runQuery($query, $mysqli);
	
	echo 'FACTURAS MODIFICADAS EXITOSAMENTE!!, <a href="<a href="http://www.inscribiteonline.com.ar/pagoMisCuentas.php">volver a cargarlas</a>';
}

