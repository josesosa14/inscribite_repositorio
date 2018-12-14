<?php 

session_start();
session_unset();
session_destroy();
header('Location:http://www.arg-it.com/inscribite/empresas/index.php');