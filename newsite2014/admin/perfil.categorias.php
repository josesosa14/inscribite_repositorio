<?php
$result1 = mysqli_query($coneccion, 'SELECT * FROM inscribite_categorias WHERE id = "' . $_GET['editando'] . '" LIMIT 1 ');
$row1 = mysqli_fetch_array($result1);
//trayendo el último código
$query = "SELECT max(codigo)+1 last_codigo FROM inscribite_categorias WHERE deevento = '{$_GET['evento']}' ";
$result2 = mysqli_query($coneccion, $query);
$row2 = mysqli_fetch_array($result2);
$idactual = ($_GET['sec'] == 'categorias.agregar') ? '' : $row1['id'];

if (!$idactual) {
    $row1['codigo'] = $row2['last_codigo'];
}
?>
<div>
    <div style="line-height:30px;font-weight:bold;margin-top:10px;"><a href="?sec=categorias.admin&amp;evento=<?= $_GET['evento'] ?>">Categorías</a> &gt; <?= ($_GET['sec'] == 'categorias.agregar') ? 'Agregar Nueva' : 'Editar' ?> &gt; <?= $row2['nombreevento'] ?></div>
    <form action="guardar.php" method="post">
        <div>
            <input type="hidden" name="tabla" value="inscribite_categorias"/>
            <input type="hidden" name="id" value="<?= $idactual ?>"/>
            <input type="hidden" name="volvera" value="<?= ($_GET['sec'] == 'categorias.agregar') ? 'categorias.agregar&amp;evento=' . $_GET['evento'] : 'categorias.admin&amp;evento=' . $_GET['evento'] ?>"/>
            <input type="hidden" name="deevento" value="<?= $_GET['evento'] ?>"/>
            <div style="height:53px;">
                <div style="width:470px;float:left;clear:none;">
                    &gt; Nombre de la Categoría
                    <input type="text" name="nombre" value="<?= $row1['nombre'] ?>"/>
                </div>
                <div style="width:210px;float:right;clear:none;">
                    &gt; Código (2 cifras)<br/>
                    <input type="text" name="codigo" value="<?= $row1['codigo'] ?>" id="codcat" style="width:40px;"/>
                </div>
            </div>
            &gt; Descripción de la Categoría
            <input type="text" name="descripcion" style="float:left;clear:left;display:inline;" value="<?= $row1['descripcion'] ?>"/>
            <div class="contselect">
                &gt; Pertenece a la opción<br/><br/>
                <select name="opcion">
                    <option value=''>Selecciona opción</option>
                    <?php
                    $result2 = mysqli_query($coneccion, 'SELECT * FROM inscribite_eventos WHERE codigo = "' . $_GET['evento'] . '" LIMIT 1 ');
                    $row2 = mysqli_fetch_array($result2);
                    $tipo = $row2['tipo'];
                    $result3 = mysqli_query($coneccion, 'SELECT * FROM inscribite_opciones WHERE evento = "' . $_GET['evento'] . '" OR evento = "' . ($_GET['evento'] * 1) . '" ');
                    while ($row3 = mysqli_fetch_array($result3)) {
                        echo '<option value="' . $row3['nombre'] . '"';
                        if ($row1['opcion'] == $row3['nombre']) {
                            echo ' selected="selected"';
                            $existeop = true;
                        }
                        echo '>' . $row3['nombre'] . '</option>';
                    }
                    if (($row1['opcion'] != '') && (!$existeop)) {
                        ?>
                        <option selected="selected"><?= $row1['opcion'] ?></option><?php }
                    ?>
                </select>
            </div>
            
            <?php if ($row2['tipo'] == 'Deportivos') { ?>
                <div style="text-align:left;float:left;height:30px;">
                    <input name="limitedeedad" value="0" type="hidden"/>
                    <span style="float:left;margin-top:8px;">Límite de edad:</span>
                    
                    <input <?=$row1["limitedeedad"]?"checked":""?> name="limitedeedad" id="checklimitedeedad" value="1" type="checkbox" onchange="activalimiteedad(this)" style="display:inline;position:relative;top:10px;width:auto;border:0px;background:transparent;float:left;clear:none;margin:0px 0px 0px 8px;"/>
                   
                </div>
                <div id="edadesmaxmin"<?php if ($row1['limitedeedad'] == 0) echo ' style="display:none;"' ?>>
                    <div style="float:left;clear:left;width:400px;">
                        <span style="float:left;clear:none;">&gt; Edad mínima</span>
                        <span style="float:right;clear:none;">&gt; Edad máxima</span>
                    </div>
                    <div style="float:left;clear:left;width:400px;">
                        <input type="text" name="edadminima" id="edadminima" value="<?= $row1['edadminima'] ?>" style="width:170px;float:left;clear:none;"/>
                        <input type="text" name="edadmaxima" id="edadmaxima" value="<?= $row1['edadmaxima'] ?>" style="width:170px;float:right;clear:none;"/>
                    </div>
                    <div style="float:left;clear:left;width:100%;">
                        &gt; Fecha de Computo de edad
                        <?php
                        $nombremes = array("", "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
                        if ($row1['fechadecomputo'] == '') {
                            $mesactual = date('n');
                            $anioactual = date('Y');
                        } else {
                            $mesactual = substr($row1['fechadecomputo'], 4, 2);
                            $anioactual = substr($row1['fechadecomputo'], 0, 4);
                        }
                        if ($mesactual < 1)
                            $mesactual = date('n');
                        if ($anioactual < 1)
                            $anioactual = date('Y');
                        $mesactual = $mesactual * 1;
                        $primdiames = date("w", mktime(0, 0, 0, $mesactual, 1, $anioactual));
                        $ultdiames = date("t", mktime(0, 0, 0, $mesactual, 1, $anioactual)) + $primdiames;
                        ?>
                        <div style="height:200px;width:188px;">
                            <div id="calendario1" style="height:170px;width:188px;float:left;font-size:11px;margin-top:5px;">
                                <div style="height:24px;">
                                    <span class="mespaatras">
                                        <a class="flechitasmes" href="#" onclick="leemes('calendario1', '<?= $row1['id'] ?>', 'fechadecomputo',<?= ($mesactual - 1) ?>,<?= $anioactual ?>);
                                                return false;">&laquo;</a>
                                    </span>
                                    <span class="nombremesencal">
                                        <?= $nombremes[$mesactual] . ' ' . substr('0' . ($anioactual - 2000), -2, 2) ?>
                                    </span>
                                    <span class="mespaadelante">
                                        <a class="flechitasmes" href="#" onclick="leemes('calendario1', '<?= $row1['id'] ?>', 'fechadecomputo',<?= ($mesactual + 1) ?>,<?= $anioactual ?>);
                                                return false;">&raquo;</a>
                                    </span>
                                </div>
                                <div onmouseup="empiezaarras = false">
                                    <div class="lineacal" style="letter-spacing:17px;text-indent:8px;">
                                        DLMMJVS
                                    </div>
                                    <div class="lineacal">
                                        <?php
                                        for ($ndia = 1; $ndia <= $ultdiames; $ndia++) {
                                            $fdia = $ndia - $primdiames;
                                            $colordfd = '';
                                            if ($row1['fechadecomputo'] == $anioactual . substr('0' . $mesactual, -2, 2) . substr('0' . $fdia, -2, 2))
                                                $colordfd = ' style="background-color:#C9DAEE;" id="tocado1"';
                                            if ($fdia < 1)
                                                echo '                <span></span>' . chr(13);
                                            else
                                                echo '<a onmousedown="tocacal(1,' . "'fechadecomputo'" . ',this,' . $fdia . ', ' . $mesactual . ', ' . $anioactual . ');" ' . $colordfd . '>' . $fdia . '</a>' . chr(13);
                                            if ($ndia % 7 == 0)
                                                echo '                </div>' . chr(13) . '                <div class="lineacal">' . chr(13);
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <input type="text" id="fechadecomputo" name="fechadecomputo" value="<?= $row1['fechadecomputo'] ?>" style="width:170px;"/>
                        </div>

                    </div>
                    <?php
                }
                ?>

            </div>
            <div class="contselect" style="float:left;clear:left;width:100%;">
                <span style="float:left;margin:4px 5px 0px 0px;">&gt; Sexo</span>
                <select name="sexo">
                    <option value="Ambos"<?php if ($row1['sexo'] == 'Ambos') echo ' selected="selected"' ?>>Ambos</option>
                    <option value="Masculino"<?php if ($row1['sexo'] == 'Masculino') echo ' selected="selected"' ?>>Masculino</option>
                    <option value="Femenino"<?php if ($row1['sexo'] == 'Femenino') echo ' selected="selected"' ?>>Femenino</option>
                </select>
            </div>

            <?php if ($tipo == 'Servicios') { ?>
                <table style="float:left;width:100%;border:0px;margin-top:10px;">
                    <tr style="border:0px;background:none">
                        <td style="width:225px;border:0px;vertical-align:top">
                            &gt; Precio 1
                            <input type="text" name="precio1" value="<?= $row1['precio1'] ?>" style="width:170px;float:left;clear:left;"/>
                            <div style="width:176px;">&gt; Vencimiento 1. Día</div>
                            <select name="fechavenc1" id="fechavenc1" value="<?= $row1['fechavenc1'] ?>" onchange="
                                    for (g = 1; g <= 31; g++) {
                                        if (g < this.value * 1) {
                                            document.getElementById('v2d' + g).disabled = 'disabled';
                                            document.getElementById('v3d' + g).disabled = 'disabled';
                                        } else {
                                            document.getElementById('v2d' + g).disabled = '';
                                            document.getElementById('v3d' + g).disabled = '';
                                        }
                                    }
                                    if (document.getElementById('fechavenc2').value * 1 < this.value) {
                                        document.getElementById('v2d' + ((this.value * 1) + 1)).selected = 'selected';
                                        document.getElementById('fechavenc2').value = ((this.value * 1) + 1);
                                    }
                                    if (document.getElementById('fechavenc3').value * 1 < this.value) {
                                        document.getElementById('v3d' + ((this.value * 1) + 2)).selected = 'selected';
                                        document.getElementById('fechavenc3').value = ((this.value * 1) + 2);
                                    }
                                    ">
                                        <?php
                                        for ($r = 1; $r <= 31; $r++) {
                                            ?>
                                    <option value="<?= $r ?>" id="v1d<?= $r ?>"<?php if ($row1['fechavenc1'] == $r) echo ' selected="selected"' ?>><?= $r ?></option>
                                <?php } ?>
                            </select> del mes
                        </td>
                        <td style="width:225px;vertical-align:top;">
                            &gt; Precio 2
                            <input type="text" name="precio2" value="<?= $row1['precio2'] ?>" style="width:170px;float:left;clear:left;"/>
                            <div style="width:176px;">&gt; Vencimiento 2. Día</div>
                            <select name="fechavenc2" id="fechavenc2" value="<?= $row1['fechavenc2'] ?>" onchange="
                                    for (g = 1; g <= 31; g++) {
                                        if (g < this.value * 1)
                                            document.getElementById('v3d' + g).disabled = 'disabled';
                                        else
                                            document.getElementById('v3d' + g).disabled = '';
                                    }
                                    if (document.getElementById('fechavenc3').value * 1 < this.value) {
                                        document.getElementById('v3d' + ((this.value * 1) + 1)).selected = 'selected';
                                        document.getElementById('fechavenc3').value = ((this.value * 1) + 1);
                                    }
                                    if (this.value * 1 < document.getElementById('fechavenc1').value * 1)
                                        this.value = document.getElementById('fechavenc1').value;
                                    ">
                                        <?php
                                        for ($r = 1; $r <= 31; $r++) {
                                            ?>
                                    <option value="<?= $r ?>" id="v2d<?= $r ?>"<?php if ($row1['fechavenc2'] == $r) echo ' selected="selected"' ?>><?= $r ?></option>
                                <?php } ?>
                            </select> del mes
                        </td>
                        <td style="vertical-align:top;">
                            &gt; Precio 3<br/>
                            <input type="text" name="precio3" value="<?= $row1['precio3'] ?>" style="width:170px;float:left;clear:left;"/>
                            <div style="width:176px;">&gt; Vencimiento 3. Día</div>
                            <select name="fechavenc3" id="fechavenc3" value="<?= $row1['fechavenc3'] ?>" onchange="if (this.value * 1 < document.getElementById('fechavenc2').value * 1)
                                        this.value = document.getElementById('fechavenc2').value;">
                                        <?php
                                        for ($r = 1; $r <= 31; $r++) {
                                            ?>
                                    <option value="<?= $r ?>" id="v3d<?= $r ?>"<?php if ($row1['fechavenc3'] == $r) echo ' selected="selected"' ?>><?= $r ?></option>
                                <?php } ?>
                            </select> del mes
                        </td>
                    </tr>
                </table>
                <?php
            } else {
                ?>
                <table style="float:left;width:100%;border:0px;">
                    <tr style="border:0px;background:none">
                        <td style="width:225px;border:0px;vertical-align:top;">
                            &gt; Precio 1
                            <input type="text" name="precio1" value="<?= $row1['precio1'] ?>" style="width:170px;float:left;clear:none;"/>
                            <div style="width:176px;">&gt; Vencimiento 1</div>
                            <?php
                            if ($row1['fechavenc1'] == '') {
                                $mesactual = date('n');
                                $anioactual = date('Y');
                            } else {
                                $mesactual = substr($row1['fechavenc1'], 4, 2);
                                $anioactual = substr($row1['fechavenc1'], 0, 4);
                            }
                            if ($mesactual < 1)
                                $mesactual = date('n');
                            if ($anioactual < 1)
                                $anioactual = date('Y');
                            $mesactual = $mesactual * 1;
                            $primdiames = date("w", mktime(0, 0, 0, $mesactual, 1, $anioactual));
                            $ultdiames = date("t", mktime(0, 0, 0, $mesactual, 1, $anioactual)) + $primdiames;
                            ?>
                            <div style="height:170px;width:176px;float:left;clear:left;">
                                <div id="calendario2" style="height:170px;width:188px;float:left;margin-top:5px;">
                                    <div style="height:24px;">
                                        <span class="mespaatras">
                                            <a class="flechitasmes" href="#" onclick="leemes('calendario2', '<?= $row1['id'] ?>', 'fechavenc1',<?= ($mesactual - 1) ?>,<?= $anioactual ?>);
                                                    return false;">&laquo;</a>
                                        </span>
                                        <span class="nombremesencal">
                                            <?= $nombremes[$mesactual] . ' ' . substr('0' . ($anioactual - 2000), -2, 2) ?>
                                        </span>
                                        <span class="mespaadelante">
                                            <a class="flechitasmes" href="#" onclick="leemes('calendario2', '<?= $row1['id'] ?>', 'fechavenc1',<?= ($mesactual + 1) ?>,<?= $anioactual ?>);
                                                    return false;">&raquo;</a>
                                        </span>
                                    </div>
                                    <div onmouseup="empiezaarras = false">
                                        <div class="lineacal" style="letter-spacing:17px;text-indent:8px;">
                                            DLMMJVS
                                        </div>
                                        <div class="lineacal">
                                            <?php
                                            for ($ndia = 1; $ndia <= $ultdiames; $ndia++) {
                                                $fdia = $ndia - $primdiames;
                                                $colordfd = '';
                                                if ($row1['fechavenc1'] == $anioactual . substr('0' . $mesactual, -2, 2) . substr('0' . $fdia, -2, 2)) {
                                                    $colordfd = ' style="background-color:#C9DAEE;" id="tocado2"';
                                                }
                                                if ($fdia < 1) {
                                                    echo '                    <span></span>' . chr(13);
                                                } else {
                                                    echo '                    <a onmousedown="tocacal(2,' . "'fechavenc1'" . ',this,' . $fdia . ', ' . $mesactual . ', ' . $anioactual . ');" ' . $colordfd . '>' . $fdia . '</a>';
                                                }
                                                if ($ndia % 7 == 0)
                                                    echo '                    </div>' . chr(13) . '                    <div class="lineacal">';
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <br/>
                                    <strong><?= ($row1['fechavenc1'] == 0) ? 'No establecida' : '' ?></strong>
                                </div>
                                <input type="text" id="fechavenc1" name="fechavenc1" value="<?= $row1['fechavenc1'] ?>" style="width:170px;"/>
                            </div>
                        </td>
                        <td style="width:225px;vertical-align:top;">
                            <div style="width:225px;height:268px;float:left;overflow:hidden;">
                                &gt; Precio 2
                                <input type="text" name="precio2" value="<?= $row1['precio2'] ?>" style="width:170px;float:left;clear:none;"/>
                                <div style="float:left;clear:left;width:176px;">&gt; Vencimiento 2</div>
                                <?php
                                if ($row1['fechavenc2'] == '') {
                                    $mesactual = date('n');
                                    $anioactual = date('Y');
                                } else {
                                    $mesactual = substr($row1['fechavenc2'], 4, 2);
                                    $anioactual = substr($row1['fechavenc2'], 0, 4);
                                }
                                if ($mesactual < 1)
                                    $mesactual = date('n');
                                if ($anioactual < 1)
                                    $anioactual = date('Y');
                                $mesactual = $mesactual * 1;
                                $primdiames = date("w", mktime(0, 0, 0, $mesactual, 1, $anioactual));
                                $ultdiames = date("t", mktime(0, 0, 0, $mesactual, 1, $anioactual)) + $primdiames;
                                ?>
                                <div style="height:160px;width:200px;float:left;overflow:hidden;">
                                    <div id="calendario3" style="height:170px;width:188px;float:left;margin-top:5px;">
                                        <div style="height:24px;">
                                            <span class="mespaatras">
                                                <a class="flechitasmes" href="#" onclick="leemes('calendario3', '<?= $row1['id'] ?>', 'fechavenc2',<?= ($mesactual - 1) ?>,<?= $anioactual ?>);
                                                        return false;">&laquo;</a>
                                            </span>
                                            <span class="nombremesencal">
                                                <?= $nombremes[$mesactual] . ' ' . substr('0' . ($anioactual - 2000), -2, 2) ?>
                                            </span>
                                            <span class="mespaadelante">
                                                <a class="flechitasmes" href="#" onclick="leemes('calendario3', '<?= $row1['id'] ?>', 'fechavenc2',<?= ($mesactual + 1) ?>,<?= $anioactual ?>);
                                                        return false;">&raquo;</a>
                                            </span>
                                        </div>
                                        <div onmouseup="empiezaarras = false" style="">
                                            <div class="lineacal" style="letter-spacing:17px;text-indent:8px;">
                                                DLMMJVS
                                            </div>
                                            <div class="lineacal" style="float:left;">
                                                <?php
                                                for ($ndia = 1; $ndia <= $ultdiames; $ndia++) {
                                                    $fdia = $ndia - $primdiames;
                                                    $colordfd = '';
                                                    if ($row1['fechavenc2'] == $anioactual . substr('0' . $mesactual, -2, 2) . substr('0' . $fdia, -2, 2)) {
                                                        $colordfd = ' style="background-color:#C9DAEE;" id="tocado3"';
                                                    }
                                                    if ($fdia < 1) {
                                                        echo '                      <span></span>' . chr(13);
                                                    } else {
                                                        echo '                      <a onmousedown="tocacal(3,' . "'fechavenc2'" . ',this,' . $fdia . ', ' . $mesactual . ', ' . $anioactual . ');" ' . $colordfd . '>' . $fdia . '</a>';
                                                    }
                                                    if ($ndia % 7 == 0)
                                                        echo '                      </div>' . chr(13) . '                      <div class="lineacal">';
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <br/>
                                    <strong><?= ($row1['fechavenc2'] == 0) ? 'No establecida' : '' ?></strong>
                                </div>
                                <input type="text" id="fechavenc2" name="fechavenc2" value="<?= $row1['fechavenc2'] ?>" style="width:170px;margin-top:14px"/>
                            </div>
                        </td>
                        <td style="">
                            <div style="width:225px;height:268px;float:left;overflow:hidden;">
                                &gt; Precio 3
                                <input type="text" name="precio3" value="<?= $row1['precio3'] ?>" style="width:170px;float:left;clear:none;"/>
                                <div style="float:left;clear:left;width:176px;">&gt; Vencimiento 3</div>
                                <?php
                                if ($row1['fechavenc3'] == '') {
                                    $mesactual = date('n');
                                    $anioactual = date('Y');
                                } else {
                                    $mesactual = substr($row1['fechavenc3'], 4, 2);
                                    $anioactual = substr($row1['fechavenc3'], 0, 4);
                                }
                                if ($mesactual < 1)
                                    $mesactual = date('n');
                                if ($anioactual < 1)
                                    $anioactual = date('Y');
                                $mesactual = $mesactual * 1;
                                $primdiames = date("w", mktime(0, 0, 0, $mesactual, 1, $anioactual));
                                $ultdiames = date("t", mktime(0, 0, 0, $mesactual, 1, $anioactual)) + $primdiames;
                                ?>
                                <div style="height:170px;width:100%;">
                                    <div id="calendario4" style="height:170px;width:188px;float:left;">
                                        <div style="height:24px;">
                                            <span class="mespaatras">
                                                <a class="flechitasmes" href="#" onclick="leemes('calendario4', '<?= $row1['id'] ?>', 'fechavenc3',<?= ($mesactual - 1) ?>,<?= $anioactual ?>);
                                                        return false;">&laquo;</a>
                                            </span>
                                            <span class="nombremesencal">
                                                <?= $nombremes[$mesactual] . ' ' . substr('0' . ($anioactual - 2000), -2, 2) ?>
                                            </span>
                                            <span class="mespaadelante">
                                                <a class="flechitasmes" href="#" onclick="leemes('calendario4', '<?= $row1['id'] ?>', 'fechavenc3',<?= ($mesactual + 1) ?>,<?= $anioactual ?>);
                                                        return false;">&raquo;</a>
                                            </span>
                                        </div>
                                        <div onmouseup="empiezaarras = false">
                                            <div class="lineacal" style="letter-spacing:17px;text-indent:8px;">
                                                DLMMJVS
                                            </div>
                                            <div class="lineacal">
                                                <?php
                                                for ($ndia = 1; $ndia <= $ultdiames; $ndia++) {
                                                    $fdia = $ndia - $primdiames;
                                                    $colordfd = '';
                                                    if ($row1['fechavenc3'] == $anioactual . substr('0' . $mesactual, -2, 2) . substr('0' . $fdia, -2, 2))
                                                        $colordfd = ' style="background-color:#C9DAEE;" id="tocado4"';
                                                    if ($fdia < 1)
                                                        echo '                        <span></span>';
                                                    else
                                                        echo '                        <a onmousedown="tocacal(4,' . "'fechavenc3'" . ',this,' . $fdia . ', ' . $mesactual . ', ' . $anioactual . ');" ' . $colordfd . '>' . $fdia . '</a>';
                                                    if ($ndia % 7 == 0)
                                                        echo '                      </div>' . chr(13) . '                      <div class="lineacal">';
                                                }
                                                ?>
                                            </div>
                                            <br/>
                                            <strong><?= ($row1['fechavenc3'] == 0) ? 'No establecida' : '' ?></strong>
                                        </div>
                                    </div>
                                    <div style="float:left;clear:left;">
                                        <input type="text" id="fechavenc3" name="fechavenc3" value="<?= $row1['fechavenc3'] ?>" style="width:170px;"/>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>

                
                <?php
            }
            ?>
            <div style="float:left;clear:left;width:100%;">
                <input type="submit" value="Enviar" class="submit"/>
            </div>
        </div>

    </form>
</div>
</div>
