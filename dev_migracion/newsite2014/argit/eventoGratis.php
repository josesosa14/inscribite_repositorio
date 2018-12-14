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

$mesactual = date('n');
$anioactual = date('y');

//info de las categorias
$query = "SELECT  CONCAT(SUBSTRING((CONVERT(c.fechadecomputo,CHAR(4))),1,4),'-',SUBSTRING((CONVERT(c.fechadecomputo,CHAR(6))),5,5),'-',SUBSTRING((CONVERT(c.fechadecomputo,CHAR(8))),7,7)) as cat_fecha,
            c.nombre cat_nombre,CASE WHEN (o.cupo+o.cuporestante) < 0 THEN 0 ELSE (o.cupo+o.cuporestante) END cupo_restante,o.nombre op_nombre,c.descripcion cat_desc,c.sexo cat_sexo,c.precio1 cat_precio,c.codigo cat_codigo,o.id op_codigo,
            c.edadminima cat_minima,c.edadmaxima cat_maxima
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

<form method="POST" action="altas/confirmaInscripcionGratis.php" id="formx">

    <div class="columns-container row">
        <div class="col-sm-9 reservation" id="toShow">
            <div class="alert">
                <div class="head">
                    Leer con atenci&oacute;n!
                </div>
            </div>
            <p>
                Usted est&aacute; por RESERVAR una vacante en el evento <?php echo $evento_info['nombre'] ?>. La opci&oacute;n: <?php echo $cat_info['op_nombre'] ?>,
                Categor&iacute;a: <?php echo $cat_info['cat_nombre'] ?> donde participan de <?php echo $cat_info['cat_minima'] ?> a <?php echo $cat_info['cat_maxima'] ?> a&ntilde;os de edad. Si la misma no se confirma efectualizando el pago
                correspondiente antes de la fecha de vencimiento la vacante quedar&aacute; liberada pudiendo ser ocupada por otra persona.
            </p>
            <?php
            if ($evento_info['pregunta1']) {
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
                EN EL MISMO. CONSULTAR WEBSITE DEL ORGANIZADOR. 
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



    <input type="hidden" name="evento" id="dato1" value="<?php echo addslashes(filter_input(INPUT_GET, 'evento')) ?>">
    <input type="hidden" name="cod" id="dato5" value="<?php echo addslashes(filter_input(INPUT_GET, 'cod')) ?>">
    <input type="hidden" name="mes" id="dato6" value="<?php echo substr('0' . $mesactual, -2, 2) . $anioactual; ?>">
    <input type="hidden" name="categoria" id="dato7" value="<?php echo addslashes(filter_input(INPUT_GET, 'categoria')) ?>">
    <input type="hidden" name="opcion_id" id="dato8" value="<?php echo addslashes(filter_input(INPUT_GET, 'opcion_id')) ?>">
    <input type="hidden" name="opcion" id="dato9" value="<?php echo addslashes(filter_input(INPUT_GET, 'opcion')) ?>">
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




<style>
.error {
color: red;
}
</style>
<script src="../js/jquery.validate.min.js"></script>
<script>

    $(document).ready(function() {
        
    $("#confirmar").click(function(event) {
        event.preventDefault();
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
		if (!$('form').valid()) {
        return false;
		}		else {	
        var d1 = $('#dato1').val();
        var d2 = $('#dato2').val();
        var d3 = $('#dato3').val();
        var d4 = $('#dato4').val();
        var d5 = $('#dato5').val();
        var d6 = $('#dato6').val();
        var d7 = $('#dato7').val();
        var d8 = $('#dato8').val();
        var d9 = $('#dato9').val();
        
            $.ajax({
                url: "altas/confirmaInscripcionGratis.php",
                type: "POST",
                async: false,
                data: {evento: d1, respuestapart1: d2, respuestapart2: d3, respuestapart3: d4, cod: d5, mes: d6, categoria: d7, opcion_id: d8, opcion: d9}
            })
                    .done(function(data) {
                        if (data == 1) {
                            $("#mensaje1").empty();
                            $("#mensaje1").append("Su inscripción fue realizada.");
                            $("#mensaje2").empty();
                            $("#mensaje2").append("Revise su correo para ver los cupones.");
                        } else {
                            $("#mensaje1").empty();
                            $("#mensaje1").append("Usted ya se encuentra inscripto");
                            $("#mensaje2").empty();
                            $("#mensaje2").append("Comuniquese al número telefónico de abajo");
                        }
                        $('.modalMessage').modal();
                        $("#confirmar").prop('disabled', true);
                        $('.modalMessage').on('hidden.bs.modal', function(e) {
                            location.href = 'http://www.inscribiteonline.com.ar/miCuenta.php#toShow';
                        });
                    });
					 }
        });
    });


</script>

<!-- Modal -->
<div class="modal fade modalMessage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="alert">
                    <h2><span id="mensaje1"></span></h2>
                    <h3><span id="mensaje2"></span></h3>
                </div>
                <center><p>Si surge algún problema, comunicate al (11) 4641-4423</p></center>
            </div>
        </div>
    </div>
</div><!-- /.modal -->


<?php 
include_once dirname(__FILE__) . '/general/footer.php'; 
?>