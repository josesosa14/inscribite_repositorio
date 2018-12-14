<?	date_default_timezone_set('America/Argentina/Buenos_Aires');
	if (!headers_sent())
		header ('Content-type: text/html; charset=utf-8');
	 
	if ($_SERVER['HTTP_HOST'] == 'localhost') {
		$coneccion = mysql_connect("localhost", "root", "");
		mysql_select_db("", $coneccion);
		define("url", "http://localhost/_/");
	} else {
		$coneccion = mysql_connect("localhost", "maritimopr_user", "b9jwCS9WrvFzGOkKT4a9");
		mysql_select_db("maritimopr_maritimopro", $coneccion);
		define("url", "http://maritimopro.com.ar/");
	}

	define("pftables", "maritimopro_");
	define("localPass", "asldkj7127sadh");
	define("adminfolder", "pagofacil");

	
	$ararremplazar = Array('  ', ' ', '/', 'á', 'é', 'í', 'ó', 'ú', 'Á', 'É', 'Í', 'Ó', 'Ú', 'ñ', 'Ñ', 'ö', 'ü', '¿', '?', '¡', '!', 'º', '"', "'", '“', '”', '«', '»', '´', ':', ',', 'û', 'ê');
	$arreemplazos =  Array(' ',  '_', '',  'a', 'e', 'i', 'o', 'u', 'a', 'e', 'i', 'o', 'u', 'n', 'n', 'o', 'u', '',  '',  '',  '',  '',  '',  '',  '',  '',  '',  '',  '_', '',  '',  'u', 'e');

?>