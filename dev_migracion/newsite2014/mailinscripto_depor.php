<?
$msg = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>
<div align="center">
  <p><a href="'.url.'"><img src="'.url.'webimages/bannermail.jpg" width="600" height="100" border="0"/></a></p>
  <table width="600" border="0" cellspacing="10" cellpadding="0">
    <tr valign="top"> 
      <td width="434">
        <p><font color="#808080" size="2" face="Arial, Helvetica, sans-serif">Estimado '.$nombredelusuario.' '.$apellidodelusuario.',</font></p>
        <p><font color="#808080" size="2" face="Arial, Helvetica, sans-serif"><strong>Gracias
          por usar los servicios de inscribite on line. </strong>Hemos registrado 
          una inscripci&oacute;n de tu parte y queremos recordarte que la misma 
          est&aacute; en el estado de RESERVADA. Esto significa que est&aacute;s ocupando una 
          vacante en forma temporaria hasta que abones el importe de la inscripci&oacute;n. 
          A las 48Hs de haberlo concretado tu inscripci&oacute;n estar&aacute; en estado 
          de CONFIRMADA.</font></p>
        <p><font size="1" face="Arial, Helvetica, sans-serif"><strong>Detalles
          de la inscripci&oacute;n:</strong></font></p>
        <table width="100%" border="1" cellpadding="3" cellspacing="0" bordercolor="#CCCCCC">
          <tr> 
            <td width="49%"><font size="1" face="Arial, Helvetica, sans-serif">Nombre
              y apellido</font></td>
			  <td>
			  '.$nombredelusuario.' '.$apellidodelusuario.'
			  </td>
          </tr>
          <tr> 
            <td><font size="1" face="Arial, Helvetica, sans-serif">Evento</font></td>
			  <td>
			  '.$nombreevento.'
			  </td>
          </tr>
          <tr> 
            <td><font size="1" face="Arial, Helvetica, sans-serif">Categor&iacute;a</font></td>
			  <td>
			  '.$_GET['cat'].'
			  </td>
          </tr>
          <tr>
            <td><font size="1" face="Arial, Helvetica, sans-serif">';
if ($fechavencimiento1 != $fechavencimiento2)
  $msg .=  'Primer v';
else
  $msg .= 'V';
$msg .= 'encimiento: </font></td>
			  <td>
			  '.substr($fechavencimiento1,6,2)."/".substr($fechavencimiento1,4,2)."/".substr($fechavencimiento1,0,4).'
			  </td>
          </tr>
          <tr> 
            <td><font size="1" face="Arial, Helvetica, sans-serif">Importe';
if ($fechavencimiento1 != $fechavencimiento2)
  $msg .= ' antes del primer vencimiento</font></td>';
$msg .= '			  <td>
			  '.($montopesos+0).','.($montocenta+0).'
			  </td>
          </tr>';
if ($fechavencimiento1 != $fechavencimiento2)
$msg .= '          <tr>
            <td><font size="1" face="Arial, Helvetica, sans-serif">Segundo vencimiento: </font></td>
			  <td>
			  '.substr($fechavencimiento2,6,2)."/".substr($fechavencimiento2,4,2)."/".substr($fechavencimiento2,0,4).'
			  </td>
          </tr>
          <tr> 
            <td><font size="1" face="Arial, Helvetica, sans-serif">Importe antes del segundo vencimiento</font></td>
			  <td>
			  '.(($montoven1+0)+($montopesos+0)).','.(($montoven1cent+0)+($montocenta+0)).'
			  </td>
          </tr>';
$msg .= '
        </table>
        <p><font color="#808080" size="2" face="Arial, Helvetica, sans-serif">Ante
          cualquier inconveniente comunicate a nuestros tel&eacute;fonos de atenci&oacute;n 
          al cliente o bien mandanos un e-mail a <a href="mailto:consultas@inscribiteonline.com.ar">consultas@inscribiteonline.com.ar</a>.</font></p>
        <p><font color="#808080" size="2" face="Arial, Helvetica, sans-serif">Record&aacute;
          que la factura de pago de tu inscripci&oacute;n tiene una fecha de vencimiento, 
          y si no lo efectivizas antes de la misma, tu inscripci&oacute;n se dar&aacute; 
          de baja autom&aacute;ticamente.</font></p>
        <p><font color="#808080" size="2" face="Arial, Helvetica, sans-serif">Una
          vez mas gracias por contar con nosotros</font><font size="2" face="Arial, Helvetica, sans-serif">.</font></p>
        </td>
      <td width="100"> 
        <table width="150" border="1" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC" bgcolor="#E7E7E7">
          <tr>
            <td><p><font size="1" face="Arial, Helvetica, sans-serif"><strong>1-
                Te registr&aacute;s</strong> sin costo alguno. Adem&aacute;s te 
                permite hacer mas r&aacute;pido la gestion la segunda vez que
                uses el servicio y acceder a importantes promociones y premios.</font></p>
              <p><font size="1" face="Arial, Helvetica, sans-serif"><strong>2-
                Seleccion&aacute;s </strong>el evento, curso o mensualidad que 
                quieras realizar, completas todos los datos requeridos por el 
                organizador e imprim&iacute;s tu cup&oacute;n de pago.</font></p>
              <p><strong><font size="1" face="Arial, Helvetica, sans-serif">3-
                Abon&aacute;s</font></strong><font size="1" face="Arial, Helvetica, sans-serif">
                en cualquier PAGO FACIL del pa&iacute;s.</font></p>
              <p><font size="1" face="Arial, Helvetica, sans-serif"><strong>4-
                Y ya est&aacute;s inscripto. </strong>A las 48 hs de haber pagado 
                pod&eacute;s chequear si tu inscripci&oacute;n figura como CONFIRMADA, 
                lo cual significa que tu pago ha sido procesado.</font></p>
              </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
  <br>
  <table width="600" height="25" border="0" cellpadding="0" cellspacing="5" background="'.url.'webimages/footer.gif">
    <tr>
      <td><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">MARITIMO SRL / 4641-4423 4643-1124 / consultas@inscribiteonline.com.ar </font></td>
    </tr>
  </table>
  <p>&nbsp;</p>
</div>
</body>
</html>';
?>