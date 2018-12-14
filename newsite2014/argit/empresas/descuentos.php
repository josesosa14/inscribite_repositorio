<?php
$descuentos = "blue";
require_once dirname(__FILE__) . '/../general/header_empresa.php';
echo '</div>';

$query = "SELECT * FROM  inscribite_eventos WHERE empresa = '{$_SESSION['empresa_nombre']}' AND ver = 1";
$eventos = getArrayQuery($query, $mysqli);

$query = "SELECT * FROM  inscribite_eventos WHERE ver = 1";
$eventos_all = getArrayQuery($query, $mysqli);

$query = "SELECT *,(SELECT nombre FROM inscribite_eventos WHERE codigo = codevento) as evento FROM inscribite_descuentos 
			INNER JOIN inscribite_usuarios u ON u.dni = coddni
			WHERE codevento in 
			(SELECT codigo FROM inscribite_eventos WHERE empresa = '{$_SESSION['empresa_nombre']}' AND ver = 1)";
$descuentos = getArrayQuery($query, $mysqli);
?>

<?php if ($descuentos): ?>
    <div class="row">
        <table border="1" style="width:100%;text-align:center" id="toShow">
            <tr>
                <th style="text-align:center">Evento</th>
                <th style="text-align:center">Nombre</th>
				<th style="text-align:center">Dni</th>
                <th style="text-align:center">Porcentaje</th>
                <th style="text-align:center">Fecha Usado</th>  
				
            </tr>

            <?php
            foreach ($descuentos as $descuento) {
                echo '<tr>
                <td>' . $descuento['evento'] . '</td>
                <td>' . $descuento['nombre'] . ' '.$descuento['apellido'].'</td>
				<td>' . $descuento['coddni'] . '</td>
                <td>' . $descuento['porcentajedescuento'] . '</td>
                <td>' . $descuento['fechausado'] . '</td>
            ';
                echo "</tr>";
            }
            ?>
        </table>
    </div>
    <?php
else:
    echo '<h3>No tiene descuentos</h3>';
endif;
?>


<div class="col-xs-6">
    <h3>Nueva descuento</h3>
    <form class="contact-form" method="POST" id="formis" action="/empresas/altaDescuento.php">
        <div class="row">
            <label class="col-sm-4">Eventos</label>
            <div class="col-sm-8 col-wrap">
                <select class="form-control" name="codevento" id="eventos">
                    <?php
                    foreach ($eventos as $evento) {
                        echo '<option value = "' . $evento['codigo'] . '" >' . $evento['nombre'] . '</option>';
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="row">
            <label class="col-sm-4">Dni</label>
            <div class="col-sm-8 col-wrap">
                <input class="form-control" type="text" name="coddni" id="dni" />
            </div>
        </div>
        <div class="row">
            <label class="col-sm-4">Porcentaje</label>
            <div class="col-sm-8 col-wrap">
                <input class="form-control" type="text" id="descuento" name="porcentajedescuento" />
            </div>
        </div>
        <input type="submit" class="form-control" id="confirmar" value="Cargar descuento"/>
    </form>
</div>


<?php if ($_SESSION['empresa_nombre'] == 'maritimo srl'): ?>
    <div class="col-xs-6">
        <h3>Descuento multiple</h3>
        <form class="contact-form" method="POST" id="formis" action="/empresas/altaDescuentoMultiple.php" enctype="multipart/form-data">
    <?php /*
      <div class="row">
      <label class="col-sm-4">Eventos</label>

      <div class="col-sm-8 col-wrap">
      <select class="form-control" name="codevento" id="eventos">
      <?php
      foreach ($eventos_all as $evento) {
      echo '<option value = "' . $evento['codigo'] . '" >' . $evento['nombre'] . '</option>';
      }
      ?>
      </select>
      </div>
      </div> */ ?>
            <div class="col-sm-7 col-md-6">
                <div class="row">
                    <div class="select-file">
                        <input type="file" name="descuentos" accept=".xls,.xlsx"/>
                    </div>
                </div>                                        
            </div>

            <input type="submit" class="form-control" id="confirmar" value="Descuento multiple"/>
        </form>
        <div class="buttons">
            <a class="form-control" href="/empresas/deleteDescuentos.php">Borra descuentos usados</a>
        </div>
    </div>
<?php endif; ?>

<script>
    $("#confirmar").click(function(event) {
        event.preventDefault();
        var evento = $('#eventos').val();
        var dni = $('#dni').val();
        var porcentaje = $('#descuento').val();
        $.ajax({
            url: "/empresas/altaDescuento.php",
            type: "POST",
            async: false,
            data: {codevento: evento, coddni: dni, porcentajedescuento: porcentaje}
        })
                .done(function(data) {
                    $("#mensaje1").empty();
                    $("#mensaje1").append("Su descuento fue cargado.");
                    $("#mensaje2").empty();
                    $("#mensaje2").append("Ser&aacute; redireccionado.");
                    $('.modalMessage').modal();
                    $("#confirmar").prop('disabled', true);
                    $('.modalMessage').on('hidden.bs.modal', function(e) {
                        location.href = '<?= $general_path ?>empresas/descuentos.php';
                    });
                });
    });
</script>

<?php if (isset($_GET['envio'])) { ?>
    <script>
        $(document).ready(function() {
            $("#mensaje1").empty();
            $("#mensaje1").append("Los descuentos fueron almacenados.");
            $("#mensaje2").empty();
            $("#mensaje2").append("El archivo de descuento fue cargado con éxito.");
            $("#mensaje3").empty();
            $("#mensaje3").append("Si hay problemas, llame a Arg-IT.");
            $('.modalMessage').modal();
        });
    </script>
<?php } ?>


<!-- Modal -->
<div class="modal fade modalMessage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="alert">
                    <h2><span id="mensaje1"></span></h2>
                    <h3><span id="mensaje2"></span></h3>
                </div>
                <center><p id="mensaje3">Si tiene problemas, llame al (11) 4641-4423</p></center>
            </div>
        </div>
    </div>
</div><!-- /.modal -->
<?php
require_once dirname(__FILE__) . '/general/footer.php';
