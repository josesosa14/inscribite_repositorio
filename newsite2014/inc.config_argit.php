<?php
error_reporting(0);
date_default_timezone_set('America/Argentina/Buenos_Aires');
$dbuser = "ktkkbfac";
$dbpassword = "3Jo8Ngd00l";
$dbhost = "localhost";
$dbname = "inscribite_base";
$mysqli = new mysqli($dbhost, $dbuser, $dbpassword, $dbname);
$general_path = "http://inscribitetest.rhind.com.ar";
$unirse_path = $general_path."unirse.php";
define("pftables", "inscribite_");
define("localPass", "nqvcwenj872k1ui202gg4ff27xjb");
define("emaildeconsulta", "consultas@inscribiteonline.com.ar");
$smtpHost = '';
$smtpPuerto = '';
$smtpUsername = '';
$smtpPassword = '';
