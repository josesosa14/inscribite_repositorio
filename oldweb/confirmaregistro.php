<? include 'includes/header.php';
$evento=str_replace("_"," ",$_GET['evento']);
$cat=$_GET['cat'];
$cod=$_GET['cod'];
$result1=mysql_query('SELECT * FROM inscribite_categorias WHERE ((nombre="'.$cat.'")AND(deevento="'.$evento.'")AND(codigo="'.$cod.'")) LIMIT 1 ');
$row=mysql_fetch_array($result1);
function agceros($nombreag,$cantceros){
	while(strlen($nombreag)<$cantceros)$nombreag="0".$nombreag;
	return $nombreag;
}
?>
	<div class="columnacentral" style="height:auto;font-size:14px; width:100%;">
    <form action="finregistro" method="post">
	<input type="hidden" name="id" value="<?=$_POST['id']?>"/>
    <input type="hidden" name="nombre" value="<?=$_POST['nombre']?>"/>
    <input type="hidden" name="apellido" value="<?=$_POST['apellido']?>"/>
    <input type="hidden" name="dni" value="<?=$_POST['dni']?>"/>
    <input type="hidden" name="fechanac" value="<?=agceros($_POST['agnonacimiento'],4).agceros($_POST['mesnacimiento'],2).agceros($_POST['dianacimiento'],2)?>"/>
    <input type="hidden" name="sexo" value="<?=$_POST['sexo']?>"/>
    <input type="hidden" name="email" value="<?=$_POST['email']?>"/>
    <input type="hidden" name="password" value="<?=$_POST['password']?>"/>
    <input type="hidden" name="telefonoparticular" value="<?=$_POST['telefonoparticular']?>"/>
    <input type="hidden" name="telefonolaboral" value="<?=$_POST['telefonolaboral']?>"/>
    <input type="hidden" name="telefonocelular" value="<?=$_POST['telefonocelular']?>"/>
    <input type="hidden" name="domicilio" value="<?=$_POST['domicilio']?>"/>
    <input type="hidden" name="localidad" value="<?=$_POST['localidad']?>"/>
    <input type="hidden" name="provincia" value="<?=$_POST['provincia']?>"/>
    <input type="hidden" name="pais" value="<?=$_POST['pais']?>"/>

	<div style="width:400px;height:325px;margin-left:auto;margin-right:auto;margin-top:30px;margin-bottom:30px;border:1px red solid;padding:10px;">
    Nombre: <strong><?=ucwords(strtolower($_POST['nombre']))?></strong><br/>
    Apellido: <strong><?=ucwords(strtolower($_POST['apellido']))?></strong><br/>
    DNI: <strong><?=$_POST['dni']?></strong><br/>
    Nacido el: <strong><?=$_POST['dianacimiento']?>/<?=$_POST['mesnacimiento']?>/<?=$_POST['agnonacimiento']?></strong><br/>
    Sexo: <strong><?=ucwords(strtolower($_POST['sexo']))?></strong><br/>
    Email: <strong><?=strtolower($_POST['email'])?></strong><br/>
    Password: <strong><?=ucwords(strtolower($_POST['password']))?></strong><br/>
    Teléfono Particular: <strong><?=ucwords(strtolower($_POST['telefonoparticular']))?></strong><br/>
    Teléfono Laboral: <strong><?=ucwords(strtolower($_POST['telefonolaboral']))?></strong><br/>
    Teléfono Celular: <strong><?=ucwords(strtolower($_POST['telefonocelular']))?></strong><br/>
    Domicilio: <strong><?=ucwords(strtolower($_POST['domicilio']))?></strong><br/>
    Localidad: <strong><?=ucwords(strtolower($_POST['localidad']))?></strong><br/>
    Provincia: <strong><?=ucwords(strtolower($_POST['provincia']))?></strong><br/>
    País: <strong><?=ucwords(strtolower($_POST['pais']))?></strong><br/>
    <div style="font-size:12px;margin-top:15px;">
    Por favor asegurese de que sus datos sean correctos.

    <div style="margin-left:90px;">
<input type="submit" value="Confirmar" style="display:inline;width:200px;float:left;font-size:14px;margin-top:25px;"/>
<a href="javascript:history.back()" style="float:left;clear:none;margin-top:27px;margin-left:15px;font-size:12px;">Cancelar</a>
    </div>

    </div>
	</div>
    </form>
	</div>
<? include 'includes/_solofooter.php'?>