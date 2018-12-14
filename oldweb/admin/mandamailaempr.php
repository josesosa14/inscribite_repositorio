<?
header("Cache-Control: no-cache, must-revalidate");  // HTTP/1.1
header("Pragma: no-cache");    	    	    	  // HTTP/1.0
ob_start();

$conexio = mysql_connect("localhost", "inscribite_user", "iW7zNKpRWkSHHwplBhUO");
mysql_select_db("inscribite_base", $conexio);

$evnorep = $_POST['nombre'];

$result1 = mysql_query('SELECT * FROM inscribite_empresas WHERE nombre="'.$evnorep.'" LIMIT 1 ');
while ($row1 = mysql_fetch_array($result1)) {

  $msg = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Inscribite Online</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>
<div align="center">
  <p><a href="http://www.inscribiteonline.com.ar/" target="_blank"><img src="http://www.inscribiteonline.com.ar/webimages/bannermail.jpg" width="600" height="100" border="0"></a></p>
  <table width="600" border="0" cellspacing="5" cellpadding="0">
    <tr>
      <td><p><font color="#666666" size="2" face="Verdana, Arial, Helvetica, sans-serif">Estimado '.$row1['contacto'].':</font></p>
        <p><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#666666">Pagofacil ha confirmado el pago de inscripciones, para ver los datos completos ingrese en <a href="http://www.inscribiteonline.com.ar/empresas/?empresa='.str_replace(" ", "_", $evnorep).'">http://www.inscribiteonline.com.ar/empresas/?empresa='.str_replace(" ", "_", $evnorep).'</a> con la contraseña: '.$row1['password'].' </font></p>

        <p><font color="#666666" size="2" face="Verdana, Arial, Helvetica, sans-serif">Saludos
          cordiales, y gracias por utilizar nuestro servicio<br/>
          Inscribite on line.</font><font color="#666666" size="2" face="Verdana, Arial, Helvetica, sans-serif"><br/>
          </font></p>
        </td>
    </tr>
  </table><br/>
  <table width="600" height="25" border="0" cellpadding="0" cellspacing="5" background="http://www.inscribiteonline.com.ar/webimages/footer.gif">
    <tr>
      <td><font color="#FFFFFF" size="1" face="Verdana, Arial, Helvetica, sans-serif">MARITIMO SRL / 4641-4423 4643-1124 / comercial@maritimopro.com.ar </font></td>
    </tr>
  </table>
  <p>&nbsp;</p>
</div>
</body>
</html>';

  $email = $row1[email];

  mail($row1['email'], "Inscripciones confirmadas desde: Inscribite Online", $msg, "From: info@maritimopro.com.ar\r\nContent-Type: text/html; charset=utf-8\r\n");

}

?>
Mail Enviado
<?
if (is_resource($result1))mysql_free_result($result1);
if (is_resource($result2))mysql_free_result($result2);
if (is_resource($result3))mysql_free_result($result3);
mysql_close($conexio);
?>