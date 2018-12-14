<?php
$contacto = "blue";
require_once dirname(__FILE__) . '/general/header.php';
$datos = filter_input(INPUT_GET, 'datos');
if (!isset($_GET['email'])) {
    $_GET['email'] = null;
}

if ($datos == "false") {
    $nombre = filter_input(INPUT_GET, 'nombre');
    $email = filter_input(INPUT_GET, 'email');
    $empresa = filter_input(INPUT_GET, 'empresa');
    $telefono = filter_input(INPUT_GET, 'telefono');
    
    ?>
    <script>
        $(document).ready(function() {
            $('.modalMessage').modal();
        });

    </script>
    <!-- Modal -->
    <div class="modal fade modalMessage " tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="alert head" style="background-color: red">
                        <h2><span id="mensaje1">Hay datos incorrectos</span></h2>
                        <h3><span id="mensaje2">Reviselos y vuelva a enviar su consulta </span></h3>
                    </div>
                    <center><p>Cualquier duda, comunicate al (11) 4641-4423</p></center>
                </div>
            </div>
        </div>
    </div><!-- /.modal -->
    <?php
} elseif ($_GET['email'] == "true") {

    $nombre = null;
    $email = null;
    $empresa = null;
    $telefono = null;
    ?>
    <script>
        $(document).ready(function() {
            $('.modalMessage').modal();
        });

    </script>
    <!-- Modal -->
    <div class="modal fade modalMessage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="alert">
                        <h2><span id="mensaje1">Su consulta fue enviada</span></h2>
                        <h3><span id="mensaje2">Pronto se comunicarán con Usted </span></h3>
                    </div>
                    <center><p>Cualquier duda, comunicate al (11) 4641-4423</p></center>
                </div>
            </div>
        </div>
    </div><!-- /.modal -->
    <?php
} else {
    $nombre = null;
    $email = null;
    $empresa = null;
    $telefono = null;
}
?>
</div>
<div class="titular row">
    <div class="title">
        <img src="../images/icon-contact.png" alt=""/>
        <h2>Formulario de Contacto</h2>
        <h3>Solicitá un promotor</h3>
    </div>
</div>
<div class="columns-container row" id="toShow">
    <div class="col-sm-9">
        <form class="contact-form" action="general/mail_consulta.php" method="post" id="formx">
            <div class="row">
                <label class="col-sm-4">Nombre *</label>
                <div class="col-sm-8 col-wrap">
                    <input class="form-control" type="text" name="cpm_nombre" value="<?php echo $nombre; ?>"/>
                </div>
            </div>
            <div class="row">
                <label class="col-sm-4">Empresa </label>
                <div class="col-sm-8 col-wrap">
                    <input class="form-control" type="text" name="cpm_empresa" value="<?php echo $empresa; ?>"/>
                </div>
            </div>
            <div class="row">
                <label class="col-sm-4">Email *</label>
                <div class="col-sm-8 col-wrap">
                    <input class="form-control" type="email" name="cpm_email" value="<?php echo $email; ?>"/>
                </div>
            </div>
            <div class="row">
                <label class="col-sm-4">Teléfono de Contacto </label>
                <div class="col-sm-8 col-wrap">
                    <input class="form-control" type="text" name="cpm_telefono" value="<?php echo $telefono; ?>"/>
                </div>
            </div>
            <div class="row">
                <label class="col-sm-4">Consulta *</label>
                <div class="col-sm-8 col-wrap">
                    <textarea class="form-control" name="cpm_textoconsulta"></textarea>
                </div>
            </div>
            <div class="row">
                <div class="btns">
                    <span class="btn pull-left col-xs-12 col-sm-7 col-md-6">Los campos con ( * ) son obligatorios</span>
                    <input class="btn green pull-right col-xs-12 col-sm-3" type="submit" value="Enviar"/>
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

<?php 
include_once dirname(__FILE__) . '/general/footer.php'; 
?>
