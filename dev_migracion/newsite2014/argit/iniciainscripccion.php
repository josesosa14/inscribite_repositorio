<?php
$inscripcion = "blue";
$pagar = "blue";
require_once dirname(__FILE__) . '/general/header.php';
?>
</div>
<?php
//get variables
global $usuario;
$evento_id = addslashes(filter_var(filter_input(INPUT_GET, 'evento'), FILTER_SANITIZE_STRING));

//info del usuario
$query = "SELECT *,TIMESTAMPDIFF(YEAR,CONCAT(SUBSTRING((CONVERT(fechanac,CHAR(4))),1,4),'-',
                    SUBSTRING((CONVERT(fechanac,CHAR(6))),5,5),'-',
                    SUBSTRING((CONVERT(fechanac,CHAR(8))),7,7)),CURDATE()) as edad 
            FROM inscribite_usuarios WHERE dni=$usuario";
$user_info = getRowQuery($query, $mysqli);


//info del evento
$query = "SELECT * FROM inscribite_eventos WHERE codigo='$evento_id'";
$evento_info = getRowQuery($query, $mysqli);


$query = "SELECT *,(SELECT COUNT(*) FROM inscribite_inscripciones WHERE deusuario='{$_SESSION['usuario']}' AND deevento = '$evento_id' AND categoria=nombre) as inscripto,
(SELECT COUNT(*) FROM inscribite_inscripciones WHERE deusuario='{$_SESSION['usuario']}' AND deevento = '$evento_id' AND categoria=nombre AND pagado = 1) as pagado
 FROM inscribite_categorias WHERE deevento ='$evento_id' 
			AND (LOWER(sexo) = LOWER('{$user_info['sexo']}') OR LOWER(sexo) = 'ambos')
            AND (limitedeedad = 0 OR (edadminima <= TIMESTAMPDIFF(YEAR,{$user_info['fechanac']},fechadecomputo) AND edadmaxima >= TIMESTAMPDIFF(YEAR,{$user_info['fechanac']},fechadecomputo))) 
            ORDER BY codigo";

$categorias = getArrayQuery($query, $mysqli);




$query = "SELECT * FROM inscribite_opciones WHERE evento = '$evento_id'";
$opciones = getArrayQuery($query, $mysqli);


foreach ($opciones as $key => $opcion) {
    foreach ($categorias as $key_cat => $categoria) {
        if ($categoria['opcion'] == $opcion['nombre']) {
            $cat_info[$key][$key_cat]['op_nombre'] = $opcion['nombre'];
            $cat_info[$key][$key_cat]['op_codigo'] = $opcion['id'];
            $cat_info[$key][$key_cat]['cupo_restante'] = ($opcion['cupo'] + $opcion['cuporestante'] <= 0) ? 0 : $opcion['cupo'] + $opcion['cuporestante'];
            $cat_info[$key][$key_cat]['cat_codigo'] = $categoria['id'];
            $cat_info[$key][$key_cat]['cat_cod'] = $categoria['codigo'];
            $cat_info[$key][$key_cat]['cat_nombre'] = $categoria['nombre'];
            $cat_info[$key][$key_cat]['cat_precio'] = $categoria['precio1'];
            $cat_info[$key][$key_cat]['cat_desc'] = $categoria['descripcion'];
            $cat_info[$key][$key_cat]['cat_sexo'] = $categoria['sexo'];
            $cat_info[$key][$key_cat]['inscripto'] = $categoria['inscripto'];
			$cat_info[$key][$key_cat]['pagado'] = $categoria['pagado'];
            $cat_info[$key][$key_cat]['vencimiento'] = $categoria['fechavenc3'];
        }
    }
}
?>

<div class="titular row">
    <div class="title col-sm-9">
        <img src="../images/icon-event.png" alt=""/>
        <h2>Inscripci&oacute;n a Evento</h2>
        <h3><?php echo $evento_info['nombre']; ?></h3>
    </div>
    <div class="col-sm-3"><?php
        if (!$usuario) {
            echo 'No est&aacute; logeado, ingrese con DNI';
        } else {
            echo '<span class="btn">' . $user_info['nombre'] . ' ' . $user_info['apellido'] . '</span>
                    <a href="' . $general_path . 'modificaUsuario.php?user_id=' . $user_info['id'] . '#toShow">Ver / Cambiar mis datos</a>
                    <a href="' . $general_path . 'logout.php">Cambiar usuario/Cerrar sesi&oacute;n</a>';
        }
        ?>
    </div>
</div>

<div class="clear"></div>
<br>

<?php if ($usuario): ?>
    <div class="columns-container row">
        <div class="col-sm-9" id="toShow">
            <h3>Elegir una categor&iacute;a.<br> Tenga en cuenta que las RESERVAS pueden cancelarse y gestionar una nueva inscripci&oacute;n.</h3>
            <p class="small" style="margin-bottom: 25px;">
                El sistema filtr&oacute; las categorias en funci&oacute;n de tu edad y sexo.
            </p>
            <ul class="event-list">
                <?php
                if ($cat_info) {
                    $inscripto = false;
                    foreach ($cat_info as $cats) {
                        
                        foreach ($cat_info as $cats_aux) {
							foreach ($cats_aux as $cat_aux) {
								if($cat_aux['inscripto'] != 0){
									$inscripto = true;
									break;
								}
							}                        
						}
                        foreach ($cats as $key => $categoria) {                            
                           
                            echo '
                            <li>
                            <div class="row">
                            <div class="col-sm-8 col-md-9">
                                    <span class="blue">' . $categoria['op_nombre'] . '</span>
                                    ' . $categoria['cat_desc'] . '
                                    | SEXO: ' . $categoria['cat_sexo'] . '
                            ';

                            echo '
                            </div>
                            <div class="col-sm-4 col-md-3">
                                   ';
								   
								   
                            if (!$inscripto || ($evento_info['tipo'] == 'Servicios' || $evento_info['tipo'] == 'Productos')) {						
							
                                if ($categoria['cupo_restante'] != 0) {
                                    if ($categoria['vencimiento'] && $categoria['vencimiento'] > 100) {
                                        $fecha = date('Y-m-d', strtotime(fechaByInt($categoria['vencimiento'])));
                                        $fecha_valida = date('Y-m-d');
                                        if ($fecha >= $fecha_valida) {
                                            if ($categoria['cat_precio'] == "00" || $categoria['cat_precio'] == "") {
                                                echo '<a href="/eventoGratis.php?evento=' . $evento_id . '&opcion=' . $categoria['op_nombre'] . '&cod=' . $categoria['cat_cod'] . '&opcion_id=' . $categoria['op_codigo'] . '&categoria=' . $categoria['cat_nombre'] . '#toShow" class="icon-go"></a>';
                                            } else {
                                                echo '<a href="/aceptaCondiciones.php?evento=' . $evento_id . '&cod=' . $categoria['cat_cod'] . '&opcion=' . $categoria['op_nombre'] . '&opcion_id=' . $categoria['op_codigo'] . '&categoria=' . $categoria['cat_nombre'] . '#toShow" class="icon-go"></a>';
                                            }
                                        }
                                        else{
                                            echo '<span class="badge" style="background-color:red">CERRADO</span>';
                                        }
                                    } else {
                                        if ($categoria['cat_precio'] == "00" || $categoria['cat_precio'] == "") {
                                            echo '<a href="/eventoGratis.php?evento=' . $evento_id . '&opcion=' . $categoria['op_nombre'] . '&cod=' . $categoria['cat_cod'] . '&opcion_id=' . $categoria['op_codigo'] . '&categoria=' . $categoria['cat_nombre'] . '#toShow" class="icon-go"></a>';
                                        } else {
                                            echo '<a href="/aceptaCondiciones.php?evento=' . $evento_id . '&cod=' . $categoria['cat_cod'] . '&opcion=' . $categoria['op_nombre'] . '&opcion_id=' . $categoria['op_codigo'] . '&categoria=' . $categoria['cat_nombre'] . '#toShow" class="icon-go"></a>';
                                        }
                                    }
                                }

                                echo '
                                        <span class="badge">' . $categoria['cupo_restante'] . ' VACANTES</span>
                                        </div>
                                        </div>
                                ';
                            } elseif($categoria['inscripto'] == 0) {
                                echo '<span class="badge">' . $categoria['cupo_restante'] . ' VACANTES</span>';
                            }
							elseif($categoria['pagado'] != 0){
								echo '<span class="badge" style="background-color:green">INSCRIPTO</span>';
							}
							else{
								echo '<span class="badge" style="background-color:green">RESERVADO</span>';
							}
                        }
                    }
                }else{
				echo '<h4>No se encontr&oacute; informaci&oacute;n para su edad y sexo, revise su fecha de nacimiento en caso de ser necesario</h4>';
				}
                ?>
            </ul>
        </div>

        <div class="col-sm-3 col-wrap">
            <div class="col gray">
                <a href="http://www.epsa.org.ar/promo/"> <img  src="../images/banner_guardavidas.jpg" /></a>
            </div>
        </div>           
    </div>
    <?php
endif;

include_once dirname(__FILE__) . '/general/special_banners.php';

include_once dirname(__FILE__) . '/general/footer.php';
