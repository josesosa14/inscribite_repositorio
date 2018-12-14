<?
$conexio=mysql_connect("localhost","inscribite_user","iW7zNKpRWkSHHwplBhUO");
mysql_select_db("inscribite_base",$conexio);
$yaseinscribio=false;
$result1=mysql_query('SELECT dni FROM inscribite_usuarios WHERE dni='.($_POST['dni']*1).' LIMIT 1 ');
while($row=mysql_fetch_array($result1))$yaseinscribio=true; 
if($_POST['id']!="nuevo")$yaseinscribio=false;
if(!($yaseinscribio)){
	setcookie("usuario",$_POST['dni'],time()+7776000,"/");
	$usuario=$_POST['dni'];
    $_POST['usuario']=$_POST['dni'];
    $recienlogeado=true;
}

include 'includes/head.php';
if($yaseinscribio){ ?>
  <div class="columnacentral" style="overflow:visible;">
    <div class="contenidoseccioncentral">
      Ya te encontrás registrado. Si olvidaste tu contraseña pulsa <a href="recordarpassword?recordar=password?username=<?=$_POST['dni']?>" style="text-decoration:underline;">aquí</a> y recibirás un correo electronico para recordartelo.
      Por cualquier consulta comunicate al 4641-4423 o por email con <a href="mailto:comercial@maritimopro.com.ar" style="text-decoration:underline;">comercial@maritimopro.com.ar</a>
    </div>
  </div>
<?php }else{

$idActual=$_POST['id'];
if($idActual=='nuevo'){
  mysql_query ("INSERT INTO `inscribite_usuarios` ( `id` ) VALUES ( '' );");
  $result1=mysql_query('SELECT id FROM inscribite_usuarios ORDER BY id DESC LIMIT 1 ');
  while($row=mysql_fetch_array($result1)){
	$idActual=$row['id'];
  }
}
$_POST['nombre']=ucwords(strtolower($_POST['nombre']));
$_POST['apellido']=ucwords(strtolower($_POST['apellido']));
$_POST['email']=strtolower($_POST['email']);
$_POST['domicilio']=ucwords(strtolower($_POST['domicilio']));
$_POST['localidad']=ucwords(strtolower($_POST['localidad']));
$_POST['provincia']=ucwords(strtolower($_POST['provincia']));
$_POST['pais']=ucwords(strtolower($_POST['pais']));
foreach($_POST as $nombrevariable => $valorvariable){
	if(($nombrevariable!='id')&&($nombrevariable!='tabla'))
	mysql_query("UPDATE inscribite_usuarios SET ".$nombrevariable."=\"".$valorvariable. "\" WHERE id=$idActual");
}

?>
  <div class="columnacentral" style="overflow:visible;">
    <div class="contenidoseccioncentral">
      <p>
       Registro completo.
        <br/><br/>
       <strong>Ahora debes elegir el evento en la solapa correspondiente y la categoría donde quieres anotarte para terminar el trámite de inscripcion.</strong>
         <br/><br/>
        Tu información quedarán en nuestra base de datos para que no tengas que llenarla cada vez que quieras inscribirte en un evento, y para que puedas disfrutar de nuestras promociones. Recordá tu contraseña y que tu nombre de usuario es tu dni. Ante cualquier duda comunicate a <a href="mailto:comercial@maritimopro.com.ar">comercial@maritimopro.com.ar</a>. Muchas Gracias.
      </p>
    </div>
  </div>
<?php 
}
include 'includes/colder.php'?>