<?php
$miCuenta = "blue";
require_once dirname(__FILE__) . '/general/header.php';

if (!isset($_SESSION['usuario'])) {
    header('Location:' . $general_path . 'login.php');
}
?>
</div>

<?php if (isset($_SESSION['usuario']) && $_SESSION['usuario'] == '36791591'): ?>
    <script src="../js/mainNew.js"></script>
<?php endif; ?>

<?php
//get variables
global $usuario;

//info del evento
$query = "SELECT * FROM inscribite_usuarios WHERE id = '{$_SESSION['user_id']}'";
$user_info = getRowQuery($query, $mysqli);

$query = "SET SQL_BIG_SELECTS=1";
runQuery($query, $mysqli);

//info de las categorias
$query = "  SELECT e.nombre evento_nombre,e.descripcion evento_descripcion, e.fecha evento_fecha,e.codigo evento_codigo, e.id evento_id,e.imagen1 evento_imagen1,i.pagado evento_pagado,e.empresa evento_empresa,
            i.precio inscripcion_precio,i.categoria inscripcion_categoria,i.opcion inscripcion_opcion,i.iniciadoeldia inscripcion_fecha,i.id,i.pmc inscripcion_pmc,c.codigo cat_codigo,
            i.mes inscripcion_mes,i.respuestapart1 inscripcion_respuesta1,i.respuestapart2 inscripcion_respuesta2,i.respuestapart3 inscripcion_respuesta3,e.tipo evento_tipo,i.mes mes
            FROM inscribite_inscripciones i
            INNER JOIN inscribite_eventos e ON e.codigo = i.deevento
			INNER JOIN inscribite_categorias c ON c.deevento = i.deevento AND c.nombre = i.categoria 
            WHERE i.deusuario = '{$_SESSION['usuario']}'
            GROUP BY i.id
            ";

$inscripciones = getArrayQuery($query, $mysqli);
?>

<div class="titular row">
    <div class="title col-sm-9">
        <img src="../images/icon-user.png" alt=""/>
        <h2>Mi cuenta</h2>
        <h3>Administr&aacute; tus inscripciones</h3>
    </div>
    <div class="col-sm-3">
        <?php
        echo '<span class="btn">' . $user_info['nombre'] . ' ' . $user_info['apellido'] . '</span>
            <a href="' . $general_path . 'modificaUsuario.php?user_id=' . $user_info['id'] . '">Ver / Cambiar mis datos</a>
            <a href="' . $general_path . 'logout.php">Cambiar Usuario</a>';
        ?>
    </div>
</div>

<div class="clear"></div>
<br>

<?php if ($_SESSION['usuario'] == '36791591'): ?>

    <?php
    if ($inscripciones):
        $cont_pro = 0;
        $cont_cap = 0;
        $cont_ins = 0;
        $cont_serv = 0;
        $cont = 0;
        ?>

        <div class = "columns-container row">
            <div class = "col-sm-9">
                <h3>Mis inscripciones</h3>
                <p class = "small" style = "margin-bottom: 25px;">
                    A continuaci&oacute;n podr&aacute;s encontrar un listado con todas tus inscripciones.
                    <br/>
                    Aquellas que ya abonaste, las que no o las que deseas eliminar de tu listado.
                </p>
                <div class = "panel-group accordion inscriptions" id = "accordion-events">

                    <?php
                    foreach ($inscripciones as $inscripcion) {
                        //if ($inscripcion['evento_tipo'] == 'Deportivos') {
                        ?>


                        <?php if ($cont == 0): ?>

                            <table class = "table">
                                <thead>
                                    <tr>
                                        <th class = "col-status">ESTADO</th>
                                        <th class = "col-date">FECHA</th>
                                        <th class = "col-event">EVENTO</th>
                                        <th class = "col-actions">ACCIONES</th>
                                    </tr>
                                </thead>
                            </table>
                            <?php
                        endif;
                        $cont_ins++;
                        $cont++;
                        ?>
                        <div class = "panel panel-default">
                            <div class = "panel-heading">
                                <table class = "table">
                                    <tbody>
                                        <tr>
                                            <?php if ($inscripcion['evento_pagado'] == 1) { ?>
                                                <td class = "col-status green"><img src = "../images/icon-status-green.png" alt = "" />PAGADO</td>
                                            <?php } else { ?>
                                                <td class = "col-status red"><img src = "../images/icon-status-red.png" alt = "" />PAGADO</td>
                                            <?php } ?>
                                            <td class = "col-date"><?php echo $inscripcion['evento_fecha']; ?></td>
                                            <td class = "col-event"><?php echo $inscripcion['evento_nombre']; ?></td>
                                            <td class = "col-actions">
                                                <a href = "/../miCuenta.php" class = "icon status-<?= ($inscripcion['evento_pagado']) ? 'green' : 'red' ?> pull-right" style = "display: none"><img src = "../images/icon-status-<?= ($inscripcion['evento_pagado']) ? 'green' : 'red' ?>-big.png" alt = "" /></a>
                                                <?php if ($inscripcion['evento_pagado'] != 1) { ?>
                                                    <a href="<?= $general_path . '' . $inscripcion['id'] . '/' . $user_info['dni'] ?>" title='cancelar inscripcion' class="btCancel icon pull-right delete"><img src = "../images/icon-delete.png" alt = "" /></a>
                                                <?php } ?>
                                                <?php if ($inscripcion['inscripcion_pmc'] != 1) { ?>
                                                    <a target="_blank" href="../imprimircupon.php?evento=<?= $inscripcion['evento_codigo'] . '&mes=' . $inscripcion['inscripcion_mes'] . '&cod=' . $inscripcion['cat_codigo'] . '&cat=' . $inscripcion['inscripcion_categoria'] . '&opcion=' . $inscripcion['inscripcion_opcion'] . '&respuesta1=' . $inscripcion['inscripcion_respuesta1'] . '&respuesta2=' . $inscripcion['inscripcion_respuesta2'] . '&respuesta3=' . $inscripcion['inscripcion_respuesta3'] ?>" class = "icon pull-right tag" title='imprimir cupon' ><img src = "../images/icon-tag.png" alt = "" /></a>
                                                <?php } ?>
                                                <a data-toggle = "collapse" data-parent = "#accordion" href = "#evento-<?= $cont ?>" class = "icon control collapsed"></a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div id = "evento-<?= $cont ?>" class = "panel-collapse collapse">
                                <div class = "panel-body">
                                    <div class = "col-xs-12">
                                        <span class = "date"><?php echo $inscripcion['evento_fecha']; ?></span>
                                        <span class = "title"><?php echo $inscripcion['evento_nombre']; ?> - COD <?php echo $inscripcion['evento_codigo']; ?> <span class = "organizador">Organizador: <?php echo $inscripcion['evento_empresa']; ?></span></span>

                                        <ul>
                                            <li><?php echo $inscripcion['evento_descripcion']; ?></li>
                                        </ul>
                                        <div class = "actions"></div>
                                    </div>
                                </div>
                            </div>
                        </div>                

                        <?php
                        //}
                    }
                    ?>
                </div>

            </div>        



            <div class="col-sm-3 col-wrap">
                <div class="col gray">
                    <a href="http://www.epsa.org.ar/promo/"> <img  src="../images/banner_guardavidas.jpg" /></a>
                </div>
            </div>
        </div>
    <?php endif;
    ?>

<?php else: ?>
    <div class="columns-container row" id="toShow">
        <div class="panel-group" id="accordion">
            <?php
            $cont_pro = 0;
            $cont_cap = 0;
            $cont_ins = 0;
            $cont_serv = 0;
            $cont = 0;
            if ($inscripciones) {

                foreach ($inscripciones as $inscripcion) {
                    if ($inscripcion['evento_tipo'] == 'Deportivos') {
                        if ($cont_ins == 0) {
                            echo '<h3>Mis Inscripciones:</h3>';
                        }
                        echo '<div>';
                        $cont_ins++;
                        $cont++;
                        ?>
                        <div class="panel panel-default" >
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-sm-10">
                                        <div class="pic">
                                            <?php
                                            if (isset($evento['evento_imagen1']) && !empty($inscripcion['evento_imagen1'])) {
                                                $file = '../imagenes/image_' . $inscripcion['evento_imagen1'];
                                                if (file_exists($file)) {
                                                    echo '<img src="../imagenes/image_' . $inscripcion['evento_imagen1'] . '" alt="" class="img-responsive" />';
                                                } else {
                                                    echo '<img src="../images/logo-default.png" alt="" class="img-responsive" />';
                                                }
                                            } else {
                                                echo '<img src="../images/logo-default.png" alt="" class="img-responsive" />';
                                            }
                                            ?>
                                            <img src="../images/img-hover.png" alt="" class="img-hover" />
                                        </div>
                                        <span class="date"><?php echo $inscripcion['evento_fecha']; ?></span>
                                        <span class="title"><?php echo $inscripcion['evento_nombre'] . '-' . $inscripcion['evento_codigo']; ?> 
                                            <span class="organizador"><?= '<span class="date">Opcion: </span>' . $inscripcion['inscripcion_opcion'] ?></span>
                                            <span class="organizador"><?= '<span class="date">Categoria: </span>' . $inscripcion['inscripcion_categoria'] ?></span>
                                            <?php
                                            if ($inscripcion['inscripcion_precio']) {
                                                echo '<span> <span class="date">A pagar: </span>$' . $inscripcion['inscripcion_precio'] . '</span>';
                                            }
                                            ?>
                                            <span class="organizador"><?= '<span class="date">Empresa: </span>' . $inscripcion['evento_empresa'] ?></span>
                                        </span>

                                        <div id="evento-<?php echo $cont; ?>" class="panel-collapse collapse">
                                            <ul>
                                                <li>Descripción: <?php echo $inscripcion['evento_descripcion']; ?></li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="col-sm-2">
                                        <?php
                                        if ($inscripcion['evento_pagado'] == 1) {
                                            echo '<span class="badge" style="background-color:green" >Pagado</span>';
                                        } else {
                                            echo '<a href="' . $general_path . '' . $inscripcion['id'] . '/' . $user_info['dni'] . '" class="btCancel"><span style="background-color:red" class="badge">Cancelar</span></a>';
                                            if ($inscripcion['inscripcion_pmc'] != 1) {
                                                echo '<a target="_blank" href="../imprimircupon.php?evento=' . $inscripcion['evento_codigo'] . '&mes=' . $inscripcion['inscripcion_mes'] . '&cod=' . $inscripcion['cat_codigo'] . '&cat=' . $inscripcion['inscripcion_categoria'] . '&opcion=' . $inscripcion['inscripcion_opcion'] . '&respuesta1=' . $inscripcion['inscripcion_respuesta1'] . '&respuesta2=' . $inscripcion['inscripcion_respuesta2'] . '&respuesta3=' . $inscripcion['inscripcion_respuesta3'] . '" ><span style="background-color:green" title="Reimprimir cup&oacute;n" class="badge">Cupon</span></a>';
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        echo '</div>';
                    }
                }




                foreach ($inscripciones as $inscripcion) {
                    if ($inscripcion['evento_tipo'] == 'Capacitación') {
                        if ($cont_cap == 0) {
                            echo '<h3>Mis Capacitaciones:</h3>';
                        }
                        echo '<div>';
                        $cont_cap++;
                        $cont++;
                        ?>
                        <div class="panel panel-default" >
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-sm-10">
                                        <div class="pic">
                                            <?php
                                            if (isset($evento['evento_imagen1']) && !empty($inscripcion['evento_imagen1'])) {
                                                $file = '../imagenes/image_' . $inscripcion['evento_imagen1'];
                                                if (file_exists($file)) {
                                                    echo '<img src="../imagenes/image_' . $inscripcion['evento_imagen1'] . '" alt="" class="img-responsive" />';
                                                } else {
                                                    echo '<img src="../images/logo-default.png" alt="" class="img-responsive" />';
                                                }
                                            } else {
                                                echo '<img src="../images/logo-default.png" alt="" class="img-responsive" />';
                                            }
                                            ?>
                                            <img src="../images/img-hover.png" alt="" class="img-hover" />
                                        </div>
                                        <span class="date"><?php echo $inscripcion['evento_fecha']; ?></span>
                                        <span class="title"><?php echo $inscripcion['evento_nombre'] . '-' . $inscripcion['evento_codigo']; ?> 
                                            <span class="organizador"><?= '<span class="date">Opcion: </span>' . $inscripcion['inscripcion_opcion'] ?></span>
                                            <span class="organizador"><?= '<span class="date">Categoria: </span>' . $inscripcion['inscripcion_categoria'] ?></span>
                                            <?php
                                            if ($inscripcion['inscripcion_precio']) {
                                                echo '<span> <span class="date">A pagar: </span>$' . $inscripcion['inscripcion_precio'] . '</span>';
                                            }
                                            ?>
                                            <span class="organizador"><?= '<span class="date">Empresa: </span>' . $inscripcion['evento_empresa'] ?></span>
                                        </span>

                                        <div id="evento-<?php echo $cont; ?>" class="panel-collapse collapse">
                                            <ul>
                                                <li>Descripción: <?php echo $inscripcion['evento_descripcion']; ?></li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="col-sm-2">
                                        <?php
                                        if ($inscripcion['evento_pagado'] == 1) {
                                            echo '<span class="badge" style="background-color:green" >Pagado</span>';
                                        } else {
                                            echo '<a href="' . $general_path . '' . $inscripcion['id'] . '/' . $user_info['dni'] . '" class="btCancel"><span style="background-color:red" class="badge">Cancelar</span></a>';
                                            if ($inscripcion['inscripcion_pmc'] != 1) {
                                                echo '<a target="_blank" href="../imprimircupon.php?evento=' . $inscripcion['evento_codigo'] . '&mes=' . $inscripcion['inscripcion_mes'] . '&cod=' . $inscripcion['cat_codigo'] . '&cat=' . $inscripcion['inscripcion_categoria'] . '&opcion=' . $inscripcion['inscripcion_opcion'] . '&respuesta1=' . $inscripcion['inscripcion_respuesta1'] . '&respuesta2=' . $inscripcion['inscripcion_respuesta2'] . '&respuesta3=' . $inscripcion['inscripcion_respuesta3'] . '" ><span style="background-color:green" class="badge">Cupon</span></a>';
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        echo '</div>';
                    }
                }



                foreach ($inscripciones as $inscripcion) {
                    if ($inscripcion['evento_tipo'] == 'Productos') {

                        if ($cont_pro == 0) {
                            echo '<h3>Mis Productos:</h3>';
                        }
                        echo '<div>';
                        $cont_pro++;
                        $cont++;
                        ?>
                        <div class="panel panel-default" >
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-sm-10">
                                        <div class="pic">
                                            <?php
                                            if (isset($evento['evento_imagen1']) && !empty($inscripcion['evento_imagen1'])) {
                                                $file = '../imagenes/image_' . $inscripcion['evento_imagen1'];
                                                if (file_exists($file)) {
                                                    echo '<img src="../imagenes/image_' . $inscripcion['evento_imagen1'] . '" alt="" class="img-responsive" />';
                                                } else {
                                                    echo '<img src="../images/logo-default.png" alt="" class="img-responsive" />';
                                                }
                                            } else {
                                                echo '<img src="../images/logo-default.png" alt="" class="img-responsive" />';
                                            }
                                            ?>
                                            <img src="../images/img-hover.png" alt="" class="img-hover" />
                                        </div>
                                        <span class="date"><?php echo $inscripcion['evento_fecha']; ?></span>
                                        <span class="title"><?php echo $inscripcion['evento_nombre'] . '-' . $inscripcion['evento_codigo']; ?> 
                                            <span class="organizador"><?= '<span class="date">Opcion: </span>' . $inscripcion['inscripcion_opcion'] ?></span>
                                            <span class="organizador"><?= '<span class="date">Categoria: </span>' . $inscripcion['inscripcion_categoria'] ?></span>
                                            <?php
                                            if ($inscripcion['inscripcion_precio']) {
                                                echo '<span> <span class="date">A pagar: </span>$' . $inscripcion['inscripcion_precio'] . '</span>';
                                            }
                                            ?>
                                            <span class="organizador"><?= '<span class="date">Empresa: </span>' . $inscripcion['evento_empresa'] ?></span>
                                        </span>

                                        <div id="evento-<?php echo $cont; ?>" class="panel-collapse collapse">
                                            <ul>
                                                <li>Descripción: <?php echo $inscripcion['evento_descripcion']; ?></li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="col-sm-2">
                                        <?php
                                        if ($inscripcion['evento_pagado'] == 1) {
                                            echo '<span class="badge" style="background-color:green" >Pagado</span>';
                                        } else {
                                            echo '<a href="' . $general_path . '' . $inscripcion['id'] . '/' . $user_info['dni'] . '" class="btCancel"><span style="background-color:red" class="badge">Cancelar</span></a>';
                                            if ($inscripcion['inscripcion_pmc'] != 1) {
                                                echo '<a target="_blank" href="../imprimircupon.php?evento=' . $inscripcion['evento_codigo'] . '&mes=' . $inscripcion['inscripcion_mes'] . '&cod=' . $inscripcion['cat_codigo'] . '&cat=' . $inscripcion['inscripcion_categoria'] . '&opcion=' . $inscripcion['inscripcion_opcion'] . '&respuesta1=' . $inscripcion['inscripcion_respuesta1'] . '&respuesta2=' . $inscripcion['inscripcion_respuesta2'] . '&respuesta3=' . $inscripcion['inscripcion_respuesta3'] . '" ><span style="background-color:green" class="badge">Cupon</span></a>';
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        echo '</div>';
                    }
                }



                foreach ($inscripciones as $inscripcion) {
                    if ($inscripcion['evento_tipo'] == 'Servicios') {
                        if ($cont_serv == 0) {
                            echo '<h3>Mis Servicios:</h3>';
                        }
                        echo '<div>';
                        $cont_serv++;
                        $cont++;
                        ?>
                        <div class="panel panel-default" >
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-sm-10">
                                        <div class="pic">
                                            <?php
                                            if (isset($evento['evento_imagen1']) && !empty($inscripcion['evento_imagen1'])) {
                                                $file = '../imagenes/image_' . $inscripcion['evento_imagen1'];
                                                if (file_exists($file)) {
                                                    echo '<img src="../imagenes/image_' . $inscripcion['evento_imagen1'] . '" alt="" class="img-responsive" />';
                                                } else {
                                                    echo '<img src="../images/logo-default.png" alt="" class="img-responsive" />';
                                                }
                                            } else {
                                                echo '<img src="../images/logo-default.png" alt="" class="img-responsive" />';
                                            }
                                            ?>
                                            <img src="../images/img-hover.png" alt="" class="img-hover" />
                                        </div>
                                        <span class="date"><?php echo $inscripcion['evento_fecha']; ?></span>
                                        <span class="title"><?php echo $inscripcion['evento_nombre'] . '-' . $inscripcion['evento_codigo']; ?> 
                                            <span class="organizador"><?= '<span class="date">Fecha: </span>' . date('F Y', strtotime($inscripcion['mes'])) ?></span>
                                            <?php
                                            if ($inscripcion['inscripcion_precio']) {
                                                echo '<span> <span class="date">A pagar: </span>$' . $inscripcion['inscripcion_precio'] . '</span>';
                                            }
                                            ?>
                                            <span class="organizador"><?= '<span class="date">Empresa: </span>' . $inscripcion['evento_empresa'] ?></span>
                                        </span>

                                        <div id="evento-<?php echo $cont; ?>" class="panel-collapse collapse">
                                            <ul>
                                                <li>Descripción: <?php echo $inscripcion['evento_descripcion']; ?></li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="col-sm-2">
                                        <?php
                                        if ($inscripcion['evento_pagado'] == 1) {
                                            echo '<span class="badge" style="background-color:green" >Pagado</span>';
                                        } else {
                                            echo '<a href="' . $general_path . '' . $inscripcion['id'] . '/' . $user_info['dni'] . '" class="btCancel"><span style="background-color:red" class="badge">Cancelar</span></a>';
                                            if ($inscripcion['inscripcion_pmc'] != 1) {
                                                echo '<a target="_blank" href="../imprimircupon.php?evento=' . $inscripcion['evento_codigo'] . '&mes=' . $inscripcion['inscripcion_mes'] . '&cod=' . $inscripcion['cat_codigo'] . '&cat=' . $inscripcion['inscripcion_categoria'] . '&opcion=' . $inscripcion['inscripcion_opcion'] . '&respuesta1=' . $inscripcion['inscripcion_respuesta1'] . '&respuesta2=' . $inscripcion['inscripcion_respuesta2'] . '&respuesta3=' . $inscripcion['inscripcion_respuesta3'] . '" ><span style="background-color:green" class="badge">Cupon</span></a>';
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        echo '</div>';
                    }
                }
            } else {
                echo '<h3>No hay inscripciones</h3>';
            }
            ?>   
        </div>    
    </div>

<?php endif; ?>


<?php include_once dirname(__FILE__) . '/general/banners.php'; ?>
<script>

    $(".btCancel").click(function(event) {
        event.preventDefault();
        var dniUsuario = null;
        var idEvento = null;
        var datos = $(this).attr('href');
        var datosArray = datos.split('/');
        dniUsuario = datosArray[4];
        idEvento = datosArray[3];
        var urlCancelar = "<?PHP echo $general_path;?>newsite2014/cancelarinscri.php?id=" + idEvento + "&dni=" + dniUsuario;
        $('#btCancelar').attr('href', urlCancelar);
        $('.modalMessage').modal();
    });
</script>



<?php // ' . $general_path . '../cancelarinscri.php?id=' . $evento['id'] . '&dni=' . $user_info['dni'] . '      ?>
<!-- Modal -->
<div class="modal fade modalMessage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="alert">
                    <h2><span id="mensaje1">Está seguro que desea cancelar?</span></h2>
                    <h3><span id="mensaje2">Confirme su elección</span></h3>
                    <a href="#" id="btCancelar"><span style="background-color:red" class="badge">Cancelar mi Inscripción</span></a>
                    <a href="<?PHP echo $general_path;?>miCuenta.php" id="btSalir"><span class="badge" style="background-color:green">Salir</span></a>					
                </div>
                <center><p>Si surge algún problema, comunicate al (11) 4641-4423</p></center>
            </div>
        </div>
    </div>
</div><!-- /.modal -->

<?php include_once 'general/footer.php'; ?>