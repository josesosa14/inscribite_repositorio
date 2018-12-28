<?php

require_once dirname(__FILE__) . '/../general/db.php';
$general_path = "http://127.0.0.1/";
$general_path2 = "http://127.0.0.1/";


if (isset($_POST['empresa'])) {


    $empresa = $_POST['empresa'];
    $query = "SELECT emp_nombre,emp_password,emp_mail,emp_usuario FROM empresa WHERE (emp_usuario = '" . $empresa."' OR emp_nombre = '".$empresa."') ";
    $user_info = getRowQuery($query, $mysqli);
	
	
    if ($user_info) {
	
        $email = $user_info['emp_mail'];
        $nombreEmpresa = $user_info['emp_nombre'];
        $nombreUsuario = $user_info['emp_usuario'];
        $passwordUsuario = $user_info['emp_password'];
        
        // Varios destinatarios
$para = 'To: '.$nombreEmpresa.' <'.$email.'>' . "\r\n";
//$para = 'dedieu92g@gmail.com'; // con coma si son m�s

// t�tulo
$titulo = 'Inscribite Online - Pedido alta evento';

// mensaje
$mensaje = '
   <head>
<title>Inscribite Online</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="refresh" content="10; url=/empresas/index.php" />
</head>
<body>
<div align="center">
  <p><a href="' . $general_path . '"><img src="' . $general_path . 'webimages/bannermail.png" width="280" height="100" border="0"></a></p>
  <table width="600" border="0" cellspacing="5" cellpadding="0">
    <tr>
      <td><p><font color="#666666" size="2" face="Arial, Helvetica, sans-serif">Estimado
          ' . $nombreEmpresa . '</font></p>
        <p><font face="Arial, Helvetica, sans-serif" size="2" color="#666666">
		Te enviamos tu contrase&ntilde;a para que puedas volver a Inscribite Online
           </font></p>
        <blockquote>
          <p><font face="Arial, Helvetica, sans-serif" size="2" color="#666666">Usuario
            <strong>' . $nombreUsuario . ' </strong><br/>
            Contrase&ntilde;a <strong>' . $passwordUsuario . '</strong></font></p>
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

// Para enviar un correo HTML, debe establecerse la cabecera Content-type
$cabeceras = 'MIME-Version: 1.0' . "\r\n";
$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Cabeceras adicionales
//$cabeceras .= 'To: '.$nombreEmpresa.' <'.$email.'>' . "\r\n";
$cabeceras .= 'From: Recordatorio <info@inscribiteonline.com.ar>' . "\r\n";



// Enviarlo
mail($para, $titulo, $mensaje, $cabeceras);
//echo $mensaje;
echo 'Ud sera redirigido en 10 segundos...';

}
}
