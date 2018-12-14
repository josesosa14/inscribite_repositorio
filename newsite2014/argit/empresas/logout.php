<?php 

$general_path = "http://www.inscribiteonline.com.ar/";

session_start();
session_unset();
session_destroy();
header('Location:'.$general_path.'empresas/index.php');