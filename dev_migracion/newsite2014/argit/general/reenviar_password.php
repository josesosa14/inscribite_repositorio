<?php
require_once dirname(__FILE__) . '/../general/db.php';
$general_path = "http://www.inscribiteonline.com.ar/";
$general_path2 = "http://arg-it.com/inscribite/argit/";

if($_POST['action'] == "checkEmail") { 
  	 
  $dni = $_POST['dni'];	
  $query = 'SELECT nombre,apellido,password,email FROM inscribite_usuarios WHERE dni = '. $dni;
  $user_info = getRowQuery($query, $mysqli);
  if($user_info) {
  $email = $user_info['email'];
  $nombreUsuario = 	$user_info['nombre'];
  $apellidoUsuario = $user_info['apellido'];
  $passwordUsuario = $user_info['password'];
  $asunto = utf8_encode("Tu contraseña de Inscribite Online");
  $info_adicional = "From: Inscribite Online <info@inscribiteonline.com.ar>\r\nContent-Type: text/html;charset=utf-8\r\n";
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
          ' . $nombreUsuario .' '. $apellidoUsuario . '</font></p>
        <p><font face="Arial, Helvetica, sans-serif" size="2" color="#666666">
		Te enviamos tu contrase&ntilde;a para que puedas volver a Inscribite Online
           </font></p>
        <blockquote>
          <p><font face="Arial, Helvetica, sans-serif" size="2" color="#666666">Usuario
            <strong>' . $dni . ' </strong><br/>
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
    if(mail($email, $asunto, $mensaje, $info_adicional)) {
                $respuesta['validez'] = 1;
                $respuesta['correo'] = mask_email($email,'*',50);
		echo json_encode($respuesta);
		exit();	
	} else {
                $respuesta['validez'] = 0;
                $respuesta['correo'] = mask_email($email,'*',50);
		echo json_encode(0);
		exit();	
	}
} else {
        $respuesta['validez'] = 0;
        $respuesta['correo'] = false;
	echo json_encode(2);
	exit();	
}

}

function mask_email( $email, $mask_char, $percent=50 ) 
{ 

        list( $user, $domain ) = preg_split("/@/", $email ); 

        $len = strlen( $user ); 

        $mask_count = floor( $len * $percent /100 ); 

        $offset = floor( ( $len - $mask_count ) / 2 ); 

        $masked = substr( $user, 0, $offset ) 
                .str_repeat( $mask_char, $mask_count ) 
                .substr( $user, $mask_count+$offset ); 


        return( $masked.'@'.$domain ); 
} 

?>