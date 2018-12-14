<?

header('Content-Type: text/html; charset=UTF-8');
header ("Cache-Control: no-cache, must-revalidate");  // HTTP/1.1
header ("Pragma: no-cache");                          // HTTP/1.0

ob_start();

function nlc($nombre) {

$nmarray = array();

$nmarray = split(" ", $nombre);



$nombreencapital = ucfirst($nmarray[0]).' '.ucfirst($nmarray[1]).' '.ucfirst($nmarray[2]).' '.ucfirst($nmarray[3]).' '.ucfirst($nmarray[4]).' '.ucfirst($nmarray[5]);



return trim($nombreencapital);

}

$conexio = mysql_connect("localhost", "maritimo_beebee", "beebee");
mysql_select_db ("maritimo_login", $conexio) OR die ("No se puede conectar");

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
 <head>
  <title>Inscribite Online</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <link href="http://www.inscribiteonline.com.ar/comercial/styles.css" rel="stylesheet" type="text/css"/>
  <link rel="shortcut icon" href="http://www.inscribiteonline.com.ar/webimages/favicon.ico" type="image/x-icon"/>
  <link rel="icon" href="http://www.inscribiteonline.com.ar/webimages/favicon.gif" type="image/gif"/>

<? //<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" /> ?>


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





cantdias = new Array(13)

function cantidias() {

	anho = document.getElementById("agnonacimiento").value;

	cantdias[1] = 31;

	cantdias[3] = 31;

	cantdias[4] = 30;

	cantdias[5] = 31;

	cantdias[6] = 30;

	cantdias[7] = 31;

	cantdias[8] = 31;

	cantdias[9] = 30;

	cantdias[10] = 31;

	cantdias[11] = 30;

	cantdias[12] = 31;

	

   if (( ( anho%4 == 0) && ( anho%100 != 0)) || ( anho%400 == 0)) {

       cantdias[2] = 29;

   } else {

       cantdias[2] = 28;

   }

  

  	if (( document.getElementById("dianacimiento").value != "" ) && ( document.getElementById("mesnacimiento").value != "" ) && ( document.getElementById("agnonacimiento").value != "" )) {

		if ( document.getElementById("dianacimiento").value > cantdias[document.getElementById("mesnacimiento").value] ) {

		 	document.getElementById('avisarmaldia').innerHTML = "Ese mes solo tiene "+cantdias[document.getElementById("mesnacimiento").value]+" días";

		}

	}

}



var nav4 = window.Event ? true : false;

function acceptNum(evt){	

	// NOTE: Backspace = 8, Enter = 13, '0' = 48, '9' = 57	

	var key = nav4 ? evt.which : evt.keyCode;	

	return (key <= 13 || (key >= 48 && key <= 57));

}

function checkacompleto() {

	if ( ( document.getElementById("nombre").value != "" ) &&

	 ( document.getElementById("apellido").value != "" ) &&

	 ( document.getElementById("dni").value != "" ) &&

	 //( document.getElementById("dianacimiento").value != "" ) &&	 

	 //( document.getElementById("mesnacimiento").value != "" ) &&

	 //( document.getElementById("agnonacimiento").value != "" ) &&

	 //( document.getElementById("sexo").value != "" ) &&

	 ( document.getElementById("email").value != "" ) &&

	 //( document.getElementById("password").value != "" ) &&

	 //( document.getElementById("passwordrepe").value != "" ) &&

	 (( document.getElementById("telefonoparticular").value != "" )|| ( document.getElementById("empresa").value != "" )) &&

	 ( document.getElementById("clave").value != "" ) 

	 //( document.getElementById("localidad").value != "" ) &&

	 //( document.getElementById("provincia").value != "" ) &&

	 //( document.getElementById("cp").value != "" ) &&
	 
	 //( document.getElementById("deporte1").value != "" ) &&

	 //( document.getElementById("alumno1").value != "" ) &&
	 
 	 //( document.getElementById("email1").value != "" ) &&
	 
 	 //( document.getElementById("alumno2").value != "" ) &&
	 
 	 //( document.getElementById("email2").value != "" ) &&
	 
  	 //( document.getElementById("alumno3").value != "" ) &&
	 
 	 //( document.getElementById("email3").value != "" ) &&
	 
  	 //( document.getElementById("alumno4").value != "" ) &&
 
 	 //( document.getElementById("email4").value != "" ) &&
	 
  	 //( document.getElementById("alumno5").value != "" ) &&
	 
 	 //( document.getElementById("email5").value != "" )

	) {

	document.getElementById('completo').innerHTML = "";

	document.getElementById("botonsumbit").disabled=false;

	} else {

	document.getElementById('completo').innerHTML = "Datos incompletos ";

	document.getElementById("botonsumbit").disabled=true;

	}

}

function checkearpassrepe() {

	 if ( document.getElementById("password").value != document.getElementById("passwordrepe").value ) {

	 	//if ( document.getElementById("passwordrepe").value != "" ) {

	 		document.getElementById('avisarmalpassword').innerHTML = "El password repetido es diferente. Ingreselos nuevamente.";

			document.getElementById("password").value = "";

			document.getElementById("passwordrepe").value = "";

		//}

	 } else {

	 	document.getElementById('avisarmalpassword').innerHTML = "";

	 }

}

function checkeamail() {

	if ((document.getElementById('email').value.indexOf("@") < 0) || (document.getElementById('email').value.indexOf(".") < 0)) {

	 	document.getElementById('avisarmalmail').innerHTML = "El email ingresado es incorrecto el formato correcto es nombredelacuenta@host.extencion.pais";	

		document.getElementById('email').value = "";

	} else {

		document.getElementById('avisarmalmail').innerHTML = "";

	}

}

	

-->

</script>

</head>

<body onload="no_Focus();" onkeyup="checkacompleto()" onclick="checkacompleto()">
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
    <h1>Registrese para acceder a los contenidos comerciales 
      <!-- formulario -->
      <?

//if ( $_GET['usuario'] != "" ) {

	//$result = mysql_query('SELECT * FROM inscribite_usuarios WHERE dni = "'.$_GET['usuario'].'" LIMIT 1 ');

	//while($row = mysql_fetch_array($result)) { 

?>
     </h1>
    <form action="finregistro.php" method="post">

	<input type="hidden" name="id" value="<? if ( $_GET['usuario'] != "" ) { echo $row['id']; } else { echo 'nuevo'; } ?>" />

  <fieldset class="fieldsettotal">
  <h1>
    <legend>Ingrese sus Datos Personales:</legend>
  </h1>
  <p style="text-align:center"> 
    <label for="nombre">Nombre:</label>
    <input type="text" name="nombre" id="nombre" value="<? echo  utf8_encode($row['nombre']); ?>" />
    <label for="apellido">Apellido:</label>
    <input type="text" name="apellido" id="apellido" value="<? echo ($row['apellido']); ?>" />
	<label for="email">Email:</label>
	<input type="text" name="email" id="email" onchange="checkeamail();" value="<? echo $row['email']; ?>" />&nbsp;&nbsp;<span id="avisarmalmail" style="float:left;clear:none;"></span>
  <p style="text-align:center"> 
    <label for="telefonoparticular">Teléfono:</label>
    <input type="text" name="telefonoparticular" id="telefonoparticular" <? echo 'onkeypress'; ?>="return acceptNum(event)" value="<? echo $row['telefonoparticular']; ?>" />
    <label for="empresa">Empresa:</label>
    <input type="text" name="telefonocelular" id="telefonocelular" value="<? echo $row['telefonocelular']; ?>" />
  </p>

  	<hr noshade="noshade" />

  <p style="text-align:center"> 
    <label for="dni">DNI:</label>
    <input type="text" name="dni" id="dni" <? echo 'onkeypress'; ?>="return acceptNum(event)" value="<? echo $row['dni']; ?>"  />
    <label for="clave">Clave:</label>
    <input type="text" name="clave" id="clave" value="<? echo utf8_encode($row['clave']); ?>" />
  <p style="text-align:center"> 

	<input type="submit" value="Registrese" id="botonsumbit" disabled="disabled" />
	<span id="completo" > Datos incompletos </span>	<br /><br /><br />
	</p>

  </fieldset>

</form>

<? // } ?>

<script type="text/javascript">

checkacompleto();

</script>

	<!-- fin del formulario -->

</div>
<? include '../includes/footer.php'?>
</body>

</html>

<?

//mysql_free_result($result);

mysql_close();

?>