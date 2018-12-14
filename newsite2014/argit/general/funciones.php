<?php

function getArrayQuery($query, $mysqli) {
    $rows = null;
//execute the query.
    $result = $mysqli->query($query, MYSQLI_USE_RESULT);
    if ($result) {
        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $rows[] = $row;
        }
    }
    return $rows;
}

function emailConAsterisco($mail) {
    $info_email = explode('@', $mail);
    $letra_1 = substr($info_email[0], 0, 1);
    $letra_2 = substr($info_email[0], strlen($info_email[0]) - 1, 1);
    $email_final = $letra_1 . str_repeat('*', strlen($info_email[0]) - 2) . $letra_2 . '@' . $info_email[1];
    return $email_final;
}

function mailDeUsuario($dni, $mysqli) {
    $query = 'SELECT nombre,apellido,password,email FROM inscribite_usuarios WHERE dni = ' . $dni;
    $user_info = getRowQuery($query, $mysqli);
    return $user_info['email'];
}

function showCheck($field,$value){
    if(isset($field) && $field == $value){
        return "checked='true'";
    }
    else{
        return "";
    }
}

function eventoDeLaEmpresa($evento, $mysqli) {
    $query = "SELECT id FROM inscribite_eventos WHERE codigo = $evento AND empresa='{$_SESSION['empresa_nombre']}'";
    $result = getRowQuery($query, $mysqli);
    if ($result) {
        return true;
    } else {
        return false;
    }
}

function sumoInscripcion($opcion, $mysqli) {
    $mysqli->query("UPDATE inscribite_opciones SET cuporestante = cuporestante-1 WHERE id = $opcion");
}

function usuarioRegistrado($parameters, $mysqli) {
    $dni = addslashes($parameters['dni']);
    $data = getRowQuery("SELECT * FROM inscribite_usuarios WHERE dni = '$dni'", $mysqli);

    if ($data) {
        return true;
    } else {
        return false;
    }
}

function esAdmin(){
 if($_SESSION['usuario'] == 36791591){
	return true;
 }
 else{
	return false;
 }
}

function getRowQuery($query, $mysqli) {
    $row = null;

//execute the query.
    $result = $mysqli->query($query, MYSQLI_USE_RESULT);

    if ($result) {
        $row = $result->fetch_array(MYSQLI_ASSOC);
    }
    return $row;
}

function insertaPMC($mysqli,$mec_id = 0,$medio = 0) {
	global $user_id;
	//si viene por mensualidades, solo poco valores importes mr white
	if($mec_id){
		$query = "SELECT * FROM mensualidad_cuotas INNER JOIN mensualidades ON men_id=mec_men_id WHERE mec_id = $mec_id";
		$data = getRowQuery($query,$mysqli);
		$evento = 0;
		$cat = 0;
		$opcion = 0;
		$categoria['fechavenc1'] = $data['mec_venc_1'];
		$categoria['fechavenc2'] = $data['mec_venc_2'];
		$categoria['fechavenc3'] = $data['mec_venc_3'];
		$precio1 = $data['mec_imp_1'];
		$precio2 = $data['mec_imp_2'];
		$precio3 = $data['mec_imp_3'];
		$hoy = date('Y-m-d');
		if ($data['mec_venc_3'] < $hoy){
			$punitorio =  $data['mec_imp_3']*$data['men_punitorio'];
			$precio3 = $precio3+$punitorio;
		}
		
		$fecha_in = date('Y-m-d h:i:s');
		if($medio == 'pmc'){
			$tipo = 1;
		}
		elseif($medio == 'pf'){
			$tipo = 2;
		}elseif($medio == 'rp'){
			$tipo = 3;
		}else{
		$tipo = 1;
		}
		
		$query = "SELECT meu_men_id FROM mensualidad_usuario WHERE meu_u_dni = {$_SESSION['usuario']} AND meu_men_id = {$data['mec_men_id']}";
		$tieneMensualidad = getRowQuery($query,$mysqli);
		if(!$tieneMensualidad){
			$parameters['meu_men_id'] = $data['mec_men_id'];
			$parameters['meu_u_dni'] = $_SESSION['usuario'];
			$parameters['meu_fecha_in'] = date('Y-m-d h:i:s');
			insertRow('mensualidad_usuario',$parameters,$mysqli);
		}
		
	}else{
		//filtramos
		$tipo = 0;
		$evento = filter_input(INPUT_POST, "evento");
		$cat = filter_input(INPUT_POST, "cod");
		$opcion = filter_input(INPUT_POST, "opcion_id");
		
		$categoria = getRowQuery("SELECT * FROM inscribite_categorias WHERE deevento = '$evento' AND codigo = '$cat' LIMIT 1 ", $mysqli);

		$descuento = getRowQuery("SELECT * FROM inscribite_descuentos WHERE coddni = '{$_SESSION['usuario']}' AND codevento = '$evento' ", $mysqli);
		if ($descuento['porcentajedescuento']) {
			$precio1 = $categoria['precio1'] - ((double) $categoria['precio1'] * ($descuento['porcentajedescuento'] / 100));
			$precio2 = $categoria['precio2'] - ((double) $categoria['precio2'] * ($descuento['porcentajedescuento'] / 100));
			$precio3 = $categoria['precio3'] - ((double) $categoria['precio3'] * ($descuento['porcentajedescuento'] / 100));
		} else {
			$precio1 = (double) $categoria['precio1'];
			$precio2 = (double) $categoria['precio2'];
			$precio3 = (double) $categoria['precio3'];
		}

		date('Y-m-d', strtotime($categoria['fechavenc3']));
		
		//magia fechas
		$fecha_venc1 = date('Y-m-d', strtotime($categoria['fechavenc1']));
		$fecha_venc2 = date('Y-m-d', strtotime($categoria['fechavenc2']));
		$fecha_venc3 = date('Y-m-d', strtotime($categoria['fechavenc3']));

		if ($fecha_venc3 == $fecha_venc2) {
			if ($fecha_venc3 == $fecha_venc1) {
				$fecha_venc3 = date('Y-m-d', strtotime($categoria['fechavenc3']." -4 days"));
				$fecha_venc1 = $fecha_venc3;
			}
			$fecha_venc3 = date('Y-m-d', strtotime($categoria['fechavenc3']." -4 days"));
			$fecha_venc2 = $fecha_venc3;
		} else {
			$fecha_venc3 = date('Y-m-d', strtotime($categoria['fechavenc3']." -4 days"));
		}

		$fecha_actual = date('Y-m-d');

		$fecha_venc1Convertida = strtotime($fecha_venc1);
		$fecha_venc2Convertida = strtotime($fecha_venc2);
		$fecha_venc3Convertida = strtotime($fecha_venc3);
		$fecha_actualConvertida = strtotime($fecha_actual);
		$dias_diferencia_fecha1 = (((($fecha_venc1Convertida - $fecha_actualConvertida) / 60) / 60) / 24);

		//si fechaVenc1 es mayor a hoy
		if ($dias_diferencia_fecha1 > 0) {
			if ($dias_diferencia_fecha1 > 11) {
				$diferencia_venc1 = 11;
				$fecha_de_vencimiento1 = date('Y-m-d', strtotime($fecha_actual . " +" . $diferencia_venc1 . " days"));
				$fecha_de_vencimiento2 = date('Y-m-d', strtotime($fecha_actual . " +" . $diferencia_venc1 . " days"));
				$fecha_de_vencimiento3 = date('Y-m-d', strtotime($fecha_actual . " +" . $diferencia_venc1 . " days"));
				$precio2 = $precio1;
				$precio3 = $precio1;
			} else {
				$diferencia_venc1 = $dias_diferencia_fecha1;
				$fecha_de_vencimiento1 = date('Y-m-d', strtotime($fecha_actual . " +" . $diferencia_venc1 . " days"));
				$diferencia_venc2 = 11 - $dias_diferencia_fecha1;
				$fecha_de_vencimiento2_aux = date('Y-m-d', strtotime($fecha_venc1 . " +" . $diferencia_venc2 . " days"));

				if ($fecha_de_vencimiento2_aux <= $fecha_venc2) {
					$fecha_de_vencimiento2 = date('Y-m-d', strtotime($fecha_venc1 . " +" . $diferencia_venc2 . " days"));
					$fecha_de_vencimiento3 = $fecha_de_vencimiento2;
					$precio3 = $precio2;
				} else {
					$dias_restantes = ((((strtotime($fecha_de_vencimiento2_aux) - $fecha_venc2Convertida) / 60) / 60) / 24);
					$dias_diferencia_fecha2 = $diferencia_venc2 - $dias_restantes;
					$dias_diferencia_fecha3 = 11 - $dias_diferencia_fecha2 - $diferencia_venc1;
					$fecha_de_vencimiento2 = date('Y-m-d', strtotime($fecha_venc1 . " +" . $dias_diferencia_fecha2 . " days"));

					if ($dias_diferencia_fecha3 > 0) {
						$fecha_de_vencimiento3_aux = date('Y-m-d', strtotime($fecha_venc2 . " +" . $dias_diferencia_fecha3 . " days"));

						if ($fecha_de_vencimiento3_aux > $fecha_venc3) {
							$fecha_de_vencimiento3 = $fecha_venc3;
						} else {
							$fecha_de_vencimiento3 = $fecha_de_vencimiento3_aux;
						}
					} else {
						$fecha_de_vencimiento3 = $fecha_de_vencimiento2;
					}
				}
			}
		}
		//fechavenc1 menor a hoy
		else {
			$fecha_de_vencimiento1 = $fecha_venc1;
			$dias_diferencia_fecha2 = (((($fecha_venc2Convertida - $fecha_actualConvertida) / 60) / 60) / 24);

			if ($dias_diferencia_fecha2 > 7) {
				$diferencia_venc2 = 7;
				$fecha_de_vencimiento2 = date('Y-m-d', strtotime($fecha_actual . " +" . $diferencia_venc2 . " days"));
				$fecha_de_vencimiento3 = date('Y-m-d', strtotime($fecha_actual . " +" . $diferencia_venc2 . " days"));
				$precio3 = $precio2;
			} else {
				$diferencia_venc2 = $dias_diferencia_fecha2;
				$fecha_de_vencimiento2 = date('Y-m-d', strtotime($fecha_actual . " +" . $diferencia_venc2 . " days"));
				$diferencia_venc3 = 7 - $dias_diferencia_fecha2;
				$fecha_de_vencimiento3_aux = date('Y-m-d', strtotime($fecha_venc2 . " +" . $diferencia_venc3 . " days"));

				if ($fecha_de_vencimiento3_aux <= $fecha_venc3) {
					$fecha_de_vencimiento3 = $fecha_de_vencimiento3_aux;
				} else {
					$fecha_de_vencimiento3 = $fecha_venc3;
				}
			}
		}


		//formateo las fechas
		$categoria['fechavenc1'] = $fecha_de_vencimiento1;
		$categoria['fechavenc2'] = $fecha_de_vencimiento2;
		$categoria['fechavenc3'] = $fecha_de_vencimiento3;
		$fecha_in = date('Y-m-d h:i:s');
	}

    $query = "  INSERT INTO facturas (fac_usu_id,fac_evento_id,fac_cat_id,fac_op_id,fac_venc1,fac_imp1,fac_venc2,fac_imp2,fac_venc3,fac_imp3,fac_fecha_in,fac_mensualidad,fac_tipo)
                VALUES('$user_id','$evento','$cat','$opcion','{$categoria['fechavenc1']}','$precio1','{$categoria['fechavenc2']}','$precio2','{$categoria['fechavenc3']}','$precio3','$fecha_in','$mec_id','$tipo')";

    $result = $mysqli->query($query, MYSQLI_USE_RESULT);

    if ($result) {
        return true;
    } else {
        return false;
    }
}

function fechaByInt($int) {
    return substr($int, 0, 4) . '-' . substr($int, 4, 2) . '-' . substr($int, 6, 2);
}

function estaInscripto($mysqli, $evento, $categoria) {

    $query = "SELECT * FROM inscribite_eventos WHERE codigo = '$evento'";
    $evento_info = getRowQuery($query, $mysqli);

    $query = "SELECT * FROM inscribite_inscripciones WHERE deusuario = '{$_SESSION['usuario']}' AND deevento = '$evento' AND categoria = '$categoria'";
    $result = getRowQuery($query, $mysqli);

    if ($result && ($evento_info['tipo'] != 'Servicios' && $evento_info['tipo'] != 'Productos')) {
        return true;
    } else {
        return false;
    }
}

function cuotaPagada($mysqli, $mec_id) {

    $query = "SELECT * FROM mensualidad_cuota_usuario WHERE meu_mec_id = $mec_id AND meu_u_dni = '{$_SESSION['usuario']}'";
    $cuota_existente = getRowQuery($query, $mysqli);
	
	if($cuota_existente){
		return true;
	}
	else{
		return false;
	}

}

function parseParameters($parameters) {
//addslashes a todos los parametros, strlower y null en caso vacio
    $response = null;

    if ($parameters) {

        foreach ($parameters as $key => $each) {
            if (is_array($each)) {
                $response[$key] = parseParameters($each);
            } else {
                $response[$key] = ((addslashes($each)) ? addslashes($each) : null);
            }
        }
    }

    return $response;
}

function insertArray($tabla, $parameters, $mysqli, $fields = null) {
//hago lower de todos los strings en parameters 
    $parameters = lowerParameters($parameters);

//si no tenemos fields buscamos todos por schema
    if (!$fields) {
        $fields = parseTableSchema($tabla, $mysqli);
    }

//parseamos los parametros
    $values = parseValuesInsertArray($fields, $parameters);

    $query = "INSERT INTO $tabla ($fields) VALUES $values";

    if ($_SESSION['empresa_nombre'] == 'Maritimo SRL') {
        
    }
    $request = $mysqli->query($query);
}

function insertRow($tabla, $parameters, $mysqli, $fields = null) {
//hago lower de todos los strings en parameters 
    $parameters = lowerParameters($parameters);
	
	if($tabla=="inscribite_inscripciones" && !$fields){
		$parameters["eliminada"]=0;
	}

//si no tenemos fields buscamos todos por schema
    if (!$fields) {
        $fields = parseTableSchema($tabla, $mysqli);
    }

    //parseamos los parametros
    $values = parseValuesInsert($fields, $parameters);

    $query = "INSERT INTO $tabla ($fields) VALUES ($values)";

    $request = $mysqli->query($query);


    if (!$mysqli->error) {
        //die('inserción correcta');
    } else {
		echo 'campos:'.$fields;
		echo '<pre>';print_r($parameters);
		echo '<pre>';print_r($values);
        echo $query.'</br>';
		echo $mysqli->error;
        die('fallamos');
    }
}

function parseTableSchema($tabla, $mysqli) {
    $dbname = "inscribite_base";
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

function parseValuesInsert($fields, $parameters) {

//definiciones
    $values = "";
    $cont = 0;
    $array_fields = explode(',', $fields);


    foreach ($array_fields as $field) {
        foreach ($parameters as $name_parameter => $value_parameter) {
            if ($field == $name_parameter) {
                if ($cont == 0) {
                    $values .= "'" . (($value_parameter || $value_parameter == 0) ? $value_parameter : "") . "'";
                } else {
                    $values .= ",'" . (($value_parameter || $value_parameter == 0) ? $value_parameter : "") . "'";
                }
                $cont++;
                break;
            }
        }
    }

    return $values;
}

function lowerParameters($parameters) {
    //addslashes a todos los parametros, strlower y null en caso vacio
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

function deleteRow($tabla, $where, $mysqli) {
    $query = "DELETE FROM $tabla WHERE $where";
    $mysqli->query($query);
}

function parseValuesUpdate($fields, $parameters) {

    //definiciones
    $values = "";
    $array_fields = explode(',', $fields);

    foreach ($array_fields as $cont => $field) {
        foreach ($parameters as $name_parameter => $value_parameter) {
            if ($field == $name_parameter) {
                if ($cont == 0) {
                    $values .= $field . " = '" . $value_parameter . "'";
                } else {
                    $values .= "," . $field . " = '" . $value_parameter . "'";
                }
            }
        }
    }
	
    return $values;
}

function actualizarRow($tabla, $parameters, $where, $mysqli) {

    if (existeRegistro($tabla, $where, $mysqli)) {

        //parameters to lower
        $parameters = lowerParameters($parameters);
        $fields = parseTableSchema($tabla, $mysqli);

        //parseamos los parametros
        $values = parseValuesUpdate($fields, $parameters);

        //formamos el where
        $where = parseWhere($where);

        $query = "UPDATE $tabla SET $values $where";

		
        //execute the query.
        $mysqli->query($query);

		

        if (!$mysqli->error) {
            //die('actualización correcta');
        } else {
			echo $query;
            die('fallamos');
        }
    } else {
        insertRow($tabla, $parameters, $mysqli);
    }
}

function existeRegistro($tabla, $where, $mysqli) {
    //formamos el where
    $where = parseWhere($where);
    $result = getRowQuery("SELECT * FROM $tabla $where", $mysqli);

    if (!$result) {
        return false;
    } else {
        return true;
    }
}

function parseWhere($parameters) {

    //definiciones
    $cont = 0;
    $where = "";


    foreach ($parameters as $field => $value) {
        if ($cont == 0) {
            $where = "WHERE " . $field . " = '" . $value . "'";
        } else {
            $where .= " AND " . $field . " = '" . $value . "'";
        }
        $cont++;
    }

    return $where;
}

function runQuery($query, $mysqli) {

    $mysqli->query($query);

    if (!$mysqli->error) {
        return true;
    } else {
        return false;
    }
}

function generarCodigoBarra($cod_empresa, $nro_cli, $nro_fac, $imp1, $venc1, $imp2, $venc2) {

    //definiciones
    $verificador = 0;
    $cod_barra = $cod_empresa . $nro_cli . $nro_fac . $imp1 . $venc1 . $imp2 . $venc2;

    /* El cod barra tiene q ser de max 60 bytes
     *  bytes fijos
     * cod_empresa(4)+fechas(16)+verificador(1)+dni_cliente(8)+importes(22)+nro_factura(9) = 60 bytes fijos
     */

    //paso el str to array
    $array = str_split($cod_barra);
    //asi lo piden, arranca del 1 pero php del 0
    array_unshift($array, "no");

    foreach ($array as $key => $caracter) {
        if ($caracter != " " && $caracter != "no") {
            if ($key % 2 == 0) {
                $verificador = $verificador + $caracter;
            } else {
                $verificador = $verificador + $caracter * 3;
            }
        }
    }

    $dig_verificador = 10 - (($verificador % 10 > 0) ? $verificador % 10 : 10);

    return $cod_barra . $dig_verificador;
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

function limpiarCaracteresEspeciales($string ){
	return strtolower(preg_replace(array('/[^a-zA-Z0-9 -]/', '/[ -]+/', '/^-|-$/'), 
	array('', '-', ''), remove_accent($string))); 
 
}
function remove_accent($str) 
{ 
  $a = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'ß', 'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', 'A', 'a', 'A', 'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'D', 'd', 'Ð', 'd', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g', 'H', 'h', 'H', 'h', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', '?', '?', 'J', 'j', 'K', 'k', 'L', 'l', 'L', 'l', 'L', 'l', '?', '?', 'L', 'l', 'N', 'n', 'N', 'n', 'N', 'n', '?', 'O', 'o', 'O', 'o', 'O', 'o', 'Œ', 'œ', 'R', 'r', 'R', 'r', 'R', 'r', 'S', 's', 'S', 's', 'S', 's', 'Š', 'š', 'T', 't', 'T', 't', 'T', 't', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'W', 'w', 'Y', 'y', 'Ÿ', 'Z', 'z', 'Z', 'z', 'Ž', 'ž', '?', 'ƒ', 'O', 'o', 'U', 'u', 'A', 'a', 'I', 'i', 'O', 'o', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', '?', '?', '?', '?', '?', '?'); 
  $b = array('A', 'A', 'A', 'A', 'A', 'A', 'AE', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'D', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 's', 'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y', 'A', 'a', 'A', 'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'D', 'd', 'D', 'd', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g', 'H', 'h', 'H', 'h', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'IJ', 'ij', 'J', 'j', 'K', 'k', 'L', 'l', 'L', 'l', 'L', 'l', 'L', 'l', 'l', 'l', 'N', 'n', 'N', 'n', 'N', 'n', 'n', 'O', 'o', 'O', 'o', 'O', 'o', 'OE', 'oe', 'R', 'r', 'R', 'r', 'R', 'r', 'S', 's', 'S', 's', 'S', 's', 'S', 's', 'T', 't', 'T', 't', 'T', 't', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'W', 'w', 'Y', 'y', 'Y', 'Z', 'z', 'Z', 'z', 'Z', 'z', 's', 'f', 'O', 'o', 'U', 'u', 'A', 'a', 'I', 'i', 'O', 'o', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'A', 'a', 'AE', 'ae', 'O', 'o'); 
  return str_replace($a, $b, $str); 
} 
function subirImagen($files, $user_id) {
	$uploaddir = '../../imagenes/';
	$extension = explode(".", $files['mensualidad_logo']['name']);
	$uploadfile = $uploaddir . $files['mensualidad_logo']['name'];
			
	if ((($files["mensualidad_logo"]["type"] == "image/gif") || ($files["mensualidad_logo"]["type"] == "image/jpeg") || 
	($files["mensualidad_logo"]["type"] == "image/jpg") || ($files["mensualidad_logo"]["type"] == "image/pjpeg") || 
	($files["mensualidad_logo"]["type"] == "image/x-png") || ($files["mensualidad_logo"]["type"] == "image/png")) 
	&& ($files["mensualidad_logo"]["size"] < 1536000)) {
		if (file_exists($uploadfile)) {
			unlink($uploadfile);
		}
		if (move_uploaded_file($files['mensualidad_logo']['tmp_name'], strtolower($uploadfile))) {
			return true;
		} else {
			return false;
		}
	}else{
		die('extension no valida');
	}

}
