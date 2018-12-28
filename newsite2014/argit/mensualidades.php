<?php
$pagar = "blue";
require_once dirname(__FILE__) . '/general/header_admin.php';
echo '</div>';

if($_SESSION['admin'] == 'inscribite'){

$limit = 50;
$page = filter_input(INPUT_GET,'page');
$page = ($page)?$page:1;
$from = ($page-1)*$limit;
$to = $limit*$page;


$query = "SELECT * FROM  empresa WHERE emp_estado = 1 ORDER BY emp_nombre ASC";
$empresas = getArrayQuery($query, $mysqli);

$query = "SELECT * FROM  mensualidades inner join empresa on emp_id = men_empresa WHERE men_activo = 1 ORDER BY men_codigo DESC";
$mensualidades = getArrayQuery($query, $mysqli);
?>

<h3>Nueva mensualidad</h3>
 <div class="row">
	<form method="post" action="/mensualidades/cargaMensualidad.php"  enctype="multipart/form-data">
		<div class="row">
			<div class="row">	
				<div class="col-md-12">
					<div class="col-md-3">
						<div class="form-group">
							<a href="#" class="img-profile">
								<img src="" alt="" class="img-responsive" id="img_thumb">
								<span class="icon-edit" id="img-trigger"></span>
								<span class="icon-close" id="img-trigger"></span>
								<input type="file" style="display:none;" id="img-selector" name="mensualidad_logo" accept="image/jpeg">
								<a href="#" class="submit" id="cancelImg">Borrar imagen</a>
							</a>
						</div>
					</div>
					<div class="col-md-9">
					
						<div class="col-md-3">
							<label>Nombre:</label>
							<input type="text" class="form-control" name="men_nombre" />
						</div>
						
						<div class="col-md-2">		
							<label>Cod:</label>
							<input type="text" class="form-control" name="men_codigo"  />
						</div>
						<div class="col-md-3">		
							<label>Empresa:</label>
							<select class="form-control" name="men_empresa">
							<option selected>Seleccione</option>
							<?php
							foreach($empresas as $empresa){
								echo '<option value="'.$empresa['emp_id'].'">'.$empresa['emp_nombre'].'</option>';
							}
							?>
							</select>
						</div>
						<div class="col-md-2">		
							<label>cuotas:</label>
							<input type="text" id="cant_cuotas" name="men_cuotas" numeric class="form-control" />
						</div>
						<div class="col-md-2">		
							<label>Punitorio:</label>
							<input type="text" id="cant_cuotas" name="men_punitorio"  placeholder="0.02" class="form-control" />
						</div>
					</div>
					<div class="col-md-9">
						<div class="col-md-5">
							<label>Texto cup&oacute;n</label>
							<textarea style="height:75px" maxlength="300" name="men_texto_cupon" class="form-control"></textarea>
						</div>
						<div class="col-md-5">
							<label>Descripci&oacute;n:</label>
							<textarea style="height:75px" name="men_descripcion" class="form-control" ></textarea>
						</div>
						<div class="col-md-2">
							<label>&nbsp;</label>
							<input type="submit" class="form-control btn-sm btn-primary" value="Cargar" />
						</div>
					</div>
			</div>
		</div>
		
		<div class="row" id="cuotas">
		</div>		
	</div>
	</form>



<?php if ($mensualidades): ?>
<h3>Mensualidades</h3>
    <div class="row">
		<table border="1" style="width:100%;font-size:12px;text-align:center">
			<tr>
				<th style="text-align:center">Código</th>
				<th style="text-align:center">Nombre</th>
				<th style="text-align:center">Empresa</th>
				<th style="text-align:center">Cuotas</th>
				<th style="text-align:center" colspan="2" >Acción</th>
			</tr>

			<?php
			foreach ($mensualidades as $pago) {
			echo '<tr>
				<td>'.$pago['men_codigo'].'</td>
				<td>'.$pago['men_nombre'].'</td>
				<td>'.$pago['emp_nombre'].'</td>
				<td>'.$pago['men_cuotas'].'</td>
				<td>
					<a href="'.$general_path.'mensualidades/modifica.php?id='.$pago['men_id'].'" >Ver</a>  |  ';
					if($pago['men_activo'] == 1){
					echo '<a href="'.$general_path.'mensualidades/borrar.php?id='.$pago['men_id'].'" >Desactivar</a>';		
					}else{
					echo '<a href="'.$general_path.'mensualidades/borrar.php?id='.$pago['men_id'].'" >Activar</a>';	
					}
					
					echo '
				</td>';
				echo "</tr>";
			}
			?>
		</table>
    </div>
    <?php

else:
    echo '<h3>No tiene mensualidades cargadas</h3>';
endif;
?>




<script src="../js/jquery.validate.min.js"></script>
<script>
var button = '<button type="button" class="test btn-primary btn-sm">borrar</button></div>';
                $(window).load(function() {
					$( "#cant_cuotas" ).change(function() {
					  var cant_cuotas = $( "#cant_cuotas" ).val();
					  var cuerpo = "";
					  
					  for (i = 1; i <= cant_cuotas; i++) {
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
							cuerpo += '<div class="col-md-3" >';
							cuerpo += '<div class="col-md-4" style="padding:0px;">';
							cuerpo += '<label>Imp:</label>';
							cuerpo += '<input class="form-control" type="text" name="mes['+i+'][mec_imp_2]" />';
							cuerpo += '</div>';
							cuerpo += '<div class="col-md-8" style="padding:0px;">';
							cuerpo += '<label>Hasta:</label>';
							cuerpo += '<input class="form-control venc2" type="date" name="mes['+i+'][mec_venc_2]" />';
							cuerpo += '</div>';
							cuerpo += '</div>';
							cuerpo += '<div class="col-md-3" >';
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
		$("#img_thumb").attr('src', '../images/img-perfil.png');
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



<?php

}else{
echo 'No se encuentra logeado, <a href="'.$general_path.'newsite2014/admin/">iniciar sesion</a>';
}

require_once dirname(__FILE__) . '/general/footer.php';
