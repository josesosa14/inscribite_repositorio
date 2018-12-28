<?php
$miCuenta = "blue";
require_once dirname(__FILE__) . '/general/header.php';

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']<=0) {
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
            WHERE (i.deusuario = '{$_SESSION['usuario']}' OR i.deusuario = '0{$_SESSION['usuario']}')
            GROUP BY i.id ORDER BY i.id DESC
            ";

$inscripciones = getArrayQuery($query, $mysqli);

$query_datos_usuario = 'SELECT nombre,apellido from inscribite_usuarios where dni = ' . $_SESSION['usuario'];
$info_usuario = getArrayQuery($query_datos_usuario, $mysqli);
?>

<div class="titular row" id="toShow">
    <div class="title col-sm-9">
        <img src="../images/icon-user.png" alt=""/>
        <h2>Mi cuenta</h2>
        <h3>Administr&aacute; tus inscripciones</h3>
    </div>
    <div class="col-sm-3">
        <?php
        echo '<span class="btn">' . $user_info['nombre'] . ' ' . $user_info['apellido'] . '</span>
            <a href="' . $general_path . 'modificaUsuario.php?user_id=' . $user_info['id'] . '#toShow">Ver / Cambiar mis datos</a>
            <a href="' . $general_path . 'logout.php">Cambiar Usuario</a>';
        ?>
    </div>
</div>

<div class="clear"></div>
<br>

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
                <?php //print_r($info_usuario);?>
                <?php
                $title = strtoupper($info_usuario[0]['nombre']) . ' ' . strtoupper($info_usuario[0]['apellido']) . utf8_encode( 'concurrir� al evento ') . utf8_encode($inscripciones[0]['evento_nombre']) . ' el dia ' . utf8_encode($inscripciones[0]['evento_fecha']) . '.';
                //$descripcion = utf8_encode($inscripciones[0]['evento_descripcion']);
                $title_face = strtoupper($info_usuario[0]['nombre']) . ' ' . strtoupper($info_usuario[0]['apellido']) . utf8_encode(' concurrir� al evento ') . utf8_encode($inscripciones[0]['evento_nombre']) . ' el dia ' . utf8_encode($inscripciones[0]['evento_fecha']) . '.';
                $usuario_face = strtoupper($info_usuario[0]['nombre']) . ' ' . strtoupper($info_usuario[0]['apellido']);
                ?>
                <br>
                <span style="float:right;">Compart&iacute; tus &uacute;ltimos eventos: 
                <a href="<?PHP echo $general_path;?>" title="<?php echo $title; ?>"  class="tweet" target="_blank"><img src="<?PHP echo $general_path;?>newsite2014/imagenes/twitter_icon.png" width="25" height="25"></a>

                <script>
                    $('a.tweet').click(function(e) {

                        //We tell our browser not to follow that link
                        e.preventDefault();

                        //We get the URL of the link
                        var loc = $(this).attr('href');

                        //We get the title of the link
                        var title = escape($(this).attr('title'));

                        //We trigger a new window with the Twitter dialog, in the middle of the page
                        window.open('http://twitter.com/share?url=' + loc + '&text=' + title + '&', 'twitterwindow', 'height=450, width=550, top=' + ($(window).height() / 2 - 225) + ', left=' + $(window).width() / 2 + ', toolbar=0, location=0, menubar=0, directories=0, scrollbars=0');

                    });
                </script>

                <script type="text/javascript">
                    $(document).ready(function() {
                        $('#share_button').click(function(e) {
                            e.preventDefault();
                            FB.ui(
                                    {
                                        method: 'feed',
                                        name: '<?php echo $usuario_face. ' se anot&oacute; a un Evento en Inscribite Online. ';?>',
                                        link: '<?PHP echo $general_path;?>',
                                        picture: '<?PHP echo $general_path;?>newsite2014/images/logo.png',
                                        caption: '<?php echo $title_face;?>',
                                        description: 'Desde el 2006 somos la mejor forma de iniciar tu evento.  M&aacute;s de 200 empresas y productoras conf&iacute;an la inscripci&oacute;n de sus eventos en nuestro sistema',
                                        message: ''
                                    });
                        });
                    });
                </script>
                
                <img src = "<?PHP echo $general_path;?>newsite2014/imagenes/face_icon.png" id = "share_button" width="26" height="26" style="cursor: pointer;">
                </span>
                <br>
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
                                            <?php
                                        }
                                        else {
                                            ?>
                                            <td class = "col-status red"><img src = "../images/icon-status-red.png" alt = "" />SIN PAGAR</td>
                                        <?php } ?>
                                        <td class = "col-date"><?php echo $inscripcion['evento_fecha']; ?></td>
                                        <td class = "col-event"><?php echo $inscripcion['evento_nombre']; ?></td>
                                        <td class = "col-actions">

                                            <a href = "/../miCuenta.php" class = "icon status-<?= ($inscripcion['evento_pagado']) ? 'green' : 'red' ?> pull-right" style = "display: none"><img src = "../images/icon-status-<?= ($inscripcion['evento_pagado']) ? 'green' : 'red' ?>-big.png" alt = "" /></a>
                                            <?php if ($inscripcion['evento_pagado'] != 1) { ?>
                                                <a href="<? echo $general_path . '' . $inscripcion['id'] . '/' . $user_info['dni'] ?>" title='cancelar inscripcion' class="btCancel icon pull-right delete"><img src = "../images/icon-delete.png" alt = "" /></a>
                                            <?php } ?>
                                            <?php if ($inscripcion['inscripcion_pmc'] != 1 && $inscripcion['evento_pagado'] != 1) { ?>
                                                <a target="_blank" href="<? echo $general_path."imprimircupon.php?evento=". $inscripcion['evento_codigo'] . '&mes=' . $inscripcion['inscripcion_mes'] . '&cod=' . $inscripcion['cat_codigo'] . '&cat=' . $inscripcion['inscripcion_categoria'] . '&opcion=' . $inscripcion['inscripcion_opcion'] . '&respuesta1=' . $inscripcion['inscripcion_respuesta1'] . '&respuesta2=' . $inscripcion['inscripcion_respuesta2'] . '&respuesta3=' . $inscripcion['inscripcion_respuesta3'] ?>" class = "icon pull-right tag" title='imprimir cupon' ><img src = "../images/icon-tag.png" alt = "" /></a>
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



       

<?php endif; ?>


<?php
$query = "  SELECT mec_id,men_id,CONCAT(mec_nro_cuota,' (mes ',MONTH(mec_venc_1),')') mec_nro_cuota,men_descripcion,men_codigo,men_nombre,men_codigo,emp_nombre,MAX(meu_importe) meu_importe,MAX(meu_fecha) meu_fecha,CASE WHEN meuc.meu_id is not null THEN 1 ELSE 0 END as pagado,fac_tipo
            FROM inscribite_usuarios
            INNER JOIN (select * from facturas where fac_tipo <> 0 AND fac_anulado<>1) fac ON fac.fac_usu_id = id
			INNER JOIN mensualidad_cuotas ON mec_id = fac_mensualidad
			INNER JOIN mensualidades ON men_id = mec_men_id
			INNER JOIN empresa ON emp_id = men_empresa
			INNER JOIN mensualidad_usuario men_u ON men_u.meu_men_id = mec_men_id AND meu_u_dni = dni
			LEFT JOIN mensualidad_cuota_usuario meuc ON meuc.meu_mec_id = mec_id AND meuc.meu_u_dni = dni
            WHERE id = '{$_SESSION['user_id']}' and men_activo = 1
			GROUP BY mec_id,men_nombre,mec_nro_cuota,meu_mec_id,dni,nombre,apellido,emp_nombre
            ORDER BY men_id DESC
            ";
			
			
			
			

$mensualidades = getArrayQuery($query, $mysqli);

if ($mensualidades):
    $cont_pro = 0;
    $cont_cap = 0;
    $cont_ins = 0;
    $cont_serv = 0;
    $cont = 0;
    ?>
        <div class = "col-sm-9">
            <h3>Mis mensualidades</h3>
            <p class = "small" style = "margin-bottom: 25px;">
                A continuaci&oacute;n podr&aacute;s encontrar un listado con todas tus mensualidades.
                <br/>
                Aquellas que ya abonaste, las que no o las que deseas eliminar de tu listado.              
                <br>
            </p>

            <div class = "panel-group accordion inscriptions" id = "accordion-events">
                <?php
                foreach ($mensualidades as $mensualidad) {
                    ?>


                    <?php if ($cont == 0): ?>

                        <table class = "table">
                            <thead>
                                <tr>
                                    <th class = "col-status">ESTADO</th>
                                    <th class = "col-date">CUOTA</th>
                                    <th class = "col-event">MENSUALIDAD</th>
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
                                        <?php if ($mensualidad['pagado'] == 1) { ?>
                                            <td class = "col-status green"><img src = "../images/icon-status-green.png" alt = "" />PAGADO</td>
                                            <?php
                                        }
                                        else {
                                            ?>
                                            <td class = "col-status red"><img src = "../images/icon-status-red.png" alt = "" />SIN PAGAR</td>
                                        <?php } ?>
                                        <td class = "col-date"><?=$mensualidad['mec_nro_cuota']?></td>
                                        <td class = "col-event"><?php echo $mensualidad['men_nombre']; ?></td>
                                        <td class = "col-actions">

                                            <a href = "/../miCuenta.php" class = "icon status-<?= ($mensualidad['pagado']) ? 'green' : 'red' ?> pull-right" style = "display: none"><img src = "../images/icon-status-<?= ($mensualidad['pagado']) ? 'green' : 'red' ?>-big.png" alt = "" /></a>
                                            <?php if ($mensualidad['pagado'] != 1) { ?>
                                                <a href="/../cancelarInscripcion.php?mec_id=<?= $mensualidad['mec_id']?>" title='cancelar mensualidad' class="icon pull-right delete"><img src = "../images/icon-delete.png" alt = "" /></a>
                                            <?php } ?>
                                            <?php if ($mensualidad['fac_tipo'] != 1 && $mensualidad['pagado'] != 1) { 
												?>
                                                <a target="_blank" href="../cuponRP.php?tipo=<?= (($mensualidad['fac_tipo'] == 2)?'pf':'rp'). '&mec_id=' . $mensualidad['mec_id'] ?>" class = "icon pull-right tag" title='imprimir cupon' ><img src = "../images/icon-tag.png" alt = "" /></a>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                   </div>                

                    <?php
                    //}
                }
                ?>
            </div>

        </div>        

<?php endif; ?>

<div class="col-sm-3 col-wrap">
	<div class="col gray">
	<a href="http://www.epsa.org.ar/promo/"> <img  src="../images/banner_guardavidas.jpg" /></a>
	</div>
</div>
</div>

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
        var urlCancelar = "http://www.inscribiteonline.com.ar/newsite2014/cancelarinscri.php?id=" + idEvento + "&dni=" + dniUsuario;
        $('#btCancelar').attr('href', urlCancelar);
        $('.modalMessage').modal();
    });
</script>



<?php // ' . $general_path . '../cancelarinscri.php?id=' . $evento['id'] . '&dni=' . $user_info['dni'] . '          ?>
<!-- Modal -->
<div class="modal fade modalMessage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="alert">
                    <h2><span id="mensaje1">Está seguro que desea cancelar?</span></h2>
                    <h3><span id="mensaje2">Confirme su elección</span></h3>
                    <a href="#" id="btCancelar"><span style="background-color:red" class="badge">Cancelar mi Inscripción</span></a>
                    <a href="http://www.inscribiteonline.com.ar/miCuenta.php" id="btSalir"><span class="badge" style="background-color:green">Salir</span></a>					
                </div>
                <center><p>Si surge algún problema, comunicate al (11) 4641-4423</p></center>
            </div>
        </div>
    </div>
</div><!-- /.modal -->

<?php include_once 'general/footer.php'; ?>