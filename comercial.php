<? include 'includes/head.php'?>
<script type="text/javascript">
<!--

function cantidias() {
    anho=document.getElementById('agnonacimiento').value;
	cantdias[1]=31;

    cantdias=new Array(0,31,0,31,30,31,30,31,31,30,31,30,31);
    if (((anho%4==0)&&(anho%100!=0)) || (anho%400==0))
        cantdias[2]=29;
    else
        cantdias[2]=28;

  	if ((document.getElementById('dianacimiento').value!="")&&(document.getElementById('mesnacimiento').value!='')&&(document.getElementById('agnonacimiento').value!='')) {
		if (document.getElementById('dianacimiento').value>cantdias[document.getElementById('mesnacimiento').value]) {
		 	document.getElementById('avisarmaldia').innerHTML='Ese mes solo tiene '+cantdias[document.getElementById('mesnacimiento').value]+' días';
		}
	}
}
function checkacompleto() {
	if ((document.getElementById('nombre').value!='')&&
	 (document.getElementById('apellido').value!='')&&
<? if ($_GET['usuario']=='') { ?>
	 (document.getElementById('dni').value!='')&&
<? } ?>
	 (document.getElementById('dianacimiento').value!='')&&
	 (document.getElementById('mesnacimiento').value!='')&&
	 (document.getElementById('agnonacimiento').value!='')&&
	 (document.getElementById('sexo').value!='')&&
	 (document.getElementById('email').value!='')&&
	 (document.getElementById('password').value!='')&&
	 (document.getElementById('passwordrepe').value!='')&&
	 ((document.getElementById('telefonoparticular').value!='') || (document.getElementById('telefonolaboral').value!='') || (document.getElementById("telefonocelular").value!=''))&&
	 (document.getElementById('domicilio').value!='')&&
	 (document.getElementById('localidad').value!='')&&
	 (document.getElementById('provincia').value!='')&&
	 (document.getElementById('pais').value!='')
	) {
	document.getElementById('completo').innerHTML='';
	document.getElementById('botonsumbit').disabled=false;
	} else {
	document.getElementById('completo').innerHTML="Datos incompletos ";
	document.getElementById("botonsumbit").disabled=true;
	}
}
function checkearpassrepe() {
	 if (document.getElementById("password").value!=document.getElementById("passwordrepe").value) {
	 	//if (document.getElementById("passwordrepe").value!='') {
	 		document.getElementById('avisarmalpassword').innerHTML="El password repetido es diferente. Ingreselos nuevamente.";
			document.getElementById("password").value='';
			document.getElementById("passwordrepe").value='';
		//}
	 } else {
	 	document.getElementById('avisarmalpassword').innerHTML='';
	 }
}
function checkeamail() {
	if ((document.getElementById('email').value.indexOf("@")<0) || (document.getElementById('email').value.indexOf(".")<0)) {
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
		<div class="columnacentral" id="colformulario" style="overflow:hidden;">
<? if ($_GET['usuario']=='') { ?>
		<p style="margin-left:9px;margin-bottom:10px;color:#336699;font-size:14px;"><strong>Por favor registrese para acceder a la información comercial</strong></p>
<? } else { ?>
		<p style="margin-left:9px;margin-bottom:10px;color:#336699;font-size:14px;">
         Corregí y actualizá tus datos:<br/>
        </p>
<? }
   if (($usuario!='')&&($_GET['usuario']=='')) { ?>
	<br/>Usted est&aacute; logueado como <? 
	$result1=mysql_query('SELECT * FROM '.pftables.'usuarios WHERE dni="'.$usuario.'" LIMIT 1 ');
	$row1 =mysql_fetch_array($result1);
	echo$row1['nombre'].' '.$row1['apellido']?>
<br/>
<a href="cerrarsesion">Cerrar Sesion para registrar a otro usuario</a>
<br/>
<a href="registrate?usuario=<?=$usuario?>">Ver o cambiar mis datos</a>
<br/><br/>
<? } else { ?>
		<!-- formulario -->
<? /*
		<div style="margin-top:8px;margin-bottom:10px;margin-left:19px;color:red;font-size:11px;float:left;">
		<div style="float:left;padding-left:1em;">
		Si usted ya se ha registrado ingrese su nombre de <br/>
		usuario y contraseña ----------------------------><br/>
		de lo contrario llene el siguiente formulario
		</div>
		</div>
*/ ?>
<?
	$result1=mysql_query('SELECT * FROM '.pftables.'usuarios WHERE dni="'.$_GET['usuario'].'" LIMIT 1 ');
	$row1 =mysql_fetch_array($result1);
?>		
	<form action="confirmaregistro" method="post" style="float:left;clear:left;width:490px;margin-left:5px;overflow:hidden;">
	<fieldset class="fieldsettotal" style="font-size:13px;padding:10px;margin-left:100px;"><legend>Datos Personales:</legend>
	<p>
    <input type="hidden" name="id" value="<?=($_GET['usuario']!="")?$row1['id']:'nuevo'?>"/>
	<label for="nombre">Nombre:</label>
	<input type="text" name="nombre" id="nombre" value="<?=$row1['nombre']?>"/>
	</p>
	<p>
	<label for="apellido">Apellido:</label>
	<input type="text" name="apellido" id="apellido" value="<?=($row1['apellido'])?>"/>
	</p>
<? if ($_GET['usuario']=='') { ?>
	<p>
	<label for="dni">DNI:</label>
	<input type="text" name="dni" id="dni" onkeypress="return acceptNum(event);" value="<?=$row1['dni']?>" onkeydown="this.value=this.value.replace('.','').replace('.','').replace('.','').replace('.','').substring(0,8);" onchange="this.value=this.value.replace('.','').replace('.','').replace('.','').replace('.','').substring(0,8);"/>
	</p>
<? } else { ?>
    <input type="hidden" name="dni" value="<?=$row1['dni']?>"/>
<? } ?>

	<hr/>
    <div id="ocultarsiestaregistrado" style="width:360px;">
    <div style="float:left;clear:left;">
	Fecha de Nacimiento:
    </div>
	<p>
	<label for="dianacimiento">Día:</label>
	<select name="dianacimiento" id="dianacimiento" >
		<option></option>
		<? for($i=1;$i<=31;$i++) { ?><option value="<?=$i?>" <? if ((substr($row1['fechanac'],6,2)*1)==$i)echo'selected'?>><?=$i?></option> <? } ?>
	</select>
	</p>
	<p>
	<label for="mesnacimiento">Mes:</label>
	<select name="mesnacimiento" id="mesnacimiento" onchange="cantidias();">
		<option></option>
		<option value="01"<? if (substr($row1['fechanac'],4,2)=="01")echo' selected="selected"'?>>Enero</option>
		<option value="02"<? if (substr($row1['fechanac'],4,2)=="02")echo' selected="selected"'?>>Febrero</option>
		<option value="03"<? if (substr($row1['fechanac'],4,2)=="03")echo' selected="selected"'?>>Marzo</option>
		<option value="04"<? if (substr($row1['fechanac'],4,2)=="04")echo' selected="selected"'?>>Abril</option>
		<option value="05"<? if (substr($row1['fechanac'],4,2)=="05")echo' selected="selected"'?>>Mayo</option>
		<option value="06"<? if (substr($row1['fechanac'],4,2)=="06")echo' selected="selected"'?>>Junio</option>
		<option value="07"<? if (substr($row1['fechanac'],4,2)=="07")echo' selected="selected"'?>>Julio</option>
		<option value="08"<? if (substr($row1['fechanac'],4,2)=="08")echo' selected="selected"'?>>Agosto</option>
		<option value="09"<? if (substr($row1['fechanac'],4,2)=="09")echo' selected="selected"'?>>Septiembre</option>
		<option value="10"<? if (substr($row1['fechanac'],4,2)=="10")echo' selected="selected"'?>>Octubre</option>
		<option value="11"<? if (substr($row1['fechanac'],4,2)=="11")echo' selected="selected"'?>>Noviembre</option>
		<option value="12"<? if (substr($row1['fechanac'],4,2)=="12")echo' selected="selected"'?>>Diciembre</option>
	</select>
	</p>
	<p>
	<label for="agnonacimiento">Año:</label>
	<select name="agnonacimiento" id="agnonacimiento" onchange="cantidias();">
		<option></option>
		<? for($i=date("Y");$i>=1900;$i--) { ?><option value="<?=$i?>"<? if (substr($row1['fechanac'],0,4)==$i)echo' selected="selected"'?>><?=$i?></option> <? } ?>
	</select><span id="avisarmaldia">&nbsp;</span>
	</p>
	<hr/>
	<p>
	<label for="sexo">Sexo:</label>
	<select name="sexo" id="sexo" >
		<option></option>
		<option value="masculino"<? if (strtolower($row1['sexo'])=="masculino")echo' selected="selected"'?>>Masculino</option>
		<option value="femenino"<? if (strtolower($row1['sexo'])=="femenino")echo' selected="selected"'?>>Femenino</option>
	</select>
	</p>
	<hr/>
	<p>
	<label for="email">Email:</label>
	<input type="text" name="email" id="email" onchange="checkeamail();" value="<?=$row1['email']?>"/>&nbsp;&nbsp;<span id="avisarmalmail" style="float:left;clear:none;"></span>
	</p>
	<p>
	<label for="password">Elegir Password:</label>
	<input type="password" name="password" id="password" value="<?=utf8_encode($row1['password'])?>"/>
	</p>
	<p>
	<label for="passwordrepe">Repetir Password:</label>
	<input type="password" name="passwordrepe" id="passwordrepe" onchange="checkearpassrepe();" value="<?=utf8_encode($row1['password'])?>"/> <span id="avisarmalpassword">&nbsp;</span>
	</p>
	<hr/>
	<p>
	<label for="telefonoparticular">Teléfono particular:</label>
	<input type="text" name="telefonoparticular" id="telefonoparticular" onkeypress="return acceptNum(event)" value="<?=$row1['telefonoparticular']?>"/>
	</p>
	<p>
	<label for="telefonolaboral">Teléfono laboral:</label>
	<input type="text" name="telefonolaboral" id="telefonolaboral" onkeypress="return acceptNum(event)" value="<?=$row1['telefonolaboral']?>"/>
	</p>
	<p>
	<label for="telefonocelular">Teléfono celular:</label>
	<input type="text" name="telefonocelular" id="telefonocelular" onkeypress="return acceptNum(event)" value="<?=$row1['telefonocelular']?>"/>
	</p>
	<hr/>
	<p>
	<label for="domicilio">Domicilio:</label>
	<input type="text" name="domicilio" id="domicilio" value="<?=utf8_encode($row1['domicilio'])?>"/>
	</p>
	<p>
	<label for="localidad">Localidad:</label>
	<input type="text" name="localidad" id="localidad" value="<?=utf8_encode($row1['localidad'])?>"/>
	</p>
	<p>
	<label for="provincia">Provincia:</label>
	<input type="text" name="provincia" id="provincia" value="<?=utf8_encode($row1['provincia'])?>"/>
	</p>
	<p>
	<label for="pais">País:</label>
	<input type="text" name="pais" id="pais" value="<?=utf8_encode($row1['pais'])?>"/>
	</p>
    <hr/>
<? /*
    <div style="float:left;clear:left;">
	Nadadores:
    </div>
	<p>
	<label for="pais">Entrenador:</label>
	<input type="text" name="entrenador" value="<?=utf8_encode($row1['entrenador'])?>"/>
	</p>
	<p>
	<label for="pais">Pileta donde entrena:</label>
	<input type="text" name="pileta" value="<?=utf8_encode($row1['pileta'])?>"/>
	</p>
*/ ?>
	<p>
	<span id="completo" style="float:left;clear:left;line-height:30px;font-size:90%;color:#777;">Datos incompletos </span><input type="submit" value="Enviar" id="botonsumbit" disabled="disabled" style="float:right;clear:none;"/>
	</p>
    </div> <? /* ocultar si esta registrado */ ?>
	</fieldset>
	</form>
<script type="text/javascript">
<!--
checkacompleto();
-->
</script>
<? } ?> 
</div>
<? include 'includes/coldercom.php'?>