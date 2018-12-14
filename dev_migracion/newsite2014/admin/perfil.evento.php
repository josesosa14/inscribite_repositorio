<?	$result1 = mysql_query('SELECT * FROM inscribite_eventos WHERE id = '.$_GET['editando'].' LIMIT 1 ');
	if (is_resource($result1)) {
		$row1 = mysql_fetch_array($result1);
		$nroid = $row1['id'];
	} ?>
   <div>
    <div class="titulosec"><a href="?sec=eventos.admin">Eventos</a> &gt; <?=(is_resource($result1))?'Editando: '.$row1['nombre']:'Agregar Nuevo'?></div>
     <form enctype="multipart/form-data"  action="guardar.php" method="post">
      <div>
       <input type="hidden" name="id" value="<?=$nroid?>"/>
       <input type="hidden" name="tabla" value="inscribite_eventos"/>
       <input type="hidden" name="volvera" value="eventos.admin"/>
       <input type="hidden" name="pubdate" value="<?=date("D, d M Y H:i:s")?>"/>
       <input type="hidden" name="codigoanterior" value="<?=$row1['codigo']?>"/>
       <table>
        <tr style="background:none">
         <td>
           <div class="contcheckbox" style="margin-right:30px">
             <input type="hidden" name="ver" value="0"/>
             <span>&gt; Ver</span>
             <input type="checkbox" name="ver" value="1"<?=($row1['ver'] == 1)?' checked="checked"':''?>/>
           </div>
         </td>
         <td>
           &gt; Fecha (dd/mm/aa)<br/>
           <input type="text" name="fecha" value="<?=$row1['fecha']?>" style="width:100px"/>
         </td>
         <td>
           &gt; Código(4 cifras)
           <input type="text" name="codigo" value="<?=$row1['codigo']?>" size="4" id="inputcodigo" class="inputcodigo"/>
         </td>
         <td>
           &gt; Puntos que otorga
           <input type="text" name="puntos" value="<?=$row1['puntos']?>" style="width:100px"/>
         </td>
        </tr>
        <tr style="background:none">
         <td>
           <div class="contselect">
             &gt; Tipo del Evento<br/>
             <select name="tipo">
               <option value="">Selecciona el Rubro</option>
               <option<?php if ($row1['tipo'] == 'Deportivos')   echo ' selected="selected"'?> value="Deportivos">Deportivos</option>
               <option<?php if ($row1['tipo'] == 'Capacitación') echo ' selected="selected"'?> value="Capacitación">Capacitación</option>
               <option<?php if ($row1['tipo'] == 'Servicios')    echo ' selected="selected"'?> value="Servicios">Mensualidades (Servicios)</option>
               <option<?php if ($row1['tipo'] == 'Productos')    echo ' selected="selected"'?> value="Productos">Productos</option>
               <option<?php if ($row1['tipo'] == 'Otros')        echo ' selected="selected"'?> value="Otros">Otros</option>
             </select>
           </div>
         </td>
         <td>
           <div class="contcheckbox">
            <input type="hidden" name="mostrarcinscriptos" value="0"/>
            <span>&gt; Mostrar competidores inscriptos</span>
            <input type="checkbox" name="mostrarcinscriptos" value="1"<?=($row1['mostrarcinscriptos'] == 1)?' checked="checked"':''?>/>
           </div>
         </td>
         <td>
           <div class="contselect">
             &gt; Empresa<br/>
             <select name="empresa">
               <option value="">Selecciona Empresa</option>
<?	$result2 = mysql_query('SELECT * FROM empresa ');
	while ($row2 = mysql_fetch_array($result2)) { ?>
               <option value="<?=$row2['emp_nombre']?>"<?=($row1['empresa'] == $row2['emp_nombre'])?' selected="selected"':''?>><?=$row2['emp_nombre']?></option>
<?	} ?>
             </select>
           </div>
         </td>
         <td>
           <div class="contcheckbox">
             <input type="hidden" name="eventodelmes" value="0"/>
             <span>&gt; Evento del mes</span>
          	 <input type="checkbox" name="eventodelmes" value="1"<?php if ($row1['eventodelmes'] == 1) echo ' checked="checked"'?>/>
           </div>
         </td>
        </tr>
       </table>
       <input type="hidden" name="nombreanterior" value="<?=$row1['nombre']?>"/>
       &gt; Nombre del Evento
       <input type="text" name="nombre" value="<?=$row1['nombre']?>"/>

       &gt; Sitio web
       <input type="text" name="web" value="<?=$row1['web']?>"/>

       &gt; Descripción del Evento
       <textarea name="descripcion" cols="50" rows="10" id="descrevent"><?=$row1['descripcion']?></textarea>

       &gt; Opciones
       <table id="tablaopciones">
         <tr style="background:none;">
           <td>&nbsp;
             
           </td>
           <td>
             Nombre
           </td>
           <td style="width:100px">
             Cupo
           </td>
           <td>
             Cupo Restante
           </td>
           <td>&nbsp;
             
           </td>
         </tr>
<?
//for ($i = 1; $i <= 4; $i++) {
$cuenta = 0;
if ($row1['codigo'] != '') {
  $result2 = mysql_query('SELECT * FROM inscribite_opciones WHERE evento = "'.$row1['codigo'].'" ');
  while ($row2 = mysql_fetch_array($result2)) {
    $cuenta++; ?>
         <tr style="background:none;">
           <td>
             <?=$cuenta?>
           </td>
           <td>
             <input type="text" name="opcion<?=$cuenta?>" value="<?=$row2['nombre']?>"/>
             <input type="hidden" name="idopcion<?=$cuenta?>" value="<?=$row2['id']?>"/>
           </td>
           <td>
             <input type="text" class="inputcodigo" name="cupoopcion<?=$cuenta?>" value="<?=($row2['cupo'] != '')?$row2['cupo']:'9999'?>"/>
           </td>
           <td>
             <?=($row2['cupo']+$row2['cuporestante'])?>
           </td>
           <td>
             <a href="javascript:confirm_entry('<?=$row2['nombre']?>', 'eventos.editaramp;editando=<?=$row1['id']?>', 'inscribite_opciones',<?=$row2['id']?>)"><img src="images/deletex.gif" alt="Eliminar"/></a>
           </td>
         </tr>
<?
  }
}
?>
       </table>
<script type="text/javascript">
 comilla = '"';
 numerodeop = <?=($cuenta + 1)?>;
</script>
          <a href="" onclick="
            var objSource = document.getElementById('tablaopciones');
            var oRows = objSource.getElementsByTagName('tr');
            var iRowCount = oRows.length;
            currentTR = objSource.insertRow(iRowCount);
            currentTR.style.background = 'none';
            currentTD = currentTR.insertCell(0);
            currentTD.innerHTML = numerodeop;
            currentTD = currentTR.insertCell(1);
            currentTD.innerHTML = '<input type='+comilla+'text'+comilla+' name='+comilla+'opcion'+numerodeop+comilla+' id='+comilla+'opcion'+numerodeop+comilla+' value='+comilla+comilla+'/>';
            currentTD = currentTR.insertCell(2);
            currentTD.innerHTML = '<input type='+comilla+'text'+comilla+' class='+comilla+'inputcodigo'+comilla+' name='+comilla+'cupoopcion'+numerodeop+comilla+' value='+comilla+'9999'+comilla+'/>';
            currentTD = currentTR.insertCell(3);
            currentTD.innerHTML = '';
            currentTD = currentTR.insertCell(4);
            currentTD.innerHTML = '';
            document.getElementById('opcion'+numerodeop).focus();
            numerodeop++;
            return false;">Agregar opción</a><br/>
<?
/*
            <div>
              &gt; Logo
<?
if (file_exists("../imagenes/logo_".@$row1['logo'])) echo '<img src="../imagenes/logo_'.$row1['logo'].'" alt=""/>';
 if ($sec != 'eventos.agregar') echo 'Cambiar: '?><input name="logo" type="file"/>
            </div>
            <div>
                &gt; Im&aacute;gen (160px x 120px)
<?
if (file_exists("../imagenes/media_".@$row1['imagen'])) echo '<img src="../imagenes/media_'.$row1['imagen'].'" alt=""/>';
 if ($sec != 'eventos.agregar') echo 'Cambiar: '?><input name="imagen" type="file"/>
            </div>
*/
?>
       <div style="width:100%;float:left;">
         <input type="hidden" name="nombrevar" value="imagen1"/>
         <input type="hidden" name="width1" value="160"/>
         <input type="hidden" name="height1" value="120"/>
         <input type="hidden" name="width2" value="160"/>
         <input type="hidden" name="height2" value="120"/>
         <div style="margin-top:20px;margin-bottom:16px;padding:0px;width:49%;float:left;clear:left;">
           &gt; Logo
<?
if (($row1['imagen1'] != '') && (file_exists($directorio.'image_'.$row1['imagen1'])))
    echo '<div><img src="'.$directorio.'image_'.$row1['imagen1'].'" alt="" style="margin:10px 0px 10px 0px;"/></div>'?>
        <br/>
        Subir imagen nueva:<br/><input name="imagen1" type="file" style="display:inline;width:300px;"/>
        </div>
        <div style="margin-top:20px;margin-bottom:16px;padding:0px;width:49%;float:left;clear:none;">
        &gt; Im&aacute;gen (160px x 120px)
<?
if (($row1['imagen2'] != '') && (file_exists($directorio.'image_'.$row1['imagen2'])))
    echo '<div><img src="'.$directorio.'image_'.$row1['imagen2'].'" alt="" style="margin:10px 0px 10px 0px;"/></div>'?>
        <br/>
        Subir imagen nueva:<br/><input name="imagen2" type="file" style="display:inline;width:300px;"/>
        </div>
<script type="text/javascript">
<!--
    textohabitual = 'Deslinde de responsabilidades:\n'+
'Manifiesto y declaro bajo juramento que me encuentro en perfectas condiciones de salud para competir en la prueba. Por la presente y en mi propio nombre y de mis herederos RENUNCIO A LA INDEMNIZACION POR DAÑOS Y/O PERJUICIOS y LIBERO PARA SIEMPRE DE TODA RESPONSABILIDAD a la empresa y a cada una de las empresas y marcas auspiciantes, que participen de alguna manera conectada con la competencia, en la cual habré de participar, respecto a toda acción, reclamo, demanda que haya hecho, que intente actualmente hacer o que en el futuro pueda hacer, por motivo de haberme inscripto y/o participado en esta competencia deportiva, o por cualquier pérdida de equipo o efectos personales antes, durante y después del desarrollo de la misma.\n'+
'Es indispensable la presentación de este cupón debidamente impreso el registro de pago en cajeros o centros de Pago Fácil antes del inicio del evento según requisito de la empresa o institución organizadora.';
-->
</script>
       </div>
       &gt; Texto particular para el cupón - <a href="#" onclick="document.getElementById('textoencupon').value=textohabitual;return false;">Texto Habitual</a>
       <textarea name="textoencupon" cols="50" rows="10" id="textoencupon"><?=$row1['textoencupon']?></textarea>
       &gt; Pregunta particular 1
       <input type="text" name="pregunta1" value="<?=$row1['pregunta1']?>"/>
       &gt; Pregunta particular 2
       <input type="text" name="pregunta2" value="<?=$row1['pregunta2']?>"/>
       &gt; Pregunta particular 3
       <input type="text" name="pregunta3" value="<?=$row1['pregunta3']?>"/>

<script type="text/javascript">
<!--
    textohabitual2 = 'Gracias por usar los servicios de inscribite on line. Hemos registrado una inscripción de tu parte y queremos recordarte que la misma está en el estado de RESERVADA. Esto significa que estás ocupando una vacante en forma temporaria hasta que abones el importe de la inscripción. A las 48Hs de haberlo concretado tu inscripción estará en estado de CONFIRMADA.';
    textohabitual3 = 'Gracias por usar los servicios de inscribite on line. Hemos registrado una inscripción de tu parte y queremos recordarte que la misma está en el estado de RESERVADA. Esto significa que estás ocupando una vacante en forma temporaria hasta que abones el importe de la inscripción. A las 48Hs de haberlo concretado tu inscripción estará en estado de CONFIRMADA.';
-->
</script>
       </div>
       &gt; Texto alternativo para email de inscripción reservada
       <textarea name="textoemailreserva" cols="50" rows="10" id="textoemailres"><?=$row1['textoemailreserva']?></textarea>

       &gt; Texto alternativo para email de confirmación
       <textarea name="textoemailconfirma" cols="50" rows="10" id="textoemailconf"><?=$row1['textoemailconfirma']?></textarea>
<?php /*
        Banner en cupón
        <div style="width:470px;float:left;clear:none;">
          &gt; Link
          <input type="text" name="link" value="<?=$row1['link']?>"/>
        </div>
        <input type="hidden" name="nombrevar" value="imagen1"/>
        <input type="hidden" name="width1" value="544"/>
        <input type="hidden" name="height1" value="60"/>

        <div style="margin-top:20px;margin-bottom:16px;padding:0px;width:100%;float:left;clear:left;">
         &gt; Imagen 1
<?
if (($row1['imagen1'] != '') && (file_exists($directorio.'image_'.$row1['imagen1']))) {
  echo '<div><img src="'.$directorio.'image_'.$row1['imagen1'].'" alt="" style="margin:10px 0px 10px 0px;"/></div>';
} ?>
        <br/>
        Subir imagen nueva:<br/><input name="imagen1" type="file" style="display:inline;width:300px;"/>
        </div>
*/ ?>

            <input type="submit" value="Enviar" class="submit" onclick="document.body.style.backgroundImage = 'url(images/ajaxloadingbig.gif)';"/>

        </form>
      </div>
