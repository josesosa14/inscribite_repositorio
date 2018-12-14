<?

$conexio = mysql_connect("localhost", "maritimo_beebee", "beebee");
mysql_select_db ("maritimo_login", $conexio) OR die ("No se puede conectar");


$yaseinscribio = false;

$result = mysql_query('SELECT dni FROM inscribite_comercial WHERE dni = '.$_POST['dni'].' LIMIT 1 ');

while($row = mysql_fetch_array($result)) { $yaseinscribio = true; } 

if ($_POST['id'] != "nuevo")

	$yaseinscribio = false;



if (!($yaseinscribio)) {

setcookie("usuario", $_POST["dni"], time()+7776000, "/");

$usuario = $_POST["dni"];

}



header ("Cache-Control: no-cache, must-revalidate");  // HTTP/1.1

header ("Pragma: no-cache");                          // HTTP/1.0

ob_start();



function nlc($nombre) {

$nmarray = array();

$nmarray = split(" ", $nombre);

$nombreencapital = ucfirst($nmarray[0]).' '.ucfirst($nmarray[1]).' '.ucfirst($nmarray[2]).' '.ucfirst($nmarray[3]).' '.ucfirst($nmarray[4]).' '.ucfirst($nmarray[5]);

return trim($nombreencapital);

}

$idActual = $_POST['id'];

if ($idActual == 'nuevo') {

mysql_query ("INSERT INTO `inscribite_comercial` ( `id` )

VALUES ( '' );");

$result = mysql_query('SELECT id FROM inscribite_comercial ORDER BY id DESC LIMIT 1 ');

while($row = mysql_fetch_array($result)) {

	$idActual = $row['id'];

} }



foreach ($_POST as $nombrevariable => $valorvariable) {

	if (($nombrevariable != 'id') && ($nombrevariable != 'tabla'))

	mysql_query ("UPDATE inscribite_comercial SET ".$nombrevariable." = \"".$valorvariable. "\" WHERE id=$idActual");

}



?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
 <head>
  <title>Inscribite Online</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <link href="http://www.inscribiteonline.com.ar/comercial/styles.css" rel="stylesheet" type="text/css"/>
  <link rel="shortcut icon" href="http://www.inscribiteonline.com.ar/webimages/favicon.ico" type="image/x-icon"/>
  <link rel="icon" href="http://www.inscribiteonline.com.ar/webimages/favicon.gif" type="image/gif"/>
  
<script type="text/javascript">

<!--

	var imagenesacargar = new Array("http://www.maritimopro.com.ar/inscri2/webimages/solapa1.gif");

	var lista_imagenes = new Array();

	function cargarimagenes(){

	   for(i in imagenesacargar){

		 lista_imagenes[i] = new Image();

		 lista_imagenes[i].src = imagenesacargar[i];

		}

	}



	function no_Focus() {

	anclas=document.getElementsByTagName("a").length;

	for (i=0;i<anclas;i++)

		document.getElementsByTagName("a").item(i).onfocus=new Function("if(this.blur)this.blur()")

	}

	function mostrar(nombreid) {

		if (nombreid != '') {

			nuevoestado = 'block';

			if ( document.getElementById(nombreid).style.display == 'block' )

				nuevoestado = 'none';

				

			document.getElementById(nombreid).style.display = nuevoestado;

		}

	}

function funcionderubro() {

	abc = document.getElementById('menurubro').value;

	document.getElementById('todoslosrubros').style.display = 'none';

	document.getElementById("eventosdeportivos").style.display = 'none';

	document.getElementById("eventoscapacitacion").style.display = 'none';

	document.getElementById("eventosmensualidades").style.display = 'none';



	document.getElementById(abc).style.display = 'block';

}

function cambio(nombredelid) {

	document.getElementById("eventoelegidoenselect").value = document.getElementById(nombredelid).value;

}

-->

</script>

</head>

<body onload="no_Focus();">

<div align="center">
  <div class="centrado">
   <div class="lineainicioyfinal"></div>
    <div class="header">
     <div class="separacionsolapas">
      <a href="http://www.inscribiteonline.com.ar/" class="logolinkalhome" ></a>
     </div>
     <div class="gruposolapas">
      <a href="http://www.inscribiteonline.com.ar/servicio" class="solapa<? if($_SERVER['PHP_SELF']!='/servicio.php')echo 'no'?>seleccionada">Servicios</a>
      <a href="http://www.inscribiteonline.com.ar/eventos" class="solapa<? if($_SERVER['PHP_SELF']!='/eventos.php')echo 'no'?>seleccionada">Eventos</a>
      <a href="http://www.inscribiteonline.com.ar/pagos" class="solapa<? if($_SERVER['PHP_SELF']!='/pagos.php')echo 'no'?>seleccionada">Pagos</a>
      <a href="http://www.inscribiteonline.com.ar/promociones" class="solapa<? if($_SERVER['PHP_SELF']!='/promociones.php')echo 'no'?>seleccionada">Promociones</a>
      <a href="http://www.inscribiteonline.com.ar/contacto" class="solapa<? if($_SERVER['PHP_SELF']!='/contacto.php')echo 'no'?>seleccionada">Contacto</a>
      <a href="http://www.inscribiteonline.com.ar/faq" class="solapa<? if($_SERVER['PHP_SELF']!='/faq.php')echo 'no'?>seleccionada">Ayuda</a>
     </div>
    </div>
    <div class="content"><br />
<p>
  <? if ($yaseinscribio) { ?>
  Ya te encontrás registrado. Por cualquier consulta comunicate al 4641-4423 o por email con <a href="mailto:comercial@maritimopro.com.ar" style="text-decoration:underline;">comercial@maritimopro.com.ar</a> 
  <? } else {  ?>
</p>
<p> Gracias por completar todos los datos requeridos, podes ingresar clickenado <a href="index.php">aquí</a>. 
<p>Ante cualquier duda 
  comunicate a <a href="mailto:comercial@maritimopro.com.ar">comercial@maritimopro.com.ar</a>. 
  Muchas Gracias. </p>
  <script type="text/javascript">
	<!--
	location.href='index.php';
	-->
    </script>
</div>  
  <?
    	$cuerpo = "A Inscribite on line COMERCIAL se ha registrado" . "\n"; 
	    $cuerpo .= "Nombre: " . $HTTP_POST_VARS["nombre"] . "\n"; 
	    $cuerpo .= "Apellido: " . $HTTP_POST_VARS["apellido"] . "\n"; 		
	    $cuerpo .= "Email: " . $HTTP_POST_VARS["email"] . "\n"; 
	    $cuerpo .= "Empresa: " . $HTTP_POST_VARS["telefonocelular"] . "\n"; 
	    $cuerpo .= "Telefono: " . $HTTP_POST_VARS["telefonoparticular"] . "\n"; 
	    $cuerpo .= "DNI: " . $HTTP_POST_VARS["dni"] . "\n"; 
	    $cuerpo .= "Clave: " . $HTTP_POST_VARS["clave"] . "\n"; 		
		mail("fabianderamo@maritimopro.com.ar", "Registro a Inscribite on line COMERCIAL",$cuerpo,"From: Inscribite On line");
		//mail("pablo@rebon.com.ar", "Registro a Inscribite on line COMERCIAL",$cuerpo,"From: R diseño <info@pablorebon.com.ar>");


  //envia mails a los alumnos
	//$msg = "";
	//$msg .= "El entrenador <b>". $_POST['nombre']." ".$_POST['apellido']."</b> nos ha solicitado ingresar al TRAINERS CLUB, y entre la lista de dirigidos que entrena te ha incluido. Solo necesitamos que si lo reconoces como tu entrenador, hagas click <a href='http://www.maritimopro.com.ar/trainersclub/validacion.php'>aquí</a> para confirmarlo y de esta forma le permitirás ingresar a este grupo del cual obtendrá distintos beneficios que sin lugar a duda te beneficiaran también a vos, no lo dudes.".chr(13);
	//$msg .= '<p />'.chr(13);
	//$msg .= "Gracias por tu colaboración. Si no lo reconoces como tu entrenador, disculpa la molestia y podes eliminar este e-mail.".chr(13);
	//$msg .= '<p />'.chr(13);
	//$msg .= "Te saluda atte, Trainers CLUB.".chr(13);
	//$to1 .= $_POST['email1'] ;

	//mail($to1,"Trainers CLUB 1",$msg,"From: info@trainersclub.com.ar\r\nContent-Type: text/html; charset=utf-8\r\n");

	 } ?>
  
  </div>
<? include '../includes/footer.php'?>
</body>

</html>

<?

mysql_free_result($result);

mysql_close();

?>