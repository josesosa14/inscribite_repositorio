<?php
$pagar = "blue";
require_once dirname(__FILE__) . '/general/header_transferencias.php';
echo '</div>';

$query = "SELECT * FROM  transferencias  
			INNER JOIN empresa ON emp_id = tra_emp_id 
			LEFT JOIN inscribite_eventos ON id = tra_evento_id
			ORDER BY emp_id DESC";
$transferencias = getArrayQuery($query, $mysqli);

$query = "SELECT emp_id,emp_nombre FROM empresa ORDER BY emp_nombre ASC";
$empresas = getArrayQuery($query, $mysqli);
?>

<?php if ($transferencias): ?>
    <div class="row">
        <table border="1" style="width:100%;text-align:center">
            <tr>
                <th style="text-align:center">Nro Evento</th>
				<th style="text-align:center">Codigo Evento</th>
                <th style="text-align:center" >Empresa</th>
                <th style="text-align:center">Monto</th>
                <th style="text-align:center">Fecha Pago</th>
                <th style="text-align:center">Recibida</th>            
            </tr>

            <?php
            foreach ($transferencias as $transferencia) {
                echo "<tr>
                <td>$transferencia[tra_evento_id]</td>
				<td>$transferencia[codigo]</td>
                <td>$transferencia[emp_nombre]</td>
                <td>$transferencia[tra_monto]</td>
                <td>$transferencia[tra_fecha_pago]</td>
                <td>$transferencia[tra_recibida]</td>
            ";
                echo "</tr>";
            }
            ?>
        </table>
    </div>
    <?php
else:
    echo '<h3>No tiene transferencias</h3>';
endif;
?>

<br><br><br>
<h3>Nueva transferencia</h3>
<form class="contact-form" method="POST" id="formis" action="<?= $general_path ?>altas/transferencia.php">
    <div class="row">
        <label class="col-sm-4">Empresa</label>
        <div class="col-sm-8 col-wrap">
            <select class="form-control" name="tra_emp_id" id="empresas">
                <?php
                foreach ($empresas as $empresa) {
                    echo '<option value = "' . $empresa['emp_id'] . '" >' . $empresa['emp_nombre'] . '</option>';
                }
                ?>
            </select>
        </div>
    </div>
	<div class="row">
        <label class="col-sm-4">Eventos</label>
        <div class="col-sm-8 col-wrap">
            <select class="form-control" name="tra_evento_id" id="eventos" required>
            </select>
        </div>
    </div>
    <div class="row">
        <label class="col-sm-4">Fecha de Pago</label>
        <div class="col-sm-8 col-wrap">
            <input class="form-control" type="text" name="tra_fecha_pago" id="datepicker" />
        </div>
    </div>
    <div class="row">
        <label class="col-sm-4">Monto</label>
        <div class="col-sm-8 col-wrap">
            <input class="form-control" type="text" name="tra_monto" placeholder="123.12"/>
        </div>
    </div>
    <div class="row">
        <div class="btns">
            <input class="btn green pull-right col-xs-12 col-sm-3" type="submit" value="Cargar"/>
            <div class="clear"></div>
        </div>
    </div>
</form>

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
	
	$("#empresas").change(function() {
		var empresa_id = $(this).val();
		$('#eventos').find('option').remove().end();
		$('#eventos').load('<?PHP echo $general_path;?>altas/getEventos.php?emp_id=' + empresa_id);
	});	
</script>

<?php
require_once dirname(__FILE__) . '/general/footer.php';
