<?php
$pagar = "blue";
require_once dirname(__FILE__) . '/../general/db.php';

//info del usuario
$query = "  SELECT *,TIMESTAMPDIFF(YEAR,CONCAT(SUBSTRING((CONVERT(fechanac,CHAR(4))),1,4),'-',
                    SUBSTRING((CONVERT(fechanac,CHAR(6))),5,5),'-',
                    SUBSTRING((CONVERT(fechanac,CHAR(8))),7,7)),CURDATE()) as edad 
            FROM inscribite_usuarios WHERE dni=$usuario";
$user_info = getRowQuery($query, $mysqli);

$cod_evento = filter_input(INPUT_POST, "evento");
$cat = filter_input(INPUT_POST, "categoria");

if ($_POST && !estaInscripto($mysqli, $cod_evento, $cat)) {


	//autocommit off
	$mysqli->autocommit(false);
	try {
    
		$cod_evento = filter_input(INPUT_POST, "evento");
		$cat = filter_input(INPUT_POST, "categoria");
		$op_nombre = filter_input(INPUT_POST, "opcion");
		$op_id = filter_input(INPUT_POST, "opcion_id");
		$cod_cat = filter_input(INPUT_POST, 'cod');
		$respuestapart1 = filter_input(INPUT_POST, "respuestapart1");
		$respuestapart2 = filter_input(INPUT_POST, "respuestapart2");
		$respuestapart3 = filter_input(INPUT_POST, "respuestapart3");
			
		$evento = getRowQuery("SELECT * FROM inscribite_eventos WHERE codigo= '$cod_evento' ", $mysqli);
		$opcion = getRowQuery("SELECT * FROM inscribite_opciones WHERE id= '$op_id' ", $mysqli);
		$categoria = getRowQuery("SELECT * FROM inscribite_categorias WHERE deevento = '$cod_evento' AND codigo = '$cod_cat' LIMIT 1", $mysqli);
		
		
		
		$parameters['deusuario'] = $_SESSION['usuario'];
		$parameters['empresa'] = $evento['empresa'];
		$parameters['deevento'] = $cod_evento;
		$parameters['categoria'] = $categoria['nombre'];
		$parameters['opcion'] = $opcion['nombre'];
		$parameters['codigo'] = 0;
		$parameters['iniciadoeldia'] = date("Y-m-d");
		$parameters['venceeldia'] = date('Ymd',strtotime(date("d-m-Y") . "+11 days"));
		$parameters['pagado'] = 1;
		$parameters['pagoeldia'] = date("Y-m-d");
		$parameters['selemandomail'] = 1;
		$parameters['precio'] = 00;
		$parameters['respuestapart1'] = $respuestapart1;
		$parameters['respuestapart2'] = $respuestapart2;
		$parameters['respuestapart3'] = $respuestapart3;
		$parameters['mes'] = filter_input(INPUT_POST, 'mes');
		$parameters['cargopuntos'] = 0;
		$parameters['pmc'] = 1;
		
		
		insertRow('inscribite_inscripciones', $parameters, $mysqli);
		if (!empty($mysqli->error)) {
			throw new Exception('Fallo en insercion de inscripción');
		}
		sumoInscripcion($op_id,$mysqli);
		if (!empty($mysqli->error)) {
			throw new Exception('Fallo en suma de cupo');
		}
	
			$email = $_SESSION['user_mail'];
			$asunto = "Inscribite Online - Inscripción a Evento";
			$info_adicional = "From: Inscribite Online <info@inscribiteonline.com.ar>\r\nContent-Type: text/html;charset=utf-8\r\n";
			$mensaje = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
			<html>
			<head>
			<title>Inscribite Online</title>
			<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
			</head>
			<body>
			<div align="center">
			  <p><a href="' . $general_path . '"><img src="' . $general_path . '../webimages/bannermail.png" width="280" height="100" border="0"></a></p>
			  <table width="600" border="0" cellspacing="5" cellpadding="0">
				<tr>
				  <td><p><font color="#666666" size="2" face="Arial, Helvetica, sans-serif">Estimado
					  Usted se ha inscripto a ' . $evento['nombre'] . ', con opci�n: ' . $categoria['nombre'] . ' y categoria ' . $opcion['nombre'] . '</font></p>
					<p><font face="Arial, Helvetica, sans-serif" size="2" color="#666666">
							Operaci�n realizada con �xito
					   </font></p>
					<blockquote>
					  <p><font face="Arial, Helvetica, sans-serif" size="2" color="#666666">Monto a pagar
						<strong>' . $precio1 . ' </strong><br/>
					</font></p>
					</blockquote>
					<p><font color="#666666" size="2" face="Arial, Helvetica, sans-serif">Saludos
					  cordiales,<br/>
					  Inscribite Online.</font><font color="#666666" size="2" face="Arial, Helvetica, sans-serif"><br/>
					  </font></p>
					</td>
				</tr>
			  </table><br/>
			  <table width="600" height="25" border="0" cellpadding="0" cellspacing="5" background="' . $general_path . '../webimages/footer.gif">
				<tr>
				  <td><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">MARITIMO SRL / 4641-4423 4643-1124 / info@inscribiteonline.com.ar </font></td>
				</tr>
			  </table>
			  <p>&nbsp;</p>
			</div>
			</body>
			</html>';
			mail($email, $asunto, $mensaje, $info_adicional);

			//si no hubieron errores ejecutamos todas las queries
			$mysqli->commit();

		echo 1;
	} catch (Exception $e) {
		$mysqli->rollback();
		echo 0;
	}

} else {
    echo 0;
}
?>

<?php include_once 'general/footer.php'; ?>