<html>
  <head>
    <style type="text/css">
    <!--
    body{
    	font-family:sans-serif;
    	font-size:100%;
    	color:grey;
    }
    a{
    	font-size:85%;
    	color:blue;
    	text-decoration:none;
    }
    a:hover {
    	text-decoration:underline;
    }
    .botonborrar{
    	font-size:80%;
    	color:red;
    }
    .apellido{
    	color:black
    }
    .datos{
    	color:black
    }
    .dni{
    	color:#228B22;
    }
    .categoria{
    	color:#808080;
    }
    #cargando{
    	visibility:hidden;
    	position:absolute;
    	top:0px;
    	right:17px;
    	background-image:url(images/ajaxloadingbig.gif);
    	background-repeat:no-repeat;
    	background-position:left top;
    	width:16px;
    	height:16px;
    }
-->
</style>
<script type="text/javascript">
<!--
function muestra(nro) {
  nuevoestado = 'block';
  if (document.getElementById('masinfo'+nro).style.display == 'block')
    nuevoestado = 'none';
  document.getElementById('masinfo'+nro).style.display = nuevoestado;
}
function muestraborrar(nro){
  nuevoestado = 'visible';
  if (document.getElementById('borra'+nro).style.visibility == 'visible')
    nuevoestado = 'hidden';
  document.getElementById('borra'+nro).style.visibility = nuevoestado;
}
var http = getHTTPObject();
var estadoajax = "libre";

function getHTTPObject(){ var xmlhttp;
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
  if (!xmlhttp && typeof XMLHttpRequest != 'undefined'){
    try { xmlhttp = new XMLHttpRequest();
    } catch (e) {
      xmlhttp = false;
    }
  }
  return xmlhttp;
}

function handleHttpResponse(){
  if (http.readyState == 4){
    estadoajax = "libre";
    document.getElementById("cargando").style.visibility = 'hidden';
    //document.getElementById("entradas").innerHTML = http.responseText;
  }
}
function enviacheck(nro){
  if (estadoajax == "libre"){
    document.getElementById("cargando").style.visibility = 'visible';
    estadoajax = "laburando";
    var mandvalue="?vars=";
    var mandvalue=mandValue+"&id="+nro;
    var mandvalue=mandValue+"&stat="+document.getElementById("check"+nro).checked;

    http.open("GET",'enviacheck.php'+mandValue,true);
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
$conexio = mysql_connect("localhost", "inscribite_user", "iW7zNKpRWkSHHwplBhUO");
mysql_select_db("inscribite_base", $conexio);

$ordpor=$_GET[ordpor];
if ($ordpor == ""){
	//$result1 = mysql_query('SELECT * FROM inscribite_usuarios ORDER BY id ');
	$result1 = mysql_query('SELECT * FROM inscribite_usuarios WHERE dni = "'.$_GET['dni'].'" ');
}
if ($ordpor == "nombre")
	$result1 = mysql_query('SELECT * FROM inscribite_usuarios ORDER BY nombre ');

if ($ordpor == "apellido")
	$result1 = mysql_query('SELECT * FROM inscribite_usuarios ORDER BY apellido ');

if ($ordpor == "dni")
	$result1 = mysql_query('SELECT * FROM inscribite_usuarios ORDER BY dni ');

if ($ordpor == "edad")
	$result1 = mysql_query('SELECT * FROM inscribite_usuarios ORDER BY fechanac ');

if ($ordpor == "evento")
	$result1 = mysql_query('SELECT * FROM inscribite_usuarios ORDER BY evento0 ');

	while ($row1 = mysql_fetch_array($result1)){

$mostrar = true;

if ((
( $row1['nombre'] == $an_nombre)&&
( $row1['apellido'] == $an_apellido)&&
( ucfirst($row1['dni']) == $an_dni)&&
( ucfirst($row1['fechanac']) == $an_fechanac)&&
( ucfirst($row1['sexo']) == $an_sexo)&&
( ucfirst($row1['email']) == $an_email)&&
( ucfirst($row1['telefonoparticular']) == $an_telefonoparticular)&&
( ucfirst($row1['telefonolaboral']) == $an_telefonolaboral)&&
( ucfirst($row1['telefonocelular']) == $an_telefonocelular)&&
( strtolower($row1['domicilio']) == $an_domicilio)&&
( ucfirst($row1['provincia']) == $an_provincia)&&
( ucfirst($row1['pais']) == $an_pais)) ||
( ucfirst($row1['dni']) == '')
){
	$mostrar = false;
}

if ($mostrar){

echo $row1[nombre]?>
<span class="apellido"><?=ucfirst(strtolower($row1['apellido']))?></span>,
Dni <span class="dni"><?=$row1['dni']?></span> Categoria: <span class="categoria">
<?=$row1['evento0']?></span>
Confirmado:
<input id="check<?=$row1['id']?>" onchange="enviacheck(<?=$row1['id']?>)" type="checkbox"<? if ($row1['confirmado0'] == 1)echo ' checked="checked"'?>/>

 <a href="javascript:muestra(<?=$row1['id']?>)">Ver más</a>

<a href="javascript:muestraborrar(<?=$row1['id']?>)" class="botonborrar">Borrar</a>
</span>
<span id="borra<?=$row1['id']?>" style="visibility: hidden;">Seguro? <a href="borrausuario.php?id = <?=$row1['id']?>">Si</a> <a href="javascript:muestraborrar(<?=$row1['id']?>)">No</a></span>

<br />
<div id="masinfo<?=$row1['id']?>" style="display: none;">
Nacimiento: <span class="datos"><?=substr($row1['fechanac'],6,2)."/".substr($row1['fechanac'],4,2)."/".substr($row1['fechanac'],0,4)?></span><br />
Sexo: <span class="datos"><?=ucfirst($row1['sexo'])?></span><br />
Email: <span class="datos"><?=strtolower($row1['email'])?></span><br />
Password: <span class="datos"><?=$row1['password']?></span><br />
Telefono Particular: <span class="datos"><?=$row1['telefonoparticular']?></span><br />
Telefono Laboral: <span class="datos"><?=$row1['telefonolaboral']?></span><br />
Telefono Celular: <span class="datos"><?=$row1['telefonocelular']?></span><br />
Domicilio: <span class="datos"><?=$row1['domicilio']?></span><br />
Provincia: <span class="datos"><?=ucfirst(strtolower($row1['provincia']))?></span><br />
País: <span class="datos"><?=$row1['pais']?></span><br />
Evento 1: <span class="datos"><?=$row1['evento0']?></span><br />
Evento 2: <span class="datos"><?=$row1['evento1']?></span><br />
Evento 3: <span class="datos"><?=$row1['evento2']?></span><br />
</div>
<?
	}
		
$an_nombre = $row1['nombre'];
$an_apellido = $row1['apellido'];
$an_dni = ucfirst($row1['dni']);
$an_fechanac = ucfirst($row1['fechanac']);
$an_sexo = ucfirst($row1['sexo']);
$an_email = ucfirst($row1['email']);
$an_password = ucfirst($row1['password']);
$an_telefonoparticular = ucfirst($row1['telefonoparticular']);
$an_telefonolaboral = ucfirst($row1['telefonolaboral']);
$an_telefonocelular = ucfirst($row1['telefonocelular']);
$an_domicilio = strtolower($row1['domicilio']);
$an_provincia = ucfirst($row1['provincia']);
$an_pais = ucfirst($row1['pais']);
}
?></body>
</html><?
mysql_free_result($result1);
mysql_close();
?>
