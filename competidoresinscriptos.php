<? include_once 'includes/header.php' ?>
<div class="left" style="width:710px;">
<h1>Competidores Inscriptos a: 
<?
$result1 = mysql_query('SELECT * FROM '.pftables.'eventos WHERE codigo = "'.$_GET['evento'].'" LIMIT 1 ');
$row1 = mysql_fetch_array($result1);
echo $row1['nombre'];
?></h1>
<table cellpadding="2" cellspacing="0" style="width:700px;">
<tr>
<td width="120"><span style="font-weight: bold">Apellido</span></td>
<td width="114"><span style="font-weight: bold">Nombre</span></td>
<td width="91"><span style="font-weight: bold">Grupo</span></td>
<td width="140"><span style="font-weight: bold">Categoría</span></td>
<td width="150"><span style="font-weight: bold">Condición</span></td>
</tr>
<?
$result1 = mysql_query('SELECT * FROM '.pftables.'inscripciones WHERE deevento = "'.$_GET['evento'].'" ORDER BY deusuario ');
while ($row1 = mysql_fetch_array($result1)) {
  if ($row1['deusuario'] != '00000000') {
    $result2 = mysql_query('SELECT * FROM '.pftables.'usuarios WHERE dni = "'.$row1['deusuario'].'" OR dni="'.($row1['deusuario']*1).'" LIMIT 1 ');
    $row2 = mysql_fetch_array($result2);
    $result3 = mysql_query('SELECT * FROM '.pftables.'categorias WHERE codigo = "'.substr($row1['codigo'],4,2).'" AND deevento="'.$evento.'" LIMIT 1 ');
    $row3 = mysql_fetch_array($result3);
    if ($ultimodni != ($row1['deusuario']*1)) {
      $ultimodni = ($row1['deusuario']*1);
?>
	<tr>
	 <td><?=$row2['apellido']?></td><td><?=$row2['nombre']?></td><td>&nbsp;<?=$row3['opcion']?></td><td><?=$row3['nombre']?></td><td><?=($row1['pagado']==0)?'Reservada':'<span style="color:green">Confirmada</span>'?></td>
	</tr>
<?
    }
  }
}
?>
	</table>
<? include_once 'includes/footerfull.php'; ?>