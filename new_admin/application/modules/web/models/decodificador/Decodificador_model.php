<?php

defined("BASEPATH") OR exit("No direct script access allowed");

class Decodificador_model extends A_Model {

    public function __construct() {

        parent::__construct();
    }

    public function getById($id) {
        return $this->getCollectionByid("Decodificador", $id);
    }

    public function sincronizaInfoNecesaria($corta_ejecucion = false) {
        
    }

    public function insertar($information) {
        if ($information["dec_id"]) {
            $decodificador = $this->getCollectionByid("Decodificador", $information["dec_id"]);
        } else {
            $decodificador = new Decodificador();
            $this->orm->persist($decodificador);
        }

        if ($_FILES["archivos"]) {
            $files = reArrayFiles($_FILES['archivos']);
            foreach ($files as $file) {
                $archivos_repetidos = $this->orm->createQuery("SELECT m FROM Mediodecodificado m WHERE LOWER(m.nombre_archivo) like :busqueda")->setParameter("busqueda", "%" . strtolower($file["name"]) . "%")->getResult();
                if ($archivos_repetidos) {
                    die("archivos repetidos");
                }
            }
            foreach ($files as $file) {
                if ($file['name']) {
                    //chequeamos que no exista el archivo con esa fecha!
                    switch ($file["name"]) {
                        case strpos(strtolower($file["name"]), "cob") !== false:
                            move_uploaded_file($file['tmp_name'], PMC_COBRANZAS . $file["name"]);
                            $pmc = $this->decodificaPMC($file["name"], $decodificador);
                            $decodificador->setPagomiscuentas($pmc);
                            break;
                        case strpos(strtolower($file["name"]), "rp") !== false:
                            if (file_exists(RP_COBRANZAS . $file["name"])) {
                                unlink(RP_COBRANZAS . $file["name"]);
                            }
                            move_uploaded_file($file['tmp_name'], RP_COBRANZAS . $file["name"]);
                            $rp = $this->decodificaRP($file["name"], $decodificador);
                            $decodificador->setRapipago($rp);
                            break;
                        case strpos(strtolower($file["name"]), "pfc") !== false:
                            move_uploaded_file($file['tmp_name'], PF_COBRANZAS . $file["name"]);
                            $pf = $this->decodificaPF($file["name"], $decodificador);
                            $decodificador->setPagofacil($pf);
                            break;
                        case strpos(strtolower($file["name"]), "pfi") !== false:
                            move_uploaded_file($file['tmp_name'], PF_COBRANZAS . $file["name"]);
                            $pfi = $this->decodificaPF($file["name"], $decodificador);
                            $decodificador->setPagofacilinterior($pfi);
                            break;
                    }
                }
            }
        }

        $decodificador->setObservaciones($information["dec_observaciones"]);
        $this->orm->flush();
        $this->avisaPagos();
        //$this->borrarInscripcionesVencidas();
    }

    public function reProcesarMedio($med_id) {
        /* @var $mediodecodificado Mediodecodificado */
        $mediodecodificado = $this->getCollectionByid("Mediodecodificado", $med_id);
        $decodificador = $mediodecodificado->getDecodificador();
        foreach ($mediodecodificado->getRenglones() as $cada_renglon) {
            $this->orm->remove($cada_renglon);
        }
        if ($mediodecodificado->getTipo() == "pmc") {
            $this->decodificaPMC($mediodecodificado->getNombre_archivo(), $decodificador, $mediodecodificado);
        } elseif ($mediodecodificado->getTipo() == "rp") {
            $this->decodificaRP($mediodecodificado->getNombre_archivo(), $decodificador, $mediodecodificado);
        } else {
            $this->decodificaPF($mediodecodificado->getNombre_archivo(), $decodificador, $mediodecodificado);
        }
        $this->avisaPagos();
    }

    private function decodificaPF($nombre_archivo, &$decodificador, &$medio_pago = false) {
        if (filesize(PF_COBRANZAS . $nombre_archivo) == 0) {
            return;
            //die('archivo de pago facil vacio');
        }
        $detalles = array();
        $file = fopen(PF_COBRANZAS . $nombre_archivo, "r");
        $cont = 1;
        while (!feof($file)) {
            $line = fgets($file);
            if ($cont > 2) {
                $detalles[] = $line;
            }
            $cont++;
        }
        if (!isset($detalles[count($detalles) - 2]) || !isset($detalles[count($detalles) - 3])) {//no hay renglones
            return;
        }
        $footer[0] = $detalles[count($detalles) - 2];
        $footer[1] = $detalles[count($detalles) - 3];
        unset($detalles[count($detalles) - 1]);
        unset($detalles[count($detalles) - 2]);
        unset($detalles[count($detalles) - 3]);
        $parseo = array();
        $monto_total = 0.00;
        foreach ($detalles as $k => $detalle) {
            $primeros4cod = substr($detalle, 24, 4);
            $cateencod = substr($detalle, 28, 2);
            $eldni = substr($detalle, 30, 15);
            $longitud = strlen(trim($detalle));
            $monto_pagado = ltrim(substr($detalle, 48, 8), 0);
            $monto_pagado .= '.' . substr($detalle, 56, 2);
            $fechacobrado = substr($detalle, 22, 2) . '/' . substr($detalle, 20, 2) . '/' . substr($detalle, 16, 4);
            $fechadpagodia = substr($detalle, 70, 2);
            $fechadpagomes = substr($detalle, 68, 2);
            $fechadpagoanio = substr($detalle, 64, 4);
            $fechadpagohora = substr($detalle, 72, 2);
            $fechadpagominutos = substr($detalle, 74, 2);
            $fechadePago = $fechadpagoanio . '-' . $fechadpagomes . '-' . $fechadpagodia . ' ' . $fechadpagohora . ':' . $fechadpagominutos . ':00';
            $fecha_orm = $fechadpagodia . "-" . $fechadpagomes . '-' . $fechadpagoanio;
            if ($longitud == 80) {
                $parseo[$k]["codigo"] = $primeros4cod;
                $parseo[$k]["categoria"] = substr($detalle, 28, 2);
                $parseo[$k]["dni"] = $eldni;
                $parseo[$k]["monto"] = $monto_pagado;
                $parseo[$k]["fecha_cobro"] = $fechacobrado;
                $parseo[$k]["fecha_pago"] = $fechadePago;
                $parseo[$k]["fecha_orm"] = $fecha_orm;
                $parseo[$k]["linea"] = $detalle;
                $parseo[$k]["longitud"] = $longitud;
                $monto_total = $monto_total + $monto_pagado;
            }
        }
        //$conte = fread($file, filesize(PF_COBRANZAS . $nombre_archivo));
        fclose($file);

        $cuentaGrabadosInscribite = 0;
        $noGrabarEnBase = false;

        $fecha = substr($nombre_archivo, -6, 2) . substr($nombre_archivo, -8, 2) . substr($nombre_archivo, -10, 2);
        $query = "INSERT INTO pagofacil_archivos (archivo_id,archivo_fecha,archivo_nombre) VALUES(NULL,'$fecha','$nombre_archivo')";
        $this->db->query($query);

        //obj cabecera
        if (!$medio_pago) {
            $medio_pago = new Mediodecodificado();
        }
        $h_fecha_proceso = "20" . substr($nombre_archivo, -6, 2) . "-" . substr($nombre_archivo, -8, 2) . "-" . substr($nombre_archivo, -10, 2);
        $medio_pago->setFecha(new \Datetime($h_fecha_proceso));
        $medio_pago->setNombre_archivo($nombre_archivo);
        $medio_pago->setDecodificador($decodificador);
        if (strpos(strtolower($nombre_archivo), "pfc") !== false) {
            $medio_pago->setTipo("pfc");
        } else {
            $medio_pago->setTipo("pfi");
        }

        $this->orm->persist($medio_pago);
        $this->orm->flush();
        $cant_registros = 0;
        foreach ($parseo as $renglon) {

            if ($renglon["codigo"] == 8888) {
                die('lo mejor en fotos');
            } elseif ($renglon["codigo"] == 8889) {
                die('cobre online');
            } else {
                $tieneMensualidad = false;
                $query = "SELECT * FROM facturas WHERE fac_usu_id = (select id from inscribite_usuarios where dni = {$renglon["dni"]} order by id asc limit 1) and fac_mensualidad = {$renglon["codigo"]} and (fac_tipo = 2 or fac_tipo= 3) ";
                $tiene_mensualidad = $this->db->query($query)->row();

                if (isset($tiene_mensualidad->fac_mensualidad) && $tiene_mensualidad->fac_mensualidad) {
                    $tieneMensualidad = true;
                }
                $fechadePago = date('Y-m-d h:i:s', strtotime($renglon["fecha_pago"]));
                //esta pagando mensualidades iooou mr white
                //busco al usuario
                $query = 'SELECT * FROM inscribite_usuarios WHERE dni = "' . $renglon["dni"] . '" LIMIT 1';
                $result1 = $this->db->query($query);
                $usuario = $result1->row();
                if (!$usuario) {
                    file_put_contents(PATH_DECODIFICADOS . 'deco_error.txt', "Dni " . $renglon["dni"] . " no encontrado\r\n");
                    continue;
                    /* echo 'no encuentra dni' . '<br>';
                      echo $query;
                      die(); */
                }
                $inserta_inscripcion=true;
                if ($tieneMensualidad) {
                    $this->insertaCuotaMensualidad($renglon["dni"], $tiene_mensualidad->fac_mensualidad, $renglon["monto"]);

                    //obj renglón
                    $renglon_medio = new Decodificado_renglones();
                    $renglon_medio->setImporte($renglon["monto"]);
                    $renglon_medio->setFechapago(new \DateTime(($renglon["fecha_orm"])));
                    $renglon_medio->setCabecera($medio_pago);
                    $renglon_medio->setFechaacreditacion(new \DateTime(($renglon["fecha_orm"])));
                    $renglon_medio->setDni($renglon["dni"]);
                    $renglon_medio->setCodigo($tiene_mensualidad->fac_id);
                    $renglon_medio->setTipo_decodificacion("mensualidad");
                    $this->orm->persist($renglon_medio);
                    $this->orm->flush();
                    //aca debería avisar mensualidad
                    ///////
                    //////
                    $inserta_inscripcion=false;
                }
                $cant_registros++;
                $row1 = $usuario;

                
                if (!$tieneMensualidad) {
                    $iddeinscr = $this->insertaInscripcionDeportista($renglon["monto"], $renglon["dni"], $renglon["codigo"], $renglon["categoria"], false, false, false, false, false, MEDIO_PF, $tieneMensualidad);
                    //obj renglón
                    $renglon_medio = new Decodificado_renglones();
                    $renglon_medio->setImporte($renglon["monto"]);
                    $renglon_medio->setFechapago(new \DateTime(($renglon["fecha_orm"])));
                    $renglon_medio->setCabecera($medio_pago);
                    $renglon_medio->setFechaacreditacion(new \DateTime(($renglon["fecha_orm"])));
                    $renglon_medio->setDni($renglon["dni"]);
                    $renglon_medio->setCodigo($iddeinscr);
                    $renglon_medio->setTipo_decodificacion("inscripcion");
                    $this->orm->persist($renglon_medio);
                    $this->orm->flush();
                }

                $fechadpagodia = substr($renglon["linea"], 70, 2);
                $fechadpagomes = substr($renglon["linea"], 68, 2);
                $fechadpagoanio = substr($renglon["linea"], 64, 4);
                $fechadpagohora = substr($renglon["linea"], 72, 2);
                $fechadpagominutos = substr($renglon["linea"], 74, 2);

                $cuentaGrabadosInscribite++;
                $usuario->deudor_nombre = $usuario->nombre . ' ' . $usuario->apellido;
                $usuario->deudor_email = $usuario->email;
                $usuario->deudor_email = $usuario->dni;
                $row1->cobro_monto = $monto_pagado;
                $row1->cupon_codigodebarras = $primeros4cod . $cateencod . trim($eldni);
            }


            $ar_tds = Array();

            $ar_tds[1] = (substr($renglon["linea"], 1, 5) + 0);
            $ar_tds[2] = $fechacobrado;
            //$ar_tds[3]  = $usuario['deudor_nombre'].' ('.$usuario['deudor_email'].')';
            $ar_tds[3] = $usuario->deudor_nombre;
            $ar_tds[4] = $row1->cupon_codigodebarras;
            $ar_tds[5] = ((substr($renglon["linea"], 45, 3) == "PES") ? "$" : substr($renglon["linea"], 45, 3));
            $ar_tds[6] = str_replace('.', ',', $row1->cobro_monto);
            //.(($row1['cobro_monto2'] != '')?' / '.str_replace('.', ',', $row1['cobro_monto2']):'');
            $ar_tds[7] = $monto_pagado;
            $ar_tds[8] = substr($renglon["linea"], 58, 6);
            $ar_tds[9] = (substr($renglon["linea"], 70, 2) * 1) . '/' . (substr($renglon["linea"], 68, 2) * 1) . '/' . substr($renglon["linea"], 66, 2);
            $ar_tds[10] = substr($renglon["linea"], 72, 2) . ':' . substr($renglon["linea"], 74, 2);
            $ar_tds[11] = $row1->id;
            $ar_tds[12] = "Enviado";
            $ar_tds['eventos_de_fotos'] = "";
            $ar_tds['fotografo_de_fotos'] = "";

            $ar_tds['cobro_id'] = "";
            $ar_tds['cobro_concepto'] = "";

            $this->db->query("INSERT INTO pagofacil_acumulado (" . "\n" .
                    "`acumulado_nro`, " . "\n" .
                    "`acumulado_fecha`, " . "\n" .
                    "`acumulado_cliente`, " . "\n" .
                    "`acumulado_ev`, " . "\n" .
                    "`acumulado_categ`, " . "\n" .
                    "`acumulado_monto`, " . "\n" .
                    "`acumulado_terminal`, " . "\n" .
                    "`acumulado_fecha_cobrado`, " . "\n" .
                    "`acumulado_hora` " . "\n" .
                    ") VALUES (" . "\n" .
                    "'" . $ar_tds[1] . "', " . "\n" . // acumulado_nro`, ".
                    "'" . $ar_tds[2] . "', " . "\n" . // acumulado_fecha`, ".
                    "'" . $usuario->dni . ' ' . $usuario->nombre . "', " . "\n" . // acumulado_cliente`, ".
                    "'" . (substr($ar_tds[4], 4) * 1) . "', " . "\n" . // acumulado_ev`, ".
                    "'" . $ar_tds[5] . "', " . "\n" . // acumulado_categ`, ".
                    "'" . $ar_tds[6] . "', " . "\n" . // acumulado_monto`, ".
                    "'" . $ar_tds[8] . "', " . "\n" . // acumulado_terminal`, ".
                    "'" . $ar_tds[9] . "', " . "\n" . // acumulado_fecha_cobrado
                    "'" . $ar_tds[10] . "'" . "\n" . // acumulado_hora` ".
                    ");");
        }
        $medio_pago->setCant_registros($cant_registros);
        $medio_pago->setTotal($monto_total);
        $this->orm->flush();
        return $medio_pago;
    }

    private function decodificaRP($nombre_archivo, &$decodificador, &$medio_pago = false) {
        $file = fopen(RP_COBRANZAS . $nombre_archivo, "r");
        $header = fread($file, 73);

        $content = "";
        while (!feof($file)) {
            $content .= fread($file, 74);
        }
        fclose($file);
        $detalles = substr($content, 1, strlen($content) - 76);
        $detalles = explode(PHP_EOL, $detalles);

        //unset($detalles[0]);
        $trailer = substr($content, strlen($content) - 74, 73);

        //formamos el header
        $h_fecha_proceso = substr($header, 28, 8);
        $t_cant_registros = substr($trailer, 8, 8);
        $t_importe_total = substr($trailer, 16, 18);

        //obj cabecera
        if (!$medio_pago) {
            $medio_pago = new Mediodecodificado();
        }
        $medio_pago->setDecodificador($decodificador);
        $medio_pago->setFecha(new \Datetime(fechaByInt($h_fecha_proceso)));
        $medio_pago->setNombre_archivo($nombre_archivo);
        $medio_pago->setTipo("rp");
        $this->orm->persist($medio_pago);
        $this->orm->flush();

        $monto_total = 0.00;
        $cant_registros = 0;

        foreach ($detalles as $k => $detalle) {
            $detalles[$k] = trim($detalle);
            if (empty($detalle)) {
                unset($detalles[$k]);
            }
        }

        $control = array();
        foreach ($detalles as $k => $detalle) {
            $para = "";
            $cabeceras = "";
            $titulo = "";

            $cant_registros++;
            $d_fec_acreditacion = substr($detalle, 0, 8);
            $d_importe = substr($detalle, 8, 15);
            $d_cod_empresa = substr($detalle, 23, 4);
            $d_importe_evento = substr($detalle, 27, 6);
            $d_recargo = substr($detalle, 33, 2);
            $d_fec_vencimiento = substr($detalle, 35, 5);
            $d_cod_evento = substr($detalle, 40, 4);
            $d_cod_categoria = substr($detalle, 44, 2);
            $d_dni = substr($detalle, 46, 8);

            //array de control
            $control[$k]["dni"] = $d_dni;
            $control[$k]["importe"] = $d_importe;
            $control[$k]["evento"] = $d_cod_evento;
            $control[$k]["categoria"] = $d_cod_categoria;
            $control[$k]["empresa"] = $d_cod_empresa;


            //parametros para la tabla
            $parameters['facp_monto'] = (int) substr($d_importe, 0, 13) . '.' . substr($d_importe, 13, 2);

            //pongo misma fecha porq no se maneja igual q pmc solo usamos el decodificador, no enviamos facturas
            $parameters['facp_fecha_aplicacion'] = fechaByInt($d_fec_acreditacion);
            $parameters['facp_fecha_acreditacion'] = fechaByInt($d_fec_acreditacion);



            $query = "SELECT fac_id,fac_mensualidad FROM facturas WHERE fac_mensualidad = $d_cod_evento and 
                                                fac_usu_id = (select id from inscribite_usuarios where (dni = '$d_dni' or dni='0$d_dni') order by id asc limit 1) and fac_tipo > 1 limit 1";
            $es_mensualidad = $this->db->query($query)->row();

            $inserto_inscripcion=false;
            if ($es_mensualidad) {
                //obj renglón
                $renglon_medio = new Decodificado_renglones();
                $renglon_medio->setImporte($parameters['facp_monto']);
                $renglon_medio->setFechapago(new \DateTime(fechaByInt($d_fec_acreditacion)));
                $renglon_medio->setCabecera($medio_pago);
                $renglon_medio->setFechaacreditacion(new \DateTime(fechaByInt($d_fec_acreditacion)));
                $renglon_medio->setDni($d_dni);
                $renglon_medio->setCodigo($es_mensualidad->fac_id);
                $renglon_medio->setTipo_decodificacion("mensualidad");
                $this->orm->persist($renglon_medio);
                $this->orm->flush();

                $this->insertaCuotaMensualidad($d_dni, $es_mensualidad->fac_mensualidad, $d_importe_evento);

                //traigo con dni evento y cod evento el nro de factura
                $d_nro_factura = $this->db->query("SELECT fac_id,nombre as usu_nombre,apellido as usu_apellido,email as email_usuario
                                                FROM facturas INNER JOIN inscribite_usuarios ON id = fac_usu_id
                                                WHERE dni = $d_dni AND fac_mensualidad = $d_cod_evento")->row();

                $d_nro_factura = $d_nro_factura->fac_id;
                $monto_total = $monto_total + $parameters["facp_monto"];
                //$this->insertaInscripcionDeportista($parameters['facp_monto'], $d_dni, $d_cod_evento, $d_cod_categoria, 0, false, $d_nro_factura, $d_cod_empresa, $nombre_archivo, MEDIO_RP);
            }


            //autocommit off
            $this->db->trans_begin();

            if (!$es_mensualidad) {
                $query = "SELECT id FROM inscribite_inscripciones WHERE deevento = $d_cod_evento and deusuario = $d_dni
                                                and (categoria = (SELECT distinct nombre FROM inscribite_categorias WHERE codigo = $d_cod_categoria 
                                                    and deevento = $d_cod_evento) OR categoria=(SELECT distinct codigo FROM inscribite_categorias WHERE codigo = $d_cod_categoria 
                                                    and deevento = $d_cod_evento))";

                //echo $query;die;
                $d_nro_factura = $this->db->query($query)->row();
                //imprimirYMorir($d_nro_factura);
                $fecha_string = new \DateTime(fechaByInt($d_fec_acreditacion));
                $fecha_string = $fecha_string->format("Y-m-d");
                if ($d_nro_factura) {
                    $monto_total = $monto_total + $parameters["facp_monto"];
                    $d_nro_factura = $d_nro_factura->id;
                    //obj renglón
                    $renglon_medio = new Decodificado_renglones();
                    $renglon_medio->setImporte($parameters['facp_monto']);
                    $renglon_medio->setFechapago(new \DateTime(fechaByInt($d_fec_acreditacion)));
                    $renglon_medio->setCabecera($medio_pago);
                    $renglon_medio->setFechaacreditacion(new \DateTime(fechaByInt($d_fec_acreditacion)));
                    $renglon_medio->setDni($d_dni);
                    $renglon_medio->setCodigo($d_nro_factura);
                    $renglon_medio->setTipo_decodificacion("inscripcion");
                    $this->orm->persist($renglon_medio);
                    $this->orm->flush();

                    $this->insertaInscripcionDeportista($parameters['facp_monto'], $d_dni, $d_cod_evento, $d_cod_categoria, 0, false, $d_nro_factura, $d_cod_empresa, $nombre_archivo, MEDIO_RP, false, $fecha_string);
                } else{
                    $this->insertaInscripcionDeportista($parameters['facp_monto'], $d_dni, $d_cod_evento, $d_cod_categoria, 0, false, false, $d_cod_empresa, $nombre_archivo, MEDIO_RP, false, $fecha_string);
                    /* echo 'query ' . $query . '<br>';
                      die('no se encontro registro para dni ' . $d_dni . ' evento ' . $d_cod_evento . ' categoria ' . $d_cod_categoria);
                      continue; */
                }
            }

            $control[$k]["dec_id"] = isset($renglon_medio) ? $renglon_medio->getId() : "0";
            $control[$k]["facp_fac_id"] = $d_nro_factura;

            $parameters['facp_fac_id'] = $d_nro_factura;
            $parameters['facp_archivo'] = $nombre_archivo;
            $parameters['facp_avisado'] = 0;
            $parameters['facp_dni'] = $d_dni;
            $parameters['facp_evento'] = $d_cod_evento;
            $parameters['facp_categoria'] = $d_cod_categoria;
            $parameters['facp_empresa'] = $d_cod_empresa;



            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
            } else {
                $this->db->trans_commit();
            }
        }


        $medio_pago->setCant_registros($cant_registros);
        $medio_pago->setTotal($monto_total);
        $this->orm->flush();


        /* imprimir($detalles);
          imprimirYMorir($control); */


        return $medio_pago;
    }

    private function insertaCuotaMensualidad(&$dni, &$cuota, &$monto) {
        $query = "select meu_id from mensualidad_cuota_usuario
                    where meu_u_dni = $dni and meu_mec_id=$cuota";
        $ya_inserto = $this->db->query($query)->result();
        if (!$ya_inserto) {
            $query = "INSERT INTO mensualidad_cuota_usuario(meu_u_dni,meu_mec_id,meu_importe,meu_fecha)
                         VALUES($dni,$cuota,$monto,NOW())";
            $this->db->query($query);
        }
    }

    /*
     * tipo_medio 1=pf,2=rp,3=pmc
     *      */

    private function insertaInscripcionDeportista(&$monto, &$dni, &$evento_codigo, &$categoria_codigo, $opcion_codigo, $fac_id = false, $ins_id = false, $cod_empresa = false, $nombre_archivo = false, $tipo_medio = false, $tieneMensualidad = false, $fecha_aplicacion = "NOW()") {
        $elcodigoes = $evento_codigo . $categoria_codigo . agceros($dni, 8);
        if ($tipo_medio == MEDIO_PF) {
            $query = 'SELECT id, deevento, selemandomail, venceeldia, cargopuntos FROM inscribite_inscripciones WHERE codigo = "' . $elcodigoes . '" ORDER BY id DESC LIMIT 1';
            $result2 = $this->db->query($query)->row();
            if (!$result2) {
                if ($tieneMensualidad) {
                    $query = 'SELECT eve.nombre, eve.empresa,eve.codigo FROM facturas
                            inner join inscribite_eventos eve on eve.codigo=fac_evento_id
                            inner join inscribite_usuarios usu on usu.id=fac_usu_id
                            where dni = ' . $dni . ' and fac_mensualidad = ' . $evento_codigo . ' and fac_tipo in(2,3) and LENGTH(eve.nombre) > 3';
                } else {
                    $query = 'SELECT nombre, empresa FROM inscribite_eventos WHERE codigo = "' . $evento_codigo . '" LIMIT 1';
                }
                $result3 = $this->db->query($query);
                $row3 = $result3->row();
                if (!$row3) {
                    echo $query;
                    die('no encontramos el evento');
                }
                $empresa = $row3->empresa;
                $query = 'SELECT opcion FROM inscribite_categorias WHERE deevento = "' . $evento_codigo . '" AND codigo = "' . $categoria_codigo . '" LIMIT 1';

                $result3 = $this->db->query($query);
                $row3 = $result3->row_array();


                $insertInscripcion = "INSERT INTO inscribite_inscripciones (deusuario,empresa,deevento,categoria,opcion,codigo) 
                    VALUES ('" . agceros($dni, 8) . "','" . $empresa . "','" . $evento_codigo . "','" . $categoria_codigo . "',
                    '" . $row3['opcion'] . "','" . $elcodigoes . "')";
                $this->db->query($insertInscripcion);
                $iddeinscr = $this->db->insert_id();
            } else {
                $this->db->query("UPDATE inscribite_inscripciones SET pagoeldia = Now(), pagado = 1 WHERE id = {$result2->id}");
                $iddeinscr = $result2->id;
            }
            return $iddeinscr;
        }
        if ($tipo_medio == MEDIO_RP) {

            if ($ins_id) {
                $query = "INSERT INTO facturas_rp_pagas(facp_fac_id,facp_archivo,facp_avisado,facp_dni,facp_evento,facp_categoria,facp_empresa,facp_monto)
                     VALUES('$ins_id','$nombre_archivo',0,'$dni','$evento_codigo','$categoria_codigo','$cod_empresa','$monto')";
                $this->db->query($query);
                $facp_id = $this->db->insert_id();
                $tieneDatos = $this->db->query("SELECT id FROM inscribite_inscripciones WHERE id = $ins_id")->row();
                if ($tieneDatos) {
                    $this->db->query("UPDATE inscribite_inscripciones SET pagoeldia = Now(), pagado = 1 WHERE id = $ins_id");
                } else {
                    $query = "INSERT INTO inscribite_inscripciones(deusuario,deevento,categoria,opcion,pagado,empresa,iniciadoeldia,pmc,pagoeldia,precio)
                        SELECT facp_dni,e.codigo,c.nombre,(SELECT opcion FROM inscribite_categorias WHERE deevento = $evento_codigo AND codigo = $categoria_codigo LIMIT 1) opcion,'1' pagado,e.empresa,facp_fecha_aplicacion ,'2' rp,facp_fecha_aplicacion,facp_monto 
                        FROM facturas_rp_pagas  
                        INNER JOIN inscribite_eventos e ON e.codigo = facp_evento
                        INNER JOIN inscribite_categorias c ON c.deevento = facp_evento AND c.codigo = facp_categoria
                        WHERE facp_id = $facp_id";
                    $this->db->query($query);
                    $d_nro_factura = $this->db->insert_id();
                    $this->db->query("UPDATE facturas_rp_pagas SET facp_fac_id = $d_nro_factura WHERE facp_id = $facp_id ");
                }
            } else {
                $query = "INSERT INTO inscribite_inscripciones(deusuario,deevento,categoria,opcion,pagado,empresa,iniciadoeldia,pmc,pagoeldia,precio)
                        SELECT '$dni' facp_dni,'$evento_codigo' codigo,'$categoria_codigo' nombre,
                        (SELECT opcion FROM inscribite_categorias WHERE deevento = $evento_codigo AND codigo = $categoria_codigo LIMIT 1) opcion,'1' pagado,
                        '$cod_empresa' empresa,'$fecha_aplicacion' facp_fecha_aplicacion ,'2' rp,'$fecha_aplicacion' facp_fecha_aplicacion,'$monto' facp_monto 
                        ";
                $this->db->query($query);
                $d_nro_factura = $this->db->insert_id();
                $query = "INSERT INTO facturas_rp_pagas(facp_fac_id,facp_archivo,facp_avisado,facp_dni,facp_evento,facp_categoria,facp_empresa,facp_monto)
                     VALUES('$d_nro_factura','$nombre_archivo',0,'$dni','$evento_codigo','$categoria_codigo','$cod_empresa','$monto')";
                $this->db->query($query);
            }
        } else {
            $query = "SELECT deusuario FROM inscribite_inscripciones 
                        WHERE deusuario = $dni
                        AND deevento = (SELECT distinct deevento FROM inscribite_categorias where codigo = $categoria_codigo
                        and deevento = $evento_codigo and opcion = (select nombre from inscribite_opciones where id = $opcion_codigo))";

            $tieneDatos = $this->db->query($query)->row();

            if ($tieneDatos) {
                $query = "UPDATE inscribite_inscripciones SET pagoeldia = Now(), pagado = 1
                            WHERE  deusuario = $dni
                            AND deevento = (SELECT distinct deevento FROM inscribite_categorias where codigo = $categoria_codigo
                            and deevento = $evento_codigo and opcion = (select nombre from inscribite_opciones where id = $opcion_codigo))";
            } else {
                $query = "INSERT INTO inscribite_inscripciones(deusuario,deevento,categoria,opcion,pagado,empresa,iniciadoeldia,pmc,pagoeldia)
                            SELECT u.dni,e.codigo,c.nombre,o.nombre,'1' pagado,e.empresa,fac_fecha_in,'1' pmc,facp_fecha_aplicacion FROM facturas 
                            INNER JOIN inscribite_eventos e ON e.codigo = fac_evento_id
                            INNER JOIN inscribite_opciones o ON o.id = fac_op_id
                            INNER JOIN inscribite_categorias c ON c.deevento = fac_evento_id AND c.codigo = fac_cat_id
                            INNER JOIN inscribite_usuarios u ON u.id = fac_usu_id
                            INNER JOIN facturas_pagas ON facp_fac_id = fac_id
                            WHERE fac_id = $fac_id";
            }
            $this->db->query($query);
        }
    }

    private function decodificaPMC($nombre_archivo, &$decodificador, &$medio_pago = false) {
        $file = fopen(PMC_COBRANZAS . $nombre_archivo, "r");
        $header = fread($file, 100);

        $content = "";
        while (!feof($file)) {
            $content .= fread($file, 101);
        }
        fclose($file);
        $detalles = substr($content, 1, strlen($content) - 103);
        $detalles = explode(PHP_EOL, $detalles);
        //unset($detalles[0]);
        $trailer = substr($content, strlen($content) - 103, 100);


        $h_cod_registro = substr($header, 0, 1);
        $h_cod_banelco = substr($header, 1, 3);
        $h_cod_empresa = substr($header, 4, 4);
        $h_fec_archivo = substr($header, 8, 8);
        $h_filler = substr($header, 16, 84);

        //obj cabecera
        if (!$medio_pago) {
            $medio_pago = new Mediodecodificado();
        }
        $medio_pago->setDecodificador($decodificador);
        $medio_pago->setFecha(new \Datetime(fechaByInt($h_fec_archivo)));
        $medio_pago->setNombre_archivo($nombre_archivo);
        $medio_pago->setTipo("pmc");
        //$t_cant_registros = substr($trailer, 16, 7);
        $t_cant_registrosD = substr($trailer, 23, 7);
        //$t_total_importe = substr($trailer, 30, 11);
        $t_total_importeD = substr($trailer, 41, 11);
        //$medio_pago->setTotal($t_total_importeD);
        $medio_pago->setNombre_archivo($nombre_archivo);
        //$medio_pago->setCant_registros($t_cant_registrosD);
        $this->orm->persist($medio_pago);
        $this->orm->flush();

        $para = "";
        $cabeceras = "";
        $mensaje = "";
        $titulo = "";
        $cont_detalles = 0;
        $monto_final = 0.00;

        foreach ($detalles as $detalle) {
            $detalle = trim($detalle);
            $para = "";
            $cabeceras = "";
            $mensaje = "";
            $titulo = "";
            if (empty($detalle)) {
                continue;
            }
            $cont_detalles++;

            $d_cod_registro = substr($detalle, 0, 1);
            $d_nro_referencia = substr($detalle, 1, 19);
            $d_nro_factura = substr($detalle, 20, 20);
            $d_fec_vencimiento = substr($detalle, 40, 8);
            $d_cod_moneda = substr($detalle, 48, 1);
            $d_fec_aplicacion = substr($detalle, 49, 8);
            $d_importe = substr($detalle, 57, 11);
            $d_cod_mov = substr($detalle, 68, 1);
            $d_fec_acreditacion = substr($detalle, 68, 8);
            $d_canal_pago = substr($detalle, 77, 2);
            $d_nro_control = substr($detalle, 79, 4);
            $d_cod_provincia = substr($detalle, 83, 3);
            $d_filler = substr($detalle, 86, 14);

            //parametros para la tabla
            $parameters['facp_monto'] = (int) substr($d_importe, 0, 9) . '.' . substr($d_importe, 9, 2);
            $parameters['facp_fecha_aplicacion'] = fechaByInt($d_fec_aplicacion);
            $parameters['facp_fecha_acreditacion'] = fechaByInt($d_fec_acreditacion);
            $parameters['facp_fac_id'] = $d_nro_factura;
            $parameters['facp_archivo'] = $nombre_archivo;
            $parameters['facp_avisado'] = 0;


            //obj renglón
            $query = "select fac_mensualidad,fac_id,dni,fac_cat_id,fac_usu_id,fac_evento_id,fac_op_id,ev.codigo evento_codigo,cat.codigo categoria_codigo,
                    op.nombre opcion_nombre,fac_op_id
                    from facturas 
                    INNER JOIN inscribite_usuarios ON id = fac_usu_id 
                    LEFT JOIN inscribite_eventos ev ON ev.codigo=fac_evento_id
                    LEFT JOIN inscribite_categorias cat ON cat.codigo=fac_cat_id and cat.deevento=fac_evento_id
                    LEFT JOIN inscribite_opciones op on op.id=fac_op_id
                    where fac_id = $d_nro_factura";
            $fac = $this->db->query($query)->row();


            $renglon_medio = new Decodificado_renglones();
            $renglon_medio->setImporte($parameters['facp_monto']);
            $monto_final = $monto_final + $parameters['facp_monto'];
            $fecha_guardar = substr($d_fec_aplicacion, 0, 4) . "-" . substr($d_fec_aplicacion, 4, 2) . "-" . substr($d_fec_aplicacion, 6, 2);
            $renglon_medio->setFechapago(new \DateTime($fecha_guardar));
            $renglon_medio->setCabecera($medio_pago);
            $fecha_acreditacion = fechaByInt($d_fec_acreditacion);
            $renglon_medio->setFechaacreditacion(new \DateTime($fecha_guardar));

            $renglon_medio->setDni($fac->dni);
            $renglon_medio->setCodigo($d_nro_factura);
            $renglon_medio->setTipo_decodificacion("inscripcion");
            if ($fac->fac_mensualidad > 0) {
                $renglon_medio->setTipo_decodificacion("mensualidad");
            }
            $this->orm->persist($renglon_medio);
            $this->orm->flush();
            $this->db->trans_begin();

            $this->db->query("INSERT INTO facturas_pagas(facp_fecha_aplicacion,facp_fecha_acreditacion,facp_monto,facp_fac_id,facp_archivo,facp_avisado) SELECT '$fecha_guardar','$fecha_acreditacion','{$parameters['facp_monto']}',$d_nro_factura,'',0 avisado ");

            if ($fac->fac_mensualidad <> 0) {
                $this->insertaCuotaMensualidad($fac->dni, $fac->fac_mensualidad, $parameters['facp_monto']);
            } else {
                $this->insertaInscripcionDeportista($parameters['facp_monto'], $fac->dni, $fac->evento_codigo, $fac->categoria_codigo, $fac->fac_op_id, $fac->fac_id);
            }
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
            } else {
                $this->db->trans_commit();
            }
        }
        $medio_pago->setCant_registros($cont_detalles);
        $medio_pago->setTotal($monto_final);
        $this->orm->flush();
        return $medio_pago;
    }

    public function avisaPagos() {

        /* @var $renglon Decodificado_renglones */
        $query = "SELECT dr.dec_id,med_fecha,CONCAT(usu.nombre,' ',usu.apellido) nombre,men_codigo codigo,CONCAT('cuota:',' ',mec_nro_cuota) categoria,usu.dni,med_tipo,dec_importe,concat(men_nombre,' cuota ',mec_nro_cuota) nombre_evento,usu.email,'mensualidad' tipo,'' fecha,'' opcion
                from mediodecodificado
                inner join decodificado_renglones dr on dec_med_id=med_id
                inner join decodificador dc on dc.dec_id=med_dec_id
                inner join facturas on fac_id=dec_codigo
                inner join inscribite_usuarios usu on dni=dec_dni
                inner join mensualidad_cuotas on mec_id=fac_mensualidad
                inner join mensualidades on men_id=mec_men_id
                    where dr.dec_enviado is null and fac_mensualidad>0
                UNION ALL SELECT dr.dec_id,med_fecha,CONCAT(usu.nombre,' ',usu.apellido) nombre,ev.codigo codigo,ins.categoria categoria,usu.dni,med_tipo,dec_importe,
					 ev.nombre nombre_evento,usu.email,'inscripcion' tipo,ev.fecha,op.nombre opcion
                from mediodecodificado
                inner join decodificado_renglones dr on dec_med_id=med_id
                inner join decodificador dc on dc.dec_id=med_dec_id
                inner join facturas on fac_id=dec_codigo
                inner join inscribite_categorias cat on cat.deevento=fac_evento_id and cat.codigo=fac_cat_id
                inner join inscribite_opciones op on op.evento=fac_evento_id and op.id=fac_op_id
                inner join inscribite_usuarios usu on dni=dec_dni
                left join inscribite_eventos ev on ev.codigo=fac_evento_id
                INNER JOIN inscribite_inscripciones ins ON ins.deusuario = dec_dni AND ins.deevento = fac_evento_id AND ins.categoria=cat.nombre AND ins.opcion=op.nombre
                    where dr.dec_enviado is null and fac_mensualidad=0
                UNION ALL 
                SELECT dr.dec_id, med_fecha,CONCAT(usu.nombre,' ',usu.apellido) nombre,ev.codigo codigo,ins.categoria categoria,usu.dni,med_tipo,dec_importe,
					 ev.nombre nombre_evento,usu.email,'inscripcion' tipo,ev.fecha,ins.opcion opcion
                from mediodecodificado
                inner join decodificador dc on dc.dec_id=med_dec_id
                inner join decodificado_renglones dr on dr.dec_med_id=med_id
                inner join inscribite_inscripciones ins on ins.id=dec_codigo
                inner join inscribite_usuarios usu on dni=dec_dni
                left join inscribite_eventos ev on ev.codigo=deevento
                    where dr.dec_enviado is null";
        $renglones_no_enviados = $this->db->query($query)->result();
        foreach ($renglones_no_enviados as $renglon) {
            if ($renglon->tipo == "inscripcion") {
                $contenido = file_get_contents(base_url() . "public/templates/pmc/mail_capacitacion.html");
                $contenido = str_replace('{GENERAL_PATH}', base_url(), $contenido);
                $contenido = str_replace('{NOMBRE}', utf8_decode($renglon->nombre), $contenido);
                $contenido = str_replace('{EMAIL}', $renglon->email, $contenido);
                $contenido = str_replace('{EVENTO}', utf8_decode($renglon->nombre_evento), $contenido);
                $contenido = str_replace('{CATEGORIA}', $renglon->categoria, $contenido);
                $contenido = str_replace('{OPCION}', $renglon->opcion, $contenido);
                $contenido = str_replace('{FECHA}', $renglon->fecha, $contenido);
            } else {
                $contenido = file_get_contents(base_url() . "public/templates/pmc/mail_mensualidad.html");
                $contenido = str_replace('{GENERAL_PATH}', base_url(), $contenido);
                $contenido = str_replace('{NOMBRE}', utf8_decode($renglon->nombre), $contenido);
                $contenido = str_replace('{EMAIL}', $renglon->email, $contenido);
                $contenido = str_replace('{MENSUALIDAD}', utf8_decode($renglon->nombre_evento), $contenido);
            }
            if ($this->mandaMail($renglon->email, "Inscribite Online Pago Registrado", $contenido, "Inscribite Online", true)) {
                $this->db->query("UPDATE decodificado_renglones SET dec_enviado=NOW() WHERE dec_id=" . $renglon->dec_id);
                $this->orm->flush();
            }
        }
    }

    private function avisaPagoInscripcion(&$inscripcion) {
        
    }

    private function avisaPagoMensualidad(&$inscripcion) {
        $query = "SELECT * FROM facturas
                        INNER JOIN mensualidad_cuotas ON mec_id = fac_mensualidad
                        INNER JOIN mensualidades ON men_id = mec_men_id
                        INNER JOIN inscribite_usuarios ON id = fac_usu_id
                        WHERE fac_id = {$inscripcion["fac_id"]}";
        $datos_mensualidad = $this->db->query($query)->row();

        //$para = ' ' . $datos_mensualidad['nombre'] . ' ' . $datos_mensualidad['apellido'] . ' <' . $datos_mensualidad['email'] . '>'; // con coma si son m�s
        $para = "fabianderamo@inscribiteonline.com.ar";
        $titulo = 'Confirmacion de Pago Inscribite Online';
        $cabeceras = 'MIME-Version: 1.0' . "\r\n";
        $cabeceras .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
        $cabeceras .= 'From: Recordatorio <info@inscribiteonline.com.ar>' . "\r\n";
        //$cabeceras .= 'Cc: Recordatorio <info@inscribiteonline.com.ar>' . "\r\n";

        $mensaje = "";
        include base_url('public/templates/pmc/mail_mensualidad.php');
        header('Content-Type: text/html; charset=UTF-8');
        if (mail($para, $titulo, $mensaje, $cabeceras)) {
            $query = "UPDATE facturas_pagas SET facp_avisado = 1 WHERE facp_fac_id = " . $inscripcion["fac_id"];
            $this->query($query);
        }
    }

    private function borrarInscripcionesVencidas() {
        $query = "SELECT id,opcion,deevento FROM inscribite_inscripciones WHERE pagado = 0 AND venceeldia <> 0 AND venceeldia < CURDATE() order by venceeldia desc";
        $datos_aux = $this->db->query($query)->result_array();
        if (count($datos_aux) > 0) {
            foreach ($datos_aux as $key => $inscripcion) {
                if ($key == 0)
                    $out = $inscripcion['id'];
                else
                    $out .= ',' . $inscripcion['id'];

                $this->db->query("UPDATE inscribite_opciones SET cuporestante = cuporestante+1 WHERE nombre = {$inscripcion['opcion']} AND evento = {$inscripcion['deevento']}");
            }
            $query = "UPDATE inscribite_inscripciones SET eliminada=1 WHERE id in($out)";
            $this->db->query($query);
        }

        $query = "SELECT id,opcion,deevento FROM facturas
                INNER JOIN inscribite_inscripciones ON deevento = fac_evento_id AND deusuario = (SELECT dni FROM inscribite_usuarios WHERE id = fac_usu_id)
                WHERE fac_id not in (SELECT facp_fac_id FROM facturas_pagas)
                AND fac_fecha_in < CURDATE() - INTERVAL 7 DAY 
                AND iniciadoeldia < CURDATE() - INTERVAL 7 DAY  
                AND pagado = 0
                AND pmc = 1";
        $inscripciones_caidas = $this->db->query($query)->result_array();
        foreach ($inscripciones_caidas as $key => $inscripcion) {
            $out .= ($key == 0) ? $inscripcion['id'] : "," . $inscripcion['id'];
            $this->db->query("UPDATE inscribite_opciones SET cuporestante = cuporestante+1 WHERE nombre = {$inscripcion['opcion']} AND evento = {$inscripcion['deevento']}");
        }
        $this->db->query("UPDATE inscribite_inscripciones SET eliminada=1 WHERE id in($out)");
    }

    public function getDecodificadorAjax($information) {
        $out = array();
        $where_venta = "";
        if ($information["limit"]) {
            $limit = $information["limit"];
        } else {
            $limit = 20;
        }
        $offset = 0;
        if ($information["offset"]) {
            $offset = $information["offset"];
        }
        $orden = "ASC";
        switch ($information["order"]) {
            case "asc" :
                $orden = "ASC";
                break;
            case "desc" :
                $orden = "DESC";
                break;
        }

        $query = $this->orm->createQuery("SELECT c FROM Decodificador c $where_venta ORDER BY c.id DESC")->setFirstResult($offset)->setMaxResults($limit);
        $decodificadors = $query->getResult();
        $data ["total"] = $this->orm->createQuery("SELECT count(c) FROM Decodificador c $where_venta")->setMaxResults(1)->getSingleScalarResult();
        foreach ($decodificadors as $decodificador) {
            $out [] = $decodificador->getDatosArray();
        }
        $data ["rows"] = $out;
        return $data;
    }

    function borrar($dec_id) {
        $this->db->trans_start();
        $decodificador = $this->orm->createQuery("SELECT d FROM Decodificador d WHERE d.id=:deco")->setParameter("deco", $dec_id)->getSingleResult();
        $meds_id = "";
        $k = 0;
        if ($decodificador->getPagomiscuentas()) {
            $meds_id = $decodificador->getPagomiscuentas()->getId();
            $k++;
        }
        if ($decodificador->getRapipago()) {
            $meds_id .= ($k > 0 ? "," : "") . $decodificador->getRapipago()->getId();
            $k++;
        }
        if ($decodificador->getPagofacil()) {
            $meds_id .= ($k > 0 ? "," : "") . $decodificador->getPagofacil()->getId();
        }
        $this->db->query("DELETE FROM decodificado_renglones WHERE dec_med_id in($meds_id)");
        $this->db->query("DELETE FROM mediodecodificado WHERE med_id in($meds_id)");
        $this->orm->remove($decodificador);
        $this->orm->flush();
        $this->db->trans_complete();
    }

    function xls_acumulado($tipo) {
        if ($tipo == "pmc") {
            $query = "SELECT 'pmc' medio,dc.dec_id,CONCAT(dec_dni,' ',nombre,' ',apellido) cliente,fac_evento_id evento,fac_cat_id categoria,'testing' organizador,dec_importe,'test_terminal' terminal,dec_fechapago,'' hora,'inscribite' FROM `decodificador` dc
          inner join mediodecodificado on med_id=dec_pagomiscuentas
          inner join decodificado_renglones dr on dr.dec_med_id=med_id
          left join facturas on fac_id=dec_codigo
          left join inscribite_usuarios on dni=dec_dni";
        }
        if ($tipo == "rp") {
            $query = "
SELECT 'rp' medio,dc.dec_id,CONCAT(dec_dni,' ',nombre,' ',apellido) cliente,fac_evento_id evento,fac_cat_id categoria,'testing' organizador,dec_importe,'test_terminal' terminal,dec_fechapago,'' hora,'inscribite' FROM `decodificador` dc
          inner join mediodecodificado on med_id=dec_rapipago
          inner join decodificado_renglones dr on dr.dec_med_id=med_id
          left join facturas on fac_id=dec_codigo
          left join inscribite_usuarios on dni=dec_dni";
        }
        if ($tipo == "pf") {
            $query = "
SELECT 'pf' medio,dc.dec_id,CONCAT(dec_dni,' ',nombre,' ',apellido) cliente,fac_evento_id evento,fac_cat_id categoria,'testing' organizador,dec_importe,'test_terminal' terminal,dec_fechapago,'' hora,'inscribite' FROM `decodificador` dc
          inner join mediodecodificado on med_id=dec_pagofacil
          inner join decodificado_renglones dr on dr.dec_med_id=med_id
          left join facturas on fac_id=dec_codigo
          left join inscribite_usuarios on dni=dec_dni
          union all
SELECT 'pf' medio,dc.dec_id,CONCAT(dec_dni,' ',nombre,' ',apellido) cliente,fac_evento_id evento,fac_cat_id categoria,'testing' organizador,dec_importe,'test_terminal' terminal,dec_fechapago,'' hora,'inscribite' FROM `decodificador` dc
          inner join mediodecodificado on med_id=dec_pagofacilinterior
          inner join decodificado_renglones dr on dr.dec_med_id=med_id
          left join facturas on fac_id=dec_codigo
          left join inscribite_usuarios on dni=dec_dni";
        }

        $q = $this->db->query($query);
        $sql["query"] = $q;
        $sql["fields"] = array("medio", "nro", "cliente", "evento", "categoria", "organizador", "monto", "terminal", "fecha", "hora", "sistema");
        to_excel($sql);
    }

    function xls_decodificador($dec_id) {
        $query = "SELECT dr.dec_id,med_fecha,CONCAT(usu.nombre,' ',usu.apellido) nombre,men_codigo codigo,CONCAT('cuota:',' ',mec_nro_cuota) categoria,usu.dni,med_tipo,dec_importe,concat(men_nombre,' cuota ',mec_nro_cuota) nombre_evento
                from mediodecodificado
                inner join decodificado_renglones dr on dec_med_id=med_id
                inner join decodificador dc on dc.dec_id=med_dec_id
                inner join facturas on fac_id=dec_codigo
                inner join inscribite_usuarios usu on dni=dec_dni
                inner join mensualidad_cuotas on mec_id=fac_mensualidad
                inner join mensualidades on men_id=mec_men_id
                where dc.dec_id=$dec_id and fac_mensualidad>0
                UNION ALL SELECT dr.dec_id,med_fecha,CONCAT(usu.nombre,' ',usu.apellido) nombre,ev.codigo codigo,ins.categoria categoria,usu.dni,med_tipo,dec_importe,ev.nombre nombre_evento
                from mediodecodificado
                inner join decodificado_renglones dr on dec_med_id=med_id
                inner join decodificador dc on dc.dec_id=med_dec_id
                inner join facturas on fac_id=dec_codigo
                inner join inscribite_categorias cat on cat.deevento=fac_evento_id and cat.codigo=fac_cat_id
                inner join inscribite_opciones op on op.evento=fac_evento_id and op.id=fac_op_id
                inner join inscribite_usuarios usu on dni=dec_dni
                left join inscribite_eventos ev on ev.codigo=fac_evento_id
                INNER JOIN inscribite_inscripciones ins ON ins.deusuario = dec_dni AND ins.deevento = fac_evento_id AND LOWER(ins.categoria)=LOWER(cat.nombre) AND LOWER(ins.opcion)=LOWER(op.nombre)
                where dc.dec_id=$dec_id and fac_mensualidad=0
                UNION ALL 
                SELECT dr.dec_id, med_fecha,CONCAT(usu.nombre,' ',usu.apellido) nombre,ev.codigo codigo,ins.categoria categoria,usu.dni,med_tipo,dec_importe,ev.nombre nombre_evento
                from mediodecodificado
                inner join decodificador dc on dc.dec_id=med_dec_id
                inner join decodificado_renglones dr on dr.dec_med_id=med_id
                inner join inscribite_inscripciones ins on ins.id=dec_codigo and ins.deusuario=dec_dni
                inner join inscribite_usuarios usu on dni=dec_dni
                left join inscribite_eventos ev on ev.codigo=deevento
                    where dc.dec_id=$dec_id";
        
        $q = $this->db->query($query);
        $sql["query"] = $q;
        $sql["fields"] = array("id", "fecha archivo", "nombre", "codigo", "categoria", "dni", "tipo", "importe", "concepto");
        to_excel($sql);
    }

}
