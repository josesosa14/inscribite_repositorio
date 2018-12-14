<?php
$result1 = mysql_query('SELECT * FROM inscribite_descuentos WHERE id = ' . $_GET['editando'] . ' LIMIT 1 ');
if (is_resource($result1)) {
    $row1 = mysql_fetch_array($result1);
    $nroid = $row1['id'];
}
?>
<div>
    <div class="titulosec">Descuentos &gt; <?= (is_resource($result1)) ? 'Editando:' : 'Agregar Nuevo' ?> <?= $row1['codigo'] ?></div>
    <div>
        <form action="guardar.php" method="post">
            <div>
                <input type="hidden" name="id" value="<?= $nroid ?>"/>
                <input type="hidden" name="tabla" value="inscribite_descuentos"/>
                <input type="hidden" name="volvera" value="descuentos.admin"/>
                &gt; De Evento
                <select name="codevento">
                    <?php
                    $result3 = mysql_query('SELECT * FROM inscribite_eventos WHERE ver = 1 ');
                    while ($row3 = mysql_fetch_array($result3)) {
                        ?>
                        <option<?php if ($row1['codevento'] == $row3['codigo']) echo ' selected="selected"' ?> value="<?= $row3['codigo'] ?>"><?= $row3['nombre'] ?></option>
<?php } ?>
                </select>
                <div>
                    &gt; DNI
                    <input type="text" name="coddni" value="<?= $row1['coddni'] ?>" id="dninmbusuario"/>
                </div>
                &gt; Descuento (porcentual)
                <input type="text" name="porcentajedescuento" value="<?= $row1['porcentajedescuento'] ?>"/>
                <input type="submit" value="Enviar" class="submit"/>
            </div>
        </form>
    </div>
