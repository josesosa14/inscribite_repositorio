<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

function getRowQuery($query, $link) {
    $row = null;
    $result = $link->query($query, MYSQLI_USE_RESULT);
    if ($result) {
        $row = $result->fetch_array(MYSQLI_ASSOC);
    }
    return $row;
}

function login($information, $fbid = false) {
    $_SESSION['nombre'] = $information['nombre'];
    $_SESSION['telefono'] = ($information['telefono']) ? $information['telefono'] : "";
    $_SESSION['email'] = $information['email'];
    $_SESSION['provincia'] = ($information['provincia']) ? $information['provincia'] : "";
    $_SESSION['localidad'] = ($information['localidad']) ? $information['barrio'] : "";
    $_SESSION['barrio'] = ($information['barrio']) ? $information['barrio'] : "";
    $_SESSION['user_id'] = $information['id'];
    $_SESSION['horario_entrega'] = ($information['horario_entrega']) ? $information['horario_entrega'] : "";
    $_SESSION['precio_alto'] = $information['precio_alto'];
    $_SESSION['direccion'] = ($information['direccion']) ? $information['direccion'] : "";

    if ($fbid) {
        $_SESSION['fbid'] = $fbid;
    }
    setcookie("wine_hash_id", md5($information['id']), time() + (10 * 365 * 24 * 60 * 60));  /* expira en una hora */
    setcookie("wine_dias", $information['id'], time() + (10 * 365 * 24 * 60 * 60));
}

function redirect($url) {
    header("Location:" . $url);
}

function muestraString($str) {
    return (isset($str)) ? $str : "";
}

function esInvitado() {
    if (isset($_SESSION['activo']) && $_SESSION['activo'] == 0) {
        return true;
    } else {
        return false;
    }
}

function cargaDatosUsuario($colores, $link) {
    $user_info['tabla'] = "";
    $user_info['user_id'] = $_SESSION['user_id'];
    if (!esInvitado()) {
        $user_info['nombre'] = $_SESSION['nombre'];
        $user_info['email'] = $_SESSION['email'];
        $user_info['telefono'] = isset($_SESSION['telefono']) ? $_SESSION['telefono'] : "";
        $user_info['horario_entrega'] = isset($_SESSION['horario_entrega']) ? $_SESSION['horario_entrega'] : "";
        $user_info['direccion'] = isset($_SESSION['direccion']) ? $_SESSION['direccion'] : "";
        $user_info['barrio'] = isset($_SESSION['barrio']) ? $_SESSION['barrio'] : "";
        $user_info['precio_alto'] = $_SESSION['precio_alto'];
    }
    $query = "SELECT *,
                (select count(*) from compras where ok<>1 and consumidor = user.id) as pedidos_en_camino,
                (select count(*) from vinosconsumidos where consumidor = user.id and calidad = 0 and preciobeneficio = 0) as vinos_a_calificar
                FROM users user
                INNER JOIN user_descriptores ud ON ud.id = user.id
                INNER JOIN user_habitos_consumo uc ON uc.id = user.id
                WHERE user.id = {$user_info['user_id']}";
    $usuario = getRowQuery($query, $link);
    $user_info['pedidos_en_camino'] = $usuario['pedidos_en_camino'];
    $user_info['vinos_a_calificar'] = $usuario['vinos_a_calificar'];
    unset($usuario['pedidos_en_camino']);
    unset($usuario['vinos_a_calificar']);
    unset($usuario['nombre']);
    unset($usuario['id']);
    unset($usuario['fbid']);
    unset($usuario['fbuser']);
    unset($usuario['direccion']);
    unset($usuario['barrio']);
    unset($usuario['localidad']);
    unset($usuario['provincia']);
    unset($usuario['horario_entrega']);
    unset($usuario['direccion_secundaria']);
    unset($usuario['email']);
    unset($usuario['clave']);
    unset($usuario['telefono']);

    $_SESSION['mi_wine'] = "";
    $cuentan = 0;
    $cont = 0;
    if ($usuario) {
        foreach ($usuario as $valor_tag) {
            if ($valor_tag > 0 && $valor_tag < 100) {
                if ($cuentan == 0) {
                    $_SESSION['mi_wine'] .= "{value: '" . $valor_tag . "', color: '" . $colores[$cont] . "'}";
                } else {
                    $_SESSION['mi_wine'] .= ",{value: '" . $valor_tag . "', color: '" . $colores[$cont] . "'}";
                }
                $cuentan++;
            }
            $cont++;
        }
    }
    return $user_info;
}

function validaAcceso() {
    //corte
    if (!isset($_SESSION['user_id']) && !isset($_SESSION['user_prov_id'])) {
        header('Location:logout.php');
    }
}



function crearUsuario($datos_user, $user_prov_id, $link) {
    $clave = crearPassword();
    $_SESSION['nombre'] = $datos_user['nombre'];
    $_SESSION['telefono'] = ($datos_user['telefono']) ? $datos_user['telefono'] : "";
    $_SESSION['email'] = $datos_user['email'];
    $_SESSION['barrio'] = ($datos_user['localidad']) ? $datos_user['localidad'] : "";
    $_SESSION['horario_entrega'] = ($datos_user['horario']) ? $datos_user['horario'] : "";
    $_SESSION['direccion'] = ($datos_user['direccion']) ? $datos_user['direccion'] : "";
    $_SESSION['activo'] = 1;

    $query = "UPDATE users SET nombre='{$_SESSION['nombre']}',email='{$_SESSION['email']}',"
            . "clave='$clave',horario_entrega='{$_SESSION['horario_entrega']}',direccion='{$_SESSION['direccion']}',barrio='{$_SESSION['barrio']}',"
            . "telefono='{$_SESSION['telefono']}',activo=1 where id = $user_prov_id";
    runQuery($query, $link);

    $mensaje = "Estimado/a, \r\n Su cuenta de wine id ha sido creada. \r\n Email:{$datos_user['email']} Password:$clave \r\n Esperamos que disfrute la experiencia.";
    manda_mail($datos_user['email'], $datos_user['email'], $mensaje, "Wine id - Bienvenido");
    return $user_prov_id;
}

function cargaVinos($link) {
    $array_vinos = array();
    if (!isset($_SESSION['string_vinos'])) {
        $query = "SELECT nombre,id,variedad,sin_wineid FROM vinos_ficha WHERE precio > 0";
        $array_vinos = getArrayQuery($query, $link);
        $_SESSION['string_vinos'] = "";
        foreach ($array_vinos as $key => $ficha_vino):
            if ((count($array_vinos) - 1 != $key)) {
                $_SESSION['string_vinos'] .= "{value: '" . ($ficha_vino['nombre']) . " " . $ficha_vino['variedad'] . "', data: '" . $ficha_vino['id'] . "'},";
            } else {
                $_SESSION['string_vinos'] .= "{value: '" . ($ficha_vino['nombre']) . " " . $ficha_vino['variedad'] . "', data: '" . $ficha_vino['id'] . "'}";
            }
        endforeach;
    }
    return $array_vinos;
}

function getArrayQuery($query, $link) {
    $rows = null;
    $result = $link->query($query, MYSQLI_USE_RESULT);
    if ($result) {
        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $rows[] = $row;
        }
    }
    return $rows;
}

function runQuery($query, $link) {

    $link->query($query);

    if (!$link->error) {
        return true;
    } else {
        return false;
    }
}

function runMultipleQuery($query, $link) {

    $link->multi_query($query);

    if (!$link->error) {
        return true;
    } else {
        return false;
    }
}

function parseValuesInsert($fields, $parameters) {

//definiciones
    $values = "";
    $cont = 0;
    $array_fields = explode(',', $fields);


    foreach ($array_fields as $field) {
        foreach ($parameters as $name_parameter => $value_parameter) {
            if ($field == $name_parameter) {
                if ($cont == 0) {
                    $values .= "('" . (($value_parameter || $value_parameter == 0) ? $value_parameter : "") . "'";
                } else {
                    $values .= ",'" . (($value_parameter || $value_parameter == 0) ? $value_parameter : "") . "'";
                }
                $cont++;
                break;
            }
        }
    }
    if (!empty($array_fields)) {
        $values .= ')';
    }
    return $values;
}

function parseTableSchema($tabla, $mysqli, $base) {
    $dbname = $base;
    $key = 0;

    $fields = getArrayQuery('SELECT column_name FROM information_schema.columns where table_name = "' . $tabla . '" and table_schema = "' . $dbname . '" and column_key != "PRI" AND data_type != "timestamp" ', $mysqli);

    //echo '<pre>';print_r($fields);die;
    foreach ($fields as $field) {
        if ($key == 0) {
            $data = $field['column_name'];
        } else {
            $data .= ',' . $field['column_name'];
        }
        $key++;
    }

    return (($data) ? $data : "");
}

function lowerParameters($parameters) {
    $data = null;
    if ($parameters) {
        foreach ($parameters as $key => $each) {
            if (is_array($each)) {
                $data[$key] = lowerParameters($each);
            } else {
                $data[$key] = strtolower($each);
            }
        }
    }
    return $data;
}

function parseValuesInsertArray($fields, $parameters) {

    //definiciones
    $values = "";
    $array_fields = explode(',', $fields);
    $key = 0;

    foreach ($parameters as $array_parameter) {
        if ($key != 0) {
            $values .= ',(';
        } else {
            $values .= '(';
        }
        $key++;

        $cont = 0;
        foreach ($array_fields as $field) {
            foreach ($array_parameter as $name_parameter => $value_parameter) {
                if ($field == $name_parameter) {
                    if ($cont == 0) {
                        $values .= "'" . $value_parameter . "'";
                    } else {
                        $values .= ",'" . $value_parameter . "'";
                    }
                }
            }
            $cont++;
        }
        $values .= ')';
    }
    return $values;
}



function insertRow($tabla, $parameters, $mysqli, $fields = null) {
    $parameters = lowerParameters($parameters);
    if (!$fields) {
        $fields = parseTableSchema($tabla, $mysqli, 'alan2_WineId');
    }

    //parseamos los parametros
    $values = parseValuesInsert($fields, $parameters);

    $query = "INSERT INTO $tabla ($fields) VALUES $values";
    $request = $mysqli->query($query);


    if (!$mysqli->error) {
        //die('inserción correcta');
    } else {
        echo $query . '<br>';
        echo $mysqli->error;
        die('Ha ocurrido un error, por favor intente mas tarde');
    }
}

