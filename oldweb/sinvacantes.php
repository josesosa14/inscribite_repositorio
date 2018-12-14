<? include 'includes/_soloheader.php';

$cat=$_GET['cat'];
$cod=$_GET['cod'];
$result1=mysql_query('SELECT * FROM inscribite_categorias WHERE ((nombre="'.$cat.'")AND(deevento="'.$_GET['evento'].'")AND(codigo="'.$cod.'")) LIMIT 1 ');
$row=mysql_fetch_array($result1);
$result2=mysql_query('SELECT nombre FROM inscribite_eventos WHERE codigo="'.$_GET['evento'].'" LIMIT 1 ');
$row2=mysql_fetch_array($result2);
?>
    <div class="columnacentral" style="height:auto;font-size:14px; width:100%;">
      <form action="inscripcion?evento=<?=$_GET['evento']?>" method="post">

    	<div style="width:400px;height:135px;margin-left:auto;margin-right:auto;margin-top:30px;margin-bottom:30px;border:1px red solid;padding:10px;">
          No quedan vacantes disponibles en este grupo.
          <a href="javascript:history.back()" style="float:left;clear:none;margin-top:27px;margin-left:15px;font-size:12px;">Volver</a>
        </div>
      </form>
	</div>
<? include 'includes/_solofooter.php'?>