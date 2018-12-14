<?php
mysql_select_db("inscribite_base", mysql_connect("localhost", "inscribite_user", "iW7zNKpRWkSHHwplBhUO"));

//header("Content-type: application/vnd.ms-excel; charset=ISO-8859-1");
//header("charset=ISO-8859-1");
if (isset($_GET['eventos'])) {
  $areventos = Array();
  $areventos = split(',', $_GET['eventos']);
  $busqueda = '';
  foreach($areventos as $cadaev){
    if ($cadaev != '')
      $busqueda .= 'deevento = '.$cadaev.' OR ';
  }
  $busqueda = substr($busqueda, 0, strlen($busqueda)-4);
  $result2 = mysql_query("SELECT * FROM inscribite_inscripciones WHERE $busqueda ORDER BY codigo ");

  header("Content-Disposition: attachment; filename=Inscripciones-".str_replace(' ','_',$row3['empresa'])."-Varios_Eventos-".date('j-n-Y').".xls; charset=ISO-8859-1");
} else {
  $result2 = mysql_query('SELECT * FROM inscribite_inscripciones WHERE deevento="'.$_GET['evento'].'" ORDER BY codigo ');
  $result3 = mysql_query('SELECT * FROM inscribite_eventos WHERE codigo = "'.$_GET['evento'].'" LIMIT 1 ');
  $row3 = mysql_fetch_array($result3);

  header("Content-Disposition: attachment; filename=Inscripciones-".str_replace(' ','_',$row3['empresa'])."-".str_replace(' ','_',$row3['nombre'])."-".date('j-n-Y').".xls; charset=ISO-8859-1");
}
$meses = Array('', 'ene', 'feb', 'mar', 'abr', 'may', 'jun', 'jul', 'ago', 'sep', 'oct', 'nov', 'dic');
if (mysql_num_rows($result2) > 0) {
  $hayuninscripto = true;
?><table><tr><td>DNI Usuario</td><td>Nombre</td>
</td><td>Apellido</td><td>DNI</td><td>Fecha de nacimiento</td><td>Sexo</td><td>Email</td><td>Tel&eacute;fono part.</td><td>Tel&eacute;fono laboral</td><td>Tel&eacute;fono celular</td><td>Domicilio</td><td>Localidad</td><td>Provincia</td><td>País</td><td>Evento</td><td>Categor&iacute;a</td><td>Pagado</td><td>el d&iacute;a</td><?
 if ($row['pregunta'] != '') echo'<td>'.$row['pregunta'].'</td>'?></tr><?
while ($row2 = mysql_fetch_array($result2)) { ?>
<tr><td><?=($row2['deusuario']*1)?></td><?php
$result3 = mysql_query('SELECT * FROM inscribite_usuarios WHERE dni="'.($row2['deusuario']*1).'" LIMIT 1 ');
$row3 = mysql_fetch_array($result3);
?><td><?=htmlentities(utf8_decode($row3['nombre']))?></td><td><?=htmlentities(utf8_decode($row3['apellido']))?></td><td><?=$row3['dni']?></td><td><?=substr($row3['fechanac'], 6, 2).' de '.$meses[substr($row3['fechanac'], 4, 2)*1].' de '.substr($row3['fechanac'], 0, 4)?></td><td><?=$row3['sexo']?></td><td><?=$row3['email']?></td><td><?=$row3['telefonoparticular']?></td><td><?=$row3['telefonolaboral']?></td><td><?=$row3['telefonocelular']?></td><td><?=htmlentities(utf8_decode($row3['domicilio']))?></td><td><?=htmlentities(utf8_decode($row3['localidad']))?></td><td><?=htmlentities(utf8_decode($row3['provincia']))?></td><td><?=htmlentities(utf8_decode($row3['pais']))?></td><td><?=htmlentities(utf8_decode($row2['deevento']))?></td><td><?=$row2['categoria']?></td><td><?=$row2['pagado']?></td><td><? if ($row2['pagado'] == 1) echo $row2['pagoeldia']?></td><?
 if ($row2['respuestapart1'] != '') echo '<tr><td colspan="3">'.$row['pregunta1'].'</td><td colspan="4">'.$row2['respuestapart1'].'</td></tr>';
 if ($row2['respuestapart2'] != '') echo '<tr><td colspan="3">'.$row['pregunta2'].'</td><td colspan="4">'.$row2['respuestapart2'].'</td></tr>';
 if ($row2['respuestapart3'] != '') echo '<tr><td colspan="3">'.$row['pregunta3'].'</td><td colspan="4">'.$row2['respuestapart3'].'</td></tr>';

?></tr><?
 } ?></table>
<? }
if (!($hayuninscripto)) echo 'Aún no hay inscriptos<br/>';
if (is_resource($result2)) mysql_free_result($result2);
if (is_resource($result3)) mysql_free_result($result3);
mysql_close();
?>