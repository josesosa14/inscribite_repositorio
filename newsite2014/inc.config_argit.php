<?php
error_reporting(0);
date_default_timezone_set('America/Argentina/Buenos_Aires');
$dbuser = "ktkkbfac_inscribite_usuario";
$dbpassword = "lizardking";
$dbhost = "localhost";
$dbname = "ktkkbfac_inscribite_base";
$mysqli = new mysqli($dbhost, $dbuser, $dbpassword, $dbname);

$general_path = "http://127.0.01:88/inscribite_repositorio";
$unirse_path = $general_path."unirse.php";
define("pftables", "inscribite_");
define("localPass", "nqvcwenj872k1ui202gg4ff27xjb");
define("emaildeconsulta", "consultas@inscribiteonline.com.ar");
$smtpHost = '';
$smtpPuerto = '';
$smtpUsername = '';
$smtpPassword = '';

if ($mysqli->connect_error) {
    die('Error de Conexión (' . $mysqli->connect_errno . ') '
            . $mysqli->connect_error);
}
?>
