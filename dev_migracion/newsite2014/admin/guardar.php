<?	header("Content-type: text/html; charset=UTF-8");

	include_once "../inc.config.php";

	function agceros($nombreag, $cantceros) {
		while (strlen($nombreag) < $cantceros) $nombreag = "0".$nombreag;
		return $nombreag;
	}
	$idActual = $_POST['id'];
	if ($_POST['tabla'] != '') {
		if (($idActual == 'nuevo') || ($idActual == '')) {
			mysql_query("INSERT INTO ".$_POST['tabla']." ( `id`) VALUES ( '');");
			/*$result1 = mysql_query('SELECT * FROM '.$_POST['tabla'].' LIMIT 1');
			$row1 = mysql_fetch_array($result1);
			$nombreId = '';
			foreach ($row1 as $llave => $valor)
				if ($nombreId == '') $nombreId = $llave;*/
			
			$result1 = mysql_query('SELECT * FROM '.$_POST['tabla'].' ORDER BY id DESC LIMIT 1');
			$row1 = mysql_fetch_array($result1);
			$idActual = $row1['id'];
		} else {
			// si se cambia el nombre de la opcion tiene que cambiar el nombre en todas las categorias de la base de las categorias
			if ($_POST['tabla'] == 'inscribite_eventos') {
				$result1 = mysql_query("SELECT * FROM ".$_POST['tabla']." WHERE id = $idActual LIMIT 1 ");
				$row1 = mysql_fetch_array($result1);
				mysql_query("UPDATE inscribite_eventos SET fechaord = '20".substr($_POST['fecha'], 6, 2)."m".substr($_POST['fecha'], 3, 2)."d".substr($_POST['fecha'], 0, 2)."' WHERE id = $idActual");
				if ($_POST['codigo'] != $_POST['codigoanterior']) {
					mysql_query('UPDATE inscribite_inscripciones SET nombreevento = "'.$_POST['nombre'].'" WHERE deevento = "'.$_POST['codigoanterior'].'" ');
					mysql_query('UPDATE inscribite_inscripciones SET codevento = "'.$_POST['codigo'].'" WHERE deevento = "'.$_POST['codigoanterior'].'" ');
					mysql_query('UPDATE inscribite_inscripciones SET deevento = "'.$_POST['codigo'].'" WHERE deevento = "'.$_POST['codigoanterior'].'" ');
					mysql_query('UPDATE inscribite_categorias SET deevento = "'.$_POST['codigo'].'" WHERE deevento = "'.$_POST['codigoanterior'].'" ');
				}
				for ($n = 1; $n <= 10; $n++) {
					if ($_POST['opcion'.$n] != '') {
						$result2 = mysql_query('SELECT * FROM inscribite_opciones WHERE id = "'.$_POST['idopcion'.$n].'" LIMIT 1');
						if (mysql_num_rows($result2) == 0) {
							mysql_query($qwe = "INSERT INTO inscribite_opciones (`nombre`, `evento`) VALUES ('".$_POST['opcion'.$n]."', '".$_POST['codigo']."');");
							//echo $qwe.'<br/>'.chr(13);
							mysql_query($qwe = 'UPDATE inscribite_opciones SET cupo = "'.$_POST['cupoopcion'.$n].'" WHERE id = "'.$_POST['idopcion'.$n].'"');
							//echo $qwe.'<br/>'.chr(13);
						} else {
							mysql_query($qwe = 'UPDATE inscribite_opciones SET nombre = "'.$_POST['opcion'.$n].'" WHERE id = "'.$_POST['idopcion'.$n].'"');
							mysql_query($qwe = 'UPDATE inscribite_opciones SET cupo = "'.$_POST['cupoopcion'.$n].'" WHERE id = "'.$_POST['idopcion'.$n].'"');
						}
					}
				}
			}
		}
		foreach ($_POST as $nombrevariable  => $valorvariable) {
			if (($nombrevariable != 'id') && ($nombrevariable != 'tabla') && ($nombrevariable != 'imagen') && (substr($nombrevariable, 0, 11) != 'vencimiento'))
				if ($_POST['tabla'] == 'inscribite_banners') {
					$arrayeventos = Array();
					if ($_POST['areventos'] != '') {
						$arrayeventos = $_POST['areventos'];
						$stringeventos = '';
						foreach ($arrayeventos as $cadaarevento) {
							$stringeventos .= '_'.$cadaarevento.', ';
						}
						if ($stringeventos != '') {
						//  $stringeventos = substr($stringeventos, 0, strlen($stringeventos)-2);
						}
					}
					mysql_query("UPDATE ".$_POST['tabla']." SET eventos = \"".$stringeventos. "\" WHERE id = $idActual");
				}
			if (($nombrevariable != 'tabla') && ($nombrevariable != 'volvera') && ($nombrevariable != 'id'))
				mysql_query("UPDATE ".$_POST['tabla']." SET ".$nombrevariable." = \"".$valorvariable. "\" WHERE id = $idActual");
		}
	}
	if ($_POST['porcentajedescuento'] != '') {
		$result1 = mysql_query('SELECT nombre FROM inscribite_eventos WHERE codigo = "'.agceros($_POST['codevento'],4).'" LIMIT 1 ');
		$row1 = mysql_fetch_array($result1);
		$nombreDelEvento = $row1['nombre'];
		mysql_query('UPDATE inscribite_descuentos SET porcentajedescuento = "'.str_replace('%', '', $_POST['porcentajedescuento']).'" WHERE id = $idActual ');
		$result1 = mysql_query('SELECT email FROM inscribite_usuarios WHERE dni = "'.agceros($_POST['coddni'], 4).'" OR dni = "'.$_POST['coddni'].'" LIMIT 1 ');
		$row1 = mysql_fetch_array($result1);
		
		$msgddesc = 'Dispones de un descuento del '.str_replace('%', '', $_POST['porcentajedescuento']).'% para inscribirte en el evento "'.$nombreDelEvento.'" desde http://www.inscribiteonline.com.ar/';
		$email = $row1['email'];
		$asunto = "Descuento en Inscribite Online";
		$info_adicional = "From: info@inscribiteonline.com.ar\r\nContent-Type: text/html; charset=utf-8\r\n";
		mail($email, $asunto, $msgddesc, $info_adicional);
	}
	// falta hacerlo
	// Solo puede haber UN evento del mes
	if ($_POST['eventodelmes'] == 1) {
		mysql_query("UPDATE inscribite_eventos SET eventodelmes = 0 WHERE eventodelmes = 1");
		mysql_query("UPDATE inscribite_eventos SET eventodelmes = 1 WHERE id = ".$idActual);
	}
	// Las fechas de los vencimientos tienen distintos formatos en los input y en la base
	if (($_POST['vencimiento1'] != "") && ($_POST['vencimiento1'] != "dd/mm/aaaa"))
		mysql_query("UPDATE inscribite_categorias SET vencimiento1 = '".substr($_POST['vencimiento1'], 6, 4)."-".substr($_POST['vencimiento1'], 3, 2)."-".substr($_POST['vencimiento1'], 0, 2)."' WHERE id = $idActual");
	if (($_POST['vencimiento2'] != "") && ($_POST['vencimiento2'] != "dd/mm/aaaa"))
		mysql_query("UPDATE inscribite_categorias SET vencimiento2 = '".substr($_POST['vencimiento2'], 6, 4)."-".substr($_POST['vencimiento2'], 3, 2)."-".substr($_POST['vencimiento2'], 0, 2)."' WHERE id = $idActual");
	if (($_POST['vencimiento3'] != "") && ($_POST['vencimiento3'] != "dd/mm/aaaa"))
		mysql_query("UPDATE inscribite_categorias SET vencimiento3 = '".substr($_POST['vencimiento3'], 6, 4)."-".substr($_POST['vencimiento3'], 3, 2)."-".substr($_POST['vencimiento3'], 0, 2)."' WHERE id = $idActual");
	//
	include "thumb.php";
	$directorio = '../imagenes/';
	// Vuelve del crop

	if ($cuentafiles = '') {
		$cuentafiles = 0;
		$cuentafilesubidos = 0;
	}
	foreach($_FILES as $valalped) {
		$cuentafiles++;
		$procesar = false;
		if (($_FILES['imagen'.$cuentafiles]['name'] != '') || (($cuentafiles == 2) && ($_POST['foto2igualalauno'] == 1))) {
			if ($primeraimgsub == '') $primeraimgsub = $cuentafiles;
			$cuentafilesubidos++;
			$cropear = true;
			$extension = strtolower(substr($_FILES['imagen'.$cuentafiles]['name'], -4, 4));
			$newname = 'file'.$cuentafiles.$extension;
			if ((($_FILES['imagen'.$cuentafiles]['name'] == $ultarchivoname) && ($_FILES['imagen'.$cuentafiles]['size'] == $ultarchivosize)) || (($cuentafiles > 1) && ($_POST['foto2igualalauno'] == 1))) {
				if (file_exists($directorio.'file'.($cuentafiles-1).$extension))
					copy($directorio.'file'.($cuentafiles-1).$extension, $directorio.'file'.$cuentafiles.$extension);
				else
					$cropear = false;
			} else {
				move_uploaded_file($_FILES['imagen'.$cuentafiles]['tmp_name'], $directorio.'file'.$cuentafiles.$extension);
				$ims = getimagesize($directorio.'file'.$cuentafiles.$extension);
				if (($ims[0] == $_POST['width'.$cuentafiles]) && ($ims[1] == $_POST['height'.$cuentafiles])) {
					$newname = strtolower(dechex(time()).$extension);
					mysql_query("UPDATE ".$_POST['tabla']." SET imagen".$cuentafiles." = \"".$newname."\" WHERE id = $idActual");
					rename($directorio.'file'.$cuentafiles.$extension, $directorio.'image_'.$newname);
					$cropear = false;
				}
			}
			$ultarchivoname = $_FILES['imagen'.$cuentafiles]['name'];
			$ultarchivosize = $_FILES['imagen'.$cuentafiles]['size'];
		}
	}
	if ($_POST['croppedimage'] != '') {
		$extension = strtolower(substr($_POST['croppedimage'], -4, 4));
		$newname = strtolower(dechex(time()).$extension);
		mysql_query("UPDATE ".$_POST['tabla']." SET ".$_POST['nombrevar']." = \"".$newname."\" WHERE id = $idActual");
		$ims = getimagesize($_POST['croppedimage']);
		if (($ims[0] == $_POST['finalwidth']) && ($ims[1] == $_POST['finalheight'])) {
			rename($_POST['croppedimage'], $directorio.'image_'.$newname);
		} else {
			$img = imagecreatetruecolor($_POST['zwidth'], $_POST['zheight']);
			$col = imagecolorallocate($img, 239, 239, 239);
			imagefilledrectangle($img, 0, 0, $_POST['zwidth'], $_POST['zheight'], $col);
			if ($extension == '.jpg')
				$org_img = imagecreatefromjpeg($_POST['croppedimage']);
			if ($extension == '.gif')
				$org_img = imagecreatefromgif ($_POST['croppedimage']);
			$margen = intval(intval($_POST['zwidth']-$ims[0])/2);
			if ($margen < 0) $margen = 0;
			$margentop = intval(intval($_POST['zheight']-$ims[1])/2);
			if ($margentop < 0) $margentop = 0;
			imagecopy($img, $org_img, $margen, $margentop, $_POST['ix'], $_POST['iy'], $ims[0], $ims[1]);
			if ($extension == '.jpg') {
				imagejpeg($img, $directorio.$newname, 100);
				thumbjpeg($directorio.$newname, $_POST['finalwidth'], $_POST['finalheight'], 'image_');
			} elseif ($extension == '.gif') {
				imagegif ($img, $directorio.$newname, 100);
				thumbgif ($directorio.$newname, $_POST['finalwidth'], $_POST['finalheight'], 'image_');
			}
			imagedestroy($img);
			copy($directorio.'image_'.$newname, $directorio.$newname);
		}
		//for($n = 1;$n<= 18;$n++) {
		//if ($_POST['thumb'.$n.'width'] != '')thumbjpeg($directorio.$newname, $_POST['thumb'.$n.'width'], $_POST['thumb'.$n.'height'],'thumb_');
		//}
		if ($_POST['thumb'.str_replace('imagen', '', $_POST['nombrevar']).'width'] != '') {
			if ($extension == '.jpg')
			thumbjpeg($directorio.$newname, $_POST['thumb'.str_replace('imagen', '', $_POST['nombrevar']).'width'], $_POST['thumb'.str_replace('imagen', '', $_POST['nombrevar']).'height'], 'thumb_');
			if ($extension == '.gif')
			thumbgif ($directorio.$newname, $_POST['thumb'.str_replace('imagen', '', $_POST['nombrevar']).'width'], $_POST['thumb'.str_replace('imagen', '', $_POST['nombrevar']).'height'], 'thumb_');
		}
		if (file_exists($_POST['croppedimage'])) unlink($_POST['croppedimage']);
		if (file_exists($directorio.$newname))   unlink($directorio.$newname);
	}
	if ($cuentafilesubidos == 0) $cuentafilesubidos = $POST['cantidaddeimagenes'];
	/*
	include("thumb.php");
	$directorio = '../imagenes/';
	if ($_FILES['imagen'] != '') {
		$newnombre = dechex(time()).'.jpg';
		if (move_uploaded_file($_FILES['imagen']['tmp_name'], $directorio.$newnombre)) {
			if ($row1['imagen'] != "")unlink($directorio.'media_'.$row1['imagen']);
			mysql_query ("UPDATE ".$_POST['tabla']." SET imagen = \"".strtolower($newnombre)."\" WHERE id = $idActual");
			chmod($directorio.$newnombre,0777);
			thumbjpeg($directorio.$newnombre,160,120,"media_");
			unlink($directorio.$newnombre);
		}
	}
	if ($_FILES['logo'] != '') {
		$newnombre = dechex((time()+1)).'.jpg';
		if (move_uploaded_file($_FILES['logo']['tmp_name'], $directorio.$newnombre)) {
			if ($row1['logo'] != "") unlink($directorio.'logo_'.$row1['logo']);
			mysql_query("UPDATE ".$_POST['tabla']." SET logo = \"".strtolower($newnombre)."\" WHERE id = $idActual");
			chmod($directorio.$newnombre,0777);
			thumbjpeg($directorio.$newnombre,160,120,"logo_");
			unlink($directorio.$newnombre);
		}
	}
	*/
	$nroimgen = $primeraimgsub;
	if ($_POST['nextimage'] != '') {
		$cropear  = true;
		$newname  = 'file'.$_POST['nextimage'].'.jpg';
		$nroimgen = $_POST['nextimage'];
	}
	if ($cropear) {
		$result1 = mysql_query('SELECT imagen'.$nroimgen.' FROM `'.$_POST['tabla'].'` WHERE id = '.$idActual.' LIMIT 1 ');
		if (is_resource($result1)) {
			$row1 = mysql_fetch_array($result1);
			if (file_exists($directorio.'image_'.$row1['imagen'.$nroimgen])) unlink($directorio.'image_'.$row1['imagen'.$nroimgen]);
		}
		chmod($directorio.$newname, 0777);
		$datos = getimagesize($directorio.$newname);
		$vaatenerdeanchoantes = $datos[0];
		$vaatenerdealtoantes = $datos[1];
		if ($datos[0] < $_POST['width'.$nroimgen]) {
			$redimensionarantes = true;
			$rantesxcero = $_POST['width'.$nroimgen];
			$rantesycero = 0;
			$radiopa = ($vaatenerdeanchoantes/$rantesxcero);
			$vaatenerdealtoantes = round($vaatenerdealtoantes/$radiopa);
		}
		if ($datos[1] < $_POST['height'.$nroimgen]) {
			$redimensionarantes = true;
			$rantesxcero = 0;
			$rantesycero = $_POST['height'.$nroimgen];
			$radiopa = ($vaatenerdealtoantes/$rantesycero);
			$vaatenerdeanchoantes = round($vaatenerdeanchoantes/$radiopa);
		}
		if ($vaatenerdeanchoantes > 1000) {
			$redimensionarantes = true;
			$rantesxcero = 1000;
			$rantesycero = 0;
			$radiopa = ($vaatenerdeanchoantes/$rantesxcero);
			$vaatenerdealtoantes = round($vaatenerdealtoantes/$radiopa);
		}
		if (($vaatenerdealtoantes > 650) && ($vaatenerdealtoantes > $vaatenerdeanchoantes)) {
			$redimensionarantes = true;
			$rantesxcero = 0;
			$rantesycero = 650;
		}
		if ($redimensionarantes) {
			$extension = strtolower(substr($newname, -4, 4));
			if ($extension == '.jpg') {
				thumbjpeg($directorio.$newname, $rantesxcero, $rantesycero,"t_");
			} else {
				thumbgif ($directorio.$newname, $rantesxcero, $rantesycero,"t_");
			}
			unlink($directorio.$newname);
			rename($directorio.'t_'.$newname, $directorio.$newname);
		}
		$datos = getimagesize($directorio.$newname);
		//$extension = '.jpg';
		//if (!(file_exists($directorio.'file'.$nroimgen.'.jpg'))) $extension = '.gif';
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
<head>
	<title>Crop Image</title>
	<meta name="robots" content="noindex,nofollow"/>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<style type="text/css">
	html, body{
		margin:0px;
		padding:0px;
	}
	</style>
	<script type="text/javascript" src="js/dom-drag.js"></script>
</head>
<body <?php /*onmouseup="soltarm();" */ ?>>
<form action="guardar.php" method="post">
	<div>
		<input type="submit" value="Enviar"/>
		<input type="hidden" name="id" value="<?=$idActual?>"/>
		<input type="hidden" name="tabla" value="<?=$_POST['tabla']?>"/>
		<input type="hidden" name="nombrevar" value="imagen<?=$nroimgen?>"/>
		<input type="hidden" name="volvera" value="<?=$_POST['volvera']?>"/>
		<input type="hidden" name="ix" id="ix" value="0"/>
		<input type="hidden" name="iy" id="iy" value="0"/>
		<input type="hidden" name="cantidaddeimagenes" value="<?=$cuentafilesubidos?>"/>
<?	if ($nroimgen < $cuentafilesubidos) { ?>
	<input type="hidden" name="nextimage" value="<?=($nroimgen+1)?>"/>
<?	} ?>
	<input type="hidden" name="widthinicial" value="<?=$datos[0]?>"/>
	<input type="hidden" name="width2" value="<?=$_POST['width2']?>"/>
	<input type="hidden" name="height2" value="<?=$_POST['height2']?>"/>
	<input type="hidden" id="zwidth" name="zwidth" value="<?=$_POST['width'.$nroimgen]?>"/>
	<input type="hidden" id="zheight" name="zheight" value="<?=$_POST['height'.$nroimgen]?>"/>
	<input type="hidden" name="finalwidth" value="<?=$_POST['width'.$nroimgen]?>"/>
	<input type="hidden" name="finalheight" value="<?=$_POST['height'.$nroimgen]?>"/>
	<input type="hidden" name="croppedimage" value="<?=$directorio.'file'.$nroimgen.$extension?>"/>
<?	for($n = 1; $n <= 18; $n++) {
		if ($_POST['thumb'.$n.'width'] != '') { ?>
		<input type="hidden" name="thumb<?=$n?>width" value="<?=$_POST['thumb'.$n.'width']?>"/>
		<input type="hidden" name="thumb<?=$n?>height" value="<?=$_POST['thumb'.$n.'height']?>"/>
<?		}
	} ?>
	</div>
	<div style="height:<?=$_POST['height'.$nroimgen]?>px;">
	<img src="<?=$directorio.'file'.$nroimgen.$extension?>?rand = <?=rand()?>" alt="" style="position:absolute;z-index:0;"/>
	<img src="images/nada.gif" id="manij" alt="" style="position:absolute;top:22px;display:block;border:1px red solid;width:<?=($_POST['width'.$nroimgen]-2)?>px;height:<?=($_POST['height'.$nroimgen]-2)?>px;cursor:move;z-index:2;"/>
	<img src="images/arrow_fat_right.gif" alt="cambiar tamaño" title="Cambiar Tamaño" id="agrand" style="position:absolute;display:block;left:<?=$_POST['width'.$nroimgen]?>px;top:<?=($_POST['height'.$nroimgen]+22)?>px;z-index:3;cursor:se-resize;"/>
	</div>
	</form>
<script type="text/javascript">
<!--
function soltarm() {
	document.getElementById('agrand').style.top = ((document.getElementById('manij').style.top.replace('px', '')*1)+(document.getElementById('manij').style.height.replace('px', '')*1)+2)+'px'
	document.getElementById('agrand').style.left = ((document.getElementById('manij').style.left.replace('px', '')*1)+(document.getElementById('manij').style.width.replace('px', '')*1)+2)+'px'
}
anchurainicial = <?=$_POST['width'.$nroimgen]?>;
alturainicial = <?=$_POST['height'.$nroimgen]?>;
document.getElementById("ix").value = 0;
document.getElementById("iy").value = 0;
Drag.init(document.getElementById("manij"),null,0,<?=$datos[0]?>,22,<?=(($datos[1]-$_POST['height'.$nroimgen])+22)?>);
Drag.init(document.getElementById("agrand"),null,<?=$_POST['height'.$nroimgen]?>,1000,-<?=$_POST['width'.$nroimgen]?>,1000);
-->
</script>
</body>
</html>
<?	} else { ?>
<script type="text/javascript">
<!--
	location.href = './?sec=<?=str_replace("idcreada", $idActual, str_replace('amp;', '&', $_POST['volvera']))?>';
-->
</script>
<a href="./?sec=<?=str_replace('amp;', '&', $_POST['volvera'])?>">Volver</a>
<?	}
	if (is_resource($result1)) mysql_free_result($result1);
	if (is_resource($result2)) mysql_free_result($result2);
	if (is_resource($result3)) mysql_free_result($result3);
	mysql_close();
?>