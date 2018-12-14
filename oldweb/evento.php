<?
$nomostrarcoli=true;
include 'includes/head.php';
if($_GET['tipo']=='')$_GET['tipo']='Deportivos';

$paginardea = 500;
$limitdesde = $_GET['pagina']*$paginardea;
$limitdesde = $limitdesde-$paginardea;
if($_GET['pagina']=="") $limitdesde = 0;
$vercategoria='';
//if($_GET['buscar']!=''){
//	$vercategoria="WHERE ((nombre LIKE '%".$_GET['buscar']."%')||(codigo LIKE '%".$_GET['buscar']."%')) ";
//}
$result1 = mysql_query('SELECT * FROM inscribite_eventos WHERE ver=1 AND tipo="'.$_GET['tipo'].'" ');
$cantitems = mysql_num_rows($result1);
$cuentaev = 0;
$result1 = mysql_query('SELECT * FROM inscribite_eventos WHERE codigo="'.$_GET['evento'].'" LIMIT 1');
$row = mysql_fetch_array($result1);

$cuentaev++;
       ?>
       <div style="float:left;width:544px;">
       <div class="cadaevento" style="padding-bottom:8px;">
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

          <div class="botoninscripcion" style="padding-bottom:0px;">
           <div>
<? if ($row['mostrarcinscriptos'] == 1) { ?>
            <div style="margin-top:2px;margin-bottom:6px;margin-bottom:0px;padding-bottom:0px;"><a href="competidoresinscriptos?evento=<?=$row['codigo']?>">Ver Competidores Inscriptos</a></div>
<? } ?>
           </div>
           <a href="iniciainscri?evento=<?=$row['codigo']?>" style="color:#EC126C;margin-top:9px;display:block;padding-bottom:0px;margin-bottom:0px;">
            Inscribirme
           </a>
        </div>
      </div>
<?
//$result1=mysql_query('SELECT * FROM inscribite_banners WHERE ver = 1 AND width1 = 544 AND (evento='.$row['id'].' OR evento=0) LIMIT 3');
$result1 = mysql_query('SELECT * FROM inscribite_banners WHERE ver = 1 AND width1 = 544 AND (eventos LIKE "%_'.$row['id'].',%" OR eventos LIKE "_0,%") LIMIT 3');
while ($row = mysql_fetch_array($result1)) {
  echo '<a href="http://'.str_replace('http://', '', $row['link']).'"><img src="imagenes/'.'image_'.$row['imagen1'].'" alt="" style="float:left;margin-top:10px;"/></a>';
}
?>
      </div>
<? include 'includes/colder.php'?>