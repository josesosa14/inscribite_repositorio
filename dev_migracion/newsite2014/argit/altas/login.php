<?php

require_once dirname(__FILE__) . '/../general/db.php';

if ($_POST && !isset($_SESSION['usuario'])) {
    //parceamos y traemos info del user
    $dni = addslashes(filter_input(INPUT_POST, 'usuario'));
    $query = "SELECT password,id,email FROM inscribite_usuarios WHERE dni = '$dni'";
    $user_info = getRowQuery($query, $mysqli);

    if ($user_info) {
        if ($user_info['password'] == $_POST['pass']) {
            $_SESSION['usuario'] = $dni;
            $_SESSION['user_id'] = $user_info['id'];
            $_SESSION['user_mail'] = $user_info['email'];

            if ($_POST['evento']) {
                $evento = filter_input(INPUT_POST, 'evento');
                header('Location:' . $general_path . 'iniciainscripccion.php?evento=' . $evento . '#toShow');
            } else {
                header('Location:' . $general_path . 'pagar.php#toShow');
            }
        } else {
            header('Location:' . $general_path . 'login.php?dni=' . $dni);
        }
    } else {
        header('Location:' . $general_path . 'unirse.php?dni=' . $dni . '');
    }
}
