<?php

require_once dirname(__FILE__) . '/../admin/general/db.php';
$path = "cobranza/";

//si no hay error en la subida
if ($_FILES['cobranza']['error'] == 0) {

    //verifico si es repetido
    if (file_exists($path . $_FILES['cobranza']['name'])) {
        die('ya existe');
    } else {
        move_uploaded_file($_FILES['cobranza']["tmp_name"], $path . $_FILES['cobranza']["name"]);
    }
}

$nombre_archivo = $_FILES['cobranza']['name'];

$file = fopen($path . $nombre_archivo, "r");
$header = fread($file, 100);

$content = "";
while (!feof($file)) {
    $content .= fread($file, 101);
}
fclose($file);
$detalles = substr($content, 1, strlen($content) - 103);
$detalles = explode(PHP_EOL, $detalles);
unset($detalles[0]);
$trailer = substr($content, strlen($content) - 101, 100);


//formamos el header
$h_cod_registro = substr($header, 0, 1);
$h_cod_banelco = substr($header, 1, 3);
$h_cod_empresa = substr($header, 4, 4);
$h_fec_archivo = substr($header, 8, 8);
$h_filler = substr($header, 16, 84);


//limpiamos las variables
$para = "";
$cabeceras = "";
$mensaje = "";
$título = "";

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
$título = "";
    if (empty($detalle)) {
        continue;
    }

    $d_cod_registro = substr($detalle, 0, 1);
    $d_nro_referencia = substr($detalle, 1, 19);
    $d_nro_factura = substr($detalle, 20, 20);
    $d_fec_vencimiento = substr($detalle, 40, 8);
    $d_cod_moneda = substr($detalle, 48, 1);
    $d_fec_aplicacion = substr($detalle, 49, 8);
    $d_importe = substr($detalle, 57, 11);
    $d_cod_mov = substr($detalle, 68, 1);
    $d_fec_acreditacion = substr($detalle, 69, 8);
    $d_canal_pago = substr($detalle, 77, 2);
    $d_nro_control = substr($detalle, 79, 4);
    $d_cod_provincia = substr($detalle, 83, 3);
    $d_filler = substr($detalle, 86, 14);

    //parametros para la tabla
    $parameters['facp_monto'] = (int) substr($d_importe, 0, 9) . '.' . substr($d_importe, 9, 2);
    $parameters['facp_fecha_aplicacion'] = fechaByInt($d_fec_aplicacion);
    $parameters['facp_fecha_acreditacion'] = fechaByInt($d_fec_acreditacion);
    $parameters['facp_fac_id'] = $d_nro_factura;
    $parameters['facp_archivo'] = $nombre_archivo;
    $parameters['facp_avisado'] = 0;
	
	//es de amd
	/*if($d_cod_evento==5555){
		$es_amd=true;
		
		//traigo con dni evento y cod evento el nro de factura
		$query = "SELECT * FROM facturas WHERE fac_id = $d_nro_factura";
		$datos_amd = getRowQuery($query,$amd_db);
		
		$parameters['facp_dni'] = $datos_amd['fac_usu_id'];
		$d_dni = $datos_amd['fac_usu_id'];
		$d_categoria = $datos_amd['fac_mensualidad'];
		insertRow('facturas_pagas', $parameters, $amd_db);
		$mec_a_pagar = getRowQuery("SELECT meu_id FROM mensualidad_usuario WHERE meu_u_dni = $d_dni AND meu_men_id = $d_categoria ORDER BY meu_id DESC LIMIT 1",$amd_db);		
		$ya_registro_pago = getRowQuery("SELECT mcu_id FROM mensualidad_cuota_usuario where mcu_meu_id = {$mec_a_pagar[0]}",$amd_db);
		if(!$ya_registro_pago){
			$fechadePago = $parameters['facp_fecha_acreditacion'];
			$insertaMensualidad = "INSERT INTO mensualidad_cuota_usuario (mcu_meu_id,mcu_importe,mcu_fecha) 
								VALUES ('".$mec_a_pagar[0]."','".$parameters['facp_monto']."','".$fechadePago."')";
			runQuery($insertaMensualidad,$amd_db);
		}
	}else{	*/
	
		//autocommit off
		$mysqli->autocommit(false);
		try {

			$fac = getRowQuery("select * from facturas where fac_id = $d_nro_factura",$mysqli);
			insertRow('facturas_pagas', $parameters, $mysqli);
			if (!empty($mysqli->error)) {
				throw new Exception('Fallo en la inserción de inscripciones.' . $query . '<br>' . $mysqli->error);
			}
			
			if($fac['fac_mensualidad'] <> 0){
				$query = "SELECT * FROM facturas
							INNER JOIN mensualidad_cuotas ON mec_id = fac_mensualidad
							INNER JOIN mensualidades ON men_id = mec_men_id
							INNER JOIN inscribite_usuarios ON id = fac_usu_id
							WHERE fac_id = $d_nro_factura";
				$datos_mensualidad = getRowQuery($query,$mysqli);
				
				$para = ' '.$datos_mensualidad['nombre'].' '.$datos_mensualidad['apellido'].' <'.$datos_mensualidad['email'].'>'; // con coma si son más
				// título
				$título = 'Confirmacion de Pago Inscribite Online';
				// Para enviar un correo HTML, debe establecerse la cabecera Content-type
				$cabeceras = 'MIME-Version: 1.0' . "\r\n";
				$cabeceras .= 'Content-type: text/html; charset=UTF-8' . "\r\n";

				// Cabeceras adicionales
				$cabeceras .= 'From: Recordatorio <info@inscribiteonline.com.ar>' . "\r\n";
				$cabeceras .= 'Cc: Recordatorio <info@inscribiteonline.com.ar>' . "\r\n";
				//$cabeceras .= 'Cco: Recordatorio <dedieu92g@gmail.com>' . "\r\n";
				
				include 'mail_mensualidad.php';
				header('Content-Type: text/html; charset=UTF-8'); 
				
				// Enviarlo
				if(mail($para, $título, $mensaje, $cabeceras)){
					$query = "UPDATE facturas_pagas SET facp_avisado = 1 WHERE facp_fac_id = $d_nro_factura";
					runQuery($query,$mysqli);
				}
				$parameters['meu_u_dni'] = $datos_mensualidad['dni'];
				$parameters['meu_mec_id'] = $datos_mensualidad['fac_mensualidad'];
				$parameters['meu_importe'] = $parameters['facp_monto'];
				$parameters['meu_fecha'] = date('Y-m-d h:i:s');
				insertRow('mensualidad_cuota_usuario',$parameters,$mysqli);
				
			}else{

				$query = "SELECT *,u.email as email_usuario,u.nombre usu_nombre,u.apellido usu_apellido,e.nombre evento_nombre,
							e.fecha evento_fecha,o.nombre op_nombre,c.nombre cat_nombre
							FROM facturas 
							INNER JOIN inscribite_eventos e ON e.codigo = fac_evento_id
							INNER JOIN inscribite_opciones o ON o.id = fac_op_id AND o.evento = fac_evento_id
							INNER JOIN inscribite_categorias c ON c.deevento = fac_evento_id AND c.codigo = fac_cat_id
							INNER JOIN inscribite_usuarios u ON u.id = fac_usu_id
							WHERE fac_id = $d_nro_factura";
				$inscripcion = getRowQuery($query, $mysqli);
				
				if (!empty($mysqli->error)) {
					throw new Exception('Fallo trayendo datos' . $query . '<br>' . $mysqli->error);
				}
				
				
				$para = ' '.$inscripcion['usu_nombre'].' '.$inscripcion['usu_apellido'].' <'.$inscripcion['email_usuario'].'>'; // con coma si son más
				// título
				$título = 'Confirmacion de Pago Inscribite Online';
				// Para enviar un correo HTML, debe establecerse la cabecera Content-type
				$cabeceras = 'MIME-Version: 1.0' . "\r\n";
				$cabeceras .= 'Content-type: text/html; charset=UTF-8' . "\r\n";

				// Cabeceras adicionales
				//$cabeceras .= 'To: Usuario <'.$inscripcion['email_usuario'].'>' . "\r\n";
				$cabeceras .= 'From: Recordatorio <info@inscribiteonline.com.ar>' . "\r\n";
				$cabeceras .= 'Cc: Recordatorio <info@inscribiteonline.com.ar>' . "\r\n";
				$cabeceras .= 'Cco: Recordatorio <dedieu92g@gmail.com>' . "\r\n";
				

				
				
				if ($inscripcion['tipo'] == 'Deportivos') {
					include 'mail_deportivos.php';
				}

				if ($inscripcion['tipo'] == 'Servicios') {
					include 'mail_servicios.php';
				}

				if ($inscripcion['tipo'] == 'Productos') {
					include 'mail_productos.php';
				}

				if ($inscripcion['tipo'] == 'CapacitaciÃ³n') {
					include 'mail_capacitacion.php';
				}

				header('Content-Type: text/html; charset=UTF-8'); 
				
				// Enviarlo
				if(mail($para, $título, $mensaje, $cabeceras)){
					$query = "UPDATE facturas_pagas SET facp_avisado = 1 WHERE facp_fac_id = {$inscripcion['fac_id']}";
					runQuery($query,$mysqli);
				}		
				

				$query = "SELECT * FROM inscribite_inscripciones 
							WHERE deusuario = (SELECT dni FROM inscribite_usuarios WHERE id = {$inscripcion['fac_usu_id']})
							AND deevento = (SELECT deevento FROM inscribite_categorias where codigo = {$inscripcion['fac_cat_id']} and deevento = {$inscripcion['fac_evento_id']} and opcion = (select nombre from inscribite_opciones where id = {$inscripcion['fac_op_id']}))";		
							
				$tieneDatos = getRowQuery($query,$mysqli);
				
				if($tieneDatos){
				$query = "UPDATE inscribite_inscripciones SET pagoeldia = Now(), pagado = 1
						WHERE  deusuario = (SELECT dni FROM inscribite_usuarios WHERE id = {$inscripcion['fac_usu_id']} ) 
						AND deevento = (SELECT deevento FROM inscribite_categorias where codigo = {$inscripcion['fac_cat_id']} and deevento = {$inscripcion['fac_evento_id']} and opcion = (select nombre from inscribite_opciones where id = {$inscripcion['fac_op_id']}))";
				}else{
				$query = "INSERT INTO inscribite_inscripciones(deusuario,deevento,categoria,opcion,pagado,empresa,iniciadoeldia,pmc,pagoeldia)
							SELECT u.dni,e.codigo,c.nombre,o.nombre,'1' pagado,e.empresa,fac_fecha_in,'1' pmc,facp_fecha_aplicacion FROM facturas 
							INNER JOIN inscribite_eventos e ON e.codigo = fac_evento_id
							INNER JOIN inscribite_opciones o ON o.id = fac_op_id
							INNER JOIN inscribite_categorias c ON c.deevento = fac_evento_id AND c.codigo = fac_cat_id
							INNER JOIN inscribite_usuarios u ON u.id = fac_usu_id
							INNER JOIN facturas_pagas ON facp_fac_id = fac_id
							WHERE fac_id = {$inscripcion['fac_id']}";
				}
				runQuery($query, $mysqli);

				if (!empty($mysqli->error)) {
					throw new Exception('Fallo en la actualizacion de inscripciones.' . $query . '<br>' . $mysqli->error);
				}
			
			}

			//si no hubieron errores ejecutamos todas las queries
			$mysqli->commit();
		} catch (Exception $e) {
			$mysqli->rollback();
		}
	/*}*/
	
}


	//formamos el trailer
	$t_cod_registro = substr($trailer, 0, 1);
	$t_cod_banelco = substr($trailer, 1, 3);
	$t_cod_empresa = substr($trailer, 4, 4);
	$t_fec_archivo = substr($trailer, 8, 8);
	$t_cant_registros = substr($trailer, 16, 7);
	$t_cant_registrosD = substr($trailer, 23, 7);
	$t_total_importe = substr($trailer, 30, 11);
	$t_total_importeD = substr($trailer, 41, 11);
	$t_filler = substr($trailer, 52, 48);


	//borramos inscripciones vencidas

	$query = "SELECT id,opcion,deevento FROM facturas
				INNER JOIN inscribite_inscripciones ON deevento = fac_evento_id AND deusuario = (SELECT dni FROM inscribite_usuarios WHERE id = fac_usu_id)
				WHERE fac_id not in (SELECT facp_fac_id FROM facturas_pagas)
				AND fac_fecha_in < CURDATE() - INTERVAL 7 DAY 
				AND iniciadoeldia < CURDATE() - INTERVAL 7 DAY  
				AND pagado = 0
				AND pmc = 1
			";
	$inscripciones_caidas = getArrayQuery($query,$mysqli);
	foreach($inscripciones_caidas as $key =>$inscripcion){
		if($key == 0)
			$out = $inscripcion['id'];
		else
			$out .= ','.$inscripcion['id'];
			
		runQuery("UPDATE inscribite_opciones SET cuporestante = cuporestante+1 WHERE nombre = {$inscripcion['opcion']} AND evento = {$inscripcion['deevento']}",$mysqli);
	}
	$query = "DELETE FROM inscribite_inscripciones WHERE id in($out)";
	runQuery($query,$mysqli);


header('Location:../pagoMisCuentas.php');
