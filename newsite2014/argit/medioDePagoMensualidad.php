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
$query = "select * from mensualidades INNER JOIN mensualidad_cuotas ON mec_men_id = men_id where mec_id = $mec_id";
$mensualidad = getRowQuery($query, $mysqli);

?>

<div class="titular row">
    <div class="title col-sm-9">
        <img src="../images/icon-event.png" alt=""/>
        <h2>Inscripci&oacute;n a Mensualidad</h2>
        <h3><?php echo $mensualidad['men_nombre']; ?></h3>
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

<form method="POST" action="">
    <div class="columns-container row">
        <div class="col-sm-9 reservation" id="toShow">
            <h4>
			El valor de la cuota a pagar hasta el <?=date('d/m/Y',strtotime($mensualidad['mec_venc_1']))?> es de <?=$mensualidad['mec_imp_1']?>
			</h4>
			<h4>
			El valor de la cuota a pagar hasta el <?=date('d/m/Y',strtotime($mensualidad['mec_venc_2']))?> es de <?=$mensualidad['mec_imp_2']?>
			</h4>
			<h4>
			El valor de la cuota a pagar hasta el <?=date('d/m/Y',strtotime($mensualidad['mec_venc_3']))?> es de <?=$mensualidad['mec_imp_3']?>
			</h4>
			<span style="font-weight: bold;">Pasada la &uacute;ltima fecha se aplicar&aacute; d&iacute;a a d&iacute;a un punitorio del <?=$mensualidad['men_punitorio']*100?>% sobre el valor final</span>
			<h3>C&oacute;mo vas a pagar?</h3>
            <p class="small" style="margin-bottom: 25px;">
                Por favor eleg&iacute; la forma de pago que m&aacute;s te convenga.
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
                    $fecha = date('Y-m-d', strtotime($mensualidad['mec_venc_3'] . "-5 days"));
                    $fecha_valida = date('Y-m-d');
					
                   if ($fecha_valida <= $fecha) {
                       echo '<div class="radio-payment misCuentas">
							<input type="radio" value="pmc" id="pagoMiscuentas" name="medio" />
									<label for="pagoMiscuentas"></label>
							</div>
							<div class="clear"></div>
							';                
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

    <input type="hidden" name="mec_id" id="mec_id" value="<?php echo addslashes(filter_input(INPUT_POST, 'mec_id')) ?>">
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
        var d2 = $('#mec_id').val();       
        if (eleccion == "pmc") {
            $.ajax({
                url: "/altas/confirmaInscripcionMensualidad.php",
                type: "POST",
                async: false,
                data: {mec_id: d2,medio:eleccion}
            })
                    .done(function(data) {
                        if (data) {
                            $("#mensaje1").empty();
                            $("#mensaje1").append("Su gesti&oacute;n fue realizada. El c&oacute;digo de pago sera tu DNI");
                            $("#mensaje2").empty();
                            $("#mensaje2").append("Dentro de 48hs h&aacute;biles estara visible en tu home banking. Nombre empresa: Inscribite Online. Rubro: Otros Servicios");
                        } 
                        $('.modalMessage').modal();
                        $("#confirmar").prop('disabled', true);
                        $('.modalMessage').on('hidden.bs.modal', function(e) {
                            location.href = '<?= $general_path ?>miCuenta.php#toShow';
                        });
                    });
					
        } else if(eleccion == "pf"){
            var linkx = '/altas/confirmaRPPF.php?medio=pf&mec_id=' + d2;
            location.href = linkx;
			}
			else{
			var linkx = '/altas/confirmaRPPF.php?medio=rp&mec_id=' + d2;
            location.href = linkx;
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