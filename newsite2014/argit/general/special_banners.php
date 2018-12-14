<?php

$query = "SELECT * FROM inscribite_banners WHERE (evento = '{$evento_info['id']}' OR eventos like '%_{$evento_info['id']},%')  AND ver = 1 ORDER BY columna ASC";
$banners = getArrayQuery($query,$mysqli);


if($banners){
echo '<div class="row">';
	foreach($banners as $banner){
		echo '<div class="col-sm-6"><a href="'.$banner['link'].'"><img src="http://www.inscribiteonline.com.ar/newsite2014/imagenes/image_'.$banner['imagen1'].'" class="img-responsive"/></a></div>';
	}
echo '</div>';
}


echo '<div class="clear"></div><br><br>';

