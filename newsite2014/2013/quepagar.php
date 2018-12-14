<?	$pagetitle = 'Acerca de Inscribite Online - ';
	include_once 'inc.header.php'?>
		<div class="cuadro_guia">
			<div>
				Seleccioná el rubro del evento que querés pagar y luego buscalo en la lista. Si deseás conocer más del evento hacé clik en <strong>+INFO</strong>, o bien en <strong>AVANZAR</strong> para gestionar la reserva e imprimir el cupón de pago.
			</div>
		</div>
		<div class="cuadro_guia" style="background:#EEE;border-color:#DDD;">
			<form action="<?=url?>quepagar" method="GET">
				<div style="font-size:12px;">
					<strong style="font-size:14px;margin-right:15px;">Buscar:</strong>
					<label style="margin-right:15px;">
						Por organizador:
						<select name="organizador">
						</select>
					</label>
					<label style="margin-right:15px;">
						Por mes:
						<select name="mes">
							<option value="enero">enero</option>
							<option value="febrero">febrero</option>
							<option value="marzo">marzo</option>
							<option value="abril">abril</option>
							<option value="mayo">mayo</option>
							<option value="junio">junio</option>
							<option value="julio">julio</option>
							<option value="agosto">agosto</option>
							<option value="septiembre">septiembre</option>
							<option value="octubre">octubre</option>
							<option value="noviembre">noviembre</option>
							<option value="diciembre">diciembre</option>
						</select>
					</label>
					<label>
						Por nombre del evento:
						<input type="text" name="q"/>
					</label>

					<input type="submit" value="Buscar" style="float:right;clear:none;"/>
				</div>
			</form>
		</div>
		<div class="solapas" id="rubros">
			<a href="#" class="activa"><span>Eventos<br/>Deportivos</span></a>
			<a href="#"><span>Eventos de Capacitación</span></a>
			<a href="#"><span>Servicios y Mensualidades</span></a>
			<a href="#"><span>Compra de<br/>Productos</span></a>
		</div>
<?	if ($_GET['tipo'] == '') $_GET['tipo'] = 'Deportivos';
	$cuentaev = 0;
	$result1 = mysql_query('SELECT * FROM '.pftables.'eventos WHERE ver = 1 AND tipo = "'.$_GET['tipo'].'" ORDER BY fechaord, nombre');
	while ($row1 = mysql_fetch_array($result1)) { $cuentaev++?>
		<div class="eventos_items">
			<div class="eventos_items_fecha">
				<span class="diaymes"><?=substr($row1["fecha"], 0, 5)?></span><br/>
				<span class="ano"><?=substr($row1["fecha"], 6, 10)?></span>
			</div>
			<div class="eventos_items_description">
				<h2><a href="evento?evento=<?=$row1['codigo']?>"><?=$row1['nombre']?></a></h2>
				COD <?=$row1['codigo']?> Organizador: <a href="evento?evento=<?=$row1['codigo']?>"><?=$row1['empresa']?></a>
			</div>
			<div class="eventos_items_botones">
				<a href="evento?evento=<?=$row1['codigo']?>" class="bluebtn">+ INFO</a>
				<a href="iniciainscripccion?evento=<?=$row1['codigo']?>" class="greenbtn">AVANZAR</a>
			</div>
		</div>
<?	}
	include_once 'inc.footer.php'?>