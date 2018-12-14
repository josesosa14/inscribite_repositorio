<?php
$inscripcion = "blue";
$pagar = "blue";
require_once dirname(__FILE__) . '/general/header.php';
?>
</div>
<?php
global $usuario;
$men_id = addslashes(filter_var(filter_input(INPUT_GET, 'men_id'), FILTER_SANITIZE_STRING));

//info del usuario
$query = "SELECT *,TIMESTAMPDIFF(YEAR,CONCAT(SUBSTRING((CONVERT(fechanac,CHAR(4))),1,4),'-',
	SUBSTRING((CONVERT(fechanac,CHAR(6))),5,5),'-',
	SUBSTRING((CONVERT(fechanac,CHAR(8))),7,7)),CURDATE()) as edad 
	FROM inscribite_usuarios WHERE dni=$usuario";
$user_info = getRowQuery($query, $mysqli);

//info de las cuotas de la mensualidad
$query = "select * from mensualidades 
inner join mensualidad_cuotas on mec_men_id = men_id
left join facturas on fac_mensualidad = mec_id and fac_usu_id = {$_SESSION['user_id']} and fac_anulado=0
left join mensualidad_cuota_usuario on meu_mec_id = mec_id and meu_u_dni = {$_SESSION['usuario']}
where men_id = $men_id ";

if(esAdmin()){
	echo $query;
}
$cuotas = getArrayQuery($query, $mysqli);


foreach ($cuotas as $cada_cuota){
	if(!$cada_cuota['meu_importe']){
		$cuota = $cada_cuota;
		break;
	}
}


$query = "SELECT meu_men_id FROM mensualidad_usuario WHERE meu_u_dni = {$_SESSION['usuario']} AND meu_men_id = $men_id";
$tieneMensualidad = getRowQuery($query,$mysqli);
if(!$tieneMensualidad){
	$parameters['meu_men_id'] = $men_id;
	$parameters['meu_u_dni'] = $_SESSION['usuario'];
	$parameters['meu_fecha_in'] = date('Y-m-d h:i:s');
	insertRow('mensualidad_usuario',$parameters,$mysqli);
}

$query = "select men_nombre from mensualidades where men_id = $men_id";
$mensualidad = getRowQuery($query, $mysqli);

?>

<div class="titular row">
    <div class="title col-sm-9">
        <img src="../images/icon-event.png" alt=""/>
        <h2>Inscripci&oacute;n a Mensualidad</h2>
        <h3><?php echo $mensualidad['men_nombre']; ?></h3>
    </div>
    <div class="col-sm-3"><?php
if (!$usuario) {
    echo 'No est&aacute; logead, ingrese con DNI';
} else {
    echo '<span class="btn">' . $user_info['nombre'] . ' ' . $user_info['apellido'] . '</span>
			<a href="' . $general_path . 'modificaUsuario.php?user_id=' . $user_info['id'] . '">Ver / Cambiar mis datos</a>
			<a href="' . $general_path . 'logout.php">Cambiar usuario/Cerrar sesi&oacute;n</a>';
}
?>
    </div>
</div>
<div class="clear"></div>

<form method="POST" action="/medioDePagoMensualidad.php#toShow" id="formx">

    <div class="columns-container row">
        <div class="col-sm-9 reservation" id="toShow">
            <div class="alert">
                <div class="head">
                    Leer con atenci&oacute;n!
                </div>
            </div>
<?php
if($cuota && !$cuota['fac_id']):
    
	echo '<label style="color:black">Cuota a pagar:</label>';
    echo '<select name="mec_id" id="mes">';
        echo '<option value="' . $cuota['mec_id'] . '">' . $cuota['mec_nro_cuota'] . '</option>';

    echo '</select><br><br>';
	
?>
            <p>
                Usted est&aacute; por inscribirse a la mensualidad <span style="text-decoration:underline"><?php echo $cuota['men_nombre'] ?></span>. Recuerde que puede ver el estado de sus cuotas
				en su panel principal.
            </p>

            <div class="terms">
                <div class="termsCheck">
                    <input type="checkbox" value="None" id="termsCheck" name="check" />
                    <label for="termsCheck"></label>
                </div>
                ACEPTO CADA UNA DE LAS CONDICIONES Y REGLAMENTO QUE EXPRESA LA ENTIDAD DE LA MENSUALIDAD A INSCRIBIRSE. 
            </div>
            <div class="btns">
                <input class="btn green pull-right" type="submit" id="confirmar" value="confirmar"> 
                <div class="clear"></div>
            </div>
        </div>

        <div class="col-sm-3 col-wrap">
            <div class="col gray" style="height: 325px;margin-bottom: 20px;">

            </div>
        </div>   
    </div>



    <input type="hidden" name="men_id" value="<?=$men_id?>">
    <input type="hidden" name="categoria" value="0">
    <input type="hidden" name="opcion_id" value="0">
    <input type="hidden" name="cod" value="<?=$cuota['men_codigo']?>">
    <input type="hidden" name="opcion" value="0">
	
	<?php
	elseif ($cuota['fac_id']):
		echo '<label style="color:black">Tiene una cuota impaga asociada, pueda ver la misma en <a href="http://www.inscribiteonline.com.ar/miCuenta.php#toShow">Micuenta</a>.</label>';
	else:
		echo '<label>No tiene cuotas a pagar de esta mensualidad, recuerde que para pagar una nueva cuota, debe tener paga la anterior</label>';
	endif;
	?>
	
</form>    

<div class="clear"></div>
<br>

<script>

    $(document).ready(function() {
        $("#confirmar").prop('disabled', true);
    });

    $("#termsCheck").click(function() {
        check = $(this).prop('checked');

        if (check) {
            $("#confirmar").prop('disabled', false);
        }
        else {
            $("#confirmar").prop('disabled', true);
        }
    });

</script>

<script src="../js/jquery.validate.min.js"></script>
<script>
    $(window).load(function() {



        $("#formx").validate({
            rules: {
                respuestapart1: {
                    required: true,
                },
                respuestapart2: {
                    required: true,
                },
                respuestapart3: {
                    required: true,
                }
            },
            messages: {
                respuestapart1: {
                    required: "Respuesta obligatoria. Por favor complete",
                },
                respuestapart2: {
                    required: "Respuesta obligatoria. Por favor complete",
                },
                respuestapart3: {
                    required: "Respuesta obligatoria. Por favor complete",
                }
            }
        });
    });
</script>

<style>
    .error {
        color: red;
    }
    .accordion.inscriptions .col-date, .accordion.inscriptions .col-status, .accordion.inscriptions .col-actions.anchox {
        width:34%;
    }
    .accordion.inscriptions .col-date, .accordion.inscriptions .col-status, .accordion.inscriptions .col-actions.anchox2 {
        width:34%;
        padding-left:1%;
    }
</style>
<?php
include_once dirname(__FILE__) . '/general/footer.php';
?>  													