<?php include_once 'includes/head.php'?>
<div class="columnacentral" style="overflow:visible;">
<div class="contenidoseccioncentral">
<p>El tramite es muy sencillo, una vez que formalizás tu inscripción completando todos los datos que necesita el organizador del evento, imprimís tu factura de pago. Tené en cuenta que la misma saldrá con una fecha de vencimiento según determinación del organizador, y si no efectivizás el pago antes de esa fecha deberás iniciar el trámite nuevamente, ya que se producirá la BAJA de la misma. </p>
<p>Con la factura impresa, te acercás a cualquier punto de cobro de PAGOFACIL abonás la misma y listo, en 48 Hs figuraras como CONFIRMADO, en la lista de inscriptos del evento o curso seleccionado.</p>
<p><a href="http://www.pagofacil.com.ar/espanol/site/donde_pago.php" style="text-decoration:underline;">Encuentre el centro de pago más cercano</a></p>
<p><strong>USUARIO REGISTRADO</strong></p>
<p>Para hacer uso del sistema es necesario estar REGISTRADO, no tiene costo y te dará muchos beneficios. El mismo consiste en cargar por unica vez todos tus datos personales y obtener un nombre de usuario y un password. De alli en mas podras  acceder al servicio de inscribite on line para anotarte en algun evento o curso con solo ingresar tu usuario u contraseña. Ademas podras participar en sorteos y promociones que ofrecemos a USUARIOS REGISTRADOS.</p>
<p><input type="button" value="Deseo Registrarme" onclick="location.href='registrate'"/> 
<?php if ($usuario != "") { ?>
<input type="button" value="Consultar mi Cuenta" onclick="location.href='usuario"/>
<?php } ?></p>
</div>
</div>
<?php include_once 'includes/colder.php'?>