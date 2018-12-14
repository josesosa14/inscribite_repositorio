<?php

require_once dirname(__FILE__) . '/../general/db.php';
$general_path = "http://www.inscribiteonline.com.ar/";
$general_path2 = "http://www.inscribiteonline.com.ar/";

if ($_POST) {
    $parameters = parseParameters($_POST);
    $parameters['emp_fecha_in'] = date("Y-m-d");
    $parameters['emp_estado'] = 0;
	$parameters['emp_comision'] = 0.2;
    //empresa
    //echo '<pre>';
    //print_r($parameters);die();
    insertRow('empresa', $parameters, $mysqli);
    //contacto
    $parameters['empc_emp_id'] = $mysqli->insert_id;
    insertRow('empresa_contacto', $parameters, $mysqli);
    //manda mail de confirmación
    $para = ' '.$parameters['emp_nombre'].' <'.$parameters['emp_mail'].'>';
	$título = 'Confirmacion Nueva Empresa';
	// Para enviar un correo HTML, debe establecerse la cabecera Content-type
	$cabeceras = 'MIME-Version: 1.0' . "\r\n";
	$cabeceras .= 'Content-type: text/html; charset=UTF-8' . "\r\n";

	// Cabeceras adicionales
	//$cabeceras .= 'To: Usuario <'.$inscripcion['email_usuario'].'>' . "\r\n";
	$cabeceras .= 'From: Recordatorio <info@inscribiteonline.com.ar>' . "\r\n";
	$cabeceras .= 'Cc: Recordatorio <info@inscribiteonline.com.ar>' . "\r\n";		
	
    $mensaje = '<html>
<head>
<title>Inscribite Online</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>
<div align="center">
  <p><a href="' . $general_path . '"><img src="' . $general_path . 'webimages/bannermail.png" width="280" height="100" border="0"></a></p>
  <table width="600" border="0" cellspacing="5" cellpadding="0">
    <tr>
      <td><p><font color="#666666" size="2" face="Arial, Helvetica, sans-serif">Estimado
          ' . $parameters['emp_nombre'] . '</font></p>
        <p><font face="Arial, Helvetica, sans-serif" size="2" color="#666666">
		Bienvenido a Inscribite Online
           </font></p>
		   
	   <p>
		   
		En la ciudad de Buenos Aires, a los '.date('d').' dias del mes '.date('m').' de '.date('Y').',entre ' . $parameters['emp_nombre'] . ' O ASOCIACION CONTRATANTE  en adelante (El Contratante) con domicilio en '.$parameters['emp_domicilio'].', representada en este acto por el Sr. '.$parameters['empc_nombre'].' y '.$parameters['empc_apellido'].' en  su carácter de '.$parameters['empc_cargo'].' que ocupa en la empresa, por una parte, y MARITIMO SRL (en adelante el PRESTADOR), con domicilio en Roma 950, Capital Federal, representada por Fabian D´Eramo en su carácter de Socio Gerente, y como empresa administradora del sitio web www.inscribiteonline.com.ar, (en adelante el SITIO WEB), deciden formalizar el siguiente acuerdo entre partes:
El PRESTADOR, como administrador del  SITIO WEB,  que funciona mediante el pago electrónico en centros de PAGO FACIL, EN VIGENCIA POR PREVIO CONTRATO ENTRE Fabian D´Eramo y SEPSA,  brindará a El Contratante  el servicio de inscripción a  eventos Deportivos y/o de capacitación y/o de gestión de cobranzas mensuales que este solicite fehacientemente, mediante una orden de servicio, que  se regirá por las siguientes cláusulas:
<ol>
	<li>El Contratante manifiesta que la dirección de correo electrónico: '.$parameters['emp_mail'].', será en adelante la dirección de correo OFICIAL  y  UNICA  para toda comunicación entre partes, mientras que el PRESTADOR declara como OFICIAL la dirección: robertomelado@maritimopro.com.ar</li>
	<li>El Contratante otorgará al PRESTADOR,  todos los datos necesarios para el ALTA DE EMPRESA, que se detallan en el anexo I, con una anticipación de 7 días hábiles antes de la fecha deseada para el alta del servicio. Deberá ser acompañado por la Orden de Servicio que también forma parte del presente acuerdo entre partes.</li>
	<li>El PRESTADOR programará el sistema para su correcto funcionamiento y notificará al Contratante que se encuentra apto para la comprobación de su funcionamiento, mediante una dirección URL privada</li>
	<li>El Contratante probará y dará conformidad al PRESTADOR,  quien inmediatamente dará el Alta definitiva del evento el sistema para comenzar con las inscripciones y/o cobranzas</li>
	<li>El PRESTADOR ofrecerá a cada usuario la asistencia “online” o telefónica que fuera necesaria para formalizar la inscripción.</li>
	<li>De lunes a Viernes el PRESTADOR trasmitirá electrónicamente los datos de la evolución de las inscripciones correspondientes  a los eventos que al momento se encuentren dados de Alta a nombre del Contratante, mediante el envío de un mail con archivo adjunto que contendrá el detalles de inscripciones.</li>
	<li>Cada archivo adjunto tendrá valor de NOTA DE CREDITO, a favor del Contratante, que se cancelaran mediante transferencia bancaria a la cuenta que el Contratante indique, los días 3, 13 y 23 de cada mes.</li>
	<li>El Contratante podrá en cada momento que lo necesite ver la evolución de sus inscripciones, con la posibilidad de bajar en formart Excel un archivo con estos datos de cada evento online al momento o bien de los eventos pasados. El PRESTADOR enviará una explicación detallada al el Contratante sobre el usuario y Password para ingresar a su panel de control privado que le permitirá bajar estos archivos.</li>
	<li> El Contratante notificara dentro de los 7 días hábiles posteriores al evento cualquier reclamo que pudiera surgir luego de controlar los correspondientes cupón de de Pago, enviando un mail desde y hacia las casillas oficiales que se manifiestan en este contrato. El PRESTADOR notificará la evolución del reclamo y acreditará en la cuenta del Contratante el importe correspondiente, si el reclamo es  correcto.</li>
	<li> El Contratante acepta el debito de $ 270 , (Pesos doscientos  cincuenta) al inicio de su orden de crédito, en carácter de PAGO  por los trabajos de programación del sistema para el ALTA de empresa CONTRATANTE, Y $ 240 en carácter de PAGO por el trabajo de programación por cada uno de los eventos que se de de ALTA el SITIO, mas el importe en carácter de comisión por cada transacción, que se detalla en el anexo II  de la Orden de Servicio, que el contratante debe confeccionar antes del alta de cada evento. Cada modificación que el Contratante necesite realizar en la programación del evento tendrá un costo de $ 85 que será debitado en la misma orden de servicio.</li>
	<li> El presente acuerdo Nro '.$parameters['empc_emp_id'].' del primer evento que tendrá esta empresa, tendrá  validez indefinida en el tiempo, hasta que alguna de las partes comunique fehacientemente el deseo de interrumpirlo y/o modificar alguna de las cláusulas, comunicación que se hará mediante comunicación fehaciente a la dirección de mail declaradas por ambas partes. En adelante y para futuras ORDENES DE SERVICIO, </li>
	<li>Ante el deseo por parte del contratante de incorporar al servicio un nuevo evento, deberá enviar un mail notificando tal requerimiento mediante el envío de una nueva  Orden de Servicio, completando todos los datos requeridos en la misma.</li>
	<li>Se dará como válido para la puesta en vigencia de este acuerdo, la contestación de este mail por parte del Contratante colocando en asunto: ACEPTO CADA UNA DE LAS CLAUSULAS DEL PRESENTE, mail que deberá ser enviado desde la dirección de correo OFICAL declarada en este acuerdo </li>
</ol>
   
	   </p>
        <blockquote>
          <p><font face="Arial, Helvetica, sans-serif" size="2" color="#666666">Usuario
            <strong>' . $parameters['emp_usuario'] . ' </strong><br/>
            Contrase&ntilde;a <strong>' . $parameters['emp_password'] . '</strong></font></p>
        </blockquote>
		<a href="' . $general_path . 'altas/confirmar_registro_empresa.php?emp_id=' . $parameters['empc_emp_id'] . '&value=true">Haga click aqu&iacute; para confirmar su inscripci&oacute;n</a>
        <p><font color="#666666" size="2" face="Arial, Helvetica, sans-serif">Saludos
          cordiales,<br/>
          Inscribite Online.</font><font color="#666666" size="2" face="Arial, Helvetica, sans-serif"><br/>
          </font></p>
        </td>
    </tr>
  </table><br/>
  <table width="600" height="25" border="0" cellpadding="0" cellspacing="5" background="' . $general_path . 'webimages/footer.gif">
    <tr>
      <td><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">MARITIMO SRL / 4641-4423 4643-1124 / info@inscribiteonline.com.ar </font></td>
    </tr>
  </table>
  <p>&nbsp;</p>
</div>
</body>
</html>';

    //banco
    $parameters['empb_emp_id'] = $parameters['empc_emp_id'];
	$parameters['empb_activa'] = 1;
    insertRow('empresa_banco', $parameters, $mysqli);

    if (mail($para, $título, $mensaje, $cabeceras)) {
        header('Location:' . $general_path . 'empresas/index.php?success=1');
    }
} else {
    header('Location:' . $general_path . 'index_argit.php');
}




