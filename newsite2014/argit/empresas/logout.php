<?php 

$general_path = "http:/127.0.0.1/";

session_start();
session_unset();
session_destroy();
header('Location:'.$general_path.'empresas/index.php');