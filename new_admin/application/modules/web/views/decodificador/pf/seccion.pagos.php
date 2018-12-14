<?php
if ($_GET['reprocesar'] != '') {
    $archivo = 'filepfacil/' . $_GET['reprocesar'];
    //$_POST['prueba'] = 1;
    //$noGrabarEnBase = true;
    $procesar = true;
    $_POST['acc'] = 'filepfupload';
}

if ($_POST['acc'] == 'filepfupload') {
    $cuentaarray_lmef = -1;
    $cuentaarray_insco = -1;
    $cuentaarray_cobo = -1;
    $cuentaGrabadosInscribite = 0;

    if ($_POST['prueba'] == 1)
        $noGrabarEnBase = true;
    else
        $noGrabarEnBase = false;

    function agceros($nombreag, $cantceros) {
        while (strlen($nombreag) < $cantceros)
            $nombreag = "0" . $nombreag;
        return $nombreag;
    }

    if (move_uploaded_file($_FILES['archivopf']['tmp_name'], 'filepfacil/' . $_FILES['archivopf']['name'])) {
        $archivo = 'filepfacil/' . $_FILES['archivopf']['name'];
        $fecha = substr($archivo, -6, 2) . substr($archivo, -8, 2) . substr($archivo, -10, 2);
        mysql_query("INSERT INTO pagofacil_archivos (" . "\n" .
                "`archivo_id`, " . "\n" .
                "`archivo_fecha`, " . "\n" .
                "`archivo_nombre` " . "\n" .
                ") VALUES (" . "\n" .
                "NULL, " . "\n" .
                "'" . $fecha . "', " . "\n" .
                "'" . $_FILES['archivopf']['name'] . "');");
        $procesar = true;
    }
    if ($procesar) {
        $fp = fopen($archivo, 'r');
        if (filesize($archivo) > 0)
            $conte = fread($fp, filesize($archivo));
        fclose($fp)
        ?>
        <div class="lineatituybotnuevo">
            <span class="titulopag">Archivo de Pago Fácil<? if ($noGrabarEnBase) echo '<span style="font-size:12px;color:#666;font-weight:normal;margin-left:15px;">Prueba de sistema, sin operar en base</span>'?></span>
        </div>
        <div style="float:left;clear:left;width:100%;">
            <?php
            $ar_dlmef = Array();
            $ar_dcobo = Array();
            $ar_insco = Array();
            $listaidsPagos = Array();
            $ar_listaIdsPagosTipo = Array();
            $arraydeempresas = array();

            $correccion = 0;
            if ((substr($conte, 137, 2) > 31) || (substr($conte, 135 + $correccion, 2) > 12) || (substr($conte, 131 + $correccion, 4) < 1990))
                $correccion = -2;
            $posant = 260 + $correccion;
            while (substr($conte, $posant, 1) == 5) {
                $primeros4cod = substr($conte, $posant + 24, 4);

                $ar_tiposEntregas = Array('', 'Digital', '');

                $fechacobrado = (substr($conte, $posant + 22, 2) * 1) . '/' . (substr($conte, $posant + 20, 2) * 1) . '/' . (substr($conte, $posant + 18, 2) * 1);

                $monto_pagado = substr($conte, $posant + 48, 8) * 1;
                $monto_pagado .= ',' . substr('00' . (substr($conte, $posant + 56, 2) + 0), -2, 2);


                if ($primeros4cod == 8888) {
                    // Si son de Lo Mejor En Fotos
                    cerrarDb();
                    $coneccion = mysql_connect("localhost", "lomejor_lomejor", "lo919");
                    mysql_select_db("lomejor_lmef", $coneccion);

                    $idcompra = substr($conte, $posant + 28, 10) * 1;

                    $result1 = mysql_query('SELECT * FROM lmef_pedidos WHERE id = "' . $idcompra . '" LIMIT 1');
                    if ($row1 = mysql_fetch_array($result1)) {

                        $upd1 = "UPDATE lmef_pedidos SET pagado = 1 WHERE id = " . $row1['id'] . " LIMIT 1";
                        if (!$noGrabarEnBase)
                            mysql_query($upd1);

                        //echo $upd1."<br/>"."\n";
                        $upd2 = "UPDATE lmef_pedidos SET archivopagofacil = '" . $_FILES['archivopf']['name'] . "' WHERE id = " . $row1['id'] . " LIMIT 1";
                        if (!$noGrabarEnBase)
                            mysql_query($upd2);
                        //echo $upd2."<br/>"."\n";

                        if ($row1['entregada'] == 0) {
                            array_push($listaidsPagos, $row1['id']);
                            array_push($ar_listaIdsPagosTipo, 'lomejor');
                        }
                        $result2 = mysql_query('SELECT * FROM lmef_usuarios WHERE id = "' . $row1['usuario'] . '" LIMIT 1');
                        $usuario = mysql_fetch_array($result2);

                        $fotos = '';
                        $coma = '';
                        $ar_fotos = explode(',', $row1['fotos']);
                        foreach ($ar_fotos AS $cadafoto) {
                            $ar_cadafoto = explode('_', $cadafoto);
                            if (trim($ar_cadafoto[1]) != '') {
                                $fotos .= $coma . trim($ar_cadafoto[1]);
                                $coma = ', ';
                            }
                        }
                        $row1['eventos_de_fotos'] = '';
                        $row1['fotografo_de_fotos'] = '';
                        $coma = '';
                        $result3 = mysql_query('SELECT lmef_albumes.evento, ' .
                                'lmef_eventos.nombresinac, ' .
                                'lmef_fotografos.nombre, ' .
                                'lmef_fotografos.apellido, ' .
                                'lmef_fotografos.nombresinac AS nombresinac_fotografo ' .
                                'FROM lmef_albumes ' .
                                'LEFT JOIN lmef_fotos ON lmef_albumes.id = lmef_fotos.album ' .
                                'LEFT JOIN lmef_eventos ON lmef_albumes.evento = lmef_eventos.id ' .
                                'LEFT JOIN lmef_fotografos ON lmef_albumes.fotografo = lmef_fotografos.id ' .
                                'WHERE lmef_fotos.id IN (' . $fotos . ') LIMIT 1');
                        while ($album = mysql_fetch_array($result3)) {
                            $row1['eventos_de_fotos'] .= $coma . '<a href="http://www.lomejorenfotos.com.ar/evento/' . $album['nombresinac'] . '" target="_blank">' . $album['evento'] . '</a>';
                            $row1['fotografo_de_fotos'] .= $coma . '<a href="http://www.lomejorenfotos.com.ar/fotografo/' . $album['nombresinac_fotografo'] . '" target="_blank">' . $album['nombre'] . ' ' . $album['apellido'] . '</a>';
                            $coma = ', ';
                        }

                        $usuario['deudor_nombre'] = $usuario['nombre'] . ' ' . $usuario['apellido'];
                        $usuario['deudor_email'] = $usuario['email'];
                        $usuario['deudor_dni'] = $usuario['dni'];
                        $row1['cobro_monto'] = number_format($row1['importe'], 2, ',', '.');
                        //$row1['cobro_monto2'] = 
                        $row1['cupon_codigodebarras'] = substr($conte, $posant + 24, 14);
                    }
                } elseif ($primeros4cod == 8889) {
                    // Si son de Cobre Online
                    cerrarDb();
                    $coneccion = mysql_connect("localhost", "cobreonline_user", "n7lrKSQcKFBCpENdqaB5");
                    mysql_select_db("cobreonline_base", $coneccion);

                    $idcompra = substr($conte, $posant + 28, 10) * 1;

                    $result1 = mysql_query($q = 'SELECT * FROM cobreonline_cupones ' . "\n" .
                            'LEFT JOIN cobreonline_cobros ON cobreonline_cupones.cupon_cobro = cobreonline_cobros.cobro_id ' . "\n" .
                            //'LEFT JOIN cobreonline_grupos_de_cobros ON cobreonline_cobros.cobro_grupo_de_cobros = cobreonline_grupos_de_cobros.grupo_id '."\n".
                            'LEFT JOIN cobreonline_entidades_cobradoras ON cobreonline_cobros.cobro_entidad = cobreonline_entidades_cobradoras.entidad_id ' . "\n" .
                            'WHERE cobreonline_cupones.cupon_id = "' . $idcompra . '" LIMIT 1');
                    if ($row1 = mysql_fetch_array($result1)) {
                        $upd1 = "UPDATE cobreonline_cupones SET cupon_fechacobrado = '" . substr($conte, $posant + 16, 8) . "', cupon_montocobrado = '" . $monto_pagado . "' WHERE cupon_id = " . $row1['cupon_id'] . " LIMIT 1";
                        if (!$noGrabarEnBase)
                            mysql_query($upd1);
                        //echo $upd1."<br/>"."\n";
                        // No hay variable de entregado todavía. Debería ser "avisado a la entidad" o algo así
                        if ($row1['entregada'] == 0) {
                            array_push($listaidsPagos, $row1['cupon_id']);
                            array_push($ar_listaIdsPagosTipo, 'cobreonline');
                        }
                        $result2 = mysql_query('SELECT * FROM cobreonline_deudores WHERE deudor_id = "' . $row1['cupon_deudor'] . '" LIMIT 1');
                        $usuario = mysql_fetch_array($result2);

                        $row1['cupon_codigodebarras'] = substr($row1['cupon_codigodebarras'], 22, 14);

                        //$result2 = mysql_query('SELECT * FROM cobreonline_grupos_de_cobros WHERE grupo_id = "'.$row1['cobro_grupo_de_cobros'].'" LIMIT 1');
                        //$grupo_de_cobros = mysql_fetch_array($result2);
                        //$row1['cobro_grupo_de_cobros'] = $grupo_de_cobros['grupo_nombre'];
                    }
                } else {


                    $primeros4cod = substr($conte, $posant + 24, 4);
                    $cateencod = substr($conte, $posant + 28, 2);
                    $eldni = trim((substr($conte, $posant + 30, 15) + 0));
                    if ($cateencod)

                    // Si son de Inscribite Online, de aquí a la linea 190
                        cerrarDb();
                    $coneccion = mysql_connect("localhost", "inscribite_user", "iW7zNKpRWkSHHwplBhUO");
                    mysql_select_db("inscribite_base", $coneccion);

                    $tieneMensualidad = false;
                    //$tiene_mensualidad = mysql_query('SELECT * FROM facturas WHERE fac_usu_id = (select id from inscribite_usuarios where dni = '.$eldni.') and fac_mensualidad = '.$cateencod.' and )fac_tipo = 2 or fac_tipo= 3) ');
                    $tiene_mensualidad = mysql_query('SELECT * FROM facturas WHERE fac_usu_id = (select id from inscribite_usuarios where dni = ' . $eldni . ') and fac_mensualidad = ' . $cateencod . ' and (fac_tipo = 2 or fac_tipo= 3) ');
                    if ($tiene_mensualidad) {
                        while ($dato_usuario = mysql_fetch_array($tiene_mensualidad)) {
                            if ($dato_usuario['fac_id']) {
                                $tieneMensualidad = true;
                                break;
                            }
                        }
                    }


                    //esta pagando mensualidades iooou mr white
                    if ($tieneMensualidad) {
                        $eldni = trim((substr($conte, $posant + 30, 15) + 0));
                        $cateencod = substr($conte, $posant + 28, 2);
                        $fechadpagodia = substr($conte, $posant + 70, 2);
                        $fechadpagomes = substr($conte, $posant + 68, 2);
                        $fechadpagoanio = substr($conte, $posant + 64, 4);
                        $fechadpagohora = substr($conte, $posant + 72, 2);
                        $fechadpagominutos = substr($conte, $posant + 74, 2);

                        $fechadePago = $fechadpagoanio . '-' . $fechadpagomes . '-' . $fechadpagodia . ' ' . $fechadpagohora . ':' . $fechadpagominutos . ':00';
                        $fechadePago = date('Y-m-d h:i:s', strtotime($fechadePago));


                        $ya_registro_pago = mysql_query("SELECT meu_id FROM mensualidad_cuota_usuario where meu_u_dni  = $eldni and meu_mec_id = $cateencod");
                        if ($ya_registro_pago) {
                            while ($datos = mysql_fetch_array($ya_registro_pago)) {
                                if ($datos['meu_id']) {
                                    $ya_registro_pago = true;
                                    break;
                                }
                            }
                        }
                        if ($ya_registro_pago) {
                            $insertaMensualidad = "INSERT INTO mensualidad_cuota_usuario (meu_u_dni,meu_mec_id,meu_importe,meu_fecha) 
            VALUES ('" . agceros($eldni, 8) . "','" . $cateencod . "','" . $monto_pagado . "','" . $fechadePago . "')";

                            mysql_query($insertaMensualidad);
                        }


                        $query = "SELECT email,nombre,apellido,dni,men_nombre,men_codigo
            FROM inscribite_usuarios 
            INNER JOIN mensualidad_cuota_usuario ON meu_u_dni = dni 
            INNER JOIN mensualidad_cuotas ON mec_id= meu_mec_id
            INNER JOIN mensualidades ON men_id= mec_men_id
            WHERE dni = $eldni";

                        $datos_mensualidad = mysql_query($query);
                        while ($dato = mysql_fetch_array($datos_mensualidad)) {
                            $datos['mensualidad'] = $dato['men_nombre'];
                            $datos['codigo'] = $dato['men_nombre'];
                            $datos['nombre'] = $dato['nombre'];
                            $datos['apellido'] = $dato['apellido'];
                            $datos['email'] = $dato['email'];
                        }
                        $datos['fecha'] = $fechadePago;
                        $datos['dni'] = $eldni;
                        $datos['monto'] = $monto_pagado;
                        $info_adicional = "From: Inscribite Online <info@inscribiteonline.com.ar>\r\nContent-Type: text/html;charset=utf-8\r\n";

                        $mensaje = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
            <html>
            <head>
            <title>Inscribite Online</title>
            <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
            </head>
            <body>
            <br>
            <div align="center">
            <p><a href="http://www.inscribiteonline.com.ar/"><img src="http://www.inscribiteonline.com.ar/newsite2014/webimages/bannermail.png" width="280" height="100" border="0"></a></p>

            <br>                    
            <span>
            Confirmaci&oacute;n de Pago
            </span>
            <br>
            <span>
            Nombre y apellido: ' . $datos['nombre'] . ', ' . $datos['apellido'] . '
            </span>
            <br>
            <span>
            Mensualidad: ' . $datos['mensualidad'] . '
            </span>
            <br>
            <span>
            C&oacute;digo: ' . $datos['codigo'] . '
            </span>
            <br>
            <span>
            Monto: ' . $datos['monto'] . '
            </span>
            <br>
            <span>
            Fecha: ' . date('d-m-Y', strtotime($datos['fecha'])) . '
            </span>			
            ';
                        $mensaje.='
            <table width="600" height="25" border="0" cellpadding="0" cellspacing="5" background="http://www.inscribiteonline.com.ar/newsite2014/webimages/footer.gif">
            <tr>
            <td><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">MARITIMO SRL / 4641-4423 4643-1124 / info@inscribiteonline.com.ar </font></td>
            </tr>
            </table>
            <p>&nbsp;</p>
            </div>
            </body>
            </html>';

                        mail($datos['email'], 'Confirmacion de Pago - Inscribite Online', $mensaje, $info_adicional);
                    } else {


                        $listamails = Array();
                        $listaids = Array();
                        $listacods = Array();

                        $eldni = trim((substr($conte, $posant + 30, 15) + 0));
                        $result1 = mysql_query('SELECT * FROM inscribite_usuarios WHERE dni = "' . $eldni . '" LIMIT 1');
                        $usuario = mysql_fetch_array($result1);

                        $elcodigoes = $primeros4cod . $cateencod . agceros($eldni, 8);

                        $selemandomail = 0;

                        $result2 = mysql_query('SELECT id, deevento, selemandomail, venceeldia, cargopuntos FROM inscribite_inscripciones WHERE codigo = "' . $elcodigoes . '" ORDER BY id DESC LIMIT 1');
                        if ($inscripcion = mysql_fetch_array($result2)) {
                            $iddeinscr = $inscripcion['id'];
                            $selemandomail = $inscripcion['selemandomail'];
                            $cargopuntos = $inscripcion['cargopuntos'];
                        }
                        if ((mysql_num_rows($result2) == 0) || ($_POST['prueba'] == 1)) {
                            $result3 = mysql_query('SELECT nombre, empresa FROM inscribite_eventos WHERE codigo = "' . $primeros4cod . '" LIMIT 1');
                            $row3 = mysql_fetch_array($result3);
                            $empresa = $row3['empresa'];
                            array_push($arraydeempresas, $row1['empresa']);
                            $nombreevento = $row3['nombre'];

                            $result3 = mysql_query('SELECT opcion FROM inscribite_categorias WHERE deevento = "' . $primeros4cod . '" AND codigo = "' . $cateencod . '" LIMIT 1');
                            $row3 = mysql_fetch_array($result3);

                            $insertInscripcion = "INSERT INTO inscribite_inscripciones (" . "\n" .
                                    "`id`, " . "\n" .
                                    "`deusuario`, " . "\n" .
                                    "`empresa`, " . "\n" .
                                    "`deevento`, " . "\n" .
                                    "`categoria`, " . "\n" .
                                    "`opcion`, " . "\n" .
                                    "`codigo`" . "\n" .
                                    ") VALUES (" . "\n" .
                                    "'', " . "\n" .
                                    "'" . agceros($eldni, 8) . "', " . "\n" .
                                    "'" . $empresa . "', " . "\n" .
                                    "'" . $primeros4cod . "', " . "\n" .
                                    "'" . $cateencod . "', " . "\n" .
                                    "'" . $row3['opcion'] . "', " . "\n" .
                                    "'" . $elcodigoes . "');";
                            //echo $cateencod."<br/>\n";
                            if (!$noGrabarEnBase) {
                                mysql_query($insertInscripcion);
                            }
                            //echo ' (agregado)';
                        }
                        //echo '123: '.$cateencod.'<br/>'."\n";

                        $result3 = mysql_query('SELECT nombre, tipo, empresa FROM inscribite_eventos WHERE codigo = "' . $primeros4cod . '" LIMIT 1');
                        $row3 = mysql_fetch_array($result3);
                        $nombreevento = $row3['nombre'];
                        $empresaevento = $row3['nombre'];

                        if ($row3['tipo'] == 'Capacitación')
                            $selemandomail = 0;
                        if ($row3['tipo'] == 'Servicios')
                            $selemandomail = 0;

                        $fechadpagodia = substr($conte, $posant + 70, 2);
                        $fechadpagomes = substr($conte, $posant + 68, 2);
                        $fechadpagoanio = substr($conte, $posant + 64, 4);
                        $fechadpagohora = substr($conte, $posant + 72, 2);
                        $fechadpagominutos = substr($conte, $posant + 74, 2);

                        $cuentaGrabadosInscribite++;
                        $query = 'UPDATE inscribite_inscripciones SET pagado = 1, pagoeldia = "' . $fechadpagoanio . "-" . $fechadpagomes . "-" . $fechadpagodia . ' ' . $fechadpagohora . ':' . $fechadpagominutos . ':00", precio = "' . $monto_pagado . '" WHERE id = ' . $iddeinscr . ' LIMIT 1';
                        $grabado = '<abbr title="' . str_replace('"', "'", $query) . '" style="color:red;">Grabado</abbr>';
                        if (!$noGrabarEnBase) {
                            mysql_query($query);
                        }
                        if ($cargopuntos != 1) {
                            $result3 = mysql_query('SELECT puntos FROM inscribite_eventos WHERE codigo = "' . $primeros4cod . '" LIMIT 1');
                            $row3 = mysql_fetch_array($result3);
                            $puntosqcarga = $row3['puntos'];
                            if (!$noGrabarEnBase)
                                mysql_query("UPDATE inscribite_usuarios SET puntos = puntos+" . $puntosqcarga . " WHERE dni = '" . $eldni . "' OR dni = '" . agceros($eldni, 8) . "' ");
                            if (!$noGrabarEnBase)
                                mysql_query('UPDATE inscribite_inscripciones SET cargopuntos = 0 WHERE id = ' . $iddeinscr . ' LIMIT 1');
                        }
                        $usuario['deudor_nombre'] = $usuario['nombre'] . ' ' . $usuario['apellido'];
                        $usuario['deudor_email'] = $usuario['email'];
                        $usuario['deudor_email'] = $usuario['dni'];
                        $row1['cobro_monto'] = $monto_pagado;
                        //$row1['cobro_monto2'] = 
                        $row1['cupon_codigodebarras'] = $primeros4cod . $cateencod . trim($eldni);
                    }
                }

                $ar_tds = Array();

                $ar_tds[1] = (substr($conte, $posant + 1, 5) + 0);
                $ar_tds[2] = $fechacobrado;
                //$ar_tds[3]  = $usuario['deudor_nombre'].' ('.$usuario['deudor_email'].')';
                $ar_tds[3] = $usuario['deudor_nombre'];
                $ar_tds[4] = $row1['cupon_codigodebarras'];
                $ar_tds[5] = ((substr($conte, $posant + 45, 3) == "PES") ? "$" : substr($conte, $posant + 45, 3));
                $ar_tds[6] = str_replace('.', ',', $row1['cobro_monto']);
                //.(($row1['cobro_monto2'] != '')?' / '.str_replace('.', ',', $row1['cobro_monto2']):'');
                $ar_tds[7] = $monto_pagado;
                $ar_tds[8] = substr($conte, $posant + 58, 6);
                $ar_tds[9] = (substr($conte, $posant + 70, 2) * 1) . '/' . (substr($conte, $posant + 68, 2) * 1) . '/' . substr($conte, $posant + 66, 2);
                $ar_tds[10] = substr($conte, $posant + 72, 2) . ':' . substr($conte, $posant + 74, 2);
                $ar_tds[11] = $row1['id'];
                $ar_tds[12] = (($row1['entregada']) ? 'Enviado' : $grabado);
                $grabado = '';

                $ar_tds['eventos_de_fotos'] = $row1['eventos_de_fotos'];
                $ar_tds['fotografo_de_fotos'] = $row1['fotografo_de_fotos'];

                $ar_tds['cobro_id'] = $row1['cobro_id'];
                $ar_tds['cobro_concepto'] = $row1['cobro_concepto'];

                cerrarDb();
                include 'inc.config.php';

                mysql_query("INSERT INTO pagofacil_acumulado (" . "\n" .
                        "`acumulado_id`, " . "\n" .
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
                        "NULL, " . "\n" .
                        "'" . $ar_tds[1] . "', " . "\n" . // acumulado_nro`, ".
                        "'" . $ar_tds[2] . "', " . "\n" . // acumulado_fecha`, ".
                        "'" . $usuario['deudor_dni'] . ' ' . $usuario['deudor_nombre'] . "', " . "\n" . // acumulado_cliente`, ".
                        "'" . (substr($ar_tds[4], 4) * 1) . "', " . "\n" . // acumulado_ev`, ".
                        "'" . $ar_tds[5] . "', " . "\n" . // acumulado_categ`, ".
                        "'" . $ar_tds[6] . "', " . "\n" . // acumulado_monto`, ".
                        "'" . $ar_tds[8] . "', " . "\n" . // acumulado_terminal`, ".
                        "'" . $ar_tds[9] . "', " . "\n" . // acumulado_fecha_cobrado
                        "'" . $ar_tds[10] . "'" . "\n" . // acumulado_hora` ".
                        ");");

                if ($primeros4cod == 8888) {
                    // Si son de Lo Mejor En Fotos
                    $cuentaarray_lmef++;
                    $ar_dlmef[$cuentaarray_lmef] = Array();
                    for ($r = 1; $r <= 12; $r++)
                        $ar_dlmef[$cuentaarray_lmef]['td' . substr(('0' . $r), -2, 2)] = $ar_tds[$r];
                    $ar_dlmef[$cuentaarray_lmef]['eventos_de_fotos'] = $ar_tds['eventos_de_fotos'];
                    $ar_dlmef[$cuentaarray_lmef]['fotografo_de_fotos'] = $ar_tds['fotografo_de_fotos'];
                } elseif ($primeros4cod == 8889) {
                    // Si son de Cobre Online
                    $cuentaarray_cobo++;
                    $ar_dcobo[$cuentaarray_cobo] = Array();
                    for ($r = 1; $r <= 12; $r++)
                        $ar_dcobo[$cuentaarray_cobo]['td' . substr(('0' . $r), -2, 2)] = $ar_tds[$r];
                    $ar_dcobo[$cuentaarray_cobo]['entidad'] = $row1['entidad_nombre'];
                    $ar_dcobo[$cuentaarray_cobo]['cobro_concepto'] = $ar_tds['cobro_concepto'];
                    $ar_dcobo[$cuentaarray_cobo]['cobro_id'] = $ar_tds['cobro_id'];
                } else {
                    // Si son de Inscribite Online
                    $cuentaarray_insco++;
                    $ar_insco[$cuentaarray_insco] = Array();
                    for ($r = 1; $r <= 12; $r++)
                        $ar_insco[$cuentaarray_insco]['td' . substr(('0' . $r), -2, 2)] = $ar_tds[$r];
                    $ar_insco[$cuentaarray_insco]['td11'] = $inscripcion['id'];
                    if ($selemandomail) {
                        $ar_insco[$cuentaarray_insco]['td12'] = 'Enviado';
                    } else {
                        if ($inscripcion['id'] != '') {
                            array_push($listaidsPagos, $inscripcion['id']);
                            array_push($ar_listaIdsPagosTipo, 'inscribite');
                        }
                    }

                    $ar_insco[$cuentaarray_insco]['eldni'] = $eldni;
                    $ar_insco[$cuentaarray_insco]['nombre'] = $usuario['deudor_nombre'];

                    $ar_insco[$cuentaarray_insco]['primeros4cod'] = $primeros4cod;
                    $ar_insco[$cuentaarray_insco]['evento'] = $cateencod;
                    $ar_insco[$cuentaarray_insco]['precio'] = $monto_pagado;
                    $ar_insco[$cuentaarray_insco]['terminal'] = substr($conte, $posant + 58, 6);
                    $ar_insco[$cuentaarray_insco]['horadpago'] = $fechadpagohora . ':' . $fechadpagominutos;

                    $ar_insco[$cuentaarray_insco]['evento_nombre'] = $nombreevento;
                    $ar_insco[$cuentaarray_insco]['evento_organizador'] = $empresaevento;
                }

                $posant = $posant + 390;
                //correccion de un archivo con 3 caracteres menos
                if ((substr($conte, $posant, 1) != 5) && (substr($conte, $posant - 3, 1) == 5))
                    $posant -= 3;
            }
            ?>
            <div class="divtabla">
                <div style="float:left;width:100%;">
                    <div style="font-size:11px;line-height:18px;margin-bottom:20px;float:left;width:50%;line-height:19px;">
                        <strong class="nombredato">Fecha:</strong>       <span><?= substr($conte, 7, 2) . '/' . substr($conte, 5, 2) . '/' . substr($conte, 1, 4) ?></span><br/>
                        <strong class="nombredato">Origin Name:</strong> <span><?= trim(substr($conte, 9, 25)) ?></span><br/>
                        <strong class="nombredato">ID Empresa:</strong>  <span><?= substr($conte, 34, 9) ?></span><br/>
                        <? /*				<strong class="nombredato">Empresa:</strong>     <span><?= substr($conte, 43, 15) ?></span><br/><br/> */ ?>
                    </div>
                    <div style="font-size:11px;line-height:18px;margin-bottom:20px;float:right;width:320px;line-height:20px;">
                        <strong class="nombredato">Transacciones:</strong> <span id="cantTransacciones"></span><br/>
                        <strong class="nombredato">De Inscribite Online:</strong> <span><?= ($cuentaarray_insco + 1) ?></span>
                        <strong class="nombredato" style="margin-left:11px;">Grabadas en base de IO:</strong> <span><?= $cuentaGrabadosInscribite ?></span><br/>
                        <strong class="nombredato">Emails a enviar:</strong> <span id="cantEmailsAEnviar"></span>
                        <strong class="nombredato" style="margin-left:11px;">Enviados:</strong> <span id="cantEmailsEnviados"></span><br/>
                        <strong class="nombredato">Proceso ajax:</strong> <input type="text" id="procesoAjax" style="width:175px;margin-left:11px;font-size:10px;margin-top:3px;"/>
                    </div>
                </div>
                <table style="margin-bottom:20px;float:left;width:100%;">
                    <tr style="font-size:12px;">
                        <th style="font-weight:normal;border-right:1px #eee solid;text-align:center;">#</th>
                        <th style="font-weight:normal;text-align:center;border-right:1px #eee solid;">Sistema</th>
                        <th style="font-weight:normal;border-right:1px #eee solid;">Creado</th>
                        <th style="font-weight:normal;text-align:center;border-right:1px #eee solid;">Usuario</th>
                        <td style="border-right:1px #eee solid;">Evento / Cobro</td>
                        <td style="border-right:1px #eee solid;">Categ./<br/>Id Compra</td>
                        <td style="border-right:1px #eee solid;">Organizador/<br/>Fotógrafo</td>
                        <td style="border-right:1px #eee solid;"></td>
                        <td style="border-right:1px #eee solid;">Monto</td>
                        <td style="border-right:1px #eee solid;">Pagado</td>
                        <td style="border-right:1px #eee solid;">Terminal</td>
                        <td style="border-right:1px #eee solid;">Fecha</td>
                        <td style="border-right:1px #eee solid;">Hora</td>
                        <th style="font-weight:normal;text-align:center;border-right:1px #eee solid;">Aviso</th>
                    </tr>
                    <?			$cuenta = 0;
                    if ($ar_dlmef[0] != '') {
                    // Lo Mejor En Fotos
                    foreach ($ar_dlmef as $item) { $cuenta++?>
                    <tr class="cadaoperacion" style="font-size:11px;">
                        <td style="text-align:right;border-right:1px #eee solid;"><?= $cuenta ?></td>
                        <td style="text-align:left;border-right:1px #eee solid;">Lo Mejor En Fotos</td>
                        <td style="text-align:right;border-right:1px #eee solid;"><?= $item['td02'] ?></td>
                        <td style="text-align:left;border-right:1px #eee solid;"><?= $item['td03'] ?></td>
                        <td style="text-align:right;border-right:1px #eee solid;"><?= $item['eventos_de_fotos'] ?></td>
                        <td style="text-align:right;border-right:1px #eee solid;"><?= substr($item['td04'], 4) * 1 ?></td>
                        <td style="border-right:1px #eee solid;"><?= $item['fotografo_de_fotos'] ?></td>
                        <td style="text-align:right;border-right:1px #eee solid;"><?= $item['td05'] ?></td>
                        <td style="text-align:right;border-right:1px #eee solid;"><?= $item['td06'] ?></td>
                        <td style="text-align:right;border-right:1px #eee solid;"><?= $item['td07'] ?></td>
                        <td style="text-align:right;border-right:1px #eee solid;"><?= $item['td08'] ?></td>
                        <td style="border-right:1px #eee solid;"><?= $item['td09'] ?></td>
                        <td style="border-right:1px #eee solid;"><?= $item['td10'] ?></td>
                        <td style="text-align:right;" id="avisoEmail<?= $item['td11'] ?>"><?= $item['td12'] ?></td>
                    </tr>
                    <?				}
                    }
                    if ($ar_dcobo[0] != '') {
                    // Cobre Online 
                    foreach ($ar_dcobo as $item) { $cuenta++?>
                    <tr class="cadaoperacion" style="font-size:11px;">
                        <td style="text-align:right;border-right:1px #eee solid;"><?= $cuenta ?></td>
                        <td style="text-align:left;border-right:1px #eee solid;">Cobre Online</td>
                        <td style="text-align:right;border-right:1px #eee solid;"><?= $item['td02'] ?></td>
                        <td style="text-align:left;border-right:1px #eee solid;"><?= $item['td03'] ?></td>
                        <td style="text-align:right;border-right:1px #eee solid;"><a href="http://cobreonline.com.ar/co_admin/?sec=editar.cobro&amp;id=<?= $item['cobro_id'] ?>" target="_blank" title="<?= $item['cobro_concepto'] ?>"><?= $item['cobro_concepto'] ?></abbr></td>
                        <td style="text-align:right;border-right:1px #eee solid;"><?= substr($item['td04'], 4) * 1 ?></td>
                        <td style="border-right:1px #eee solid;"><?= $item['entidad'] ?></td>
                        <td style="text-align:right;border-right:1px #eee solid;"><?= $item['td05'] ?></td>
                        <td style="text-align:right;border-right:1px #eee solid;"><?= $item['td06'] ?></td>
                        <td style="text-align:right;border-right:1px #eee solid;"><?= $item['td07'] ?></td>
                        <td style="text-align:right;border-right:1px #eee solid;"><?= $item['td08'] ?></td>
                        <td style="border-right:1px #eee solid;"><?= $item['td09'] ?></td>
                        <td style="border-right:1px #eee solid;"><?= $item['td10'] ?></td>
                        <td style="text-align:right;" id="avisoEmail<?= $item['td11'] ?>"><?= $item['td12'] ?></td>
                    </tr>
                    <?				}
                    }
                    if ($ar_insco[0] != '') { 
                    // Inscribite Online
                    foreach ($ar_insco as $item) { 
                    $cuenta++;
                    $mensualidad = null;
                    if($item['evento'] == $item['primeros4cod']){
                    cerrarDb();
                    $coneccion = mysql_connect("localhost", "inscribite_user", "iW7zNKpRWkSHHwplBhUO");
                    mysql_select_db("inscribite_base", $coneccion);
                    $query = "SELECT mec_nro_cuota,men_codigo,emp_nombre,concat(nombre,' ',apellido) as nombre
                    FROM facturas
                    LEFT JOIN facturas_pagas ON facp_fac_id = fac_id
                    INNER JOIN inscribite_usuarios ON id = fac_usu_id
                    INNER JOIN mensualidad_cuotas ON mec_id = fac_mensualidad
                    INNER JOIN mensualidades ON men_id = mec_men_id
                    INNER JOIN empresa ON emp_id = men_empresa
                    WHERE fac_mensualidad = {$item['evento']} AND dni = {$item['eldni']}
                    LIMIT 1 ";
                    $tiene_mensualidad = mysql_query($query);
                    while ($dato_usuario = mysql_fetch_array($tiene_mensualidad)) {
                    $mensualidad = $dato_usuario;
                    }
                    $item['evento_organizador'] = $mensualidad['emp_nombre'];
                    }
                    ?>
                    <tr class="cadaoperacion" style="font-size:11px;">
                        <td style="text-align:right;border-right:1px #eee solid;"><abbr title="Id: <?= $item['td11'] ?>"><?= $cuenta ?></abbr></td>
                        <td style="text-align:left;border-right:1px #eee solid;">Inscribite Online</td>
                        <td style="text-align:right;border-right:1px #eee solid;"><?= $item['td02'] ?></td>
                        <td style="border-right:1px #eee solid;"><a href="http://inscribiteonline.com.ar/admin/usuarios?busqueda=<?= $item['eldni'] ?>" style="margin-right:5px;" target="_blank"><?= $item['eldni'] ?></a> <?= (($mensualidad['nombre']) ? $mensualidad['nombre'] : $item['nombre']) ?></td>
                        <td style="border-right:1px #eee solid;text-align:right;"><abbr title="<?= $item['evento_nombre'] ?>"><?= (($mensualidad['men_codigo']) ? $mensualidad['men_codigo'] : $item['primeros4cod']) ?></abbr></td>
                        <td style="border-right:1px #eee solid;text-align:right;"><?= (($mensualidad['mec_nro_cuota']) ? $mensualidad['mec_nro_cuota'] : $item['evento']) ?></td>
                        <td style="border-right:1px #eee solid;"><?= substr($item['evento_organizador'], 0, 20) . ((strlen($item['evento_organizador']) > 20) ? '...' : '') ?></td>
                        <td style="border-right:1px #eee solid;text-align:right;">$</td>
                        <td style="border-right:1px #eee solid;text-align:right;"><?= $item['precio'] ?></td>
                        <td style="border-right:1px #eee solid;text-align:right;"><?= $item['precio'] ?></td>
                        <td style="border-right:1px #eee solid;text-align:right;"><?= $item['terminal'] ?></td>
                        <td style="border-right:1px #eee solid;"><?= $item['td09'] ?></td>
                        <td style="border-right:1px #eee solid;"><?= $item['horadpago'] ?></td>
                        <td style="text-align:right;border-right:1px #eee solid;" id="avisoEmail<?= $item['td11'] ?>"><?= $item['td12'] ?></td>
                    </tr>
                    <?				}
                    }

                    // arregla fecha en algunos archivos
                    if (!(substr($conte, $posant+1, 4) > 2000)) $posant -= 3?>
                </table>
                <div style="font-size:11px;margin-top:15px;line-height:18px;margin-bottom:50px;">
                    <strong class="nombredato">Fecha:</strong>                              <?= substr($conte, $posant + 7, 2) . '/' . substr($conte, $posant + 5, 2) . '/' . substr($conte, $posant + 1, 4) ?><br/>
                    <strong class="nombredato">Número Batch:</strong>                       <?= substr($conte, $posant + 9, 6) ?><br/>
                    <strong class="nombredato">Cantidad de transacciones del lote:</strong> <? $cantTransacciones = substr($conte, $posant+15, 7); echo $cantTransacciones?><br/>
                    <strong class="nombredato">Importe total cobrado del lote:</strong>     <?= (substr($conte, $posant + 22, 10) + 0) . ',' . substr($conte, $posant + 32, 2) . "\n" ?>
                </div>
            </div>
        </div>
        <script type="text/javascript">
        <!--
            contarTdPares = 0;
            $('tr').each(function (index) {
                contarTdPares++;
                if ((contarTdPares > 2) && (contarTdPares % 2 != 0))
                    $(this).find('td').css('background', '#EFEFEF');
            });
            delayEntreEmails = 5000;
            $('#cantTransacciones').html('<?= ($cantTransacciones * 1) ?>');
            ar_listaIdsPagos = Array();
            ar_listaIdsPagosTipo = Array();
                    < ?		$r = - 1;
                    foreach ($listaidsPagos as $cadaId) { $r++? >
                    ar_listaIdsPagos[<?= $r ?>] = <?= $cadaId ?>;
            ar_listaIdsPagosTipo[<?= $r ?>] = '<?= $ar_listaIdsPagosTipo[$r] ?>';
                    < ?		} ? >
                    $('#cantEmailsAEnviar').html(<?= ($r+1) ?>);
    cuenta = 0;
    ultIdenviado = 0;
    intentos = 1;
    function enviaAvisos(idCompra, tipo) {
        ultIdenviado = idCompra;
        $.ajax({
            url: "enviaemailsavisos?idcompra=" + idCompra + '&tipo=' + tipo,
            success: function (data) {
                if (data == '1') {
                    $('#avisoEmail' + ultIdenviado).html("Enviado");
                    cuenta++;
                    window.setTimeout("reiniciaEnviaAvisos()", delayEntreEmails);
                    intentos = 1;
                    $('#cantEmailsEnviados').html(cuenta);
                    $('#procesoAjax').val("http://maritimopro.com.ar/pagofacil/enviaemailsavisos?idcompra=" + idCompra + "&tipo=" + tipo);
                } else {
                    window.setTimeout("reiniciaEnviaAvisos()", delayEntreEmails);
                }
            },
            error: function (xhr, textStatus, errorThrown) {
                intentos++;
                $('#avisoEmail' + ultIdenviado).html(intentos + "o intento");
                window.setTimeout("reiniciaEnviaAvisos()", delayEntreEmails);
            }/*,
             statusCode: {
             404: function() {
             alert('Error 404. Aceptar para continuar');
             window.setTimeout("reiniciaEnviaAvisos()", delayEntreEmails);
             }
             }*/
        });
    }
    function reiniciaEnviaAvisos() {
        if (ar_listaIdsPagos[cuenta])
            enviaAvisos(ar_listaIdsPagos[cuenta], ar_listaIdsPagosTipo[cuenta]);
//else
//alert('id inexistente: '+ar_listaIdsPagos[cuenta])
    }
    < ?			if ($_POST['prueba'] != 1) { ? >
            reiniciaEnviaAvisos();
            < ?			} ? >
-->
</script>
<?		} else {
print "Error al intentar subir el archivo.";
}
} else { ?>
<div class="lineatituybotnuevo">
    <span class="titulopag">Subir archivo de Pago Fácil</span>
</div>
<div class="divinput">
    <form enctype="multipart/form-data" action="?sec=pagos" method="post">
        <div style="padding:20px;">

            <input type="hidden" name="acc" value="filepfupload"/>
            <div style="width:100%;float:left;">
                <div style="margin-bottom:6px;margin-left:2px;">
                    Archivo PF:
                </div>
                <input name="archivopf" type="file" style="display:inline;width:360px;"/>
            </div>
            <label style="width:100%;float:left;margin-top:15px;">
                <span class="tlabel" style="float:left;">No operar en base:</span>
                <input type="checkbox" name="prueba" value="1" style="margin:3px 0 0 12px;float:left;clear:none;"/>
            </label>

            <div style="float:left;clear:left;width:100%;margin-top:15px;">
                <input type="submit" value="Enviar" class="inputsubmit"/>
            </div>
        </div>
    </form>
</div>

<table style="width:400px;float:left;clear:both;">
    <tr>
        <td>Fecha</td>
        <td>Archivo</td>
        <td></td>
    </tr>
    <?		$result1 = mysql_query('SELECT archivo_id, archivo_fecha, archivo_nombre FROM pagofacil_archivos ORDER BY archivo_fecha DESC LIMIT 10');
    while ($row1 = mysql_fetch_array($result1)) {
    echo '		<tr>'."\n";
    echo '			<td>'.substr($row1['archivo_fecha'], 0, 2).'/'.substr($row1['archivo_fecha'], 2, 2).'/'.substr($row1['archivo_fecha'], 0, 2).'</td>'."\n";
    echo '			<td><a href="descargarpf?archivo='.$row1['archivo_nombre'].'">'.$row1['archivo_nombre'].'</a></td>'."\n";
    echo '			<td style="text-align:right;"><a href="?sec=pagos&amp;reprocesar='.$row1['archivo_nombre'].'">Reprocesar</a></td>'."\n";
    echo '		</tr>'."\n";
    } ?>
</table>

<?	}
//echo '<pre>';
//print_r($arraydeempresas);
//echo '</pre>';

cerrarDb();
$coneccion = mysql_connect("localhost", "inscribite_user", "iW7zNKpRWkSHHwplBhUO");
mysql_select_db("inscribite_base", $coneccion);

$result1 = mysql_query('SELECT * FROM inscribite_inscripciones WHERE pagado = 0 AND venceeldia!= 0 AND venceeldia<'.date("Ymd").' ');
//$result1 = mysql_query('SELECT * FROM inscribite_inscripciones WHERE pagado = 0 AND venceeldia!= 0 ');
if (mysql_num_rows($result1) > 0) echo '<div style="float:left;clear:both;margin-top:20px;">Inscripciones vencidas a borrar: ('.mysql_num_rows($result1).')<br/><br/>';
while ($row1 = mysql_fetch_array($result1)) {
echo 'Usuario: <strong>'.$row1['deusuario'].'</strong> Evento: <strong>'.$row1['deevento'].'</strong> Iniciada el día: <strong>'.$row1['iniciadoeldia'].'</strong> Pagado: <strong>';
if ($row1['pagado'] == 1) echo 'Si'; else echo 'No';
echo '</strong><br/>'."\n";
}
if (mysql_num_rows($result1) > 0) echo '<a href="borrarinscripcionesvencidas" style="margin:10px 0 24px 0;display:block;font-weight:bold;text-decoration:underline;">Confirmar</a></div>'."\n";
?>