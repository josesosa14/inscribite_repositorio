<?php
$result1 = mysql_query('SELECT * FROM inscribite_banners WHERE id="' . $_GET['editando'] . '" LIMIT 1 ');
$row1 = mysql_fetch_array($result1);
$idactual = ($_GET['sec'] == 'banners.agregar') ? '' : $row1['id']
?>
<div>
    <div style="line-height:30px;font-weight:bold;margin-top:10px;"><a href="?sec=categorias.admin&amp;evento=<?= $_GET['evento'] ?>">Categorías</a> &gt; <?= ($_GET['sec'] == 'categorias.agregar') ? 'Agregar Nueva' : 'Editar' ?> &gt; <?= $row1['nombreevento'] ?></div>
    <form enctype="multipart/form-data" action="guardar.php" method="post">
        <div>
            <input type="hidden" name="tabla" value="inscribite_banners"/>
            <input type="hidden" name="id" value="<?= $idactual ?>"/>
            <input type="hidden" name="volvera" value="<?= ($_GET['sec'] == 'banners.agregar') ? 'banners.agregar' : 'banners.admin' ?>"/>
            <input type="hidden" name="columna" value="2"/>
<?php /*        <input type="hidden" name="columna" value="2"/> */ ?>
            <div style="width:470px;float:left;clear:none;">
                &gt; Nombre
                <input type="text" name="nombre" value="<?= $row1['nombre'] ?>"/>
            </div>
            <div class="contcheckbox"style="float:left;clear:left;width:100%;">
                <input type="hidden" name="ver" value="0"/>
                <span>&gt; Ver</span>
                <input type="checkbox" name="ver" value="1"<?= ($row1['ver'] == 1) ? ' checked="checked"' : '' ?>/>
            </div>
            <div style="width:470px;float:left;clear:none;">
                &gt; Link
                <input type="text" name="link" value="<?= $row1['link'] ?>"/>
            </div>
            <input type="hidden" name="nombrevar" value="imagen1"/>
            <input type="hidden" name="width1" value="160"/>
            <input type="hidden" name="height1" value="60"/>

            <div class="contselect" style="float:left;clear:left;">
                Formato:
                <select name="width1">
                    <option value="160"<?php if ($row1['width1'] == 160) echo ' selected="selected"' ?>>160px x 60px</option>
                    <option value="544"<?php if ($row1['width1'] == 544) echo ' selected="selected"' ?>>544px x 60px</option>
                </select>
            </div>

            <div class="contselect" style="float:left;clear:left;width:100%;">
                <span style="float:left;">Evento:</span>
                <select name="areventos[]" multiple="multiple" size="4" style="float:left;clear:none;margin-left:7px;">
                    <option value="0"<?php if (strpos($row1['eventos'], '_0') > -1) echo' selected="selected"' ?>>Todos</option>
                    <?php
                    $result2 = mysql_query('SELECT * FROM inscribite_eventos WHERE ver = 1 ORDER BY nombre ASC');
                    while ($row2 = mysql_fetch_array($result2)) {
                        ?>
                        <option value="<?= $row2['id'] ?>"<?php if (strpos($row1['eventos'], '_' . $row2['id']) > -1) echo' selected="selected"' ?>><?= $row2['nombre'] ?></option>
<?php } ?>
                </select>
            </div>

            <div class="contselect" style="float:left;clear:left;width:100%;">
                Ubicación:
                <select name="ubicacion">
                    <option value="1"<?php if ($row1['ubicacion'] == 1) echo ' selected="selected"' ?>>Inicio de inscripción</option>
                    <option value="2"<?php if ($row1['ubicacion'] == 2) echo ' selected="selected"' ?>>Cupón</option>
                    <option value="0"<?php if ($row1['ubicacion'] == 0) echo ' selected="selected"' ?>>Ambos</option>
                </select>
            </div>

            <div style="margin-top:20px;margin-bottom:16px;padding:0px;width:100%;float:left;clear:left;">
                &gt; Imagen 1
                <?
                if (($row1['imagen1'] != '') && (file_exists($directorio.'image_'.$row1['imagen1']))) {
                echo '<div><img src="'.$directorio.'image_'.$row1['imagen1'].'" alt="" style="margin:10px 0px 10px 0px;"/></div>';
                }
                ?>
                <br/>
                Subir imagen nueva:<br/><input name="imagen1" type="file" style="display:inline;width:300px;"/>
            </div>
            <?php /*
              <div class="contselect" style="float:left;clear:left;width:100%;">
              &gt; Posición<br/><br/>
              <select name="columna">
              <option value="">Selecciona opcion</option>
              <option<?
              if ($row1['columna'] == 1) echo ' selected="selected"'?> value="1">Izquierda</option>
              <option<?
              if ($row1['columna'] == 2) echo ' selected="selected"'?> value="2">Derecha</option>
              </select>
              </div>
             */ ?>
            <div style="float:left;clear:left;width:100%;">
                <input type="submit" value="Enviar" class="submit"/>
            </div>
        </div>
    </form>
</div>
