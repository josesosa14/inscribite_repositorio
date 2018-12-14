<?php 
$emp_id = filter_input(INPUT_GET,'editando');
$query = "SELECT * FROM empresa LEFT JOIN empresa_contacto ON empc_emp_id = emp_id WHERE emp_id = $emp_id";
$result1 = mysql_query($query);
if (is_resource($result1)) {
	$row1 = mysql_fetch_array($result1);
	$nroid = $row1['emp_id'];
}

 ?>
	<div>
	  <div class="titulosec">Empresas &gt; <?=(is_resource($result1))?'Editando:':'Agregar Nueva'?> <?=$row1['emp_nombre']?></div>
      <div>
        <form action="guardar.php" method="post">
			<div>
              <input type="hidden" name="id" value="<?=$nroid?>"/>
              <input type="hidden" name="tabla" value="empresa"/>
              <input type="hidden" name="volvera" value="empresas.admin"/>
              &gt; Nombre de la Empresa
              <input type="text" name="emp_nombre" value="<?=$row1['emp_nombre']?>"/>
			  &gt; Usuario
              <input type="text" name="emp_nombre" value="<?=$row1['emp_usuario']?>"/>
              &gt; Contacto
        	  <input type="text" name="contacto" value="<?=$row1['empc_nombre']?>"/>
        	  &gt; e-mail
        	  <input type="text" name="emp_mail" value="<?=$row1['emp_mail']?>"/>
        	  &gt; Password
        	  <input type="text" name="emp_password" value="<?=$row1['emp_password']?>"/>
        	  <input type="submit" value="Enviar" class="submit"/>
			</div>
        </form>
	</div>
