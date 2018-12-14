<?php  
date_default_timezone_set('America/Argentina/Buenos_Aires');

$dbuser = "root";
$dbpassword = "";
$dbhost = "localhost";
$dbname = "inscribite_base";

$coneccion = mysqli_connect($dbhost, $dbuser, $dbpassword,$dbname);
define("url", "");
define("pftables", "inscribite_");
define("localPass", $dbpassword);
define("emaildeconsulta", "info@inscribiteonline.com.ar");

$smtpHost = '';
$smtpPuerto = '';
$smtpUsername = '';
$smtpPassword = '';

session_start();