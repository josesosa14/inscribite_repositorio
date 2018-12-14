<?php
require_once dirname(__FILE__) . '/../admin/general/db.php';

$query = "SELECT fac_id FROM facturas INNER JOIN facturas_pagas ON facp_fac_id = fac_id WHERE facp_avisado <> 1 OR facp_avisado is null";
$facturas =  getArrayQuery($query,$mysqli);


//limpiamos las variables
$para = "";
$cabeceras = "";
$mensaje = "";
$título = "";

//formamos detalles
foreach ($facturas as $factura) {

//limpiamos las variables
$para = "";
$cabeceras = "";
$mensaje = "";
$título = "";

        $query = "SELECT *,u.email as email_usuario,u.nombre usu_nombre,u.apellido usu_apellido,e.nombre evento_nombre,
					e.fecha evento_fecha,o.nombre op_nombre,c.nombre cat_nombre
					FROM facturas 
                    INNER JOIN inscribite_eventos e ON e.codigo = fac_evento_id
                    INNER JOIN inscribite_opciones o ON o.id = fac_op_id AND o.evento = fac_evento_id
                    INNER JOIN inscribite_categorias c ON c.deevento = fac_evento_id AND c.codigo = fac_cat_id
                    INNER JOIN inscribite_usuarios u ON u.id = fac_usu_id
                    WHERE fac_id = {$factura['fac_id']}";
        $inscripcion = getRowQuery($query, $mysqli);

        if (!empty($mysqli->error)) {
            throw new Exception('Fallo trayendo datos' . $query . '<br>' . $mysqli->error);
        }
		
		$para = ' '.$inscripcion['usu_nombre'].' '.$inscripcion['usu_apellido'].' <'.$inscripcion['email_usuario'].'>'; // con coma si son más
		//$para = 'dedieu92g@gmail.com';
		// título
		$título = 'Confirmacion de Pago Inscribite Online';
		// Para enviar un correo HTML, debe establecerse la cabecera Content-type
		$cabeceras = 'MIME-Version: 1.0' . "\r\n";
		$cabeceras .= 'Content-type: text/html; charset=UTF-8' . "\r\n";

		// Cabeceras adicionales
		//$cabeceras .= 'To: Usuario <'.$inscripcion['email_usuario'].'>' . "\r\n";
		$cabeceras .= 'From: Recordatorio <info@inscribiteonline.com.ar>' . "\r\n";
		$cabeceras .= 'Cc: Recordatorio <info@inscribiteonline.com.ar>' . "\r\n";		
		
        if ($inscripcion['tipo'] == 'Deportivos') {
            include 'mail_deportivos.php';
        }
		elseif ($inscripcion['tipo'] == 'Servicios') {
            include 'mail_servicios.php';
        }
        elseif ($inscripcion['tipo'] == 'Productos') {
            include 'mail_productos.php';
        }
        elseif ($inscripcion['tipo'] == 'CapacitaciÃ³n') {
            include 'mail_capacitacion.php';
        }
		

		header('Content-Type: text/html; charset=UTF-8'); 
		
        // Enviarlo
		if(mail($para, $título, $mensaje, $cabeceras)){
			$query = "UPDATE facturas_pagas SET facp_avisado = 1 WHERE facp_fac_id = {$inscripcion['fac_id']}";
			runQuery($query,$mysqli);
			
			//echo $mensaje;
			//die('mando con factura'.$inscripcion['fac_id']);
		}
}

header('Location:../pagoMisCuentas.php');
