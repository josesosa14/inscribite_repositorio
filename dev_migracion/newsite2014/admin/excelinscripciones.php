<?php
$nombremes = Array('', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
header("Content-type: application/vnd.ms-excel; charset=ISO-8859-1");
header("Content-Disposition: attachment; filename=inscripciones.xls");
/*
function ledad($dob, $diax, $mesx, $agnox) {
	// El formato es dd/mm/yy
	list($d, $m, $y) = explode("/", $dob);
	$age = $agnox - $y;
	if (($m+0)>($mesx+0)) $age--;
	if ((($m+0) == ($mesx+0)) && (($d+0)>($diax+0))) $age--;
	return $age;
}*/
function ledad($fechanacdeurs, $fechadecomput) {
    // El formato es yyyymmdd
    $y = substr($fechanacdeurs, 0, 4)*1;
    $m = substr($fechanacdeurs, 4, 2)*1;
    $d = substr($fechanacdeurs, 6, 2)*1;
    $agnox = substr($fechadecomput, 0, 4)*1;
    $mesx  = substr($fechadecomput, 4, 2)*1;
    $diax  = substr($fechadecomput, 6, 2)*1;
    $age = $agnox-$y;
	if (($m+0) > ($mesx+0)) $age--;
	if ((($m+0) == ($mesx+0)) && (($d+0)>($diax+0))) $age--;
	return $age;
}
include_once "../inc.config.php";

if (1 == 1) {
  $result1 = mysql_query('SELECT tipo FROM inscribite_eventos WHERE codigo = '.$_GET['evento']);
  $row1 = mysql_fetch_array($result1);
  $tipo = $row1['tipo'];

  function agceros($nombreag, $cantceros) {
    while (strlen($nombreag) < $cantceros) { $nombreag = "0".$nombreag; }
    return $nombreag;
  }
  //$paginardea = 60;
  $paginardea = 9999999;
  $limitdesde = ($_GET['pagina'])*$paginardea;
  $limitdesde = $limitdesde-$paginardea;
  if ($_GET['pagina'] == "") $limitdesde = 0;
  $result1 = mysql_query('SELECT id FROM inscribite_inscripciones WHERE deevento = "'.$_GET['evento'].'" ');
  $cantproductos = mysql_num_rows($result1);
  if ($_GET['busqueda'] == '') {
    $ordenarpor = $_GET['ordenarpor'];
    if ($ordenarpor == '') {
      if ($ordenarinscripcionesx == '') {
  	    $result1 = mysql_query('SELECT * FROM inscribite_inscripciones WHERE deevento = "'.$_GET['evento'].'" LIMIT '.$limitdesde.', '.$paginardea.' ');
      } else {
  	    if ($ordenarinscripcionesx == 'fecha') $ordenarinscripcionesx = 'pagoeldia';
  	    $result1 = mysql_query('SELECT * FROM inscribite_inscripciones WHERE deevento = "'.$_GET['evento'].'" ORDER BY '.$ordenarinscripcionesx.' LIMIT '.$limitdesde.', '.$paginardea.' ');
  	  }
    } else {
   	  $result1 = mysql_query('SELECT DISTINCT * FROM inscribite_inscripciones LEFT OUTER JOIN inscribite_usuarios ON inscribite_usuarios.dni = inscribite_inscripciones.deusuario WHERE deevento = "'.$_GET['evento'].'" ORDER BY inscribite_usuarios.'.$ordenarpor.' LIMIT '.$limitdesde.', '.$paginardea.' ');
    }
?>
<table>
<tr>
<td>Apellido</td><td>Nombre</td><td>Fecha de Nac.</td><td>Edad de computo</td><td>Categor&iacute;a</td><?php
  if ($tipo == 'Servicios') {
    echo '<td>Mes</td>';
  }
?><td>Grupo</td><td>Localidad</td>
</tr>
<?php
    } else {
      $result1 = mysql_query('SELECT * FROM inscribite_inscripciones WHERE (( deusuario LIKE "%'.$_GET['busqueda'].'%") OR ( deusuario = '.agceros($_GET['busqueda'],8).' )) ');
    }
    while ($row1 = mysql_fetch_array($result1)) {
      $result2 = mysql_query('SELECT * FROM inscribite_usuarios WHERE dni = "'.agceros($row1['deusuario'],8).'" OR dni = "'.($row1['deusuario']*1).'" LIMIT 1 ');
      while ($row2 = mysql_fetch_array($result2)) {
        echo '<tr>';
        $arrnombresdpila = split(' ', $row2['nombre']);
        echo '<td>'.utf8_decode($row2['apellido']).'</td>';
        echo '<td>'.utf8_decode($arrnombresdpila[0].' '.substr($arrnombresdpila[1], 0, 1));
        if ($arrnombresdpila[1] != '') echo '.';
        echo '</td>';
        echo '<td>'.substr($row2['fechanac'],6,2)."/".substr($row2['fechanac'],4,2)."/".substr($row2['fechanac'],0,4).'</td>';
        $result3 = mysql_query('SELECT * FROM inscribite_categorias WHERE deevento = "'.$row1['deevento'].'" AND codigo = "'.substr($row1['codigo'],4,2).'" LIMIT 1 ');
        $row3    = mysql_fetch_array($result3);
        $edadcomputable = ledad($row2['fechanac'], $row3['fechadecomputo']);
        echo '<td>'.$edadcomputable.'</td>';
        $categavr       = $row3['opcion'];
        $arrderemplazos = array('Categorias de ', 'Categorías de ', 'Categorías de ', 'categorias de ', 'categorías de ', 'categoria ', 'categoría ', 'Categoria ', 'Categoría ', 'Grupo ', 'grupo ');
        $categavr       = str_replace($arrderemplazos,'', $categavr);
        echo '    <td>';
        if (is_numeric($row1['categoria'])) {
          $result4 = mysql_query('SELECT * FROM inscribite_categorias WHERE deevento = "'.$row1['deevento'].'" AND codigo = "'.$row1['categoria'].'" LIMIT 1 ');
          $row4 = mysql_fetch_array($result4);
          //echo 'SELECT * FROM inscribite_categorias WHERE deevento = "'.$row1['deevento'].'" AND codigo = "'.$row1['categoria'].'" LIMIT 1 ';
          echo $row4['nombre'];
        } else {
          echo $row1['categoria'];
        }
        echo '</td>';

      if ($tipo == 'Servicios') {
        echo '    <td>';
        if ($row1['mes'] != '') {
          echo $nombremes[substr($row1['mes'],0,2)*1].' de '.substr($row1['mes'],2,2);
        }
        echo '</td>';
      }
        echo '    <td>'.$categavr.'</td>';
        //echo '<td>$'.($row1['precio']*1).'</td>';
        //echo'<td>';
        //if ($row1['pagoeldia'] != "0000-00-00 00:00:00")echo substr($row1['pagoeldia'],8,2).'/'.substr($row1['pagoeldia'],5,2).'/'.substr($row1['pagoeldia'],2,2).' '.substr($row1['pagoeldia'],11,5).'hs';
        //echo '</td>';
        echo '    <td>'.$row2['localidad'].'</td>';
        echo '  </tr>';
      }
    } ?>
</table>
<?php  if (is_resource($result1)) mysql_free_result($result1);
    if (is_resource($result2)) mysql_free_result($result2);
    if (is_resource($result3)) mysql_free_result($result3);
    if (is_resource($result4)) mysql_free_result($result4);
    mysql_close();
  } else {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es" >
  <head>
    <title>Inscribite Online - Administración</title>
    <meta name="ROBOTS" content="NOARCHIVE"/>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style type="text/css">
    <!--
    body{
      font-family:Arial, Helvetica, sans-serif;
      font-size:12px;
    }
    .submit{
      border:1px #555 solid;
      width:100px;
      background-color:white;
      font-size:12px;
      margin-left:auto;
      margin-right:auto;
      display:block;
      margin-top:20px;
    }
    -->
    </style>
  </head>
  <body>
    <div style="width:200px;margin-left:auto;margin-right:auto;margin-top:100px;">
      <form action="./" method="post">
        <div>
          Nombre de usuario<br/>
          <input type="text" name="admin_username" style="width:150px;"/><br/>
          Contraseña<br/>
          <input type="password" name="admin_password" style="width:150px;"/><br/>
          <input type="submit" value="Entrar" class="submit"/>
        </div>
      </form>
    </div>
  </body>
</html>
<?php
}
?>