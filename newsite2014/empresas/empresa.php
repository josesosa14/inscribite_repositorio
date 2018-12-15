<?php
require_once dirname(__FILE__) . '/../argit/general/header_empresa.php';

if (!isset($_SESSION['empresa'])) {
    header('Location:http://www.arg-it.com/inscribite/empresas/index.php');
}
?>
</div>
<?php
//info de las categorias
$query = "SELECT e.nombre nombre,e.codigo codigo,count(*) as cantidad  FROM inscribite_eventos e LEFT JOIN inscribite_inscripciones ins ON ins.deevento = e.codigo WHERE ver = 1 AND e.empresa = '{$_SESSION['empresa_nombre']}' GROUP BY nombre";
$eventos_Online = getArrayQuery($query, $mysqli);

$query = "SELECT e.nombre nombre,e.codigo codigo,count(*) as cantidad FROM inscribite_eventos e LEFT JOIN inscribite_inscripciones ins ON ins.deevento = e.codigo WHERE ver = 0 AND e.empresa = '{$_SESSION['empresa_nombre']}' GROUP BY nombre";
$eventos_Offline = getArrayQuery($query, $mysqli);


?>

<div class="titular row">
    <div class="title col-sm-9">
        <img src="../images/icon-event.png" alt=""/>
        <h2>Cuenta de empresa</h2>

    </div>
    <div class="col-sm-3">
        <?php
        echo '<span class="btn">' . $_SESSION['empresa_nombre'] . '</span>
                    <a href="' . $general_path . 'modificaEmpresa.php?empresa_id=' . $_SESSION['empresa'] . '">Ver / Cambiar mis datos</a>';
        ?> 
    </div>
</div>

<div class="clear"></div>
<br>


<div class="columns-container row">
    <div class="col-sm-9">
        <h3>Eventos Online:</h3>
        <br>

        <ul class="event-list">
            <?php
            if ($eventos_Online) {
                foreach ($eventos_Online as $evento) {
                    echo '
                    <li>
                    <div class = "row">
                    <div class = "col-sm-8 col-md-6">
                        <span class = "blue">Nombre: ' . $evento['nombre'] . '</span>
                    </div>
                    <div class = "col-sm-8 col-md-3">
                        <span>Inscriptos: '.$evento['cantidad'].'</span>
                    </div>
                    <div class = "col-sm-8 col-md-3">
                        <a href="http://www.inscribiteonline.com.ar/descargarinscripciones.php?evento='.$evento['codigo'].'" style="font-size:13px;">Descargar</a>
                    </div>
                    </div>
                    </li>
                    ';
                }
            }
            ?>
        </ul>
    </div>
    <div class="col-sm-3 col-wrap">
        <div class="col gray" style="height: 325px;margin-bottom: 20px;">

        </div>
    </div>   
</div>


<div class="columns-container row">
    <div class="col-sm-9">
        <h3>Eventos Offline:</h3>
        <br>

        <ul class="event-list">
            <?php
            if ($eventos_Offline) {
                foreach ($eventos_Offline as $evento) {
                    echo '
                    <li>
                    <div class = "row">
                    <div class = "col-sm-8 col-md-6">
                        <span class = "blue">Nombre: ' . $evento['nombre'] . '</span>
                    </div>
                    <div class = "col-sm-8 col-md-3">
                        <span>Inscriptos: '.$evento['cantidad'].'</span>
                    </div>
                    <div class = "col-sm-8 col-md-3">
                        <a href="http://www.inscribiteonline.com.ar/descargarinscripciones.php?evento='.$evento['codigo'].'" style="font-size:13px;">Descargar</a>
                    </div>
                    </div>
                    </li>
                    ';
                }
            }
            ?>
        </ul>
    </div>
    <div class="col-sm-3 col-wrap">
        <div class="col gray" style="height: 325px;margin-bottom: 20px;">

        </div>
    </div>   
</div>
<div class="columns-container gray row">
    <div class="col-xs-12">
        <div class="row">
            <div class="col-xs-6 col-wrap">
                <div class="col gray">

                </div>
            </div>
            <div class="col-xs-6 col-wrap">
                <div class="col gray">

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-wrap">
                <div class="col gray">

                </div>
            </div>
        </div>
    </div>
</div>
<?php
include_once dirname(__FILE__) . '/../argit/general/footer.php';
?>