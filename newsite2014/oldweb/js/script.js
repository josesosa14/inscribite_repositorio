var imagenesacargar=new Array("http://www.inscribiteonline.com.ar/webimages/solapa1.gif");
var lista_imagenes=new Array();
function cargarimagenes(){
   for(i in imagenesacargar){
	 lista_imagenes[i]=new Image();
	 lista_imagenes[i].src=imagenesacargar[i];
	}
}
function mostrar(nombreid){
	if(nombreid!=''){
		nuevoestado='visible';
		if(document.getElementById(nombreid).style.visibility==nuevoestado) nuevoestado='hidden';
		document.getElementById(nombreid).style.visibility=nuevoestado;
	}
}
function funcionderubro(){
	abc=document.getElementById('menurubro').value;
	document.getElementById('todoslosrubros').style.display='none';
	document.getElementById("eventosdeportivos").style.display='none';
	document.getElementById("eventoscapacitacion").style.display='none';
	document.getElementById("eventosmensualidades").style.display='none';
	document.getElementById(abc).style.display='block';
}
function cambio(nombredelid){
	document.getElementById("eventoelegidoenselect").value=document.getElementById(nombredelid).value;
}

var nav4=window.Event ? true : false;
function acceptNum(evt){
	// NOTE: Backspace = 8, Enter = 13, '0' = 48, '9' = 57
	var key = nav4 ? evt.which : evt.keyCode;
	return (key <= 13 || (key >= 48 && key <= 57) || ((evt.ctrlKey)&&(key == 118)) || ((evt.ctrlKey)&&(key == 120)) || ((evt.ctrlKey)&&(key == 99)));
}
function limitalength(nombrec,canti){
	nombrec.value=nombrec.value.substr(0,canti);
}

function cortardnilargo(objmsm){
    textmsm2=objmsm.value.replace('.','').replace('.','').replace('.','').replace('.','').replace('.','')
    textmsm3=parseInt(textmsm2.toString());
    textmsm3=textmsm3.toString().substring(0,8);
    if(isNaN(textmsm3)) textmsm3="";
    objmsm.value=textmsm3;
}

//Ajax
var http=getHTTPObject()
var ajaxlibre=true
function getHTTPObject(){ var xmlhttp
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
    if(!xmlhttp && typeof XMLHttpRequest!='undefined'){
        try{
            xmlhttp=new XMLHttpRequest();
    	}catch(e){
    		xmlhttp=false;
    	}
    }
    return xmlhttp
}
function handleHttpResponse(){
    if(http.readyState==4){
	    ajaxlibre=true;
	    //document.body.style.backgroundImage='none'
        //document.getElementById('seceventos').style.backgroundImage='none';
        //alert(http.responseText.length)
        //if((http.responseText.length>0)&&(http.responseText.length!=296)){
	      //document.getElementById(seccionaactualizar).innerHTML=http.responseText;
        //}
        //if(http.responseText=='location.href="registrate"')
	      eval(http.responseText)
        //else
          //document.getElementById(seccionaactualizar).innerHTML=http.responseText;

        document.getElementById(seccionaactualizar).style.background = "";
    }
}
seccionaactualizar='';
function checkdni(){
  if(ajaxlibre){
    seccionaactualizar='parapass';
    //document.getElementById('nota').style.backgroundImage='url(images/ajax-loader.gif)';
  	ajaxlibre=false;
    document.getElementById(seccionaactualizar).innerHTML='';
    document.getElementById(seccionaactualizar).style.height = "37px";
    //document.getElementById(seccionaactualizar).style.background = "url('webimages/cargando.gif') center middle no-repeat";

  	var mandValue = "?vars=";
  	var mandValue = mandValue+"&dni="+document.getElementById('dninmbusuario').value;
  	var mandValue = mandValue+"&random="+Math.random();
  	http.open("GET", 'checkdnilogin'+mandValue, true);
    http.onreadystatechange = handleHttpResponse;
  	http.send(null);
  }
}
