<?

function countryCityFromIP($ipAddr) {
    //verify the IP address for the
    ip2long($ipAddr) == -1 || ip2long($ipAddr) === false ? trigger_error("Invalid IP", E_USER_ERROR) : "";
    $ipDetail = array(); //initialize a blank array
    //get the XML result from hostip.info
    $xml = file_get_contents("http://api.hostip.info/?ip=" . $ipAddr);

    //get the city name inside the node <gml:name> and </gml:name>
    //preg_match("@<Hostip>(\s)*<gml:name>(.*?)</gml:name>@si",$xml,$match);
    preg_match("|<gml:name>(.*)</gml:name>|s", $xml, $match);

    //assing the city name to the array
    $ciudad = $match[1];
    $ciudad = substr($ciudad, strpos($ciudad, '<gml:name>') + 10, 100);
    $ipDetail['city'] = $ciudad;
    if ($ipDetail['city'] == '(Unknown City?)')
        $ipDetail['city'] = '';

    //get the country name inside the node <countryName> and </countryName>
    preg_match("@<countryName>(.*?)</countryName>@si", $xml, $matches);

    //assign the country name to the $ipDetail array
    $ipDetail['country'] = $matches[1];
    if ($ipDetail['country'] == '(Unknown Country?)')
        $ipDetail['country'] = '';

    //return the array containing city, country and country code
    return $ipDetail;
}

function getRealIpAddr() {
    //check ip from share internet
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } //to check ip is pass from proxy
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    if (strpos($ip, ', ') > -1) {
        $ar_ips = Array();
        $ar_ips = split(', ', $ip);
        $ip = $ar_ips[0];
    }
    return $ip;
}

include_once 'includes/header.php'
?>
<script type="text/javascript">
<!--
    function cantidias() {
        anho = document.getElementById('agnonacimiento').value;
        cantdias[1] = 31;
        cantdias = new Array(0, 31, 0, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
        if (((anho % 4 == 0) && (anho % 100 != 0)) || (anho % 400 == 0))
            cantdias[2] = 29;
        else
            cantdias[2] = 28;

        if ((document.getElementById('dianacimiento').value != "") && (document.getElementById('mesnacimiento').value != '') && (document.getElementById('agnonacimiento').value != '')) {
            if (document.getElementById('dianacimiento').value > cantdias[document.getElementById('mesnacimiento').value]) {
                document.getElementById('avisarmaldia').innerHTML = 'Ese mes solo tiene ' + cantdias[document.getElementById('mesnacimiento').value] + ' días';
            }
        }
    }
    function checkacompleto() {
        if ((document.getElementById('nombre').value != '') &&
                (document.getElementById('apellido').value != '') &&
<?php if ($_GET['usuario'] == '') { ?>
            (document.getElementById('dni').value != '') &&
<?php } ?>
        (document.getElementById('dianacimiento').value != '') &&
                (document.getElementById('mesnacimiento').value != '') &&
                (document.getElementById('agnonacimiento').value != '') &&
                (document.getElementById('sexo').value != '') &&
                (document.getElementById('email').value != '') &&
                (document.getElementById('password').value != '') &&
                (document.getElementById('passwordrepe').value != '') &&
                ((document.getElementById('telefonoparticular').value != '') || (document.getElementById('telefonolaboral').value != '') || (document.getElementById("telefonocelular").value != '')) &&
                (document.getElementById('domicilio').value != '') &&
                (document.getElementById('localidad').value != '') &&
                (document.getElementById('provincia').value != '') &&
                (document.getElementById('pais').value != '')
                ) {
            document.getElementById('completo').innerHTML = '';
            document.getElementById('botonsumbit').disabled = false;
        } else {
            document.getElementById('completo').innerHTML = "Datos incompletos ";
            document.getElementById("botonsumbit").disabled = true;
        }
    }
    function checkearpassrepe() {
        if (document.getElementById("password").value != document.getElementById("passwordrepe").value) {
            //if (document.getElementById("passwordrepe").value != '') {
            document.getElementById('avisarmalpassword').innerHTML = "El password repetido es diferente. Ingreselos nuevamente.";
            document.getElementById("password").value = '';
            document.getElementById("passwordrepe").value = '';
            //}
        } else {
            document.getElementById('avisarmalpassword').innerHTML = '';
        }
    }
    function checkeamail() {
        if ((document.getElementById('email').value.indexOf("@") < 0) || (document.getElementById('email').value.indexOf(".") < 0)) {
            document.getElementById('avisarmalmail').innerHTML = "El email ingresado es incorrecto el formato correcto es nombredelacuenta@host.extencion.pais";
            document.getElementById('email').value = '';
        } else {
            document.getElementById('avisarmalmail').innerHTML = '';
        }
    }
    document.body.onkeyup = checkacompleto;
    document.body.onclick = checkacompleto;
-->
</script>
    <?php if ($_GET['usuario'] == '') { ?>
    <?php } else { ?>
    <h1>Corregí y actualizá tus datos:</h1>
    <?php }
    if (($usuario != '') && ($_GET['usuario'] == '')) {
        ?>
    <br/>
    <p>Usted est&aacute; logueado como <?
    $result1 = mysql_query('SELECT * FROM ' . pftables . 'usuarios WHERE dni="' . $usuario . '" LIMIT 1 ');
    $row1 = mysql_fetch_array($result1);
    echo$row1['nombre'] . ' ' . $row1['apellido']
    ?></p>
    <a href="cerrarsesion">Cerrar Sesion para registrar a otro usuario</a>
    <br/>
    <a href="registrate?usuario=<?= $usuario ?>">Ver o cambiar mis datos</a>
    <br/><br/>
<?php } else { ?>
    <!-- formulario -->
    <?
    /*
      <div style="margin-top:8px;margin-bottom:10px;margin-left:19px;color:red;font-size:11px;float:left;">
      <div style="float:left;padding-left:1em;">
      Si usted ya se ha registrado ingrese su nombre de <br/>
      usuario y contraseña ----------------------------><br/>
      de lo contrario llene el siguiente formulario
      </div>
      </div>
     */
    $result1 = mysql_query('SELECT * FROM ' . pftables . 'usuarios WHERE dni="' . $_GET['usuario'] . '" LIMIT 1 ');
    $row1 = mysql_fetch_array($result1);
    ?>
    <a href="#" onclick="document.getElementById('dninmbusuario').focus();
                                            return false;"><img src="images/paso-1.gif" alt="" style="border:0" id="imagenpaso1"/></a>
    <a href="<?= url ?>registrate"><img src="images/paso-2b.gif" alt="" id="imagenpaso2"/></a>
    <img src="images/paso-3b.gif" alt="" id="imagenpaso3"/>
    <a href="<?= url ?>quepagar"><img src="images/paso-4b.gif" alt="" id="imagenpaso4"/></a>
    <br/>
    <div class="gboxtop"></div>
    <div class="gbox">
        <h2>Nunca has usado el sistema con anterioridad por lo tanto es necesario que por <strong>UNICA VEZ</strong>, cargues tu	datos para quedar registrado. Luego podrás usar el sistema de gestión solo	ingresando <strong>DNI y CLAVE</strong>. </h2>
    </div>
    <div class="left">
        <h1>Formulario de registro:</h1>
        <div style="width:100%;margin-top:10px;">
            <form action="confirmaregistro" method="post">
                <div class="fieldsettotal" style="padding:10px;border:1px #9C9C9C solid;margin-bottom:17px;float:left;width:663px;">
                    <h2>Datos Personales:</h2>
                    <table width="100%" border="0" cellspacing="5" cellpadding="0">
                        <tr>
                            <td style="width:39%">
                                <input type="hidden" name="id" value="<?= ($_GET['usuario'] != "") ? $row1['id'] : 'nuevo' ?>"/>
                                <label for="nombre"><span class="asteriscoobliga">(*)</span> Nombre:</label>
                            </td>
                            <td style="width:61%"><input type="text" name="nombre" id="nombre" value="<?= $row1['nombre'] ?>"/></td>
                        </tr>
                        <tr>
                            <td><label for="apellido"><span class="asteriscoobliga">(*)</span> Apellido:</label></td>
                            <td><input type="text" name="apellido" id="apellido" value="<?= ($row1['apellido']) ?>"/></td>
                        </tr>
                        <tr>
                            <td><label for="dni"><span class="asteriscoobliga">(*)</span> DNI:</label></td>
                            <td><input type="text" name="dni" id="dni" value="<?= $row1['dni'] ?>" onkeydown="this.value = this.value.replace('.', '').replace('.', '').replace('.', '').replace('.', '').substring(0, 8);" onchange="this.value = this.value.replace('.', '').replace('.', '').replace('.', '').replace('.', '').substring(0, 8);"/></td>
                        </tr>
                    </table>
    <?php if ($_GET['usuario'] != '') { ?>
                        <input type="hidden" name="dni" value="<?= $row1['dni'] ?>"/>
    <?php } ?>
                    <hr/>
                    <div id="ocultarsiestaregistrado">
                        <table width="100%" border="0" cellspacing="5" cellpadding="0">
                            <tr>
                                <td style="width:39%">
                                    <label for="dianacimiento"><span class="asteriscoobliga">(*)</span> Fecha de Nacimiento:</label>
                                </td>
                                <td style="width:61%">
                                    <select name="dianacimiento" id="dianacimiento">
                                        <option></option>
    <?php for ($i = 1; $i <= 31; $i++) { ?>
                                            <option value="<?= $i ?>" <?php if ((substr($row1['fechanac'], 6, 2) * 1) == $i) echo'selected' ?>><?= $i ?></option>
    <?php } ?>
                                    </select>
                                    <select name="mesnacimiento" id="mesnacimiento" onchange="cantidias();">
                                        <option></option>
                                        <option value="01"<?php if (substr($row1['fechanac'], 4, 2) == "01") echo ' selected="selected"' ?>>Enero</option>
                                        <option value="02"<?php if (substr($row1['fechanac'], 4, 2) == "02") echo ' selected="selected"' ?>>Febrero</option>
                                        <option value="03"<?php if (substr($row1['fechanac'], 4, 2) == "03") echo ' selected="selected"' ?>>Marzo</option>
                                        <option value="04"<?php if (substr($row1['fechanac'], 4, 2) == "04") echo ' selected="selected"' ?>>Abril</option>
                                        <option value="05"<?php if (substr($row1['fechanac'], 4, 2) == "05") echo ' selected="selected"' ?>>Mayo</option>
                                        <option value="06"<?php if (substr($row1['fechanac'], 4, 2) == "06") echo ' selected="selected"' ?>>Junio</option>
                                        <option value="07"<?php if (substr($row1['fechanac'], 4, 2) == "07") echo ' selected="selected"' ?>>Julio</option>
                                        <option value="08"<?php if (substr($row1['fechanac'], 4, 2) == "08") echo ' selected="selected"' ?>>Agosto</option>
                                        <option value="09"<?php if (substr($row1['fechanac'], 4, 2) == "09") echo ' selected="selected"' ?>>Septiembre</option>
                                        <option value="10"<?php if (substr($row1['fechanac'], 4, 2) == "10") echo ' selected="selected"' ?>>Octubre</option>
                                        <option value="11"<?php if (substr($row1['fechanac'], 4, 2) == "11") echo ' selected="selected"' ?>>Noviembre</option>
                                        <option value="12"<?php if (substr($row1['fechanac'], 4, 2) == "12") echo ' selected="selected"' ?>>Diciembre</option>
                                    </select>
                                    <select name="agnonacimiento" id="agnonacimiento" onchange="cantidias();">
                                        <option></option>
    <?php for ($i = date("Y"); $i >= 1900; $i--) { ?>
                                            <option value="<?= $i ?>"<?php if (substr($row1['fechanac'], 0, 4) == $i) echo ' selected="selected"' ?>><?= $i ?></option>
    <?php } ?>
                                    </select>
                                    <span id="avisarmaldia">&nbsp;</span>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="sexo"><span class="asteriscoobliga">(*)</span> Sexo:</label></td>
                                <td>
                                    <select name="sexo" id="sexo">
                                        <option></option>
                                        <option value="masculino"<?php if (strtolower($row1['sexo']) == "masculino") echo ' selected="selected"' ?>>Masculino</option>
                                        <option value="femenino"<?php if (strtolower($row1['sexo']) == "femenino") echo ' selected="selected"' ?>>Femenino</option>
                                    </select>
                                </td>
                            </tr>
                        </table>
                        <hr/>
                        <table width="100%" border="0" cellspacing="5" cellpadding="0">
                            <tr>
                                <td style="width:39%">
                                    <label for="email"><span class="asteriscoobliga">(*)</span> Email:</label></td>
                                <td style="width:61%">
                                    <input type="text" name="email" id="email" onchange="checkeamail();" value="<?= $row1['email'] ?>"/><span id="avisarmalmail"></span>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="password"><span class="asteriscoobliga">(*)</span> Elegir Password:</label></td>
                                <td><input type="password" name="password" id="password" value="<?= utf8_encode($row1['password']) ?>"/></td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="passwordrepe"><span class="asteriscoobliga">(*)</span> Repetir Password:</label>
                                </td>
                                <td>
                                    <input type="password" name="passwordrepe" id="passwordrepe" onchange="checkearpassrepe();" value="<?= utf8_encode($row1['password']) ?>"/>
                                    <span id="avisarmalpassword">&nbsp;</span>
                                </td>
                            </tr>
                        </table>
                        <hr/>
                        <table width="100%" border="0" cellspacing="5" cellpadding="0">
                            <tr>
                                <td style="width:39%">
                                    <label for="telefonoparticular">Teléfono particular:</label>
                                </td>
                                <td style="width:61%">
                                    <input type="text" name="telefonoparticular" id="telefonoparticular" value="<?= $row1['telefonoparticular'] ?>"/>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="telefonolaboral">Teléfono laboral:</label>
                                </td>
                                <td>
                                    <input type="text" name="telefonolaboral" id="telefonolaboral" value="<?= $row1['telefonolaboral'] ?>"/>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="telefonocelular">Teléfono celular:</label>
                                </td>
                                <td>
                                    <input type="text" name="telefonocelular" id="telefonocelular" value="<?= $row1['telefonocelular'] ?>"/>
                                </td>
                            </tr>
                        </table>
                        <hr/>
                        <table width="100%" border="0" cellspacing="5" cellpadding="0">
                            <tr>
                                <td style="width:39%"><label for="domicilio"><span class="asteriscoobliga">(*)</span> Domicilio:</label></td>
                                <td style="width:61%"><input type="text" name="domicilio" id="domicilio" value="<?= utf8_encode($row1['domicilio']) ?>"/></td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="pais"><span class="asteriscoobliga">(*)</span> País:</label>
                                </td>
                                <td>
                                            <?php /* <input type="text" name="pais" id="pais" value="<?=utf8_encode($row1['pais'])?>"/> */ ?>
                                    <select name="pais" id="pais" style="width:250px;" onchange="
                                                                            if (this.value == 'Argentina') {
                                                                                document.getElementById('provincia').style.display = 'none';
                                                                                document.getElementById('selectprovincia').style.display = 'block';
                                                                            } else {
                                                                                document.getElementById('provincia').style.display = 'block';
                                                                                document.getElementById('selectprovincia').style.display = 'none';
                                                                            }
                                                                            " onkeyup="
                                                                                    if (this.value == 'Argentina') {
                                                                                        document.getElementById('provincia').style.display = 'none';
                                                                                        document.getElementById('selectprovincia').style.display = 'block';
                                                                                    } else {
                                                                                        document.getElementById('provincia').style.display = 'block';
                                                                                        document.getElementById('selectprovincia').style.display = 'none';
                                                                                    }
                                                                                    ">
                                        <option value=""></option>
    <?php include 'inc.lista_paises.php' ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label>
                                        <span class="asteriscoobliga">(*)</span> Provincia:
                                    </label></td>
                                <td>
                                    <input type="text" name="provincia" id="provincia" value="<?= utf8_encode($row1['provincia']) ?>"/>
                                    <select id="selectprovincia" name="selectprovincia" style="display:none;width:206px;" onchange="document.getElementById('provincia').value = this.value">
                                        <option value=""></option>
                                        <option value="Capital Federal">Capital Federal</option>
                                        <option value="Buenos Aires">Buenos Aires</option>
                                        <option value="Catamarca">Catamarca</option>
                                        <option value="Chaco">Chaco</option>
                                        <option value="Chubut">Chubut</option>
                                        <option value="Córdoba">Córdoba</option>
                                        <option value="Corrientes">Corrientes</option>
                                        <option value="Entre Ríos">Entre Ríos</option>
                                        <option value="Formosa">Formosa</option>
                                        <option value="Jujuy">Jujuy</option>
                                        <option value="La Pampa">La Pampa</option>
                                        <option value="La Rioja">La Rioja</option>
                                        <option value="Mendoza">Mendoza</option>
                                        <option value="Misiones">Misiones</option>
                                        <option value="Neuquén">Neuquén</option>
                                        <option value="Río Negro">Río Negro</option>
                                        <option value="Salta">Salta</option>
                                        <option value="San Juan">San Juan</option>
                                        <option value="San Luis">San Luis</option>
                                        <option value="Santa Cruz">Santa Cruz</option>
                                        <option value="Santa Fe">Santa Fe</option>
                                        <option value="Santiago del Estero">Santiago del Estero</option>
                                        <option value="Tierra del Fuego">Tierra del Fuego</option>
                                        <option value="Tucumán">Tucumán</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="localidad"><span class="asteriscoobliga">(*)</span> Localidad:</label></td>
                                <td><input type="text" name="localidad" id="localidad" value="<?= utf8_encode($row1['localidad']) ?>"/></td>
                            </tr>
                        </table>
                        <script type="text/javascript">
                        <!--
    <?php $direip = getRealIpAddr();
    $IPDetail = countryCityFromIP($direip)
    ?>
                            paisxip = '<?= ucwords(strtolower($IPDetail['country'])) ?>';
                            document.getElementById('pais').value = paisxip;
                            //document.getElementById('localidad').value = '<?= $IPDetail['city'] ?>';
                            if (document.getElementById('pais').value == 'Argentina') {
                                document.getElementById('provincia').style.display = 'none';
                                document.getElementById('selectprovincia').style.display = 'block';
                            }
    <?php if ($row1['pais'] != '') { ?>
                                document.getElementById('pais').value = '<?= $row1['pais'] ?>';
    <?php } ?>
                        -->
                        </script>
                    </div>
                </div>
                <div style="float:left;width:100%;">
                    <span id="completo" style="float:left;clear:left;line-height:30px;font-size:90%;color:#777;">Datos incompletos</span>
                    <input type="submit" value="Enviar" id="botonsumbit" disabled="disabled" style="float:right;clear:none;margin:10px;cursor:pointer;"/>
                </div>
            </form>
        </div>
        <script type="text/javascript">
    <!--
        checkacompleto();
    -->
        </script>
<?php } ?>
    <div class="banners">
        <img src="banners/comercio544x60.gif" alt="" width="544" height="60"/>
        <br/><br/>
        <img src="banners/banner-kappa.gif" alt="" width="544" height="60"/>
    </div>
</div>
<div id="right">
<?php include_once 'includes/faqsfull.php' ?>
</div>
<?php include_once 'includes/footer.php' ?>