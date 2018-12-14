<div class="collapse navbar-collapse" id="fixed-menu">
    <ul class="nav navbar-nav menu">
        <?php if ($_SESSION['admin'] == "inscribite"): ?>
		<li >
            <a href="http://www.inscribiteonline.com.ar/newsite2014/argit/mensualidades.php" class="<?php echo $inicio ?>">Alta mensualidades</a>
        </li>
		<li >
            <a href="http://www.inscribiteonline.com.ar/newsite2014/argit/mensualidadesInactivas.php" class="<?php echo $inicio ?>">Mensualidades inactivas</a>
        </li>
		<li >
            <a href="http://www.inscribiteonline.com.ar/newsite2014/argit/usuariosMensualidades.php" class="<?php echo $inicio ?>">Usuarios mensualidades</a>
        </li>
		<li >
            <a href="http://www.inscribiteonline.com.ar/newsite2014/admin" class="<?php echo $inicio ?>">Admin</a>
        </li>
		<?php endif; ?>

    </ul>
</div>