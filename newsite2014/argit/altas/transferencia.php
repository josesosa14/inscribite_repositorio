<?php

require_once dirname(__FILE__) . '/../general/db.php';
$general_path = "http://www.inscribiteonline.com.ar/";
$general_path2 = "http://www.inscribiteonline.com.ar/";

if ($_POST) {
    $parameters = parseParameters($_POST);
    $parameters['tra_recibida'] = 0;
    $parameters['tra_fecha_pago'] = date('Ymd', strtotime($parameters['tra_fecha_pago']));
    insertRow('transferencias', $parameters, $mysqli);
    $tra_id = $mysqli->insert_id;


    $empresa = getRowQuery("SELECT emp_mail,emp_nombre,nombre FROM empresa LEFT JOIN inscribite_eventos ON empresa = emp_nombre WHERE emp_id = {$parameters['tra_emp_id']} AND id = {$parameters['tra_evento_id']}", $mysqli);

    //manda mail de confirmación
    $email = $empresa['emp_mail'];
    $asunto = "Inscribite Online - Transferencia ";
    $info_adicional = "From: info@inscribiteonline.com.ar \r\nContent-Type: text/html; charset=utf-8\r\n";
	$info_adicional .= "Cc: info@inscribiteonline.com.ar \r\n ";
    $mensaje = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Inscribite Online</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>
<div align="center">
  <p><a href="' . $general_path . '"><img src="' . $general_path . 'webimages/bannermail.png" width="280" height="100" border="0"></a></p>
  <table width="600" border="0" cellspacing="5" cellpadding="0">
    <tr>
      <td><p><font color="#666666" size="2" face="Arial, Helvetica, sans-serif">Estimado
          ' . $empresa['emp_nombre'] . '</font></p>
        <p><font face="Arial, Helvetica, sans-serif" size="2" color="#666666">
		Se le ha enviado un recibo de transferencia por medio de Inscribite Online
           </font></p>
        <blockquote>
          <p><font face="Arial, Helvetica, sans-serif" size="2" color="#666666">Usuario
            <strong>Monto:' . $parameters['tra_monto'] . ' </strong><br/>
            <strong>Fecha de pago:' . $parameters['tra_fecha_pago'] . ' </strong><br/>
        </blockquote>
		<a href="' . $general_path . 'altas/confirmar_transferencia.php?tra_id=' . $tra_id . '&value=true">Haga click aqu&iacute; para confirmar la recepci&oacute;n</a>
        <p><font color="#666666" size="2" face="Arial, Helvetica, sans-serif">Saludos
          cordiales,<br/>
          Inscribite Online.</font><font color="#666666" size="2" face="Arial, Helvetica, sans-serif"><br/>
          </font></p>
        </td>
    </tr>
  </table><br/>
  <table width="600" height="25" border="0" cellpadding="0" cellspacing="5" background="' . $general_path . 'webimages/footer.gif">
    <tr>
      <td><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">MARITIMO SRL / 4641-4423 4643-1124 / info@inscribiteonline.com.ar </font></td>
    </tr>
  </table>
  <p>&nbsp;</p>
</div>
</body>
</html>';

    mail($email, $asunto, $mensaje, $info_adicional);
    header('Location:../transferencias.php');
} else {
    header('Location:' . $general_path . 'transferencias.php');
}




