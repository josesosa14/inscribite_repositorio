<?
$nomostrarcoli=true;
include 'includes/head.php';
if($_GET['tipo']=='')$_GET['tipo']='Deportivos'?>
      <div class="columnacentral" style="height:auto;width:565px;">
      <div style="color:#336699;font-family:Arial,Helvetica,sans-serif;font-size:11px;padding:5px;margin-bottom:7px;margin-top:7px;">
      Busca en la solapa correspondiente el evento en que queres inscribirte, la mensualidad o compra de producto que necesitas pagar.
      </div>
       <div style="width:99px;height:22px;overflow:hidden;float:left;clear:none;background-image:url(webimages/solapa<?=($_GET['tipo']=='Deportivos')?'1':'0'?>.gif);color:#336699;font-size:12px;line-height:25px;text-align:center;">
        <a href="?tipo=Deportivos">Deportivos</a>
       </div>
       <div style="width:99px;height:22px;overflow:hidden;float:left;clear:none;background-image:url(webimages/solapa<?=($_GET['tipo']=='Capacitación')?'1':'0'?>.gif);color:#336699;font-size:12px;line-height:25px;text-align:center;">
        <a href="?tipo=Capacitación">Capacitación</a>
       </div>
       <div style="width:99px;height:22px;overflow:hidden;float:left;clear:none;background-image:url(webimages/solapa<?=($_GET['tipo']=='Servicios')?'1':'0'?>.gif);color:#336699;font-size:12px;line-height:25px;text-align:center;">
        <a href="?tipo=Servicios">Servicios</a>
       </div>
       <div style="width:99px;height:22px;overflow:hidden;float:left;clear:none;background-image:url(webimages/solapa<?=($_GET['tipo']=='Productos')?'1':'0'?>.gif);color:#336699;font-size:12px;line-height:25px;text-align:center;">
        <a href="?tipo=Productos">Productos</a>
       </div>
       <div style="float:left;width:550px;border-left:1px #6F6F6F solid;">
        <div class="contenidoseccioncentral" style="height:auto;float:left;height:250px;overflow:auto;">
<? /*
         <div style="float:left;clear:left;width:100%;">
          Estos son los eventos, cursos, congresos y servicios que han elegido INSCRIBITEONLINE para brindarte mayor comodidad en <span style="float:left;">tu inscripción.</span><span style="float:right;clear:none;"></span>
         </div>
*/ ?>
         <table class="tabladeeventos">
          <tr>
           <th>Nro</th>
           <th>Fecha</th>
           <th>Evento</th>
           <th>Organizador</th>
           <th>&nbsp;</th>
          </tr>
<?
$paginardea=500;
$limitdesde=$_GET['pagina']*$paginardea;
$limitdesde=$limitdesde-$paginardea;
if($_GET['pagina']=="")$limitdesde=0;
$vercategoria='';
//if($_GET['buscar']!=''){
//	$vercategoria="WHERE ((nombre LIKE '%".$_GET['buscar']."%')||(codigo LIKE '%".$_GET['buscar']."%')) ";
//}
$result1=mysql_query('SELECT * FROM inscribite_eventos WHERE ver=1 AND tipo="'.$_GET['tipo'].'" ORDER BY fechaord, nombre ');
$cantitems=mysql_num_rows($result1);
$cuentaev=0;
$result1=mysql_query('SELECT * FROM inscribite_eventos WHERE ver=1 AND tipo="'.$_GET['tipo'].'" ORDER BY fechaord, nombre LIMIT '.$limitdesde.', '.$paginardea);
while($row=mysql_fetch_array($result1)){
/*
$cuentaev++;
       ?><div class="cadaevento">
          <div class="titulo">
           <div><a href="iniciainscri?evento=<?=$row['codigo']?>"><?=$row['nombre']?></a></div>
          </div>

          <div style="width:100%;float:left;margin-top:6px;margin-bottom:6px;">
<? if(file_exists("imagenes/image_".$row['imagen1'])){
$datos=getimagesize("imagenes/image_".$row['imagen1']); ?>
           <div style="width:160px;display:inline;float:left;margin-left:107px;text-align:center;overflow:hidden;">
            <a href="iniciainscri?evento=<?=$row['codigo']?>">
             <img src="imagenes/image_<?=$row['imagen1']?>" alt="<?=$row['nombre']?>" style="width:<?=$datos[0]?>px;height:<?=$datos[1]?>px;display:inline;"/>
            </a>
           </div>
<? }
if(file_exists("imagenes/image_".$row['imagen2'])){ ?>
           <a href="iniciainscri?evento=<?=$row['codigo']?>">
            <img src="imagenes/image_<?=$row['imagen2']?>" alt="<?=$row['nombre']?>" style="display:inline;float:left;clear:none;margin-right:13px;margin-left:9px;"/>
           </a>
<? } ?>
          </div>

          <div class="descripciondeevento">
           <?=preg_replace("(\r\n|\n|\r)","<br/>",$row['descripcion']).chr(13);?>
          </div>

          <div class="botoninscripcion">
           <div>
            <div style="margin-bottom:6px;margin-bottom:0px;padding-bottom:0px;"><a href="competidoresinscriptos?evento=<?=$row['codigo']?>">Ver Competidores Inscriptos</a></div>
           </div>
          </div>
         </div><?
*/

$cuentaev++;
       ?>

       <tr class="<?=($cuentaev%2==0)?'lineaspares':'lineasimpares'?>">
        <td>
         <a href="evento?evento=<?=$row['codigo']?>"><?=$row['codigo']?></a>
        </td>
        <td>
         <a href="evento?evento=<?=$row['codigo']?>"><?=($row['fecha']!='')?$row['fecha']:'&nbsp;'?></a>
        </td>
        <td>
         <a href="evento?evento=<?=$row['codigo']?>"><?=$row['nombre']?></a>
        </td>
        <td>
         <a href="evento?evento=<?=$row['codigo']?>"><?=$row['empresa']?></a>
        </td>
        <td style="width:65px;">
         <a href="evento?evento=<?=$row['codigo']?>" style="color:#EC126C;text-decoration:underline;width:65px;">Más Info</a>
        </td>
       </tr>
<? } ?>
         </table>
<?
   /* if($cantitems>$paginardea){
?>
         <span style="float:left;margin-top:10px;">
          Viendo del <?=($limitdesde+1)?> al <?=$cuentaev?> de <?=$cantitems?> - Página
<? for($cpag=0;$cpag<$cantitems/$paginardea;$cpag++){ ?>
          <a href="?sec=inscripciones.admin&amp;pagina=<?=($cpag+1)?>" <?=($limitdesde==$cpag*$paginardea)?'style="font-weight:bold;text-decoration:none;"':'style="font-weight:normal;text-decoration:none;"'?>><?=($cpag+1)?></a>
<? } ?>
         </span>
<? } */ ?>
         <span style="float:right;clear:none;margin-top:10px;"><? /*<a href="eventoslistacompleta" style="text-decoration:underline;">Ver como lista</a>*/ ?></span>
        </div>
       </div>
      </div>
<? include 'includes/colder.php'?>