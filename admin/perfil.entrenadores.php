<? $result1 = mysql_query('SELECT * FROM inscribite_entrenadores WHERE id = '.$_GET['editando'].' LIMIT 1 ');
if (is_resource($result1)) {
	$row1 = mysql_fetch_array($result1);
	$nroid = $row1['id'];
} ?>
          <div>
	            <div class="titulosec">Entrenadores &gt; <?=(is_resource($result1))?'Editando: '.$row1['nombre']:'Agregar Nuevo'?>
                </div>
            <div>
		      <form enctype="multipart/form-data"  action="guardar" method="post">
			    <div>
			      <input type="hidden" name="id" value="<?=$nroid?>"/>
			      <input type="hidden" name="tabla" value="inscribite_entrenadores"/>
			      <input type="hidden" name="volvera" value="entrenadores.admin"/>
			      &gt; Nombre
                  <input type="text" name="nombre" value="<?=$row1['nombre']?>"/>
                  &gt; Código
                  <input type="text" name="codigo" value="<?=$row1['codigo']?>"/>
          		  <input type="submit" value="Enviar" class="submit" onclick="document.body.style.backgroundImage = 'url(images/ajaxloadingbig.gif)';"/>
                </div>
              </form>
            </div>
          </div>
