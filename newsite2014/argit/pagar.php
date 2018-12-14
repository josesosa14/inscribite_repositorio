<?php
$pagar = "blue";
?>
<?php
require_once dirname(__FILE__) . '/general/header.php';


//info del usuario
$query = "SELECT *,TIMESTAMPDIFF(YEAR,CONCAT(SUBSTRING((CONVERT(fechanac,CHAR(4))),1,4),'-',
                    SUBSTRING((CONVERT(fechanac,CHAR(6))),5,5),'-',
                    SUBSTRING((CONVERT(fechanac,CHAR(8))),7,7)),CURDATE()) as edad 
            FROM inscribite_usuarios WHERE dni=$usuario";
$user_info = getRowQuery($query, $mysqli);

?>
<script src="../js/mainNew.js"></script>
<script>
    $(function() {
        $("#tabs").tabs();
    });
</script>
</div>
<div class="titular row">
    <div class="title col-sm-9">
        <img src="../images/icon-pay.png" alt=""/><br>
        <h3>Eleg&iacute;, imprim&iacute; y despu&eacute;s pag&aacute;</h3>
    </div>
    <div class="col-sm-3"><?php
        if (!$usuario) {
            echo 'No est&aacute; logeado, ingrese con DNI';
        } else {
            echo '<span class="btn">' . $user_info['nombre'] . ' ' . $user_info['apellido'] . '</span>
                    <a href="' . $general_path . 'modificaUsuario.php?user_id=' . $user_info['id'] . '#toShow">Ver / Cambiar mis datos</a>
                    <a href="' . $general_path . 'logout.php">Cambiar usuario/Cerrar sesi&oacute;n</a>';
        }
        ?>
    </div>
</div>

<div id="tabs">
    <div class="columns-container row" id="toShow">
        <div class="col-xs-12">
            <div class="row">
                <ul>
                    <li>
                        <div class="col-sm-3 col-wrap">
                            <a href="<?= $general_path ?>pagar.php#Deportivos" class="col category">
                                EVENTOS
                                <br/>
                                DEPORTIVOS
                            </a>
                        </div>
                    </li>
                    <li>
                        <div class="col-sm-3 col-wrap">
                            <a href="<?= $general_path ?>pagar.php#Capacitacion" class="col category">
                                EVENTOS
                                <br/>
                                DE CAPACITACIÓN
                            </a>
                        </div>
                    </li>
                    <li>
                        <div class="col-sm-3 col-wrap">
                            <a href="<?= $general_path ?>pagar.php#Servicios" class="col category">
                                SERVICIO Y
                                <br/>
                                MENSUALIDADES
                            </a>
                        </div>
                    </li>
                    <li>
                        <div class="col-sm-3 col-wrap">
                            <a href="<?= $general_path ?>pagar.php#Productos" class="col category">
                                COMPRA DE
                                <br/>
                                PRODUCTOS
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>







    <?php
    //$query = "SELECT * FROM  inscribite_eventos WHERE ver=1 $empresa ORDER BY fechaord, nombre ";
    $query = "SELECT * FROM  inscribite_eventos WHERE ver=1 ORDER BY tipo DESC,fechaord,nombre";

    $eventos_todo = getArrayQuery($query, $mysqli);
	
	$query = "SELECT * FROM mensualidades INNER JOIN empresa ON emp_id = men_empresa WHERE men_activo = 1 ORDER BY men_id";
	$mensualidades = getArrayQuery($query,$mysqli);
	


    foreach ($eventos_todo as $item) {
		$tipo=str_replace('ó','o',$item["tipo"]);
        $tipo_eventos[$tipo][] = $item;
    }

    $cont = 0;

    if ($tipo_eventos) {
		$mostro_mensualidades = false;
        foreach ($tipo_eventos as $tipo_evento => $eventos) {
            echo '<div id="' . $tipo_evento . '">';
            ?>
            <div class="panel-group accordion" >

                <table class="table">
                    <thead>
                        <tr>
                            <?php
                            if ($tipo_evento != "Servicios") {
                                echo '<th class="col-date">FECHA</th>';
                            }
                            ?>
                            <th class="col-event">EVENTO</th>
                            <th class="col-id">ID</th>
                            <th class="col-org">ORGANIZADOR</th>
                            <th class="col-actions">ACCIONES</th>
                        </tr>
                    </thead> 
                </table> 
                <?php
                foreach ($eventos as $evento) {
                    $cont++;
                    ?>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <?php if (!empty($evento['fecha'])) { ?>
                                            <td class="col-date"><?php echo $evento['fecha']; ?></td>
            <?php } ?>	
                                        <td class="col-event"><?php echo $evento['nombre']; ?></td>
                                        <td class="col-id"><?php echo $evento['codigo']; ?></td>
                                        <td class="col-org"><?php echo strtoupper($evento['empresa']); ?></td>
                                        <td class="col-actions">
                                            <a href="<?= $general_path ?>iniciainscripccion.php?evento=<?php echo $evento['codigo']; ?>#toShow" class="icon-go"></a>
                                            <a data-toggle="collapse" data-parent="#accordion" href="#evento-<?php echo $cont; ?>" class="icon control collapsed"></a>
                                        </td>
                                    </tr>
                                </tbody>   
                            </table>
                        </div>
                        <div id="evento-<?php echo $cont; ?>" class="panel-collapse collapse">
                            <div class="panel-body">
                                <div class="col-xs-12">
                                    <div class="pic">
                                        <a href="<?= $general_path ?>iniciainscripccion.php?evento=<?php echo $evento['codigo']; ?>#toShow">
                                            <?php
                                            if (isset($evento['imagen1']) && !empty($evento['imagen1'])) {
                                                $file = '../imagenes/image_' . $evento['imagen1'];
                                                if (file_exists($file)) {
                                                    echo '<img src="../imagenes/image_' . $evento['imagen1'] . '" alt="" class="img-responsive" style="width: 100%;height: 100%;" />';
                                                } else {
                                                    echo '<img src="../images/logo-default.png" alt="" class="img-responsive" />';
                                                }
                                            } else {
                                                echo '<img src="../images/logo-default.png" alt="" class="img-responsive" />';
                                            }
                                            ?>
                                            <img src="../images/img-hover.png" alt="" class="img-hover" />
                                        </a>
                                    </div>
                                    <span class="date"><?php echo $evento['fecha']; ?></span>
                                    <span class="title"><?php echo $evento['nombre']; ?> - COD <?php echo $evento['codigo']; ?> <span class="organizador">Organizador: <?php echo $evento['empresa']; ?></span></span>

                                    <ul>
                                        <li><?php echo $evento['descripcion']; ?></li>
										<?php if($evento['mostrarcinscriptos']){
											echo '<li><a href="http://www.inscribiteonline.com.ar/competidoresinscriptos.php?evento='.$evento['codigo'].'" >ver inscriptos</a></li>';
										}
										?>
										
										

                                    </ul>
                                    <div class="actions"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                }
				if($tipo_evento == 'Servicios'){
					foreach ($mensualidades as $evento) {
						$cont++;
						?>
						<div class="panel panel-default">
							<div class="panel-heading" id="heading-hover">
								<table class="table">
									<tbody>
										<tr>
											<td class="col-event"><?php echo $evento['men_nombre']; ?></td>
											<td class="col-id"><?php echo $evento['men_codigo']; ?></td>
											<td class="col-org"><?php echo strtoupper($evento['emp_nombre']); ?></td>
											<td class="col-actions">
												<a href="<?= $general_path ?>aceptaMensualidad.php?men_id=<?php echo $evento['men_id']; ?>#toShow" class="icon-go"></a>
												<a data-toggle="collapse" data-parent="#accordion" href="#evento-<?php echo $cont; ?>" class="icon control collapsed"></a>
											</td>
										</tr>
									</tbody>   
								</table>
							</div>
							<div id="evento-<?php echo $cont; ?>" class="panel-collapse collapse">
								<div class="panel-body">
									<div class="col-xs-12">
										<div class="pic">
											<a href="<?= $general_path ?>aceptaMensualidad.php?men_id=<?php echo $evento['men_id']; ?>#toShow">
												<?php
												if (isset($evento['men_id'])) {
													if (file_exists($file)) {
														echo '<img src="../imagenes/' . $evento['men_imagen'].'" alt="" class="img-responsive" style="width: 100%;height: 100%;" />';
													} else {
														echo '<img src="../images/logo-default.png" alt="" class="img-responsive" />';
													}
												} else {
													echo '<img src="../images/logo-default.png" alt="" class="img-responsive" />';
												}
												?>
												<img src="../images/img-hover.png" alt="" class="img-hover" />
											</a>
										</div>
										<span class="date"><?php echo $evento['fecha']; ?></span>
										<span class="title"><?php echo $evento['men_nombre']; ?> - COD <?php echo $evento['men_codigo']; ?> <span class="organizador">Organizador: <?php echo $evento['emp_nombre']; ?></span></span>
										<ul>
                                        <li><?php echo $evento['men_descripcion']; ?></li>
										</ul>
										<div class="actions"></div>
									</div>
								</div>
							</div>
						</div>

						<?php
					}
				}
                echo '</div> </div>';
            }


        } else {
            echo 'No hay eventos de tipo ' . $tipo;
        }
        ?>


    </div>

    <?php include_once dirname(__FILE__) . '/general/banners.php'; ?>

<?php include_once dirname(__FILE__) . '/general/footer.php'; ?>					