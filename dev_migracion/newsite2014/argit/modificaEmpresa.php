<?php
$empresa = "blue";
require_once dirname(__FILE__) . '/general/header.php';

//if ($_SESSION['empresa_id']):
//if ($_GET['empresa_id']):

$provincias = getArrayQuery("SELECT * FROM provincias", $mysqli);
$localidades = getArrayQuery("SELECT * FROM localidades", $mysqli);


$empresa_id = addslashes(filter_input(INPUT_GET, "empresa_id"));

$query = "SELECT * FROM empresa 
				LEFT JOIN empresa_contacto ON empc_emp_id = emp_id 
				LEFT JOIN empresa_banco ON empb_emp_id = emp_id 
				WHERE emp_id = $empresa_id";

$empresa = getRowQuery($query, $mysqli);
?>
</div>
<div class="titular row" id="toShow">
    <div class="title col-sm-9">
        <img src="../images/icon-registration.png" alt=""/>
        <h2>Formulario de Registro</h2>
        <h3>Esto es solo el comienzo</h3>
    </div>
    <div class="col-sm-3">
<?php
echo '<a href="' . $general_path . '../empresas/empresa.php"><span class="btn">Volver al panel</span></a>';
?> 
    </div>

</div>
<div class="columns-container row">
    <div class="col-sm-9">
        <form class="contact-form" action="/altas/modificaEmpresa.php" method="post" id="formx">
            <input type="hidden" value="<?php echo $_GET['empresa_id'] ?>" name="emp_id"/>
            <div class="row">
                <h2 class="col-sm-9">Empresa/Institucion</h2>
            </div>
            <div class="clear"></div><br><br>
            <div class="row">
                <label class="col-sm-4">Usuario *</label>
                <div class="col-sm-8 col-wrap">
                    <input class="form-control" type="text" name="emp_usuario" value="<?php echo $empresa['emp_usuario'] ?>" />
                </div>
            </div>
            <div class="row">
                <label class="col-sm-4">Password *</label>
                <div class="col-sm-8 col-wrap">
                    <input class="form-control" type="password" name="emp_password" value="<?php echo $empresa['emp_password'] ?>" />
                </div>
            </div>
            <div class="row">
                <label class="col-sm-4">Nombre *</label>
                <div class="col-sm-8 col-wrap">
                    <input class="form-control" type="text" name="emp_nombre" value="<?php echo $empresa['emp_nombre'] ?>" />
                </div>
            </div>

            <div class="row">
                <label class="col-sm-4">Numero de CUIT *</label>
                <div class="col-sm-8 col-wrap">
                    <input class="form-control" type="text" name="emp_cuit" value="<?php echo $empresa['emp_cuit'] ?>" />
                </div>
            </div>
            <div class="row">
                <label class="col-sm-4">Condicion ante IVA *</label>
                <div class="col-sm-8 col-wrap">
                    <select class="form-control" name="emp_cond_iva">
                        <option value="responsable inscripto" <?php if (strtolower($empresa['emp_cond_iva']) == "responsable inscripto") echo "selected" ?> >Responsable inscripto</option>
                        <option value="consumidor final" <?php if (strtolower($empresa['emp_cond_iva']) == "consumidor final") echo "selected" ?>>Consumidor final</option>
                        <option value="excento" <?php if (strtolower($empresa['emp_cond_iva']) == "excento") echo "selected" ?>>Excento</option>
                        <select/>
                </div>
            </div>
            <div class="row">
                <label class="col-sm-4">Mail *</label>
                <div class="col-sm-8 col-wrap">
                    <input class="form-control" type="email" name="emp_mail" value="<?php echo $empresa['emp_mail'] ?>" />
                </div>
            </div>
            <div class="row">
                <label class="col-sm-4">Domicilio Legal *</label>
                <div class="col-sm-8 col-wrap">
                    <input class="form-control" type="text" name="emp_domicilio" value="<?php echo $empresa['emp_domicilio'] ?>" />
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
    if ($item['id'] == $empresa['emp_provincia']) {
        echo "<option selected value=" . $item['id'] . ">" . $item['nombre'] . "</option>";
    } else {
        echo "<option value=" . $item['id'] . ">" . $item['nombre'] . "</option>";
    }
}
?>
                        <select/>
                </div>
            </div>
            <div class="row">
                <label class="col-sm-4">Localidad *</label>
                <div class="col-sm-8 col-wrap">
                    <select class="form-control" name="emp_localidad" id="localidades_select">
<?php
foreach ($localidades as $item) {
    if ($item['id_provincia'] == $empresa['emp_provincia']) {
        if ($item['id'] == $empresa['emp_localidad']) {
            echo "<option selected value=" . $item['id'] . ">" . $item['nombre'] . "</option>";
        } else {
            echo "<option value=" . $item['id'] . ">" . $item['nombre'] . "</option>";
        }
    }
}
?>
                        <select/>
                </div>
            </div>
            <div class="row">
                <label class="col-sm-4">Codigo Postal *</label>
                <div class="col-sm-8 col-wrap">
                    <input class="form-control" type="text" name="emp_cp" value="<?php echo $empresa['emp_cp'] ?>" />
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
                    <input class="form-control" type="text" name="empc_nombre" value="<?php echo $empresa['empc_nombre'] ?>" />
                </div>
            </div>
            <div class="row">
                <label class="col-sm-4">Apellido *</label>
                <div class="col-sm-8 col-wrap">
                    <input class="form-control" type="text" name="empc_apellido" value="<?php echo $empresa['empc_apellido'] ?>" />
                </div>
            </div>
            <div class="row">
                <label class="col-sm-4">DNI *</label>
                <div class="col-sm-8 col-wrap">
                    <input class="form-control" type="text" name="empc_dni" value="<?php echo $empresa['empc_dni'] ?>" />
                </div>
            </div>
            <div class="row">
                <label class="col-sm-4">Cargo ocupado *</label>
                <div class="col-sm-8 col-wrap">
                    <input class="form-control" type="text" name="empc_cargo"  value="<?php echo $empresa['empc_cargo'] ?>" />
                </div>
            </div>
            <div class="row">
                <label class="col-sm-4">Telefono fijo *</label>
                <div class="col-sm-8 col-wrap">
                    <input class="form-control" type="text" name="empc_tel_fijo"  value="<?php echo $empresa['empc_tel_fijo'] ?>" />
                </div>
            </div>
            <div class="row">
                <label class="col-sm-4">Telefono movil *</label>
                <div class="col-sm-8 col-wrap">
                    <input class="form-control" type="text" name="empc_tel_movil" value="<?php echo $empresa['empc_tel_movil'] ?>" />
                </div>
            </div>
            <div class="row">
                <label class="col-sm-4">Usuario SKYPE</label>
                <div class="col-sm-8 col-wrap">
                    <input class="form-control" type="text" name="empc_skype" value="<?php echo $empresa['empc_skype'] ?>" />
                </div>
            </div>
            <div class="row">
                <label class="col-sm-4">Mail *</label>
                <div class="col-sm-8 col-wrap">
                    <input class="form-control" type="email" name="empc_mail" value="<?php echo $empresa['empc_mail'] ?>"/>
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
                    <input class="form-control" type="text" name="empb_nombre" value="<?php echo $empresa['empb_nombre'] ?>" />
                </div>
            </div>
			<div class="row">
                <label class="col-sm-4">Tipo de cuenta *</label>
                <div class="col-sm-8 col-wrap">
                    <select class="form-control" name="empb_tipo_cuenta" >
                        <option disabled selected>Seleccionar Cuenta</option>
                        <option value="caja de ahorro"  <?php if (strtolower($empresa['empb_tipo_cuenta']) == 'caja de ahorro') echo 'selected' ?>>Caja de ahorro</option>
                        <option value="cuenta corriente" <?php if (strtolower($empresa['empb_tipo_cuenta']) == 'cuenta corriente') echo 'selected' ?> >Cuenta corriente</option>
                        <select/>
                </div>
            </div>
            <div class="row">
                <label class="col-sm-4">Nro *</label>
                <div class="col-sm-8 col-wrap">
                    <input class="form-control" type="text" name="empb_nro_cuenta" value="<?php echo $empresa['empb_nro_cuenta'] ?>" />
                </div>
            </div>
            <div class="row">
                <label class="col-sm-4">CBU *</label>
                <div class="col-sm-8 col-wrap">
                    <input class="form-control" type="text" name="empb_cbu" value="<?php echo $empresa['empb_cbu'] ?>" />
                </div>
            </div>
            <div class="row">
                <label class="col-sm-4">Titular *</label>
                <div class="col-sm-8 col-wrap">
                    <input class="form-control" type="text" name="empb_titular" value="<?php echo $empresa['empb_titular'] ?>" />
                </div>
            </div>
            <div class="row">
                <label class="col-sm-4">CUIT de titular *</label>
                <div class="col-sm-8 col-wrap">
                    <input class="form-control" type="text" name="empb_cuit_titular" value="<?php echo $empresa['empb_cuit_titular'] ?>" />
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
        <div class="col gray">
            <a href="http://www.epsa.org.ar/promo/"> <img  src="../images/banner_guardavidas.jpg" /></a>
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
        dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sabado'],
        dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Juv', 'Vie', 'Sab'],
        dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
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

<script type="text/javascript">

    $(window).load(function() {



        jQuery.extend(jQuery.validator.messages, {
            required: "Este campo es obligatorio.",
            email: "Debe completar con un e-mail v&aacute;lido.",
            digits: "Debe completar solo con n&uacute;meros."

        });



        $("#formx").validate({
            lang: 'es',
            rules: {
                emp_nombre: "required",
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
                    minlength: 10,
                    maxlength: 11

                },
                empc_tel_movil: {
                    required: true,
                    digits: true,
                    minlength: 10,
                    maxlength: 11

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
                empc_dni: {
                    minlength: "La longitud m&iacute;nima debe ser 7",
                    maxlength: "La longitud m&aacute;xima debe ser 8",
                    digits: "Solo n&uacute;meros, por favor"
                },
                empb_cuit_titular: {
                    minlength: "La longitud m&iacute;nima debe ser 7",
                    maxlength: "La longitud m&aacute;xima debe ser 8"
                },
                emp_cuit: {
                    minlength: "La longitud debe ser 11",
                    maxlength: "La longitud debe ser 11",
                    digits: "Solo n&uacute;meros, por favor"
                }
            }
        });
    });
</script>
<?php
/* else:
  header('Location:' . $general_path . 'index_argit.php');
  endif; */
include_once dirname(__FILE__) . '/general/footer.php';
