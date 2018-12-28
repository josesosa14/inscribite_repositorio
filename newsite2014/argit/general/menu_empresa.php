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
            <a href="<?PHP echo $general_path;?>empresas/empresa.php" class="<?php echo $inicio ?>">Inicio</a>
        </li>
		
		
		
		<li>
            <a href="<?PHP echo $general_path;?>empresas/mensualidades.php" class="<?php echo $mensualidades ?>">Mensualidades</a>
        </li>
		<?php //if($_SESSION["empresa"]=="4"):?>
		<li>
            <a href="<?PHP echo $general_path;?>empresas/transferencias.php" class="<?php echo $transferencia ?>">Liquidaciones</a>
        </li>
		<?php //endif;?>
		<li>
            <a href="<?PHP echo $general_path;?>empresas/descuentos.php" class="<?php echo $descuentos ?>">Descuentos</a>
        </li>
		<li>
            <a href="<?PHP echo $general_path;?>empresas/altaEvento.php" class="<?php echo $alta_evento ?>">Evento</a>
        </li>
		
		<li >
            <a href="<?PHP echo $general_path;?>empresas/logout.php" class="">Salir</a>
        </li>
    </ul>
    <!-- End main navigation -->
</div>