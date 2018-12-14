<?php
$transferencia = "blue";
require_once dirname(__FILE__) . '/../general/header_empresa.php';
echo '</div>';

$query = "SELECT * FROM  transferencias WHERE tra_emp_id = {$_SESSION['empresa']} ORDER BY tra_id";

$transferencias = getArrayQuery($query, $mysqli);
?>

<?php if ($transferencias): ?>
    <div class="row">
        <table border="1" style="width:100%;text-align:center" id="toShow">
            <tr>
                <th style="text-align:center">Id</th>
                <th style="text-align:center">Monto</th>
                <th style="text-align:center">Fecha Pago</th>
                <th style="text-align:center">Recibida</th>          
				<th style="text-align:center">Acci&oacute;n</th>
            </tr>

            <?php
            foreach ($transferencias as $transferencia) {
                echo '<tr>
                <td>'.$transferencia['tra_id'].'</td>
                <td>'.$transferencia['tra_monto'].'</td>
                <td>'.$transferencia['tra_fecha_pago'].'</td>
                <td>'.$transferencia['tra_recibida'].'</td>
				<td>';
					if($transferencia['tra_recibida']){
						echo '<span>Recibida</span>';
					}else{
						echo '<a href="altas/confirmar_transferencia.php?tra_id='.$transferencia['tra_id'].'" >Recibir</a>';
					}
				echo '</td>
            ';
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

<?php
require_once dirname(__FILE__) . '/general/footer.php';
