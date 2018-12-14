<?php

$mensaje = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
                <html>
                <head>
                <title>Inscribite Online</title>
                <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
                </head>
                <body>
                <br>
                <div align="center">
                  <p><a href="' . $general_path . '"><img src="'.$general_path.'newsite2014/webimages/bannermail.png" width="280" height="100" border="0"></a></p>
                  <table width="600" border="0" cellspacing="5" cellpadding="0">
                    <tr>
				  <td>
					<br>                    
					<span>
					Estimado '.$mensualidad['usuario'].' ,
					gracias por usar los servicios de inscribite on line. Hemos registrado una inscripción de tu parte y queremos recordarte que la misma está en el estado de RESERVADA.
					</span>
					<br>
					<span>
					Esto significa que estás ocupando una vacante en forma temporaria hasta que abones el importe de la inscripción. A las 48Hs de haberlo concretado tu inscripción estará en estado de CONFIRMADA.
                    </span>
                    <br>
					<br>
                    <h4>Detalles de la inscripción</h4>
					<span><h5>Mensualidad:</h5>'.$mensualidad['men_nombre'].'</span><br>
					<span><h5>Cuota:</h5>'.$mensualidad['mec_nro_cuota'].'</span><br>
					<span><h5>Primer vencimiento:</h5>'.$mensualidad['mec_venc_1'].'</span><br>
					<span><h5>Importe:</h5>'.$mensualidad['mec_imp_1'].'</span><br>
					<span><h5>Segundo vencimiento:</h5>'.$mensualidad['mec_venc_2'].'</span><br>
					<span><h5>Importe:</h5>'.$mensualidad['mec_imp_2'].'</span><br>
					<span><h5>Tercer vencimiento:</h5>'.$mensualidad['mec_venc_3'].'</span><br>
					<span><h5>Importe:</h5>'.$mensualidad['mec_imp_3'].'</span><br>
					';
                    
					$mensaje .= '
                    <br>

                    <span>Ante cualquier inconveniente comunicate a nuestros teléfonos de atención al cliente o bien mandanos un e-mail a consultas@inscribiteonline.com.ar.
Recordá que la factura de pago de tu inscripción tiene una fecha de vencimiento, y si no lo efectivizas antes de la misma, tu inscripción se dará de baja automáticamente.
Una vez mas gracias por contar con nosotros.
</span>
                </body>
                </html>';
