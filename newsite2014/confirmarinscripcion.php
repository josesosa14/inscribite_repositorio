<?php include_once 'includes/header.php'?>
  <div class="left">
<?php $categoria = str_replace("_", " ", $_GET['cat']);
$cat = $_GET['cat'];
$cod = $_GET['cod'];
$result3 = mysql_query('SELECT * FROM '.pftables.'eventos WHERE codigo="'.$_GET['evento'].'" LIMIT 1');
$row3 = mysql_fetch_array($result3);
$tipo = $row3['tipo'];
$empresa = $row3['empresa'];
$web = $row3['web'];
//$coddelevento=$row1['codigo'];
//$result1=mysql_query('SELECT * FROM '.pftables.'inscripciones WHERE (codigo="'.$coddelevento.$_GET['cod'].$usuario.'") ORDER BY id DESC');
if (($_GET['modinscr'] == '') && ($tipo != 'Servicios')) {
	$result1=mysql_query('SELECT * FROM '.pftables.'inscripciones WHERE deevento="'.$evento.'" AND deusuario="'.$usuario.'" ORDER BY id DESC');
	while ($row1 = mysql_fetch_array($result1)) {
		$yaestainscripto = true;
	}
}
$result1 = mysql_query('SELECT * FROM '.pftables.'categorias WHERE nombre="'.$cat.'" AND deevento="'.$_GET['evento'].'" AND codigo="'.$cod.'" LIMIT 1');
$row1 = mysql_fetch_array($result1)?>
    <form action="imprimircupon.php?evento=<?=$_GET['evento']?>&opcion=<?=$_GET['opcion']?>&cat=<?=$_GET['cat']?>&cod=<?=$_GET['cod']; if (isset($_GET['mes']))echo'&mes='.$_GET['mes']; echo($modinscr!='')?'&modinscr='.$modinscr:'';echo($_GET['codigodedescuento']!='')?'&codigodedescuento='.$_GET['codigodedescuento']:''?>" method="post">
	<div style="float:left;display:inline;border:1px #78B047 solid;padding:10px;width:650px;">
           <p><strong>
<?php if (!$yaestainscripto) {
if ($tipo=='Servicios') { ?>
             Usted está gestionando el pago de cuota de 
             <?=$row3['nombre']?>
             en la opción 
             <?=$row1['opcion']?>
             mes 
             <?=$cat?>
             .</strong>
           </p>
        <p>Si la misma no se confirma efectivizando el pago correspondiente antes de la fecha de vencimiento se anulará la gestión de pago y tendrá que repetir el proceso.
        </p>
      <p>
<?php  } else { ?>
		Usted esta por <span style="font-weight: bold">RESERVAR</span> una vacante en el evento <strong>
		<?=$row3['nombre']?>
		</strong> la opción: <strong>
		<?=$row1['opcion']?>
		</strong>, categoría: <strong>
		<?=$cat?>
		</strong> donde participan de <strong>
		<?=$row1['edadminima']?>
		</strong> a <strong>
		<?=$row1['edadmaxima']?>
		</strong> años de edad.
		<br/>
		</p>
		<p>Si la misma no se confirma efectivizando el pago correspondiente  antes de la fecha de vencimiento la vacante quedará liberada pudiendo ser ocupada por otra persona.
		</p>
<?php  }
    if ($row3['pregunta1']!='')
      echo '<div style="margin-top:10px">'.$row3['pregunta1'].'<input type="text" name="respuesta1" id="respuesta1" onkeyup="'."if ((this.value!='')&&(document.getElementById('respuesta2').value!='')&&(document.getElementById('respuesta3').value!='')&&(document.getElementById('acepto').checked))document.getElementById('confirmar').disabled=''; else document.getElementById('confirmar').disabled='disabled'".'" style="margin-left:20px"/></div>';
    else
      echo '<input type="hidden" id="respuesta1" value="1"/>';
    if ($row3['pregunta2']!='')
      echo '<div style="margin-top:10px">'.$row3['pregunta2'].'<input type="text" name="respuesta2" id="respuesta2" onkeyup="'."if ((this.value!='')&&(document.getElementById('respuesta1').value!='')&&(document.getElementById('respuesta3').value!='')&&(document.getElementById('acepto').checked))document.getElementById('confirmar').disabled=''; else document.getElementById('confirmar').disabled='disabled'".'" style="margin-left:20px"/></div>';
    else
      echo '<input type="hidden" id="respuesta2" value="1"/>';
    if ($row3['pregunta3'] != '')
      echo '<div style="margin-top:10px">'.$row3['pregunta3'].'<input type="text" name="respuesta3" id="respuesta3" onkeyup="'."if ((this.value!='')&&(document.getElementById('respuesta1').value!='')&&(document.getElementById('respuesta2').value!='')&&(document.getElementById('acepto').checked))document.getElementById('confirmar').disabled=''; else document.getElementById('confirmar').disabled='disabled'".'" style="margin-left:20px"/></div>';
    else
      echo '<input type="hidden" id="respuesta3" value="1"/>';

?>
 <div style="font-size:11px;border:1px red solid;margin-top:10px;padding:4px;float:left; background-color:#E0E0E0; width:635px;">
  <input type="checkbox" id="acepto" style="float:left;margin:5px 0px 0px 10px" onclick="if ((this.checked)&&(document.getElementById('respuesta1').value!='')&&(document.getElementById('respuesta2').value!='')&&(document.getElementById('respuesta3').value!=''))document.getElementById('confirmar').disabled=''; else document.getElementById('confirmar').disabled='disabled';"/>
  <script type="text/javascript">
  <!--
  document.getElementById('acepto').checked=false
  -->
  </script>
  <div style="float:right;width:600px">ACEPTO CADA UNA DE LAS CONDICIONES Y REGLAMENTO QUE EXPRESA LA ENTIDAD ORGANIZADORA DEL EVENTO PARA PARTICIPAR EN EN EL MISMO, (CONSULTAR WEBSITE DEL ORGANIZADOR <?
  /*
  $result2=mysql_query('SELECT * FROM '.pftables.'empresas WHERE nombre="'.$empresa.'" LIMIT 1');
  $row2=mysql_fetch_array($result2);
  echo $row2['web']
  */
  echo '<a href="http://'.str_replace('http://','',$web).'">'.strtoupper($web).'</a>';
  ?>)  </div>
 </div>
<div>
 <input type="submit" value="Confirmar" id="confirmar" disabled="disabled" style="width:200px;float:left;font-size:14px;margin-left:42px;margin-top:20px;"/>
 <a href="javascript:history.back()" style="float:left;clear:none;margin-top:24px;margin-left:15px;font-size:12px;">Cancelar</a>
</div>
<?php  } else { ?>
     Ya te encontrás inscripto en este evento. Para cancelar o modificar tus inscripciones ingresá en <a href="usuario">Ver mi cuenta</a> o haciendo click <a href="usuario">aquí</a>.
<?php  } ?>
	</div>
    </form>
<?php include_once 'includes/footerfull.php'?>