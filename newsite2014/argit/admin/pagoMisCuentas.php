<?php
$pagar = "blue";
die('asd');
require_once dirname(__FILE__).'/general/header.php';
echo '</div>';

$query = "SELECT * FROM  facturas WHERE fac_fecha_pago is null and (fac_tipo = 0 OR fac_tipo = 1)";
$facturas = getArrayQuery($query, $mysqli);
?>

<div class="row">
    <form method="post" action="../pagoMisCuentas/archivoFactura.php" id="formx">
        <table>
            <tr>
                <th>Seleccionar</th>
                <th>Id</th>
                <th>Usuario</th>
                <th>Evento</th>
                <th>Categoria</th>
                <th>Opcion</th>            
                <th>Vencimiento</th>
            </tr>

            <?php
            foreach ($facturas as $factura) {
                echo "<tr>
                <td><input type='checkbox' name='facturas[]' value='$factura[fac_id]' /></td>                
                <td>$factura[fac_id]</td>
                <td>$factura[fac_usu_id]</td>
                <td>$factura[fac_evento_id]</td>
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
                        rules: {
                            facturas[]: {
                                required: true,
                                minlength: 1,
                                
                            }
                        },
                        messages: {
                            facturas[]: {
                                
                                minlength: "M&iacute;nimo 1 seleccionado",
                                
                            }
                        }
                    });
                });
</script>


<?php 
require_once dirname(__FILE__).'/general/footer.php';
?>