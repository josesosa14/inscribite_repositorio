<? date_default_timezone_set('America/Argentina/Buenos_Aires');
if ($_SERVER['HTTP_HOST'] == 'localhost') {
	$coneccion = mysql_connect("localhost", "root", "");
	mysql_select_db("inscribite_base", $coneccion);
	define("url", "http://localhost/inscribite/");
} else {
        $coneccion = mysql_connect("localhost", "inscribite_user", "iW7zNKpRWkSHHwplBhUO");
	mysql_select_db("inscribite_base", $coneccion);
	define("url", "http://www.inscribiteonline.com.ar/");
}

define("pftables", "inscribite_");
define("localPass", "");

define("emaildeconsulta", "consultas@inscribiteonline.com.ar");

$smtpHost = '';
$smtpPuerto = '';
$smtpUsername = '';
$smtpPassword = '';
?>