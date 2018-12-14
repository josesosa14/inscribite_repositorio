<?php

require_once dirname(__FILE__) . '/../general/header_empresa.php';



$parameters = parseParameters($_POST);
$path = dirname(__FILE__) . '/imagenes/';

if (!isset($parameters['pevt_news'])) {
    $parameters['pevt_news'] = 0;
}

if (!isset($parameters['pevt_banner'])) {
    $parameters['pevt_banner'] = 0;
}


$parameters['pevt_fecha_inicio'] = date('Y-m-d', strtotime($parameters['pevt_fecha_inicio']));
$parameters['pevt_venc1'] = date('Y-m-d', strtotime($parameters['pevt_venc1']));
$parameters['pevt_venc2'] = date('Y-m-d', strtotime($parameters['pevt_venc2']));
$parameters['pevt_venc3'] = date('Y-m-d', strtotime($parameters['pevt_venc3']));
$parameters['pevt_fecha_calculo'] = date('Y-m-d', strtotime($parameters['pevt_fecha_calculo']));

//echo '<pre>';print_r($_FILES);die;
if ($_FILES && $_FILES['imagen']['error'] == 0 && ($_FILES['imagen']['type'] == 'image/jpeg' || $_FILES['imagen']['type'] == 'image/png')) {
    if (move_uploaded_file($_FILES['imagen']['tmp_name'], $path . $_FILES['imagen']['name'])) {
        
    }
    else {
        die('No se pudo cargar el archivo');
    }

    $parameters['pevt_imagen'] = $_FILES['imagen']['name'];
}



insertRow('pedido_evento', $parameters, $mysqli);

if ($parameters['categorias']) {
    foreach ($parameters['categorias'] as $key => $categoria) {
        if ($categoria['pcat_nombre'] && $categoria['pcat_sexo'] != 'elegir') {
            $out[$key] = $categoria;
            $out[$key]['pcat_pevt_id'] = $mysqli->insert_id;
        }
    }
    insertArray('pedido_categorias', $out, $mysqli);
}


//$email = 'info@inscribiteonline.com.ar';
/*$email = 'rmatiasgallardo@gmail.com';
$asunto = "Inscribite Online - Pedido alta evento";
$info_adicional = 'From: Inscribite Online <info@inscribiteonline.com.ar>\r\nContent-Type: text/html;charset=utf-8\r\n';
$mensaje = '<!DOCTYPE html>
                <html>
                <head>
                <title>Inscribite Online</title>
                <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
                </head>
                <body><p>se pidiÃ³ una alta para el evento ' . $parameters['pevt_nombre'] . ' de la empresa ' . $_SESSION['empresa'] . '</p></body>
                </html>';


mail($email, $asunto, $mensaje, $info_adicional);*/
// Varios destinatarios
$para = 'info@inscribiteonline.com.ar'; // con coma si son más
//$para = 'dedieu92g@gmail.com'; // con coma si son más

// título
$título = 'Inscribite Online - Pedido alta evento';

// mensaje
$mensaje = '
    <html>
        <head>
            <title>Inscribite Online - Pedido alta evento</title>
        </head>
        <body>
            <p>Inscribite Online</p>
            <p>
                <a href="' . $general_path . '"><img src="' . $general_path . 'webimages/bannermail.png" width="280" height="100" border="0"></a>
            </p>
            <p>se pidiÃ³ una alta para el evento ' . $parameters['pevt_nombre'] . ' de la empresa ' . $_SESSION['empresa'] . '</p>
        </body>
    </html>
';

// Para enviar un correo HTML, debe establecerse la cabecera Content-type
$cabeceras = 'MIME-Version: 1.0' . "\r\n";
$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Cabeceras adicionales
$cabeceras .= 'To: Inscribite <'.$para.'>' . "\r\n";
$cabeceras .= 'From: Recordatorio <'.$para.'>' . "\r\n";



// Enviarlo
mail($para, $título, $mensaje, $cabeceras);
