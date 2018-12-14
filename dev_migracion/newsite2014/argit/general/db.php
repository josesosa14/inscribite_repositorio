<?php
/*if($_SERVER[REMOTE_ADDR] != '190.55.90.203'){
	echo '
	<style>
	body{
	margin:auto;
	width:100%;
	overflow-y:hidden;
	}
	.back{
	position:absolute;
	width:100%;
	}
	</style>
	<img class="back" src="http://www.inscribiteonline.com.ar/newsite2014/images/back_uc.jpg" />
	<img src="http://www.inscribiteonline.com.ar/newsite2014/images/underconstruction_io.png" style="margin-left:12%;position:absolute;margin-top:12%"/>	
	';
	die;
}else{*/
	require_once dirname(__FILE__) . '/../../inc.config_argit.php';
	session_start();

	if (isset($_SESSION['usuario']) || (isset($_SESSION['empresa']) && $_SESSION['empresa'] == 93)) {
		$usuario = $_SESSION['usuario'];
		$user_id = $_SESSION['user_id'];
	}
	require_once dirname(__FILE__) . '/funciones.php';

//}
