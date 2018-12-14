<?php include_once 'includes/header.php'?>
  <div class="left">
<?
	$nomostrarcoli=true;
	//include_once 'includes/head.php';
	if ($_GET['tipo']=='')$_GET['tipo']='Deportivos';

	$paginardea = 500;
	$limitdesde = $_GET['pagina']*$paginardea;
	$limitdesde = $limitdesde-$paginardea;
	if ($_GET['pagina']=="") $limitdesde = 0;
	$vercategoria='';

	$result1 = mysql_query('SELECT * FROM '.pftables.'eventos WHERE ver=1 AND tipo="'.$_GET['tipo'].'" ');
	$cantitems = mysql_num_rows($result1);
	$cuentaev = 0;
	$result1 = mysql_query('SELECT * FROM '.pftables.'eventos WHERE codigo="'.$_GET['evento'].'" LIMIT 1');
	$row1 = mysql_fetch_array($result1);

	$cuentaev++;
       ?>
    <div style="float:left;width:560px;">
       <div class="cadaevento" style="padding-bottom:8px;">
          <h1><?=$row1['nombre']?></h1>
          <div style="width:100%;float:left;margin-top:6px;margin-bottom:6px;">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="35%">
	<div class="descripciondeevento">
           <p><?=preg_replace("(\r\n|\n|\r)","<br/>",$row1['descripcion']).chr(13);?></p>
          </div>
          <td width="65%"> 
	<?php //if (file_exists("/imagenes/image_".$row1['imagen1'])) {
//$datos=getimagesize("/imagenes/image_".$row1['imagen1']); ?>
           <div style="width:160px;display:inline;float:left;margin-left:0;text-align:left;overflow:hidden;">
            <a href="iniciainscripccion?evento=<?=$row1['codigo']?>">
             <img src="/imagenes/image_<?=$row1['imagen1']?>" alt="<?=$row1['nombre']?>" style="width:<?=$datos[0]?>px;height:<?=$datos[1]?>px;display:inline;border:none;"/></a>           
             </div>
<?php // }
// if (file_exists("/imagenes/image_".$row1['imagen2'])) { ?>
            <a href="iniciainscripccion?evento=<?=$row1['codigo']?>">
            <img src="/imagenes/image_<?=$row1['imagen2']?>" alt="<?=$row1['nombre']?>" style="display:inline;float:left;clear:none;margin-right:13px;margin-left:15px;border:2px solid #009900;"/></a>
<?php //} ?>
          </td>         
  </table>
         <div class="botoninscripcion" style="padding-bottom:0px;">
           <div>
<?php if ($row1['mostrarcinscriptos'] == 1) { ?>
            <div style="margin-top:2px;margin-bottom:6px;margin-bottom:0px;padding-bottom:0px;"><a href="competidoresinscriptos?evento=<?=$row1['codigo']?>">Ver Competidores Inscriptos</a></div>
<?php } ?>
           </div>
 			<a href="iniciainscripccion?evento=<?=$row1['codigo']?>" class="greenbtn" style="padding:1px 4px 8px 4px">AVANZAR</a>
        </div>
      </div>
       <?
//$result1=mysql_query('SELECT * FROM '.pftables.'banners WHERE ver = 1 AND width1 = 544 AND (evento='.$row1['id'].' OR evento=0) LIMIT 3');
$result1 = mysql_query('SELECT * FROM '.pftables.'banners WHERE ver = 1 AND width1 = 544 AND (eventos LIKE "%_'.$row1['id'].',%" OR eventos LIKE "_0,%") LIMIT 3');
while ($row1 = mysql_fetch_array($result1)) {
  echo '<a href="http://'.str_replace('http://', '', $row1['link']).'"><img src="/imagenes/'.'image_'.$row1['imagen1'].'" alt="" style="float:left;margin-top:10px;"/></a>';
}
?>
    </div></div>
<?php include_once 'includes/footerfull.php'?>