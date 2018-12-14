<?php

header('Content-Type: text/html; charset=UTF-8');
header("Cache-Control: no-cache, must-revalidate");  // HTTP/1.1
header("Pragma: no-cache");                          // HTTP/1.0
ob_start();
?><html>
    <head>
        <title>Inscribite Online</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <style type="text/css">
            <!--
            body{
                font-family:Verdana, Arial, Helvetica, sans-serif;
                font-size:90%;
                color:grey;
            }
            a{
                font-size:11px;
                color:grey;
                text-decoration:none;
            }
            a:hover{
                text-decoration:underline;
            }
            a img{
                border:none;
            }
            .botonborrar{
                font-size:80%;
                color:red;
            }
            .apellido{
                color:black;
            }
            .datos{
                color:black;
            }
            .dni{
                color:#228B22;
            }
            .categoria{
                color:#808080;
            }
            #cargando{
                visibility:hidden;
                position:absolute;
                top:0px;
                right:17px;
                background-image:url(images/ajaxloadingbig.gif);
                background-repeat:no-repeat;
                background-position:left top;
                width:16px;
                height:16px;
            }
            .masinfo{
                font-size:90%;
                border:1px #666 solid;
                width:400px;
                margin-left:30px;
            }
            tr{
                background:#FFF url(images/puntitos.gif) repeat-x 0% 100%;
            }
            td{
                /*border:1px #999 solid;*/
                padding-left:7px;
                padding-right:7px;
                margin:0px;
            }
            table{
                font-size:10px;
            }
            -->
        </style>
        <script type="text/javascript">
            <!--
      function mostrar(name) {
                nuevoestado = 'block';
                if (document.getElementById(name).style.display == 'block')
                    nuevoestado = 'none';
                document.getElementById(name).style.display = nuevoestado;
            }
            var http = getHTTPObject();
            var estadoajax = "libre";
            function getHTTPObject() {
                var xmlhttp;
                /*@cc_on 
                 @if (@_jscript_version >= 5)
                 try{
                 xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
                 } catch(e){
                 try{
                 xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                 } catch(E){
                 xmlhttp = false;
                 } 
                 }
                 @else xmlhttp = false;
                 @end @*/
                if (!xmlhttp && typeof XMLHttpRequest != 'undefined') {
                    try {
                        xmlhttp = new XMLHttpRequest();
                    } catch (e) {
                        xmlhttp = false;
                    }
                }
                return xmlhttp;
            }
            function handleHttpResponse() {
                if (http.readyState == 4) {
                    estadoajax = "libre";
                    document.getElementById("cargando").style.visibility = 'hidden';
                    //document.getElementById("entradas").innerHTML = http.responseText;
                }
            }
            function enviacheck(nro) {
                if (estadoajax == "libre") {
                    document.getElementById("cargando").style.visibility = 'visible';
                    estadoajax = "laburando";
                    var mandvalue = "?vars = ";
                    var mandvalue = mandValue + "&id = " + nro;
                    var mandvalue = mandValue + "&stat = " + document.getElementById("check" + nro).checked;
                    http.open("GET", 'enviacheck' + mandValue, true);
                    http.onreadystatechange = handleHttpResponse;
                    http.send(null);
                    //window.setTimeout("sisetilda();",3000);
                }
            }
            function confirm_entry(nombreaborrar, volvera, nmtabla, nroid) {
                input_box = confirm("Seguro desea borrar " + nombreaborrar);
                if (input_box == true) {
                    location.href = 'borrar?tabla = ' + nmtabla + '&id = ' + nroid + '&volvera=..<?= $_SERVER[REQUEST_URI] ?>';
                } else {
                    //alert("You clicked cancel");
                }
            }
-->
        </script>
    </head>
    <body>
        <p>
            <a href="./">Volver</a>
        </p>
        <div id="entradas"></div>
        <div id="cargando"></div>
        Ordenar por: <a href="usuarios.php?ordpor=nombre">nombre</a>,
        <a href="usuarios.php?ordpor=apellido<?php if ($_GET['busqueda'] != "") echo "&amp;busqueda=" . $_GET['busqueda'] ?>">apellido</a>,
        <a href="usuarios.php?ordpor=dni<?php if ($_GET['busqueda'] != "") echo "&amp;busqueda=" . $_GET['busqueda'] ?>">dni</a>,
        <a href="usuarios.php?ordpor=edad<?php if ($_GET['busqueda'] != "") echo "&amp;busqueda=" . $_GET['busqueda'] ?>">edad</a>,
        <a href="usuarios.php?ordpor=evento<?php if ($_GET['busqueda'] != "") echo "&amp;busqueda=" . $_GET['busqueda'] ?>">evento</a>,
        <a href="usuarios.php?ordpor=puntos<?php if ($_GET['busqueda'] != "") echo "&amp;busqueda=" . $_GET['busqueda'] ?>">puntos</a>
        <form action="usuarios.php" method="get">
            <div>
                <input type="text" name="busqueda"/>
                <input type="submit" value="Buscar Usuario" style="margin-top:5px;margin-left:31px;"/>
            </div>
        </form>
        <br/>
        <?php
        $verdesde = $_GET['verdesde'];
        if ($verdesde == "")
            $verdesde = 0;

        include_once "../inc.config.php";

//mysqli_query($coneccion,"ALTER TABLE `inscribite_usuarios` DROP `id` ");
//mysqli_query($coneccion,"ALTER TABLE `inscribite_usuarios` ADD `id` INT(7 ) NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST ");
        $result1 = mysqli_query($coneccion, 'SELECT id FROM inscribite_usuarios ');
        $totalusuarios = mysqli_num_rows($result1);
        $nrohasta = ($_GET[verdesde] + 100);
        $botsiguiente = '<a href="usuarios.php?ordpor=' . $_GET['ordpor'] . '&verdesde = ' . ($_GET['verdesde'] + 100) . '">Siguientes</a>';
        if ($nrohasta > $totalusuarios) {
            $nrohasta = $totalusuarios;
            $botsiguiente = "";
        }
        if ($_GET[busqueda] == "") {
            echo "Mostrando de " . $verdesde . " a " . $nrohasta . " de " . $totalusuarios . ' inscriptos - <a href="usuarios?ordpor=' . $_GET['ordpor'] . '&verdesde = ' . ($_GET['verdesde'] - 100) . '">Anteriores</a> Ver 100 ' . $botsiguiente;
            echo '<br/><br/>';
        }
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
            $ordpor = 'evento0'
            ?>
        <table cellspacing="0px">
            <tr>
                <th>Nro</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>DNI</th>
                <th>Nac.</th>
                <th>Sexo</th>
                <th>Mail</th>
                <th style="color:black">Puntos</th>
                <th>Pass</th>
                <th>Tel. Part.</th>
                <th>Tel. Lab.</th>
                <th>Tel. Cel.</th>
                <th>Domicilio</th>
                <th>Pcia</th>
                <th>Pa&iacute;s</th>
                <th>&nbsp;</th>
            </tr>
<?php
if ($_GET['busqueda'] != "")
    $result1 = mysqli_query($coneccion, "SELECT * FROM inscribite_usuarios WHERE((apellido LIKE '%" . $_GET['busqueda'] . "%')OR(dni LIKE '%" . $_GET['busqueda'] . "%')) ORDER BY " . $ordpor . " LIMIT " . $verdesde . ", 100 ");
else
    $result1 = mysqli_query($coneccion, 'SELECT * FROM inscribite_usuarios ORDER BY ' . $ordpor . ' LIMIT ' . $verdesde . ', 100 ');

while ($row1 = mysqli_fetch_array($result1)) {
    ?>
                <tr>
                    <td><a href="./?sec=usuarios.editar&amp;editando=<?= $row1['id'] ?>"><?= $row1['id'] ?></a></td>
                    <td><a href="./?sec=usuarios.editar&amp;editando=<?= $row1['id'] ?>"><?= $row1['nombre'] ?></a></td>
                    <td><a href="./?sec=usuarios.editar&amp;editando=<?= $row1['id'] ?>" class="apellido"><?= $row1['apellido'] ?></a></td>
                    <td style="text-align:right"><a href="./?sec=usuarios.editar&amp;editando=<?= $row1['id'] ?>" class="dni"><?= $row1['dni'] ?></a></td>
                    <td style="text-align:right; width:50px;">
                        <a href="./?sec=usuarios.editar&amp;editando=<?= $row1['id'] ?>">
    <?= substr($row1['fechanac'], 6, 2) . "/" . substr($row1['fechanac'], 4, 2) . "/" . substr($row1['fechanac'], 0, 4) ?>
                        </a>
                    </td>
                    <td><a href="./?sec=usuarios.editar&amp;editando=<?= $row1['id'] ?>"><?= substr(ucfirst($row1['sexo']), 0, 1) ?></a></td>
                    <td><a href="./?sec=usuarios.editar&amp;editando=<?= $row1['id'] ?>"><?= strtolower($row1['email']) ?></a></td>
                    <td style="text-align:right;"><a href="./?sec=usuarios.editar&amp;editando=<?= $row1['id'] ?>" style="color:black"><?= $row1['puntos'] ?></a></td>
                    <td><a href="./?sec=usuarios.editar&amp;editando=<?= $row1['id'] ?>"><?= $row1['password'] ?></a></td>
                    <td><a href="./?sec=usuarios.editar&amp;editando=<?= $row1['id'] ?>">&nbsp;<?= $row1['telefonoparticular'] ?></a></td>
                    <td><a href="./?sec=usuarios.editar&amp;editando=<?= $row1['id'] ?>">&nbsp;<?= $row1['telefonolaboral'] ?></a></td>
                    <td><a href="./?sec=usuarios.editar&amp;editando=<?= $row1['id'] ?>">&nbsp;<?= $row1['telefonocelular'] ?></a></td>
                    <td><a href="./?sec=usuarios.editar&amp;editando=<?= $row1['id'] ?>"><?= $row1['domicilio'] ?></a></td>
                    <td><a href="./?sec=usuarios.editar&amp;editando=<?= $row1['id'] ?>"><?= ucfirst(strtolower($row1['provincia'])) ?></a></td>
                    <td><a href="./?sec=usuarios.editar&amp;editando=<?= $row1['id'] ?>" title="<?= ucfirst(strtolower($row1['pais'])) ?>"><?= ucfirst(strtolower(substr($row1['pais'], 0, 2))) ?></a></td>
                    <td><a href="javascript:confirm_entry('<?= $row1['nombre'] ?> <?= $row1['apellido'] ?>', '', 'inscribite_usuarios',<?= $row1['id'] ?>)"><img src="images/deletex.gif" alt="Eliminar"/></a></td>
                    <td><?php if ($row1['dni'] == $antedni) echo'<span style="color:red;">Se Repite</span>' ?></td>
            <?php
            $antedni = $row1['dni'];
        }
        ?>
            </tr>
        </table>
<?php
if ($_GET['busqueda'] == "") {
    echo '<br />';
    echo "Mostrando de " . $verdesde . " a " . $nrohasta . " de " . $totalusuarios . ' inscriptos - <a href="usuarios.php?ordpor=' . $_GET['ordpor'] . '&verdesde=' . ($_GET['verdesde'] - 100) . '">Anteriores</a> Ver 100 ' . $botsiguiente;
    echo '<br /><br />';
}
?>
    </body>
</html>
<?php
mysqli_free_result($result1);
mysqli_close($coneccion);
?>
