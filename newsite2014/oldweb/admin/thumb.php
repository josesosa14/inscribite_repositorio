<?
function thumbjpeg($imagen, $anchura, $altura, $prefijo_thumb){
//$dir_thumb="";
$camino_nombre = explode("/", $imagen);
$nombre = end($camino_nombre);
$camino = substr($imagen,0,strlen($imagen)-strlen($nombre));
//if (!file_exists($camino.$dir_thumb))
//mkdir ($camino.$dir_thumb, 0777) or die("No se ha podido crear el directorio $dir_thumb");
$img = imagecreatefromjpeg($camino.$nombre);
$datos = getimagesize($camino.$nombre);
/*
if ($altura == 0){
	if ($datos[0]>$datos[1]){
		$altura = $anchura;
		$anchura = 0;
	}
}else{
	if ($anchura == 0){
		if ($datos[1]>$datos[0]){
			$anchura = $altura;
			$altura = 0;
		}
	}
}
*/
if ($altura == 0){
	$ratio = ($datos[0]/$anchura);
	$altura = round($datos[1]/$ratio);
}
if ($anchura == 0){
	$ratio = ($datos[1]/$altura);
	$anchura = round($datos[0]/$ratio);
}
$thumb = imagecreatetruecolor($anchura, $altura);
imagecopyresampled($thumb, $img,0,0,0,0, $anchura, $altura, $datos[0], $datos[1]);
imagejpeg($thumb, $camino.$dir_thumb.$prefijo_thumb.strtolower($nombre));
chmod($camino.$dir_thumb.$prefijo_thumb.$nombre,0777);
}

function thumbgif ($imagen, $anchura, $altura, $prefijo_thumb){
//$dir_thumb = "";
$camino_nombre = explode("/", $imagen);
$nombre = end($camino_nombre);
$camino = substr($imagen,0,strlen($imagen)-strlen($nombre));
//if (!file_exists($camino.$dir_thumb))
//mkdir ($camino.$dir_thumb, 0777) or die("No se ha podido crear el directorio $dir_thumb");
$img = imagecreatefromgif ($camino.$nombre);
$datos = getimagesize($camino.$nombre);
/*
if ($altura == 0){
	if ($datos[0]>$datos[1]){
		$altura = $anchura;
		$anchura = 0;
	}
}else{
	if ($anchura == 0){
		if ($datos[1]>$datos[0]){
			$anchura = $altura;
			$altura = 0;
		}
	}
}
*/
if ($altura == 0){
	$ratio = ($datos[0]/$anchura);
	$altura = round($datos[1]/$ratio);
}
if ($anchura == 0){
	$ratio = ($datos[1]/$altura);
	$anchura = round($datos[0]/$ratio);
}
$thumb = imagecreatetruecolor($anchura, $altura);
imagecopyresampled($thumb, $img,0,0,0,0, $anchura, $altura, $datos[0], $datos[1]);
imagegif ($thumb, $camino.$dir_thumb.$prefijo_thumb.strtolower($nombre));
chmod($camino.$dir_thumb.$prefijo_thumb.$nombre,0777);
}
?>
