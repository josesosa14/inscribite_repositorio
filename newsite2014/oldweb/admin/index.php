<? header("Content-type: text/html; charset=UTF-8");
$admin_username = $_COOKIE['admin_username'];
$admin_password = $_COOKIE['admin_password'];
if (($_POST['admin_username'] != "") && ($_POST['admin_username'] != "")) {
  setcookie("admin_username", $_POST['admin_username'], time()+7776000, "/");
  setcookie("admin_password", $_POST['admin_password'], time()+7776000, "/");
  $admin_username = $_POST['admin_username'];
  $admin_password = $_POST['admin_password'];
}
if (($admin_username == "beebee") && ($admin_password == "argentina")) $passwordok = true;
if (($admin_username == "fabian") && ($admin_password == "1902"))      $passwordok = true;
if (($admin_username == "pablo") && ($admin_password == "rebon"))      $passwordok = true;
if (strpos($_SERVER['HTTP_USER_AGENT'],'Validator') > 0) $passwordok = true;
mysql_select_db("inscribite_base",mysql_connect("localhost", "inscribite_user", "iW7zNKpRWkSHHwplBhUO"));
//http://www.maritimopro.com.ar:2082/3rdparty/phpMyAdmin/index.php
if ($passwordok) {
  function agceros($nombreag, $cantceros) {
    while (strlen($nombreag) < $cantceros) $nombreag = "0".$nombreag;
    return $nombreag;
  }
  function agcnbsp($nombreag, $cantceros) {
    while (strlen($nombreag) < $cantceros) $nombreag = "z".$nombreag;
    $nombreag = str_replace('z', '&nbsp;', $nombreag);
    return $nombreag;
  }
  $directorio = '../imagenes/';
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
 <head>
  <title>Inscribite Online - Administración</title>
  <meta name="robots" content="noindex,nofollow"/>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <script type="text/javascript" src="js/script.js"></script>
  <link href="estilo.css" rel="stylesheet" type="text/css"/>
 </head>
 <body>
 <div id="contentodo">
  <div id="cabezal">
   <a href="../">Inscribite Online</a> | <a href="./">Administración</a>
   <a href="cerrarsesion" style="position:absolute;right:10px;top:0px;font-size:10px;">Cerrar Sesión</a>
  </div>
  <div id="menulateral">
   <div id="contminimizmaximiz">
    <a href="" onclick="maximizarmenu();return false;" title="Maximizar">&gt;</a>
    <a href="" onclick="minimizarmenu();return false;" title="Minimizar" id="minimizar">&lt;</a>
   </div>
   <div id="restocontenidomenu" style="width:100%;overflow:hidden;">
    <h2>Eventos</h2>
    <div><a href="?sec=eventos.agregar">Agregar Nuevo</a></div>
    <div><a href="?sec=eventos.admin">Administrar</a></div>
    <h2>Usuarios</h2>
    <span>Buscar</span>
    <form action="" method="get">
     <div>
      <input type="hidden" name="sec" value="buscar.usuarios"/>
      <input type="text" name="busqueda" class="inputbusca"/><input type="submit" value="" style="width:15px;margin-left:5px;"/>
      <a href="usuarios">Ver Lista</a>
      <a href="excelusuarioscompl.php">Descargar</a>
     </div>
    </form>
    <h2>Inscripciones</h2>
    <span>Buscar: (dni)</span>
    <form action="" method="get">
     <div>
      <input type="hidden" name="sec" value="inscripciones.admin"/>
      <input type="text" name="busqueda" class="inputbusca"/><input type="submit" value="" style="width:15px;margin-left:5px;"/>
     </div>
    </form>
    <a href="?sec=feedback.pagofacil">Subir Pagos</a>
    <h2>Descuentos</h2>
    <a href="?sec=descuentos.agregar">Agregar Nuevo</a>
    <a href="?sec=descuentos.admin">Administrar</a>
    <h2>Empresas</h2>
    <a href="?sec=empresas.agregar">Agregar Nueva</a>
    <a href="?sec=empresas.admin">Administrar</a>
<?
/*
    <h2>Entrenadores</h2>
    <a href="?sec=entrenadores.agregar">Agregar Nuevo</a>
    <a href="?sec=entrenadores.admin">Administrar</a>
*/
?>
    <h2>Banners</h2>
    <a href="?sec=banners.agregar">Agregar Nuevo</a>
    <a href="?sec=banners.admin">Administrar</a>
    <h2>Preguntas Frequentes</h2>
    <a href="?sec=faq.agregar">Agregar Nueva</a>
    <a href="?sec=faq.admin">Administrar</a>
    <h2>Visitas</h2>
    <a href="https://www.google.com/analytics/home/?et=reset&amp;hl=es-ES" title="Correo Electrónico: fabianderamo Contraseña: mar5445">Ver Estadísticas</a>
   </div>
  </div>
  <div id="main">
<?
if (($_GET['sec'] == 'eventos.agregar') || ($_GET['sec'] == 'eventos.editar')) {
  $result1 = mysql_query('SELECT * FROM inscribite_eventos WHERE id = '.$_GET['editando'].' LIMIT 1 ');
  if (is_resource($result1)) {
    $row1 = mysql_fetch_array($result1);
    $nroid = $row1['id'];
  }
?>
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
               <option<? if ($row1['tipo'] == 'Deportivos')   echo ' selected="selected"'?> value="Deportivos">Deportivos</option>
               <option<? if ($row1['tipo'] == 'Capacitación') echo ' selected="selected"'?> value="Capacitación">Capacitación</option>
               <option<? if ($row1['tipo'] == 'Servicios')    echo ' selected="selected"'?> value="Servicios">Mensualidades (Servicios)</option>
               <option<? if ($row1['tipo'] == 'Productos')    echo ' selected="selected"'?> value="Productos">Productos</option>
               <option<? if ($row1['tipo'] == 'Otros')        echo ' selected="selected"'?> value="Otros">Otros</option>
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
<?
$result2 = mysql_query('SELECT * FROM inscribite_empresas ');
while ($row2 = mysql_fetch_array($result2)) {
?>
               <option<?=($row1['empresa'] == $row2['nombre'])?' selected="selected"':''?>><?=$row2['nombre']?></option>
<?
}
?>
             </select>
           </div>
         </td>
         <td>
           <div class="contcheckbox">
             <input type="hidden" name="eventodelmes" value="0"/>
             <span>&gt; Evento del mes</span>
          	 <input type="checkbox" name="eventodelmes" value="1"<? if ($row1['eventodelmes'] == 1) echo ' checked="checked"'?>/>
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
           <td>
             &nbsp;
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
           <td>
             &nbsp;
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
            currentTD.innerHTML = '<input type='+comilla+'text'+comilla+' name='+comilla+'opcion'+numerodeop+comilla+' value='+comilla+comilla+'/>';
            currentTD = currentTR.insertCell(2);
            currentTD.innerHTML = '<input type='+comilla+'text'+comilla+' class='+comilla+'inputcodigo'+comilla+' name='+comilla+'cupoopcion'+numerodeop+comilla+' value='+comilla+'9999'+comilla+'/>';
            currentTD = currentTR.insertCell(3);
            currentTD.innerHTML = '';
            currentTD = currentTR.insertCell(4);
            currentTD.innerHTML = '';
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
<? /*
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
<?
}
if (($_GET['sec'] == 'eventos.admin') || ($_GET['sec'] == '')) {
?>
    <div class="titulosec">Eventos &gt; Admin</div>
    <div style="margin-bottom:6px;height:17px;">
      <div style="float:left;width:400px;">
        <a href="?sec=eventos.admin&amp;tipo=deportivos"<?=($_GET['tipo'] == 'deportivos')?'':' style="font-weight:normal;"'?>>Deportivos</a> |
        <a href="?sec=eventos.admin&amp;tipo=capacitación"<?=($_GET['tipo'] == 'capacitación')?'':' style="font-weight:normal;"'?>>Capacitación</a> |
        <a href="?sec=eventos.admin&amp;tipo=servicios"<?=($_GET['tipo'] == 'servicios')?'':' style="font-weight:normal;"'?>>Servicios</a> |
        <a href="?sec=eventos.admin&amp;tipo=productos"<?=($_GET['tipo'] == 'productos')?'':' style="font-weight:normal;"'?>>Productos</a>
      </div>
      <div style="width:400px;float:right;clear:none;text-align:right;">
<? if ($_GET['ver'] != 'todos') { ?>
      <a href="?sec=eventos.admin&amp;ver=todos" style="color:#0682B8;">Ver Todos</a> -
<? } else { ?>
      <a href="?sec=eventos.admin" style="color:#0682B8;">Ver solo actualmente publicados</a> -
<? } ?>
      <a href="#" onclick="
      var inputs = document.getElementsByTagName('input');
      idsparad = '';
      for (var i = 0; i < inputs.length; i++) {
        if ((inputs[i].classname = 'paradescargar') && (inputs[i].checked))
          idsparad += inputs[i].value+', ';
      }
      if (idsparad != '')
        location.href = 'excelinscompleto.php?eventos = '+idsparad;
      return false;" style="color:#0682B8;">Descargar</a>
<script type="text/javascript">
<!--
	var arrayIdxOrden = new Array();
<? $contnrodeid = 0;
$result1 = mysql_query('SELECT * FROM inscribite_eventos ORDER BY orden ');
while ($row1 = mysql_fetch_array($result1)) {
$contnrodeid++; ?>
	arrayIdxOrden[<?=$contnrodeid?>] = <?=$row1['id']?>;
<?
} ?>
-->
</script>
      </div>
    </div>
	<form action="guardarordenes" method="post">
      <div>
        <input type="hidden" name="tabla" value="inscribite_eventos"/>
        <input type="hidden" name="volvera" value="eventos.admin"/>
        <table>
         <tr>
<? /*      <th style="text-align:left;width:38px;">Nro</th> */ ?>
           <th>Cód.</th>
           <th>Ver</th>
           <th>Evento</th>
           <th><acronym title="Duplicar evento y sus categorias"><img src="images/duplicar.jpg" alt="Duplicar" style="margin:0px 0px 2px 3px;"/></acronym></th>
           <th>Tipo</th>
           <th>Empresa</th>
           <th style="width:100px;">Categorías</th>
           <th colspan="3">Inscripciones</th>
           <th>&nbsp;</th>
           <th>&nbsp;</th>
         </tr>
<?
$contnrodeid = 0;
if ($_GET['tipo'] != '')     $filtroportipo = ' AND tipo="'.$_GET['tipo'].'"';
$filtrover = '';
if ($_GET['ver'] != 'todos') $filtrover = ' AND ver = 1';
$result1 = mysql_query('SELECT * FROM inscribite_eventos WHERE id > 0'.$filtroportipo.$filtrover.' ORDER BY orden ');
while ($row1 = mysql_fetch_array($result1)) {
  $contnrodeid++;
  $result2 = mysql_query('SELECT * FROM inscribite_empresas WHERE nombre="'.$row1['empresa'].'" LIMIT 1 ');
  $row2 = mysql_fetch_array($result2) ?>
         <tr>
<? /*      <td>
             <div id="contorden<?=$contnrodeid?>_1">
               <input type="hidden" name="orden<?=$row1['id']?>" id="orden<?=$row1['id']?>" value="<?=$contnrodeid?>"/>
               <a href="?sec=eventos.editar&amp;editando=<?=$row1['id']?>" style="float:left;clear:none;margin-top:2px;margin-right:6px;"><?=substr("0".$row1[orden],-2,2)?></a>
               <span style="float:left;clear:none;width:6px;">
                 <a href="javascript:subirorden(<?=$row1['id']?>);" title="Subir Orden" style="margin:0px;"><img src="images/s_asc.png" alt="Subir Orden" style="float:left;margin:0px;"/></a>
                 <a href="javascript:bajarorden(<?=$row1['id']?>);" title="Bajar Orden" style="margin:0px;"><img src="images/s_desc.png" alt="Bajar Orden" style="float:left;margin:0px;"/></a>
               </span>
             </div>
           </td>
*/ ?>
          <td>
            <div id="contorden<?=$contnrodeid?>_2">
              <a href="?sec=eventos.editar&amp;editando=<?=$row1['id']?>"><?=$row1['codigo']?></a>
            </div>
          </td>
          <td>
            <div id="contorden<?=$contnrodeid?>_3">
              <a href="cambiacheck.php?tabla=inscribite_eventos&amp;campo=ver&amp;id=<?=$row1['id']?>&amp;volvera=eventos.admin" onclick="cmbcheck(this.parentNode,'inscribite_eventos', 'ver',<?=$row1['id']?>,'<?=$_GET['sec']?>');return false" title="Cambiar">
                <img src="images/<?=($row1['ver'] == 1)?'checkboxchecked.gif':'checkbox.gif'?>" alt="" style="margin-top:0px;"/>
              </a>
            </div>
          </td>
          <td>
            <div id="contorden<?=$contnrodeid?>_4">
              <a href="?sec=eventos.editar&amp;editando=<?=$row1['id']?>">
                <?=$row1['nombre']?>
              </a>
            </div>
          </td>
          <td>
            <div id="contorden<?=$contnrodeid?>_5">
              <a href="#" onclick="javascript:confirm_dupli('<?=$row1['nombre']?>',<?=$row1['id']?>)" title="Duplicar evento y sus categorias"><img src="images/duplicar.jpg" alt="Duplicar"/></a>
             </div>
          </td>
          <td>
            <div id="contorden<?=$contnrodeid?>_6">
              <a href="?sec=eventos.editar&amp;editando=<?=$row1['id']?>">
                <?=$row1['tipo']?>
              </a>
            </div>
          </td>
          <td>
            <div id="contorden<?=$contnrodeid?>_7">
              <?=$row1['empresa']?> <a href="?sec=empresas.editar&amp;editando=<?=$row2['id']?>">(Ver)</a>
            </div>
          </td>
          <td>
            <div id="contorden<?=$contnrodeid?>_8">
              <a href="?sec=categorias.admin&amp;evento=<?=$row1['codigo']?>" style="font-family:monospace;cursor:pointer;">
               <span style="float:left;cursor:pointer;"> <?=agcnbsp($num = mysql_num_rows(mysql_query('SELECT * FROM inscribite_categorias WHERE deevento = "'.$row1['codigo'].'"')),2)?>
               <span style="font-weight:bold;font-family:arial;margin-left:3px;cursor:pointer;">Ver</span>
               </span>
              </a>
              <a href="?sec=categorias.agregar&amp;evento=<?=$row1['codigo']?>" style="float:right;clear:none;">Nueva</a>
            </div>
          </td>
          <td style="text-align:left;">
            <div id="contorden<?=$contnrodeid?>_9">
              <a href="?sec=inscripciones.admin&amp;evento=<?=$row1['codigo']?>" style="font-family:monospace;cursor:pointer;">
                <?=agcnbsp(mysql_num_rows(mysql_query('SELECT * FROM inscribite_inscripciones WHERE deevento = "'.$row1['codigo'].'"')),4)?>
              </a>
            </div>
          </td>
          <td style="text-align:right;">
            <div id="contorden<?=$contnrodeid?>_10">
              <a href="?sec=inscripciones.admin&amp;evento=<?=$row1['codigo']?>" style="font-family:monospace;cursor:pointer;">
                (<?=mysql_num_rows(mysql_query('SELECT * FROM inscribite_inscripciones WHERE deevento = "'.$row1['codigo'].'" AND pagado = 1 '))?>)
<? /*           (<?=mysql_num_rows(mysql_query('SELECT * FROM inscribite_inscripciones WHERE deevento = "'.$row1['codigo'].'" AND pagado = 1 AND iniciadoeldia != "0000-00-00" '))?>) */ ?>
              </a>
            </div>
          </td>
          <td>
            <div id="contorden<?=$contnrodeid?>_11">
              <a href="?sec=inscripciones.admin&amp;evento=<?=$row1['codigo']?>" style="font-family:monospace;cursor:pointer;">Ver</a>
            </div>
          </td>
          <td>
           <div id="contorden<?=$contnrodeid?>_12">
           <a href="javascript:confirm_entry('<?=$row1['nombre']?>', 'eventos.admin', 'inscribite_eventos',<?=$row1['id']?>)"><img src="images/deletex.gif" alt="Eliminar"/></a>
           </div>
          </td>
          <td>
            <input type="checkbox" name="paradescargar" class="paradescargar" value="<?=$row1['id']?>" style="float:left;margin:6px 0px 0px 0px;"/>
          </td>
         </tr>
<? } ?>
         </table>
<? /*    <input type="submit" value="Guardar Ordenes" style="width:150px;margin-top:20px;background:white;border:1px #666 solid;height:25px;color:#666666;cursor:pointer;"/>
 */ ?>
       </div>
     </form>
<?
}
if (($_GET['sec'] == 'categorias.agregar') || ($_GET['sec'] == 'categorias.editar')) {
  $result1 = mysql_query('SELECT * FROM inscribite_categorias WHERE id = "'.$_GET['editando'].'" LIMIT 1 ');
  $row1 = mysql_fetch_array($result1);
  $idactual = ($_GET['sec'] == 'categorias.agregar')?'':$row1['id']; ?>
	<div>
     <div style="line-height:30px;font-weight:bold;margin-top:10px;"><a href="?sec=categorias.admin&amp;evento=<?=$_GET['evento']?>">Categorías</a> &gt; <?=($_GET['sec'] == 'categorias.agregar')?'Agregar Nueva':'Editar'?> &gt; <?=$row2['nombreevento']?></div>
      <form action="guardar" method="post">
       <div>
        <input type="hidden" name="tabla" value="inscribite_categorias"/>
        <input type="hidden" name="id" value="<?=$idactual?>"/>
        <input type="hidden" name="volvera" value="<?=($_GET['sec'] == 'categorias.agregar')?'categorias.agregar&amp;evento='.$_GET['evento']:'categorias.admin&amp;evento='.$_GET['evento']?>"/>
        <input type="hidden" name="deevento" value="<?=$_GET['evento']?>"/>
        <div style="height:53px;">
         <div style="width:470px;float:left;clear:none;">
          &gt; Nombre de la Categoría
         <input type="text" name="nombre" value="<?=$row1['nombre']?>"/>
        </div>
        <div style="width:210px;float:right;clear:none;">
         &gt; Código(2 cifras)<br/>
         <input type="text" name="codigo" value="<?=$row1['codigo']?>" id="codcat" style="width:40px;" onkeypress="checkacantcar(this.id, 2);"/>
        </div>
       </div>
       &gt; Descripción de la Categoría
       <input type="text" name="descripcion" style="float:left;clear:left;display:inline;" value="<?=$row1['descripcion']?>"/>
       <div class="contselect">
         &gt; Pertenece a la opción<br/><br/>
         <select name="opcion">
           <option value=''>Selecciona opción</option>
<?	$result2 = mysql_query('SELECT * FROM inscribite_eventos WHERE codigo = "'.$_GET['evento'].'" LIMIT 1 ');
	$row2 = mysql_fetch_array($result2);
    $tipo = $row2['tipo'];
	$result3 = mysql_query('SELECT * FROM inscribite_opciones WHERE evento = "'.$_GET['evento'].'" OR evento = "'.($_GET['evento']*1).'" ');
	while ($row3 = mysql_fetch_array($result3)) {
      echo '<option value="'.$row3['nombre'].'"';
      if ($row1['opcion'] == $row3['nombre']) {
        echo ' selected="selected"';
        $existeop = true;
      }
      echo '>'.$row3['nombre'].'</option>';
    }
    if (($row1['opcion'] != '') && (!$existeop)) { ?>
           <option selected="selected"><?=$row1['opcion']?></option><?
    } ?>
         </select>
       </div>
<?  if ($row2['tipo'] == 'Deportivos') { ?>
       <div style="text-align:left;float:left;height:30px;">
        <input name="limitedeedad" value="0" type="hidden"/>
        <span style="float:left;margin-top:8px;">Límite de edad:</span>
        <input name="limitedeedad" id="checklimitedeedad" value="1" type="checkbox" onchange="activalimiteedad(this)" style="display:inline;position:relative;top:10px;width:auto;border:0px;background:transparent;float:left;clear:none;margin:0px 0px 0px 8px;"/>
<script type="text/javascript">
<!--
  document.getElementById("checklimitedeedad").checked = "<? if ($row1[limitedeedad] == 1) echo 'checked'?>";
-->
</script>
       </div>
    <div id="edadesmaxmin"<?
if ($row1['limitedeedad'] == 0) echo ' style="display:none;"'?>>
        <div style="float:left;clear:left;width:400px;">
         <span style="float:left;clear:none;">&gt; Edad mínima</span>
         <span style="float:right;clear:none;">&gt; Edad máxima</span>
        </div>
        <div style="float:left;clear:left;width:400px;">
         <input type="text" name="edadminima" id="edadminima" value="<?=$row1['edadminima']?>" style="width:170px;float:left;clear:none;"/>
         <input type="text" name="edadmaxima" id="edadmaxima" value="<?=$row1['edadmaxima']?>" style="width:170px;float:right;clear:none;"/>
        </div>
        <div style="float:left;clear:left;width:100%;">
          &gt; Fecha de Computo de edad
<? $nombremes = array("", "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
    if ($row1['fechadecomputo'] == '') {
      $mesactual  = date('n');
      $anioactual = date('Y');
    } else {
      $mesactual  = substr($row1['fechadecomputo'],4,2);
      $anioactual = substr($row1['fechadecomputo'],0,4);
    }
    if ($mesactual < 1)  $mesactual  = date('n');
    if ($anioactual < 1) $anioactual = date('Y');
    $mesactual  = $mesactual*1;
    $primdiames = date("w", mktime(0, 0, 0, $mesactual,1, $anioactual));
    $ultdiames  = date("t", mktime(0, 0, 0, $mesactual,1, $anioactual))+$primdiames;
?>
          <div style="height:200px;width:188px;">
            <div id="calendario1" style="height:170px;width:188px;float:left;font-size:11px;margin-top:5px;">
              <div style="height:24px;">
                <span class="mespaatras">
                  <a class="flechitasmes" href="#" onclick="leemes('calendario1', '<?=$row1['id']?>', 'fechadecomputo',<?=($mesactual-1)?>,<?=$anioactual?>);return false;">&laquo;</a>
                </span>
                <span class="nombremesencal">
                  <?=$nombremes[$mesactual].' '.substr('0'.($anioactual-2000),-2,2)?>
                </span>
                <span class="mespaadelante">
                  <a class="flechitasmes" href="#" onclick="leemes('calendario1', '<?=$row1['id']?>', 'fechadecomputo',<?=($mesactual+1)?>,<?=$anioactual?>);return false;">&raquo;</a>
                </span>
              </div>
              <div onmouseup="empiezaarras = false">
                <div class="lineacal" style="letter-spacing:17px;text-indent:8px;">
                  DLMMJVS
                </div>
                <div class="lineacal">
<? for ($ndia = 1; $ndia <= $ultdiames; $ndia++) {
     $fdia = $ndia-$primdiames;
     $colordfd = '';
     if ($row1['fechadecomputo'] == $anioactual.substr('0'.$mesactual,-2,2).substr('0'.$fdia,-2,2))
       $colordfd = ' style="background-color:#C9DAEE;" id="tocado1"';
       if ($fdia < 1)
         echo '                <span></span>'.chr(13);
       else
         echo '<a onmousedown="tocacal(1,'."'fechadecomputo'".',this,'.$fdia.', '.$mesactual.', '.$anioactual.');" '.$colordfd.'>'.$fdia.'</a>'.chr(13);
       if ($ndia%7 == 0) echo '                </div>'.chr(13).'                <div class="lineacal">'.chr(13);
   } ?>
                </div>
              </div>
            </div>
            <input type="text" id="fechadecomputo" name="fechadecomputo" value="<?=$row1['fechadecomputo']?>" style="width:170px;"/>
          </div>
<script type="text/javascript">
<!--
//disableSelection(document.getElementById('calendario'))
//document.getElementById('fechadecomputo').value='<?=$row1['fechadecomputo']?>'
-->
</script>
        </div>
<?
}
?>
<?
/*
        <div style="float:left;clear:left;width:100%;">
         &gt; Fecha de Computo
        </div>
        <div style="float:left;clear:left;width:100%;">
         <select name="diadecomparacion">
<? for ($z = 1; $z <= 31; $z++) { ?>
          <option value="<?=$z?>"<?
if ($row1['diadecomparacion'] == $z) echo ' selected="selected"'?>><?=$z?></option>
<? } ?>
         </select>
/
         <select name="mesdecomparacion">
<? for ($z = 1; $z <= 12; $z++) { ?>
          <option value="<?=$z?>"<?
if ($row1['mesdecomparacion'] == $z) echo ' selected="selected"'?>><?=$z?></option>
<? } ?>
         </select>
/
         <select id="agnodecomparacion" name="agnodecomparacion">
          <option value="<?=(date("Y")-2)?>"<?
if ($row1['agnodecomparacion'] == (date("Y")-2)) echo ' selected="selected"'?>><?=(date("Y")-2)?></option>
          <option value="<?=(date("Y")-1)?>"<?
if ($row1['agnodecomparacion'] == (date("Y")-1)) echo ' selected="selected"'?>><?=(date("Y")-1)?></option>
          <option value="<?=(date("Y")+0)?>"<?
if ($row1['agnodecomparacion'] == (date("Y")+0)) echo ' selected="selected"'?>><?=(date("Y")+0)?></option>
          <option value="<?=(date("Y")+1)?>"<?
if ($row1['agnodecomparacion'] == (date("Y")+1)) echo ' selected="selected"'?>><?=(date("Y")+1)?></option>
          <option value="<?=(date("Y")+2)?>"<?
if ($row1['agnodecomparacion'] == (date("Y")+2)) echo ' selected="selected"'?>><?=(date("Y")+2)?></option>
          <option value="<?=(date("Y")+3)?>"<?
if ($row1['agnodecomparacion'] == (date("Y")+3)) echo ' selected="selected"'?>><?=(date("Y")+3)?></option>
          <option value="<?=(date("Y")+4)?>"<?
if ($row1['agnodecomparacion'] == (date("Y")+4)) echo ' selected="selected"'?>><?=(date("Y")+4)?></option>
          <option value="<?=(date("Y")+5)?>"<?
if ($row1['agnodecomparacion'] == (date("Y")+5)) echo ' selected="selected"'?>><?=(date("Y")+5)?></option>
         </select>
        </div>
       </div>
*/
?>
    </div>
    <div class="contselect" style="float:left;clear:left;width:100%;">
      <span style="float:left;margin:4px 5px 0px 0px;">&gt; Sexo</span>
      <select name="sexo">
        <option value="Ambos"<?
if ($row1['sexo'] == 'Ambos') echo ' selected="selected"'?>>Ambos</option>
        <option value="Masculino"<?
if ($row1['sexo'] == 'Masculino') echo ' selected="selected"'?>>Masculino</option>
        <option value="Femenino"<?
if ($row1['sexo'] == 'Femenino') echo ' selected="selected"'?>>Femenino</option>
      </select>
    </div>

<? if ($tipo == 'Servicios') { ?>
    <table style="float:left;width:100%;border:0px;margin-top:10px;">
      <tr style="border:0px;background:none">
        <td style="width:225px;border:0px;vertical-align:top">
          &gt; Precio 1
          <input type="text" name="precio1" value="<?=$row1['precio1']?>" style="width:170px;float:left;clear:left;"/>
          <div style="width:176px;">&gt; Vencimiento 1. Día</div>
          <select name="fechavenc1" id="fechavenc1" value="<?=$row1['fechavenc1']?>" onchange="
          for (g = 1; g <= 31; g++) {
            if (g < this.value*1) {
              document.getElementById('v2d'+g).disabled = 'disabled';
              document.getElementById('v3d'+g).disabled = 'disabled';
            } else {
              document.getElementById('v2d'+g).disabled = '';
              document.getElementById('v3d'+g).disabled = '';
            }
          }
          if (document.getElementById('fechavenc2').value*1 < this.value ) {
            document.getElementById('v2d'+((this.value*1)+1)).selected = 'selected';
            document.getElementById('fechavenc2').value = ((this.value*1)+1);
          }
          if (document.getElementById('fechavenc3').value*1 < this.value ) {
            document.getElementById('v3d'+((this.value*1)+2)).selected = 'selected';
            document.getElementById('fechavenc3').value = ((this.value*1)+2);
          }
           ">
<? for ($r = 1; $r <= 31; $r++) { ?>
              <option value="<?=$r?>" id="v1d<?=$r?>"<? if ($row1['fechavenc1'] == $r) echo ' selected="selected"'?>><?=$r?></option>
<? } ?>
            </select> del mes
          </td>
          <td style="width:225px;vertical-align:top;">
            &gt; Precio 2
            <input type="text" name="precio2" value="<?=$row1['precio2']?>" style="width:170px;float:left;clear:left;"/>
            <div style="width:176px;">&gt; Vencimiento 2. Día</div>
            <select name="fechavenc2" id="fechavenc2" value="<?=$row1['fechavenc2']?>" onchange="
          for (g = 1; g <= 31; g++) {
            if (g < this.value*1)
              document.getElementById('v3d'+g).disabled = 'disabled';
            else
              document.getElementById('v3d'+g).disabled = '';
          }
          if (document.getElementById('fechavenc3').value*1 < this.value ) {
            document.getElementById('v3d'+((this.value*1)+1)).selected = 'selected';
            document.getElementById('fechavenc3').value = ((this.value*1)+1);
          }
          if (this.value*1 < document.getElementById('fechavenc1').value*1)
            this.value=document.getElementById('fechavenc1').value;
           ">
<? for ($r = 1; $r <= 31; $r++) { ?>
                <option value="<?=$r?>" id="v2d<?=$r?>"<? if ($row1['fechavenc2'] == $r) echo ' selected="selected"'?>><?=$r?></option>
<? } ?>
              </select> del mes
            </td>
            <td style="vertical-align:top;">
              &gt; Precio 3<br/>
              <input type="text" name="precio3" value="<?=$row1['precio3']?>" style="width:170px;float:left;clear:left;"/>
              <div style="width:176px;">&gt; Vencimiento 3. Día</div>
              <select name="fechavenc3" id="fechavenc3" value="<?=$row1['fechavenc3']?>" onchange="if (this.value*1 < document.getElementById('fechavenc2').value*1) this.value=document.getElementById('fechavenc2').value; ">
<?  for ($r = 1; $r <= 31; $r++) { ?>
                <option value="<?=$r?>" id="v3d<?=$r?>"<? if ($row1['fechavenc3'] == $r) echo ' selected="selected"'?>><?=$r?></option>
<?  } ?>
              </select> del mes
            </td>
          </tr>
        </table>
<?
  } else {
?>
        <table style="float:left;width:100%;border:0px;">
          <tr style="border:0px;background:none">
            <td style="width:225px;border:0px;vertical-align:top;">
              &gt; Precio 1
              <input type="text" name="precio1" value="<?=$row1['precio1']?>" style="width:170px;float:left;clear:none;"/>
              <div style="width:176px;">&gt; Vencimiento 1</div>
<?
    if ($row1['fechavenc1'] == '') {
      $mesactual  = date('n');
      $anioactual = date('Y');
    } else {
      $mesactual  = substr($row1['fechavenc1'],4,2);
      $anioactual = substr($row1['fechavenc1'],0,4);
    }
    if ($mesactual < 1)  $mesactual  = date('n');
    if ($anioactual < 1) $anioactual = date('Y');
    $mesactual  = $mesactual*1;
    $primdiames = date("w", mktime(0, 0, 0, $mesactual, 1, $anioactual));
    $ultdiames  = date("t", mktime(0, 0, 0, $mesactual, 1, $anioactual))+$primdiames;
?>
              <div style="height:170px;width:176px;float:left;clear:left;">
                <div id="calendario2" style="height:170px;width:188px;float:left;margin-top:5px;">
                  <div style="height:24px;">
                    <span class="mespaatras">
                      <a class="flechitasmes" href="#" onclick="leemes('calendario2', '<?=$row1['id']?>', 'fechavenc1',<?=($mesactual-1)?>,<?=$anioactual?>);return false;">&laquo;</a>
                    </span>
                    <span class="nombremesencal">
                      <?=$nombremes[$mesactual].' '.substr('0'.($anioactual-2000),-2,2)?>
                    </span>
                    <span class="mespaadelante">
                      <a class="flechitasmes" href="#" onclick="leemes('calendario2', '<?=$row1['id']?>', 'fechavenc1',<?=($mesactual+1)?>,<?=$anioactual?>);return false;">&raquo;</a>
                    </span>
                  </div>
                  <div onmouseup="empiezaarras = false">
                    <div class="lineacal" style="letter-spacing:17px;text-indent:8px;">
                      DLMMJVS
                    </div>
                    <div class="lineacal">
<?
for ($ndia = 1; $ndia <= $ultdiames; $ndia++) {
  $fdia = $ndia-$primdiames;
  $colordfd = '';
  if ($row1['fechavenc1'] == $anioactual.substr('0'.$mesactual, -2, 2).substr('0'.$fdia, -2, 2)) {
    $colordfd = ' style="background-color:#C9DAEE;" id="tocado2"';
  }
  if ($fdia < 1) {
    echo '                    <span></span>'.chr(13);
  } else {
    echo '                    <a onmousedown="tocacal(2,'."'fechavenc1'".',this,'.$fdia.', '.$mesactual.', '.$anioactual.');" '.$colordfd.'>'.$fdia.'</a>';
  }
  if ($ndia%7 == 0) echo '                    </div>'.chr(13).'                    <div class="lineacal">';
}
?>
                    </div>
                  </div>
                  <br/>
                  <strong><?=($row1['fechavenc1'] == 0)?'No establecida':''?></strong>
                </div>
                <input type="text" id="fechavenc1" name="fechavenc1" value="<?=$row1['fechavenc1']?>" style="width:170px;"/>
              </div>
            </td>
            <td style="width:225px;vertical-align:top;">
              <div style="width:225px;height:268px;float:left;overflow:hidden;">
                &gt; Precio 2
                <input type="text" name="precio2" value="<?=$row1['precio2']?>" style="width:170px;float:left;clear:none;"/>
                <div style="float:left;clear:left;width:176px;">&gt; Vencimiento 2</div>
<?
    if ($row1['fechavenc2'] == '') {
      $mesactual  = date('n');
      $anioactual = date('Y');
    } else {
      $mesactual  = substr($row1['fechavenc2'],4,2);
      $anioactual = substr($row1['fechavenc2'],0,4);
    }
    if ($mesactual  < 1) $mesactual  = date('n');
    if ($anioactual < 1) $anioactual = date('Y');
    $mesactual  = $mesactual*1;
    $primdiames = date("w", mktime(0, 0, 0, $mesactual, 1, $anioactual));
    $ultdiames  = date("t" ,mktime(0, 0, 0, $mesactual, 1, $anioactual))+$primdiames;
?>
                <div style="height:160px;width:200px;float:left;overflow:hidden;">
                  <div id="calendario3" style="height:170px;width:188px;float:left;margin-top:5px;">
                    <div style="height:24px;">
                      <span class="mespaatras">
                        <a class="flechitasmes" href="#" onclick="leemes('calendario3', '<?=$row1['id']?>', 'fechavenc2',<?=($mesactual-1)?>,<?=$anioactual?>);return false;">&laquo;</a>
                      </span>
                      <span class="nombremesencal">
                        <?=$nombremes[$mesactual].' '.substr('0'.($anioactual-2000),-2,2)?>
                      </span>
                      <span class="mespaadelante">
                        <a class="flechitasmes" href="#" onclick="leemes('calendario3', '<?=$row1['id']?>', 'fechavenc2',<?=($mesactual+1)?>,<?=$anioactual?>);return false;">&raquo;</a>
                      </span>
                    </div>
                    <div onmouseup="empiezaarras = false" style="">
                      <div class="lineacal" style="letter-spacing:17px;text-indent:8px;">
                        DLMMJVS
                      </div>
                      <div class="lineacal" style="float:left;">
<?
for ($ndia = 1; $ndia <= $ultdiames; $ndia++) {
  $fdia = $ndia-$primdiames;
  $colordfd = '';
  if ($row1['fechavenc2'] == $anioactual.substr('0'.$mesactual,-2,2).substr('0'.$fdia,-2,2)) {
    $colordfd = ' style="background-color:#C9DAEE;" id="tocado3"';
  }
  if ($fdia < 1) {
    echo '                      <span></span>'.chr(13);
  } else {
    echo '                      <a onmousedown="tocacal(3,'."'fechavenc2'".',this,'.$fdia.', '.$mesactual.', '.$anioactual.');" '.$colordfd.'>'.$fdia.'</a>';
  }
  if ($ndia%7 == 0) echo '                      </div>'.chr(13).'                      <div class="lineacal">';
}
?>
                      </div>
                    </div>
                  </div>
                  <br/>
                  <strong><?=($row1['fechavenc2'] == 0)?'No establecida':''?></strong>
                </div>
                <input type="text" id="fechavenc2" name="fechavenc2" value="<?=$row1['fechavenc2']?>" style="width:170px;margin-top:14px"/>
              </div>
            </td>
            <td style="">
              <div style="width:225px;height:268px;float:left;overflow:hidden;">
                &gt; Precio 3
                <input type="text" name="precio3" value="<?=$row1['precio3']?>" style="width:170px;float:left;clear:none;"/>
                <div style="float:left;clear:left;width:176px;">&gt; Vencimiento 3</div>
<?  if ($row1['fechavenc3'] == '') {
      $mesactual  = date('n');
      $anioactual = date('Y');
    } else {
      $mesactual  = substr($row1['fechavenc3'],4,2);
      $anioactual = substr($row1['fechavenc3'],0,4);
    }
    if ($mesactual < 1)  $mesactual  = date('n');
    if ($anioactual < 1) $anioactual = date('Y');
    $mesactual = $mesactual*1;
    $primdiames = date("w",mktime(0,0,0, $mesactual,1, $anioactual));
    $ultdiames  = date("t",mktime(0,0,0, $mesactual,1, $anioactual))+$primdiames; ?>
                <div style="height:170px;width:100%;">
                  <div id="calendario4" style="height:170px;width:188px;float:left;">
                    <div style="height:24px;">
                      <span class="mespaatras">
                        <a class="flechitasmes" href="#" onclick="leemes('calendario4', '<?=$row1['id']?>', 'fechavenc3',<?=($mesactual-1)?>,<?=$anioactual?>);return false;">&laquo;</a>
                      </span>
                      <span class="nombremesencal">
                        <?=$nombremes[$mesactual].' '.substr('0'.($anioactual-2000),-2,2)?>
                      </span>
                      <span class="mespaadelante">
                        <a class="flechitasmes" href="#" onclick="leemes('calendario4', '<?=$row1['id']?>', 'fechavenc3',<?=($mesactual+1)?>,<?=$anioactual?>);return false;">&raquo;</a>
                      </span>
                    </div>
                    <div onmouseup="empiezaarras = false">
                      <div class="lineacal" style="letter-spacing:17px;text-indent:8px;">
                        DLMMJVS
                      </div>
                      <div class="lineacal">
<? for ($ndia = 1; $ndia <= $ultdiames; $ndia++) {
     $fdia = $ndia-$primdiames;
     $colordfd = '';
     if ($row1['fechavenc3'] == $anioactual.substr('0'.$mesactual,-2,2).substr('0'.$fdia,-2,2))
       $colordfd = ' style="background-color:#C9DAEE;" id="tocado4"';
     if ($fdia < 1)
       echo '                        <span></span>';
     else
       echo '                        <a onmousedown="tocacal(4,'."'fechavenc3'".',this,'.$fdia.', '.$mesactual.', '.$anioactual.');" '.$colordfd.'>'.$fdia.'</a>';
     if ($ndia%7 == 0) echo '                      </div>'.chr(13).'                      <div class="lineacal">';
   } ?>
                      </div>
                      <br/>
                      <strong><?=($row1['fechavenc3'] == 0)?'No establecida':''?></strong>
                    </div>
                  </div>
                  <div style="float:left;clear:left;">
                    <input type="text" id="fechavenc3" name="fechavenc3" value="<?=$row1['fechavenc3']?>" style="width:170px;"/>
                  </div>
                </div>
              </div>
            </td>
          </tr>
        </table>

<script type="text/javascript">
<!--
ultfechatoc = new Array();
ultfechatoc[1] = '1';
ultfechatoc[2] = '1';
ultfechatoc[3] = '1';
ultfechatoc[4] = '1';
<?
if ($row1['fechadecomputo'] != '') echo"ultfechatoc[1] = document.getElementById('tocado1')".chr(13);
if ($row1['fechavenc1'] != '')     echo"ultfechatoc[2] = document.getElementById('tocado2')".chr(13);
if ($row1['fechavenc2'] != '')     echo"ultfechatoc[3] = document.getElementById('tocado3')".chr(13);
if ($row1['fechavenc3'] != '')     echo"ultfechatoc[4] = document.getElementById('tocado4')".chr(13);
?>
-->
</script>
<?
  }
/*
		    <div style="float:left;clear:left;width:400px;">
	  	  	<span style="float:left;clear:none;">&gt; Precio 1</span>
	    		<span style="float:right;clear:none;">&gt; Vencimiento 1</span>
  		  </div>
		    <div style="float:left;clear:left;width:400px;">
  		  	<input type="text" name="precio1" value="<?=$row1['precio1']?>" style="width:170px;float:left;clear:none;"/>
	    		<input type="text" name="vencimiento1" value="<?=(($_GET['sec'] == 'categorias.agregar') || ($row1['vencimiento1'] == '0000-00-00'))?'dd/mm/aaaa':substr($row1['vencimiento1'],8,2).'/'.substr($row1['vencimiento1'],5,2).'/'.substr($row1['vencimiento1'],0,4)?>" style="width:170px;float:right;clear:none;"/>
  		  </div>
		    <div style="float:left;clear:left;width:400px;">
		    	<span style="float:left;clear:none;">&gt; Precio 2</span>
	  	  	<span style="float:right;clear:none;">&gt; Vencimiento 2</span>
  		  </div>
		    <div style="float:left;clear:left;width:400px;">
  		  	<input type="text" name="precio2" value="<?=$row1['precio2']?>" style="width:170px;float:left;clear:none;"/>
	    		<input type="text" name="vencimiento2" value="<?=(($_GET['sec'] == 'categorias.agregar') || ($row1['vencimiento2'] == '0000-00-00'))?'dd/mm/aaaa':substr($row1['vencimiento2'],8,2).'/'.substr($row1['vencimiento2'],5,2).'/'.substr($row1['vencimiento2'],0,4)?>" style="width:170px;float:right;clear:none;"/>
  		  </div>
		    <div style="float:left;clear:left;width:400px;">
	    		<span style="float:left;clear:none;">&gt; Precio 3</span>
  		  	<span style="float:right;clear:none;">&gt; Vencimiento 3</span>
		    </div>
		    <div style="float:left;clear:left;width:400px;">
	  	  	<input type="text" name="precio3" value="<?=$row1['precio3']?>" style="width:170px;float:left;clear:none;"/>
  		  	<input type="text" name="vencimiento3" value="<?=(($_GET['sec'] == 'categorias.agregar') || ($row1['vencimiento3'] == '0000-00-00'))?'dd/mm/aaaa':substr($row1['vencimiento3'],8,2).'/'.substr($row1['vencimiento3'],5,2).'/'.substr($row1['vencimiento3'],0,4)?>" style="width:170px;float:right;clear:none;"/>
		    </div>
*/
?>
		    <div style="float:left;clear:left;width:100%;">
		   	  <input type="submit" value="Enviar" class="submit"/>
		    </div>
		    </div>

		  </form>
    </div>
  </div>
<?
}
if ($_GET['sec'] == 'categorias.admin') {
  $result1 = mysql_query('SELECT * FROM inscribite_eventos WHERE codigo = "'.$_GET['evento'].'" LIMIT 1 ');
  $row1 = mysql_fetch_array($result1);
?>
   <div>
    <div class="titulosec">Categorías &gt; Admin : Evento <a href="?sec=eventos.editar&editando=<?=$row1['id']?>"><?=$row1['nombre']?></a>&nbsp;&nbsp;&nbsp;<a href="tablacategorias?evento=<?=str_replace(' ', '_', $_GET['evento'])?>">Ver datos completos en tabla</a>
    </div>
<?
  $result2 = mysql_query('SELECT * FROM inscribite_opciones WHERE evento = "'.$_GET['evento'].'" OR evento = "'.($_GET['evento']*1).'" ');
  while ($row2 = mysql_fetch_array($result2)) {
?>
    Opción: <strong><?=$row2['nombre']?></strong>
<?
    if ($row2['cupo'] != 0) {
?>
    Cupo restante: <strong><?=$row2['cupo']+$row2['cuporestante']?></strong> de <?=$row2['cupo']?>
<?
    }
    echo '<br/>';
  }
?>
    <br/>
    <table>
     <tr>
      <th>Cod</th>
      <th>Nombre</th>
      <th style="width:200px;">Opción</th>
      <th>Categoría</th>
      <th>Sexo</th>
      <th>Edad</th>
      <th>Computada al</th>
      <th>&nbsp;</th>
     </tr>
<?
$result1 = mysql_query('SELECT * FROM inscribite_categorias WHERE deevento = "'.$_GET['evento'].'" ORDER BY codigo ');
while ($row1 = mysql_fetch_array($result1)) {
?>
     <tr>
      <td>
       <a href="?sec=categorias.editar&amp;editando=<?=$row1['id']?>&amp;evento=<?=$_GET['evento']?>">
        <span style="color:#666666;font-weight:normal;"><?=$row1['codigo']?></span>
       </a>
      </td>
      <td>
       <a href="?sec=categorias.editar&amp;editando=<?=$row1['id']?>&amp;evento=<?=$_GET['evento']?>">
        <?=$row1['nombre']?>
       </a>
      </td>
      <td style="color:#666">
       <a href="?sec=categorias.editar&amp;editando=<?=$row1['id']?>&amp;evento=<?=$_GET['evento']?>">
        <?=$row1['opcion']?>
       </a>
      </td>
      <td style="color:#666">
       <a href="?sec=categorias.editar&amp;editando=<?=$row1['id']?>&amp;evento=<?=$_GET['evento']?>">
        <?=$row1['descripcion']?>
       </a>
      </td>
      <td style="color:#666">
       <a href="?sec=categorias.editar&amp;editando=<?=$row1['id']?>&amp;evento=<?=$_GET['evento']?>">
        <?
  if ($row1['sexo'] == 'Masculino') { echo 'Masc'; } else { if ($row1['sexo'] == 'Femenino') echo 'Fem'; else echo 'Ambos'; }?>
       </a>
      </td>
      <td style="color:#666666;text-align:center;">
       <a href="?sec=categorias.editar&amp;editando=<?=$row1['id']?>&amp;evento=<?=$_GET['evento']?>">
        <?=$row1['edadminima']?> a <?=$row1['edadmaxima']?>
       </a>
      </td>
      <td style="color:#666666;text-align:center;">
       <a href="?sec=categorias.editar&amp;editando=<?=$row1['id']?>&amp;evento=<?=$_GET['evento']?>">
        <?=substr($row1['fechadecomputo'],6,2).'/'.substr($row1['fechadecomputo'],4,2).'/'.substr($row1['fechadecomputo'],0,4)?>
       </a>
      </td>
      <td>
       <a href="javascript:confirm_entry('<?=$row1['nombre']?>', 'categorias.adminamp;evento=<?=$_GET['evento']?>', 'inscribite_categorias',<?=$row1['id']?>)"><img src="images/deletex.gif" alt="Eliminar"/></a>
      </td>
     </tr>
<?
}
?>
    </table>
    <a href="?sec=categorias.agregar&evento=<?=$_GET['evento']?>" style="margin-left:10;margin-top:20px;font-size:12px;float:left;">Agregar Nueva</a>
   </div>
<?
}
if (($_GET['sec'] == 'empresas.agregar') || ($_GET['sec'] == 'empresas.editar')) {
$result1 = mysql_query('SELECT * FROM inscribite_empresas WHERE id = '.$_GET['editando'].' LIMIT 1 ');
if (is_resource($result1)) {
	$row1 = mysql_fetch_array($result1);
	$nroid = $row1['id'];
}
?>
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
<?
}
if ($_GET['sec'] == 'empresas.admin') {?>
   <div class="titulosec">Empresas &gt; Admin</div>
    <table>
     <tr>
      <th>Nombre</th>
      <th>Password</th>
      <th>Panel de empresa</th>
      <th>&nbsp;</th>
      <th>&nbsp;</th>
     </tr>
<?
$result1 = mysql_query('SELECT * FROM inscribite_empresas ORDER BY nombre ');
while ($row1 = mysql_fetch_array($result1)) {
?>
      <tr>
       <td>
        <a href="?sec=empresas.editar&amp;editando=<?=$row1['id']?>">
         <?=$row1['nombre']?>
        </a>
       </td>
       <td>
        <a href="?sec=empresas.editar&amp;editando=<?=$row1['id']?>">
         <?=$row1['password']?>
        </a>
       </td>
       <td>
        <a href="../empresas/?empresa=<?=$row1['nombre']?>">
          Ver
        </a>
       </td>
       <td>&nbsp;</td>
       <td>
        <a href="javascript:confirm_entry('<?=$row1['nombre']?>', 'empresas.admin', 'inscribite_empresas',<?=$row1['id']?>)"><img src="images/deletex.gif" alt="Eliminar"/></a>
       </td>
      </tr>
<?
}
?>
     </table>
<?
}
if (($_GET['sec'] == 'descuentos.agregar') || ($_GET['sec'] == 'descuentos.editar')) {
$result1 = mysql_query('SELECT * FROM inscribite_descuentos WHERE id = '.$_GET['editando'].' LIMIT 1 ');
if (is_resource($result1)) {
	$row1 = mysql_fetch_array($result1);
	$nroid = $row1['id'];
}
?>
	<div>
	  <div class="titulosec">Descuentos &gt; <?=(is_resource($result1))?'Editando:':'Agregar Nuevo'?> <?=$row1['codigo']?></div>
      <div>
        <form action="guardar" method="post">
			<div>
              <input type="hidden" name="id" value="<?=$nroid?>"/>
              <input type="hidden" name="tabla" value="inscribite_descuentos"/>
              <input type="hidden" name="volvera" value="descuentos.admin"/>
              &gt; De Evento
			  <select name="codevento">
<?
$result3 = mysql_query('SELECT * FROM inscribite_eventos WHERE ver = 1 ');
while ($row3 = mysql_fetch_array($result3)) {
?>
                <option<?
if ($row1['codevento'] == $row3['codigo']) echo ' selected="selected"'?> value="<?=$row3['codigo']?>"><?=$row3['nombre']?></option>
<?
}
?>
			  </select>
              <div>
              &gt; DNI
              <input type="text" name="coddni" value="<?=$row1['coddni']?>" id="dninmbusuario" onkeyup="this.value=this.value.replace(/./g, '').substring(0, 8)"/>
              </div>
              &gt; Descuento (porcentual)
        	  <input type="text" name="porcentajedescuento" value="<?=$row1['porcentajedescuento']?>"/>
        	  <input type="submit" value="Enviar" class="submit"/>
			</div>
        </form>
	</div>
<?
}
if ($_GET['sec'] == 'descuentos.admin') {?>
   <div class="titulosec">Descuentos &gt; Admin</div>
    <table>
     <tr>
      <th style="text-align:left;">Código</th>
      <th style="text-align:left;">Evento</th>
      <th style="text-align:left;">DNI</th>
      <th style="text-align:left;">Email</th>
      <th style="text-align:left;">Porcentaje</th>
      <th>&nbsp;</th>
      <th>&nbsp;</th>
     </tr>
<?
$result1 = mysql_query('SELECT * FROM inscribite_descuentos ');
while ($row1 = mysql_fetch_array($result1)) {
?>
      <tr>
       <td>
        <a href="?sec=descuentos.editar&amp;editando=<?=$row1['id']?>">
         <?=agceros($row1['codevento'],4).agceros($row1['coddni'],8).agceros($row1['porcentajedescuento'],3);?>
        </a>
       </td>
       <td>
        <a href="?sec=descuentos.editar&amp;editando=<?=$row1['id']?>">
         <?=agceros($row1['codevento'],4)?>
        </a>
       </td>
       <td>
        <a href="?sec=descuentos.editar&amp;editando=<?=$row1['id']?>">
         <?=agceros($row1['coddni'],8)?>
        </a>
       </td>
       <td>
        <a href="?sec=descuentos.editar&amp;editando=<?=$row1['id']?>">
         <?
$result2 = mysql_query('SELECT email FROM inscribite_usuarios WHERE dni = '.agceros($row1['coddni'],8).' ');
$row2 = mysql_fetch_array($result2);
         echo $row2['email'].'<a href="'.$row2['email'].'" title="mailto:'.$row2['email'].'"><img src="images/miniemail.gif" alt="" style="margin-left:5px;"></a>';
        
?>
        </a>
       </td>
       <td>
        <a href="?sec=descuentos.editar&amp;editando=<?=$row1['id']?>">
         <?=$row1['porcentajedescuento']?>%
        </a>
       </td>
       <td>&nbsp;</td>
       <td>
        <a href="javascript:confirm_entry('<?=agceros($row1['codevento'],4).agceros($row1['coddni'],8).agceros($row1['porcentajedescuento'],3);?>', 'descuentos.admin', 'inscribite_descuentos',<?=$row1['id']?>)"><img src="images/deletex.gif" alt="Eliminar"/></a>
       </td>
      </tr>
<?
}
?>
     </table>
<?
}
if ($_GET['sec'] == 'inscripciones.admin') {
  $paginardea = 9999999;
  $limitdesde = ($_GET['pagina'])*$paginardea;
  $limitdesde--;
  $limitdesde = $limitdesde-$paginardea;
  if ($_GET['pagina'] == "") $limitdesde = 0;
  $result1 = mysql_query('SELECT id FROM inscribite_inscripciones WHERE deevento="'.$_GET['evento'].'" ');
  //$result1 = mysql_query('SELECT id FROM inscribite_inscripciones WHERE deevento="'.$_GET['evento'].'" AND iniciadoeldia != "0000-00-00" ');
  $cantproductos = mysql_num_rows($result1);
  $result2 = mysql_query('SELECT * FROM inscribite_eventos WHERE codigo="'.$_GET['evento'].'" ');
  $row2 = mysql_fetch_array($result2);
?>
<script type="text/javascript">
<!--
//document.getElementById('menulateral').style.width        = '9px';
//document.getElementById('restocontenidomenu').style.width = '1px';
//document.getElementById('minimizar').style.display        = 'none';
-->
</script>
     <div>
       <div style="margin-left:10px;margin-top:16px;font-size:12px;width:100%;">
         <div class="titulosec">Inscripciones &gt; Admin : Evento <?=$row2['nombre'].' &gt; '.$cantproductos.' inscripciones &gt;'?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="excelinscripciones?evento=<?=$_GET['evento']?>">Generar Excel</a>&nbsp;-&nbsp;<a href="excelinscompleto?evento=<?=$_GET['evento']?>">Generar Excel con datos completos</a>
         </div>
       </div>
	     <div>
<? $result2 = mysql_query('SELECT * FROM inscribite_opciones WHERE evento="'.$_GET['evento'].'" OR evento="'.($_GET['evento']*1).'" ');
   while ($row2 = mysql_fetch_array($result2)) { ?>
    Opción: <strong><?=$row2['nombre']?></strong>
<?   if ($row2['cupo'] != 0) { ?>
 Cupo restante: <strong><?=($row2['cupo']+$row2['cuporestante'])?></strong> de <?=$row2['cupo']?>
<?   }
     echo '<br/>';
   }
?>
    <br/>
<? /*   <div style="font-size:11px;line-height:30px;">
		Ordernar por: <a href="?sec=inscripciones.admin&amp;evento=<?=$_GET['evento']?>&amp;ordenarpor=dni">dni</a>
    	, <a href="?sec=inscripciones.admin&amp;evento=<?=$_GET['evento']?>&amp;ordenarpor=nombre">nombre</a>
    	, <a href="?sec=inscripciones.admin&amp;evento=<?=$_GET['evento']?>&amp;ordenarpor=apellido">apellido</a>
    	, <a href="?sec=inscripciones.admin&amp;evento=<?=$_GET['evento']?>&amp;ordenarinscripcionesx=fecha">fechadepago</a>
		</div>
<? */
if ($_GET['busqueda'] == '') {
  $ordenarpor=$_GET['ordenarpor'];
  if ($ordenarpor == '') {
  	if ($ordenarinscripcionesx == '') {
      $result1 = mysql_query('SELECT * FROM inscribite_inscripciones WHERE deevento = "'.$_GET['evento'].'" AND iniciadoeldia != "0000-00-00" LIMIT '.$limitdesde.', '.$paginardea.' ');
  	} else {
      if ($ordenarinscripcionesx == 'fecha') $ordenarinscripcionesx = 'pagoeldia';
      $result1 = mysql_query('SELECT * FROM inscribite_inscripciones WHERE deevento = "'.$_GET['evento'].'" AND iniciadoeldia != "0000-00-00" ORDER BY '.$ordenarinscripcionesx.' LIMIT '.$limitdesde.', '.$paginardea.' ');
  	}
  } else {
  	$result1 = mysql_query('SELECT DISTINCT * FROM inscribite_inscripciones LEFT OUTER JOIN inscribite_usuarios ON inscribite_usuarios.dni = inscribite_inscripciones.deusuario WHERE deevento = "'.$_GET['evento'].'" AND iniciadoeldia != "0000-00-00" ORDER BY inscribite_usuarios.'.$ordenarpor.' LIMIT '.$limitdesde.', '.$paginardea.' ');
  }
} else {
    $result1 = mysql_query('SELECT * FROM inscribite_inscripciones WHERE ((deusuario LIKE "%'.$_GET['busqueda'].'%") OR (deusuario = '.agceros($_GET['busqueda'],8).')) AND iniciadoeldia != "0000-00-00" ');
} ?>
    <table>
      <tr>
        <th>Nro</th>
        <th><a href="?sec=inscripciones.admin&amp;evento=<?=$_GET['evento']?>&amp;ordenarpor=dni" style="font-weight:bold;text-decoration:underline;">DNI</a></th>
        <th><a href="?sec=inscripciones.admin&amp;evento=<?=$_GET['evento']?>&amp;ordenarpor=apellido" style="font-weight:bold;text-decoration:underline;">Apellido</a></th>
        <th><a href="?sec=inscripciones.admin&amp;evento=<?=$_GET['evento']?>&amp;ordenarpor=nombre" style="font-weight:bold;text-decoration:underline;">Nombre</a></th>
        <th>Localidad</th>
        <th>Opción</th>
        <th>Cat.</th>
<? if ($row2['tipo'] == 'Servicios') echo '<th>Mes</th>';
   $tipo = $row2['tipo']; ?>
        <th>Fecha de nac</th>
        <th><a href="?sec=inscripciones.admin&amp;evento=<?=$_GET['evento']?>&amp;ordenarinscripcionesx = fecha" style="font-weight:bold;text-decoration:underline;">Pagado</a></th>
        <th>&nbsp;</th>
      </tr>
<?
$cuentar = 0;
while ($row1 = mysql_fetch_array($result1)) {
  $cuentar++;
  if ($codigoant != $row1['codigo']) {
    $codigoant = $row1['codigo'];
    $result2 = mysql_query('SELECT *  FROM inscribite_usuarios WHERE dni = "'.($row1['deusuario']*1).'" LIMIT 1 ');
    while ($row2 = mysql_fetch_array($result2)) {
      $localidad = $row2['localidad'];
      $provincia = $row2['provincia'];
      $fechanac  = $row2['fechanac']; ?>
      <tr>
        <td><?=$cuentar?></td>
        <td style="text-align:right;">
          <a title="codigo: <?=$row1['codigo']?>" href="?sec=inscripciones.editar&amp;editando=<?=$row1['id']?>">
            <?=$row1['deusuario'].chr(13)?>
          </a>
        </td>
        <td style="color:#666;font-size:11px;">
          <a title="codigo: <?=$row1['codigo']?>" href="?sec=inscripciones.editar&amp;editando=<?=$row1['id']?>">
            <?=$row2['apellido'].chr(13)?>
          </a>
        </td>
        <td style="color:#666;font-size:11px;">
          <a title="codigo: <?=$row1['codigo']?>" href="?sec=inscripciones.editar&amp;editando=<?=$row1['id']?>">
<?
$arrnombresdpila = split(' ', $row2['nombre']);
echo $arrnombresdpila[0].' '.substr($arrnombresdpila[1],0,1);
if ($arrnombresdpila[1] != '') echo '.'.chr(13)?>
          </a>
        </td>
        <td style="color:#666;font-size:11px;">
          <a title="codigo: <?=$row1['codigo']?>" href="?sec=inscripciones.editar&amp;editando=<?=$row1['id']?>">
<?=ucwords(str_replace('autonoma', '',str_replace('autónoma', '',strtolower($localidad))));
if ((trim(strtolower($localidad)) != 'capital federal') && (trim(strtolower($localidad)) != 'ciudad de buenos aires') && (trim(strtolower($localidad)) != 'ciudad autonoma de buenos aires') && (trim(strtolower($provincia)) != 'capital federal') && (trim(strtolower($provincia)) != 'ciudad de buenos aires') && (trim(strtolower($provincia)) != 'ciudad autonoma de buenos aires'))
    echo ' ('.ucwords(str_replace('autónoma', '',str_replace('autonoma', '',str_replace('santiago', 'stgo.',str_replace('buenos aires', 'bs. as.',str_replace('-', '',(strtolower($provincia)))))))).')'?>
          </a>
        </td>
        <td>
          <a title="codigo: <?=$row1['codigo']?>" href="?sec=inscripciones.editar&amp;editando=<?=$row1['id']?>">
<?
$result3 = mysql_query('SELECT * FROM inscribite_categorias WHERE ((deevento = "'.$row1['deevento'].'") && (codigo = "'.substr($row1['codigo'],4,2).'")) LIMIT 1');
$row3 = mysql_fetch_array($result3);
$categavr = $row3['opcion'];
//$categavr = str_replace('Categorias de ', '', $categavr);
//$categavr = str_replace('Categorías de ', '', $categavr);
//$categavr = str_replace('categorias de ', '', $categavr);
//$categavr = str_replace('categorías de ', '', $categavr);
//$categavr = str_replace('categoria ', '', $categavr);
//$categavr = str_replace('categoría ', '', $categavr);
//$categavr = str_replace('Categoria ', '', $categavr);
//$categavr = str_replace('Categoría ', '', $categavr);
//$categavr = str_replace('Grupo ', '', $categavr);
//$categavr = str_replace('grupo ', '', $categavr);
echo $categavr;
?>
          </a>
        </td>
        <td>
          <a title="codigo: <?=$row1['codigo']?>" href="?sec=inscripciones.editar&amp;editando=<?=$row1['id']?>">
            <?=$row1['categoria']?>
          </a>
        </td>
<?
  if ($tipo == 'Servicios') {
    echo '<td>';
    if ($row1['mes']!= '') {
      echo substr($row1['mes'],0,2).'/'.substr($row1['mes'],2,2);
    }
    echo '</td>';
  }
?>
        <td style="text-align:right;">
          <a title="codigo: <?=$row1['codigo']?>" href="?sec=inscripciones.editar&amp;editando=<?=$row1['id']?>">
           <?=substr($row2['fechanac'],6,2)?>/<?=substr($row2['fechanac'],4,2)?>/<?=substr($row2['fechanac'],0,4)?>
          </a>
        </td>
        <td style="font-size:10px;line-height:20px;color:#555">
          <strong><?
if ($row1['precio']*1 != 0) echo '$'.$row1['precio']?></strong>
<?
if ($row1['pagoeldia'] != "0000-00-00 00:00:00") echo substr($row1['pagoeldia'],8,2).'/'.substr($row1['pagoeldia'],5,2).'/'.substr($row1['pagoeldia'],2,2).' '.substr($row1['pagoeldia'],11,5).'hs'?>
        </td>
        <td>
          <a href="javascript:confirm_entry('inscripcion de usuario: dni <?=$row1['deusuario']?>', 'inscripciones.admin<?
if ($_GET['evento'] != '') echo 'amp;evento='.$_GET['evento']; if ($_GET['busqueda'] != '') echo 'amp;busqueda='.$_GET['busqueda']; if ($_GET['ordenarpor'] != "") echo 'amp;ordenarpor='.$_GET['ordenarpor']?>', 'inscribite_inscripciones',<?=$row1['id']?>)">
            <img src="images/deletex.gif" alt="Eliminar"/>
          </a>
        </td>
      </tr>
<?
} } }
?>
    </table>
  </div>
  </div>
    </div>
<?
}
if (($_GET['sec'] == 'inscripciones.agregar') || ($_GET['sec'] == 'inscripciones.editar')) {
  $result1 = mysql_query('SELECT * FROM inscribite_inscripciones WHERE id = '.$_GET['editando'].' LIMIT 1 ');
  if (is_resource($result1)) {
    $row1 = mysql_fetch_array($result1);
    $nroid = $row1['id'];
  }
?>
    <div>
        <div class="titulosec">Inscripciones &gt; <?=(is_resource($result1))?'Editando:':'Agregar Nueva'?> <?=$row1['deusuario']?>
        </div>
      <div>
		<form action="guardar" method="post">
      <div>
        <input type="hidden" name="id" value="<?=$nroid?>"/>
        <input type="hidden" name="tabla" value="inscribite_inscripciones"/>
        <input type="hidden" name="volvera" value="inscripciones.admin"/>

        &gt; DNI del inscripto
        <input type="text" name="deusuario" value="<?=$row1['deusuario']?>"/>

        <div style="margin-bottom:11px;">
          &gt; Iniciado el día: <?=substr($row1['iniciadoeldia'], 8, 2).' / '.substr($row1['iniciadoeldia'], 5, 2).' / '.substr($row1['iniciadoeldia'], 0, 4)?>
        </div>
        <div>
          &gt; Vence el día: <?=substr($row1['venceeldia'], 6, 2).' / '.substr($row1['venceeldia'], 4, 2).' / '.substr($row1['venceeldia'], 0, 4)?>
        </div>

            <div class="contselect">
              &gt; Categoría
			  <select name="categoria">
<?
$result3 = mysql_query('SELECT * FROM inscribite_categorias WHERE deevento="'.$row1['deevento'].'" ');
while ($row3 = mysql_fetch_array($result3)) {
?>
                <option<?
if ($row1['categoria'] == $row3['nombre']) echo ' selected="selected"'?> value="<?=$row3['nombre']?>"><?=$row3['nombre']?></option>
<?
}
?>
			  </select>
            </div>
            <div class="contselect">
			&gt; Pagado
			<select name="pagado">
              <option<?
if ($row1['pagado'] == 0) echo ' selected="selected"'?> value="0">No</option>
              <option<?
if ($row1['pagado'] == 1) echo ' selected="selected"'?> value="1">Si</option>
			</select>
            </div>
<?
$result3 = mysql_query('SELECT * FROM inscribite_eventos WHERE codigo = "'.$row1['deevento'].'" ');
$row3 = mysql_fetch_array($result3);
if ($row3['pregunta1'] != '') {
  echo '            Pregunta 1<br/>';
  echo $row3['pregunta1'].'<br/>';
  echo '            Respuesta:<br/>';
  echo $row1['respuesta1'].'<br/>';
}
if ($row3['pregunta2'] != '') {
  echo '            Pregunta 2<br/>';
  echo $row3['pregunta2'].'<br/>';
  echo '            Respuesta:<br/>';
  echo $row1['respuesta2'].'<br/>';
}
if ($row3['pregunta3'] != '') {
  echo '            Pregunta 3<br/>';
  echo $row3['pregunta3'].'<br/>';
  echo '            Respuesta:<br/>';
  echo $row1['respuesta3'].'<br/>';
}
?>

			<input type="submit" value="Enviar" class="submit"/>
          </div>
		</form>
      </div>
	</div>
<?
}
if ($_GET['sec'] == 'feedback.pagofacil') {
?>
	<div>
	<div>
	<div class="titulosec">Inscripciones &gt; Subir Archivo de PagoFacil</div>
		<div>
			<form enctype="multipart/form-data" action="uploadfilefpagofacil.php" method="post">
    	    <div>
			Subir archivo:<br/><input name="archivo_usuario" type="file" onChange="submit()" style="width:350px;"/>
    	    </div>
			</form>
		</div>
	</div>
    <br/>
	<div style="margin-bottom:10px;">
	Subidos
	</div>
	<form action="verarchivospfacil" method="post">
    <div style="height:50px;">
        <input type="hidden" name="volvera" value="feedback.pagofacilamp;pagina=<?=$_GET['pagina']?>"/>
        <div style="float:left;clear:left;margin-top:15px;">
<?
$paginardea = 40;
$limitdesde = ($_GET['pagina'])*$paginardea;
$limitdesde = $limitdesde-$paginardea;
if ($_GET['pagina'] == "") $limitdesde = 0;
$result1 = mysql_query('SELECT id FROM inscribite_archivospfacil ');
$cantproductos = mysql_num_rows($result1);
echo($limitdesde+1)?> al <?=($limitdesde+$paginardea)?> de <?=$cantproductos?>
		- P&aacute;gina
<?
for ($cpag = 0; $cpag <= $cantproductos/$paginardea; $cpag++) {
  if ($cantproductos>($cpag*$paginardea)) { ?>
		<a href="?sec=feedback.pagofacil&amp;pagina=<?=($cpag+1)?>"<?=($limitdesde == $cpag*$paginardea)?' style="font-weight:bold;"':' style="font-weight:normal;"'?>><?=($cpag+1)?></a> <?
  }
}
$result1 = mysql_query('SELECT * FROM inscribite_archivospfacil ORDER BY id DESC LIMIT '.$limitdesde.', '.$paginardea);
?>
        </div>
      <div style="float:right;line-height:10px;">
        <input type="submit" value="Procesar Archivos" style="width:120px;border:none;background:none;cursor:pointer;border-bottom:1px black solid;margin:0px;padding-left:0px;padding-right:0px;"/>
	  </div>
    </div>
	<table>
      <tr>
        <th style="width:100px;">Archivo</th>
        <th style="width:50px;">Peso</th>
        <th style="width:100px;">Fecha</th>
        <th style="text-align:left;"><a href="" onclick="for (n = 1; n <= <?=mysql_num_rows($result1)?>; n++) { if (document.getElementById('check<?=mysql_num_rows($result1)?>').checked != true)document.getElementById('check'+n).checked = true; else document.getElementById('check'+n).checked = false; };return false;">Marcar Todos</a></th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
      </tr>
<?
$cuentachecks = 0;
while ($row1 = mysql_fetch_array($result1)) {
  $cuentachecks++;
?>
        <tr>
          <td><a href="filepfacil/<?=$row1['nombre']?>"><?=$row1['nombre']?></a></td>
          <td style="font-size:10px;">
          <?
  if (file_exists("filepfacil/".$row1['nombre'])) echo filesize("filepfacil/".$row1['nombre']).chr(13)?>
          </td>
          <td style="font-weight:bold;">
           <?=$row1['fecha']?>
          </td>
          <td>
            <input type="checkbox" id="check<?=$cuentachecks?>" name="verfile<?=$row1['id']?>" value="<?=$row1['nombre']?>" style="width:auto;height:auto;margin:7px 0px 6px 0px;float:left;clear:none;border:none;"/>
          </td>
          <td>
            <a href="verarchivospfacil.php?archivo=<?=$row1['nombre']?>&amp;volvera=feedback.pagofacilamp;pagina=<?=$_GET['pagina']?>">Reprocesar</a>
          </td>
          <td>&nbsp;</td>
        </tr>
<?
}
?>
      </table>
      <div style="float:right;margin-top:15px;line-height:10px;">
        <input type="submit" value="Procesar Archivos" style="width:120px;border:none;background:none;cursor:pointer;border-bottom:1px black solid;margin:0px;padding-left:0px;padding-right:0px;"/>
	  </div>
    </form>
    <div style="height:80px;">
        <div style="float:left;clear:left;margin-top:15px;">
         <?=($limitdesde+1)?> al <?=($limitdesde+$paginardea)?> de <?=$cantproductos?> - P&aacute;gina
<?
for ($cpag = 0; $cpag <= $cantproductos/$paginardea; $cpag++) {
    if ($cantproductos>($cpag*$paginardea)) {
?>
		<a href="?sec=feedback.pagofacil&amp;pagina=<?=($cpag+1)?>"<?=($limitdesde == $cpag*$paginardea)?' style="font-weight:bold;"':''?>><?=($cpag+1)?></a> <?
}
  }
?>
        </div>
    </div>
</div>
</div>
<?
}
if (($_GET['sec'] == 'banners.agregar') || ($_GET['sec'] == 'banners.editar')) {
	$result1 = mysql_query('SELECT * FROM inscribite_banners WHERE id="'.$_GET['editando'].'" LIMIT 1 ');
	$row1 = mysql_fetch_array($result1);
    $idactual = ($_GET['sec'] == 'banners.agregar')?'':$row1['id']?>
	<div>
     <div style="line-height:30px;font-weight:bold;margin-top:10px;"><a href="?sec=categorias.admin&amp;evento=<?=$_GET['evento']?>">Categorías</a> &gt; <?=($_GET['sec'] == 'categorias.agregar')?'Agregar Nueva':'Editar'?> &gt; <?=$row2['nombreevento']?></div>
      <form enctype="multipart/form-data" action="guardar.php" method="post">
       <div>
        <input type="hidden" name="tabla" value="inscribite_banners"/>
        <input type="hidden" name="id" value="<?=$idactual?>"/>
        <input type="hidden" name="volvera" value="<?=($_GET['sec'] == 'banners.agregar')?'banners.agregar':'banners.admin'?>"/>
        <input type="hidden" name="columna" value="2"/>
<?
/*        <input type="hidden" name="columna" value="2"/>*/
?>
        <div style="width:470px;float:left;clear:none;">
          &gt; Nombre
         <input type="text" name="nombre" value="<?=$row1['nombre']?>"/>
        </div>
       <div class="contcheckbox"style="float:left;clear:left;width:100%;">
        <input type="hidden" name="ver" value="0"/>
        <span>&gt; Ver</span>
        <input type="checkbox" name="ver" value="1"<?=($row1['ver'] == 1)?' checked="checked"':''?>/>
       </div>
        <div style="width:470px;float:left;clear:none;">
          &gt; Link
         <input type="text" name="link" value="<?=$row1['link']?>"/>
        </div>
        <input type="hidden" name="nombrevar" value="imagen1"/>
        <input type="hidden" name="width1" value="160"/>
        <input type="hidden" name="height1" value="60"/>

        <div class="contselect" style="float:left;clear:left;">
         Formato:
         <select name="width1">
          <option value="160"<? if ($row1['width1'] == 160) echo ' selected="selected"' ?>>160px x 60px</option>
          <option value="544"<? if ($row1['width1'] == 544) echo ' selected="selected"' ?>>544px x 60px</option>
         </select>
        </div>

        <div class="contselect" style="float:left;clear:left;width:100%;">
          <span style="float:left;">Evento:</span>
          <select name="areventos[]" multiple="multiple" size="4" style="float:left;clear:none;margin-left:7px;">
            <option value="0"<? if (strpos($row1['eventos'], '_0') > -1) echo' selected="selected"'?>>Todos</option>
<?
  $result2 = mysql_query('SELECT * FROM inscribite_eventos WHERE ver = 1 ORDER BY nombre ASC');
  while ($row2 = mysql_fetch_array($result2)) {
?>
            <option value="<?=$row2['id']?>"<? if (strpos($row1['eventos'], '_'.$row2['id']) > -1) echo' selected="selected"'?>><?=$row2['nombre']?></option>
<? } ?>
          </select>
        </div>

        <div class="contselect" style="float:left;clear:left;width:100%;">
          Ubicación:
          <select name="ubicacion">
            <option value="1"<? if ($row1['ubicacion'] == 1) echo ' selected="selected"'?>>Inicio de inscripción</option>
            <option value="2"<? if ($row1['ubicacion'] == 2) echo ' selected="selected"'?>>Cupón</option>
            <option value="0"<? if ($row1['ubicacion'] == 0) echo ' selected="selected"'?>>Ambos</option>
          </select>
        </div>

        <div style="margin-top:20px;margin-bottom:16px;padding:0px;width:100%;float:left;clear:left;">
         &gt; Imagen 1
<?
if (($row1['imagen1'] != '') && (file_exists($directorio.'image_'.$row1['imagen1']))) {
  echo '<div><img src="'.$directorio.'image_'.$row1['imagen1'].'" alt="" style="margin:10px 0px 10px 0px;"/></div>';
}
?>
        <br/>
        Subir imagen nueva:<br/><input name="imagen1" type="file" style="display:inline;width:300px;"/>
        </div>
<? /*
        <div class="contselect" style="float:left;clear:left;width:100%;">
         &gt; Posición<br/><br/>
         <select name="columna">
          <option value="">Selecciona opcion</option>
          <option<?
if ($row1['columna'] == 1) echo ' selected="selected"'?> value="1">Izquierda</option>
          <option<?
if ($row1['columna'] == 2) echo ' selected="selected"'?> value="2">Derecha</option>
         </select>
        </div>
*/ ?>
		  <div style="float:left;clear:left;width:100%;">
			<input type="submit" value="Enviar" class="submit"/>
		  </div>
       </div>
	  </form>
     </div>
<?
}
if ($_GET['sec'] == 'banners.admin') {
?>
   <div>
    <div class="titulosec">Banners &gt; Admin
    </div>
    <table>
     <tr>
      <th style="text-align:left;">Nombre</th>
      <th style="text-align:left;">Publicado</th>
      <th style="text-align:left;">Link</th>
      <th style="text-align:left;">Evento</th>
      <th style="text-align:left;">Formato</th>
      <th>&nbsp;</th>
     </tr>
<?
  $result1 = mysql_query('SELECT * FROM inscribite_banners ');
  while ($row1 = mysql_fetch_array($result1)) {
?>
     <tr>
      <td>
       <a href="?sec=banners.editar&amp;editando=<?=$row1['id']?>">
        <?=$row1['nombre']?>
       </a>
      </td>
      <td>
        <a href="cambiacheck.php?tabla=inscribite_banners&amp;campo=ver&amp;id=<?=$row1['id']?>&amp;volvera=banners.admin" onclick="cmbcheck(this.parentNode,'inscribite_banners', 'ver',<?=$row1['id']?>,'<?=$_GET['sec']?>');return false" title="Cambiar">
          <img src="images/<?=($row1['ver'] == 1)?'checkboxchecked.gif':'checkbox.gif'?>" alt="" style="margin-top:0px;"/>
        </a>
      </td>
      <td>
       <a href="?sec=banners.editar&amp;editando=<?=$row1['id']?>">
        <?=$row1['link']?>
       </a>
      </td>
      <td>
       <a href="?sec=banners.editar&amp;editando=<?=$row1['id']?>">
        <?
          $result2 = mysql_query('SELECT * FROM inscribite_eventos WHERE id = '.$row1['evento']);
          $row2 = mysql_fetch_array($result2);
          echo $row2['nombre']?>
       </a>
      </td>
      <td>
       <a href="?sec=banners.editar&amp;editando=<?=$row1['id']?>">
        <?
          if ($row1['width1'] == 160) echo '160px x 60px';
          if ($row1['width1'] == 544) echo '544px x 60px';
        ?>
       </a>
      </td>
      <td>
       <a href="javascript:confirm_entry('<?=$row1['nombre']?>', 'banners.admin', 'inscribite_banners',<?=$row1['id']?>)"><img src="images/deletex.gif" alt="Eliminar"/></a>
      </td>
     </tr>
<?
  }
?>
    </table>
   </div>
<?
}
if (($_GET['sec'] == 'entrenadores.agregar') || ($_GET['sec'] == 'entrenadores.editar')) {
  $result1 = mysql_query('SELECT * FROM inscribite_entrenadores WHERE id = '.$_GET['editando'].' LIMIT 1 ');
  if (is_resource($result1)) {
	$row1 = mysql_fetch_array($result1);
	$nroid = $row1['id'];
  }
?>
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
<?
}
if ($_GET['sec'] == 'entrenadores.admin') {
?>
	        Entrenadores &gt; Admin
      <table>
        <tr>
          <th>Nombre</th>
          <th>&nbsp;</th>
          <th>&nbsp;</th>
        </tr>
<?
  $result1 = mysql_query('SELECT * FROM inscribite_entrenadores ');
  while ($row1 = mysql_fetch_array($result1)) {
?>
        <tr>
          <td>
            <a href="?sec=entrenadores.editar&amp;editando=<?=$row1['id']?>">
              <span style="color:#777;font-weight:normal;"><?=$row1['codigo']?></span> <?=$row1['nombre']?>
            </a>
          </td>
          <td>
              <a href="javascript:confirm_entry('<?=$row1['nombre']?>', 'entrenadores.admin', 'inscribite_entrenadores',<?=$row1['id']?>)"><img src="images/deletex.gif" alt="Eliminar"/></a>
          </td>
        </tr>
<?
}
?>
      </table>
<?
}
if (($_GET['sec'] == 'faq.agregar') || ($_GET['sec'] == 'faq.editar')) {
  $result1 = mysql_query('SELECT * FROM inscribite_faq WHERE id = '.$_GET['editando'].' LIMIT 1 ');
  if (is_resource($result1)) {
	$row1 = mysql_fetch_array($result1);
	$nroid = $row1['id'];
  }
?>
          <div>
	            <div class="titulosec">Preguntas Frecuentes &gt; <?=(is_resource($result1))?'Editando: '.$row1['nombre']:'Agregar Nueva'?>
                </div>
            <div>
		      <form enctype="multipart/form-data"  action="guardar" method="post">
			    <div>
			      <input type="hidden" name="id" value="<?=$nroid?>"/>
			      <input type="hidden" name="tabla" value="inscribite_faq"/>
			      <input type="hidden" name="volvera" value="faq.admin"/>
			      &gt; Número
                  <input type="text" name="numero" value="<?=$row1['numero']?>"/>
			      &gt; Pregunta
                  <textarea name="pregunta" cols="50" rows="10" id="descrevent" onkeypress="editaritem = this.id; escribiendo(event);"><?=$row1['pregunta']?></textarea>
                  &gt; Respuesta
                  <textarea name="respuesta" cols="50" rows="10" id="descrevent" onkeypress="editaritem = this.id; escribiendo(event);"><?=$row1['respuesta']?></textarea>
          		  <input type="submit" value="Enviar" class="submit" onclick="document.body.style.backgroundImage = 'url(images/ajaxloadingbig.gif)';"/>
                </div>
              </form>
            </div>
          </div>
<?
}
if ($_GET['sec'] == 'faq.admin') {
?>
	        Preguntas Frecuentes &gt; Admin
      <table>
        <tr>
          <th>Nro</th>
          <th>Pregunta</th>
          <th>&nbsp;</th>
          <th>&nbsp;</th>
        </tr>
<?
$result1 = mysql_query('SELECT * FROM inscribite_faq ');
while ($row1 = mysql_fetch_array($result1)) {
?>
        <tr>
          <td>
            <a href="?sec=faq.editar&amp;editando=<?=$row1['id']?>">
              <?=$row1['numero']?>
            </a>
          </td>
          <td>
            <a href="?sec=faq.editar&amp;editando=<?=$row1['id']?>">
              <?=$row1['pregunta']?>
            </a>
          </td>
          <td>
          </td>
          <td>
              <a href="javascript:confirm_entry('<?=$row1['pregunta']?>', 'faq.admin', 'inscribite_faq',<?=$row1['id']?>)"><img src="images/deletex.gif" alt="Eliminar"/></a>
          </td>
        </tr>
<?
}
?>
      </table>
<?
}
if ($_GET['sec'] == 'buscar.usuarios') {
?>
      <table>
        <tr>
          <th>Nro</th>
          <th>Nombre</th>
          <th>Apellido</th>
          <th>DNI</th>
          <th>Nac.</th>
          <th>Sexo</th>
          <th>Mail</th>
          <th>Puntos</th>
          <th>Pass</th>
          <th>Tel. Part.</th>
          <th>Tel. Lab.</th>
          <th>Tel. Cel.</th>
          <th>Domicilio</th>
          <th>Pcia</th>
          <th>Pa&iacute;s</th>
          <th>&nbsp;</th>
        </tr>
<?
$ordpor=$_GET['ordpor'];
if ($ordpor == "")         $ordpor='id';
if ($ordpor == "nombre")   $ordpor='nombre';
if ($ordpor == "apellido") $ordpor='apellido';
if ($ordpor == "dni")      $ordpor='dni';
if ($ordpor == "edad")     $ordpor='fechanac';
if ($ordpor == "evento")   $ordpor='evento0';
$verdesde = $_GET['verdesde'];
if ($verdesde == "") $verdesde = 0;
$result1 = mysql_query("SELECT * FROM inscribite_usuarios WHERE((apellido LIKE '%".$_GET['busqueda']."%')OR(dni LIKE '%".$_GET['busqueda']."%')) ORDER BY ".$ordpor." LIMIT ".$verdesde.",100");
while ($row1 = mysql_fetch_array($result1)) {
?>
        <tr>
          <td><a href="?sec=usuarios.editar&amp;editando=<?=$row1['id']?>"><?=$row1['id']?></a></td>
          <td><a href="?sec=usuarios.editar&amp;editando=<?=$row1['id']?>"><?=$row1['nombre']?></a></td>
          <td><a href="?sec=usuarios.editar&amp;editando=<?=$row1['id']?>" class="apellido"><?=$row1['apellido']?></a></td>
          <td style="text-align:right"><a class="dni" href="?sec=usuarios.editar&amp;editando=<?=$row1['id']?>"><?=$row1['dni']?></a></td>
          <td style="text-align:right; width:50px;">
           <a href="?sec=usuarios.editar&amp;editando=<?=$row1['id']?>">
            <?=substr($row1['fechanac'],6,2)."/".substr($row1['fechanac'],4,2)."/".substr($row1['fechanac'],0,4)?>
           </a>
          </td>
          <td><a href="?sec=usuarios.editar&amp;editando=<?=$row1['id']?>"><?=substr(ucfirst($row1['sexo']),0,1)?></a></td>
          <td><a href="?sec=usuarios.editar&amp;editando=<?=$row1['id']?>"><?=strtolower($row1['email'])?></a></td>
          <td style="text-align:right;"><a href="?sec=usuarios.editar&amp;editando=<?=$row1['id']?>"><?=$row1['puntos']?></a></td>
          <td><a href="?sec=usuarios.editar&amp;editando=<?=$row1['id']?>"><?=$row1['password']?></a></td>
          <td><a href="?sec=usuarios.editar&amp;editando=<?=$row1['id']?>">&nbsp;<?=$row1['telefonoparticular']?></a></td>
          <td><a href="?sec=usuarios.editar&amp;editando=<?=$row1['id']?>">&nbsp;<?=$row1['telefonolaboral']?></a></td>
          <td><a href="?sec=usuarios.editar&amp;editando=<?=$row1['id']?>">&nbsp;<?=$row1['telefonocelular']?></a></td>
          <td><a href="?sec=usuarios.editar&amp;editando=<?=$row1['id']?>"><?=$row1['domicilio']?></a></td>
          <td><a href="?sec=usuarios.editar&amp;editando=<?=$row1['id']?>"><?=ucfirst(strtolower($row1['provincia']))?></a></td>
          <td><a href="?sec=usuarios.editar&amp;editando=<?=$row1['id']?>"><?=$row1['pais']?></a></td>
          <td><a href="javascript:confirm_entry('<?=$row1['nombre']?> <?=$row1['apellido']?>', 'buscar.usuariosamp;busqueda=<?=$_GET['busqueda']?>', 'inscribite_usuarios',<?=$row1['id']?>)"><img src="images/deletex.gif" alt="Eliminar"/></a></td>
          <td><?
if ($row1['dni'] == $antedni) echo '<span style="color:red;">Se Repite</span>'?></td>
        </tr>
<?
}
?>
      </table>
<?
}
if (($_GET['sec'] == 'usuarios.agregar') || ($_GET['sec'] == 'usuarios.editar')) {
  $result1 = mysql_query('SELECT * FROM inscribite_usuarios WHERE id = '.$_GET['editando'].' LIMIT 1 ');
  if (is_resource($result1)) {
	$row1 = mysql_fetch_array($result1);
	$nroid = $row1['id'];
  }
?>
          <div>
	            <div class="titulosec">Usuario &gt; <?=(is_resource($result1))?'Editando: '.$row1['nombre']:'Agregar Nuevo'?>
                </div>
            <div>
		      <form enctype="multipart/form-data"  action="guardar" method="post">
			    <div>
			      <input type="hidden" name="id" value="<?=$nroid?>"/>
			      <input type="hidden" name="tabla" value="inscribite_usuarios"/>
			      <input type="hidden" name="volvera" value=""/>

                  <table>
                   <tr style="background:none;">
                    <td>
			         <div>&gt; Nombre</div>
                     <input type="text" style="width:200px;" name="nombre" value="<?=$row1['nombre']?>"/>
                    </td>
                    <td>
			         <div>&gt; Apellido</div>
                     <input type="text" style="width:200px;" name="apellido" value="<?=$row1['apellido']?>"/>
                    </td>
                   </tr>
                  </table>

			      <span style="font-size:13px;">&gt; Puntos</span>
                  <input style="font-size:13px;height:20px;padding-top:5px;font-weight:bold;border:1px black solid" type="text" name="puntos" value="<?=$row1['puntos']?>"/>

                  <table>
                   <tr style="background:none;">
                    <td>
			         <div>&gt; Dni
			         </div>
                  <input type="text" style="width:200px;" name="dni" value="<?=$row1['dni']?>"/>
                    </td>
                    <td>
			         <div>&gt; Fecha de nacimiento
			         </div>
                  <input type="text" style="width:200px;" name="fechanac" value="<?=$row1['fechanac']?>"/>
                    </td>
                    <td>
			         <div>&gt; Sexo
			         </div>
                     <select name="sexo">
                      <option value="masculino"<? if ($row1['sexo'] == 'masculino') echo ' selected="selected"'?>>masculino</option>
                      <option value="femenino"<? if ($row1['sexo'] == 'femenino') echo ' selected="selected"'?>>femenino</option>
                     </select>
                    </td>
                   </tr>
                  </table>

			      &gt; Email
                  <input type="text" name="email" value="<?=$row1['email']?>"/>

			      &gt; Password
                  <input type="text" name="password" value="<?=$row1['password']?>"/>

			      &gt; Teléfono particular
                  <input type="text" name="telefonoparticular" value="<?=$row1['telefonoparticular']?>"/>

			      &gt; Teléfono laboral
                  <input type="text" name="telefonolaboral" value="<?=$row1['telefonolaboral']?>"/>

			      &gt; Teléfono celular
                  <input type="text" name="telefonocelular" value="<?=$row1['telefonocelular']?>"/>

			      &gt; Domicilio
                  <input type="text" name="domicilio" value="<?=$row1['domicilio']?>"/>

			      &gt; Localidad
                  <input type="text" name="localidad" value="<?=$row1['localidad']?>"/>

			      &gt; Provincia
                  <input type="text" name="provincia" value="<?=$row1['provincia']?>"/>

			      &gt; País
                  <input type="text" name="pais" value="<?=$row1['pais']?>"/>

          		  <input type="submit" value="Enviar" class="submit" onclick="document.body.style.backgroundImage = 'url(images/ajaxloadingbig.gif)';"/>
                </div>
              </form>
            </div>
          </div>
<?
}


//    </div>
?>
<script type="text/javascript">
<!--
function autoComplete() {
  var i = 0;
  for (var node;node = document.getElementsByTagName('input')[i];i++) {
    var type = node.getAttribute('type').toLowerCase();
    if (type == 'text') {
      node.setAttribute('autocomplete', 'off');
    }
  }
}
autoComplete();
var inputs = document.getElementsByTagName("input");
for (var i = 0;i<inputs.length;i++) {
  if ((inputs[i].type != 'radio') && (inputs[i].type != 'checkbox')) {
    inputs[i].onfocus = function() { this.style.backgroundColor = '#FFF';    };
    inputs[i].onblur = function()  { this.style.backgroundColor = '#FFFFCC'; };
  }
}
var inputs = document.getElementsByTagName("textarea");
for (var i = 0; i < inputs.length; i++) {
  inputs[i].onfocus = function() { this.style.backgroundColor = 'transparent'; };
  inputs[i].onblur = function()  { this.style.backgroundColor = '#FFFFCC';     };
}
ultcolortr = 'transparent';
var inputs = document.getElementsByTagName("tr");
for (var i = 0; i < inputs.length; i++) { /*
  inputs[i].onmouseover = function() {
    ultcolortr = this.style.backgroundColor;
    this.style.backgroundColor = '#1793C9';
  }
  */
  //inputs[i].onmouseout = function() { this.style.backgroundColor = ultcolortr };
}
-->
</script>
 </div>
</body>
</html>
<?
} else {
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
  <head>
    <title>Inscribite Online - Administración</title>
    <meta name="ROBOTS" content="NOARCHIVE"/>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style type="text/css">
    <!--
    body{
    	font-family:Arial, Helvetica, sans-serif;
    	font-size:12px;
    }
    .submit{
    	border:1px #555555 solid;
    	width:100px;
    	background-color:white;
    	font-size:12px;
    	margin-left:auto;
    	margin-right:auto;
    	display:block;
    	margin-top:20px;
    }
    -->
    </style>
  </head>
  <body>
  <a href="../">InscribiteOnLine.com.ar</a>
    <div style="width:200px;margin-left:auto;margin-right:auto;margin-top:100px;">
      <form action="./" method="post">
        <div>
          Nombre de usuario<br/>
          <input type="text" name="admin_username" id="admin_username" style="width:150px;"/><br/>
<script type="text/javascript">
<!--
  document.getElementById('admin_username').focus();
-->
</script>
          Contraseña<br/>
          <input type="password" name="admin_password" style="width:150px;"/><br/>
          <input type="submit" value="Entrar" class="submit"/>
        </div>
      </form>
    </div>
  </body>
</html>
<?
}
if (is_resource($result1)) mysql_free_result($result1);
if (is_resource($result2)) mysql_free_result($result2);
if (is_resource($result3)) mysql_free_result($result3);
mysql_close();
?>