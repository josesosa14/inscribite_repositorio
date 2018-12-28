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
                        Elegiste como medio de pago: Pago Mis Cuentas
                    </span>
                    <br>
                     <span>
                        Dentro de las 48hs h&aacute;biles estar&aacute;n visible en tu Home Banking los detalles del Evento y costo a pagar.
                    </span>
                    <br>
                    <span>
                        Buscanos por nombre de empresa: Inscribite Online
                    </span>
					<br>
                    <span>
                        Rubro: Otros servicios.
                    </span>
                    <br>
                    <span>
                        El c&oacute;digo de pago es tu DNI.
                    </span>
                    <br>
                    <ul>
                        <li>Elegiste pagar el servicio: ' . $evento['nombre'] . ', con la opción: ' . $opcion['nombre'] . ' y categoria: ' . $categoria['nombre'] . '.</li>
                    </ul>				
					';
					$fecha1 = date('d-m-Y',strtotime($pmc['fac_venc1']));
					$fecha2 = date('d-m-Y',strtotime($pmc['fac_venc2']));
					$fecha3 = date('d-m-Y',strtotime($pmc['fac_venc3']));
					
					if($fecha1 > date('d-m-Y')):
					$mensaje .= '<span>
                        1er Vencimiento '.date('d-m-Y',strtotime($pmc['fac_venc1'])).': $'.$pmc['fac_imp1'].'
						</span>
						<br>';
					endif;
					
					if($fecha2 > $fecha1):
					
					$mensaje .= '
                    <span>
                        Recargo al '.date('d-m-Y',strtotime($pmc['fac_venc2'])).': $'.$pmc['fac_imp2'].'
                    </span>
                    <br>
					';
					endif;
					
					if($fecha3 > $fecha2):					
					$mensaje .= '
                    <span>
                        Recargo al '.date('d-m-Y',strtotime($pmc['fac_venc3'])).': $'.$pmc['fac_imp3'].'
                    </span>
					';
					endif;
					$mensaje .= '
                    <br>

                    <span>Para ver como operar a trav&eacute;s de Pago Mis Cuentas o desde su Home Banknig <a href="'.$general_path.'newsite2014/documentos/PMC.pdf" class="btn green pull-right col-xs-12 col-sm-3" id="pdf" target="_blank" title="ver presentacion">click ac&aacute;</a></span>
                        <p>
							Operaci&oacute;n realizada con &eacute;xito
					   </p>
                        <p><font color="#666666" size="2" face="Arial, Helvetica, sans-serif">Saludos
                          cordiales,<br/>
                          Inscribite Online.</font><font color="#666666" size="2" face="Arial, Helvetica, sans-serif"><br/>
                          </font></p>
                        </td>
                    </tr>
                  </table><br/>
                  <table width="600" height="25" border="0" cellpadding="0" cellspacing="5" background="'.$general_path.'newsite2014/webimages/footer.gif">
                    <tr>
                      <td><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">MARITIMO SRL / 4641-4423 4643-1124 / info@inscribiteonline.com.ar </font></td>
                    </tr>
                  </table>
                  <p>&nbsp;</p>
                </div>
                </body>
                </html>';
