<?php include_once 'includes/header.php'?>
  <div class="left">
<?
$nomostrarcoli = true;
//include_once 'includes/head.php';
function ledad($fechanacdeurs,$fechadecomput) {
  // El formato es yyyymmdd
  $y = substr($fechanacdeurs, 0, 4)*1;
  $m = substr($fechanacdeurs, 4, 2)*1;
  $d = substr($fechanacdeurs, 6, 2)*1;
  $agnox = substr($fechadecomput, 0, 4)*1;
  $mesx  = substr($fechadecomput, 4, 2)*1;
  $diax  = substr($fechadecomput, 6, 2)*1;
  $age = $agnox-$y;
  if (($m+0) > ($mesx+0)) $age--;
  if ((($m+0) == ($mesx+0)) && (($d+0)>($diax+0))) $age--;
  return $age;
}
$mesactual    = date('n');
$anioactual   = date('y');
$seismesesmas = $mesactual+6;
function mostrarselectmeses() {
  global $row2, $mesactual, $anioactual, $seismesesmas;
  $meses        = array('', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
  echo '            <select onchange="document.getElementById(\'linkinscr'.$row2['id'].'\').href=\'confirmarinscripcion?evento='.$_GET['evento'].'&amp;opcion='.$row3['nombre'].'&amp;cat='.$row2['nombre'].'&amp;cod='.$row2['codigo'].'&amp;mes=\'+this.value';
  if ($_GET['modinscr'] != "") echo "&amp;modinscr=".$_GET['modinscr'];
  if ($_GET['codigodedescuento'] != '') echo '&codigodedescuento='.$_GET['codigodedescuento'];
  echo ';">'.chr(13);
  for ($m = $mesactual-3; $m <= $seismesesmas; $m++) {
    $mes  = $m;
    $anio = $anioactual;
    if ($m < 1) {
      $mes = $mes+12;
      $anio--;
    }
    if ($m > 12) {
      $mes = $mes-12;
      $anio++;
    }
    echo '              <option value="'.substr('0'.$mes, -2, 2).substr('0'.$anio, -2, 2).'"';
    if ($mes == $mesactual) echo ' selected="selected"';
    echo '>'.$meses[$mes].' '.substr('0'.$anio, -2, 2).'</option>'.chr(13);
  }
  echo '            </select>'.chr(13);
}
function getdatosusuario() {
  global $usuario, $sexodelusuario, $fechanac;
  $result1 = mysql_query('SELECT * FROM '.pftables.'usuarios WHERE dni="'.$usuario.'" LIMIT 1 ');
  $row1 = mysql_fetch_array($result1);
  $sexodelusuario = $row1['sexo'];
  $fechanac = $row1['fechanac'];
  echo $row1['nombre'].' '.$row1['apellido'];
  mysql_free_result($result1);
}
function versiesmasbarato() {
  global $row2;
  if (isset($_GET['modinscr'])) {
    if (gregoriantojd(date("m"), date("d"), date("Y")) < gregoriantojd(substr($row2['vencimiento1'], 5, 2), substr($row2['vencimiento1'], 8, 2), substr($row2['vencimiento1'], 0, 4)))
      $preciodecat = $row2['precio1'];
    elseif (gregoriantojd(date("m"), date("d"), date("Y")) < gregoriantojd(substr($row2['vencimiento2'], 5, 2), substr($row2['vencimiento2'], 8, 2), substr($row2['vencimiento2'], 0, 4)))
      $preciodecat = $row2['precio2'];
    elseif (gregoriantojd(date("m"), date("d"), date("Y")) < gregoriantojd(substr($row2['vencimiento3'], 5, 2), substr($row2['vencimiento3'], 8, 2), substr($row2['vencimiento3'], 0, 4)))
      $preciodecat = $row2['precio3'];
    $result1 = mysql_query('SELECT pagado, precio FROM '.pftables.'inscripciones WHERE id="'.$_GET['modinscr'].'" LIMIT 1 ');
    $row1    = mysql_fetch_array($result1);
    if (($row1['pagado'] == 1) && ($row1['precio'] < $preciodecat)) return true; else return false;
    mysql_free_result($result1);
  } else return true;
}
$result1 = mysql_query('SELECT * FROM '.pftables.'eventos WHERE codigo="'.$_GET['evento'].'" LIMIT 1 ');
$row1     = mysql_fetch_array($result1);
?>
      <div style="overflow:hidden;">
          <h1>Inscripción a:<strong>
          <?=$row1['nombre']?>
          </strong>
            <?
//if (strpos($_SERVER['HTTP_USER_AGENT'],'Validator') > 0) $usuario = 29865763;
if (!($usuario != "")) {
  echo '<br/><br/><div style="color:#FF0000; border:1px solid #FF0000; text-align:center; ">
		<br/>
		Por favor ingresa tu DNI, para inscribirte debes estar logueado<br/>
	    <br/>
		</div><br/></h1>'.chr(13);
} else { ?></h1>
            <br/>
        <h2>Estás logueado como <strong>
        <?php getdatosusuario(); ?>
        </strong><br/>
        <br/>
        <a href="cerrarsesion">Cerrar Sesion para registrar a otro usuario</a><br/>
        <a href="registrate?usuario=<?=$usuario?>">Ver o cambiar mis datos</a><br/></h2>
        <br/>
        <?
$result2 = mysql_query('SELECT * FROM '.pftables.'descuentos WHERE codevento = "'.$_GET['evento'].'" AND coddni='.$usuario.' LIMIT 1 ');
$row2    = mysql_fetch_array($result2);
if (mysql_num_rows($result2) > 0) {
$codigodedescuentovalido = $row2['codigo']; ?>
        <div style="margin-bottom:6px;">Descuento del <?=$row2['porcentajedescuento']?>%</div>
          <?
} ?>
        <h3>Elija Categoría:</h3>
        <p>Por tu edad y sexo solo podras elegir entre las categorías que están destacadas en verde. </p>
        <p>Verificá que sea realmente en la que deseas participar.
          <?
  $result3 = mysql_query('SELECT * FROM '.pftables.'opciones WHERE evento = "'.$_GET['evento'].'" OR evento="'.($_GET['evento']*1).'" ');
  while ($row3 = mysql_fetch_array($result3)) {
    $result2 = mysql_query('SELECT * FROM '.pftables.'categorias WHERE deevento = "'.$_GET['evento'].'" AND opcion="'.trim($row3['nombre']).'" ORDER BY codigo ');
?>
        </p>
	<div class="left_articles">    
		<div>
        <p><?=$row3['nombre'];
    if ((($row3['cupo']+$row3['cuporestante']) <= 0) && ($row1['tipo'] != 'Servicios'))echo ' <span style=""> - No quedan vacantes disponibles en este grupo</span>'.chr(13);
    if ($row3['cupo'] != 0) {
      echo '<span style="margin-right:5px;float:right;clear:none;font-weight:normal;font-size:11px;"> vacantes disponibles (';
      echo (($row3['cupo']+$row3['cuporestante']) >= 0)?($row3['cupo']+$row3['cuporestante']):'0';
      echo ')</span>'.chr(13);
    } ?></p>
        </div>
        </div>
<?
    while ($row2 = mysql_fetch_array($result2)) {
      $edadcomputable = ledad($fechanac, $row2['fechadecomputo']);

      if ((($row2['sexo'] == 'Ambos') || (strtolower($row2['sexo']) == strtolower($sexodelusuario))) && ((($edadcomputable>=$row2['edadminima']) && ($edadcomputable<=$row2['edadmaxima'])) || ($row2['limitedeedad'] == 0)) && ((versiesmasbarato()) || ($row1['tipo'] == 'Servicios'))) { ?>
      <div class="left_articles">
          <div class="cevlist">
<?php    if (gregoriantojd(date("m"), date("d"), date("Y")) == gregoriantojd(substr($row1['vencimiento3'], 5, 2), substr($row1['vencimiento3'], 8, 2), substr($row1['vencimiento3'], 0, 4))-1 )
        echo '			<span style="color:#FF0000;">Hoy es el último día para el pago de tu inscripción</span>'.chr(13); ?>
            <a id="linkinscr<?=$row2['id']?>"<?php if (!((($row3['cupo']+$row3['cuporestante'])<=0) && ($row1['tipo'] != 'Servicios'))) echo ' href="confirmarinscripcion?evento='.$_GET['evento'].'&amp;opcion='.$row3['nombre'].'&amp;cat='.$row2['nombre'].'&amp;cod='.$row2['codigo']; echo '&amp;mes='.substr('0'.$mesactual, -2, 2).$anioactual; if ($_GET['modinscr'] != "")echo"&amp;modinscr=".$_GET['modinscr'];echo($_GET['codigodedescuento'] != '')?'&codigodedescuento='.$_GET['codigodedescuento']:''; echo '"';?>>
              <span style="float:left;clear:left;width:auto;">
              <p>&gt; <?=$row2['nombre']." ".$row2['descripcion'].'<br/>'.chr(13)?>
                <span style="font-size:10px;font-weight:normal;"><?
      if (($row1['tipo'] != 'Productos') && ($row1['tipo'] != 'Servicios'))
        echo 'Sexo: '.$row2['sexo'];
      if (($row1['tipo'] == 'Deportivos') && ($row2['limitedeedad'] == 1))
        echo ' Edad: de '.$row2['edadminima'].' a '.$row2['edadmaxima'].' (calculada al '.substr($row2['fechadecomputo'], 6, 2)."/".substr($row2['fechadecomputo'], 4, 2)."/".substr($row2['fechadecomputo'], 0, 4).')'.chr(13); ?>
                </span></p>
              </span>
 			  <p class="greenbtn" style="float:right;">AVANZAR</p>
            </a>
            <?php if ($row1['tipo'] == 'Servicios') mostrarselectmeses()?>
          </div>
      </div>
<?php   }
    }
  }
} ?>
</div>
<?php include_once 'includes/footerfull.php'?>