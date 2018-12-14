<?php

$pagar = "blue";
require_once dirname(__FILE__) . '/../general/db.php';

//info del usuario
$query = "  SELECT *,TIMESTAMPDIFF(YEAR,CONCAT(SUBSTRING((CONVERT(fechanac,CHAR(4))),1,4),'-',
                    SUBSTRING((CONVERT(fechanac,CHAR(6))),5,5),'-',
                    SUBSTRING((CONVERT(fechanac,CHAR(8))),7,7)),CURDATE()) as edad 
            FROM inscribite_usuarios WHERE dni=$usuario";
$user_info = getRowQuery($query, $mysqli);

if ($_POST) {
    $mec_id = filter_input(INPUT_POST, "mec_id");
    if (!cuotaPagada($mysqli, $mec_id)) {
        if ($_POST['medio'] == "pmc") {

            //autocommit off
            $mysqli->autocommit(false);
            try {
                if (insertaPMC($mysqli,$mec_id,"pmc")) {
					$query = "select *,concat(nombre,' ',apellido) as usuario from facturas 
								inner join mensualidad_cuotas on mec_id = fac_mensualidad
								inner join mensualidades on men_id = mec_men_id
								inner join inscribite_usuarios on id = fac_usu_id
								where mec_id = $mec_id and fac_usu_id = (select id from inscribite_usuarios where dni = {$_SESSION['usuario']})";
					$mensualidad = getRowQuery($query,$mysqli);
					/* solo cuando cobramos la cuota modificamos este valor
					$parameters['meu_u_dni'] = $_SESSION['usuario'];
					$parameters['meu_mec_id'] = $mec_id;
					$parameters['meu_importe'] = $importe;
					$parameters['meu_fecha'] = date('Y-m-d h:i:s');
					insertRow('mensualidad_cuota_usuario',$parameters,$mysqli);
					*/
                } else {
                    throw new Exception('Fallo en insercion de pmc.');
                }

                $email = $_SESSION['user_mail'];
                $asunto = "Inscribite Online - Inscripcion a Mensualidad";
                $info_adicional = "From: Inscribite Online <info@inscribiteonline.com.ar>\r\nContent-Type: text/html;charset=utf-8\r\n";
                $mensaje = "";
                
                require_once 'mail_mensualidad.php';
                
                mail($email, $asunto, $mensaje, $info_adicional);

                //si no hubieron errores ejecutamos todas las queries
                $mysqli->commit();

                echo 1;
            } catch (Exception $e) {
                $mysqli->rollback();
                echo 0;
            }
        } elseif($_POST['medio'] == "rp"){
			if (insertaPMC($mysqli,$mec_id)) {
				header('Location:http://www.inscribiteonline.com.ar/newsite2014/cuponRP.php?tipo=rp&mec_id='.$mec_id);
			}
			
		}else {
            if (insertaPMC($mysqli,$mec_id)) {
				header('Location:http://www.inscribiteonline.com.ar/newsite2014/cuponRP.php?tipo=pf&mec_id='.$mec_id);
			}
        }
    } else {
        echo 0;
    }
} else {
    echo 0;
}
?>