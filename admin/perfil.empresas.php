<? $result1 = mysql_query('SELECT * FROM inscribite_empresas WHERE id = '.$_GET['editando'].' LIMIT 1 ');
if (is_resource($result1)) {
	$row1 = mysql_fetch_array($result1);
	$nroid = $row1['id'];
} ?>
	<div>
	  <div class="titulosec">Empresas &gt; <?=(is_resource($result1))?'Editando:':'Agregar Nueva'?> <?=$row1['nombre']?></div>
      <div>
        <form action="guardar" method="post">
			<div>
              <input type="hidden" name="id" value="<?=$nroid?>"/>
              <input type="hidden" name="tabla" value="inscribite_empresas"/>
              <input type="hidden" name="volvera" value="empresas.admin"/>
              &gt; Nombre de la Empresa
              <input type="text" name="nombre" value="<?=$row1['nombre']?>"/>
              &gt; Contacto
        	  <input type="text" name="contacto" value="<?=$row1['contacto']?>"/>
        	  &gt; e-mail
        	  <input type="text" name="email" value="<?=$row1['email']?>"/>
        	  &gt; Password
        	  <input type="text" name="password" value="<?=$row1['password']?>"/>
        	  <input type="submit" value="Enviar" class="submit"/>
			</div>
        </form>
	</div>
