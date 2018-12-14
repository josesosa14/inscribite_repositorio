<?php include_once 'includes/header.php' ?>
<a href="#" onclick="document.getElementById('dninmbusuario').focus();
        return false;"><img src="images/paso-1.gif" alt="" style="border:0" id="imagenpaso1"/></a>
<a href="<?= url ?>registrate"><img src="images/paso-2b.gif" alt="" id="imagenpaso2"/></a>
<img src="images/paso-3b.gif" alt="" id="imagenpaso3"/>
<a href="<?= url ?>quepagar"><img src="images/paso-4b.gif" alt="" id="imagenpaso4"/></a>
<br/>
<div class="gboxtop"></div>
<div class="gbox">
    <h2>Selecciona el rubro del evento  que queres  pagar y luego búscalo en ese rubro seleccionado. Una vez  encontrado hace clik en <strong>+INFO</strong>, se deseas conocer as del evento o bien en  <strong>AVANZAR</strong>, si ya deseas gestionar la reserva e imprimir el cupón de pago.</h2>
</div>
<div class="left">
    <h1>Qué pagar con Inscribite on line</h1>
    <br/>
    <?
    $nomostrarcoli = true;
//include_once 'includes/header.php';
    if ($_GET['tipo'] == '')
        $_GET['tipo'] = 'Deportivos'
        ?>
    <h2>Seleccioná de las distintas posibilidades, lo  que queres gestionar y luego imprimí el cupón de pago</h2>
    <br/>
    <img src="images/rubros.gif" alt="" width="500" height="32"/><br/>
    <div style="border-bottom:1px dotted #1E67A8; height:39px; width:640px;">
        <div class="solapas" style="background-image:url(images/solapa<?= ($_GET['tipo'] == 'Deportivos') ? '1' : '0' ?>.gif);">
            <a href="?tipo=Deportivos"  style="background-image:none;">Eventos <br/>
                Deportivos</a>       </div>
        <div class="solapas" style="background-image:url(images/solapa<?= ($_GET['tipo'] == 'Capacitación') ? '1' : '0' ?>.gif);">
            <a href="?tipo=Capacitación"   style="background-image:none;">Eventos de Capacitación</a>
        </div>
        <div class="solapas" style="background-image:url(images/solapa<?= ($_GET['tipo'] == 'Servicios') ? '1' : '0' ?>.gif);">
            <a href="?tipo=Servicios"  style="background-image:none;">Servicio y Mensualidades</a>
        </div>
        <div class="solapas" style="background-image:url(images/solapa<?= ($_GET['tipo'] == 'Productos') ? '1' : '0' ?>.gif);">
            <a href="?tipo=Productos" style="background-image:none;">Compra de Productos</a>
        </div>
    </div>
    <br/><br/>
    <?
    $paginardea = 500;
    $limitdesde = $_GET['pagina'] * $paginardea;
    $limitdesde = $limitdesde - $paginardea;
    if ($_GET['pagina'] == "")
        $limitdesde = 0;
    $vercategoria = '';

    $result1 = mysql_query('SELECT * FROM ' . pftables . 'eventos WHERE ver=1 AND tipo="' . $_GET['tipo'] . '" ORDER BY fechaord, nombre ');
    $cantitems = mysql_num_rows($result1);
    $cuentaev = 0;
    $result1 = mysql_query($q = 'SELECT * FROM ' . pftables . 'eventos WHERE ver=1 AND tipo="' . $_GET['tipo'] . '" ORDER BY fechaord, nombre LIMIT ' . $limitdesde . ', ' . $paginardea);

    while ($row1 = mysql_fetch_array($result1)) {

        $cuentaev++;
        ?>
        <div class="left_articles">
            <div class="buttons">
                <p><a href="evento?evento=<?= $row1['codigo'] ?>" class="bluebtn">+ INFO</a> <a href="iniciainscripccion?evento=<?= $row1['codigo'] ?>" class="greenbtn">AVANZAR</a></p>
            </div>
            <div class="calendar">
                <p><?php echo substr($row1["fecha"], 0, 5); ?><br/>
                    <strong><?php echo substr($row1["fecha"], 6, 10); ?></strong></p>
            </div>
            <h2><a href="evento?evento=<?= $row1['codigo'] ?>">
        <?= $row1['nombre'] ?>
                </a></h2>
            <p class="description">
                COD <?= $row1['codigo'] ?> Organizador: <a href="evento?evento=<?= $row1['codigo'] ?>"><?= $row1['empresa'] ?></a></p>
        </div>
<?php }
include_once 'includes/footerfull.php'
?>