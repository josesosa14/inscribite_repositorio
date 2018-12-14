<? include_once 'inc.config.php';
$yaseinscribio = false;
$result1 = mysql_query('SELECT dni FROM '.pftables.'usuarios WHERE dni = '.($_POST['dni']*1).' LIMIT 1 ');
while ($row1 = mysql_fetch_array($result1)) $yaseinscribio = true;
if ($_POST['id'] != "nuevo") $yaseinscribio = false;
if (!($yaseinscribio)) {
  setcookie("usuario", $_POST['dni'], time()+7776000, "/");
  $usuario = $_POST['dni'];
  $_POST['usuario'] = $_POST['dni'];
  $recienlogeado = true;

  $idActual = $_POST['id'];
  if ($idActual == 'nuevo') {
    mysql_query('INSERT INTO `'.pftables.'usuarios` ( `id` ) VALUES ( NULL );');
    $result1 = mysql_query('SELECT id FROM '.pftables.'usuarios ORDER BY id DESC LIMIT 1 ');
    while ($row1 = mysql_fetch_array($result1)) {
  	  $idActual = $row1['id'];
    }
  }
  if ($idActual != '') {
    $_POST['nombre']    = ucwords(strtolower($_POST['nombre']));
    $_POST['apellido']  = ucwords(strtolower($_POST['apellido']));
    $_POST['email']     = strtolower($_POST['email']);
    $_POST['domicilio'] = ucwords(strtolower($_POST['domicilio']));
    $_POST['localidad'] = ucwords(strtolower($_POST['localidad']));
    $_POST['provincia'] = ucwords(strtolower($_POST['provincia']));
    $_POST['pais']      = ucwords(strtolower($_POST['pais']));
    foreach ($_POST as $nombrevariable => $valorvariable) {
      if (($nombrevariable != 'id') && ($nombrevariable != 'tabla'))
      mysql_query('UPDATE '.pftables.'usuarios SET '.$nombrevariable.' = "'.$valorvariable.'" WHERE id = '.$idActual);
    }
  }
}

include_once 'includes/header.php';
if ($yaseinscribio) { ?>
<div class="gboxtop"></div>
<div class="gbox">
<h1>Ya te encontrás registrado. </h1>
<p>Si olvidaste tu contraseña pulsa <a href="recordarpassword?recordar=password?username=<?=$_POST['dni']?>" style="text-decoration:underline;">aquí</a> y recibirás un correo electronico para recordartelo. Por cualquier consulta comunicate al 4641-4423 o por email con <a href="mailto:consultas@inscribiteonline.com.ar" style="text-decoration:underline;">consultas@inscribiteonline.com.ar</a>
</p>
</div>
<? } else { ?>
<h1>Registro completo.</h1>
<div class="gboxtop"></div>
<div class="gbox">
<h2>Selecciona el rubro del evento  que queres  pagar y luego búscalo en ese rubro seleccionado. Una vez  encontrado hace clik en <strong>+INFO</strong>, se deseas conocer as del evento o bien en  <strong>AVANZAR</strong>, si ya deseas gestionar la reserva e imprimir el cupón de pago.</h2>
</div>
<p>Ante cualquier duda comunicate a <a href="mailto:consultas@inscribiteonline.com.ar">consultas@inscribiteonline.com.ar</a>. Muchas Gracias.</p>
</div>
<?
}
include_once 'includes/footer.php'?>