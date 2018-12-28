<?php

require_once dirname(__FILE__) . '/db.php';
$general_path = "http://127.0.0.1/";
$general_path2 = "http://127.0.0.1/";
$parameters['cpm_nombre'] = filter_var($_POST['cpm_nombre'], FILTER_SANITIZE_STRING);
$parameters['cpm_empresa'] = filter_var($_POST['cpm_empresa'], FILTER_SANITIZE_STRING);
$parameters['cpm_email'] = filter_var($_POST['cpm_email'], FILTER_SANITIZE_EMAIL);
$parameters['cpm_telefono'] = filter_var($_POST['cpm_telefono'], FILTER_SANITIZE_STRING);
$parameters['cpm_textoconsulta'] = filter_var($_POST['cpm_textoconsulta'], FILTER_SANITIZE_STRING);

$nombre = false;
$emailContacto = false;
$textoConsulta = false;



if (isset($parameters['cpm_nombre']) && !empty($parameters['cpm_nombre'])) {
    $nombre = true;
}
if (isset($parameters['cpm_email']) && !empty($parameters['cpm_email'])) {
    $emailContacto = true;
}
if (isset($parameters['cpm_textoconsulta']) && !empty($parameters['cpm_textoconsulta'])) {
    $textoConsulta = true;
}


if ($nombre && $emailContacto && $textoConsulta) {

    insertRow("consultas_por_mail", $parameters, $mysqli);
    $email = 'info@inscribiteonline.com.ar';
    $asunto = "Nuevo Consulta en Inscribite Online";
    $info_adicional = "From: info@inscribiteonline.com.ar\r\nContent-Type: text/html; charset=utf-8\r\n";
    $mensaje = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <title>Inscribite Online</title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    </head>
<body>
    <div align="center">
    <p>
        <a href="' . $general_path . '"><img src="' . $general_path . 'webimages/bannermail.png" width="280" height="100" border="0"></a>
    </p>
    <table width="600" border="0" cellspacing="5" cellpadding="0">
    <tr>
        <td>
            <p>
                <font color="#666666" size="2" face="Arial, Helvetica, sans-serif">
                </font>
            </p>
            <p>
                <font face="Arial, Helvetica, sans-serif" size="2" color="#666666">
                Nueva Consulta en Inscribite Online
                </font>
            </p>
            <blockquote>
                <p>
                    <font face="Arial, Helvetica, sans-serif" size="2" color="#666666">
                        Usuario:   <strong>' . $parameters['cpm_nombre'] . ' </strong><br/>
                        Empresa:  <strong>' . $parameters['cpm_empresa'] . '</strong><br/>
                        Email:  <strong>' . $parameters['cpm_email'] . '</strong><br/>
                        Telefono:  <strong>' . $parameters['cpm_telefono'] . '</strong><br/>
                        Consulta: "' . $parameters['cpm_textoconsulta'] . '"

                    </font>
                </p>
            </blockquote>
            <p>
                <font color="#666666" size="2" face="Arial, Helvetica, sans-serif">
                </font>
                <font color="#666666" size="2" face="Arial, Helvetica, sans-serif">
                <br/>
                </font>
            </p>
        </td>
    </tr>
</table>
<br/>
<table width="600" height="25" border="0" cellpadding="0" cellspacing="5" background="' . $general_path . 'webimages/footer.gif">
    <tr>
        <td>
            <font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">
                MARITIMO SRL / 4641-4423 4643-1124 / info@inscribiteonline.com.ar
            </font>
        </td>
    </tr>
</table>
<p>&nbsp;</p>
</div>
</body>
</html>';
    if (mail($email, $asunto, $mensaje, $info_adicional)) {
        header('Location:' . $general_path2 . 'contacto.php?email=true');
    } else {
        header('Location:' . $general_path2 . 'contacto.php?email=false');
    }
} else {
    $nombre = $parameters['cpm_nombre'];
    $email = $parameters['cpm_email'];
    $empresa = $parameters['cpm_empresa'];
    $telefono = $parameters['cpm_telefono'];
    header('Location:' . $general_path2 . 'contacto.php?datos=false&nombre=' . $nombre . '&email=' . $email . '&empresa=' . $empresa . '&telefono=' . $telefono);
}