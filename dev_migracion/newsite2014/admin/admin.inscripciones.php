<?	
$result1 = mysql_query('SELECT id FROM inscribite_inscripciones WHERE deevento="'.$_GET['evento'].'" LIMIT 1');
	//$result1 = mysql_query('SELECT id FROM inscribite_inscripciones WHERE deevento="'.$_GET['evento'].'" AND iniciadoeldia != "0000-00-00" ');
	$cantproductos = mysql_num_rows($result1);
	$result2 = mysql_query('SELECT * FROM inscribite_eventos WHERE codigo="'.$_GET['evento'].'" LIMIT 1');
	$row2 = mysql_fetch_array($result2); ?>

	
	
     <div>
       <div style="margin-left:10px;margin-top:16px;font-size:12px;width:100%;">
         <div class="titulosec">Inscripciones &gt; Admin : Evento <?=$row2['nombre'].' &gt; '.$cantproductos.' inscripciones &gt;'?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="excelinscripciones?evento=<?=$_GET['evento']?>">Generar Excel</a>&nbsp;-&nbsp;<a href="excelinscompleto?evento=<?=$_GET['evento']?>">Generar Excel con datos completos</a>
         </div>
       </div>
	     <div>
		 
		 
<?	$query = 'SELECT * FROM inscribite_opciones WHERE evento="'.$_GET['evento'].'" OR evento="'.($_GET['evento']*1).'" ';
	$opciones = getArrayQuery($query,$mysqli);

	if ($opciones){
		foreach($opciones as $opcion) {			
			echo 'Opción: <strong>'.$opcion['nombre'].'</strong>';
			if ($opcion['cupo'] != 0) { 
				echo 'Cupo restante: <strong>'.($opcion['cupo']+$opcion['cuporestante']).'</strong> de '.$opcion['cupo'].'';
			}
			echo '<br/>';
		}
	}
	
	?>
			<br/>
<?	if ($_GET['ordenarpor'] == 'inscribite_inscripciones.fecha') $_GET['ordenarpor'] = 'inscribite_inscripciones.pagoeldia';
	$query = 'SELECT ins.id id,codigo,deusuario,precio,deevento,categoria,mes,pagoeldia,venceeldia,usu.nombre nombre,usu.apellido apellido,localidad,provincia,fechanac 
				FROM inscribite_inscripciones ins 
				INNER JOIN inscribite_usuarios usu ON ins.deusuario = usu.dni '.
	'WHERE '.
	(($_GET['busqueda'] == '')?'deevento = "'.$_GET['evento'].'" ':
	'(deusuario = "'.$_GET['busqueda'].'") ').
	'ORDER BY '.
	(($_GET['ordenarpor'] != '')?$_GET['ordenarpor'].', ':'').'pagoeldia DESC';?>
			<table>
				<tr>
					<th style="width:5px;">Nro</th>
					<th style="width:15px;"><a href="?sec=inscripciones.admin&amp;evento=<?=$_GET['evento']?>&amp;ordenarpor=inscribite_usuarios.dni" style="font-weight:bold;text-decoration:underline;">DNI</a></th>
					<th><a href="?sec=inscripciones.admin&amp;evento=<?=$_GET['evento']?>&amp;ordenarpor=inscribite_usuarios.apellido" style="font-weight:bold;text-decoration:underline;">Apellido</a></th>
					<th><a href="?sec=inscripciones.admin&amp;evento=<?=$_GET['evento']?>&amp;ordenarpor=inscribite_usuarios.nombre" style="font-weight:bold;text-decoration:underline;">Nombre</a></th>
					<th>Localidad</th>
					<th>Opción</th>
					<th>Cat.</th>
					<th>Fecha nac.</th>
					<th><a href="?sec=inscripciones.admin&amp;evento=<?=$_GET['evento']?>&amp;ordenarpor=inscribite_inscripciones.fecha" style="font-weight:bold;text-decoration:underline;">Pagado</a></th>
					<th>Vence</th>
					<th>&nbsp;</th>
					</tr>
<?	$contar = 0;
	
	$inscripciones = getArrayQuery($query,$mysqli);
		
	if($inscripciones){
	
	foreach ($inscripciones as $row1){
		//if ($codigoant != $row1['codigo']) {
			$contar++;
			$codigoant = $row1['codigo']?>
					<tr>
						<td style="text-align:right;"><?=$contar?></td>
						<td style="text-align:right;"><a title="codigo: <?=$row1['codigo']?>" href="?sec=inscripciones.editar&amp;editando=<?=$row1['id']?>"<?=(($dniAnterior == $row1['deusuario'])?' style="color:red;font-weight:bold;"':'')?>><?=$row1['deusuario']?></a></td>
						<td style="color:#666;font-size:11px;"><a title="codigo: <?=$row1['codigo']?>" href="?sec=inscripciones.editar&amp;editando=<?=$row1['id']?>"><?=$row1['apellido']?></a></td>
						<td style="color:#666;font-size:11px;"><a title="codigo: <?=$row1['codigo']?>" href="?sec=inscripciones.editar&amp;editando=<?=$row1['id']?>"><?
			$arrnombresdpila = explode(' ', $row1['nombre']);
			echo $arrnombresdpila[0].' '.substr($arrnombresdpila[1],0,1);
			if ($arrnombresdpila[1] != '') echo '.'?></a></td>
						<td style="color:#666;font-size:11px;"><a title="codigo: <?=$row1['codigo']?>" href="?sec=inscripciones.editar&amp;editando=<?=$row1['id']?>"><?=ucwords(str_replace('autonoma', '',str_replace('autónoma', '',strtolower($row1['localidad']))));
			if ($row1['localidad'] != '' ) {
				if ((trim(strtolower($row1['localidad'])) != 'capital federal') && (trim(strtolower($row1['localidad'])) != 'ciudad de buenos aires') && (trim(strtolower($row1['localidad'])) != 'ciudad autonoma de buenos aires') && (trim(strtolower($provincia)) != 'capital federal') && (trim(strtolower($provincia)) != 'ciudad de buenos aires') && (trim(strtolower($provincia)) != 'ciudad autonoma de buenos aires'))
					echo ' ('.ucwords(str_replace('autónoma', '',str_replace('autonoma', '',str_replace('santiago', 'stgo.',str_replace('buenos aires', 'bs. as.',str_replace('-', '',(strtolower($row1['provincia'])))))))).')';
			}	
				?></a></td>
						<td><a title="codigo: <?=$row1['codigo']?>" href="?sec=inscripciones.editar&amp;editando=<?=$row1['id']?>"><?
			/*$result3 = mysql_query('SELECT * FROM inscribite_categorias WHERE ((deevento = "'.$row1['deevento'].'") && (codigo = "'.substr($row1['codigo'], 4, 2).'")) LIMIT 1');
			$row3 = mysql_fetch_array($result3);
			echo $row3['opcion']*/?></a></td>
						<td><a title="codigo: <?=$row1['codigo']?>" href="?sec=inscripciones.editar&amp;editando=<?=$row1['id']?>"><?=$row1['categoria']?></a></td>
						<td style="text-align:right;"><a title="codigo: <?=$row1['codigo']?>" href="?sec=inscripciones.editar&amp;editando=<?=$row1['id']?>"><?=(($row1['fechanac'] == '')?'':substr($row1['fechanac'], 6, 2).'/'.substr($row1['fechanac'], 4, 2).'/'.substr($row1['fechanac'], 0, 4))?></a></td>
						<td style="font-size:10px;line-height:20px;color:#555"><strong><?php if ($row1['precio']*1 != 0) echo '$'.$row1['precio']?></strong> <?php if ($row1['pagoeldia'] != "0000-00-00 00:00:00") echo substr($row1['pagoeldia'], 8, 2).'/'.substr($row1['pagoeldia'], 5, 2).'/'.substr($row1['pagoeldia'], 2, 2).' '.substr($row1['pagoeldia'],11,5).'hs'?></td>
						<td style="font-size:10px;line-height:20px;color:#555"><?=(($row1['venceeldia'] != 0)?substr($row1['venceeldia'], 6, 2).'/'.substr($row1['venceeldia'], 4, 2).'/'.substr($row1['venceeldia'], 2, 2):'')?></td>
						<td><a href="javascript:confirm_entry('inscripcion de usuario: dni <?=$row1['deusuario']?>', 'inscripciones.admin<?php if ($_GET['evento'] != '') echo 'amp;evento='.$_GET['evento']; if ($_GET['busqueda'] != '') echo 'amp;busqueda='.$_GET['busqueda']; if ($_GET['ordenarpor'] != "") echo 'amp;ordenarpor='.$_GET['ordenarpor']?>', 'inscribite_inscripciones', <?=$row1['id']?>)"> <img src="images/deletex.gif" alt="Eliminar"/></a></td>
					</tr>
<?			if ($_GET['ordenarpor'] == 'inscribite_usuarios.dni') {
				$dniAnterior = $row1['deusuario'];
			}
		//}
	}
}	?>
				</table>
			</div>
		</div>
	</div>
