<?
$msg="";
$msg.="Nombre: ".$_POST['nombre'].'<br/>'.chr(13);
$msg.="Empresa: ".$_POST['empresa'].'<br/>'.chr(13);
$msg.="Email: ".$_POST['email'].'<br/>'.chr(13);
$msg.="Teléfono: ".$_POST['telefono'].'<br/>'.chr(13);
$msg.='<br/>'.chr(13);
$msg.="Empresa: ". $_POST['consulta'].'<br/>'.chr(13);
mail('info@maritimopro.com.ar',"Consulta desde Inscribite Online",$msg,"From: info@maritimopro.com.ar\r\nContent-Type: text/html; charset=utf-8\r\n");

include 'includes/head.php'?>
		<div class="columnacentral" style="overflow:visible;">
			<div class="contenidoseccioncentral">
			<p>
Su consulta fue enviada, nos comunicaremos con usted para responderle. Muchas Gracias.
			</p>
			</div>
		</div>
<? include 'includes/colder.php'?>