<?php
require_once dirname(__FILE__) . '/../argit/general/db.php';

if ($_POST && !isset($_SESSION['empresa'])) {
    //parceamos y traemos info del user
    $empresa = addslashes(filter_input(INPUT_POST, 'usuario'));
    $password = addslashes(filter_input(INPUT_POST, 'password'));
    $query = "SELECT emp_password,emp_id,emp_nombre FROM empresa WHERE emp_usuario = '$empresa'";
    $empresa_info = getRowQuery($query, $mysqli);

    if ($empresa_info) {
        if ($empresa_info['emp_password'] == $password) {
            $_SESSION['empresa'] = $empresa_info['emp_id'];
            $_SESSION['empresa_nombre'] = $empresa_info['emp_nombre'];
            header('Location:http://www.arg-it.com/inscribite/empresas/empresa.php');
        } else {
            header('Location:http://www.arg-it.com/inscribite/empresas/index.php');
        }
    }else {
        header('Location:' . $general_path . 'empresa.php');
    }
}
elseif (isset($_SESSION['empresa'])){
    header('Location:http://www.arg-it.com/inscribite/empresas/empresa.php');
}
