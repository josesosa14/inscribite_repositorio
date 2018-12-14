<?php
$inscripcion = "blue";
$pagar = "blue";
require_once dirname(__FILE__) . '/general/header.php';
?>
</div>
<?php
//get variables
global $usuario;
$evento_id = addslashes(filter_var(filter_input(INPUT_POST, 'evento'), FILTER_SANITIZE_STRING));
$cat_id = addslashes(filter_var(filter_input(INPUT_POST, 'categoria'), FILTER_SANITIZE_STRING));
$cat_cod = addslashes(filter_var(filter_input(INPUT_POST, 'cod'), FILTER_SANITIZE_STRING));
$op_id = addslashes(filter_var(filter_input(INPUT_POST, 'opcion'), FILTER_SANITIZE_STRING));
$men_id = addslashes(filter_var(filter_input(INPUT_POST, 'men_id'), FILTER_SANITIZE_STRING));
$mec_id = addslashes(filter_var(filter_input(INPUT_POST, 'mec_id'), FILTER_SANITIZE_STRING));

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
$query = "SELECT  * FROM inscribite_categorias c
            INNER JOIN inscribite_opciones o ON o.evento = c.deevento AND o.nombre = c.opcion
            WHERE c.codigo = $cat_cod AND c.deevento = $evento_id AND c.nombre = '$cat_id' ";


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
                    <a href="' . $general_path . 'modificaUsuario.php?user_id=' . $user_info['id'] . '#toShow">Ver / Cambiar mis datos</a>
                    <a href="' . $general_path . 'logout.php">Cambiar usuario/Cerrar sesi&oacute;n</a>';
        }
        ?>
    </div>
</div>
<div class="clear"></div>

<form method="POST" action="/altas/confirmaInscripcion.php">
    <div class="columns-container row">
        <div class="col-sm-9 reservation" id="toShow">
            <h3>Cómo vas a pagar?</h3>
            <p class="small" style="margin-bottom: 25px;">
                Por favor elegí la forma de pago que más te convenga.
            </p>

            <div class="radios-payment">
                <div class="radio-payment pFacil">
                    <input type="radio" value="pf" id="pagoFacil" name="medio" />
                    <label for="pagoFacil"></label>
                </div>
				
				<?php
				if(esAdmin()){
				
				echo '<div class="radio-payment rPago">
							<input type="radio" value="rp" id="rapiPago" name="medio" />
							<label for="rapiPago"></label>
						</div>';
				}
				?>

                <?php
                //echo '<pre>';print_r($cat_info);die;
                if ($cat_info['fechavenc3'] && $cat_info['fechavenc3'] > 100) {
                    $fecha = date('Y-m-d', strtotime(fechaByInt($cat_info['fechavenc3']) . "-5 days"));
                    $fecha_valida = date('Y-m-d');

                   if ($fecha_valida <= $fecha) {
                        echo '<div class="radio-payment misCuentas">
                            <input type="radio" value="pmc" id="pagoMiscuentas" name="medio" />
                                    <label for="pagoMiscuentas"></label>
                            </div>
                            <div class="clear"></div>
                            ';
                    }
                }
                ?>
                <h4 id="pmc-text" style="display:none">Eligi&oacute; Pago Mis Cuentas, dentro de 48hs podr&aacute; realizar su pago por este medio</h4>
            </div>

            <div class="btns">
                <input class="btn green pull-right" type="submit" id="confirmar" value="confirmar">
                <div class="clear"></div>
            </div>
        </div>


    </div>

    <input type="hidden" name="evento" id="dato1" value="<?php echo addslashes(filter_input(INPUT_POST, 'evento')) ?>">
    <input type="hidden" name="respuestapart1" id="dato2" value="<?php echo addslashes(filter_input(INPUT_POST, 'respuestapart1')) ?>">
    <input type="hidden" name="respuestapart2" id="dato3" value="<?php echo addslashes(filter_input(INPUT_POST, 'respuestapart2')) ?>">
    <input type="hidden" name="respuestapart3" id="dato4" value="<?php echo addslashes(filter_input(INPUT_POST, 'respuestapart3')) ?>">
    <input type="hidden" name="cod" id="dato5" value="<?php echo addslashes(filter_input(INPUT_POST, 'cod')) ?>">
    <input type="hidden" name="mes" id="dato6" value="<?php if (isset($_POST['mes']))
                    echo filter_input(INPUT_POST, 'mes');
                else
                    echo substr('0' . $mesactual, -2, 2) . $anioactual;
                ?>">
    <input type="hidden" name="categoria" id="dato7" value="<?php echo addslashes(filter_input(INPUT_POST, 'categoria')) ?>">
    <input type="hidden" name="opcion_id" id="dato8" value="<?php echo addslashes(filter_input(INPUT_POST, 'opcion_id')) ?>">
    <input type="hidden" name="opcion" id="dato9" value="<?php echo addslashes(filter_input(INPUT_POST, 'opcion')) ?>">
</form>

<div class="clear"></div>
<br>
<div id="test"></div>
<script>

    $(document).ready(function() {
        $("#confirmar").prop('disabled', true);
    });
    var eleccion = 0;
    $("#pagoFacil").click(function() {
        medio1 = $(this).prop('checked');
        medio2 = $("#pagoMiscuentas").prop('checked');
		medio3 = $("#rPago").prop('checked');
        eleccion = $("#pagoFacil").val();
        if (medio1 || medio2 || medio3) {
            $("#confirmar").prop('disabled', false);
        }
        else {
            $("#confirmar").prop('disabled', true);
        }
    });
    $("#pagoMiscuentas").click(function() {
        $("#pmc-text").show();
        medio2 = $(this).prop('checked');
        medio1 = $("#pagoFacil").prop('checked');
		medio3 = $("#rPago").prop('checked');
        eleccion = $("#pagoMiscuentas").val();
        if (medio1 || medio2 || medio3) {
            $("#confirmar").prop('disabled', false);
        }
        else {
            $("#confirmar").prop('disabled', true);
        }
    });
	$("#rapiPago").click(function() {
		medio2 = $(this).prop('checked');
        medio1 = $("#pagoFacil").prop('checked');
		medio3 = $("#pagoMiscuentas").prop('checked');
        eleccion = $("#rPago").val();
        if (medio1 || medio2 || medio3) {
            $("#confirmar").prop('disabled', false);
        }
        else {
            $("#confirmar").prop('disabled', true);
        }
    });
    $("#confirmar").click(function(event) {
        event.preventDefault();
        var d1 = $('#dato1').val();
        var d2 = $('#dato2').val();
        var d3 = $('#dato3').val();
        var d4 = $('#dato4').val();
        var d5 = $('#dato5').val();
        var d6 = $('#dato6').val();
        var d7 = $('#dato7').val();
        var d8 = $('#dato8').val();
        var d9 = $('#dato9').val();
        if (eleccion == "pmc") {
            $.ajax({
                url: "/altas/confirmaInscripcion.php",
                type: "POST",
                async: false,
                data: {medio: eleccion, evento: d1, respuestapart1: d2, respuestapart2: d3, respuestapart3: d4, cod: d5, mes: d6, categoria: d7, opcion_id: d8, opcion: d9}
            })
                    .done(function(data) {
                        if (data) {
                            $("#mensaje1").empty();
                            $("#mensaje1").append("Su gesti&oacute;n fue realizada. El c&oacute;digo de pago sera tu DNI");
                            $("#mensaje2").empty();
                            $("#mensaje2").append("Dentro de 48hs h&aacute;biles estara visible en tu home banking. Nombre empresa: Inscribite Online. Rubro: Otros Servicios");
                        } /*else {
                            $("#mensaje1").empty();
                            $("#mensaje1").append("Usted ya se encuentra inscripto");
                            $("#mensaje2").empty();
                            $("#mensaje2").append("Comuniquese al número telefónico de abajo");
                        }*/ 
                        $('.modalMessage').modal();
                        $("#confirmar").prop('disabled', true);
                        $('.modalMessage').on('hidden.bs.modal', function(e) {
                            location.href = '<?= $general_path ?>miCuenta.php#toShow';
                        });
                    });
					
        } else if(eleccion == "pf"){

            var linkx = 'http://www.inscribiteonline.com.ar/newsite2014/imprimircupon.php' + '?medio=' + eleccion + '&evento=' + d1 + '&respuesta1=' + d2 + '&respuesta2=' + d3 + '&respuesta3=' + d4 + '&cod=' + d5 + '&mes=' + d6 + '&cat=' + d7 + '&opcion=' + d9;
            location.href = linkx;
			/*
			window.open(linkx, 'Cupón Pago Fácil');
            setTimeout(function() {
                location.href = '<?= $general_path ?>miCuenta.php#toShow';
            }, 1500);*/
			}
			else{
			
			var linkx = 'http://www.inscribiteonline.com.ar/newsite2014/imprimircuponRP.php' + '?medio=' + eleccion + '&evento=' + d1 + '&respuesta1=' + d2 + '&respuesta2=' + d3 + '&respuesta3=' + d4 + '&cod=' + d5 + '&mes=' + d6 + '&cat=' + d7 + '&opcion=' + d9;
            location.href = linkx;
			
			/*
			window.open(linkx, 'Cupón Pago Fácil');
            setTimeout(function() {
                location.href = '<?= $general_path ?>miCuenta.php#toShow';
            }, 1500);*/


        }
    });


</script>

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
                <center><p>Si surge alg&uacute;n problema, comunicate a info@inscribiteonline.com.ar</p></center>
            </div>
        </div>
    </div>
</div><!-- /.modal -->
<?php
include_once dirname(__FILE__) . '/general/footer.php';
?>