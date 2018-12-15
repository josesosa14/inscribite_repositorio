<div class="collapse navbar-collapse" id="fixed-menu">
    <!-- Main navigation -->
    <ul class="nav navbar-nav menu">
        <?php if (!isset($_SESSION['usuario'])): ?>
		<li >
            <a href="<?PHP echo $general_path;?>/index.php" class="<?php echo $inicio ?>">Inicio</a>
        </li>
		<?php endif; ?>
        <li>
            <a href="<?PHP echo $general_path;?>/nosotros.php" class="<?php echo $nosotros ?>">Nosotros</a>
        </li>
        <?php if (isset($_SESSION['usuario'])) { ?>
		<li>
            <a href="pagar.php#toShow" class="<?php echo $pagar ?>">Eventos</a>
        </li>
		<?php } ?>
        <li>
            <a href="<?PHP echo $general_path;?>/contacto.php#toShow" class="<?php echo $contacto ?>">Contacto</a>
        </li>
		<li>
            <a href="<?PHP echo $general_path;?>/faq.php#toShow" class="<?php echo $dudas ?>">Preguntas Frecuentes</a>
        </li>
        <?php if (!isset($_SESSION['usuario'])) { ?>
            <li>
                <a href="<?PHP echo $general_path;?>//unirse.php#toShow" class="<?php echo $unirse ?>">Unirse</a>
            </li>
        <?php } ?>
        <?php if (!isset($_SESSION['usuario'])) { ?>
            <li>
                <a href="<?PHP echo $general_path;?>/empresa.php#toShow" class="<?php echo $empresa ?>">Empresa</a>
            </li>
        <?php } ?>
        <li>
            <?php if (!isset($_SESSION['usuario'])): ?>
                <!--<a href="http://www.inscribiteonline.com.ar/login.php" class="<?php echo $login ?>">Iniciar sesi&oacute;n</a>-->
            <?php else: ?>
                <a href="<?PHP echo $general_path;?>/miCuenta.php#toShow" class="<?php echo $miCuenta ?>">Ver mi cuenta</a>
            <?php endif; ?>
        </li>
        <?php if (isset($_SESSION['usuario'])): ?>
            <li>
                <a href="<?PHP echo $general_path;?>/logout.php" class="<?php echo $empresa ?>">Cerrar Sesi&oacute;n</a>
            </li>
        <?php endif; ?>
    </ul>
    <!-- End main navigation -->
</div>