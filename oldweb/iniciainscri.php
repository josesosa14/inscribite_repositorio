<?php
$nomostrarcoli = true;
include 'includes/head.php';
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
function getdatosusuario(){
  global $usuario, $sexodelusuario, $fechanac;
  $result1 = mysql_query('SELECT * FROM inscribite_usuarios WHERE dni="'.$usuario.'" LIMIT 1 ');
  $row = mysql_fetch_array($result1);
  $sexodelusuario = $row['sexo'];
  $fechanac = $row['fechanac'];
  echo $row['nombre'].' '.$row['apellido'];
  mysql_free_result($result1);
}
function versiesmasbarato(){
  global $row2;
  if (isset($_GET['modinscr'])) {
    if (gregoriantojd(date("m"), date("d"), date("Y")) < gregoriantojd(substr($row2['vencimiento1'], 5, 2), substr($row2['vencimiento1'], 8, 2), substr($row2['vencimiento1'], 0, 4)))
      $preciodecat = $row2['precio1'];
    elseif (gregoriantojd(date("m"), date("d"), date("Y")) < gregoriantojd(substr($row2['vencimiento2'], 5, 2), substr($row2['vencimiento2'], 8, 2), substr($row2['vencimiento2'], 0, 4)))
      $preciodecat = $row2['precio2'];
    elseif (gregoriantojd(date("m"), date("d"), date("Y")) < gregoriantojd(substr($row2['vencimiento3'], 5, 2), substr($row2['vencimiento3'], 8, 2), substr($row2['vencimiento3'], 0, 4)))
      $preciodecat = $row2['precio3'];
    $result1 = mysql_query('SELECT pagado, precio FROM inscribite_inscripciones WHERE id="'.$_GET['modinscr'].'" LIMIT 1 ');
    $row    = mysql_fetch_array($result1);
    if (($row['pagado'] == 1) && ($row['precio'] < $preciodecat)) return true; else return false;
    mysql_free_result($result1);
  } else return true;
}
$result1 = mysql_query('SELECT * FROM inscribite_eventos WHERE codigo="'.$_GET['evento'].'" LIMIT 1 ');
$row     = mysql_fetch_array($result1);
?>
      <div class="columnacentral" style="width:550px;height:auto;padding-left:15px;overflow:hidden;">
        Inscripción a:<br/><strong><?=$row['nombre']?></strong>
<?php
//if (strpos($_SERVER['HTTP_USER_AGENT'],'Validator') > 0) $usuario = 29865763;
if (!($usuario != "")) {
  echo '		<div style="margin:8px 0px 5px 19px;color:#336699;font-size:11px;">
        Por favor ingrese su DNI -------------------------------------------------------------------------------------------&gt;<br/>
		</div>'.chr(13);
} else { ?>
          <br/><br/>Usted está logueado como <strong><? getdatosusuario(); ?></strong><br/><br/><a href="cerrarsesion">Cerrar Sesion para registrar a otro usuario</a><br/><a href="registrate?usuario=<?=$usuario?>">Ver o cambiar mis datos</a><br/><br/>
<?php
$result2 = mysql_query('SELECT * FROM inscribite_descuentos WHERE codevento="'.$_GET['evento'].'" AND coddni='.$usuario.' LIMIT 1 ');
$row2    = mysql_fetch_array($result2);
if (mysql_num_rows($result2) > 0) {
$codigodedescuentovalido = $row2['codigo']; ?>
          <div style="margin-bottom:6px;">Descuento del <?=$row2['porcentajedescuento']?>%</div>
<?php
} ?>
          Elija Categoría:<br/>
          <span style="font-size:11px;color:#777777">
          Por tu edad y sexo solo podras elegir entre las categorías que están destacadas en verde. Verificá que sea realmente en la que deseas participar.
          </span>
<?php
  $result3 = mysql_query('SELECT * FROM inscribite_opciones WHERE evento="'.$_GET['evento'].'" OR evento="'.($_GET['evento']*1).'" ');
  while ($row3 = mysql_fetch_array($result3)) {
    $result2 = mysql_query('SELECT * FROM inscribite_categorias WHERE deevento="'.$_GET['evento'].'" AND opcion="'.trim($row3['nombre']).'" ORDER BY codigo ');
?>
          <div class="titucevlist">
            <?=$row3['nombre'];
    if ((($row3['cupo']+$row3['cuporestante']) <= 0) && ($row['tipo'] != 'Servicios'))echo ' <span style=""> - No quedan vacantes disponibles en este grupo</span>'.chr(13);
    if ($row3['cupo'] != 0) {
      echo '<span style="margin-right:5px;float:right;clear:none;font-weight:normal;font-size:11px;"> vacantes disponibles (';
      echo (($row3['cupo']+$row3['cuporestante']) >= 0)?($row3['cupo']+$row3['cuporestante']):'0';
      echo ')</span>'.chr(13);
    } ?>
          </div>
<?php
    while ($row2 = mysql_fetch_array($result2)) {
      $edadcomputable = ledad($fechanac, $row2['fechadecomputo']);

      if ((($row2['sexo'] == 'Ambos') || (strtolower($row2['sexo']) == strtolower($sexodelusuario))) && ((($edadcomputable>=$row2['edadminima']) && ($edadcomputable<=$row2['edadmaxima'])) || ($row2['limitedeedad'] == 0)) && ((versiesmasbarato()) || ($row['tipo'] == 'Servicios'))) { ?>
          <div class="cevlist">
<?    if (gregoriantojd(date("m"), date("d"), date("Y")) == gregoriantojd(substr($row['vencimiento3'], 5, 2), substr($row['vencimiento3'], 8, 2), substr($row['vencimiento3'], 0, 4))-1 )
        echo '			<span style="color:#FF0000;">Hoy es el último día para el pago de tu inscripción</span>'.chr(13); ?>
            <a id="linkinscr<?=$row2['id']?>"<? if (!((($row3['cupo']+$row3['cuporestante'])<=0) && ($row['tipo'] != 'Servicios'))) echo ' href="confirmarinscripcion?evento='.$_GET['evento'].'&amp;opcion='.$row3['nombre'].'&amp;cat='.$row2['nombre'].'&amp;cod='.$row2['codigo']; echo '&amp;mes='.substr('0'.$mesactual, -2, 2).$anioactual; if ($_GET['modinscr'] != "")echo"&amp;modinscr=".$_GET['modinscr'];echo($_GET['codigodedescuento'] != '')?'&codigodedescuento='.$_GET['codigodedescuento']:''; echo '"';?>>
              <span style="float:left;width:auto;">
                &gt; <?=$row2['nombre']." ".$row2['descripcion'].'<br/>'.chr(13)?>
                <span style="font-size:10px;font-weight:normal;"><?
      if (($row['tipo'] != 'Productos') && ($row['tipo'] != 'Servicios'))
        echo 'Sexo: '.$row2['sexo'];
      if (($row['tipo'] == 'Deportivos') && ($row2['limitedeedad'] == 1))
        echo ' Edad: de '.$row2['edadminima'].' a '.$row2['edadmaxima'].' (calculada al '.substr($row2['fechadecomputo'], 6, 2)."/".substr($row2['fechadecomputo'], 4, 2)."/".substr($row2['fechadecomputo'], 0, 4).')'.chr(13); ?>
                </span>
              </span>
              <span style="float:right;clear:none;margin:5px 4px 0px 0px;">
                &lt; Inscribirse
              </span>
            </a>
<? if ($row['tipo'] == 'Servicios') mostrarselectmeses()?>
          </div>
<?php   }
    }
  }
} ?>
		</div>
<?
include 'includes/colder.php';
?>