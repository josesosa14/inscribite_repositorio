<?php

require_once dirname(__FILE__) . '/../general/db.php';
$general_path = "http://www.inscribiteonline.com.ar/";
$general_path2 = "http://www.inscribiteonline.com.ar/";
if ($_POST && !usuarioRegistrado($_POST,$mysqli)) {
    $parameters = parseParameters($_POST);
    $parameters['puntos'] = 0;
    $parameters['entrenador'] = "";
    $parameters['pileta'] = "";
    
    $parameters['fechanac'] = date('Ymd',strtotime($parameters['fec_dia'].'-'.$parameters['fec_mes'].'-'.$parameters['fec_ano']));

    //usuario
    insertRow('inscribite_usuarios', $parameters, $mysqli);
    $email = $parameters['email'];
    $asunto = "Bienvenido a Inscribite Online";
    $info_adicional = "From: Inscribite Online <info@inscribiteonline.com.ar>\r\nContent-Type: text/html;charset=utf-8\r\n";
    $mensaje = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Inscribite Online</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>
<div align="center">
  <p><a href="' . $general_path . '"><img src="' . $general_path . 'newsite2014/webimages/bannermail.png" width="280" height="100" border="0"></a></p>
  <table width="600" border="0" cellspacing="5" cellpadding="0">
    <tr>
      <td><p><font color="#666666" size="2" face="Arial, Helvetica, sans-serif">Estimado
          ' . $parameters['nombre'] . ' ' . $parameters['apellido'] . '</font></p>
        <p><font face="Arial, Helvetica, sans-serif" size="2" color="#666666">
		Bienvenido a Inscribite Online
           </font></p>
        <blockquote>
          <p><font face="Arial, Helvetica, sans-serif" size="2" color="#666666">Usuario
            <strong>' . $parameters['dni'] . ' </strong><br/>
            Contrase&ntilde;a <strong>' . $parameters['password'] . '</strong></font></p>
        </blockquote>
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
    if (mail($email, $asunto, $mensaje, $info_adicional)) {
        header('Location:' . $general_path . 'index_argit.php');
        $query = 'SELECT password,id FROM inscribite_usuarios WHERE dni = ' . $parameters['dni'] . '"';
        $user_info = getRowQuery($query, $mysqli);

        session_start();
		$_SESSION['usuario'] = $parameters['dni'];
		$_SESSION['user_id'] = $mysqli->insert_id;
		$_SESSION['user_mail'] = $parameters['email'];
		
        header('Location:' . $general_path2 . 'pagar.php#toShow');
    }
} else {
    header('Location:' . $general_path2 . 'index.php');
}






