<html>
<head>
<style type="text/css">
<!--
body {
	font-family: sans-serif;
  font-size: 100%;
    color: grey;
}
a {
  font-size: 85%;
  color: blue;
  text-decoration:none;
}
a:hover {
  text-decoration: underline;
}
.botonborrar {
    font-size: 80%;
    color: red;
}
.apellido {
  color: black
}
.datos {
  color: black
}
.dni {
  color:#228B22;
}
.categoria {
  color:#808080;
}
#cargando {
	visibility: hidden;
	position: absolute;
	top: 0px;
	right: 17px;
	background-image: url("web_images/mozilla_giallo.gif");
	background-repeat: no-repeat;
	background-position: left top;
	width: 16px;
	height: 16px;
}
-->
</style>
<script type="text/javascript">
<!--
	function muestra(nro) {
		nuevoestado = 'block';
		if ( document.getElementById('masinfo'+nro).style.display == 'block' )
			nuevoestado = 'none';
			
		document.getElementById('masinfo'+nro).style.display = nuevoestado;
	}
	function muestraborrar(nro) {
		nuevoestado = 'visible';
		if ( document.getElementById('borra'+nro).style.visibility == 'visible' )
			nuevoestado = 'hidden';
			
		document.getElementById('borra'+nro).style.visibility = nuevoestado;
	}
	var http = getHTTPObject();
	var estadoajax = "libre";

	function getHTTPObject() { var xmlhttp; 
		/*@cc_on 
		@if (@_jscript_version >= 5)
			try {
				xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
			} catch (e) {
			try {
				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP"); 
			} catch (E) {
			xmlhttp = false;
			} 
		}
		@else xmlhttp = false; 
		@end @*/  
		if (!xmlhttp && typeof XMLHttpRequest != 'undefined') {
				try { xmlhttp = new XMLHttpRequest();
			} catch (e) {
				xmlhttp = false;
			} 
		}
		return xmlhttp;
	}

	function handleHttpResponse() {
		if (http.readyState == 4) {
			estadoajax = "libre";
			document.getElementById("cargando").style.visibility = 'hidden';
			//document.getElementById("entradas").innerHTML = http.responseText;
		}
	}
	function enviacheck(nro) {
		if ( estadoajax == "libre" ) {
			document.getElementById("cargando").style.visibility = 'visible';
			estadoajax = "laburando";
			var mandValue = "?vars=";
			var mandValue = mandValue + "&id=" + nro;
			var mandValue = mandValue + "&stat=" + document.getElementById("check"+nro).checked;

			http.open("GET", 'enviacheck.php' + mandValue, true);
			http.onreadystatechange = handleHttpResponse;
			http.send(null);
			//window.setTimeout("sisetilda();",3000);
		}
	}
-->
</script>
</head>
<body>
<div id="entradas"></div>
<div id="cargando"></div>
Ordenar por: <a href="usuarios.php?ordpor=nombre">nombre</a>, <a href="usuarios.php?ordpor=apellido">apellido</a>, <a href="usuarios.php?ordpor=dni">dni</a>, <a href="usuarios.php?ordpor=edad">edad</a>, <a href="usuarios.php?ordpor=evento">evento</a>
<br /><br />
<?
$conexio = mysql_connect("localhost", "maritimo_beebee", "beebee");
mysql_select_db ("maritimo_login", $conexio) OR die ("No se puede conectar");

$ordpor = $HTTP_GET_VARS["ordpor"];
if ($ordpor == "") {
	//$result = mysql_query('SELECT * FROM inscribite_usuarios ORDER BY id ');
	$result = mysql_query('SELECT * FROM inscribite_usuarios WHERE dni = "'.$HTTP_GET_VARS["dni"].'" ');
}
if ($ordpor == "nombre") {
	$result = mysql_query('SELECT * FROM inscribite_usuarios ORDER BY nombre ');
}
if ($ordpor == "apellido") {
	$result = mysql_query('SELECT * FROM inscribite_usuarios ORDER BY apellido ');
}
if ($ordpor == "dni") {
	$result = mysql_query('SELECT * FROM inscribite_usuarios ORDER BY dni ');
}
if ($ordpor == "edad") {
	$result = mysql_query('SELECT * FROM inscribite_usuarios ORDER BY agnonacimiento ');
}
if ($ordpor == "evento") {
	$result = mysql_query('SELECT * FROM inscribite_usuarios ORDER BY evento0 ');
}

	while($row = mysql_fetch_array($result)) {

$mostrar = true;
	 
if (
(
( ucfirst($row["nombre"]) == $an_nombre ) && 
( ucfirst($row["apellido"]) == $an_apellido ) && 
( ucfirst($row["dni"]) == $an_dni ) && 
( ucfirst($row["dianacimiento"]) == $an_dianacimiento ) && 
( ucfirst($row["mesnacimiento"]) == $an_mesnacimiento ) && 
( ucfirst($row["agnonacimiento"]) == $an_agnonacimiento ) && 
( ucfirst($row["sexo"]) == $an_sexo ) && 
( ucfirst($row["email"]) == $an_email ) && 
( ucfirst($row["telefonoparticular"]) == $an_telefonoparticular ) && 
( ucfirst($row["telefonolaboral"]) == $an_telefonolaboral ) && 
( ucfirst($row["telefonocelular"]) == $an_telefonocelular ) && 
( strtolower($row["domicilio"]) == $an_domicilio ) && 
( ucfirst($row["provincia"]) == $an_provincia ) && 
( ucfirst($row["pais"]) == $an_pais )
) || 
( ucfirst($row["dni"]) == "" )
) {
	$mostrar = false;
}

if ( $mostrar == true ) {
  
echo ucfirst(strtolower($row["nombre"])); ?> 
<span class="apellido"><? echo ucfirst(strtolower($row["apellido"])); ?></span>, 
Dni <span class="dni"><? echo $row["dni"]; ?></span> Categoria: <span class="categoria">
<? echo $row["evento0"]; ?></span> 
Confirmado: 
<input id="check<? echo $row['id']; ?>" <? echo 'onchange'; ?>="enviacheck(<? echo $row['id']; ?>)" type="checkbox" <? if ( $row['confirmado0'] == 1 ) { echo 'checked="checked"'; } ?> />

 <a href="javascript:muestra(<? echo $row['id']; ?>)">Ver más</a>
 
<a href="javascript:muestraborrar(<? echo $row['id']; ?>)" class="botonborrar">Borrar</a>
</span>
<span id="borra<? echo $row['id']; ?>" style="visibility: hidden;">Seguro? <a href="borrausuario.php?id=<? echo $row['id']; ?>">Si</a> <a href="javascript:muestraborrar(<? echo $row['id']; ?>)">No</a></span>
 
<br />
<div id="masinfo<? echo $row["id"]; ?>" style="display: none;">
Nacimiento: <span class="datos"><? echo $row["dianacimiento"]; ?> / <? echo $row["mesnacimiento"]; ?> / <? echo $row["agnonacimiento"]; ?></span><br />
Sexo: <span class="datos"><? echo ucfirst($row["sexo"]); ?></span><br />
Email: <span class="datos"><? echo strtolower($row["email"]); ?></span><br />
Password: <span class="datos"><? echo $row["password"]; ?></span><br />
Telefono Particular: <span class="datos"><? echo $row["telefonoparticular"]; ?></span><br />
Telefono Laboral: <span class="datos"><? echo $row["telefonolaboral"]; ?></span><br />
Telefono Celular: <span class="datos"><? echo $row["telefonocelular"]; ?></span><br />
Domicilio: <span class="datos"><? echo $row["domicilio"]; ?></span><br />
Provincia: <span class="datos"><? echo ucfirst(strtolower($row["provincia"])); ?></span><br />
País: <span class="datos"><? echo $row["pais"]; ?></span><br />
Evento 1: <span class="datos"><? echo $row["evento0"]; ?></span><br />
Evento 2: <span class="datos"><? echo $row["evento1"]; ?></span><br />
Evento 3: <span class="datos"><? echo $row["evento2"]; ?></span><br />
</div>
<?
	}
		
$an_nombre = ucfirst($row["nombre"]);
$an_apellido = ucfirst($row["apellido"]);
$an_dni = ucfirst($row["dni"]);
$an_dianacimiento = ucfirst($row["dianacimiento"]);
$an_mesnacimiento = ucfirst($row["mesnacimiento"]);
$an_agnonacimiento = ucfirst($row["agnonacimiento"]);
$an_sexo = ucfirst($row["sexo"]);
$an_email = ucfirst($row["email"]);
$an_password = ucfirst($row["password"]);
$an_telefonoparticular = ucfirst($row["telefonoparticular"]);
$an_telefonolaboral = ucfirst($row["telefonolaboral"]);
$an_telefonocelular = ucfirst($row["telefonocelular"]);
$an_domicilio = strtolower($row["domicilio"]);
$an_provincia = ucfirst($row["provincia"]);
$an_pais = ucfirst($row["pais"]);

}
?>
</body>
</html>
<?
mysql_free_result($result);
mysql_close();
?>