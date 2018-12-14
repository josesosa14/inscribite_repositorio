<?php

$pagar = "blue";
require_once dirname(__FILE__) . '/../general/db.php';
if(!isset($_SESSION["usuario"]) || strlen($_SESSION["usuario"])<6){
	header("Location:http://www.inscribiteonline.com.ar/logout.php");
}


//info del usuario
$query = "  SELECT *,TIMESTAMPDIFF(YEAR,CONCAT(SUBSTRING((CONVERT(fechanac,CHAR(4))),1,4),'-',
                    SUBSTRING((CONVERT(fechanac,CHAR(6))),5,5),'-',
                    SUBSTRING((CONVERT(fechanac,CHAR(8))),7,7)),CURDATE()) as edad 
            FROM inscribite_usuarios WHERE dni=$usuario";
$user_info = getRowQuery($query, $mysqli);

if ($_GET) {
    $mec_id = filter_input(INPUT_GET, "mec_id");
    if (!cuotaPagada($mysqli, $mec_id)) {
		
        if ($_GET['medio'] == "pmc") {

        } elseif($_GET['medio'] == "rp"){
			if (insertaPMC($mysqli,$mec_id,$_GET['medio'])) {
				$query = "select *,concat(nombre,' ',apellido) as usuario from facturas 
					inner join mensualidad_cuotas on mec_id = fac_mensualidad
					inner join mensualidades on men_id = mec_men_id
					inner join inscribite_usuarios on id = fac_usu_id
					where mec_id = $mec_id and fac_usu_id = (select id from inscribite_usuarios where dni = {$_SESSION['usuario']})";
				
		$mensualidad = getRowQuery($query,$mysqli);
		$email = $_SESSION['user_mail'];
		$asunto = "Inscribite Online - Inscripcion a Mensualidad";
		$info_adicional = "From: Inscribite Online <info@inscribiteonline.com.ar>\r\nContent-Type: text/html;charset=utf-8\r\n";
		$mensaje = "";
				require_once 'mail_mensualidad.php';
                mail($email, $asunto, $mensaje, $info_adicional);
				header("Location:http://www.inscribiteonline.com.ar/newsite2014/cuponRP.php?tipo=rp&mec_id=$mec_id");
			}
			
		}else {
            if (insertaPMC($mysqli,$mec_id,$_GET['medio'])) {
				$query = "select *,concat(nombre,' ',apellido) as usuario from facturas 
					inner join mensualidad_cuotas on mec_id = fac_mensualidad
					inner join mensualidades on men_id = mec_men_id
					inner join inscribite_usuarios on id = fac_usu_id
					where mec_id = $mec_id and fac_usu_id = (select id from inscribite_usuarios where dni = {$_SESSION['usuario']})";
				
		$mensualidad = getRowQuery($query,$mysqli);
		$email = $_SESSION['user_mail'];
		$asunto = "Inscribite Online - Inscripcion a Mensualidad";
		$info_adicional = "From: Inscribite Online <info@inscribiteonline.com.ar>\r\nContent-Type: text/html;charset=utf-8\r\n";
		$mensaje = "";
				require_once 'mail_mensualidad.php';
                mail($email, $asunto, $mensaje, $info_adicional);
				header("Location:http://www.inscribiteonline.com.ar/newsite2014/cuponRP.php?tipo=rp&mec_id=$mec_id");
			}
        }
    } else {
        echo 0;
    }
} else {
    echo 0;
}
?>