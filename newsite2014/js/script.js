//var imagenesacargar = new Array("http://www.inscribiteonline.com.ar/webimages/solapa1.gif");
/*var lista_imagenes  = new Array();
function cargarimagenes() {
	for (i in imagenesacargar) {
		lista_imagenes[i] = new Image();
		lista_imagenes[i].src=imagenesacargar[i];
	}
} */
function mostrar(nombreid) {
	if (nombreid != '') {
		nuevoestado = 'visible';
		if (document.getElementById(nombreid).style.visibility == nuevoestado) nuevoestado = 'hidden';
		document.getElementById(nombreid).style.visibility = nuevoestado;
	}
}
function funcionderubro() {
	abc=document.getElementById('menurubro').value;
	document.getElementById('todoslosrubros').style.display       = 'none';
	document.getElementById("eventosdeportivos").style.display    = 'none';
	document.getElementById("eventoscapacitacion").style.display  = 'none';
	document.getElementById("eventosmensualidades").style.display = 'none';
	document.getElementById(abc).style.display='block';
}
function cambio(nombredelid) {
	document.getElementById("eventoelegidoenselect").value=document.getElementById(nombredelid).value;
}

var nav4 = window.Event ? true : false;
function acceptNum(evt) {
	// NOTE: Backspace = 8, Enter = 13, '0' = 48, '9' = 57
	var key = nav4 ? evt.which : evt.keyCode;
	return (key <= 13 || (key >= 48 && key <= 57) || ((evt.ctrlKey) && (key == 118)) || ((evt.ctrlKey) && (key == 120)) || ((evt.ctrlKey) && (key == 99)));
}
function limitalength (nombrec,canti) {
	nombrec.value=nombrec.value.substr(0,canti);
}

function cortardnilargo (objmsm) {
	textmsm2 = objmsm.value.replace('.','').replace('.','').replace('.','').replace('.','').replace('.','')
	textmsm3 = parseInt(textmsm2.toString());
	textmsm3 = textmsm3.toString().substring(0,8);
	if (isNaN(textmsm3)) textmsm3 = "";
	objmsm.value = textmsm3;
}

//Ajax
var http = getHTTPObject();
var ajaxlibre = true;
function getHTTPObject() {
	var xmlhttp
	/*@cc_on
	@if (@_jscript_version >= 5)
		try {
			xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
		try {
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		} catch (E) {
		xmlhttp = false;
		}
	}
	@else xmlhttp = false;
	@end @*/
	if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
		try {
			xmlhttp = new XMLHttpRequest();
		}catch(e) {
			xmlhttp = false;
		}
	}
	return xmlhttp
}
function handleHttpResponse() {
	if (http.readyState == 4) {
		ajaxlibre = true;
		//document.body.style.backgroundImage='none'
		//document.getElementById('seceventos').style.backgroundImage='none';
		//alert(http.responseText.length)
		//if ((http.responseText.length>0)&&(http.responseText.length!=296)) {
		//document.getElementById(seccionaactualizar).innerHTML=http.responseText;
		//}
		if (http.responseText*1 == 1) {
			location.href = "registrate";
		} else {
			document.getElementById('parapass').innerHTML = '<h2 style="text-align:left;float:left;padding:4px 6px;"><span style="text-align:left;font-size:14px;">CONTRASEÑA</span></h2><input type="password" name="passw" id="inputpassw" value="" class="search"/>';
			document.getElementById("formdelogin").action = '';
			document.getElementById("inputpassw").focus();
			if (document.getElementById("imagenpaso3")) {
				document.getElementById("imagenpaso1").src = 'images/paso-1b.gif';
				document.getElementById("imagenpaso2").src = 'images/paso-2b.gif';
				document.getElementById("imagenpaso3").src = 'images/paso-3.gif';
			}
			//document.getElementById(seccionaactualizar).innerHTML = http.responseText;
		}
		document.getElementById(seccionaactualizar).style.background = "";
	}
}
seccionaactualizar='';
function checkdni() {
	if (ajaxlibre) {
		seccionaactualizar = 'parapass';
		//document.getElementById('nota').style.backgroundImage='url(images/ajax-loader.gif)';
		ajaxlibre = false;
		document.getElementById(seccionaactualizar).innerHTML = '';
		document.getElementById(seccionaactualizar).style.height = "30px";
		//document.getElementById(seccionaactualizar).style.background = "transparent url(/webimages/cargando.gif) center center no-repeat";

		var mandValue = "?vars=";
		var mandValue = mandValue+"&dni="+document.getElementById('dninmbusuario').value;
		var mandValue = mandValue+"&random="+Math.random();

		http.open("GET", 'checkdnilogin'+mandValue, true);
		http.onreadystatechange=handleHttpResponse;
		http.send(null);
	}
}

if (document.getElementById('dninmbusuario'))
	document.getElementById('dninmbusuario').focus();
	
if (typeof(url) != "undefined") {
	arurl = Array();
	arurl[0] = url.replace('http://', '');
} else {
	url = location.href;
	url = url.replace('http://', '');
	arurl = url.split('/');
	if (arurl[0] == 'localhost') arurl[0] = arurl[0]+'/'+arurl[1];
	url = arurl[0];
}
var i = 0;
for (var node; node = document.getElementsByTagName('a')[i]; i++) {
	if ((node.href.indexOf('http://') > -1) && (!(node.href.indexOf(url.replace('www.', '')) > -1)))
		node.target = '_blank';
}
