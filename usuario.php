<? include_once 'includes/header.php';

function agceros($nombreag, $cantceros) {
	while(strlen($nombreag) < $cantceros){ $nombreag = "0".$nombreag; }
	return $nombreag;
}

$result = mysql_query('SELECT * FROM '.pftables.'usuarios WHERE dni = "'.$usuario.'" LIMIT 1 ');
$row1 = mysql_fetch_array($result); ?>
<div class="left">
	<h1><?=$row1['nombre'].' '.$row1['apellido']?></h1>
	<h2>dni: <?=$usuario?></h2>
	<h2>Inscripciones vigentes:</h2>
<? if ($usuario != '') {
	$result = mysql_query('SELECT * FROM '.pftables.'inscripciones WHERE ((deusuario = "'.$usuario.'" ) OR (deusuario = "'.agceros($usuario,8).'")) ORDER BY id DESC');
	while($row1 = mysql_fetch_array($result)){ ?>
	<div style="font-size:13px;margin-top:4px;border-bottom:1px #666666 solid;padding:3px 5px 3px 5px;">    
		<div style="font-size:13px;">
<? $result2 = mysql_query('SELECT opcion FROM '.pftables.'categorias WHERE ((deevento = "'.$row1['deevento'].'") AND (nombre = "'.$row1['categoria'].'")) LIMIT 1');
$row2 = mysql_fetch_array($result2);
$result3 = mysql_query('SELECT nombre FROM '.pftables.'eventos WHERE (codigo = "'.$row1['deevento'].'") LIMIT 1');
$row3 = mysql_fetch_array($result3); ?>
		<h2><strong style="text-decoration:underline;">Evento:</strong> <?=$row3['nombre']?></h2></div>
<? if ($row1['iniciadoeldia'] != '') { ?>
        <p>Iniciado el día: <?=substr($row1['iniciadoeldia'], 8, 2).' / '.substr($row1['iniciadoeldia'], 5, 2).' / '.substr($row1['iniciadoeldia'], 0, 4)?></p>
<? } ?>
<strong style="text-decoration:underline;font-size:11px;">Categoría de Grupo:</strong> <span style="font-size:11px;">
<?=$row2['opcion']?>
</span><br/>
<strong style="text-decoration:underline;font-size:11px;">Código de Categoría:</strong> <?=$row1['categoria']?>
<? if ($row1['mes'] != ''){
$meses = array('', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'); ?>
			<div>
				<strong style="text-decoration:underline;font-size:11px;">Mes:</strong> <?=$meses[(substr($row1['mes'],0,2)*1)]?> <?=substr($row1['mes'],-2,2)?>
			</div>
<? } ?>
			<div style="font-size:12px;">
				<strong style="text-decoration:underline;font-size:11px;">Estado:</strong> <?=($row1['pagado']==1)?'<span style="color:green;">Confirmado</span>':'<span style="font-size:11px;">Reservado, acerquese a cualquiera de las sucursales de <a href="http://www.pagofacil.com.ar/espanol/php/pagina.php?top=topdonde&contenido=dondepago" style="text-decoration:underline">Pago Facil</a></span>'.chr(13)?>
			</div>
			<div>
				<h2>
					<a href="#" onclick="if(document.getElementById('opciones<?=$row1['id']?>').style.display=='block')document.getElementById('opciones<?=$row1['id']?>').style.display='none'; else document.getElementById('opciones<?=$row1['id']?>').style.display='block'; return false;" style="display:block;font-size:11px;margin-top:4px;margin-bottom:2px;">
					<img src="images/bullet.gif" alt="" width="21" height="21" border="0" align="absmiddle" />Opciones:</a>
				</h2>
				<div id="opciones<?=$row1['id']?>" style="display:none;border:1px #666 solid;width:250px;line-height:18px;font-size:11px;padding-left:7px;padding-top:4px;padding-bottom:4px;">
					<a href="imprimircupon?evento=<?=$row1['deevento']?>&amp;cat=<?=$row1['categoria']?>&amp;cod=<?=substr($row1['codigo'],4,2)?>&amp;reimpr=1">Reimprimir cupón de pago</a><br/>
					<a href="iniciainscri?evento=<?=$row1['deevento']?>&amp;modinscr=<?=$row1['id']?>">Modificar mi inscripción</a><br/>
					<a href="javascript:mostrar('borra<?=$row1['id']?>')" style="color:#FF0000">Cancelar Inscripción</a>
					<span id="borra<?=$row1['id']?>" style="visibility:hidden;">Seguro?
						<a href="cancelarinscri?id=<?=$row1['id']?>&amp;dni=<?=$usuario?>">Si</a> <a href="javascript:mostrar('borra<?=$row1['id']?>')">No</a>
					</span>
				</div>
			</div>
		</div>
<? }
} ?>
	</div>
	<div id="right">
<? include_once 'includes/faqsfull.php'?>
	</div>    
<? include_once 'includes/footer.php'?>