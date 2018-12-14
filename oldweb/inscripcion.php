<? include 'includes/head.php';

function ledad($fechanacdeurs,$fechadecomput){
    // El formato es yyyymmdd
    $y=substr($fechanacdeurs,0,4)*1;
    $m=substr($fechanacdeurs,4,2)*1;
    $d=substr($fechanacdeurs,6,2)*1;

    $agnox=substr($fechadecomput,0,4)*1;
    $mesx=substr($fechadecomput,4,2)*1;
    $diax=substr($fechadecomput,6,2)*1;
    $age=$agnox-$y;
	if(($m+0)>($mesx+0))$age--;
	if((($m+0)==($mesx+0))&&(($d+0)>($diax+0)))$age--;
	return $age;
}

/*
if($_POST['agnonacimiento']=="")
	die('<span style=""margin-left:5px;margin-top:7px;>Vuelva a ingresar sus datos. <a href="./">Volver</a></span>');
*/
$result1=mysql_query('SELECT * FROM inscribite_usuarios WHERE dni="'.$_POST['dni'].'" LIMIT 1 ');
while($row=mysql_fetch_array($result1)){
	$yaseinscribio=true;
}
if(!($yaseinscribio)){
	setcookie("usuario", $_POST['dni'],time()+7776000,"/");
	$usuario=$_POST['dni'];
	//session_register('usuario');
	//$_SESSION['usuario']=$_POST['dni'];
}
if(substr($_SERVER['PHP_SELF'],9,15)=="inscripcion.php"){
	//$yaseinscribio=false;
	$recargolapag=true;
}
if($yaseinscribio){ ?>
		<div class="columnacentral" style="overflow:visible;">
			<div class="contenidoseccioncentral">
				Ya se encuentra registrado un usuario con ese DNI. Si olvidaste tu contraseña pulsa <a href="recordarpassword?recordar=password?username=<?=$_POST['dni']?>" style="text-decoration:underline;">aquí</a> y recibirás un correo electrónico para recordartelo.
				 Por cualquier consulta comunicate al 4641-4423 o por email con <a href="mailto:comercial@maritimopro.com.ar" style="text-decoration:underline;">comercial@maritimopro.com.ar</a>
			</div>
		</div>
<? }else{
mysql_query("INSERT INTO `inscribite_usuarios` ( `id` ) VALUES ( '' );");
$result1=mysql_query('SELECT id FROM inscribite_usuarios ORDER BY id DESC LIMIT 1 ');
while($row=mysql_fetch_array($result1))$idActual=$row['id'];
$result1=mysql_query('SELECT * FROM inscribite_usuarios WHERE dni="'.$usuario.'" LIMIT 1 ');
while($row=mysql_fetch_array($result1))$idActual=$row['id']; 
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

    $_POST['usuario']=$usuario;
    $recienlogeado=true;
?>
		<div class="columnacentral" style="overflow:visible;">
			<div class="contenidoseccioncentral">
			Evento: <?=$_GET['evento']?><br/>
			<br/>
			Elija Categoría:<br/>
<span style="font-size:11px;color:#777777">
Por tu edad y sexo solo podras elegir entre las categorías que están destacadas en verde. Verificá que sea realmente en la que deseas participar.
</span>
<?
$result1=mysql_query('SELECT * FROM inscribite_eventos WHERE codigo="'.$_GET['evento'].'" LIMIT 1 ');
while($row=mysql_fetch_array($result1)){
    for($iopciones=1;$iopciones<=4;$iopciones++){
	$result2=mysql_query('SELECT * FROM inscribite_categorias WHERE((deevento="'.$_GET['evento'].'")AND(opcion="'.$row['opcion'.$iopciones].'")) ORDER BY codigo ');
	$result3=mysql_query('SELECT * FROM inscribite_usuarios WHERE dni="'.$usuario.'" LIMIT 1 ');
	$row3=mysql_fetch_array($result3);
	$sexodelusuario=$row3['sexo'];
    $fechanac=$row['fechanac'];

	if(($row['opcion'.$iopciones]!="")&&(mysql_num_rows($result2)>0)){ ?>
		 <div style="font-size:14px;border:1px #336699 solid;text-align:center;font-weight:bold;color:#336699;height:22px;line-height:22px;margin-top:5px;margin-bottom:2px;">
		 <?=$row['opcion'.$iopciones]?></div>
<?
	while($row2=mysql_fetch_array($result2)){ ?>
		<div style="font-size:13px;color:#666666;">
<?
	$edadcomputable=ledad($fechanac,$row2['fechadecomputo']);
    $fechdcomp=substr($fechadecomput,0,4)."/".substr($fechadecomput,4,2)."/".substr($fechadecomput,6,2);
	 
		if((($row2['sexo']=='Ambos')||(strtolower($row2['sexo'])==strtolower($sexodelusuario)))&&((($edadcomputable>=$row2['edadminima'])&&($edadcomputable<=$row2['edadmaxima']))||($row2['limitedeedad']==0))&&(!$mascaro)){
			if(gregoriantojd(date("m"),date("d"),date("Y"))==gregoriantojd(substr($row['vencimiento3'],5,2),substr($row['vencimiento3'],8,2),substr($row['vencimiento3'],0,4))-1 ){ ?>
			<span style="color:#FF0000;">Hoy es el último día para el pago de tu inscripción</span>
			<? } ?>
		<a href="confirmarinscripcion?evento=<?=$_GET['evento']?>&amp;cat=<?=$row2['nombre']?>&amp;cod=<?=$row2['codigo']?><?=($modinscr!="")?'&amp;modinscr='.$modinscr:''?>" style="font-weight:bold;margin-bottom:6px;display:block;color:green;">
		> <?=$row2['nombre']." ".$row2['descripcion']?> &lt; Inscribirse<br/>
		 <span style="font-size:9px;font-weight:normal;">Sexo: <?=$row2['sexo']?> Edad: de <?=$row2['edadminima']?> a <?=$row2['edadmaxima']?> (calculada al <?=$fechdcomp?>)</span></a>
		<? } ?>
		</div>
<? } } 
	}
	}
?>
			</div>
		</div>
<? 
}
include 'includes/colder.php'?>