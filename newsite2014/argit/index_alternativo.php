<?php
$inicio = "blue";
require_once dirname(__FILE__) . '/general/header.php';
?>

<div class="col-xs-12 col-sm-6 col-md-5 pull-right login-container">
    <?php if (empty($usuario)) : ?>
        <div class="head">
            Inicia sesión para continuar
        </div>
        <form method="POST" action="altas/login.php" id="formx">
            <input name="usuario" type="text" placeholder="Ingresar DNI" value="<?= filter_input(INPUT_GET, 'dni') ?>" class="form-control" id="dniUsuario" autocomplete="off"/>
            <input name="pass" type="hidden"  placeholder="Ingrese su contraseña para ingresar" class="form-control" autocomplete="off" id="passworx"/>
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
                                url: '<?PHP echo $general_path;?>general/reenviar_password.php',
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
                                            $("#mensaje3").append("Si estás registrado y seguis con problemas comunicate al (11) 4641-4423");
                                            dato = msg;
                                        } else {
                                            $("#mensaje1").empty();
                                            $(".alert").css("background-color", "#4eb4e1)");
                                            $("#mensaje1").append("Tu contraseña fue enviada a tu correo.");
                                            $("#mensaje2").empty();
                                            $("#mensaje2").append("Revise su correo por favor");
                                            $("#mensaje3").empty();
                                            $("#mensaje3").append("Revise la carpeta SPAM por las dudas y si seguis con problemas comunicate al (11) 4641-4423");
                                        }
                                    });

                            $('.modalMessage').modal();
                        } else {
                            $("#mensaje1").empty();
                            $("#mensaje1").append("Por favor, complete con un dni válido");
                            $("#mensaje2").empty();
                            $("#mensaje2").append("DNI argentino entre 7 y 8 números");
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
                            <center><p><span id="mensaje3">Si este email es incorrecto comunicate al (11) 4641-4423</span></p></center>
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
                <input type="submit" value="Ingresar" class="btn green" id="btIngresar" style="display:none;"/>
                <a href="#" class="btn green new" id="btActions">Continuar</a>
            </div>
            <div class="clear"></div>
        </form>
        <script>
            $("#btActions").click(function(evento) {
                flag = 0;
                evento.preventDefault();
                var dniUsuario = $("#dniUsuario").val();
                if (dniUsuario.length >= 7 && dniUsuario.length <= 8 && $.isNumeric(dniUsuario)) {
                    respuesta = 0;
                    dato = 0;
                    respuesta = $.ajax({
                        type: "POST",
                        url: '<?PHP echo $general_path;?>general/buscar_dni.php',
                        data: {'action': 'checkDni', 'dni': dniUsuario},
                        async: false,
                    })
                            .done(function(msg) {
                                if (msg == 1) {
                                    $('#passworx').attr('type', 'password');
                                    $('#btActions').css('display', 'none');
                                    $('#btIngresar').css('display', 'block');
                                } else {
                                    $("#mensaje1").empty();
                                    $("#mensaje1").append("Su DNI no se encuentra registrado");
                                    $("#mensaje2").empty();
                                    $("#mensaje2").append("Verifique sus datos y si no está registrado haga click en Unirse");
                                    $("#mensaje3").empty();
                                    $("#mensaje3").append('Para registrarse haga click <a href="<?PHP echo $general_path;?>unirse.php">aquí<a/>');
                                    $('.modalMessage').modal();
                                }
                            });
                } else {
                    $("#mensaje1").empty();
                    $("#mensaje1").append("Por favor, complete con un dni válido");
                    $("#mensaje2").empty();
                    $("#mensaje2").append("DNI argentino entre 7 y 8 números");
                    $('.modalMessage').modal();
                }
            });
        </script>
		<style>
		.btn.green.new {
			font-size: 20px;
			width: 100% !important;
		}
		</style>  
    <?php else : ?>
        <div class="head">
            Logeado con el DNI: <?php echo $usuario ?>
        </div>
        <div class="row">
            <a href="/../miCuenta.php">Mi cuenta</a>
            &nbsp;&nbsp;&nbsp;
            <a href="/../pagar.php#toShow">Inscripci&oacute;n a eventos</a>
        </div>
    <?php endif; ?>
</div>



<a href="<?php echo $unirse_path ?>" class="circle">
    Fácil,comodo <br/> y seguro: <br/> Tu inscripción en solo tres clicks
</a>
</div>
<div class="titular row">
    <div class="text">
        <a href="<?php echo $general_path ?>nosotros.php">
            <span>¿Organizas un evento?</span>
            <br />
            Más información sobre InscribiteOnline
        </a>
    </div>
</div>

<?php
include_once dirname(__FILE__) . '/general/footer.php';
?>