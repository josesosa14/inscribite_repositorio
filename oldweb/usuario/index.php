<? include '../includes/head.php';

function agceros($nombreag,$cantceros){
	while(strlen($nombreag)<$cantceros){ $nombreag = "0".$nombreag;}
	return $nombreag;
}

	$result=mysql_query('SELECT * FROM inscribite_usuarios WHERE dni="'.$usuario.'" LIMIT 1 ');
	$row=mysql_fetch_array($result);
?>
		<div class="columnacentral" style="overflow:visible;height:auto;width:572px;overflow:hidden">
			<div class="contenidoseccioncentral" style="float:left;width:555px;">
<div style="color:#000000;font-size:14px;margin-bottom:4px;">
<?=$row['nombre'].' '.$row['apellido']?></div>
<span style="float:left;">dni: <?=$usuario?></span>
<span style="float:right;clear:none;margin-right:30px;">puntos acumulados: <?=$row['puntos']?></span>

<br /><br />
<a href="../registrate?usuario=<?=$usuario?>">Cambiar mis datos</a>
<br /><br />
<div style="font-size:14px;text-decoration:underline;margin-bottom:3px;">Inscripciones vigentes:</div>
<?
if($usuario!=''){
$result=mysql_query('SELECT * FROM inscribite_inscripciones WHERE ((deusuario="'.$usuario.'" )OR(deusuario="'.agceros($usuario,8).'")) ORDER BY id DESC');
while($row=mysql_fetch_array($result)){ ?>
	<div style="font-size:13px;margin-top:4px;border-bottom:1px #666666 solid;padding:3px 5px 3px 5px;">
		<div style="font-size:13px;">
<?
$result2=mysql_query('SELECT opcion FROM inscribite_categorias WHERE ((deevento="'.$row['deevento'].'")AND(nombre = "'.$row['categoria'].'")) LIMIT 1');
$row2=mysql_fetch_array($result2);
$result3=mysql_query('SELECT nombre FROM inscribite_eventos WHERE (codigo="'.$row['deevento'].'") LIMIT 1');
$row3=mysql_fetch_array($result3);
?>
		<strong style="text-decoration:underline;">Evento:</strong> <?=$row3['nombre']?></div>
<strong style="text-decoration:underline;font-size:11px;">Categoría de Grupo:</strong> <span style="font-size:11px;">
<?=$row2['opcion']?>
</span><br/>
<strong style="text-decoration:underline;font-size:11px;">Código de Categoría:</strong> <?=$row['categoria']?>
<? if($row['mes']!=''){
$meses=array('','Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
?>
<div>
<strong style="text-decoration:underline;font-size:11px;">Mes:</strong> <?=$meses[(substr($row['mes'],0,2)*1)]?> <?=substr($row['mes'],-2,2)?>
</div>
<? } ?>
<div style="font-size:12px;">
<strong style="text-decoration:underline;font-size:11px;">
Estado:</strong> <?=($row['pagado']==1)?'<span style="color:green;">Confirmado</span>':'<span style="font-size:11px;">Reservado, acerquese a cualquiera de las sucursales de <a href="http://www.pagofacil.com.ar/espanol/php/pagina.php?top=topdonde&contenido=dondepago" style="text-decoration:underline">Pago Facil</a></span>'?>
</div>
<div>
<a href="#" onclick="if(document.getElementById('opciones<?=$row['id']?>').style.display=='block')document.getElementById('opciones<?=$row['id']?>').style.display='none'; else document.getElementById('opciones<?=$row['id']?>').style.display='block'; return false;" style="display:block;font-size:11px;margin-top:4px;margin-bottom:2px;">
 <img src="../webimages/flechita.gif" alt="" style="margin-right:6px;">Opciones:</a>
 <div id="opciones<?=$row['id']?>" style="display:none;border:1px #666 solid;width:250px;line-height:18px;font-size:11px;padding-left:7px;padding-top:4px;padding-bottom:4px;">
  <a href="../imprimircupon?evento=<?=$row['deevento']?>&amp;cat=<?=$row['categoria']?>&amp;cod=<?=substr($row['codigo'],4,2)?>&amp;reimpr=1">

  Reimprimir cupón de pago</a><br/>
  <a href="../iniciainscri?evento=<?=$row['deevento']?>&amp;modinscr=<?=$row['id']?>">

  Modificar mi inscripción</a><br/>
  <a href="javascript:mostrar('borra<?=$row['id']?>')" style="color:#FF0000">

  Cancelar Inscripción</a> <span id="borra<?=$row['id']?>" style="visibility:hidden;">Seguro?
  <a href="../cancelarinscri?id=<?=$row['id']?>&amp;dni=<?=$usuario?>">Si</a> <a href="javascript:mostrar('borra<?=$row['id']?>')">No</a>
  </span>
 </div>
</div>

</div>
<? }} ?>
			</div>
		</div>
<? include '../includes/colder.php'?>