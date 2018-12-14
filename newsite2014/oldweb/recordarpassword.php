<?
mysql_select_db("inscribite_base",mysql_connect("localhost","inscribite_user","iW7zNKpRWkSHHwplBhUO"));
//mysql_select_db("maritimo_login",mysql_connect("localhost","maritimo_beebee","beebee"));
if($_POST['recordar']!="")$recordar=$_POST['recordar'];
if($_GET['recordar']!="")$recordar=$_GET['recordar'];
if($_POST['username']!="")$username=$_POST['username'];
if($_GET['username']!="")$username=$_GET['username'];
if($_GET['dni']!=""){
    $username=$_GET['dni'];
    $recordar='password';
}
if($recordar=='password'){
	$result1=mysql_query("SELECT * FROM inscribite_usuarios WHERE dni='".$username."' LIMIT 1 ");
	if(mysql_num_rows($result1)>0){
	while($row=mysql_fetch_array($result1)){

$msg='<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Inscribite Online</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>
<div align="center">
  <p><a href="http://www.inscribiteonline.com.ar" target="_blank"><img src="http://www.inscribiteonline.com.ar/webimages/bannermail.jpg" width="600" height="100" border="0"></a></p>
  <table width="600" border="0" cellspacing="5" cellpadding="0">
    <tr>
      <td><p><font color="#666666" size="2" face="Arial, Helvetica, sans-serif">Estimado
          '.$row['nombre'].' '.$row['apellido'].'</font></p>
        <p><font face="Arial, Helvetica, sans-serif" size="2" color="#666666">Te
          recordammos tu contrase&ntilde;a de Inscribite on line seg&uacute;n
          tu pedido. </font></p>
        <blockquote>
          <p><font face="Arial, Helvetica, sans-serif" size="2" color="#666666">Usuario
            <strong>'.$row['dni'].' </strong><br/>
            Contrase&ntilde;a <strong>'.$row['password'].'</strong></font></p>
        </blockquote>
        <p><font color="#666666" size="2" face="Arial, Helvetica, sans-serif">Saludos
          cordiales,<br/>
          Inscribite on line.</font><font color="#666666" size="2" face="Arial, Helvetica, sans-serif"><br/>
          </font></p>
        </td>
    </tr>
  </table><br/>
  <table width="600" height="25" border="0" cellpadding="0" cellspacing="5" background="http://www.inscribiteonline.com.ar/webimages/footer.gif">
    <tr>
      <td><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">MARITIMO SRL / 4641-4423 4643-1124 / comercial@maritimopro.com.ar </font></td>
    </tr>
  </table>
  <p>&nbsp;</p>
</div>
</body>
</html>';
$email=$row['email'];
}
mail($email,"Recuerdo de Password desde Inscribite Online",$msg,"From: info@maritimopro.com.ar\r\nContent-Type: text/html; charset=utf-8\r\n");
}else{
$usernoexiste=true;
}
}
include 'includes/header.php'?>
  <div class="left" style="overflow:visible;">
<?
if($recordar=='password'){
if($usernoexiste){ ?>
				  <h1>
				    No existe ning&uacute;n usuario con ese DNI. </h1>
				  <p>Por favor revise si lo ha escrito correctamente. </p>
				  <p>Si todav&iacute;a no se ha registrado hacelo haciendo click <a href="registrate" style="text-decoration:underline;">aqu&iacute;</a>. Gracias </p>
				  <? }else{ ?>
				<h1>Env&iacute;o de clave</h1>
				<p>Se ha enviado un email a 
				  <?=str_repeat('*', strlen(substr($email, 0, strpos($email, '@')))).substr($email, strpos($email, '@'), 200)?>
				  para recordarte tu clave revisa tu casilla.  </p>
				<p>Si este email es incorrecto comunicate al (11) 4641-4423. </p>
				<?	}
}else{ ?>
			<form action="recordarpassword" method="post">
			  <h1>Olvidaste tu clave?</h1>
              <br />
              <br />
			  <p>Si ya est&aacute;s registrado y olvidaste tu contrase&ntilde;a. Ingresa tu nombre de usuario ( n&uacute;mero de DNI ) y te enviaremos un email con la clave. </p>
              <br />
              <br />
			  <p>Si ya no utilizas esa cuenta de mail comunicate con <a href="mailto:info@maritimopro.com.ar">info@maritimopro.com.ar</a>			</p>
              <br />
              <br />              
			  <h2>
  <input type="hidden" name="recordar" value="password"/>
			    Nombre de usuario:
  <input type="text" name="username" id="dnirecus" onkeypress="return acceptNum(event)" title="Su nombre de usuario es el nro de DNI" onkeyup="cortardnilargo(this)"/>
		        </h2>
			  <p>
<input type="submit" value="Enviarme un email con la clave"/>
			</p>
			</form>
<? } ?>
<? include 'includes/footerfull.php'?>