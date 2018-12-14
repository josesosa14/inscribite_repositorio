<?php
$pagar = "blue";
require_once dirname(__FILE__) . '/../general/header_admin.php';
echo '</div>';

if($_SESSION['admin'] == 'inscribite'){

$limit = 50;
$page = filter_input(INPUT_GET,'page');
$page = ($page)?$page:1;
$from = ($page-1)*$limit;
$to = $limit*$page;

$men_id = addslashes($_GET['id']);
$query = "SELECT * FROM  empresa WHERE emp_estado = 1 ORDER BY emp_nombre ASC";
$empresas = getArrayQuery($query, $mysqli);

$query = "SELECT * FROM  mensualidades INNER JOIN mensualidad_cuotas ON mec_men_id = men_id 
			WHERE men_id =$men_id";
$mensualidad = getArrayQuery($query, $mysqli);

$query = "SELECT * FROM mensualidad_usuario WHERE meu_men_id = $men_id";
$tieneUsuarios = getArrayQuery($query,$mysqli);

?>

<h3>Modifica mensualidad</h3>
 <div class="row">
	<form method="post" action="/mensualidades/modificaMensualidad.php" enctype="multipart/form-data">
	<input type="hidden" name="men_id" value="<?=$_GET['id']?>" />
		<div class="row">
			<div class="row">
				<div class="col-md-12">
					<div class="col-md-3">
						<div class="form-group">
							<a href="#" class="img-profile">

								<img src="../imagenes/<?=$mensualidad[0]['men_imagen']?>" alt="" class="img-responsive" id="img_thumb">
								<span class="icon-edit" id="img-trigger"></span>
								<span class="icon-close" id="img-trigger"></span>
								<input type="file" style="display:none;" id="img-selector" name="mensualidad_logo" accept="image/jpeg">
								<a href="#" class="submit" id="cancelImg">Borrar imagen</a>
								<input type="hidden" name="men_imagen" value=<?=$mensualidad[0]['men_imagen']?>/>
							</a>
						</div>
					</div>
					<div class="col-md-9">
						<div class="col-md-3">
							<label>Nombre:</label>
							
							<input type="text" class="form-control" value="<?=$mensualidad[0]['men_nombre']?>" name="men_nombre" />
						</div>
						
						<div class="col-md-2">		
							<label>C&oacute;digo:</label>
							<input type="text" class="form-control" value="<?=$mensualidad[0]['men_codigo']?>" name="men_codigo"  />
						</div>
						<div class="col-md-3">		
							<label>Empresa:</label>
							<select class="form-control" name="men_empresa">
							<option selected>Seleccione epresa</option>
							<?php
							foreach($empresas as $empresa){
								if($empresa['emp_id'] == $mensualidad[0]['men_empresa']){
									echo '<option selected value="'.$empresa['emp_id'].'">'.$empresa['emp_nombre'].'</option>';
								}else{
									echo '<option value="'.$empresa['emp_id'].'">'.$empresa['emp_nombre'].'</option>';	
								}
								
							}
							?>
							</select>
						</div>
						<div class="col-md-2">		
							<label>Cuotas:</label>
							<input type="text" id="cant_cuotas" name="men_cuotas" value="<?=$mensualidad[0]['men_cuotas']?>" numeric class="form-control" />
						</div>
						<div class="col-md-2">		
							<label>Punitorio:</label>
							<input type="text" id="cant_cuotas" name="men_punitorio" value="<?=$mensualidad[0]['men_punitorio']?>"  placeholder="0.02" class="form-control" />
						</div>
					</div>
					<div class="col-md-9">
						<div class="col-md-6">
							<label>Texto cupon:</label>
							<textarea style="height:75px" name="men_texto_cupon" maxlength="300" class="form-control" ><?=$mensualidad[0]['men_texto_cupon']?></textarea>
						</div>
						<div class="col-md-6">
							<label>Descripci&oacute;n:</label>
							<textarea style="height:75px" name="men_descripcion" class="form-control" placeholder="Descripci&oacute;n de la mensualidad"><?=$mensualidad[0]['men_descripcion']?></textarea>
						</div>
					</div>
				</div>				
			</div>
		
		<div class="row" id="cuotas">
		
		<?php
		if($tieneUsuarios){
			echo '<h4>Tenga en cuenta que hay usuarios registrados en esta mensualidad</h4>';	
		}
		foreach($mensualidad as $key => $cuotas){
			echo'<div class="row"><div class="col-md-12">
			<label>Cuota</label>
			<div class="col-md-3">
			<div class="col-md-4" style="padding:0px;">
			<label>Imp. 1:</label>
			<input type="hidden" name="mes['.$key.'][mec_id]" value="'.$cuotas['mec_id'].'" />
			<input type="text" class="form-control" name="mes['.$key.'][mec_imp_1]" value="'.$cuotas['mec_imp_1'].'" />
			</div>
			<div class="col-md-8" style="padding:0px;">
			<label>Hasta:</label>
			<input type="date" class="form-control venc1" name="mes['.$key.'][mec_venc_1]" value="'.$cuotas['mec_venc_1'].'" />
			</div>
			</div>
			<div class="col-md-4">
			<div class="col-md-4" style="padding:0px;">
			<label>Imp. 2:</label>
			<input type="text" class="form-control" name="mes['.$key.'][mec_imp_2]" value="'.$cuotas['mec_imp_2'].'" />
			</div>
			<div class="col-md-8 style="padding:0px;">
			<label>Hasta:</label>
			<input type="date" class="form-control venc2" name="mes['.$key.'][mec_venc_2]" value="'.$cuotas['mec_venc_2'].'" />
			</div>
			</div>
			<div class="col-md-4">
			<div class="col-md-4" style="padding:0px;">
			<label>Imp. 3:</label>
			<input type="text" class="form-control" name="mes['.$key.'][mec_imp_3]" value="'.$cuotas['mec_imp_3'].'" />
			</div>
			<div class="col-md-8" style="padding:0px;">
			<label>Hasta:</label>
			<input type="date" class="form-control venc3" name="mes['.$key.'][mec_venc_3]" value="'.$cuotas['mec_venc_3'].'" />
			</div>
			</div>
			<label>&nbsp;</label>
			<button type="button" class="test btn-primary btn-sm">borrar</button>
			</div></div>';
		}
		?>
		</div>
		<?php
		
		echo '<div class="col-md-2">
			<label>&nbsp;</label>
			<input type="submit" class="form-control btn-sm btn-primary" value="Editar" />
		</div>';
		?>
		</div>
	</form>
</div>


<script src="../js/jquery.validate.min.js"></script>
<!-- cdn for modernizr, if you haven't included it already -->
<script src="http://cdn.jsdelivr.net/webshim/1.12.4/extras/modernizr-custom.js"></script>
<!-- polyfiller file to detect and load polyfills -->
<script src="http://cdn.jsdelivr.net/webshim/1.12.4/polyfiller.js"></script>

<script>
    webshims.setOptions('waitReady', false);
    webshims.setOptions('forms-ext', {types: 'date'});
    webshims.polyfill('forms forms-ext');
</script>
<script>
var button = '<label>&nbsp;</label><button type="button" class="test btn-primary btn-sm">borrar</button></div>';
                $(window).load(function() {
					var cuotas_actuales = <?=count($mensualidad)?>;
					$( "#borrar" ).click(function(e) {
						e.preventDefault();
						$("#cuotas > div").remove();
						cuotas_actuales = 0;
					});
					$( "#cant_cuotas" ).change(function() {
						var cant_cuotas = $( "#cant_cuotas" ).val();
						var cuerpo = "";
					  
					  for (i = cuotas_actuales+1; i <= cant_cuotas; i++) {
							cuerpo += '<div class="row"><div class="col-md-12">';
							cuerpo += '<label>Cuota Nro '+i+'</label>';
							cuerpo += '<div class="col-md-3" >';
							cuerpo += '<div class="col-md-4" style="padding:0px;">';
							cuerpo += '<label>Imp:</label>';
							cuerpo += '<input class="form-control" type="text" name="mes['+i+'][mec_imp_1]" />';
							cuerpo += '</div>';
							cuerpo += '<div class="col-md-8" style="padding:0px;">';
							cuerpo += '<label>Hasta:</label>';
							cuerpo += '<input class="form-control venc1" type="date" name="mes['+i+'][mec_venc_1]" />';
							cuerpo += '</div>';
							cuerpo += '</div>';
							cuerpo += '<div class="col-md-4" >';
							cuerpo += '<div class="col-md-4" style="padding:0px;">';
							cuerpo += '<label>Imp:</label>';
							cuerpo += '<input class="form-control" type="text" name="mes['+i+'][mec_imp_2]" />';
							cuerpo += '</div>';
							cuerpo += '<div class="col-md-8" style="padding:0px;">';
							cuerpo += '<label>Hasta:</label>';
							cuerpo += '<input class="form-control venc2" type="date" name="mes['+i+'][mec_venc_2]" />';
							cuerpo += '</div>';
							cuerpo += '</div>';
							cuerpo += '<div class="col-md-4" >';
							cuerpo += '<div class="col-md-4" style="padding:0px;">';
							cuerpo += '<label>Imp:</label>';
							cuerpo += '<input class="form-control" type="text" name="mes['+i+'][mec_imp_3]" />';
							cuerpo += '</div>';
							cuerpo += '<div class="col-md-8" style="padding:0px;">';
							cuerpo += '<label>Hasta:</label>';
							cuerpo += '<input class="form-control venc3" type="date" name="mes['+i+'][mec_venc_3]" />';
							cuerpo += '</div>';
							cuerpo += '</div>';
							cuerpo += button;
							cuerpo += '</div></div>';
						}
						$('#cuotas').append(cuerpo);
						cuotas_actuales = cant_cuotas;
					});
                });
				
		$(document).ready(function () {
        $("#cuotas").on("click", "button.test", function () {
            $(this).closest('div').remove();
        });
		 $("#cuotas").on("change", "input.venc1", function () {
			venc2 = $(this).parent().parent().next('div').children().find('input.venc2');
			$(venc2).parent().parent().next('div').children().find('input.venc3').val($(this).val());
			venc2.val($(this).val());
        });
		
		$("#cuotas").on("change", "input.venc2", function () {
			venc2 = $(this).val();
			venc1 = $(this).parent().parent().prev('div').children().find('input.venc1').val();
			if(venc2 < venc1){
				alert('vencimiento 2 menor a vencimiento 1');
				$(this).val(venc1);
			}
        });
		$("#cuotas").on("change", "input.venc3", function () {
			venc3 = $(this).val();
			venc2 = $(this).parent().parent().prev('div').children().find('input.venc2').val();
			if(venc3 < venc2){
				alert('vencimiento 3 menor a vencimiento 2');
				$(this).val(venc2);
			}
        });
    });
</script>

<script>
    $('#img-trigger').on('click', function (e) {
        e.preventDefault();
        $("#img-selector").trigger('click');
    });
    $('#img_thumb').on('click', function (e) {
        e.preventDefault();
        $("#img-selector").trigger('click');
    });
    $('#cancelImg').on('click', function (e) {
        e.preventDefault();
        $("#img-selector").val('');
        $("#img_thumb").attr('src', '../images/img-perfil.png');
    });
    function readURL(input) {
        var $prev = $('#img_thumb'); // cached for efficiency
        imageSize = 0;
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $prev.attr('src', e.target.result);

            };
            imageSize = (input.files[0].size) / 1024;
            if (imageSize < 1024) {
                reader.readAsDataURL(input.files[0]);
                $prev.show(); // this will show only when the input has a file
            } else {
                $("#img-selector").val('');
                $prev.attr('src', '../images/img-perfil.png');
                alert("El tamaño de la foto no debe superar 1MB");
            }

        } else {

            $prev.attr('src', '../images/img-perfil.png');
            //$prev.hide(); // this hides it when the input is cleared
        }
    }
    $('#img-selector').change(function () {
        readURL(this);
    });
	
	$(document).ready(function () {
		<?php
		if(!$mensualidad[0]['men_imagen']){
			echo '$("#img_thumb").attr("src", "../images/img-perfil.png");';
		}
		?>
    });
</script>
<?php
}else{
echo 'No se encuentra logeado, <a href="http://www.inscribiteonline.com.ar/newsite2014/admin/">iniciar sesion</a>';
}
require_once dirname(__FILE__) . '../general/footer.php';
