<?php
error_reporting(0);
include dirname(__FILE__) . '/../general/db.php';
if ($_POST) {
	$cont_fac_amd = 0;
    foreach ($_POST['facturas'] as $key => $factura) {
		if(strpos($factura,'_amd') === FALSE){
			if ($key == 0) {
				$facturas_id = $factura;
			} else {
				$facturas_id .= ',' . $factura;
			}
		}else{
			if ($cont_fac_amd == 0) {
				$facturas_amd_id = str_replace("_amd","",$factura);
			} else {
				$facturas_amd_id .= ',' . str_replace("_amd","",$factura);
			}
			$cont_fac_amd++;
		}
    }

	//AMD STAFF
	$es_amd = false;
	$amd_dbuser = "aptomedico_user";
	$amd_dbpassword = "Urudata25267!";
	$amd_dbhost = "localhost";
	$amd_dbname = "aptomedico_base";
	$amd_db = new mysqli($amd_dbhost, $amd_dbuser, $amd_dbpassword, $amd_dbname);
	$query = "SELECT *,meu_venc_1 as fac_venc1,meu_venc_2 as fac_venc2,meu_venc_3 as fac_venc3,fac_usu_id as dni,'Apto Medico Digital' as nombre FROM facturas INNER JOIN mensualidad_usuario ON fac_usu_id = meu_u_dni
				AND fac_mensualidad = meu_men_id WHERE fac_id in ($facturas_amd_id)";
    $facturas_amd = getArrayQuery($query, $amd_db);
	$query = "UPDATE facturas SET fac_pedido = 1,fac_fecha_pedido = Now() WHERE fac_id in ($facturas_amd_id) AND fac_pedido =0";
    runQuery($query, $amd_db);
		
    $query = "SELECT *,CASE WHEN fac_evento_id = 0 THEN 'Inscribite Online' ELSE  (select nombre from inscribite_eventos where codigo = fac_evento_id) END as nombre FROM facturas INNER JOIN inscribite_usuarios u ON u.id = fac_usu_id WHERE fac_id in ($facturas_id)";
    $facturas = getArrayQuery($query, $mysqli);
	
	foreach($facturas_amd as $factura_amd){
		$facturas[] = $factura_amd;
	}
	
    $query = "UPDATE facturas SET fac_pedido = 1,fac_fecha_pedido = Now() WHERE fac_id in ($facturas_id)";
    runQuery($query, $mysqli);
    //info general
    $cod_empresa = 3545;
    $nombre_archivo = "FAC" . $cod_empresa . "." . date("dmy");
//campos correspondientes al header
    $h_cod_registro = 0;
    $h_cod_banelco = 400;
    $h_cod_empresa = $cod_empresa;
    $h_fec_archivo = date("Ymd");
    $h_filler = str_pad($h_filler, 264, "0", STR_PAD_LEFT);
//formamos el header en orden
    $header = $h_cod_registro . $h_cod_banelco . $h_cod_empresa . $h_fec_archivo . $h_filler;
    
    $msj_corto = "INSONLINE";
    $detalles = "";
    $total = 0;
	$msj = "";
    foreach ($facturas as $factura) {
        if(strlen($factura['nombre'])>=35){
			$msj = substr($factura['nombre'],0,34);
		}
		else{
			$msj = $factura['nombre'];
		}
		
		$msj = limpiarCaracteresEspeciales($msj);
		
        $importe1 = explode('.', $factura[fac_imp1]);
        $entero1 = $importe1[0];
        $decimal1 = $importe1[1];
        $importe2 = explode('.', $factura[fac_imp2]);
        $entero2 = $importe2[0];
        $decimal2 = $importe2[1];
        $importe3 = explode('.', $factura[fac_imp3]);
        $entero3 = $importe3[0];
        $decimal3 = $importe3[1];
        //limpio vars
        $d_nro_referencia = "";
        $d_nro_factura = "";
        $d_cod_moneda = 0;
        $d_fec_venc1 = 20160519;
        $d_imp_venc1 = "";
        $d_fec_venc2 = 20160519;
        $d_imp_venc2 = "";
        $d_fec_venc3 = 20160519;
        $d_imp_venc3 = "";
        $d_filler1 = "";
        $d_nro_referenciaA = $d_nro_referencia; //codigo de empresa 19 bytes
        $d_msj_ticket = "";
        $d_msj_pantalla = "";
        $d_cod_barra = "";
        $d_filler2 = "";
        //campos correspondientes al detalle
        $d_cod_registro = 5;
        $d_nro_referencia = $factura[dni] . str_pad($d_nro_referencia, (19 - strlen($factura[dni])), " ", STR_PAD_RIGHT); //codigo de empresa 19 bytes
        $d_nro_factura = $factura[fac_id] . str_pad($d_nro_factura, (20 - strlen($factura[fac_id])), " ", STR_PAD_RIGHT); //id de la factura 20 bytes
        $d_cod_moneda = 0;
        $d_fec_venc1 = date('Ymd', strtotime($factura[fac_venc1]));
        $d_imp_venc1 = str_pad($entero1, 9, "0", STR_PAD_LEFT) . str_pad($decimal1, 2, "0", STR_PAD_LEFT); // 9 enteros 2 decimales
        $d_fec_venc2 = date('Ymd', strtotime($factura[fac_venc2]));
        $d_imp_venc2 = str_pad($entero2, 9, "0", STR_PAD_LEFT) . str_pad($decimal2, 2, "0", STR_PAD_LEFT); // 9 enteros 2 decimales
        $d_fec_venc3 = date('Ymd', strtotime($factura[fac_venc3]));
        $d_imp_venc3 = str_pad($entero3, 9, "0", STR_PAD_LEFT) . str_pad($decimal3, 2, "0", STR_PAD_LEFT); // 9 enteros 2 decimales
        $d_filler1 = str_pad($d_filler1, 19, "0", STR_PAD_LEFT);
        $d_nro_referenciaA = $d_nro_referencia; //codigo de empresa 19 bytes
        $d_msj_ticket = $msj . str_pad($d_msj_ticket, (40 - strlen(utf8_decode($msj))), " ", STR_PAD_RIGHT); //mensaje del ticket 40 bytes ex:"Cuota nov"
        $d_msj_pantalla = $msj_corto . str_pad($d_msj_pantalla, (15 - strlen($msj_corto)), " ", STR_PAD_RIGHT); //mensaje del ticket 40 bytes ex:"Cuota nov" mas corto
        //referencia y factura sin espacios | COD BARRA CHANCHULLO
        $d_nro_referenciaSE = $factura[dni];
        $d_nro_facturaSE = str_pad($factura[fac_id], 9, "0", STR_PAD_LEFT); //id de la factura 20 bytes
        $d_cod_barra_aux = generarCodigoBarra($cod_empresa, $d_nro_referenciaSE, $d_nro_facturaSE, $d_imp_venc1, $d_fec_venc1, $d_imp_venc2, $d_fec_venc2);
        $d_cod_barra = $d_cod_barra_aux . str_pad($d_cod_barra, (60 - strlen($d_cod_barra_aux)), " ", STR_PAD_RIGHT);
        //////////////////////////////////////////////////
        $d_filler2 = str_pad($d_filler2, 29, "0", STR_PAD_RIGHT);
        //formamos el detalle
        $detalle = $d_cod_registro . $d_nro_referencia . $d_nro_factura . $d_cod_moneda . $d_fec_venc1 . $d_imp_venc1;
        $detalle .= $d_fec_venc2 . $d_imp_venc2 . $d_fec_venc3 . $d_imp_venc3 . $d_filler1 . $d_nro_referenciaA;
        $detalle .= $d_msj_ticket . $d_msj_pantalla . $d_cod_barra . $d_filler2;
        $detalles .= $detalle . PHP_EOL;
        $total = $total + $factura[fac_imp1];
		
    } 
	
	
	//importe total
    $importeT = explode('.', $total);
    $enteroT = $importeT[0];
    $decimalT = $importeT[1];
    //campos correspondientes al trailer
    $t_cod_registro = 9;
    $t_cod_banelco = 400;
    $t_cod_empresa = $cod_empresa;
    $t_fec_archivo = date("Ymd");
    $t_cant_registros = str_pad(count($facturas), 7, "0", STR_PAD_LEFT); //cant de registros en detalle
    $t_filler1 = str_pad($t_filler1, 7, "0", STR_PAD_LEFT);
    $t_total_importe = str_pad($enteroT, 9, "0", STR_PAD_LEFT) . str_pad($decimalT, 2, "0", STR_PAD_RIGHT); // 9 enteros 2 decimales
    $t_filler2 = str_pad($t_filler2, 239, "0", STR_PAD_LEFT);
//formamos el trailer
    $trailer = $t_cod_registro . $t_cod_banelco . $t_cod_empresa . $t_fec_archivo;
    $trailer .= $t_cant_registros . $t_filler1 . $t_total_importe . $t_filler2;
	
	$file = fopen($nombre_archivo, "w");
    fwrite($file, $header . PHP_EOL);
    fwrite($file, $detalles);
    fwrite($file, $trailer . PHP_EOL);
    fclose($file);


    //Descarga
	header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename='.basename($nombre_archivo));
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($nombre_archivo));
    ob_clean();
    flush();
    readfile($nombre_archivo);
    exit;
}

