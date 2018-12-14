<?	include_once 'inc.config.php';

	//header("Content-type: application/vnd.ms-excel; charset=ISO-8859-1");
	//header("charset=ISO-8859-1");
	if (isset($_GET['eventos'])) {
		$areventos = Array();
		$areventos = split(',', $_GET['eventos']);
		$busqueda = '';
		foreach($areventos as $cadaev) {
			if ($cadaev != '')
			$busqueda .= 'deevento = '.$cadaev.' OR ';
		}
		$busqueda = substr($busqueda, 0, strlen($busqueda)-4);
		$result2 = mysql_query('SELECT * FROM '.pftables.'inscripciones WHERE '.$busqueda.' ORDER BY codigo ');

		header("Content-Disposition: attachment; filename=Inscripciones-".str_replace(' ','_',$row3['empresa'])."-Varios_Eventos-".date('j-n-Y').".xls; charset=ISO-8859-1");
	} else {
		$result2 = mysql_query('SELECT * FROM '.pftables.'inscripciones WHERE deevento="'.$_GET['evento'].'" ORDER BY codigo ');
		//echo $q;
		$result3 = mysql_query('SELECT * FROM '.pftables.'eventos WHERE codigo = "'.$_GET['evento'].'" LIMIT 1 ');
		$row3 = mysql_fetch_array($result3);

		header("Content-Disposition: attachment; filename=Inscripciones-".str_replace(',', '', str_replace(' ', '_', $row3['empresa']."-".$row3['nombre']))."-".date('j-n-Y').".xls; charset=ISO-8859-1");
	}
	$meses = Array('', 'ene', 'feb', 'mar', 'abr', 'may', 'jun', 'jul', 'ago', 'sep', 'oct', 'nov', 'dic');
	if (mysql_num_rows($result2) > 0) {
		$hayuninscripto = true?>
<table>
<tr>
	<td>DNI Usuario</td>
	<td>Nombre</td>
	<td>Apellido</td>
	<td>DNI</td>
	<td>Fecha de nacimiento</td>
	<td>Edad</td>
	<td>Sexo</td>
	<td>Email</td>
	<td>Tel&eacute;fono part.</td>
	<td>Tel&eacute;fono laboral</td>
	<td>Tel&eacute;fono celular</td>
	<td>Domicilio</td>
	<td>Localidad</td>
	<td>Provincia</td>
	<td>País</td>
	<td>Evento</td>
	<td>Categor&iacute;a</td>
	<td>Inscripci&oacute;n</td>
	<td>Pagado</td>
	<td>el d&iacute;a</td>
<?		if ($row1['pregunta1'] != '') echo'<td>'.$row1['pregunta1'].'</td>'."\n";
		if ($row1['pregunta2'] != '') echo'<td>'.$row1['pregunta2'].'</td>'."\n";
		if ($row1['pregunta3'] != '') echo'<td>'.$row1['pregunta3'].'</td>'."\n"?>
</tr>
<?		while ($row2 = mysql_fetch_array($result2)) {
			$query = "SELECT *,TIMESTAMPDIFF(YEAR,CONCAT(SUBSTRING((CONVERT(fechanac,CHAR(4))),1,4),'-',
						SUBSTRING((CONVERT(fechanac,CHAR(6))),5,5),'-',
						SUBSTRING((CONVERT(fechanac,CHAR(8))),7,7)),CURDATE()) as edad FROM inscribite_usuarios WHERE dni= '".($row2['deusuario']*1)."' LIMIT 1";
			$result3 = mysql_query($query);
			$row3 = mysql_fetch_array($result3)
		?>
	<tr>
		<td><?=($row2['deusuario']*1)?></td>
		<td><?=htmlentities(utf8_decode($row3['nombre']))?></td>
		<td><?=htmlentities(utf8_decode($row3['apellido']))?></td>
		<td><?=$row3['dni']?></td>
		<td><?=substr($row3['fechanac'], 6, 2).'/'.substr($row3['fechanac'], 4, 2).'/'.substr($row3['fechanac'], 0, 4)?></td>
		<td><?=$row3['edad']?></td>
		<td><?=$row3['sexo']?></td>
		<td><?=$row3['email']?></td>
		<td><?=$row3['telefonoparticular']?></td>
		<td><?=$row3['telefonolaboral']?></td>
		<td><?=$row3['telefonocelular']?></td>
		<td><?=htmlentities(utf8_decode($row3['domicilio']))?></td>
		<td><?=htmlentities(utf8_decode($row3['localidad']))?></td>
		<td><?=htmlentities(utf8_decode($row3['provincia']))?></td>
		<td><?=htmlentities(utf8_decode($row3['pais']))?></td>
		<td><?=htmlentities(utf8_decode($row2['deevento']))?></td>
		<td><?=$row2['categoria']?></td>
		<td><?=$row2['iniciadoeldia']?></td>
		<td><?=$row2['pagado']?></td>
		<td><? if ($row2['pagado'] == 1) echo $row2['pagoeldia']?></td>
<?			if ($row2['respuestapart1'] != '') echo '		<td>'.$row2['respuestapart1'].'</td>'."\n";
			if ($row2['respuestapart2'] != '') echo '		<td>'.$row2['respuestapart2'].'</td>'."\n";
			if ($row2['respuestapart3'] != '') echo '		<td>'.$row2['respuestapart3'].'</td>'."\n"?>
	</tr>
<?		} ?>
</table>
<?	}
	if (!($hayuninscripto)) echo 'Aún no hay inscriptos<br/>';
	if (is_resource($result2)) mysql_free_result($result2);
	if (is_resource($result3)) mysql_free_result($result3);
	mysql_close()?>