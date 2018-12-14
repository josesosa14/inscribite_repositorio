<?php
$empresa = "blue";
require_once dirname(__FILE__) . '/general/header.php';
$provincias = getArrayQuery("SELECT * FROM provincias", $mysqli);
$localidades = getArrayQuery("SELECT * FROM localidades", $mysqli);
?>
</div>
<div class="titular row"  id="toShow">
    <div class="title col-sm-9">
        <img src="../images/icon-registration.png" alt=""/>
        <h2>Formulario de Registro</h2>
        <h3>Esto es solo el comienzo</h3>
    </div>
    <div class="col-sm-3">
        <?php
        echo '<a href="http://www.inscribiteonline.com.ar/empresas/index.php"><span class="btn">Login de empresa</span></a>';
        ?> 
    </div>

</div>
<div class="columns-container row">
    <div class="col-sm-9">
        <form class="contact-form" action="/altas/empresa.php" method="post" id="formx">
            <div class="row">
                <h2 class="col-sm-9">Empresa/Institucion</h2>
            </div>
            <div class="clear"></div><br><br>
            <div class="row">
                <label class="col-sm-4">Nombre *</label>
                <div class="col-sm-8 col-wrap">
                    <input class="form-control" type="text" name="emp_nombre"/>
                </div>
            </div>
            <div class="row">
                <label class="col-sm-4">Numero de CUIT *</label>
                <div class="col-sm-8 col-wrap">
                    <input class="form-control" type="text" name="emp_cuit"/>
                </div>
            </div>
            <div class="row">
                <label class="col-sm-4">Condicion ante IVA *</label>
                <div class="col-sm-8 col-wrap">
                    <select class="form-control" name="emp_cond_iva">
                        <option>Responsable inscripto</option>
                        <option>Consumidor final</option>
                        <option>Excento</option>
                        <select/>
                </div>
            </div>
            <div class="row">
                <label class="col-sm-4">Nombre de Usuario *</label>
                <div class="col-sm-8 col-wrap">
                    <input class="form-control" type="text" name="emp_usuario" placeholder="Sin acentos, ni caracteres @-_$& o signos de puntuación"/>
                </div>
            </div>
            <div class="row">
                <label class="col-sm-4">Elegir contraseña *</label>
                <div class="col-sm-8 col-wrap">
                    <input class="form-control" type="password" name="emp_password" />
                </div>
            </div>
            <div class="row">
                <label class="col-sm-4">Mail *</label>
                <div class="col-sm-8 col-wrap">
                    <input class="form-control" type="email" name="emp_mail"/>
                </div>
            </div>
            <div class="row">
                <label class="col-sm-4">Domicilio Legal *</label>
                <div class="col-sm-8 col-wrap">
                    <input class="form-control" type="text" name="emp_domicilio"/>
                </div>
            </div>
            <div class="row">
                <label class="col-sm-4">Provincia *</label>
                <div class="col-sm-8 col-wrap">
                    <select class="form-control" name="emp_provincia" id="provincias">
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
                   <select class="form-control" name="emp_localidad" id="localidades_select">
                        <option disabled="" selected=""></option>
                    </select>
                </div>
            </div>
            <div class="row">
                <label class="col-sm-4">Codigo Postal *</label>
                <div class="col-sm-8 col-wrap">
                    <input class="form-control" type="text" name="emp_cp" />
                </div>
            </div>
            <br><br>
            <div class="row">
                <h2 class="col-sm-9">Contacto Responsable</h2>
            </div>
            <div class="clear"></div><br><br>
            <div class="row">
                <label class="col-sm-4">Nombre *</label>
                <div class="col-sm-8 col-wrap">
                    <input class="form-control" type="text" name="empc_nombre"/>
                </div>
            </div>
            <div class="row">
                <label class="col-sm-4">Apellido *</label>
                <div class="col-sm-8 col-wrap">
                    <input class="form-control" type="text" name="empc_apellido"/>
                </div>
            </div>
            <div class="row">
                <label class="col-sm-4">DNI *</label>
                <div class="col-sm-8 col-wrap">
                    <input class="form-control" type="text" name="empc_dni"/>
                </div>
            </div>
            <div class="row">
                <label class="col-sm-4">Cargo ocupado *</label>
                <div class="col-sm-8 col-wrap">
                    <input class="form-control" type="text" name="empc_cargo"/>
                </div>
            </div>
            <div class="row">
                <label class="col-sm-4">Telefono fijo *</label>
                <div class="col-sm-8 col-wrap">
                    <input class="form-control" type="text" name="empc_tel_fijo" />
                </div>
            </div>
            <div class="row">
                <label class="col-sm-4">Telefono movil *</label>
                <div class="col-sm-8 col-wrap">
                    <input class="form-control" type="text" name="empc_tel_movil"/>
                </div>
            </div>
            <div class="row">
                <label class="col-sm-4">Usuario SKYPE</label>
                <div class="col-sm-8 col-wrap">
                    <input class="form-control" type="text" name="empc_skype"/>
                </div>
            </div>
            <div class="row">
                <label class="col-sm-4">Mail *</label>
                <div class="col-sm-8 col-wrap">
                    <input class="form-control" type="email" name="empc_mail"/>
                </div>
            </div>
            <br><br>
            <div class="row">
                <h2 class="col-sm-8">Informacion Cuenta Bancaria</h2>
            </div>
            <div class="clear"></div><br><br>
            <div class="row">
                <label class="col-sm-4">Banco *</label>
                <div class="col-sm-8 col-wrap">
                    <input class="form-control" type="text" name="empb_nombre"/>
                </div>
            </div>
            <div class="row">
                <label class="col-sm-4">Tipo de cuenta *</label>
                <div class="col-sm-8 col-wrap">
                    <select class="form-control" name="empb_tipo_cuenta" >
                        <option disabled selected>Seleccionar Cuenta</option>
                        <option value="caja ahorro">Caja de ahorro</option>
                        <option value="cuenta corriente">Cuenta corriente</option>
                        <select/>
                </div>
            </div>
            <div class="row">
                <label class="col-sm-4">Nro *</label>
                <div class="col-sm-8 col-wrap">
                    <input class="form-control" type="text" name="empb_nro_cuenta"/>
                </div>
            </div>
            <div class="row">
                <label class="col-sm-4">CBU *</label>
                <div class="col-sm-8 col-wrap">
                    <input class="form-control" type="text" name="empb_cbu"/>
                </div>
            </div>
            <div class="row">
                <label class="col-sm-4">Titular *</label>
                <div class="col-sm-8 col-wrap">
                    <input class="form-control" type="text" name="empb_titular"/>
                </div>
            </div>
            <div class="row">
                <label class="col-sm-4">CUIT de titular *</label>
                <div class="col-sm-8 col-wrap">
                    <input class="form-control" type="text" name="empb_cuit_titular"/>
                </div>
            </div>


            <div class="row">
                <div class="btns">
                    <span class="btn pull-left col-xs-12 col-sm-7 col-md-6">Los campos con ( * ) son obligatorios</span>
                    <input class="btn green pull-right col-xs-12 col-sm-3" type="submit" value="registrar"/>
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

<script src="../js/jquery.validate.min.js"></script>
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
        dateFormat: 'dd/mm/yy',
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
    $(function() {
        $("#datepicker2").datepicker({
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true,
            yearRange: "1914:2014"
        });
    });
</script>



<script>
    $(window).load(function() {

        jQuery.validator.addMethod("alphanumeric", function(value, element) {
            return this.optional(element) || /^\w+$/i.test(value);
        }, "Sólo letras y n&uacute;meros por favor");


        jQuery.extend(jQuery.validator.messages, {
            required: "Este campo es obligatorio.",
            email: "Debe completar con un e-mail válido.",
            digits: "Debe completar solo con números."
        });



        $("#formx").validate({
            lang: 'es',
			rules: {
                emp_nombre: "required",
                emp_usuario: {
                    required: true,
                    alphanumeric: true,
                    minlength: 8,
                    maxlength: 32
                },
                emp_password: {
                    required: true,
                    alphanumeric: true,
                    minlength: 8,
                    maxlength: 32
                },
                emp_cuit: {
                    required: true,
                    digits: true,
                    minlength: 10,
                    maxlength: 11

                },
                emp_cond_iva: "required",
                emp_mail: "required",
                emp_domicilio: "required",
                emp_provincia: "required",
                emp_localidad: "required",
                emp_cp: {
                    required: true,
                    digits: true,
                    minlength: 4,
                    maxlength: 5

                },
                empc_nombre: "required",
                empc_apellido: "required",
                empc_dni: {
                    required: true,
                    digits: true,
                    minlength: 7,
                    maxlength: 8

                },
                empc_cargo: "required",
                empc_tel_fijo: {
                    required: true,
                    digits: true,
                    minlength: 8,
                    maxlength: 25

                },
                empc_tel_movil: {
                    required: true,
                    digits: true,
                    minlength: 8,
                    maxlength: 25

                },
                empc_mail: "required",
                empb_nombre: "required",
                empb_fecha_alta: "required",
                empb_fecha_mod: "required",
                empb_tipo_cuenta: "required",
                empb_nro_cuenta: {
                    required: true,
                    digits: true

                },
                empb_cbu: {
                    required: true,
                    digits: true

                },
                empb_titular: "required",
                empb_cuit_titular: {
                    required: true,
                    digits: true,
                    minlength: 10,
                    maxlength: 11
                }
            },
            messages: {
                emp_usuario: {
                    minlength: "La longitud m&iacute;nima es de 8 caracteres.",
                    maxlength: "La longitud m&aacute;xima es de 32 caracteres.",
                },
                emp_password: {
                    minlength: "La longitud m&iacute;nima es de 8 caracteres.",
                    maxlength: "La longitud m&aacute;xima es de 32 caracteres.",
                },
                empc_dni: {
                    minlength: "La longitud m&iacute;nima es de 7 caracteres.",
                    maxlength: "La longitud m&aacute;xima es de 8 caracteres.",
                },
                empc_tel_fijo: {
                    minlength: "La longitud m&iacute;nima es de 8 caracteres.",
                    maxlength: "La longitud m&aacute;xima es de 25 caracteres.",
                },
                empc_tel_movil: {
                    minlength: "La longitud m&iacute;nima es de 8 caracteres.",
                    maxlength: "La longitud m&aacute;xima es de 25 caracteres.",
                },
                emp_cuit: {
                    minlength: "La longitud debe ser 10",
                    maxlength: "La longitud debe ser 11",
                    number: "Solo n&uacute;meros, por favor"
                }
            }
        });
    });
</script>
<?php 
include_once dirname(__FILE__) . '/general/footer.php'; 
?>