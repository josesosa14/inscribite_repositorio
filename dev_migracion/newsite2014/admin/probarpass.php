<?
$uriactualsinpag = ((isset($fullurl))?$fullurl:'').'?';
$uriactualsinpag = '?';
foreach ($_GET as $nombrevariable => $valorvariable) {
	$proxvalorvariable = strip_tags($valorvariable);
	$proxvalorvariable = stripslashes($proxvalorvariable);
	$_GET[$nombrevariable] = $proxvalorvariable;
	if ($nombrevariable != 'pagina') $uriactualsinpag .= $nombrevariable.'='.$valorvariable.'&amp;';
}
foreach ($_POST as $nombrevariable => $valorvariable) {
	$proxvalorvariable = strip_tags($valorvariable);
	$proxvalorvariable = stripslashes($proxvalorvariable);
	$_POST[$nombrevariable] = $proxvalorvariable;
}
foreach ($_COOKIE as $nombrevariable => $valorvariable) {
	$proxvalorvariable = strip_tags($valorvariable);
	$proxvalorvariable = stripslashes($proxvalorvariable);
	$_POST[$nombrevariable] = $proxvalorvariable;
}

$diasSemana = Array('Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado');
$meses = Array('', 'enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');

$saltL = Array(2, 1, 2, 5, 5, 8, 2, 3);
$cantL = Array(1, 2, 2, 4, 5, 1, 2, 7);
function chash($pass, $hash2 = '') {
	global $saltL, $cantL, $localPass;
	if ($hash2 == '') {
		return md5($pass.$localPass);
	} else {
		$largo = strlen($pass);
		$PassPHash = '';
		$r = $p = 0;
		while (strlen($hash2) <= $largo) $hash2 .= $hash2;
		while ($r <= $largo) {
			$PassPHash .= substr($pass, $r, $saltL[$p]).substr($hash2, $r, $cantL[$p]).substr($localPass, $r, $cantL[$p]);
			$r += $saltL[$p];
			$p++;
		}
		return md5($PassPHash);
	}
}

// Función y variables de Paginación
$iniciopag = 0;
$cantidadporpag = 50;
if (!(isset($_GET['pagina']))) $_GET['pagina'] = 1;
$cuentaentbl = (($_GET['pagina']-1)*$cantidadporpag);
$ultimoQueryYtabla = '';
$ultimaPaginacion = '';
$txpaginacion = '';
function paginacion($nombretabla = '', $strquery = '') {
	global $result1, $cantidadporpag, $cantitems, $uriactualsinpag, $ultimoquerypaginacion, $txpaginacion, $cuentaentbl;
	if (($ultimoQueryYtabla != $nombretabla.$strquery)) {
		$ultimoQueryYtabla = $nombretabla.$strquery;
		$result1 = mysql_query('SELECT '.pftables.$nombretabla.'.id FROM '.pftables.$nombretabla.(($strquery == '')?'':' WHERE '.$strquery));
		$cantitems = mysql_num_rows($result1);
		$ultenpag = ($_GET['pagina']*$cantidadporpag);
		if ($ultenpag > $cantitems) $ultenpag = $cantitems;

		$txpaginacion = '<div class="paginacion">';
		if ($_GET['pagina'] > 2) $txpaginacion .= '<a href="'.str_replace('?', '', $uriactualsinpag).'">« Primera página</a>';
		if ($_GET['pagina'] > 1) $txpaginacion .= ' <a href="'.$uriactualsinpag.'pagina='.($_GET['pagina']-1).'" style="font-weight:bold;">‹ Anterior</a> ';
		$txpaginacion .= (($_GET['pagina']-1)*$cantidadporpag+1).' - '.$ultenpag.' de '.$cantitems;
		if ($ultenpag != $cantitems) $txpaginacion .= ' <a href="'.$uriactualsinpag.'pagina='.($_GET['pagina']+1).'" style="font-weight:bold;">Siguiente ›</a>';
		$txpaginacion .= '</div>'.chr(13);
	}
	echo $txpaginacion;
}

//


include_once "../inc.config.php";

$horasdesesion = 8;
$http_client_ip = (isset($_SERVER['HTTP_CLIENT_IP']))?$_SERVER['HTTP_CLIENT_IP']:'';
function LogIn(){
	global $result1, $logged, $localPass, $loginhash, $horasdesesion, $http_client_ip;
	if ((isset($_POST['alogin_username'])) && (isset($_POST['alogin_password']))) {
		$alogin_username = strtolower($_POST['alogin_username']);
		$result1 = mysql_query('SELECT * FROM '.pftables.'admin_users WHERE (username = "'.$alogin_username.'" OR email = "'.$alogin_username.'") AND password = "'.chash($_POST['alogin_password']).'" LIMIT 1');
		if ($logged = mysql_fetch_array($result1)) {
			$loginhash = chash($alogin_username.$http_client_ip.time());
			setcookie("alogin_hash", $loginhash, 0, "/");

			mysql_query("UPDATE ".pftables."admin_users SET sesionanterior = '".time()."' WHERE id = ".$logged['id']." LIMIT 1;");
			mysql_query("INSERT INTO ".pftables."sesiones ( `id`, `user`, `hash`, `address`, `lastlogin` ) VALUES ( NULL , '".$logged['id']."', '".chash($localPass.$loginhash)."', '".$http_client_ip.$_SERVER['REMOTE_ADDR']."', '".time()."' );");
			// Envío de resumen al administrador por email
			$msg = '';
			/*$result1 = mysql_query('SELECT * FROM '.pftables.'registro WHERE fecha != '.date('Ymd'));
			while ($row1 = mysql_fetch_array($result1)) {
				if ($msg == '') $msg = 'Fecha: '.substr($row1['fecha'], 6, 2).'/'.substr($row1['fecha'], 4, 2).'/'.substr($row1['fecha'], 0, 4).'<br/>'.chr(13);
				$msg .= '<strong>'.$row1['usuario'].'</strong> '.$row1['accion'].'<br/>'.chr(13);
			}*/
			/*if (mysql_num_rows($result1)) {
				$headerparamail = "From: Mar del Plata Film Fest <info@mardelplatafilmfest.com>\r\nContent-Type: text/html; charset=utf-8\r\n";
				require_once '../class.phpmailer.php';
				$mail = new PHPMailer();
				$mail->SetFrom('info@mardelplatafilmfest.com', '');
				// cambiar por dire del responsable
				$mail->AddAddress('patricio.pitaluga@gmail.com', '');
				$mail->Subject = "Resumen de administración de Mar del Plata Film Fest";
				$mail->MsgHTML($msg);
				$mail->SMTPAuth = true;
				$mail->Host = $smtpHost;
				$mail->Port = $smtpPuerto;
				$mail->Username = $smtpUsername;
				$mail->Password = $smtpPassword;
				$mail->Send();
				mysql_query("TRUNCATE TABLE `".pftables."registro` ");
			} */
			//
			cerrarDb();
			header("Location: ".$_SERVER['REQUEST_URI']);
		}
	}
}
function cerrarDb(){
	global $result1, $result2;
	if (isset($result1)){ if (is_resource($result1)) mysql_free_result($result1); }
	if (isset($result2)){ if (is_resource($result2)) mysql_free_result($result2); }
	mysql_close();
}
if (!isset($loginhash)) $loginhash = '';
function checklogin($loginSiNo = 0) {
	global $result1, $logged, $localPass, $loginhash, $horasdesesion;
	if ($logged['id'] == '') {
		if ((isset($_COOKIE['alogin_hash'])) && ($loginhash == '')) $loginhash = $_COOKIE['alogin_hash'];
		if ($loginhash != '') {
			$result1 = mysql_query('SELECT '.pftables.'sesiones.*, '.pftables.'admin_users.username, '.pftables.'admin_users.email, '.pftables.'admin_users.sesionanterior FROM '.pftables.'sesiones JOIN '.pftables.'admin_users ON '.pftables.'sesiones.user = '.pftables.'admin_users.id WHERE '.pftables.'sesiones.hash = "'.chash($localPass.$loginhash).'" AND (('.pftables.'sesiones.lastlogin*1) >= '.(time()-(3600*$horasdesesion)).') AND '.pftables.'sesiones.address = "'.$http_client_ip.$_SERVER['REMOTE_ADDR'].'" LIMIT 1');
			if ($logged = mysql_fetch_array($result1)) {
				return true;
			} else {
				if ($loginSiNo) { cerrarDb(); header("Location: ".url."26fadm/"); }
				return false;
			}
		} else {
			//Para test W3C. Solo durante etapa desarrollo, luego anular por seguridad
			if (strpos($_SERVER['HTTP_USER_AGENT'], 'Validator') > 0) {
				$result1 = mysql_query('SELECT '.pftables.'sesiones.*, '.pftables.'admin_users.username, '.pftables.'admin_users.email, '.pftables.'admin_users.sesionanterior FROM '.pftables.'sesiones JOIN '.pftables.'admin_users ON '.pftables.'sesiones.user = '.pftables.'admin_users.id LIMIT 1');
				$logged = mysql_fetch_array($result1);
				return true;
			}
			if ($loginSiNo) { cerrarDb(); header("Location: ".url."26fadm/"); }
			return false;
		}
	} else {
		return true;
	}
}
echo chash($_POST['pass']);
?>
<form action="" method="post">
<div>
<input type="password" name="pass"/>
<input type="submit" name="Enviar"/>
</div>
</form>
  