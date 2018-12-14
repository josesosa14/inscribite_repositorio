<?php 

if($_SERVER['REQUEST_URI'] == "/empresas/mensualidades.php"){
	$mensualidades = "blue";
	$transferencia = "";
}


?>
<div class="collapse navbar-collapse" id="fixed-menu">
    <!-- Main navigation -->
    <ul class="nav navbar-nav menu"> 
        <li>
            <a href="http://www.inscribiteonline.com.ar/empresas/empresa.php" class="<?php echo $inicio ?>">Inicio</a>
        </li>
		
		
		
		<li>
            <a href="http://www.inscribiteonline.com.ar/empresas/mensualidades.php" class="<?php echo $mensualidades ?>">Mensualidades</a>
        </li>
		<li>
            <a href="http://www.inscribiteonline.com.ar/empresas/transferencias.php" class="<?php echo $transferencia ?>">Transferencias</a>
        </li>
		<li>
            <a href="http://www.inscribiteonline.com.ar/empresas/descuentos.php" class="<?php echo $descuentos ?>">Descuentos</a>
        </li>
		<li>
            <a href="http://www.inscribiteonline.com.ar/empresas/altaEvento.php" class="<?php echo $alta_evento ?>">Evento</a>
        </li>
		
		<li >
            <a href="http://www.inscribiteonline.com.ar/empresas/logout.php" class="">Salir</a>
        </li>
    </ul>
    <!-- End main navigation -->
</div>