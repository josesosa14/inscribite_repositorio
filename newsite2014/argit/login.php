<?php
$login = "blue";
include_once 'general/header.php';
?>


<div class="col-xs-12 col-sm-6 col-md-5 pull-right login-container">
    <?php if (empty($usuario)) : ?>
        <div class="head">
            Inicia sesión para continuar
        </div>
        <form method="POST" action="altas/login.php" id="formx">
            <input name="usuario" type="text" placeholder="Ingresar DNI" value="<?= filter_input(INPUT_GET, 'dni') ?>" class="form-control" id="dniUsuario" autocomplete="off"/>
            <input name="pass" type="password"  placeholder="Ingresar contraseña" class="form-control" autocomplete="off" />
            <!-- BOX DE RECUPERAR CONTRASEÑA -->
            <script>
                $(document).ready(function() {
                    $("#recuperarContraseña").click(function(evento) {
                        evento.preventDefault();
                        var dniUsuario = $("#dniUsuario").val();
                        if (dniUsuario.length >= 7 && dniUsuario.length <= 8 && $.isNumeric(dniUsuario)) {
                            respuesta = 0;
                            dato = 0;
                            respuesta = $.ajax({
                                type: "POST",
                                url: 'http://www.inscribiteonline.com.ar/general/reenviar_password.php',
                                data: {'action': 'checkEmail', 'dni': dniUsuario},
                                async: false,
                            })
                                    .done(function(msg) {
                                        if (msg == 2) {
                                            $("#mensaje1").empty();
                                            $(".alert").css("background-color", "rgb(255,0,0)");
                                            $("#mensaje1").append("DNI no encontrado.");
                                            $("#mensaje2").empty();
                                            $("#mensaje2").append("Corrija el DNI ingresado por favor");
                                            $("#mensaje3").empty();
                                            $("#mensaje3").append("Si estás registrado y seguis con problemas comunicate a info@inscribiteonline.com.ar");
                                            dato = msg;
                                        } else {
                                            $("#mensaje1").empty();
                                            $(".alert").css("background-color", "#4eb4e1)");
                                            $("#mensaje1").append("Tu contraseña fue enviada a tu correo.");
                                            $("#mensaje2").empty();
                                            $("#mensaje2").append("Revise su correo por favor");
                                            $("#mensaje3").empty();
                                            $("#mensaje3").append("Revise la carpeta SPAM por las dudas y si seguis con problemas comunicate a info@inscribiteonline.com.ar");
                                        }
                                    });

                            $('.modalMessage').modal();
                        } else {
                            $("#mensaje1").empty();
                            $("#mensaje1").append("Por favor, complete con un dni válido");
                            $("#mensaje2").empty();
                            $("#mensaje2").append("DNI argentino entre 7 y 8 números");
                            $("#mensaje3").empty();
                            $("#mensaje3").append("Si contin&uacute;as con inconvenientes, comunicate a info@inscribiteonline.com.ar");
                            $('.modalMessage').modal();
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
                                <h2><span id="mensaje1">...</span></h2>
                                <h3><span id="mensaje2">...</span></h3>
                            </div>
                            <center><p><span id="mensaje3">Si este email es incorrecto comunicate a info@inscribiteonline.com.ar</span></p></center>
                        </div>
                    </div>
                </div>
            </div><!-- /.modal -->
            <?php if (isset($_GET['dni'])) { ?>
                <script>
                    $("#mensaje1").empty();
                    $(".alert").css("background-color", "rgb(255,0,0)");
                    $("#mensaje1").append("Ha ingresado mal su contraseña");
                    $("#mensaje2").empty();
                    $("#mensaje2").append("Por favor complete con una contraseña válida");
                    $("#mensaje3").empty();
                    $("#mensaje3").append("Si continúa con problemas, haga click en olvidé mi contraseña");
                    $('.modalMessage').modal();
                </script>
            <?php } ?>

            <!-- BOX DE RECUPERAR CONTRASEÑA -->
            <div class="left">
                <div><a href="login.php" id="recuperarContraseña" style="color:grey">Olvidaste tu contraseña?</a></div>
                <a href="unirse.php">No tengo cuenta. Registrarme</a>
            </div>
            <div class="right">
                <input type="submit" value="ingresar" class="btn green" />
            </div>
            <div class="clear"></div>
        </form>
    <?php else : ?>
        <div class="head">
            Logeado con el DNI: <?php echo $usuario ?>
        </div>
        <div class="row">
            <a href="miCuenta.php">Ver Mi cuenta</a>
            <a href="pagar.php">Que pagar</a>
        </div>
    <?php endif; ?>
</div>
</div>
<div class="titular steps row">
    <div class="col-xs-12">
        <div class="row">
            <div class="step col-xs-6 col-sm-3">
                <img src="../images/step-1.png" class="img-responsive" alt="" />
                <h3>PRIMER PASO</h3>
                <p>Registrese en InscribiteOnline.com.ar completando tus datos.</p>
            </div>
            <div class="step col-xs-6 col-sm-3">
                <img src="../images/step-2.png" class="img-responsive" alt="" />
                <h3>SEGUNDO PASO</h3>
                <p>Busque el evento al que se quiere inscribir y confirme su inscripción.</p>
            </div>
            <div class="step col-xs-6 col-sm-3">
                <img src="../images/step-3.png" class="img-responsive" alt="" />
                <h3>TERCERO PASO</h3>
                <p>Para finalizar la inscripción, seleccione una forma de pago e imprima su boleta.</p>
            </div>
            <div class="step col-xs-6 col-sm-3">
                <img src="../images/step-4.png" class="img-responsive" alt="" />
                <h3>CUARTO PASO</h3>
                <p>Puede abonar con cualquier medio de pago en cualquier centro adherido.</p>
            </div>
        </div>
    </div>
</div>
<!--<div class="columns-container gray row">
    <div class="col-xs-12">
        <div class="row">
            <div class="col-xs-6 col-wrap">
                <div class="col gray">

                </div>
            </div>
            <div class="col-xs-6 col-wrap">
                <div class="col gray">

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-wrap">
                <div class="col gray">

                </div>
            </div>
        </div>
    </div>
</div>-->
<script src="../js/jquery.validate.min.js"></script>
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
                        usuario: {
                            required: true,
                            minlength: 7,
                            maxlength: 8,
                            digits: true,
                        },
                        pass: {
                            alphanumeric: false,
                        }
                    },
                    messages: {
                        usuario: {
                            digits: "Solo n&uacute;meros, por favor",
                            minlength: "M&iacute;nimo 7 caracteres",
                            maxlength: "M&aacute;ximo 8 caracteres",
                        }
                    }
                });
            });
</script>

<?php
include_once dirname(__FILE__) . '/general/footer.php';
?>