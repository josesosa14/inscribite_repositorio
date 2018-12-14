<?php
$inscripcion = "blue";
$pagar = "blue";
require_once dirname(__FILE__) . '/general/header.php';
?>
</div>
<?php
//get variables
global $usuario;
$evento_id = addslashes(filter_var(filter_input(INPUT_GET, 'evento'), FILTER_SANITIZE_STRING));
$cod = addslashes(filter_var(filter_input(INPUT_GET, 'cod'), FILTER_SANITIZE_STRING));
$op_id = addslashes(filter_var(filter_input(INPUT_GET, 'opcion'), FILTER_SANITIZE_STRING));
$opcion_id = addslashes(filter_var(filter_input(INPUT_GET, 'opcion_id'), FILTER_SANITIZE_STRING));

//info del usuario
$query = "SELECT *,TIMESTAMPDIFF(YEAR,CONCAT(SUBSTRING((CONVERT(fechanac,CHAR(4))),1,4),'-',
	SUBSTRING((CONVERT(fechanac,CHAR(6))),5,5),'-',
	SUBSTRING((CONVERT(fechanac,CHAR(8))),7,7)),CURDATE()) as edad 
	FROM inscribite_usuarios WHERE dni=$usuario";
$user_info = getRowQuery($query, $mysqli);

//info del evento
$query = "SELECT * FROM inscribite_eventos WHERE codigo='$evento_id'";
$evento_info = getRowQuery($query, $mysqli);

//info de las categorias
$query = "SELECT  CONCAT(SUBSTRING((CONVERT(c.fechadecomputo,CHAR(4))),1,4),'-',SUBSTRING((CONVERT(c.fechadecomputo,CHAR(6))),5,5),'-',SUBSTRING((CONVERT(c.fechadecomputo,CHAR(8))),7,7)) as cat_fecha,
	c.nombre cat_nombre,CASE WHEN (o.cupo+o.cuporestante) < 0 THEN 0 ELSE (o.cupo+o.cuporestante) END cupo_restante,o.nombre op_nombre,c.descripcion cat_desc,c.sexo cat_sexo,c.precio1 cat_precio,c.codigo cat_codigo,o.id op_codigo,
	c.edadminima cat_minima,c.edadmaxima cat_maxima,c.fechavenc1,c.fechavenc2,c.fechavenc3,c.precio1,c.precio2,c.precio3
	FROM inscribite_categorias c
	INNER JOIN inscribite_opciones o ON o.evento = c.deevento AND o.nombre = c.opcion
	WHERE c.codigo = '$cod' AND c.deevento = '$evento_id' AND o.id = '$opcion_id'";


$cat_info = getRowQuery($query, $mysqli);
?>

<div class="titular row">
    <div class="title col-sm-9">
        <img src="../images/icon-event.png" alt=""/>
        <h2>Inscripci&oacute;n a Evento</h2>
        <h3><?php echo $evento_info['nombre']; ?></h3>
    </div>
    <div class="col-sm-3"><?php
if (!$usuario) {
    echo 'No est&aacute; logead, ingrese con DNI';
} else {
    echo '<span class="btn">' . $user_info['nombre'] . ' ' . $user_info['apellido'] . '</span>
			<a href="' . $general_path . 'modificaUsuario.php?user_id=' . $user_info['id'] . '">Ver / Cambiar mis datos</a>
			<a href="' . $general_path . 'logout.php">Cambiar usuario/Cerrar sesi&oacute;n</a>';
}
?>
    </div>
</div>
<div class="clear"></div>

<form method="POST" action="/medioDePago.php#toShow" id="formx">

    <div class="columns-container row">
        <div class="col-sm-9 reservation" id="toShow">
            <div class="alert">
                <div class="head">
                    Leer con atenci&oacute;n!
                </div>
            </div>
<?php
if ($evento_info['tipo'] == 'Servicios') {
    echo '<label>Mes a pagar:</label>';
    echo '<select name="mes" id="mes">';

    for ($i = 0; $i <= (12 - (int) date('m')); $i++) {
        $fecha = date('my', strtotime(date("d-m-Y") . "+$i months"));
        $mes = date('F', strtotime(date("d-m-Y") . "+$i months"));
        echo '<option value="' . $fecha . '">' . $mes . '</option>';
    }
    echo '</select><br><br>';
}
?>
            <p>
                Usted est&aacute; por RESERVAR una vacante en el evento <?php echo $evento_info['nombre'] ?>. La opci&oacute;n: <?php echo $cat_info['op_nombre'] ?>,
                Categor&iacute;a: <?php echo $cat_info['cat_nombre'] ?> donde participan de <?php echo $cat_info['cat_minima'] ?> a <?php echo $cat_info['cat_maxima'] ?> a&ntilde;os de edad. Si la misma no se confirma efectualizando el pago
                correspondiente antes de la fecha de vencimiento la vacante quedar&aacute; liberada pudiendo ser ocupada por otra persona.
            </p>

            
            <?php  if($cat_info['fechavenc1'] > 100): ?>
            <div class="columns-container row">
                <div class="col-sm-12">
                    <h3>Vencimientos</h3>
                    <br>


                    <div class="panel-group accordion inscriptions" id="accordion-events">

                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="col-status anchox">VENCIMIENTO Nº</th>
                                    <th class="col-date anchox">FECHA HASTA</th>
                                    <th class="col-actions anchox">VALOR</th>

                                </tr>
                            </thead> 
                        </table> 

						<?php 
						
						if ( ($cat_info['fechavenc1'] == $cat_info['fechavenc2'] && $cat_info['precio1'] == $cat_info['precio2']) && ($cat_info['fechavenc1'] == $cat_info['fechavenc3'] && $cat_info['precio1'] == $cat_info['precio3'])  ){
						?>						
							<div class="panel panel-default"> 
								<div class="panel-heading">
									<table class="table">
										<tbody>
											<tr>
												<td class="col-status anchox">1er vencimiento</td>
												<td class="col-date anchox"><?php $fechax = fechaByInt($cat_info['fechavenc1']);
													echo date("d/m/Y", strtotime($fechax)); ?></td>
												<td class="col-event anchox2"><?php echo '$' . $cat_info['precio1']; ?></td>
											</tr>
										</tbody>   
									</table>
								</div>
							</div>
						<?php
						}
						else{
						?>
						
							<div class="panel panel-default"> 
								<div class="panel-heading">
									<table class="table">
										<tbody>
											<tr>
												<td class="col-status anchox">1er vencimiento</td>
												<td class="col-date anchox"><?php $fechax = fechaByInt($cat_info['fechavenc1']);
													echo date("d/m/Y", strtotime($fechax)); ?></td>
												<td class="col-event anchox2"><?php echo '$' . $cat_info['precio1']; ?></td>

											</tr>
										</tbody>   
									</table>
								</div>
							</div>
							<div class="panel panel-default"> 
								<div class="panel-heading">
									<table class="table">
										<tbody>
											<tr>
												<td class="col-status anchox">2do vencimiento</td>
												<td class="col-date anchox"><?php $fechax = fechaByInt($cat_info['fechavenc2']);
													echo date("d/m/Y", strtotime($fechax)); ?></td>
												<td class="col-event anchox2"><?php echo '$' . $cat_info['precio2']; ?></td>

											</tr>
										</tbody>   
									</table>
								</div>
							</div>
							
							
							<?php
							if ( ($cat_info['fechavenc2'] != $cat_info['fechavenc3'] || $cat_info['precio2'] != $cat_info['precio3']) ){
							?>
								<div class="panel panel-default"> 
									<div class="panel-heading">
										<table class="table">
											<tbody>
												<tr>
													<td class="col-status anchox">3er vencimiento</td>
													<td class="col-date anchox"><?php $fechax = fechaByInt($cat_info['fechavenc3']);
														echo date("d/m/Y", strtotime($fechax)); ?></td>
													<td class="col-event anchox2"><?php echo '$' . $cat_info['precio3']; ?></td>

												</tr>
											</tbody>   
										</table>
									</div>
								</div>
							<?php }?>
						
						<?php }?>


                    </div>
                </div>                  
            </div> 
            <?php endif;?>


            <?php
            if ($evento_info['pregunta1']) {
                ?> <h3>Preguntas:</h3> <?php
                echo '
					<label for="respuestapart1">' . $evento_info['pregunta1'] . '</label>
					<input type="text" name="respuestapart1" />
					';
            }
            if ($evento_info['pregunta2']) {
                echo '
					<label for="respuestapart2">' . $evento_info['pregunta2'] . '</label>
					<input type="text" name="respuestapart2" />
					';
            }

            if ($evento_info['pregunta3']) {
                echo '
					<label for="respuestapart3">' . $evento_info['pregunta3'] . '</label>
				<input type="text" name="respuestapart3" />
				';
            }
            ?>

            <div class="terms">
                <div class="termsCheck">
                    <input type="checkbox" value="None" id="termsCheck" name="check" />
                    <label for="termsCheck"></label>
                </div>
                ACEPTO CADA UNA DE LAS CONDICIONES Y REGLAMENTO QUE EXPRESA LA ENTIDAD ORGANIZADORA DEL EVENTO PARA PARTICIPAR
                EN EL MISMO. <a target="_blank" class="underline" style="color:black" href="<?= $evento_info['web'] ?>">CONSULTAR WEBSITE DEL ORGANIZADOR. </a>
            </div>
            <div class="btns">
                <input class="btn green pull-right" type="submit" id="confirmar" value="confirmar"> 
                <div class="clear"></div>
            </div>
        </div>

        <div class="col-sm-3 col-wrap">
            <div class="col gray" style="height: 325px;margin-bottom: 20px;">

            </div>
        </div>   
    </div>



    <input type="hidden" name="evento" value="<?php echo filter_input(INPUT_GET, 'evento') ?>">
    <input type="hidden" name="categoria" value="<?php echo filter_input(INPUT_GET, 'categoria') ?>">
    <input type="hidden" name="opcion_id" value="<?php echo addslashes(filter_input(INPUT_GET, 'opcion_id')) ?>">
    <input type="hidden" name="cod" value="<?php echo filter_input(INPUT_GET, 'cod') ?>">
    <input type="hidden" name="opcion" value="<?php echo filter_input(INPUT_GET, 'opcion') ?>">
</form>    

<div class="clear"></div>
<br>

<script>

    $(document).ready(function() {
        $("#confirmar").prop('disabled', true);
    });

    $("#termsCheck").click(function() {
        check = $(this).prop('checked');

        if (check) {
            $("#confirmar").prop('disabled', false);
        }
        else {
            $("#confirmar").prop('disabled', true);
        }
    });

</script>

<script src="../js/jquery.validate.min.js"></script>
<script>
    $(window).load(function() {



        $("#formx").validate({
            rules: {
                respuestapart1: {
                    required: true,
                },
                respuestapart2: {
                    required: true,
                },
                respuestapart3: {
                    required: true,
                }
            },
            messages: {
                respuestapart1: {
                    required: "Respuesta obligatoria. Por favor complete",
                },
                respuestapart2: {
                    required: "Respuesta obligatoria. Por favor complete",
                },
                respuestapart3: {
                    required: "Respuesta obligatoria. Por favor complete",
                }
            }
        });
    });
</script>

<style>
    .error {
        color: red;
    }
    .accordion.inscriptions .col-date, .accordion.inscriptions .col-status, .accordion.inscriptions .col-actions.anchox {
        width:34%;
    }
    .accordion.inscriptions .col-date, .accordion.inscriptions .col-status, .accordion.inscriptions .col-actions.anchox2 {
        width:34%;
        padding-left:1%;
    }
</style>
<?php
include_once dirname(__FILE__) . '/general/footer.php';
?>  													