<?php
$unirse = "blue";
require_once dirname(__FILE__) . '/general/header.php';
$provincias = getArrayQuery("SELECT * FROM provincias", $mysqli);
$localidades = getArrayQuery("SELECT * FROM localidades", $mysqli);

if (!isset($_SESSION['usuario'])) {
    header('Location:' . $general_path . 'login.php');
}

if (isset($_GET['user_id'])) {
    $u_id = addslashes(filter_input(INPUT_GET, "user_id"));

    if ($_SESSION['user_id'] != $u_id) {
        die('trata de modificar un usuario distinto al suyo');
    }
    $user = getRowQuery("SELECT *,(SELECT nombre FROM localidades WHERE id = localidad) localidad_nombre FROM inscribite_usuarios WHERE id = $user_id", $mysqli);
    ?>
    </div>
    <div class="titular row" id="toShow">
        <div class="title">
            <img src="../images/icon-registration.png" alt=""/>
            <h2>Formulario de Registro</h2>
            <h3>Esto es solo el comienzo</h3>
        </div>
    </div>
    <div class="columns-container row">
        <div class="col-sm-9">
            <form class="contact-form" method="POST" action="/altas/modificaUsuario.php" id="formis">
                <div class="row">
                    <label class="col-sm-4">Nombre *</label>
                    <div class="col-sm-8 col-wrap">
                        <input class="form-control" type="text" <?php if ($_GET['user_id']) echo "readonly" ?> name="nombre" value="<?php echo $user['nombre'] ?>" />
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-4">Apellido *</label>
                    <div class="col-sm-8 col-wrap">
                        <input class="form-control" type="text" <?php if ($_GET['user_id']) echo "readonly" ?> name="apellido"  value="<?php echo $user['apellido'] ?>" />
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-4">DNI *</label>
                    <div class="col-sm-8 col-wrap">
                        <input class="form-control" name="documento" <?php if ($_GET['user_id']) echo "readonly" ?> type="text" value="<?php
                        if ($_GET['user_id'])
                            echo $user['dni'];
                        else
                            echo filter_input(INPUT_GET, "dni")
                            ?>" />
                    </div>
                </div>
                <br/>
                <div class="row">
                    <label class="col-sm-4">Fecha de nacimiento *</label>
                    <div class="col-sm-8 col-wrap">
                        <input class="form-control" type="text" <?php if ($_GET['user_id']) echo "readonly" ?> name="fechanac" value="<?php echo date('d-m-Y', strtotime($user['fechanac'])) ?>" id="datepicker" placeholder="Ej: dd/mm/aaaa"/>
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-4">Sexo *</label>
                    <div class="col-sm-8 col-wrap">
                        <select class="form-control" name="sexo">
                            <option disabled="" selected=""></option>
                            <option value="masculino" <?php if ($user['sexo'] == 'masculino') echo 'selected' ?> >Masculino</option>
                            <option value="femenino" <?php if ($user['sexo'] == 'femenino') echo 'selected' ?> >Femenino</option>
                        </select>
                    </div>
                </div>
                <br/>
                <div class="row">
                    <label class="col-sm-4">Email *</label>
                    <div class="col-sm-8 col-wrap">
                        <input class="form-control" type="email" name="email" value="<?php echo $user['email'] ?>" />
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-4">Elegir contraseña *</label>
                    <div class="col-sm-8 col-wrap">
                        <input class="form-control" type="password" name="password"  value="<?php echo $user['password'] ?>" />
                    </div>
                </div>
                <br/>
                <div class="row">
                    <label class="col-sm-4">Teléfono Particular *</label>
                    <div class="col-sm-8 col-wrap">
                        <input class="form-control" type="text" name="telefonoparticular" value="<?php echo $user['telefonoparticular'] ?>" />
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-4">Teléfono Laboral</label>
                    <div class="col-sm-8 col-wrap">
                        <input class="form-control" type="text" name="telefonolaboral" value="<?php echo $user['telefonolaboral'] ?>" />
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-4">Teléfono Celular</label>
                    <div class="col-sm-8 col-wrap">
                        <input class="form-control" type="text" name="telefonocelular" value="<?php echo $user['telefonocelular'] ?>" />
                    </div>
                </div>
                <br/>
                <div class="row">
                    <label class="col-sm-4">Domicilio</label>
                    <div class="col-sm-8 col-wrap">
                        <input class="form-control" type="text" name="domicilio"  value="<?php echo $user['domicilio'] ?>" />
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-4">Pa&iacute;s *</label>
                    <div class="col-sm-8 col-wrap">
                        <select class="form-control" name="pais">
                            <option disabled="" selected=""></option>
                            <option value="argentina" <?php if ($user['pais'] == 'argentina') echo 'selected' ?> >Argentina</option>
                            <option value="brazil" <?php if ($user['pais'] == 'brazil') echo 'selected' ?> >Brazil</option>
                            <option value="colombia" <?php if ($user['pais'] == 'colombia') echo 'selected' ?> >Colombia</option>
                            <option value="chile" <?php if ($user['pais'] == 'chile') echo 'selected' ?> >Chile</option>
                            <option value="ecuador" <?php if ($user['pais'] == 'ecuador') echo 'selected' ?> >Ecuador</option>
                            <option value="paraguay" <?php if ($user['pais'] == 'paraguay') echo 'selected' ?> >Paraguay</option>
                            <option value="peru" <?php if ($user['pais'] == 'peru') echo 'selected' ?> >Per&uacute;</option>
                            <option value="uruguay" <?php if ($user['pais'] == 'uruguay') echo 'selected' ?> >Uruguay</option>
                            <option value="venezuela" <?php if ($user['pais'] == 'venezuela') echo 'selected' ?> >Venezuela</option>
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
                                if ($item['id'] == $user['provincia']) {
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
                        <select class="form-control" name="localidad" id="localidades_select">
                            <option value="<?= $user['localidad'] ?>"><?= $user['localidad_nombre'] ?></option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="btns">
                        <span class="btn pull-left col-xs-12 col-sm-7 col-md-6">Los campos con ( * ) son obligatorios</span>
                        <input class="btn green pull-right col-xs-12 col-sm-3" type="submit" value="actualizar"/>
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
    </script>

    <script src="../js/jquery.validate.min.js"></script>
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
                    documento: {
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
                    documento: {
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
    <?php
}
include_once dirname(__FILE__) . '/general/footer.php';

