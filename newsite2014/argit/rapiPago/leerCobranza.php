<?php

require_once dirname(__FILE__) . '/../admin/general/db.php';
$path = "cobranza/";


//si no hay error en la subida
if ($_FILES['cobranza']['error'] == 0) {

    //verifico si es repetido
    if (file_exists($path . $_FILES['cobranza']['name'])) {
		//die('ya existe');
		unlink($path . $_FILES['cobranza']["name"]);
		move_uploaded_file($_FILES['cobranza']["tmp_name"], $path . $_FILES['cobranza']["name"]);
    } else {
	    move_uploaded_file($_FILES['cobranza']["tmp_name"], $path . $_FILES['cobranza']["name"]);
    }
}
$nombre_archivo = $_FILES['cobranza']['name'];

$file = fopen($path . $nombre_archivo, "r");
$header = fread($file, 73);

$content = "";
while (!feof($file)) {
    $content .= fread($file, 74);
}
fclose($file);
$detalles = substr($content, 1, strlen($content) - 76);
$detalles = explode(PHP_EOL, $detalles);
unset($detalles[0]);
$trailer = substr($content, strlen($content) - 74, 73);

//formamos el header
$h_id = substr($header, 0, 8);
$h_nombre_empresa = substr($header, 8, 20);
$h_fecha_proceso = substr($header, 28, 8);
$h_id_archivo = substr($header, 36, 20);
$h_filler = substr($header, 56, 17);

//limpiamos las variables
$para = "";
$cabeceras = "";
$mensaje = "";
$titulo = "";

//AMD STAFF
/*$es_amd = false;
$amd_dbuser = "aptomedico_user";
$amd_dbpassword = "Urudata25267!";
$amd_dbhost = "localhost";
$amd_dbname = "aptomedico_base";
$amd_db = new mysqli($amd_dbhost, $amd_dbuser, $amd_dbpassword, $amd_dbname);*/

//formamos detalles
foreach ($detalles as $detalle) {

//limpiamos las variables
$para = "";
$cabeceras = "";
$mensaje = "";
$titulo = "";
    if (empty($detalle)) {
        continue;
    }

    $d_fec_acreditacion = substr($detalle, 0, 8);
    $d_importe = substr($detalle, 8, 15);
    $d_cod_empresa = substr($detalle, 23, 4);
    $d_importe_evento = substr($detalle, 27, 6);
    $d_recargo = substr($detalle, 33, 2);
    $d_fec_vencimiento = substr($detalle, 35, 5);
    $d_cod_evento = substr($detalle, 40, 4);
    $d_cod_categoria = substr($detalle, 44, 2);
    $d_dni = substr($detalle, 46, 8);
	
	//echo $d_importe.'<br>'.$d_cod_evento.'<br>'.$d_cod_categoria.'<br>'.$d_dni;die;
	
    
    //parametros para la tabla
    $parameters['facp_monto'] = (int) substr($d_importe, 0, 13) . '.' . substr($d_importe, 13, 2);
    //pongo misma fecha porq no se maneja igual q pmc solo usamos el decodificador, no enviamos facturas
	$parameters['facp_fecha_aplicacion'] = fechaByInt($d_fec_acreditacion);
    $parameters['facp_fecha_acreditacion'] = fechaByInt($d_fec_acreditacion);
	
	//es de amd
	/*if($d_cod_evento==5555){
		$es_amd=true;
		
		//traigo con dni evento y cod evento el nro de factura
		$d_nro_factura = getRowQuery("SELECT fac_id FROM facturas WHERE fac_usu_id = $d_dni AND fac_mensualidad = $d_cod_categoria ORDER BY fac_id DESC LIMIT 1",$amd_db);
		$d_nro_factura = $d_nro_factura['fac_id'];
		
		$parameters['facp_fac_id'] = $d_nro_factura;
		$parameters['facp_archivo'] = $nombre_archivo;
		$parameters['facp_avisado'] = 0;
		$parameters['facp_dni'] = $d_dni;
		
		insertRow('facturas_pagas', $parameters, $amd_db);
		$mec_a_pagar = getRowQuery("SELECT meu_id FROM mensualidad_usuario WHERE meu_u_dni = $d_dni AND meu_men_id = $d_cod_categoria ORDER BY meu_id DESC LIMIT 1",$amd_db);		
		$ya_registro_pago = getRowQuery("SELECT mcu_id FROM mensualidad_cuota_usuario where mcu_meu_id = {$mec_a_pagar[0]}",$amd_db);
		if(!$ya_registro_pago){
			$fechadePago = $parameters['facp_fecha_acreditacion'];
			$insertaMensualidad = "INSERT INTO mensualidad_cuota_usuario (mcu_meu_id,mcu_importe,mcu_fecha) 
								VALUES ('".$mec_a_pagar[0]."','".$d_importe_evento."','".$fechadePago."')";
			runQuery($insertaMensualidad,$amd_db);
		}
	}else{	*/
		$es_mensualidad = getRowQuery("SELECT fac_id FROM facturas WHERE fac_mensualidad = $d_cod_evento and 
							fac_usu_id = (select id from inscribite_usuarios where dni = $d_dni) and fac_tipo > 1 limit 1",$mysqli);
							
		if ($es_mensualidad){
			
			$ya_registro_pago = getRowQuery("SELECT meu_id FROM mensualidad_cuota_usuario where meu_u_dni  = $d_dni and meu_mec_id = $d_cod_evento",$mysqli);
			if(!$ya_registro_pago){
				$fechadePago = $parameters['facp_fecha_acreditacion'];
				$insertaMensualidad = "INSERT INTO mensualidad_cuota_usuario (meu_u_dni,meu_mec_id,meu_importe,meu_fecha) 
									VALUES ('".$d_dni."','".$d_cod_evento."','".$d_importe_evento."','".$fechadePago."')";
				runQuery($insertaMensualidad,$mysqli);
				
					//traigo con dni evento y cod evento el nro de factura
				$d_nro_factura = getRowQuery("SELECT fac_id,nombre as usu_nombre,apellido as usu_apellido,email as email_usuario
												FROM facturas
												INNER JOIN inscribite_usuarios ON id = fac_usu_id
												WHERE dni = $d_dni AND fac_mensualidad = $d_cod_evento",$mysqli);

				$d_nro_factura = $d_nro_factura['fac_id'];
			}
			
			
		}else{
		
			//traigo con dni evento y cod evento el nro de factura
			$d_nro_factura = getRowQuery("SELECT id FROM inscribite_inscripciones WHERE deevento = $d_cod_evento and deusuario = $d_dni
											and categoria =
											(SELECT nombre FROM inscribite_categorias WHERE codigo = $d_cod_categoria 
											and deevento = $d_cod_evento)",$mysqli);
			$d_nro_factura= $d_nro_factura['id'];
		}
	

	
										
		$parameters['facp_fac_id'] = $d_nro_factura;
		$parameters['facp_archivo'] = $nombre_archivo;
		$parameters['facp_avisado'] = 0;
		$parameters['facp_dni'] = $d_dni;
		$parameters['facp_evento'] = $d_cod_evento;
		$parameters['facp_categoria'] = $d_cod_categoria;
		$parameters['facp_empresa'] = $d_cod_empresa;
		
		//autocommit off
		$mysqli->autocommit(false);
		try {
			insertRow('facturas_rp_pagas', $parameters, $mysqli);
			if (!empty($mysqli->error)) {
				throw new Exception('Fallo en la inserci�n de inscripciones.' . $query . '<br>' . $mysqli->error);
			}
			
			$facp_id = $mysqli->insert_id;
				
			$query = "SELECT * FROM inscribite_inscripciones WHERE id = $d_nro_factura";
						
			$tieneDatos = getRowQuery($query,$mysqli);
			
			if($tieneDatos){
			$query = "UPDATE inscribite_inscripciones SET pagoeldia = Now(), pagado = 1 WHERE id = $d_nro_factura";
			runQuery($query, $mysqli);        
			}
			else{
			$query = "INSERT INTO inscribite_inscripciones(deusuario,deevento,categoria,opcion,pagado,empresa,iniciadoeldia,pmc,pagoeldia,precio)
						SELECT facp_dni,e.codigo,c.nombre,'','1' pagado,e.empresa,facp_fecha_aplicacion ,'2' rp,facp_fecha_aplicacion,facp_monto 
						FROM facturas_rp_pagas  
						INNER JOIN inscribite_eventos e ON e.codigo = facp_evento
						INNER JOIN inscribite_categorias c ON c.deevento = facp_evento AND c.codigo = facp_categoria
						WHERE facp_id = $facp_id";
						runQuery($query, $mysqli);
						$d_nro_factura = $mysqli->insert_id;
						
						$query = "UPDATE facturas_rp_pagas SET facp_fac_id = $d_nro_factura WHERE facp_id = $facp_id ";
						runQuery($query, $mysqli);
			}
			
			 if (!empty($mysqli->error)) {
				throw new Exception('Fallo cargar el usuario.' . $query . '<br>' . $mysqli->error);
			}

			
			if($es_mensualidad){
				$query = "SELECT * FROM facturas
							INNER JOIN mensualidad_cuotas ON mec_id = fac_mensualidad
							INNER JOIN mensualidades ON men_id = mec_men_id
							INNER JOIN inscribite_usuarios ON id = fac_usu_id
							WHERE fac_id = $d_nro_factura";
				$datos_mensualidad = getRowQuery($query,$mysqli);
				
				$para = ' '.$datos_mensualidad['nombre'].' '.$datos_mensualidad['apellido'].' <'.$datos_mensualidad['email'].'>'; // con coma si son m�s
				// t�tulo
				$titulo = 'Confirmacion de Pago Inscribite Online';
				// Para enviar un correo HTML, debe establecerse la cabecera Content-type
				$cabeceras = 'MIME-Version: 1.0' . "\r\n";
				$cabeceras .= 'Content-type: text/html; charset=UTF-8' . "\r\n";

				// Cabeceras adicionales
				$cabeceras .= 'From: Recordatorio <info@inscribiteonline.com.ar>' . "\r\n";
				$cabeceras .= 'Cc: Recordatorio <info@inscribiteonline.com.ar>' . "\r\n";
				$cabeceras .= 'Cco: Recordatorio <dedieu92g@gmail.com>' . "\r\n";
				
				include '../pagoMisCuentas/mail_mensualidad.php';
				header('Content-Type: text/html; charset=UTF-8'); 
				
				// Enviarlo
				if(mail($para, $titulo, $mensaje, $cabeceras)){
					$query = "UPDATE facturas_pagas SET facp_avisado = 1 WHERE facp_id = $facp_id";
					runQuery($query,$mysqli);
				}
				
			}	else{
			
				$query = "SELECT ins.opcion as op_nombre,u.email as email_usuario,u.nombre usu_nombre,u.apellido usu_apellido
							,e.nombre evento_nombre,e.fecha evento_fecha,c.nombre cat_nombre
							FROM inscribite_inscripciones ins
							INNER JOIN inscribite_eventos e ON e.codigo = ins.deevento
							INNER JOIN inscribite_categorias c ON c.deevento = ins.deevento AND c.codigo = facp_categoria
							INNER JOIN inscribite_usuarios u ON u.dni = ins.deusuario
							WHERE id = $d_nro_factura";
				$inscripcion = getRowQuery($query, $mysqli);
				
				if (!empty($mysqli->error)) {
					throw new Exception('Fallo trayendo datos' . $query . '<br>' . $mysqli->error);
				}
				
				

				$para = ' '.$inscripcion['usu_nombre'].' '.$inscripcion['usu_apellido'].' <'.$inscripcion['email_usuario'].'>'; // con coma si son m�s	
				
				// t�tulo
				$titulo = 'Confirmacion de Pago Inscribite Online';
				// Para enviar un correo HTML, debe establecerse la cabecera Content-type
				$cabeceras = 'MIME-Version: 1.0' . "\r\n";
				$cabeceras .= 'Content-type: text/html; charset=UTF-8' . "\r\n";

				// Cabeceras adicionales
				//$cabeceras .= 'To: Usuario <'.$inscripcion['email_usuario'].'>' . "\r\n";
				$cabeceras .= 'From: Recordatorio <info@inscribiteonline.com.ar>' . "\r\n";
				$cabeceras .= 'Cc: Recordatorio <info@inscribiteonline.com.ar>' . "\r\n";
				//$cabeceras .= 'Cco: Recordatorio <dedieu92g@gmail.com>' . "\r\n";
				

				
				
				if ($inscripcion['tipo'] == 'Deportivos') {
					include 'mail_deportivos.php';
				}

				if ($es_mensualidad || $inscripcion['tipo'] == 'Servicios') {
					include 'mail_servicios.php';
				}

				if ($inscripcion['tipo'] == 'Productos') {
					include 'mail_productos.php';
				}

				if ($inscripcion['tipo'] == 'Capacitación') {
					include 'mail_capacitacion.php';
				}

				header('Content-Type: text/html; charset=UTF-8'); 
				
				// Enviarlo
				if(mail($para, $titulo, $mensaje, $cabeceras)){
					$query = "UPDATE facturas_rp_pagas SET facp_avisado = 1 WHERE facp_fac_id = $d_nro_factura";
					runQuery($query,$mysqli);
				}		
					

				if (!empty($mysqli->error)) {
					throw new Exception('Fallo en la actualizacion de inscripciones.' . $query . '<br>' . $mysqli->error);
				}
			
			}
			

			//si no hubieron errores ejecutamos todas las queries
			$mysqli->commit();
		} catch (Exception $e) {
			$mysqli->rollback();
		}
	
}



	//formamos el trailer
	$t_id = substr($trailer, 0, 8);
	$t_cant_registros = substr($trailer, 8, 8);
	$t_importe_total = substr($trailer, 16, 18);
	$t_filler = substr($trailer, 34, 39);

//borramos inscripciones vencidas
	$query = "SELECT id,opcion,deevento FROM inscribite_inscripciones WHERE pagado = 0 AND venceeldia <> 0 AND venceeldia < CURDATE() order by venceeldia desc";

	/*$query = "SELECT id,opcion,deevento FROM facturas
				INNER JOIN inscribite_inscripciones ON deevento = fac_evento_id AND deusuario = (SELECT dni FROM inscribite_usuarios WHERE id = fac_usu_id)
				WHERE fac_id not in (SELECT facp_fac_id FROM facturas_pagas)
				AND fac_fecha_in < CURDATE() - INTERVAL 7 DAY 
				AND iniciadoeldia < CURDATE() - INTERVAL 7 DAY  
				AND pagado = 0
				AND pmc = 1
			";*/
	$inscripciones_caidas = getArrayQuery($query,$mysqli);
	foreach($inscripciones_caidas as $key =>$inscripcion){
		if($key == 0)
			$out = $inscripcion['id'];
		else
			$out .= ','.$inscripcion['id'];
			
		runQuery("UPDATE inscribite_opciones SET cuporestante = cuporestante+1 WHERE nombre = {$inscripcion['opcion']} AND evento = {$inscripcion['deevento']}",$mysqli);
	}
	$query = "UPDATE inscribite_inscripciones SET eliminada=1 WHERE id in($out)";
	runQuery($query,$mysqli);

header('Location:../rapiPago.php');
