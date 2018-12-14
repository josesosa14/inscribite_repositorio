<?php

$mensaje = '<html>
                <head>
                <title>Inscribite Online</title>
                <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
                </head>
                <body>
                <br>
                <div align="center">
                  <p><a href="' . $general_path . '"><img src="' . $general_path . 'newsite2014/webimages/bannermail.png" width="280" height="100" border="0"></a></p>
                  <table width="600" border="0" cellspacing="5" cellpadding="0">
                    <tr>
                      <td>
<br>                    
<p>Estimado Nombre y Apellido: ' . $inscripcion['usu_nombre'] . ', ' . $inscripcion['usu_apellido'] . ' con mail: '.$inscripcion['email_usuario'].'
<br>
Tu inscripci&oacute;n al evento ' . $inscripcion['evento_nombre'] . ', con la opcion: ' . $inscripcion['op_nombre'] . ' con categoria: ' . $inscripcion['cat_nombre'] . ',  ha sido confirmada a trav&eacute;s de tu pago. Ahora tenes que seguir las instrucciones del organizador del evento y presentarte el mismo dia con este mail impreso y adjunto el comprobante de pago de tu Home Banking.
<br>
Importante: Maritimo S.R.L Producciones, como empresa administradora del sitio web www.inscribiteonline.com.ar no se hace responsable por los cambios que el organizador de este evento pudiera producir sin previo aviso a los interesados y/o inscriptos al evento.
<br>
Deslinde de responsabilidades:
<br>
Manifiesto y declaro bajo juramento que me encuentro en perfectas condiciones de salud para competir en la prueba. Por la presente y en mi propio nombre y de mis herederos RENUNCIO A LA INDEMNIZACION POR DA&ntilde;OS Y/O PERJUICIOS y LIBERO PARA SIEMPRE DE TODA RESPONSABILIDAD a la empresa y a cada una de las empresas y marcas auspiciantes, que participen de alguna manera conectada con la competencia, en la cual habr&eacute; de participar, respecto a toda acci&oacute;n, reclamo, demanda que haya hecho, que intente actualmente hacer o que en el futuro pueda hacer, por motivo de haberme inscripto y/o participado en esta competencia deportiva, o por cualquier p&eacute;rdida de equipo o efectos personales antes, durante y despu&eacute;s del desarrollo de la misma.
Es indispensable la presentaci&oacute;n de este mail de confirmaci&oacute;n debidamente impreso antes del inicio del evento seg&uacute;n requisito de la empresa o instituci&oacute;n organizadora.
Firma __________________________  Aclaración _______________________________
</p>

                        <p>Saludos
                          cordiales,<br/>
                          Inscribite Online.<br/>
                          </p>
                        </td>
                    </tr>
                  </table><br/>
                  <table width="600" height="25" border="0" cellpadding="0" cellspacing="5" background="' . $general_path . 'newsite2014/webimages/footer.gif">
                    <tr>
                      <td>MARITIMO SRL / 4641-4423 4643-1124 / info@inscribiteonline.com.ar</td>
                    </tr>
                  </table>
                  <p>&nbsp;</p>
                </div>
                </body>
                </html>';
