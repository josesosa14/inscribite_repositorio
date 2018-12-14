<?php
$mtime = microtime();
$mtime = explode(" ", $mtime);
$mtime = $mtime[1] + $mtime[0];
$starttime = $mtime;
header("Content-type: text/html; charset=UTF-8");
header('Cache-Control: no-cache');
header('Pragma: no-cache');

include_once "../inc.config.php";

require_once dirname(__FILE__) . '/../argit/general/db.php';

include_once "inc.funciones.php";
LogIn($coneccion);
$logOk = checklogin(0, $coneccion);

function agceros($nombreag, $cantceros) {
    while (strlen($nombreag) < $cantceros)
        $nombreag = "0" . $nombreag;
    return $nombreag;
}

function agcnbsp($nombreag, $cantceros) {
    while (strlen($nombreag) < $cantceros)
        $nombreag = "z" . $nombreag;
    $nombreag = str_replace('z', '&nbsp;', $nombreag);
    return $nombreag;
}

$directorio = '../imagenes/';
if ($logOk) {

    /* borra inscripciones vencidas */
    $query = "SELECT id,opcion,deevento FROM inscribite_inscripciones WHERE pagado = 0 AND venceeldia <> 0 AND venceeldia < CURDATE() order by venceeldia desc";
    $inscripciones_caidas = mysqli_query($coneccion, $query);
    $datos_aux = array();
    while ($datos = mysqli_fetch_array($inscripciones_caidas)) {
        $datos_aux[] = $datos;
    }
    if (count($datos_aux) > 0) {
        foreach ($datos_aux as $key => $inscripcion) {
            if ($key == 0)
                $out = $inscripcion['id'];
            else
                $out .= ',' . $inscripcion['id'];

            mysqli_query($coneccion, "UPDATE inscribite_opciones SET cuporestante = cuporestante+1 WHERE nombre = {$inscripcion['opcion']} AND evento = {$inscripcion['deevento']}");
        }

        $query = "UPDATE inscribite_inscripciones SET eliminada=1 WHERE id in($out)";
        mysqli_query($coneccion, $query);
    }
    /**/
    ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
        <head>
            <title>Inscribite Online - Administración</title>
            <meta name="robots" content="noindex,nofollow"/>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
            <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
            <script src="js/jquery.numeric.js"></script>
            <script type="text/javascript" src="js/script.js"></script>
            <link href="estilo.css" rel="stylesheet" type="text/css"/>
        </head>
        <body>
            <div id="contentodo">
                <div id="cabezal">
                    <a href="http://www.inscribiteonline.com.ar/">Inscribite Online</a> | <a href="./">Administración</a>
                    <a href="cerrarsesion.php" style="position:absolute;right:10px;top:0px;font-size:10px;">Cerrar Sesión</a>
                </div>
                <div id="menulateral">
                    <div id="contminimizmaximiz">
                        <a href="" onclick="maximizarmenu();
                                return false;" title="Maximizar">&gt;</a>
                        <a href="" onclick="minimizarmenu();
                                return false;" title="Minimizar" id="minimizar">&lt;</a>
                    </div>
                    <div id="restocontenidomenu" style="width:100%;overflow:hidden;">
                        <h2>Eventos</h2>
                        <div><a href="?sec=eventos.agregar">Agregar Nuevo</a></div>
                        <div><a href="?sec=eventos.admin">Administrar</a></div>
                        <span>Buscar</span>
                        <form action="" method="get">
                            <div>
                                <input type="hidden" name="sec" value="eventos.admin"/>
                                <input type="text" name="evento" class="inputbusca"/><input type="submit" value="" style="width:15px;margin-left:5px;"/>
                                <a href="usuarios.php">Ver Lista</a>
                                <a href="excelusuarioscompl.php">Descargar</a>
                            </div>
                        </form>
                        <h2>Usuarios</h2>
                        <span>Buscar</span>
                        <form action="" method="get">
                            <div>
                                <input type="hidden" name="sec" value="buscar.usuarios"/>
                                <input type="text" name="busqueda" class="inputbusca"/><input type="submit" value="" style="width:15px;margin-left:5px;"/>
                                <a href="usuarios">Ver Lista</a>
                                <a href="excelusuarioscompl.php">Descargar</a>
                            </div>
                        </form>
                        <h2>Inscripciones</h2>
                        <span>Buscar: (dni)</span>
                        <form action="" method="get">
                            <div>
                                <input type="hidden" name="sec" value="inscripciones.admin"/>
                                <input type="text" name="busqueda" class="inputbusca"/><input type="submit" value="" style="width:15px;margin-left:5px;"/>
                            </div>
                        </form>
                        <?php /* 		<a href="?sec=feedback.pagofacil">Subir Pagos</a> */ ?>
                        <a href="http://maritimopro.com.ar/pagofacil/?loginfromnet=<?= md5('inscribiteonline') ?>">Subir Pagos</a>
                        <h2>Mensualidades</h2>
                        <a href="../argit/mensualidades.php">Nueva mensualidad</a>
                        <h2>Pago mis cuentas</h2>
                        <a href="../argit/pagoMisCuentas.php">Pedidos de pago</a>
                        <h2>RapiPago</h2>
                        <a href="../argit/rapiPago.php">Decodificar pagos</a>
                        <h2>Transferencias</h2>
                        <a href="http://www.inscribiteonline.com.ar/transferencias.php">Cargar</a>
                        <h2>Descuentos</h2>
                        <a href="?sec=descuentos.agregar">Agregar Nuevo</a>
                        <a href="?sec=descuentos.admin">Administrar</a>
                        <h2>Empresas</h2>
                        <a href="?sec=empresas.agregar">Agregar Nueva</a>
                        <a href="?sec=empresas.admin">Administrar</a>
                        <?php /* 		<h2>Entrenadores</h2>
                          <a href="?sec=entrenadores.agregar">Agregar Nuevo</a>
                          <a href="?sec=entrenadores.admin">Administrar</a> */ ?>
                        <h2>Banners</h2>
                        <a href="?sec=banners.agregar">Agregar Nuevo</a>
                        <a href="?sec=banners.admin">Administrar</a>
                        <h2>Preguntas Frequentes</h2>
                        <a href="?sec=faq.agregar">Agregar Nueva</a>
                        <a href="?sec=faq.admin">Administrar</a>
                        <h2>Visitas</h2>
                        <a href="https://www.google.com/analytics/home/?et=reset&amp;hl=es-ES" title="Correo Electrónico: fabianderamo Contraseña: mar5445">Ver Estadísticas</a>
                    </div>
                </div>
                <div id="main">
                    <?php
                    if (($_GET['sec'] == 'eventos.agregar') || ($_GET['sec'] == 'eventos.editar'))
                        include 'perfil.evento.php';
                    if (($_GET['sec'] == 'eventos.admin') || ($_GET['sec'] == ''))
                        include 'admin.eventos.php';
                    if (($_GET['sec'] == 'categorias.agregar') || ($_GET['sec'] == 'categorias.editar'))
                        include 'perfil.categorias.php';
                    if ($_GET['sec'] == 'categorias.admin')
                        include 'admin.categorias.php';
                    if (($_GET['sec'] == 'empresas.agregar') || ($_GET['sec'] == 'empresas.editar'))
                        include 'perfil.empresas.php';
                    if ($_GET['sec'] == 'empresas.admin')
                        include 'admin.empresas.php';
                    if (($_GET['sec'] == 'descuentos.agregar') || ($_GET['sec'] == 'descuentos.editar'))
                        include 'perfil.descuentos.php';
                    if ($_GET['sec'] == 'descuentos.admin')
                        include 'admin.descuentos.php';
                    if ($_GET['sec'] == 'inscripciones.admin')
                        include 'admin.inscripciones.php';
                    if (($_GET['sec'] == 'inscripciones.agregar') || ($_GET['sec'] == 'inscripciones.editar'))
                        include 'perfil.inscripciones.php';
                    if (($_GET['sec'] == 'banners.agregar') || ($_GET['sec'] == 'banners.editar'))
                        include 'perfil.banners.php';
                    if ($_GET['sec'] == 'banners.admin')
                        include 'admin.banners.php';
                    if (($_GET['sec'] == 'entrenadores.agregar') || ($_GET['sec'] == 'entrenadores.editar'))
                        include 'perfil.entrenadores.php';
                    if ($_GET['sec'] == 'entrenadores.admin')
                        include 'admin.entrenadores.php';

                    if (($_GET['sec'] == 'faq.agregar') || ($_GET['sec'] == 'faq.editar')) {
                        $result1 = mysqli_query($coneccion, 'SELECT * FROM inscribite_faq WHERE id = ' . $_GET['editando'] . ' LIMIT 1 ');
                        if (is_resource($result1)) {
                            $row1 = mysqli_fetch_array($result1);
                            $nroid = $row1['id'];
                        }
                        ?>
                        <div>
                            <div class="titulosec">Preguntas Frecuentes &gt; <?= (is_resource($result1)) ? 'Editando: ' . $row1['nombre'] : 'Agregar Nueva' ?>
                            </div>
                            <div>
                                <form enctype="multipart/form-data"  action="guardar.php" method="post">
                                    <div>
                                        <input type="hidden" name="id" value="<?= $nroid ?>"/>
                                        <input type="hidden" name="tabla" value="inscribite_faq"/>
                                        <input type="hidden" name="volvera" value="faq.admin"/>
                                        &gt; Número
                                        <input type="text" name="numero" value="<?= $row1['numero'] ?>"/>
                                        &gt; Pregunta
                                        <textarea name="pregunta" cols="50" rows="10" id="descrevent" onkeypress="editaritem = this.id;
                                                escribiendo(event);"><?= $row1['pregunta'] ?></textarea>
                                        &gt; Respuesta
                                        <textarea name="respuesta" cols="50" rows="10" id="descrevent" onkeypress="editaritem = this.id;
                                                escribiendo(event);"><?= $row1['respuesta'] ?></textarea>
                                        <input type="submit" value="Enviar" class="submit" onclick="document.body.style.backgroundImage = 'url(images/ajaxloadingbig.gif)';"/>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <?php
                    }
                    if ($_GET['sec'] == 'faq.admin') {
                        ?>
                        Preguntas Frecuentes &gt; Admin
                        <table>
                            <tr>
                                <th>Nro</th>
                                <th>Pregunta</th>
                                <th>&nbsp;</th>
                                <th>&nbsp;</th>
                            </tr>
                            <?php
                            $result1 = mysqli_query($coneccion, 'SELECT * FROM inscribite_faq ');
                            while ($row1 = mysqli_fetch_array($result1)) {
                                ?>
                                <tr>
                                    <td><a href="?sec=faq.editar&amp;editando=<?= $row1['id'] ?>"><?= $row1['numero'] ?></a></td>
                                    <td><a href="?sec=faq.editar&amp;editando=<?= $row1['id'] ?>"><?= $row1['pregunta'] ?></a></td>
                                    <td></td>
                                    <td><a href="javascript:confirm_entry('<?= $row1['pregunta'] ?>', 'faq.admin', 'inscribite_faq',<?= $row1['id'] ?>)"><img src="images/deletex.gif" alt="Eliminar"/></a></td>
                                </tr>
                            <?php } ?>
                        </table>
                        <?php
                    }
                    if ($_GET['sec'] == 'buscar.usuarios') {
                        ?>
                        <table>
                            <tr>
                                <th>Nro</th>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>DNI</th>
                                <th>Nac.</th>
                                <th>Sexo</th>
                                <th>Mail</th>
                                <th>Puntos</th>
                                <th>Pass</th>
                                <th>Tel. Part.</th>
                                <th>Tel. Lab.</th>
                                <th>Tel. Cel.</th>
                                <th>Localidad</th>
                                <th>Pcia</th>
                                <th>Pa&iacute;s</th>
                                <th>&nbsp;</th>
                            </tr>
                            <?php
                            $ordpor = $_GET['ordpor'];
                            if ($ordpor == "")
                                $ordpor = 'id';
                            if ($ordpor == "nombre")
                                $ordpor = 'nombre';
                            if ($ordpor == "apellido")
                                $ordpor = 'apellido';
                            if ($ordpor == "dni")
                                $ordpor = 'dni';
                            if ($ordpor == "edad")
                                $ordpor = 'fechanac';
                            if ($ordpor == "evento")
                                $ordpor = 'evento0';
                            $verdesde = $_GET['verdesde'];
                            if ($verdesde == "")
                                $verdesde = 0;
                            $result1 = mysqli_query($coneccion, "SELECT * FROM inscribite_usuarios WHERE((apellido LIKE '%" . $_GET['busqueda'] . "%')OR(dni LIKE '%" . $_GET['busqueda'] . "%')) ORDER BY " . $ordpor . " LIMIT " . $verdesde . ",100");
                            while ($row1 = mysqli_fetch_array($result1)) {
                                ?>
                                <tr>
                                    <td><a href="?sec=usuarios.editar&amp;editando=<?= $row1['id'] ?>"><?= $row1['id'] ?></a></td>
                                    <td><a href="?sec=usuarios.editar&amp;editando=<?= $row1['id'] ?>"><?= $row1['nombre'] ?></a></td>
                                    <td><a href="?sec=usuarios.editar&amp;editando=<?= $row1['id'] ?>" class="apellido"><?= $row1['apellido'] ?></a></td>
                                    <td style="text-align:right"><a class="dni" href="?sec=usuarios.editar&amp;editando=<?= $row1['id'] ?>"><?= $row1['dni'] ?></a></td>
                                    <td style="text-align:right; width:50px;">
                                        <a href="?sec=usuarios.editar&amp;editando=<?= $row1['id'] ?>">
                                            <?= substr($row1['fechanac'], 6, 2) . "/" . substr($row1['fechanac'], 4, 2) . "/" . substr($row1['fechanac'], 0, 4) ?>
                                        </a>
                                    </td>
                                    <td><a href="?sec=usuarios.editar&amp;editando=<?= $row1['id'] ?>"><?= substr(ucfirst($row1['sexo']), 0, 1) ?></a></td>
                                    <td><a href="?sec=usuarios.editar&amp;editando=<?= $row1['id'] ?>"><?= strtolower($row1['email']) ?></a></td>
                                    <td style="text-align:right;"><a href="?sec=usuarios.editar&amp;editando=<?= $row1['id'] ?>"><?= $row1['puntos'] ?></a></td>
                                    <td><a href="?sec=usuarios.editar&amp;editando=<?= $row1['id'] ?>"><?= $row1['password'] ?></a></td>
                                    <td><a href="?sec=usuarios.editar&amp;editando=<?= $row1['id'] ?>"><?= $row1['telefonoparticular'] ?></a></td>
                                    <td><a href="?sec=usuarios.editar&amp;editando=<?= $row1['id'] ?>"><?= $row1['telefonolaboral'] ?></a></td>
                                    <td><a href="?sec=usuarios.editar&amp;editando=<?= $row1['id'] ?>"><?= $row1['telefonocelular'] ?></a></td>
                                    <td><a href="?sec=usuarios.editar&amp;editando=<?= $row1['id'] ?>"><?= $row1['localidad'] ?></a></td>
                                    <td><a href="?sec=usuarios.editar&amp;editando=<?= $row1['id'] ?>"><?= ucfirst(strtolower($row1['provincia'])) ?></a></td>
                                    <td><a href="?sec=usuarios.editar&amp;editando=<?= $row1['id'] ?>"><?= $row1['pais'] ?></a></td>
                                    <td><a href="javascript:confirm_entry('<?= $row1['nombre'] ?> <?= $row1['apellido'] ?>', 'buscar.usuariosamp;busqueda=<?= $_GET['busqueda'] ?>', 'inscribite_usuarios',<?= $row1['id'] ?>)"><img src="images/deletex.gif" alt="Eliminar"/></a></td>
                                    <td><?php if ($row1['dni'] == $antedni) echo '<span style="color:red;">Se Repite</span>' ?></td>
                                </tr>
                            <?php } ?>
                        </table>
                        <?php
                    }
                    if (($_GET['sec'] == 'usuarios.agregar') || ($_GET['sec'] == 'usuarios.editar')) {
                        $result1 = mysqli_query($coneccion, 'SELECT * FROM inscribite_usuarios WHERE id = ' . $_GET['editando'] . ' LIMIT 1 ');

                        $row1 = mysqli_fetch_array($result1);
                        $nroid = $row1['id'];
                        ?>
                        <div>
                            <div class="titulosec">Usuario &gt; <?= (is_resource($result1)) ? 'Editando: ' . $row1['nombre'] : 'Agregar Nuevo' ?>
                            </div>
                            <div>
                                <form enctype="multipart/form-data"  action="guardar.php" method="post">
                                    <div>
                                        <input type="hidden" name="id" value="<?= $nroid ?>"/>
                                        <input type="hidden" name="tabla" value="inscribite_usuarios"/>
                                        <input type="hidden" name="volvera" value=""/>

                                        <table>
                                            <tr style="background:none;">
                                                <td>
                                                    <div>&gt; Nombre</div>
                                                    <input type="text" style="width:200px;" name="nombre" value="<?= $row1['nombre'] ?>"/>
                                                </td>
                                                <td>
                                                    <div>&gt; Apellido</div>
                                                    <input type="text" style="width:200px;" name="apellido" value="<?= $row1['apellido'] ?>"/>
                                                </td>
                                            </tr>
                                        </table>

                                        <span style="font-size:13px;">&gt; Puntos</span>
                                        <input style="font-size:13px;height:20px;padding-top:5px;font-weight:bold;border:1px black solid" type="text" name="puntos" value="<?= $row1['puntos'] ?>"/>

                                        <table>
                                            <tr style="background:none;">
                                                <td>
                                                    <div>&gt; Dni
                                                    </div>
                                                    <input type="text" style="width:200px;" name="dni" value="<?= $row1['dni'] ?>"/>
                                                </td>
                                                <td>
                                                    <div>&gt; Fecha de nacimiento
                                                    </div>
                                                    <input type="text" style="width:200px;" name="fechanac" value="<?= $row1['fechanac'] ?>"/>
                                                </td>
                                                <td>
                                                    <div>&gt; Sexo
                                                    </div>
                                                    <select name="sexo">
                                                        <option value="masculino"<?php if ($row1['sexo'] == 'masculino') echo ' selected="selected"' ?>>masculino</option>
                                                        <option value="femenino"<?php if ($row1['sexo'] == 'femenino') echo ' selected="selected"' ?>>femenino</option>
                                                    </select>
                                                </td>
                                            </tr>
                                        </table>

                                        &gt; Email
                                        <input type="text" name="email" value="<?= $row1['email'] ?>"/>

                                        &gt; Password
                                        <input type="text" name="password" value="<?= $row1['password'] ?>"/>

                                        &gt; Teléfono particular
                                        <input type="text" name="telefonoparticular" value="<?= $row1['telefonoparticular'] ?>"/>

                                        &gt; Teléfono laboral
                                        <input type="text" name="telefonolaboral" value="<?= $row1['telefonolaboral'] ?>"/>

                                        &gt; Teléfono celular
                                        <input type="text" name="telefonocelular" value="<?= $row1['telefonocelular'] ?>"/>

                                        &gt; Domicilio
                                        <input type="text" name="domicilio" value="<?= $row1['domicilio'] ?>"/>

                                        &gt; Localidad
                                        <input type="text" name="localidad" value="<?= $row1['localidad'] ?>"/>

                                        &gt; Provincia
                                        <input type="text" name="provincia" value="<?= $row1['provincia'] ?>"/>

                                        &gt; País
                                        <input type="text" name="pais" value="<?= $row1['pais'] ?>"/>

                                        <input type="submit" value="Enviar" class="submit" onclick="document.body.style.backgroundImage = 'url(images/ajaxloadingbig.gif)';"/>
                                    </div>
                                </form>
                            </div>
                        </div>
        <?php
    }
    if ($_GET['sec'] == 'feedback.pagofacil') {
        ?>
                        <div>
                            <div>
                                <div class="titulosec">Inscripciones &gt; Subir Archivo de PagoFacil</div>
                                <div>
                                    <form enctype="multipart/form-data" action="uploadfilefpagofacil.php" method="post">
                                        <div style="width:100%;float:left;">
                                            <div style="width:240px;float:left;">
                                                Subir archivo:<br/><input name="archivo_usuario" type="file" onChange="submit()" style="width:auto;"/>
                                            </div>
                                            <input type="submit" value="Enviar" style="width:auto;float:left;clear:none;margin-top:19px;"/>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <br/>
                            <div style="margin-bottom:10px;">
                                Subidos
                            </div>
                            <form action="verarchivospfacil" method="post">
                                <div style="height:50px;">
                                    <input type="hidden" name="volvera" value="feedback.pagofacilamp;pagina=<?= $_GET['pagina'] ?>"/>
                                    <div style="float:left;clear:left;margin-top:15px;">
        <?php
        $paginardea = 40;
        $limitdesde = ($_GET['pagina']) * $paginardea;
        $limitdesde = $limitdesde - $paginardea;
        if ($_GET['pagina'] == "")
            $limitdesde = 0;
        $result1 = mysqli_query($coneccion, 'SELECT id FROM inscribite_archivospfacil ');
        $cantproductos = mysqli_num_rows($result1);
        echo($limitdesde + 1)
        ?> al <?= ($limitdesde + $paginardea) ?> de <?= $cantproductos ?> - P&aacute;gina
                                        <?php
                                        for ($cpag = 0; $cpag <= $cantproductos / $paginardea; $cpag++) {
                                            if ($cantproductos > ($cpag * $paginardea)) {
                                                ?>
                                                <a href="?sec=feedback.pagofacil&amp;pagina=<?= ($cpag + 1) ?>"<?= ($limitdesde == $cpag * $paginardea) ? ' style="font-weight:bold;"' : ' style="font-weight:normal;"' ?>><?= ($cpag + 1) ?></a> <?php
                                            }
                                        }
                                        $result1 = mysqli_query($coneccion, 'SELECT * FROM inscribite_archivospfacil ORDER BY id DESC LIMIT ' . $limitdesde . ', ' . $paginardea);
                                        ?>
                                    </div>
                                    <div style="float:right;line-height:10px;">
                                        <input type="submit" value="Procesar Archivos" style="width:120px;border:none;background:none;cursor:pointer;border-bottom:1px black solid;margin:0px;padding-left:0px;padding-right:0px;"/>
                                    </div>
                                </div>
                                <table>
                                    <tr>
                                        <th style="width:100px;">Archivo</th>
                                        <th style="width:50px;">Peso</th>
                                        <th style="width:100px;">Fecha</th>
                                        <th style="text-align:left;"><a href="" onclick="for (n = 1; n <= <?= mysqli_num_rows($result1) ?>; n++) {
                                                    if (document.getElementById('check<?= mysqli_num_rows($result1) ?>').checked != true)
                                                        document.getElementById('check' + n).checked = true;
                                                    else
                                                        document.getElementById('check' + n).checked = false;
                                                }
                                                ;
                                                return false;">Marcar Todos</a></th>
                                        <th>&nbsp;</th>
                                        <th>&nbsp;</th>
                                    </tr>
        <?php
        $cuentachecks = 0;
        while ($row1 = mysqli_fetch_array($result1)) {
            $cuentachecks++
            ?>
                                        <tr>
                                            <td><a href="filepfacil/<?= $row1['nombre'] ?>"><?= $row1['nombre'] ?></a></td>
                                            <td style="font-size:10px;"><?php if (file_exists("filepfacil/" . $row1['nombre'])) echo filesize("filepfacil/" . $row1['nombre']) ?></td>
                                            <td style="font-weight:bold;"><?= $row1['fecha'] ?></td>
                                            <td><input type="checkbox" id="check<?= $cuentachecks ?>" name="verfile<?= $row1['id'] ?>" value="<?= $row1['nombre'] ?>" style="width:auto;height:auto;margin:7px 0px 6px 0px;float:left;clear:none;border:none;"/></td>
                                            <td><a href="verarchivospfacil.php?archivo=<?= $row1['nombre'] ?>&amp;volvera=feedback.pagofacilamp;pagina=<?= $_GET['pagina'] ?>">Reprocesar</a></td>
                                            <td>&nbsp;</td>
                                        </tr>
        <?php } ?>
                                </table>
                                <div style="float:right;margin-top:15px;line-height:10px;">
                                    <input type="submit" value="Procesar Archivos" style="width:120px;border:none;background:none;cursor:pointer;border-bottom:1px black solid;margin:0px;padding-left:0px;padding-right:0px;"/>
                                </div>
                            </form>
                            <div style="height:80px;">
                                <div style="float:left;clear:left;margin-top:15px;">
        <?= ($limitdesde + 1) ?> al <?= ($limitdesde + $paginardea) ?> de <?= $cantproductos ?> - P&aacute;gina
                                    <?php
                                    for ($cpag = 0; $cpag <= $cantproductos / $paginardea; $cpag++) {
                                        if ($cantproductos > ($cpag * $paginardea)) {
                                            ?>
                                            <a href="?sec=feedback.pagofacil&amp;pagina=<?= ($cpag + 1) ?>"<?= ($limitdesde == $cpag * $paginardea) ? ' style="font-weight:bold;"' : '' ?>><?= ($cpag + 1) ?></a> <?php
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
    <?php } ?>
            </div>
            </div>
    <?php
    $mtime = microtime();
    $mtime = explode(" ", $mtime);
    $mtime = $mtime[1] + $mtime[0];
    $endtime = $mtime;
    $totaltime = ($endtime - $starttime);
    echo '<div style="width:100%;float:left;clear:both;"><div style="padding-left:155px;text-align:center;font-size:10px;color:#888">Execution time: ' . $totaltime . ' segundos</div>' . chr(13);
    ?>
            <script type="text/javascript">
                <!--
            function autoComplete() {
                    var i = 0;
                    for (var node; node = document.getElementsByTagName('input')[i]; i++) {
                        var type = node.getAttribute('type').toLow
                        erCase();
                        if (type == 'text') {
                            node.setAttribute('autocomplete', 'off');
                        }
                    }
                }
                autoComplete();
                var inputs = document.getElementsByTagName("input");
                for (var i = 0; i < inputs.length; i++) {
                    if ((inputs[i].type != 'radio') && (inputs[i].type != 'checkbox')) {
                        inputs[i].onfocus = function () {
                            this.style.backgroundColor = '#FFF';
                        };
                        inputs[i].onblur = function () {
                            this.style.backgroundColor = '#FFFFCC';
                        };
                    }
                }
                var inputs = document.getElementsByTagName("textarea");
                for (var i = 0; i < inputs.length; i++) {
                    inputs[i].onfocus = function () {
                        this.style.backgroundColor = 'transparent';
                    };
                    inputs[i].onblur = function () {
                        this.style.backgroundColor = '#FFFFCC';
                    };
                }
                ultcolortr = 'transparent';
                var inputs = document.getElementsByTagName("tr");
                for (var i = 0; i < inputs.length; i++) { /*
                 inputs[i].onmouseover = function() {
                 ultcolortr = this.style.backgroundColor;
                 this.style.backgroundColor = '#1793C9';
                 }
                 */
                    //inputs[i].onmouseout = function() { this.style.backgroundColor = ultcolortr };
                }
    -->
            </script>
            </div>
    <?php
} else {

    session_start();
    session_unset();
    session_destroy();
    $_SESSION = array();
    ?>
            <!DOCTYPE HTML>
            <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
                <head>
                    <title>Panel - <?= $pagetitle ?>Maritimo Producciones</title>
                    <meta charset="utf-8"/>
                    <link rel="stylesheet" href="estilo2.css" type="text/css" media="all"/>
                    <link rel="icon" href="images/favicon.gif" type="image/gif"/>
                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js" type="text/javascript"></script>
                </head>
                <body style="background:#FFF">
                    <div class="logoInput"><a href="<?= url ?>admin/"><img src="images/logo_220.gif" alt=""/></a></div>
                    <form action="<?= str_replace('&', '&amp;', $_SERVER['REQUEST_URI']) ?>" method="post">
                        <div class="formlogin">
    <?php if ((isset($_POST['alogin_username'])) || (isset($_POST['alogin_password']))) { ?>
                                <div class="avisoerror">
                                    <img src="images/cmn_attention_icon01.gif" alt=""/>
                                    Nombre de usuario o contraseña incorrectos
                                </div>
    <?php } ?>
                            <label class="labellogin">
                                Usuario / email:
                                <input type="text" class="tinput firstFocus" name="alogin_username"/>
                            </label>
                            <label class="labellogin">
                                Contraseña:
                                <input type="password" class="tinput" name="alogin_password"/>
                            </label>
                            <input type="submit" class="inputsubmit" value="Entrar" style="float:right;"/>
    <?php /* 	<a href="#" style="float:right;clear:right;font-size:13px;margin-top:3px;">Olvidé mi contrasña</a> */ ?>
                        </div>
                    </form>
                    <script type="text/javascript" src="script.js"></script>
    <?php
}
cerrarDb($coneccion);
?>
            </body>
        </html>