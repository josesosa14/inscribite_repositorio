<div class="titulosec">Eventos &gt; Admin</div>
<div style="margin-bottom:6px;height:17px;">
    <div style="float:left;width:400px;">
        <a href="?sec=eventos.admin&amp;tipo=deportivos"<?= ($_GET['tipo'] == 'deportivos') ? '' : ' style="font-weight:normal;"' ?>>Deportivos</a> |
        <a href="?sec=eventos.admin&amp;tipo=capacitación"<?= ($_GET['tipo'] == 'capacitación') ? '' : ' style="font-weight:normal;"' ?>>Capacitación</a> |
        <a href="?sec=eventos.admin&amp;tipo=servicios"<?= ($_GET['tipo'] == 'servicios') ? '' : ' style="font-weight:normal;"' ?>>Servicios</a> |
        <a href="?sec=eventos.admin&amp;tipo=productos"<?= ($_GET['tipo'] == 'productos') ? '' : ' style="font-weight:normal;"' ?>>Productos</a>
    </div>
    <?php if ($_GET['ver'] != 'todos') { ?>
        <a href="?sec=eventos.admin&amp;ver=todos" style="color:#0682B8;">Ver Todos</a> -
    <?php } else { ?>
        <a href="?sec=eventos.admin" style="color:#0682B8;">Ver solo actualmente publicados</a> -
    <?php } ?>
    <a href="#" onclick="return descargarevs()" style="color:#0682B8;">Descargar</a>
    <script type="text/javascript">
    <!--
        var arrayIdxOrden = new Array();
<?php
$contnrodeid = 0;


$result1 = mysqli_query($coneccion,'SELECT * FROM inscribite_eventos ORDER BY orden ');

while ($row1 = mysqli_fetch_array($result1)) {
    $contnrodeid++;
    ?>
            arrayIdxOrden[<?= $contnrodeid ?>] = <?= $row1['id'] ?>;
<?php } ?>
        function descargarevs() {
            var inputs = document.getElementsByTagName('input');
            idsparad = '';
            for (var i = 0; i < inputs.length; i++) {
                if ((inputs[i].classname = 'paradescargar') && (inputs[i].checked))
                    idsparad += inputs[i].value + ', ';
            }
            if (idsparad != '')
                location.href = 'excelinscompleto.php?eventos=' + idsparad;
            return false;
        }
    -->
    </script>
</div>
<form action="guardarordenes" method="post">
    <div>
        <input type="hidden" name="tabla" value="inscribite_eventos"/>
        <input type="hidden" name="volvera" value="eventos.admin"/>
        <table>
            <tr>
<?php /* 					<th style="text-align:left;width:38px;">Nro</th> */ ?>
                <th>Cód.</th>
                <th>Ver</th>
                <th>Evento</th>
                <th><acronym title="Duplicar evento y sus categorias"><img src="images/duplicar.jpg" alt="Duplicar" style="margin:0px 0px 2px 3px;"/></acronym></th>
            <th>Tipo</th>
            <th>Empresa</th>
            <th style="width:100px;">Categorías</th>
            <th colspan="3">Inscripciones</th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
            </tr>
            <?php
            $contnrodeid = 0;
            if ($_GET['tipo'] != '')
                $filtroportipo = ' AND tipo="' . $_GET['tipo'] . '"';
            $filtrover = '';
            if ($_GET['ver'] != 'todos')
                $filtrover = ' AND ver = 1';

            if (isset($_GET['evento'])) {
                $evento_id = addslashes(filter_input(INPUT_GET, 'evento'));
                $result1 = mysqli_query($coneccion,'SELECT * FROM inscribite_eventos WHERE id > 0 AND codigo = ' . $evento_id);
            } else {
                $result1 = mysqli_query($coneccion,'SELECT * FROM inscribite_eventos WHERE id > 0' . $filtroportipo . $filtrover . ' ORDER BY orden ');
            }
            while ($row1 = mysqli_fetch_array($result1)) {
                $contnrodeid++;
                $result2 = mysqli_query($coneccion,'SELECT * FROM empresa WHERE emp_nombre= LOWER("' . $row1['empresa'] . '") LIMIT 1 ');
                $row2 = mysqli_fetch_array($result2)
                ?>
                <tr>
                    <?php /* 					<td>
                      <div id="contorden<?=$contnrodeid?>_1">
                      <input type="hidden" name="orden<?=$row1['id']?>" id="orden<?=$row1['id']?>" value="<?=$contnrodeid?>"/>
                      <a href="?sec=eventos.editar&amp;editando=<?=$row1['id']?>" style="float:left;clear:none;margin-top:2px;margin-right:6px;"><?=substr("0".$row1[orden],-2,2)?></a>
                      <span style="float:left;clear:none;width:6px;">
                      <a href="javascript:subirorden(<?=$row1['id']?>);" title="Subir Orden" style="margin:0px;"><img src="images/s_asc.png" alt="Subir Orden" style="float:left;margin:0px;"/></a>
                      <a href="javascript:bajarorden(<?=$row1['id']?>);" title="Bajar Orden" style="margin:0px;"><img src="images/s_desc.png" alt="Bajar Orden" style="float:left;margin:0px;"/></a>
                      </span>
                      </div>
                      </td> */ ?>
                    <td>
                        <div id="contorden<?= $contnrodeid ?>_2">
                            <a href="?sec=eventos.editar&amp;editando=<?= $row1['id'] ?>"><?= $row1['codigo'] ?></a>
                        </div>
                    </td>
                    <td>
                        <div id="contorden<?= $contnrodeid ?>_3">
                            <a href="cambiacheck.php?tabla=inscribite_eventos&amp;campo=ver&amp;id=<?= $row1['id'] ?>&amp;volvera=eventos.admin" onclick="cmbcheck(this.parentNode, 'inscribite_eventos', 'ver',<?= $row1['id'] ?>, '<?= $_GET['sec'] ?>');return false" title="Cambiar">
                                <img src="images/<?= ($row1['ver'] == 1) ? 'checkboxchecked.gif' : 'checkbox.gif' ?>" alt="" style="margin-top:0px;"/>
                            </a>
                        </div>
                    </td>
                    <td>
                        <div id="contorden<?= $contnrodeid ?>_4">
                            <a href="?sec=eventos.editar&amp;editando=<?= $row1['id'] ?>"><?= $row1['nombre'] ?></a>
                        </div>
                    </td>
                    <td>
                        <div id="contorden<?= $contnrodeid ?>_5">
                            <a href="#" onclick="javascript:confirm_dupli('<?= $row1['nombre'] ?>',<?= $row1['id'] ?>)" title="Duplicar evento y sus categorias"><img src="images/duplicar.jpg" alt="Duplicar"/></a>
                        </div>
                    </td>
                    <td>
                        <div id="contorden<?= $contnrodeid ?>_6">
                            <a href="?sec=eventos.editar&amp;editando=<?= $row1['id'] ?>"><?= $row1['tipo'] ?></a>
                        </div>
                    </td>
                    <td>
                        <div id="contorden<?= $contnrodeid ?>_7">
    <?= $row1['empresa'] ?> <a href="?sec=empresas.editar&amp;editando=<?= $row2['emp_id'] ?>">(Ver)</a>
                        </div>
                    </td>
                    <td>
                        <div id="contorden<?= $contnrodeid ?>_8">
                            <a href="?sec=categorias.admin&amp;evento=<?= $row1['codigo'] ?>" style="font-family:monospace;cursor:pointer;">
                                <span style="float:left;cursor:pointer;"> <?= mysqli_num_rows(mysqli_query($coneccion,'SELECT * FROM inscribite_categorias WHERE deevento = "' . $row1['codigo'] . '"')) ?>
                                    <span style="font-weight:bold;font-family:arial;margin-left:3px;cursor:pointer;">Ver</span>
                                </span>
                            </a>
                            <a href="?sec=categorias.agregar&amp;evento=<?= $row1['codigo'] ?>" style="float:right;clear:none;">Nueva</a>
                        </div>
                    </td>
                    <td style="text-align:left;">
                        <div id="contorden<?= $contnrodeid ?>_9">
                            <a href="?sec=inscripciones.admin&amp;evento=<?= $row1['codigo'] ?>" style="font-family:monospace;cursor:pointer;">
    <?php /* =agcnbsp(mysqli_num_rows(mysqli_query($coneccion,'SELECT * FROM inscribite_inscripciones WHERE deevento = "'.$row1['codigo'].'"')),4) */ ?>
    <?= mysqli_num_rows(mysqli_query($coneccion,'SELECT * FROM inscribite_inscripciones WHERE deevento = "' . $row1['codigo'] . '"')) ?>
                            </a>
                        </div>
                    </td>
                    <td style="text-align:right;">
                        <div id="contorden<?= $contnrodeid ?>_10">
                            <a href="?sec=inscripciones.admin&amp;evento=<?= $row1['codigo'] ?>" style="font-family:monospace;cursor:pointer;">
                                (<?= mysqli_num_rows(mysqli_query($coneccion,'SELECT * FROM inscribite_inscripciones WHERE deevento = "' . $row1['codigo'] . '" AND pagado = 1 ')) ?>)
    <?php /* 							(<?=mysqli_num_rows(mysqli_query($coneccion,'SELECT * FROM inscribite_inscripciones WHERE deevento = "'.$row1['codigo'].'" AND pagado = 1 AND iniciadoeldia != "0000-00-00" '))?>) */ ?>
                            </a>
                        </div>
                    </td>
                    <td>
                        <div id="contorden<?= $contnrodeid ?>_11">
                            <a href="?sec=inscripciones.admin&amp;evento=<?= $row1['codigo'] ?>" style="font-family:monospace;cursor:pointer;">Ver</a>
                        </div>
                    </td>
                    <td>
                        <div id="contorden<?= $contnrodeid ?>_12">
                            <a href="javascript:confirm_entry('<?= $row1['nombre'] ?>', 'eventos.admin', 'inscribite_eventos',<?= $row1['id'] ?>)"><img src="images/deletex.gif" alt="Eliminar"/></a>
                        </div>
                    </td>
                    <td>
                        <input type="checkbox" name="paradescargar" class="paradescargar" value="<?= $row1['id'] ?>" style="float:left;margin:6px 0px 0px 0px;"/>
                    </td>
                </tr>
<?php } ?>
        </table>
<?php /* 			<input type="submit" value="Guardar Ordenes" style="width:150px;margin-top:20px;background:white;border:1px #666 solid;height:25px;color:#666666;cursor:pointer;"/> */ ?>
    </div>
</form>
<script type="text/javascript">
<!--
    ultcolortr = 'transparent';
    var inputs = document.getElementsByTagName("tr");
    for (var i = 0; i < inputs.length; i++) {
        inputs[i].onmouseover = function () {
            ultcolortr = this.style.backgroundColor;
            this.style.backgroundColor = '#d1e9f4';
        }
        inputs[i].onmouseout = function () {
            this.style.backgroundColor = ultcolortr
        };
    }
-->
</script>