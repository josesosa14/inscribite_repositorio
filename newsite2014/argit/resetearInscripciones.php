<?php
$pagar = "blue";
require_once dirname(__FILE__) . '/general/header.php';
echo '</div>';

if($_SESSION['admin'] == 'inscribite'){

$query = "SELECT fac_fecha_pedido,fac_id,fac_usu_id,dni,inscribite_eventos.nombre as nombre,fac_cat_id,fac_op_id,fac_venc1
 FROM  facturas 
 INNER JOIN inscribite_usuarios ON inscribite_usuarios.id = fac_usu_id 
 INNER JOIN inscribite_eventos ON codigo = fac_evento_id WHERE fac_pedido = 1 ORDER BY fac_id DESC";
$facturas = getArrayQuery($query, $mysqli);
?>


<?php if ($facturas): ?>
<h3>Inscripciones pedidas, no necesariamente enviadas a PMC</h3>
    <div class="row">
        <form method="post" action="http://www.inscribiteonline.com.ar/newsite2014/argit/pagoMisCuentas/resetearInscripciones.php" id="formx">
            <table border="1" style="width:100%;text-align:center">
                <tr>
                    <th style="text-align:center">Seleccionar</th>
                    <th style="text-align:center">Fecha Pedido</th>
					<th style="text-align:center">Id</th>
                    <th style="text-align:center" >Usuario</th>
					<th style="text-align:center" >Dni</th>
                    <th style="text-align:center">Evento</th>
                    <th style="text-align:center">Categoria</th>
                    <th style="text-align:center">Opcion</th>            
                    <th style="text-align:center">Vencimiento</th>
                </tr>

                <?php
                foreach ($facturas as $factura) {
                    echo "<tr>
                <td><input style='visibility:visible' type='checkbox' name='facturas[]' value='$factura[fac_id]' /></td>                
                <td>$factura[fac_fecha_pedido]</td>
				<td>$factura[fac_id]</td>
                <td>$factura[fac_usu_id]</td>
				<td>$factura[dni]</td>
                <td>$factura[nombre]</td>
                <td>$factura[fac_cat_id]</td>
                <td>$factura[fac_op_id]</td>
                <td>$factura[fac_venc1]</td>
            ";
                    echo "</tr>";
                }
                ?>
            </table>
            <input type="submit" value="Enviar" />
        </form>
    </div>
    <?php
else:
    echo '<h3>No tiene archivos para facturar</h3>';
endif;
?>
<br><br><br>


<script src="../js/jquery.validate.min.js"></script>
<script>
                $(window).load(function() {
                   
					
                    $("#formx").validate({
                        rules: {
                            "facturas[]": {
                                required: true,
                                minlength: 1,
                                
                            }
                        },
                        messages: {
                            "facturas[]": {
                                required:"M&iacute;nimo 1 seleccionado",
                                minlength: "M&iacute;nimo 1 seleccionado",
                                
                            }
                        }
                    });
                });
</script>



<?php

}else{
echo 'No se encuentra logeado, <a href="http://www.inscribiteonline.com.ar/newsite2014/admin/">iniciar sesion</a>';
}

require_once dirname(__FILE__) . '/general/footer.php';
