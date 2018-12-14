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
						
						La empresa '.$_SESSION['empresa'].' ha modificado sus datos.<br>
						Usuario: '.$parameters['emp_usuario'].'<br>
						Pass:'.$parameters['emp_password'].'<br>
						Nombre:'.$parameters['emp_nombre'].'<br>
						Cuit:'.$parameters['emp_cuit'].'<br>
						Mail:'.$parameters['emp_mail'].'<br>
						Domicilio:'.$parameters['emp_domicilio'].'<br>
						
						Responsable:'.$parameters['empc_nombre'].'<br>
						Apellido:'.$parameters['empc_apellido'].'<br>
						Dni:'.$parameters['empc_dni'].'<br>
						Telefono:'.$parameters['empc_tel_movil'].'<br>
						Mail:'.$parameters['empc_mail'].'<br>
						
						Banco:'.$parameters['empb_nombre'].'<br>
						Tipo Cuenta:'.$parameters['empb_tipo_cuenta'].'<br>
						Nro:'.$parameters['empb_nro_cuenta'].'<br>
						CBU:'.$parameters['empb_cbu'].'<br>
						Titular:'.$parameters['empb_titular'].'<br>
						Cuit:'.$parameters['empb_cuit_titular'].'<br>							
					
						
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
