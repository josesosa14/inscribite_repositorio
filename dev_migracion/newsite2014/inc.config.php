<?php  
date_default_timezone_set('America/Argentina/Buenos_Aires');

$dbuser = "inscribite_user";
$dbpassword = "tIvxBjA3";
//$dbuser = "root";
//$dbpassword = "";
$dbhost = "localhost";
$dbname = "inscribite_base";

$coneccion = mysql_connect($dbhost, $dbuser, $dbpassword);
mysql_select_db($dbname, $coneccion);
define("url", "http://www.inscribiteonline.com.ar/dev_migracion/");
//define("url", "http://localhost/inscribite_old/");


define("pftables", "inscribite_");
define("localPass", $dbpassword);

define("emaildeconsulta", "info@inscribiteonline.com.ar");

$smtpHost = '';
$smtpPuerto = '';
$smtpUsername = '';
$smtpPassword = '';
