<?php
require_once dirname(__FILE__) . '/../general/header_empresa.php';
$evento = filter_input(INPUT_GET,'cod_evento');

if (!isset($_SESSION['empresa'])) {
	header('Location:'.$general_path.'empresas/index.php');
}
?>
</div>
<?php
if(eventoDeLaEmpresa($evento,$mysqli)){
//info de las categorias
$query = "SELECT nombre FROM inscribite_eventos WHERE codigo = $evento";
$evento_info = getRowQuery($query,$mysqli);
$query = "SELECT id,nombre,cupo,cupo+cuporestante restante FROM inscribite_opciones WHERE evento = $evento";
$opciones = getArrayQuery($query, $mysqli);

?>

<div class="columns-container row">
    <div class="col-xs-12">
        <h3>Informaci&oacute;n del evento:&nbsp;<?=$evento_info['nombre']?></h3>
        <br>
		<div class="row">
        <ul class="event-list">
            <?php
            if ($opciones) {
                foreach ($opciones as $opcion) {
                    echo '
					<form method="POST" action="/empresas/modificaCupos.php">
                    <li>
					<input class="form-control" name="op_id" type="hidden" value="'.$opcion['id'].'"/>
					<input class="form-control" name="evento" type="hidden" value="'.$evento.'"/>
					<div class="row">
						<div class = "col-sm-4">
							<span class = "blue">' . $opcion['nombre'] . '</span>
						</div>
						<div class="col-sm-2">
							<span>Cupo del evento:</span>
						</div>
						<div class="col-sm-1">
							<input class="form-control" name="cupo" type="text" value="'.$opcion['cupo'].'"/>
						</div>
						<div class="col-sm-2">
							<span>Cupo Restante:</span>
						</div>
						<div class="col-md-1">
							<span '.(($opcion['restante'] <= 0)?'style="color:red"':'').' >'.$opcion['restante'].'</span>
						</div>
						<div class="col-md-2">
							<input class="form-control" type="submit" value="Modificar"/>
						</div>
						</div>
                    </li>
					</form>
                    ';
                }
            }
            ?>
        </ul>
		</div>
    </div>
</div>

<?php
}
else{
	echo '<h3>El evento pedido no es de su empresa</h3>';
}
 ?>

<div class="columns-container gray row">
    <div class="col-xs-12">
        <div class="row">
            <div class="col-xs-6 col-wrap">
            <!--    <div class="col gray">

                </div>-->
            </div>
            <div class="col-xs-6 col-wrap">
                <!--<div class="col gray">

                </div>-->
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-wrap">
                <!--<div class="col gray">

                </div>-->
            </div>
        </div>
    </div>
</div>
<?php
include_once dirname(__FILE__) . '/../general/footer.php';
?>
