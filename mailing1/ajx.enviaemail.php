<?
$url = 'http://inscribiteonline.com.ar/';

$msg = '';
$msg .= '<!DOCTYPE HTML>'.$br;
$msg .= '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">'.$br;
$msg .= '<head>'.$br;
$msg .= '	<title></title>'.$br;
$msg .= '	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>'.$br;
$msg .= '</head>'.$br;
$msg .= '<body style="margin:0;padding:0">'.$br;

$msg .= '<table style="background:#9bd4f1;width:100%;border-collapse:collapse;">'.$br;
$msg .= '	<tr>'.$br;
$msg .= '		<td style="margin:0;padding:0">&nbsp;</td>'.$br;
$msg .= '		<td style="margin:0;padding:0;width:45px;">&nbsp;</td>'.$br;
$msg .= '		<td style="margin:0;padding:29px 0 0 0">'.$br;
$msg .= '			<table style="width:710px;border-collapse:collapse;"">'.$br;
$msg .= '				<tr>'.$br;
$msg .= '					<td style="margin:0;padding:0">'.$br;
$msg .= '						<table style="border-collapse:collapse;">'.$br;
$msg .= '							<tr>'.$br;
$msg .= '								<td  colspan="3" style="margin:0;padding:0">'.$br;
$msg .= '									<a href="'.$url.'"><img src="'.$url.'mailing1/images/headeremail.gif" style="border:0px;display:block;width:710px;height:62px;margin:0;padding:0;vertical-align:top" alt=""/></a>'.$br;
$msg .= '								</td>'.$br;
$msg .= '							</tr>'.$br;
$msg .= '							<tr>'.$br;
$msg .= '								<td style="width:40px;margin:0;padding:0;background:#FFF;">&nbsp;</td>'.$br;
$msg .= '								<td style="width:630px;margin:0;padding:0 0 25px 0;background:#FFF;">'.$br;
$msg .= '									<table style="width:630px;margin:0;padding:0;background:#FFF;">'.$br;
$msg .= '										<tr>'.$br;
$msg .= '											<td style="margin:0;padding:27px 0 20px 0;font-family:arial, sans-serif;font-size:15px;">'.$br;
$msg .= '												Te invitamos a participar en nuestra página en Facebook: <a href="http://www.facebook.com/institutoepsa">http://www.facebook.com/institutoepsa</a>.<br/>'.$br;
$msg .= '											</td>'.$br;
$msg .= '										</tr>'.$br;
$msg .= '										<tr>'.$br;
$msg .= '											<td style="margin:0;padding:25px 0 25px 0;background:#accee0;">'.$br;
$msg .= '												<table style="width:630px;margin:0;padding:0;border-collapse:collapse;">'.$br;
$msg .= '													<tr>'.$br;
$msg .= '														<td style="margin:0;padding:0;width:15px;">&nbsp;</td>'.$br;
$msg .= '														<td style="margin:0;padding:0;">'.$br;
$msg .= '															<table style="border-collapse:collapse;">'.$br;
$msg .= '																Además recibí un descuento para .............. y también ........... ';
$msg .= '															</table>'.$br;
$msg .= '														</td>'.$br;
$msg .= '														<td style="margin:0;padding:0;width:15px;">&nbsp;</td>'.$br;
$msg .= '													</tr>'.$br;
$msg .= '												</table>'.$br;
$msg .= '											</td>'.$br;
$msg .= '										</tr>'.$br;
$msg .= '									</table>'.$br;
$msg .= '								</td>'.$br;
$msg .= '								<td style="width:40px;margin:0;padding:0;background:#FFF;">&nbsp;</td>'.$br;
$msg .= '							</tr>'.$br;
$msg .= '							<tr>'.$br;
$msg .= '								<td style="width:40px;margin:0;padding:0">&nbsp;</td>'.$br;
$msg .= '								<td style="margin:0;padding:25px 0 25px 0;font-family:arial, sans-serif;font-size:12px;">'.$br;
$msg .= '									Si este email es incorrecto ignorelo.<br/>'.$br;
$msg .= '									<br/>'.$br;
$msg .= '									&copy; 2011 Inscribite Online<br/>'.$br;
$msg .= '									info@inscribiteonline.com.ar'.$br;
$msg .= '								</td>'.$br;
$msg .= '								<td style="width:40px;margin:0;padding:0">&nbsp;</td>'.$br;
$msg .= '							</tr>'.$br;
$msg .= '						</table>'.$br;
$msg .= '					</td>'.$br;
$msg .= '				</tr>'.$br;
$msg .= '			</table>'.$br;
$msg .= '		</td>'.$br;
$msg .= '		<td style="margin:0;padding:0;width:45px;">&nbsp;</td>'.$br;
$msg .= '		<td>&nbsp;</td>'.$br;
$msg .= '	</tr>'.$br;
$msg .= '</table>'.$br;

$msg .= '</body>'.$br;

$header = "From: InscribiteOnline.com.ar <comercial@inscribiteonline.com.ar>\r\nContent-Type: text/html; charset=utf-8\r\n";
if ($_GET['email'] == '') {
	echo $msg;
} else { 
	//mail($_GET['email'], "Participá en Inscribite Online", $msg, $header);
	mail('patricio.pitaluga@gmail.com', "Participá en Inscribite Online", $msg, $header);
}
?>