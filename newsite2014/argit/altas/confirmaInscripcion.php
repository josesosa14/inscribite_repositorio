<?php

$pagar = "blue";
require_once dirname(__FILE__) . '/../general/db.php';

if(!isset($_SESSION["usuario"]) || strlen($_SESSION["usuario"])<6){
	header("Location:logout.php");
}


//info del usuario
$query = "  SELECT *,TIMESTAMPDIFF(YEAR,CONCAT(SUBSTRING((CONVERT(fechanac,CHAR(4))),1,4),'-',
                    SUBSTRING((CONVERT(fechanac,CHAR(6))),5,5),'-',
                    SUBSTRING((CONVERT(fechanac,CHAR(8))),7,7)),CURDATE()) as edad 
            FROM inscribite_usuarios WHERE dni=$usuario";
$user_info = getRowQuery($query, $mysqli);

if ($_POST) {
    $cod_evento = filter_input(INPUT_POST, "evento");
    $cat = filter_input(INPUT_POST, "categoria");
    if (!estaInscripto($mysqli, $cod_evento, $cat)) {
        if ($_POST['medio'] == "pmc") {

            //autocommit off
            $mysqli->autocommit(false);
            try {

                if (insertaPMC($mysqli)) {
                    $op_nombre = filter_input(INPUT_POST, "opcion");
                    $op_id = filter_input(INPUT_POST, "opcion_id");
                    $cod_cat = filter_input(INPUT_POST, 'cod');
                    $respuestapart1 = filter_input(INPUT_POST, "respuestapart1");
                    $respuestapart2 = filter_input(INPUT_POST, "respuestapart2");
                    $respuestapart3 = filter_input(INPUT_POST, "respuestapart3");
                    $pmc = getRowQuery("SELECT * FROM facturas WHERE fac_id= '{$mysqli->insert_id}' ", $mysqli);
                    $evento = getRowQuery("SELECT * FROM inscribite_eventos WHERE codigo= '$cod_evento' ", $mysqli);
                    $opcion = getRowQuery("SELECT * FROM inscribite_opciones WHERE id= '$op_id' ", $mysqli);
                    $categoria = getRowQuery("SELECT * FROM inscribite_categorias WHERE deevento = '$cod_evento' AND codigo = '$cod_cat' LIMIT 1", $mysqli);

                    $descuento = getRowQuery("SELECT * FROM inscribite_descuentos WHERE coddni = '{$_SESSION['usuario']}' AND codevento = '$cod_evento' ", $mysqli);
                    if ($descuento['porcentajedescuento']) {
                        $precio1 = $categoria['precio1'] - $categoria['precio1'] * ($descuento['porcentajedescuento'] / 100);
                        $precio2 = $categoria['precio2'] - $categoria['precio2'] * ($descuento['porcentajedescuento'] / 100);
                        $precio3 = $categoria['precio3'] - $categoria['precio3'] * ($descuento['porcentajedescuento'] / 100);
                    } else {
                        $precio1 = $categoria['precio1'];
                        $precio2 = $categoria['precio2'];
                        $precio3 = $categoria['precio3'];
                    }

                    $parameters['deusuario'] = $_SESSION['usuario'];
                    $parameters['empresa'] = $evento['empresa'];
                    $parameters['deevento'] = $cod_evento;
                    $parameters['categoria'] = $cat;
                    $parameters['opcion'] = $op_nombre;
                    $parameters['codigo'] = 0;
                    $parameters['iniciadoeldia'] = date("Y-m-d");
                    $parameters['venceeldia'] = date('Ymd', strtotime(date("d-m-Y") . "+11 days"));
                    $parameters['pagado'] = 0;
                    $parameters['pagoeldia'] = "";
                    $parameters['selemandomail'] = 1;
                    $parameters['precio'] = $precio1;
                    $parameters['respuestapart1'] = $respuestapart1;
                    $parameters['respuestapart2'] = $respuestapart2;
                    $parameters['respuestapart3'] = $respuestapart3;
                    $parameters['mes'] = filter_input(INPUT_POST, 'mes');
                    $parameters['cargopuntos'] = 0;
					$parameters['pmc'] = 1;
                    insertRow('inscribite_inscripciones', $parameters, $mysqli);

                    if (!empty($mysqli->error)) {
                        throw new Exception('Fallo en insercion de inscripción.' . $query . '<br>' . $mysqli->error);
                    }
                    sumoInscripcion($op_id, $mysqli);
                    if (!empty($mysqli->error)) {
                        throw new Exception('Fallo en la suma de cupo.' . $query . '<br>' . $mysqli->error);
                    }
                } else {
                    throw new Exception('Fallo en insercion de pmc.');
                }

                $email = $_SESSION['user_mail'];
                $asunto = "Inscribite Online - Inscripcion a Evento";
                $info_adicional = "From: Inscribite Online <info@inscribiteonline.com.ar>\r\nContent-Type: text/html;charset=utf-8\r\n";
                $mensaje = "";
                
//                if($evento['tipo'] == 'Deportivos'){
//                    require_once 'mail_deportivos.php';
//                }
//                
//                if($evento['tipo'] == 'Servicios'){
//                    require_once 'mail_servicios.php';
//                }
//                
//                if($evento['tipo'] == 'Productos'){
//                    require_once 'mail_productos.php';
//                }
//                
//                if($evento['tipo'] == 'Capacitación'){
//                    require_once 'mail_capacitacion.php';
//                }
//                
                //mail($email, $asunto, $mensaje, $info_adicional);

                //si no hubieron errores ejecutamos todas las queries
                $mysqli->commit();

                echo 1;
            } catch (Exception $e) {
                $mysqli->rollback();
                echo 0;
            }
        } elseif ($_POST['medio'] == "pf") {
            echo 1;
        } else {
            //header('Location:' . $general_path . 'index_argit.php');
        }
    } else {
        echo 0;
    }
} else {
    echo 0;
}
?>