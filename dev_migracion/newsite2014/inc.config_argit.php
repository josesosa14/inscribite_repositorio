<?php
define('ENVIRONMENT', 'development');
//define('ENVIRONMENT', 'production');
if (ENVIRONMENT == "production") {
    error_reporting(0);
} else {
    //error_reporting(-1);
    error_reporting(E_ALL ^ E_NOTICE);
}

date_default_timezone_set('America/Argentina/Buenos_Aires');
$dbuser = "inscribite_user";
$dbpassword = "tIvxBjA3"; 
//$dbuser = "root";
//$dbpassword = "";
$dbhost = "localhost";
$dbname = "inscribite_base";
$mysqli = new mysqli($dbhost, $dbuser, $dbpassword, $dbname);
$general_path = base_url();
$unirse_path = base_url() . "/unirse.php";
define("pftables", "inscribite_");
define("localPass", "nqvcwenj872k1ui202gg4ff27xjb");
define("emaildeconsulta", "consultas@inscribiteonline.com.ar");
$smtpHost = '';
$smtpPuerto = '';
$smtpUsername = '';
$smtpPassword = '';

function base_url() {
    $path="http://www.inscribiteonline.com.ar/dev_migracion/newsite2014/argit/";
    //$path = 'http://localhost/inscribite_old/newsite2014/argit/';
    return $path;
}
function base_root(){
    $path="http://www.inscribiteonline.com.ar/dev_migracion/newsite2014/";
    //$path = 'http://localhost/inscribite_old/newsite2014/';
    return $path;
}