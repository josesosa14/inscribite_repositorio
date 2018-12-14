<?	date_default_timezone_set('America/Argentina/Buenos_Aires');
	if (!headers_sent())
		header ('Content-type: text/html;charset=utf-8');
	if ($_SERVER['HTTP_HOST'] == 'localhost') {
		if (!($no_conectar)) {
			$coneccion = mysql_connect("localhost", "root", "");
			mysql_select_db("motivarte", $coneccion);
		}
		define("url", "http://localhost/inscribite/");
	} else {
		if (!($no_conectar)) {
			$coneccion = mysql_connect("localhost", "inscribite_user", "iW7zNKpRWkSHHwplBhUO");
			mysql_select_db("inscribite_base", $coneccion);
		}
		define("url", "http://www.inscribiteonline.com.ar/2013/");
	}
	define("pftables", "inscribite_");
	define("localPass", "aslkjasd6asdmczx");
	$ararremplazar = Array('	', ' ', '/', 'á', 'é', 'í', 'ó', 'ú', 'Á', 'É', 'Í', 'Ó', 'Ú', 'ñ', 'Ñ', 'ö', 'ü', '¿', '?', '¡', '!', 'º', '"', "'", '“', '”', '«', '»', '´', ':', ',', 'û', 'ê');
	$arreemplazos =	Array(' ',	'_', '',	'a', 'e', 'i', 'o', 'u', 'a', 'e', 'i', 'o', 'u', 'n', 'n', 'o', 'u', '',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'_', '',	'',	'u', 'e')?>