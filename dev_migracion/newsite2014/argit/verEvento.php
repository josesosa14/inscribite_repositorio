<?php
$inscripcion = "blue";
$pagar = "blue";
require_once dirname(__FILE__) . '/general/header.php';
?>

</div>
<?php
$evento_id = addslashes(filter_var(filter_input(INPUT_GET, 'evento'), FILTER_SANITIZE_STRING));


//info del evento
$query = "SELECT * FROM inscribite_eventos WHERE codigo='$evento_id'";
$evento_info = getRowQuery($query, $mysqli);


$query = "SELECT * FROM inscribite_categorias WHERE deevento ='$evento_id' 
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

            $out[$key]['cupo_restante'] = ($opcion['cupo'] + $opcion['cuporestante'] <= 0) ? 0 : $opcion['cupo'] + $opcion['cuporestante'];
            $out[$key]['op_nombre'] = $opcion['nombre'];
            $out[$key]['categorias'][$key_cat]['codigo'] = $categoria['codigo'];
            $out[$key]['categorias'][$key_cat]['nombre'] = $categoria['nombre'];
            $out[$key]['categorias'][$key_cat]['descripcion'] = $categoria['descripcion'];
            $out[$key]['categorias'][$key_cat]['sexo'] = $categoria['sexo'];
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
	<div class="col-sm-3 ">
		<?='<img src="../imagenes/image_' . $evento_info['imagen1'] . '" alt="" class="img-responsive" style="width: 100%;height: 100%;" />';?>
	</div>
</div>

<div class="clear"></div>
<br>

<div class="columns-container row">
    <div class="col-sm-9" id="toShow">
        <h3>Grupos y vacantes</h3>
        <br>
        <div class="panel-group accordion" id="accordion-vacantes">
            <?php
            if ($out) {
                foreach ($out as $cont => $opcion) {
                    echo '  <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-sm-8 col-md-8">
                                        <span class="blue">
                                        ' . $opcion['op_nombre'] . '</span>
                                    </div>
                                    <div class="col-sm-4 col-md-4">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#evento-' . $cont . '" class="icon collapsed"></a>
                                        <span class="badge">' . $opcion['cupo_restante'] . ' VACANTES</span>
                                    </div>
                                </div>
                            </div>
                            <div id="evento-' . $cont . '" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <ul class="event-list">                            

                            ';


                    foreach ($opcion['categorias'] as $key => $categoria) {
                        echo '
                            <li>
                            <div class="row">
                                <div class="col-sm-8 col-md-9">
                                    <span class="blue">' . $categoria['nombre'] . '</span>
                                    <span> - ' . $categoria['descripcion'] . ' | SEXO: ' . $categoria['sexo'] . '</span>
                                </div>
                                ';
								if(isset($_SESSION['usuario'])){
									echo '
									<div class="col-sm-4 col-md-3">
										<a href="' . $general_path . 'iniciainscripccion.php?evento=' . filter_input(INPUT_GET, 'evento') . '#toShow" class="icon-go"></a>
									</div>
									';
								}
								else{
								echo '
									<div class="col-sm-4 col-md-3">
										<a href="' . $general_path . 'index.php?evento=' . filter_input(INPUT_GET, 'evento') . '" class="icon-go"></a>
									</div>
									';
								}
								echo '							
                            </div>
                            </li>
                            ';
                    }

                    echo '</ul></div></div></div>';
                }
            }
            ?>
        </div>
    </div>

    <div class="col-sm-3 col-wrap">
        <div class="col gray">
            <a href="http://www.epsa.org.ar/promo/"> <img  src="../images/banner_guardavidas.jpg" /></a>
        </div>
    </div>             
</div>
<?php
include_once dirname(__FILE__) . '/general/special_banners.php';

include_once dirname(__FILE__) . '/general/footer.php';
