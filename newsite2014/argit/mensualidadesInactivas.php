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

$query = "SELECT * FROM  mensualidades WHERE men_activo = 0 ORDER BY men_id DESC";
$mensualidades = getArrayQuery($query, $mysqli);
?>


<?php if ($mensualidades): ?>
<h3>Mensualidades inactivas</h3>
    <div class="row">
		<table border="1" style="width:100%;font-size:12px;text-align:center">
			<tr>
				<th style="text-align:center">Id</th>
				<th style="text-align:center">Nombre</th>
				<th style="text-align:center">Descripci&oacute;n</th>
				<th style="text-align:center">Activa</th>
				<th style="text-align:center" colspan="2" >Acción</th>
			</tr>

			<?php
			foreach ($mensualidades as $pago) {
			echo '<tr>
				<td>'.$pago['men_id'].'</td>
				<td>'.$pago['men_nombre'].'</td>
				<td>'.$pago['men_descripcion'].'</td>
				<td>'.$pago['men_activo'].'</td>
				<td>
					<a href="'.$general_path.'mensualidades/modifica.php?id='.$pago['men_id'].'" >Ver</a>  |  ';
					if($pago['men_activa'] == 1){
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

<?php

}else{
echo 'No se encuentra logeado, <a href="'.$general_path.'newsite2014/admin/">iniciar sesion</a>';
}

require_once dirname(__FILE__) . '/general/footer.php';
