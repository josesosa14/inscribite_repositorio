<?php
$unirse = "blue";
require_once dirname(__FILE__) . '/general/header.php';
$provincias = getArrayQuery("SELECT * FROM provincias", $mysqli);
$localidades = getArrayQuery("SELECT * FROM localidades", $mysqli);
?>
</div>
<div class="titular row" id="toShow">
    <div class="title">
        <img src="../images/icon-registration.png" alt=""/>
        <h2>Formulario de Registro</h2>
        <h3>Esto es solo el comienzo - Lo completas por única vez</h3>
    </div>
</div>


<div class="columns-container row" >
    <div class="col-sm-9">
        <form class="contact-form" method="POST" action="<?PHP echo $general_path;?>/altas/usuario.php" id="formis">
            <div class="row">
                <label class="col-sm-4">Nombre *</label>
                <div class="col-sm-8 col-wrap">
                    <input class="form-control" type="text" name="nombre"  />
                </div>
            </div>
            <div class="row">
                <label class="col-sm-4">Apellido *</label>
                <div class="col-sm-8 col-wrap">
                    <input class="form-control" type="text" name="apellido" />
                </div>
            </div>
            <div class="row">
                <label class="col-sm-4">Tipo de Documento *</label>
                <div class="col-sm-8 col-wrap">
                    <select class="form-control" name="tipo_documento">
                        <option value="DNI" >DNI</option>
                        <option value="CI" >CI</option>
                        <option value="LC" >LC</option>
                        <option value="LE" >LE</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <label class="col-sm-4">DNI *</label>
                <div class="col-sm-8 col-wrap">
                    <input class="form-control" name="dni" type="text" value="<?php echo filter_input(INPUT_GET, "dni") ?>" id="dniUsuario" autocomplete="off"/>
                </div>
            </div>
            <br/>
            <div class="row">
                <label class="col-sm-4">Fecha de nacimiento *</label>
                
				<?php
					//if($_SERVER['REMOTE_ADDR'] == '190.191.229.226'):?>
						<div class="col-sm-2 col-wrap">
							<select class="form-control" name="fec_dia" id="fec_dia" >
							</select>
						</div>
						<div class="col-sm-4 col-wrap">
							<select class="form-control" name="fec_mes"  id="fec_mes">
								<option value="1">Ene</option>
								<option value="2">Feb</option>
								<option value="3">Mar</option>
								<option value="4">Abr</option>
								<option value="5">May</option>
								<option value="6">Jun</option>
								<option value="7">Jul</option>
								<option value="8">Ago</option>
								<option value="9">Sep</option>
								<option value="10">Oct</option>
								<option value="11">Nov</option>
								<option value="12">Dic</option>
							</select>
						</div>
						<div class="col-sm-2 col-wrap">
							<select class="form-control" name="fec_ano"  id="fec_ano">
							</select>
						</div>
				<?php //endif;?>
				<!--<div class="col-sm-5 col-wrap">
                    <input class="form-control" type="text" name="fechanac" id="datepicker" />
                </div>
				
				
				<div class="col-sm-3 col-wrap">
					<input class="form-control" type="text" name="edad" id="edad" readonly />
				</div>-->
				
				
            </div>
            <div class="row">
                <label class="col-sm-4">Sexo *</label>
                <div class="col-sm-8 col-wrap">
                    <select class="form-control" name="sexo">
                        <option disabled="" selected=""></option>
                        <option value="masculino" >Masculino</option>
                        <option value="femenino" >Femenino</option>
                    </select>
                </div>
            </div>
            <br/>
            <div class="row">
                <label class="col-sm-4">Email *</label>
                <div class="col-sm-8 col-wrap">
                    <input class="form-control" type="email" name="email" autocomplete="off"/>
                </div>
            </div>
            <div class="row">
                <label class="col-sm-4">Elegir contraseña *</label>
                <div class="col-sm-8 col-wrap">
                    <input class="form-control" type="password" name="password" autocomplete="off"/>
                </div>
            </div>
            <br/>
            <div class="row">
                <label class="col-sm-4">Teléfono Particular *</label>
                <div class="col-sm-8 col-wrap">
                    <input class="form-control" type="text" name="telefonoparticular" />
                </div>
            </div>
            <div class="row">
                <label class="col-sm-4">Teléfono Laboral</label>
                <div class="col-sm-8 col-wrap">
                    <input class="form-control" type="text" name="telefonolaboral" />
                </div>
            </div>
            <div class="row">
                <label class="col-sm-4">Teléfono Celular</label>
                <div class="col-sm-8 col-wrap">
                    <input class="form-control" type="text" name="telefonocelular" />
                </div>
            </div>
            <br/>
            <div class="row">
                <label class="col-sm-4">Domicilio</label>
                <div class="col-sm-8 col-wrap">
                    <input class="form-control" type="text" name="domicilio"  />
                </div>
            </div>
            <div class="row">
                <label class="col-sm-4">Pa&iacute;s *</label>
                <div class="col-sm-8 col-wrap">
                    <select class="form-control" name="pais">
                        <option disabled="" selected=""></option>
                        <option value="argentina">Argentina</option>
                        <option value="brazil">Brazil</option>
                        <option value="colombia">Colombia</option>
                        <option value="chile">Chile</option>
                        <option value="ecuador">Ecuador</option>
                        <option value="paraguay">Paraguay</option>
                        <option value="peru">Per&uacute;</option>
                        <option value="uruguay">Uruguay</option>
                        <option value="venezuela">Venezuela</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <label class="col-sm-4">Provincia *</label>
                <div class="col-sm-8 col-wrap">
                    <select class="form-control" name="provincia" id="provincias">
                        <option disabled selected>Seleccionar Provincia</option>
                        <?php
                        $provincias_utf8 = $provincias;

                        function encode_items(&$item, $key) {
                            $item = utf8_encode($item);
                        }

                        array_walk_recursive($provincias_utf8, 'encode_items');
                        foreach ($provincias_utf8 as $item) {
                            echo "<option value=" . $item['id'] . ">" . $item['nombre'] . "</option>";
                        }
                        ?>
                        <select/>
                </div>
            </div>
            <div class="row">
                <label class="col-sm-4">Localidad *</label>
                <div class="col-sm-8 col-wrap">
                    <select class="form-control" name="localidad" id="localidades_select">
                        <option disabled="" selected=""></option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="btns">
                    <span class="btn pull-left col-xs-12 col-sm-7 col-md-6">Los campos con ( * ) son obligatorios</span>
                    <input class="btn green pull-right col-xs-12 col-sm-3" type="submit" id="registrarse" value="registrarse"/>
                    <div class="clear"></div>
                </div>
            </div>
        </form>
    </div>
    <div class="col-sm-3 col-wrap">
        <div class="col gray" >
            <a href="http://www.epsa.org.ar/promo/"> <img src="../images/banner_guardavidas.jpg" /></a>
        </div>
    </div>   
</div>
<?php include_once dirname(__FILE__) . '/general/banners.php'; ?>
<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
<?php
$localidades_utf8 = $localidades;

array_walk_recursive($localidades_utf8, 'encode_items');
?>
<script>
    $("#provincias").change(function() {
        var provincia_id = $(this).val();
        var localidades = new Array();
        localidades = <?php echo json_encode($localidades_utf8); ?>;
        $('#localidades_select').find('option').remove().end();
        $.each(localidades, function(key, valor) {
            if (valor.id_provincia == provincia_id) {
                $("#localidades_select").append('<option value="' + valor.id + '">' + valor.nombre + '</option>');
            }
        });
    });
</script>

<script>
    $.datepicker.regional['es'] = {
        closeText: 'Cerrar',
        prevText: '<Ant',
        nextText: 'Sig>',
        currentText: 'Hoy',
        monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
        dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
        dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Juv', 'Vie', 'Sáb'],
        dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sá'],
        weekHeader: 'Sm',
        dateFormat: 'dd-mm-yy',
        firstDay: 1,
        isRTL: false,
        showMonthAfterYear: false,
        yearSuffix: ''
    };
    $.datepicker.setDefaults($.datepicker.regional['es']);
    $(function() {
        $("#datepicker").datepicker({
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true,
            yearRange: "1914:2014"
        });
    });

    $("#datepicker").change(function() {
		var fecha_actual = $.now();
		var fecha = $('#datepicker').datepicker('getDate').getTime();
		var edad = Math.floor((fecha_actual-fecha) / (365.25 * 24 * 60 * 60 * 1000));
		
		if(edad <= 5){
			alert("Usted seleccionó que tiene "+edad+" años. No tiene edad suficiente.");
			$("#registrarse").attr("disabled", true);
			$("#registrarse").val("corregir la edad");
		}
		else{
		$("#registrarse").attr("disabled", false);
		$("#registrarse").val("registrarse");
		}
		
		$("#edad").val("usted tiene: "+edad+" años");
		$("#edad").focus();
		
    });
    
</script>

<script src="../js/jquery.validate.min.js"></script>
<script src="moment.js"></script>
<script type="text/javascript">
    $(window).load(function() {
        jQuery.extend(jQuery.validator.messages, {
            required: "Este campo es obligatorio.",
            email: "Debe completar con un e-mail válido."
        });
        $("#formis").validate({
            lang: 'es',
            rules: {
                nombre: "required",
                apellido: "required",
                dni: {
                    required: true,
                    minlength: 7,
                    maxlength: 8,
                    digits: true
                },
                fechanac: "required",
                sexo: "required",
                email: "required",
                password: {
                    required: true,
                    minlength: 5
                },
                telefonoparticular: "required",
                pais: "required",
                provincia: "required",
                localidad: "required"
            },
            messages: {
                dni: {
                    minlength: "La logitud debe ser 8",
                    maxlength: "La logitud debe ser 8",
                    digits: "Solo numeros, por favor"
                },
                password: {
                    minlength: "Debe contener 5 caracteres como mínimo."
                },
                telefonoparticular: {
                    minlength: "Debe contener 5 caracteres como mínimo."
                }
            }

        });
    });
</script>

<script>
    $(document).ready(function() {
		dia ="";
		for(d=1;d<=31;d++){
			dia += "<option>"+d+"</option>";
		}
		$("#fec_dia").append(dia);
		
		/*mes = "";
		for(m=1;m<=12;m++){
			mes += "<option>"+m+"</option>";
		}
		$("#fec_mes").append(mes);*/
		ano = "";
		for(a=2016;a>=2016-100;a--){
			ano += "<option>"+a+"</option>";
		}
		$("#fec_ano").append(ano);
		$("#fec_ano").change(function(){
			
			var fecha_actual = new Date();
			var fecha = new Date($('#fec_ano').val()+'-'+$("#fec_mes").val()+'-'+$("#fec_dia").val());
			console.log(fecha);
			var edad = Math.floor((fecha_actual-fecha) / (365.25 * 24 * 60 * 60 * 1000));
			
			if(edad <= 5){
				alert("Usted seleccionó que tiene "+edad+" años. No tiene edad suficiente.");
				$("#registrarse").attr("disabled", true);
				$("#registrarse").val("corregir la edad");
			}
			else{
			$("#registrarse").attr("disabled", false);
			$("#registrarse").val("registrarse");
			}
			
			//$("#edad").val("usted tiene: "+edad+" años");
			//$("#edad").focus();
		});
		
		
        var cantidadNumeros = 0;
        var dniUsuario = 0;
        $("#dniUsuario").change(function() {
            cantidadNumeros = $("#dniUsuario").val().length;
            dniUsuario = $("#dniUsuario").val();
            if (cantidadNumeros >= 7 && cantidadNumeros <= 8 && $.isNumeric(dniUsuario)) {
                respuesta = $.ajax({
                    type: "POST",
                    url: '<?PHP echo $general_path;?>general/buscar_dni.php',
                    data: {'action': 'checkDni', 'dni': dniUsuario},
                    async: false,
                })
                        .done(function(msg) {
                            if (msg == 1) {
                                $('.modalMessage').modal();
                            }
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
                    <h2><span id="mensaje1">El DNI ingresado ya se encuentra registrado</span></h2>
                    <h3><span id="mensaje2">Revise los datos ingresados</span></h3>
                </div>
            </div>
        </div>
    </div>
</div><!-- /.modal -->

<!-- BOX DE RECUPERAR CONTRASEÑA -->

<?php
include_once dirname(__FILE__) . '/general/footer.php';
