<?
function countryCityFromIP($ipAddr){
  //verify the IP address for the
  ip2long($ipAddr)== -1 || ip2long($ipAddr) === false ? trigger_error("Invalid IP", E_USER_ERROR) : "";
  $ipDetail=array(); //initialize a blank array

  //get the XML result from hostip.info
  $xml = file_get_contents("http://api.hostip.info/?ip=".$ipAddr);

  //get the city name inside the node <gml:name> and </gml:name>
  //preg_match("@<Hostip>(\s)*<gml:name>(.*?)</gml:name>@si",$xml,$match);
  preg_match("|<gml:name>(.*)</gml:name>|s", $xml, $match);

  //assing the city name to the array
  $ciudad = $match[1];
  $ciudad = substr($ciudad, strpos($ciudad, '<gml:name>')+10, 100);
  $ipDetail['city']=$ciudad;
  if ($ipDetail['city'] == '(Unknown City?)') $ipDetail['city'] = '';

  //get the country name inside the node <countryName> and </countryName>
  preg_match("@<countryName>(.*?)</countryName>@si",$xml,$matches);

  //assign the country name to the $ipDetail array
  $ipDetail['country'] = $matches[1];
  if ($ipDetail['country'] == '(Unknown Country?)') $ipDetail['country'] = '';

  //return the array containing city, country and country code
  return $ipDetail;
}
function getRealIpAddr(){
  //check ip from share internet
  if (!empty($_SERVER['HTTP_CLIENT_IP'])){
    $ip=$_SERVER['HTTP_CLIENT_IP'];
  } //to check ip is pass from proxy
  elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
    $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
  }else{
    $ip=$_SERVER['REMOTE_ADDR'];
  }
  if (strpos($ip, ', ') > -1){
    $ar_ips = Array();
    $ar_ips = split(', ', $ip);
    $ip = $ar_ips[0];
  }
  return $ip;
}
include 'includes/head.php'?>
<script type="text/javascript">
<!--

function cantidias(){
    anho=document.getElementById('agnonacimiento').value;
	cantdias[1]=31;

    cantdias=new Array(0,31,0,31,30,31,30,31,31,30,31,30,31);
    if(((anho%4==0)&&(anho%100!=0))||(anho%400==0))
        cantdias[2]=29;
    else
        cantdias[2]=28;

  	if((document.getElementById('dianacimiento').value!="")&&(document.getElementById('mesnacimiento').value!='')&&(document.getElementById('agnonacimiento').value!='')){
		if(document.getElementById('dianacimiento').value>cantdias[document.getElementById('mesnacimiento').value]){
		 	document.getElementById('avisarmaldia').innerHTML='Ese mes solo tiene '+cantdias[document.getElementById('mesnacimiento').value]+' días';
		}
	}
}
function checkacompleto(){
	if((document.getElementById('nombre').value!='')&&
	 (document.getElementById('apellido').value!='')&&
<?php if($_GET['usuario']==''){ ?>
	 (document.getElementById('dni').value!='')&&
<?php } ?>
	 (document.getElementById('dianacimiento').value!='')&&
	 (document.getElementById('mesnacimiento').value!='')&&
	 (document.getElementById('agnonacimiento').value!='')&&
	 (document.getElementById('sexo').value!='')&&
	 (document.getElementById('email').value!='')&&
	 (document.getElementById('password').value!='')&&
	 (document.getElementById('passwordrepe').value!='')&&
	 ((document.getElementById('telefonoparticular').value!='')||(document.getElementById('telefonolaboral').value!='')||(document.getElementById("telefonocelular").value!=''))&&
	 (document.getElementById('domicilio').value!='')&&
	 (document.getElementById('localidad').value!='')&&
	 (document.getElementById('provincia').value!='')&&
	 (document.getElementById('pais').value!='')
	){
  	document.getElementById('completo').innerHTML='';
    document.getElementById('botonsumbit').disabled=false;
	} else {
	document.getElementById('completo').innerHTML="Datos incompletos ";
	document.getElementById("botonsumbit").disabled=true;
	}
}
function checkearpassrepe(){
	 if(document.getElementById("password").value!=document.getElementById("passwordrepe").value){
	 	//if(document.getElementById("passwordrepe").value!=''){
	 		document.getElementById('avisarmalpassword').innerHTML="El password repetido es diferente. Ingreselos nuevamente.";
			document.getElementById("password").value='';
			document.getElementById("passwordrepe").value='';
		//}
	 } else {
	 	document.getElementById('avisarmalpassword').innerHTML='';
	 }
}
function checkeamail(){
	if((document.getElementById('email').value.indexOf("@")<0)||(document.getElementById('email').value.indexOf(".")<0)){
	 	document.getElementById('avisarmalmail').innerHTML="El email ingresado es incorrecto el formato correcto es nombredelacuenta@host.extencion.pais";
		document.getElementById('email').value='';
	} else {
		document.getElementById('avisarmalmail').innerHTML='';
	}
}
document.body.onkeyup=checkacompleto;
document.body.onclick=checkacompleto;
-->
</script>
		<div class="columnacentral" id="colformulario" style="width:100%">
<?php if($_GET['usuario']==''){ ?>
		<p style="margin-left:9px;margin-bottom:10px;color:#336699;font-size:14px;">
         Formulario de registro:<br/>
         <span style="font-size:11px;">
         Al no estar aun registrado en el sistema, debes completar tus datos personales por unica vez,
         luego de hacerlo podras utilizar el sistema las veces siguientes ingresando únicamente con tu DNI
         </span>
        </p>
<?php }else{ ?>
		<p style="margin-left:9px;margin-bottom:10px;color:#336699;font-size:14px;">
         Corregí y actualizá tus datos:<br/>
        </p>
<?php }
   if(($usuario!='')&&($_GET['usuario']=='')){ ?>
	<br/>Usted est&aacute; logueado como <?
	$result1=mysql_query('SELECT * FROM inscribite_usuarios WHERE dni="'.$usuario.'" LIMIT 1 ');
	$row=mysql_fetch_array($result1);
	echo$row['nombre'].' '.$row['apellido']?>
<br/>
<a href="cerrarsesion">Cerrar Sesion para registrar a otro usuario</a>
<br/>
<a href="registrate?usuario=<?=$usuario?>">Ver o cambiar mis datos</a>
<br/><br/>
<?php }else{ ?>
		<!-- formulario -->
<?php /*
		<div style="margin-top:8px;margin-bottom:10px;margin-left:19px;color:red;font-size:11px;float:left;">
		<div style="float:left;padding-left:1em;">
		Si usted ya se ha registrado ingrese su nombre de <br/>
		usuario y contraseña ----------------------------><br/>
		de lo contrario llene el siguiente formulario
		</div>
		</div>
*/
	$result1=mysql_query('SELECT * FROM inscribite_usuarios WHERE dni="'.$_GET['usuario'].'" LIMIT 1 ');
	$row=mysql_fetch_array($result1);
?>
	<div style="width:487px;margin:0px auto 20px auto;">
	<form action="confirmaregistro" method="post">
	  <fieldset class="fieldsettotal" style="font-size:13px;padding:10px;"><legend>Datos Personales:</legend>
	  <p>
      <input type="hidden" name="id" value="<?=($_GET['usuario']!="")?$row['id']:'nuevo'?>"/>
	    <label for="nombre"><span class="asteriscoobliga">(*)</span>Nombre:</label>
	    <input type="text" name="nombre" id="nombre" value="<?=$row['nombre']?>"/>
	  </p>
	  <p>
	    <label for="apellido"><span class="asteriscoobliga">(*)</span>Apellido:</label>
    	<input type="text" name="apellido" id="apellido" value="<?=($row['apellido'])?>"/>
	  </p>
<?php if($_GET['usuario']==''){ ?>
	  <p>
	    <label for="dni"><span class="asteriscoobliga">(*)</span>DNI:</label>
    	<input type="text" name="dni" id="dni" value="<?=$row['dni']?>" onkeydown="this.value=this.value.replace('.','').replace('.','').replace('.','').replace('.','').substring(0,8);" onchange="this.value=this.value.replace('.','').replace('.','').replace('.','').replace('.','').substring(0,8);"/>
	  </p>
<?php }else{ ?>
      <input type="hidden" name="dni" value="<?=$row['dni']?>" />
<?php } ?>

   	<hr/>
      <div id="ocultarsiestaregistrado" style="width:460px;">
        <div style="float:left;clear:left;">
	        <span class="asteriscoobliga">(*)</span>Fecha de Nacimiento:
        </div>
      	<select name="agnonacimiento" id="agnonacimiento" style="float:right;clear:none;" onchange="cantidias();">
      		<option></option>
      		<?php for($i=date("Y");$i>=1900;$i--){ ?><option value="<?=$i?>"<?php if(substr($row['fechanac'],0,4)==$i)echo' selected="selected"'?>><?=$i?></option> <?php } ?>
     	</select>
     	<select name="mesnacimiento" id="mesnacimiento" style="float:right;clear:none;" onchange="cantidias();">
    		<option></option>
    		<option value="01"<?php if(substr($row['fechanac'],4,2)=="01")echo' selected="selected"'?>>Enero</option>
    		<option value="02"<?php if(substr($row['fechanac'],4,2)=="02")echo' selected="selected"'?>>Febrero</option>
    		<option value="03"<?php if(substr($row['fechanac'],4,2)=="03")echo' selected="selected"'?>>Marzo</option>
    		<option value="04"<?php if(substr($row['fechanac'],4,2)=="04")echo' selected="selected"'?>>Abril</option>
    		<option value="05"<?php if(substr($row['fechanac'],4,2)=="05")echo' selected="selected"'?>>Mayo</option>
    		<option value="06"<?php if(substr($row['fechanac'],4,2)=="06")echo' selected="selected"'?>>Junio</option>
    		<option value="07"<?php if(substr($row['fechanac'],4,2)=="07")echo' selected="selected"'?>>Julio</option>
    		<option value="08"<?php if(substr($row['fechanac'],4,2)=="08")echo' selected="selected"'?>>Agosto</option>
    		<option value="09"<?php if(substr($row['fechanac'],4,2)=="09")echo' selected="selected"'?>>Septiembre</option>
    		<option value="10"<?php if(substr($row['fechanac'],4,2)=="10")echo' selected="selected"'?>>Octubre</option>
    		<option value="11"<?php if(substr($row['fechanac'],4,2)=="11")echo' selected="selected"'?>>Noviembre</option>
    		<option value="12"<?php if(substr($row['fechanac'],4,2)=="12")echo' selected="selected"'?>>Diciembre</option>
    	</select>
    	<select name="dianacimiento" id="dianacimiento" style="float:right;clear:none;">
    		<option></option>
    		<?php for($i=1;$i<=31;$i++){ ?><option value="<?=$i?>" <?php if((substr($row['fechanac'],6,2)*1)==$i)echo'selected'?>><?=$i?></option> <?php } ?>
    	</select>
      <span id="avisarmaldia">&nbsp;</span>
     	<hr/>
    	<p>
      	<label for="sexo"><span class="asteriscoobliga">(*)</span>Sexo:</label>
      	<select name="sexo" id="sexo" >
      		<option></option>
      		<option value="masculino"<?php if(strtolower($row['sexo'])=="masculino")echo' selected="selected"'?>>Masculino</option>
       		<option value="femenino"<?php if(strtolower($row['sexo'])=="femenino")echo' selected="selected"'?>>Femenino</option>
      	</select>
	    </p>
	    <hr/>
     	<p>
	      <label for="email"><span class="asteriscoobliga">(*)</span>Email:</label>
      	<input type="text" name="email" id="email" onchange="checkeamail();" value="<?=$row['email']?>"/>&nbsp;&nbsp;<span id="avisarmalmail" style="float:left;clear:none;"></span>
	    </p>
	<p>
	<label for="password"><span class="asteriscoobliga">(*)</span>Elegir Password:</label>
	<input type="password" name="password" id="password" value="<?=utf8_encode($row['password'])?>"/>
	</p>
	<p>
	<label for="passwordrepe"><span class="asteriscoobliga">(*)</span>Repetir Password:</label>
	<input type="password" name="passwordrepe" id="passwordrepe" onchange="checkearpassrepe();" value="<?=utf8_encode($row['password'])?>"/> <span id="avisarmalpassword">&nbsp;</span>
	</p>
	<hr/>
	<p>
	<label for="telefonoparticular">Teléfono particular:</label>
	<input type="text" name="telefonoparticular" id="telefonoparticular" value="<?=$row['telefonoparticular']?>"/>
	</p>
	<p>
  	<label for="telefonolaboral">Teléfono laboral:</label>
  	<input type="text" name="telefonolaboral" id="telefonolaboral" value="<?=$row['telefonolaboral']?>"/>
	</p>
	<p>
  	<label for="telefonocelular">Teléfono celular:</label>
  	<input type="text" name="telefonocelular" id="telefonocelular" value="<?=$row['telefonocelular']?>"/>
	</p>
	<hr/>
	<p>
  	<label for="domicilio"><span class="asteriscoobliga">(*)</span>Domicilio:</label>
  	<input type="text" name="domicilio" id="domicilio" value="<?=utf8_encode($row['domicilio'])?>"/>
	</p>
	<p>
  	<label for="pais"><span class="asteriscoobliga">(*)</span>País:</label>
<?php /*
  	<input type="text" name="pais" id="pais" value="<?=utf8_encode($row['pais'])?>"/>
*/ ?>
                  <select name="pais" id="pais" style="width:206px;" onchange="
                    if (this.value == 'Argentina') {
                      document.getElementById('provincia').style.display = 'none'; document.getElementById('selectprovincia').style.display = 'block';
                    } else {
                      document.getElementById('provincia').style.display = 'block'; document.getElementById('selectprovincia').style.display = 'none';
                    } " onkeyup="
                    if (this.value == 'Argentina') {
                      document.getElementById('provincia').style.display = 'none'; document.getElementById('selectprovincia').style.display = 'block';
                    } else {
                      document.getElementById('provincia').style.display = 'block'; document.getElementById('selectprovincia').style.display = 'none';
                    } ">
    <option value="" selected="selected"></option>
    <option value="Afghanistan">Afghanistan</option>
    <option value="Albania">Albania</option>
    <option value="Algeria">Algeria</option>
    <option value="American Samoa">American Samoa</option>
    <option value="Andorra">Andorra</option>
    <option value="Angola">Angola</option>
    <option value="Anguilla">Anguilla</option>
    <option value="Antarctica">Antarctica</option>
    <option value="Antigua and Barbuda">Antigua and Barbuda</option>
    <option value="Argentina">Argentina</option>
    <option value="Armenia">Armenia</option>
    <option value="Aruba">Aruba</option>
    <option value="Australia">Australia</option>
    <option value="Austria">Austria</option>
    <option value="Azerbaijan">Azerbaijan</option>
    <option value="Bahamas">Bahamas</option>
    <option value="Bahrain">Bahrain</option>
    <option value="Bangladesh">Bangladesh</option>
    <option value="Barbados">Barbados</option>
    <option value="Belarus">Belarus</option>
    <option value="Belgium">Belgium</option>
    <option value="Belize">Belize</option>
    <option value="Benin">Benin</option>
    <option value="Bermuda">Bermuda</option>
    <option value="Bhutan">Bhutan</option>
    <option value="Bolivia">Bolivia</option>
    <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
    <option value="Botswana">Botswana</option>
    <option value="Bouvet Island">Bouvet Island</option>
    <option value="Brazil">Brazil</option>
    <option value="British Indian Ocean Territory">British Indian Ocean Territory</option>
    <option value="Brunei Darussalam">Brunei Darussalam</option>
    <option value="Bulgaria">Bulgaria</option>
    <option value="Burkina Faso">Burkina Faso</option>
    <option value="Burundi">Burundi</option>
    <option value="Cambodia">Cambodia</option>
    <option value="Cameroon">Cameroon</option>
    <option value="Canada">Canada</option>
    <option value="Cape Verde">Cape Verde</option>
    <option value="Cayman Islands">Cayman Islands</option>
    <option value="Central African Republic">Central African Republic</option>
    <option value="Chad">Chad</option>
    <option value="Chile">Chile</option>
    <option value="China">China</option>
    <option value="Christmas Island">Christmas Island</option>
    <option value="Cocos (Keeling) Islands">Cocos (Keeling) Islands</option>
    <option value="Colombia">Colombia</option>
    <option value="Comoros">Comoros</option>
    <option value="Congo">Congo</option>
    <option value="Congo, The Democratic Republic of The">Congo, The Democratic Republic of The</option>
    <option value="Cook Islands">Cook Islands</option>
    <option value="Costa Rica">Costa Rica</option>
    <option value="Cote D'ivoire">Cote D'ivoire</option>
    <option value="Croatia">Croatia</option>
    <option value="Cuba">Cuba</option>
    <option value="Cyprus">Cyprus</option>
    <option value="Czech Republic">Czech Republic</option>
    <option value="Denmark">Denmark</option>
    <option value="Djibouti">Djibouti</option>
    <option value="Dominica">Dominica</option>
    <option value="Dominican Republic">Dominican Republic</option>
    <option value="Ecuador">Ecuador</option>
    <option value="Egypt">Egypt</option>
    <option value="El Salvador">El Salvador</option>
    <option value="Equatorial Guinea">Equatorial Guinea</option>
    <option value="Eritrea">Eritrea</option>
    <option value="Estonia">Estonia</option>
    <option value="Ethiopia">Ethiopia</option>
    <option value="Falkland Islands (Malvinas)">Falkland Islands (Malvinas)</option>
    <option value="Faroe Islands">Faroe Islands</option>
    <option value="Fiji">Fiji</option>
    <option value="Finland">Finland</option>
    <option value="France">France</option>
    <option value="French Guiana">French Guiana</option>
    <option value="French Polynesia">French Polynesia</option>
    <option value="French Southern Territories">French Southern Territories</option>
    <option value="Gabon">Gabon</option>
    <option value="Gambia">Gambia</option>
    <option value="Georgia">Georgia</option>
    <option value="Germany">Germany</option>
    <option value="Ghana">Ghana</option>
    <option value="Gibraltar">Gibraltar</option>
    <option value="Greece">Greece</option>
    <option value="Greenland">Greenland</option>
    <option value="Grenada">Grenada</option>
    <option value="Guadeloupe">Guadeloupe</option>
    <option value="Guam">Guam</option>
    <option value="Guatemala">Guatemala</option>
    <option value="Guinea">Guinea</option>
    <option value="Guinea-bissau">Guinea-bissau</option>
    <option value="Guyana">Guyana</option>
    <option value="Haiti">Haiti</option>
    <option value="Heard Island and Mcdonald Islands">Heard Island and Mcdonald Islands</option>
    <option value="Holy See (Vatican City State)">Holy See (Vatican City State)</option>
    <option value="Honduras">Honduras</option>
    <option value="Hong Kong">Hong Kong</option>
    <option value="Hungary">Hungary</option>
    <option value="Iceland">Iceland</option>
    <option value="India">India</option>
    <option value="Indonesia">Indonesia</option>
    <option value="Iran, Islamic Republic of">Iran, Islamic Republic of</option>
    <option value="Iraq">Iraq</option>
    <option value="Ireland">Ireland</option>
    <option value="Israel">Israel</option>
    <option value="Italy">Italy</option>
    <option value="Jamaica">Jamaica</option>
    <option value="Japan">Japan</option>
    <option value="Jordan">Jordan</option>
    <option value="Kazakhstan">Kazakhstan</option>
    <option value="Kenya">Kenya</option>
    <option value="Kiribati">Kiribati</option>
    <option value="Korea, Democratic People's Republic of">Korea, Democratic People's Republic of</option>
    <option value="Korea, Republic of">Korea, Republic of</option>
    <option value="Kuwait">Kuwait</option>
    <option value="Kyrgyzstan">Kyrgyzstan</option>
    <option value="Lao People's Democratic Republic">Lao People's Democratic Republic</option>
    <option value="Latvia">Latvia</option>
    <option value="Lebanon">Lebanon</option>
    <option value="Lesotho">Lesotho</option>
    <option value="Liberia">Liberia</option>
    <option value="Libyan Arab Jamahiriya">Libyan Arab Jamahiriya</option>
    <option value="Liechtenstein">Liechtenstein</option>
    <option value="Lithuania">Lithuania</option>
    <option value="Luxembourg">Luxembourg</option>
    <option value="Macao">Macao</option>
    <option value="Macedonia, The Former Yugoslav Republic of">Macedonia, The Former Yugoslav Republic of</option>
    <option value="Madagascar">Madagascar</option>
    <option value="Malawi">Malawi</option>
    <option value="Malaysia">Malaysia</option>
    <option value="Maldives">Maldives</option>
    <option value="Mali">Mali</option>
    <option value="Malta">Malta</option>
    <option value="Marshall Islands">Marshall Islands</option>
    <option value="Martinique">Martinique</option>
    <option value="Mauritania">Mauritania</option>
    <option value="Mauritius">Mauritius</option>
    <option value="Mayotte">Mayotte</option>
    <option value="Mexico">Mexico</option>
    <option value="Micronesia, Federated States of">Micronesia, Federated States of</option>
    <option value="Moldova, Republic of">Moldova, Republic of</option>
    <option value="Monaco">Monaco</option>
    <option value="Mongolia">Mongolia</option>
    <option value="Montserrat">Montserrat</option>
    <option value="Morocco">Morocco</option>
    <option value="Mozambique">Mozambique</option>
    <option value="Myanmar">Myanmar</option>
    <option value="Namibia">Namibia</option>
    <option value="Nauru">Nauru</option>
    <option value="Nepal">Nepal</option>
    <option value="Netherlands">Netherlands</option>
    <option value="Netherlands Antilles">Netherlands Antilles</option>
    <option value="New Caledonia">New Caledonia</option>
    <option value="New Zealand">New Zealand</option>
    <option value="Nicaragua">Nicaragua</option>
    <option value="Niger">Niger</option>
    <option value="Nigeria">Nigeria</option>
    <option value="Niue">Niue</option>
    <option value="Norfolk Island">Norfolk Island</option>
    <option value="Northern Mariana Islands">Northern Mariana Islands</option>
    <option value="Norway">Norway</option>
    <option value="Oman">Oman</option>
    <option value="Pakistan">Pakistan</option>
    <option value="Palau">Palau</option>
    <option value="Palestinian Territory, Occupied">Palestinian Territory, Occupied</option>
    <option value="Panama">Panama</option>
    <option value="Papua New Guinea">Papua New Guinea</option>
    <option value="Paraguay">Paraguay</option>
    <option value="Peru">Peru</option>
    <option value="Philippines">Philippines</option>
    <option value="Pitcairn">Pitcairn</option>
    <option value="Poland">Poland</option>
    <option value="Portugal">Portugal</option>
    <option value="Puerto Rico">Puerto Rico</option>
    <option value="Qatar">Qatar</option>
    <option value="Reunion">Reunion</option>
    <option value="Romania">Romania</option>
    <option value="Russian Federation">Russian Federation</option>
    <option value="Rwanda">Rwanda</option>
    <option value="Saint Helena">Saint Helena</option>
    <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
    <option value="Saint Lucia">Saint Lucia</option>
    <option value="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option>
    <option value="Saint Vincent and The Grenadines">Saint Vincent and The Grenadines</option>
    <option value="Samoa">Samoa</option>
    <option value="San Marino">San Marino</option>
    <option value="Sao Tome and Principe">Sao Tome and Principe</option>
    <option value="Saudi Arabia">Saudi Arabia</option>
    <option value="Senegal">Senegal</option>
    <option value="Serbia and Montenegro">Serbia and Montenegro</option>
    <option value="Seychelles">Seychelles</option>
    <option value="Sierra Leone">Sierra Leone</option>
    <option value="Singapore">Singapore</option>
    <option value="Slovakia">Slovakia</option>
    <option value="Slovenia">Slovenia</option>
    <option value="Solomon Islands">Solomon Islands</option>
    <option value="Somalia">Somalia</option>
    <option value="South Africa">South Africa</option>
    <option value="South Georgia and The South Sandwich Islands">South Georgia and The South Sandwich Islands</option>
    <option value="Spain">Spain</option>
    <option value="Sri Lanka">Sri Lanka</option>
    <option value="Sudan">Sudan</option>
    <option value="Suriname">Suriname</option>
    <option value="Svalbard and Jan Mayen">Svalbard and Jan Mayen</option>
    <option value="Swaziland">Swaziland</option>
    <option value="Sweden">Sweden</option>
    <option value="Switzerland">Switzerland</option>
    <option value="Syrian Arab Republic">Syrian Arab Republic</option>
    <option value="Taiwan, Province of China">Taiwan, Province of China</option>
    <option value="Tajikistan">Tajikistan</option>
    <option value="Tanzania, United Republic of">Tanzania, United Republic of</option>
    <option value="Thailand">Thailand</option>
    <option value="Timor-leste">Timor-leste</option>
    <option value="Togo">Togo</option>
    <option value="Tokelau">Tokelau</option>
    <option value="Tonga">Tonga</option>
    <option value="Trinidad and Tobago">Trinidad and Tobago</option>
    <option value="Tunisia">Tunisia</option>
    <option value="Turkey">Turkey</option>
    <option value="Turkmenistan">Turkmenistan</option>
    <option value="Turks and Caicos Islands">Turks and Caicos Islands</option>
    <option value="Tuvalu">Tuvalu</option>
    <option value="Uganda">Uganda</option>
    <option value="Ukraine">Ukraine</option>
    <option value="United Arab Emirates">United Arab Emirates</option>
    <option value="United Kingdom">United Kingdom</option>
    <option value="United States">United States</option>
    <option value="United States Minor Outlying Islands">United States Minor Outlying Islands</option>
    <option value="Uruguay">Uruguay</option>
    <option value="Uzbekistan">Uzbekistan</option>
    <option value="Vanuatu">Vanuatu</option>
    <option value="Venezuela">Venezuela</option>
    <option value="Viet Nam">Viet Nam</option>
    <option value="Virgin Islands, British">Virgin Islands, British</option>
    <option value="Virgin Islands, U.S.">Virgin Islands, U.S.</option>
    <option value="Wallis and Futuna">Wallis and Futuna</option>
    <option value="Western Sahara">Western Sahara</option>
    <option value="Yemen">Yemen</option>
    <option value="Zambia">Zambia</option>
    <option value="Zimbabwe">Zimbabwe</option>
                </select>
	</p>
	<p>
  	<label for="provincia"><span class="asteriscoobliga">(*)</span>Provincia:</label>
  	<input type="text" name="provincia" id="provincia" value="<?=utf8_encode($row['provincia'])?>"/>
  <select id="selectprovincia" name="selectprovincia" style="display:none;width:206px;" onchange="document.getElementById('provincia').value=this.value">
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
  </p>
	<p>
  	<label for="localidad"><span class="asteriscoobliga">(*)</span>Localidad:</label>
  	<input type="text" name="localidad" id="localidad" value="<?=utf8_encode($row['localidad'])?>"/>
<script type="text/javascript">
<!--
<?
  $direip = getRealIpAddr();
  $IPDetail = countryCityFromIP($direip);
?>
  paisxip = '<?=ucwords(strtolower($IPDetail['country']))?>';
  document.getElementById('pais').value = paisxip;
  //document.getElementById('localidad').value = '<?=$IPDetail['city']?>';
  if (document.getElementById('pais').value == 'Argentina') {
    document.getElementById('provincia').style.display = 'none';
    document.getElementById('selectprovincia').style.display = 'block';
  }
-->
</script>
    	</p>
      <hr/>
<?php /*
      <div style="float:left;clear:left;">
	  Nadadores:
      </div>
  	<p>
  	<label for="pais">Entrenador:</label>
  	<input type="text" name="entrenador" value="<?=utf8_encode($row['entrenador'])?>"/>
  	</p>
  	<p>
  	<label for="pais">Pileta donde entrena:</label>
  	<input type="text" name="pileta" value="<?=utf8_encode($row['pileta'])?>"/>
  	</p>
*/ ?>
  	<p>
  	<span id="completo" style="float:left;clear:left;line-height:30px;font-size:90%;color:#777;">Datos incompletos </span><input type="submit" value="Enviar" id="botonsumbit" disabled="disabled" style="float:right;clear:none;"/>
  	</p>
      </div> <?php /* ocultar si esta registrado */ ?>
  	</fieldset>
  	</form>
	</div>
<script type="text/javascript">
<!--
checkacompleto();
-->
</script>
<?php } ?>
		</div>
<?php include 'includes/_solofooter.php'?>