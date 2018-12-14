<?php $result1 = mysql_query('SELECT * FROM inscribite_inscripciones WHERE id = '.$_GET['editando'].' LIMIT 1 ');
if (is_resource($result1)) {
	$row1 = mysql_fetch_array($result1);
	$nroid = $row1['id'];
} ?>
    <div>
        <div class="titulosec">Inscripciones &gt; <?=(is_resource($result1))?'Editando:':'Agregar Nueva'?> <?=$row1['deusuario']?>
        </div>
      <div>
		<form action="guardar.php" method="post">
      <div>
        <input type="hidden" name="id" value="<?=$nroid?>"/>
        <input type="hidden" name="tabla" value="inscribite_inscripciones"/>
        <input type="hidden" name="volvera" value="inscripciones.admin"/>

        &gt; DNI del inscripto
        <input type="text" name="deusuario" value="<?=$row1['deusuario']?>"/>

        <div style="margin-bottom:11px;">
          &gt; Iniciado el día: <?=substr($row1['iniciadoeldia'], 8, 2).' / '.substr($row1['iniciadoeldia'], 5, 2).' / '.substr($row1['iniciadoeldia'], 0, 4)?>
        </div>
        <div>
          &gt; Vence el día: <?=substr($row1['venceeldia'], 6, 2).' / '.substr($row1['venceeldia'], 4, 2).' / '.substr($row1['venceeldia'], 0, 4)?>
        </div>

            <div class="contselect">
              &gt; Categoría
			  <select name="categoria">
<?
$result3 = mysql_query('SELECT * FROM inscribite_categorias WHERE deevento="'.$row1['deevento'].'" ');
while ($row3 = mysql_fetch_array($result3)) {
?>
                <option<?
if ($row1['categoria'] == $row3['nombre']) echo ' selected="selected"'?> value="<?=$row3['nombre']?>"><?=$row3['nombre']?></option>
<?
}
?>
			  </select>
            </div>
            <div class="contselect">
			&gt; Pagado
			<select name="pagado">
              <option<?
if ($row1['pagado'] == 0) echo ' selected="selected"'?> value="0">No</option>
              <option<?
if ($row1['pagado'] == 1) echo ' selected="selected"'?> value="1">Si</option>
			</select>
            </div>
<?
$result3 = mysql_query('SELECT * FROM inscribite_eventos WHERE codigo = "'.$row1['deevento'].'" ');
$row3 = mysql_fetch_array($result3);
if ($row3['pregunta1'] != '') {
  echo '            Pregunta 1<br/>';
  echo $row3['pregunta1'].'<br/>';
  echo '            Respuesta:<br/>';
  echo $row1['respuesta1'].'<br/>';
}
if ($row3['pregunta2'] != '') {
  echo '            Pregunta 2<br/>';
  echo $row3['pregunta2'].'<br/>';
  echo '            Respuesta:<br/>';
  echo $row1['respuesta2'].'<br/>';
}
if ($row3['pregunta3'] != '') {
  echo '            Pregunta 3<br/>';
  echo $row3['pregunta3'].'<br/>';
  echo '            Respuesta:<br/>';
  echo $row1['respuesta3'].'<br/>';
}
?>

			<input type="submit" value="Enviar" class="submit"/>
          </div>
		</form>
      </div>
	</div>
