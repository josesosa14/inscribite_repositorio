<?php
header("Content-type: text/html; charset=UTF-8");

include_once "../inc.config.php";

$evento = $_GET['evento'];
$evento = str_replace('_', ' ', $evento);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es" >
    <head>
        <title>Inscribite Online - Tabla de categorías de <?= $_GET['evento'] ?></title>
        <meta name="description" content="mtnbazar Argentina"/>
        <meta name="robots" content="noindex,nofollow"/>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <style type="text/css" >
            <!--
            body{
                font-family: Verdana, Arial, Helvetica, sans-serif;
                font-size: 90%;
                width:990px;
                outline:0;
            }
            *{
                outline:0;
            }
            td{
                border:none;
                margin:none;
                padding:0px 6px 0px 6px;
                text-align:center;
            }
            table{
                font-size: 83%;
                margin-bottom:10px;
                margin-top:10px;
                border-collapse:collapse;
            }
            table tr{
                background:#FFF url(images/puntitos.gif) repeat-x 0% 100%;
            }
            .titulos th{
                padding-bottom:3px;
                padding-top:2px;
                font-size:13px;
                font-weight:bold;
                background-color:#EEEEEE;
            }
            a{
                color:blue;
                text-decoration:none;
                font-size:11px;
            }
            -->
        </style>
    </head>
    <body>
        <a href="./">Volver</a>
        <table cellpadding="0" cellspacing="0">
            <tr class="titulos">
                <th>Cod</th>
                <th>Evento</th>
                <th>Opción</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>De</th>
                <th>A</th>
                <th>Al</th>
                <th>Sexo</th>
                <th>Precio 1</th>
                <th>Precio 2</th>
                <th>Precio 3</th>
            </tr>
            <?php
            $cambiacollineas = 0;
            $result1 = mysqli_query($coneccion,'SELECT * FROM inscribite_categorias WHERE deevento = "' . $evento . '" ORDER BY codigo ');
            while ($row1 = mysqli_fetch_array($result1)) {
                $cambiacollineas++
                ?>
                <tr style="background-color:#FFFFFF">
                    <td><?= $row1['codigo'] ?></td>
                    <td><?= $row1['deevento'] ?></td>
                    <td><?= $row1['opcion'] ?></td>
                    <td><?= $row1['nombre'] ?></td>
                    <td><?= $row1['descripcion'] ?></td>
                    <td><?= $row1['edadminima'] ?></td>
                    <td><?= $row1['edadmaxima'] ?></td>
                    <td><?= substr($row1['fechadecomputo'], 6, 2) . '/' . substr($row1['fechadecomputo'], 4, 2) . '/' . substr($row1['fechadecomputo'], 0, 4) ?></td>
                    <td><?= $row1['sexo'] ?></td>
                    <td><?php if ($row1['precio1'] == 00) echo 'no fijado';
                else echo '$ ' . $row1['precio1'] . ' hasta el ' . substr($row1['fechavenc1'], 6, 2) . '/' . substr($row1['fechavenc1'], 4, 2) . '/' . substr($row1['fechavenc1'], 0, 4) ?></td>
                    <td><?php if ($row1['precio2'] == 00) echo 'no fijado';
                else echo '$ ' . $row1['precio2'] . ' hasta el ' . substr($row1['fechavenc2'], 6, 2) . '/' . substr($row1['fechavenc2'], 4, 2) . '/' . substr($row1['fechavenc2'], 0, 4) ?></td>
                    <td><?php if ($row1['precio3'] == 00) echo 'no fijado';
                else echo '$ ' . $row1['precio3'] . ' hasta el ' . substr($row1['fechavenc3'], 6, 2) . '/' . substr($row1['fechavenc3'], 4, 2) . '/' . substr($row1['fechavenc3'], 0, 4) ?></td>
                </tr>
<?php } ?>
        </table>
        <a href="./">Volver</a>
    </body>
</html><?php
mysqli_free_result($result1);
mysqli_close($coneccion);
?>