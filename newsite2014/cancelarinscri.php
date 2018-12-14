<?php
//header("Content-type: text/html; charset=UTF-8");
//header("Cache-Control: no-cache, must-revalidate");  // HTTP/1.1
//header("Pragma: no-cache");                          // HTTP/1.0
ob_start();
include_once 'inc.config.php';

$id = $_GET['id'];

$result1 = mysqli_query($coneccion,'SELECT * FROM ' . pftables . 'inscripciones WHERE id = ' . $id . ' LIMIT 1 ');
$row1 = mysqli_fetch_array($result1);

//mysqli_query($coneccion,'UPDATE '.pftables.'eventos SET cuporestanteop'.$row1['opcion'].'=cuporestanteop'.$row1['opcion'].'+1 WHERE codigo = "'.$row1['deevento'].'" ');

mysqli_query($coneccion,'UPDATE ' . pftables . 'opciones SET cuporestante = cuporestante+1 WHERE (evento = "' . $row1['deevento'] . '" OR evento = "' . ($row1['deevento'] * 1) . '") AND nombre = "' . $row1['opcion'] . '" ');

mysqli_query($coneccion,'DELETE FROM `' . pftables . 'inscripciones` WHERE `id` = ' . $id . ' LIMIT 1');

if (is_resource($result1))
    mysqli_free_result($result1);
//if (is_resource($result2)) mysqli_free_result($result2);
//if (is_resource($result3)) mysqli_free_result($result3);
mysqli_close($coneccion);
?><html>
    <head>
        <?php /* <meta http-equiv="refresh" content="0;URL=<?=$_SERVER[HTTP_REFERER]?>"> */ ?>
    </head>
    <body>
        <script type="text/javascript">

            location.href = 'http://www.inscribiteonline.com.ar/miCuenta.php';

        </script>
    </body>
</html>