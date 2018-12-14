<?php
$result1 = mysqli_query($coneccion,'SELECT * FROM inscribite_eventos WHERE codigo = "' . $_GET['evento'] . '" LIMIT 1 ');
$row1 = mysqli_fetch_array($result1);
?>
<div>
    <div class="titulosec">Categorías &gt; Admin : Evento <a href="?sec=eventos.editar&editando=<?= $row1['id'] ?>"><?= $row1['nombre'] ?></a>&nbsp;&nbsp;&nbsp;<a href="tablacategorias.php?evento=<?= str_replace(' ', '_', $_GET['evento']) ?>">Ver datos completos en tabla</a>
    </div>
    <?php
    $result2 = mysqli_query($coneccion,'SELECT * FROM inscribite_opciones WHERE evento = "' . $_GET['evento'] . '" OR evento = "' . ($_GET['evento'] * 1) . '" ');
    while ($row2 = mysqli_fetch_array($result2)) {
        ?>
        Opción: <strong><?= $row2['nombre'] ?></strong>
        <?php
        if ($row2['cupo'] != 0) {
            ?>
            Cupo restante: <strong><?= $row2['cupo'] + $row2['cuporestante'] ?></strong> de <?= $row2['cupo'] ?>
            <?php
        }
        echo '<br/>';
    }
    ?>
    <br/>
    <table>
        <tr>
            <th>Cod</th>
            <th>Nombre</th>
            <th style="width:200px;">Opción</th>
            <th>Categoría</th>
            <th>Sexo</th>
            <th>Edad</th>
            <th>Computada al</th>
            <th>&nbsp;</th>
        </tr>
        <?php
        $result1 = mysqli_query($coneccion,'SELECT * FROM inscribite_categorias WHERE deevento = "' . $_GET['evento'] . '" ORDER BY codigo ');
        while ($row1 = mysqli_fetch_array($result1)) {
            ?>
            <tr>
                <td>
                    <a href="?sec=categorias.editar&amp;editando=<?= $row1['id'] ?>&amp;evento=<?= $_GET['evento'] ?>">
                        <span style="color:#666666;font-weight:normal;"><?= $row1['codigo'] ?></span>
                    </a>
                </td>
                <td>
                    <a href="?sec=categorias.editar&amp;editando=<?= $row1['id'] ?>&amp;evento=<?= $_GET['evento'] ?>">
                        <?= $row1['nombre'] ?>
                    </a>
                </td>
                <td style="color:#666">
                    <a href="?sec=categorias.editar&amp;editando=<?= $row1['id'] ?>&amp;evento=<?= $_GET['evento'] ?>">
                        <?= $row1['opcion'] ?>
                    </a>
                </td>
                <td style="color:#666">
                    <a href="?sec=categorias.editar&amp;editando=<?= $row1['id'] ?>&amp;evento=<?= $_GET['evento'] ?>">
                        <?= $row1['descripcion'] ?>
                    </a>
                </td>
                <td style="color:#666">
                    <a href="?sec=categorias.editar&amp;editando=<?= $row1['id'] ?>&amp;evento=<?= $_GET['evento'] ?>">
                        <?
                        if ($row1['sexo'] == 'Masculino') { echo 'Masc'; } else { if ($row1['sexo'] == 'Femenino') echo 'Fem'; else echo 'Ambos'; }?>
                    </a>
                </td>
                <td style="color:#666666;text-align:center;">
                    <a href="?sec=categorias.editar&amp;editando=<?= $row1['id'] ?>&amp;evento=<?= $_GET['evento'] ?>">
                        <?= $row1['edadminima'] ?> a <?= $row1['edadmaxima'] ?>
                    </a>
                </td>
                <td style="color:#666666;text-align:center;">
                    <a href="?sec=categorias.editar&amp;editando=<?= $row1['id'] ?>&amp;evento=<?= $_GET['evento'] ?>">
                        <?= substr($row1['fechadecomputo'], 6, 2) . '/' . substr($row1['fechadecomputo'], 4, 2) . '/' . substr($row1['fechadecomputo'], 0, 4) ?>
                    </a>
                </td>
                <td>
                    <a href="javascript:confirm_entry('<?= $row1['nombre'] ?>', 'categorias.adminamp;evento=<?= $_GET['evento'] ?>', 'inscribite_categorias',<?= $row1['id'] ?>)"><img src="images/deletex.gif" alt="Eliminar"/></a>
                </td>
            </tr>
            <?php
        }
        ?>
    </table>
    <a href="?sec=categorias.agregar&evento=<?= $_GET['evento'] ?>" style="margin-left:10;margin-top:20px;font-size:12px;float:left;">Agregar Nueva</a>
</div>
