<?php
$nombremes = Array('', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
include_once "../inc.config.php";
include_once "inc.funciones.php";
function ledad($fechanacdeurs, $fechadecomput) {
  // El formato es yyyymmdd
  $y = substr($fechanacdeurs, 0, 4)*1;
  $m = substr($fechanacdeurs, 4, 2)*1;
  $d = substr($fechanacdeurs, 6, 2)*1;
  $agnox = substr($fechadecomput, 0, 4)*1;
  $mesx  = substr($fechadecomput, 4, 2)*1;
  $diax  = substr($fechadecomput, 6, 2)*1;
  $age   = $agnox-$y;
  if (($m*1) > ($mesx*1)) $age--;
  if ((($m*1) == ($mesx*1)) && (($d*1)>($diax*1))) $age--;
  return $age;
}
function agceros($nombreag, $cantceros) {
  while (strlen($nombreag) < $cantceros) { $nombreag = "0".$nombreag; }
  return $nombreag;
}
//$paginardea = 60;
$paginardea = 9999999;
$limitdesde = ($_GET['pagina'])*$paginardea;
$limitdesde = $limitdesde-$paginardea;
if ($_GET['pagina'] == "") $limitdesde = 0;
//header("Content-type: application/vnd.ms-excel; charset=UTF-8");
header("Content-type: application/vnd.ms-excel; charset=ISO-8859-1");
//header("Content-type: text/html; charset=ISO-8859-1");
header("Content-Disposition: attachment; filename = Inscriptos(listaCompleta)_".str_replace(" ", "_", $row1['nombre']).".xls");
        echo '<table>';
?>
<tr>
<td>DNI</td><td>Apellido</td><td>Nombre</td><td>Sexo</td><td>DNI</td><td>Email</td><td>Fecha de Nac.</td><td>Edad de computo</td><td>Categor&iacute;a</td><?php
  if ($tipo == 'Servicios') {
    echo '<td>Mes</td>';
  }
?><td>Grupo</td><td>Tel Particular</td><td>Tel Laboral</td><td>Celular</td><td>Domicilio</td><td>Localidad</td><td>Provincia</td><td>Pa&iacute;s</td><td>Pagado</td><td>Precio</td><td>Fecha</td>
</tr>
<?
if (isset($_GET['evento']))
$result1 = mysql_query('SELECT * FROM inscribite_eventos WHERE codigo = '.$_GET['evento'].' LIMIT 1 ');
$_GET['eventos'] = trim($_GET['eventos']);
if ($_GET['eventos'] != '') {
	$areventos = Array();
	$areventos = explode(', ', $_GET['eventos']);
	$busqueda = '';
	foreach($areventos as $cadaev){
		$cadaev = str_replace(',', '', $cadaev);
		if ($cadaev != '')
			$busqueda .= 'id = '.$cadaev.' OR ';
	}
	$busqueda = substr($busqueda, 0, strlen($busqueda)-4);
	$result1 = mysql_query("SELECT * FROM inscribite_eventos WHERE $busqueda ");
}
while ($row1 = mysql_fetch_array($result1)) {
$tipo = $row2['tipo'];
$result3 = mysql_query('SELECT id FROM inscribite_inscripciones WHERE deevento = "'.$row1['codigo'].'" ');
$cantproductos = mysql_num_rows($result3);
if ($_GET['busqueda'] == '') {
  $ordenarpor = $_GET['ordenarpor'];
  if ($ordenarpor == '') {
	if ($ordenarinscripcionesx == '') {
		$result2 = mysql_query('SELECT * FROM inscribite_inscripciones WHERE deevento = "'.$row1['codigo'].'" LIMIT '.$limitdesde.', '.$paginardea.' ');
	} else {
		if ($ordenarinscripcionesx == 'fecha') $ordenarinscripcionesx = 'pagoeldia';
		$result1 = mysql_query('SELECT * FROM inscribite_inscripciones WHERE deevento = "'.$row1['codigo'].'" ORDER BY '.$ordenarinscripcionesx.' LIMIT '.$limitdesde.', '.$paginardea.' ');
	}
  } else {
	$result2 = mysql_query('SELECT DISTINCT * FROM inscribite_inscripciones LEFT OUTER JOIN inscribite_usuarios ON inscribite_usuarios.dni = inscribite_inscripciones.deusuario WHERE deevento = "'.$row1['codigo'].'" ORDER BY inscribite_usuarios.'.$ordenarpor.' LIMIT '.$limitdesde.', '.$paginardea.' ');
  }
} else {
  $result2 = mysql_query('SELECT * FROM inscribite_inscripciones WHERE (( deusuario LIKE "%'.$_GET['busqueda'].'%") OR ( deusuario = '.agceros($_GET['busqueda'],8).' )) ');
  //echo 'SELECT * FROM inscribite_inscripciones WHERE (( deusuario LIKE "%'.$_GET['busqueda'].'%") OR ( deusuario = '.agceros($_GET['busqueda'],8).' )) ';
}
while ($row2 = mysql_fetch_array($result2)) {
  $result3 = mysql_query('SELECT * FROM inscribite_usuarios WHERE dni = "'.agceros($row2['deusuario'],8).'" OR dni = "'.($row2['deusuario']*1).'" LIMIT 1 ');
  while ($row3 = mysql_fetch_array($result3)) {
	echo '<tr>';
	$arrnombresdpila = split(' ', $row3['nombre']);
	echo '<td>'.$row3['dni'].'</td>';
	//echo '<td>'.str_replace("-", "",substr($row2['pagoeldia'],0,10)).'</td>';
	echo '<td>'.utf8_decode($row3['apellido']).'</td>';
	echo '<td>'.utf8_decode($arrnombresdpila[0].' '.substr($arrnombresdpila[1], 0, 1));
	if ($arrnombresdpila[1] != '') echo '.';
	echo '</td>';
	//echo '<td>'.$row3['dni'].'</td>';
	echo '<td>'.$row3['sexo'].'</td>';
	echo '<td>'.$row2['deusuario'].'</td>';
	echo '<td>'.$row3['email'].'</td>';
	echo '<td>'.substr($row3['fechanac'],6,2)."/".substr($row3['fechanac'],4,2)."/".substr($row3['fechanac'],0,4).'</td>';
	$result4 = mysql_query('SELECT * FROM inscribite_categorias WHERE (( deevento = "'.$row2['deevento'].'" ) && ( codigo = "'.substr($row2['codigo'], 4, 2).'" )) LIMIT 1 ');
	$row4 = mysql_fetch_array($result4);

	$edadcomputable = ledad($row3['fechanac'], $row4['fechadecomputo']);
	echo '<td>';
	echo $edadcomputable.'</td>';
	$categavr = $row4['opcion'];
	$arrderemplazos = array('Categorias de ', 'Categorías de ', 'Categorías de ', 'categorias de ', 'categorías de ', 'categoria ', 'categoría ', 'Categoria ', 'Categoría ', 'Grupo ', 'grupo ');
	$categavr = str_replace($arrderemplazos,'', $categavr);
	echo '<td>';
	if (is_numeric($row2['categoria'])) {
	  $result5 = mysql_query('SELECT * FROM inscribite_categorias WHERE deevento = "'.$row2['deevento'].'" AND codigo = "'.$row2['categoria'].'" LIMIT 1 ');
	  $row5 = mysql_fetch_array($result5);
	  //echo 'SELECT * FROM inscribite_categorias WHERE deevento = "'.$row2['deevento'].'" AND codigo = "'.$row2['categoria'].'" LIMIT 1 ';
	  echo $row5['nombre'];
	} else {
	  echo $row2['categoria'];
	}
	echo '</td>';

	if ($tipo == 'Servicios') {
	  echo '<td>';
	  if ($row2['mes'] != '') {
		echo $nombremes[substr($row2['mes'],0,2)*1].' de '.substr($row2['mes'],2,2);
	  }
	  echo '</td>';
	}

	echo '<td>'.$categavr.'</td>';
	//echo '<td>$'.($row2['precio']*1).'</td>';
	//echo '<td>';
	//if ($row2['pagoeldia']!= "0000-00-00 00:00:00")echo substr($row2['pagoeldia'],8,2).'/'.substr($row2['pagoeldia'],5,2).'/'.substr($row2['pagoeldia'],2,2).' '.substr($row2['pagoeldia'],11,5).'hs';
	//echo '</td>';
	echo '<td>'.$row3['telefonoparticular'].'</td>';
	echo '<td>'.$row3['telefonolaboral'].'</td>';
	echo '<td>'.$row3['telefonocelular'].'</td>';
	echo '<td>'.$row3['domicilio'].'</td>';
	echo '<td>'.$row3['localidad'].'</td>';
	echo '<td>'.$row3['provincia'].'</td>';
	echo '<td>'.$row3['pais'].'</td>';
	echo '<td>';
	if ($row2['pagado'] == "1") echo 'Si';
	echo '</td>';
	echo($row2['precio']*1!= 0)?'<td>$'.$row2['precio'].'</td>':'<td></td>';
	echo '<td>';
	if ($row2['pagoeldia']!= "0000-00-00 00:00:00") echo substr($row2['pagoeldia'],8,2).'/'.substr($row2['pagoeldia'],5,2).'/'.substr($row2['pagoeldia'],2,2).' '.substr($row2['pagoeldia'],11,5).'hs';
	echo '</td>';
	echo '</tr>';
  }
}
}
echo '</table>';

if (is_resource($result1)) mysql_free_result($result1);
if (is_resource($result2)) mysql_free_result($result2);
if (is_resource($result3)) mysql_free_result($result3);
if (is_resource($result4)) mysql_free_result($result4);
if (is_resource($result5)) mysql_free_result($result5);
mysql_close();
