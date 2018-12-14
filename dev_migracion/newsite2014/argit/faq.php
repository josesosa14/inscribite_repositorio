<?php $dudas = "blue";
require_once dirname(__FILE__).'/general/header.php';

$query = "SELECT * FROM inscribite_faq ORDER BY numero ASC";
$preguntas = getArrayQuery($query,$mysqli);
?>
</div>
<div class="clear"></div>

<div class="columns-container row">
    <div class="col-sm-12" id="toShow">
        <h3>Preguntas Frecuentes</h3>
        <br>
        <div class="panel-group accordion" id="accordion-vacantes">
            <?php 
				foreach($preguntas as $cont => $pregunta){
					echo '<div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-sm-10 col-md-9">
                                        <span class="blue">
                                        ' . $pregunta['pregunta'] . '</span>
                                    </div>
                                    <div class="col-sm-2 col-md-3">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#evento-' . $cont . '" class="icon collapsed"></a>
                                    </div>
                                </div>
                            </div>
                            <div id="evento-' . $cont . '" class="panel-collapse collapse">
								<div class="panel-body">
									 <div class="row">
										<div class="col-xs-12">
											<p style="text-align:justify;padding:14px">' . $pregunta['respuesta'] . '</p>
										</div>														
									</div>
								</div>
							</div>
						</div>';
				}
			?>
        </div>
    </div>
</div>


<?php include_once dirname(__FILE__) . '/general/banners.php'; ?>

<?php 
include_once dirname(__FILE__) . '/general/footer.php'; 
?>

