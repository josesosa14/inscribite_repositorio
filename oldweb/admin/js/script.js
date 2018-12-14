//Precarga de imagenes (de rollover y carga ajax)
var imagenesacargar=new Array("images/ajaxloadingbig.gif");
var lista_imagenes=new Array();
function cargarimagenes(){
 for(i in imagenesacargar){
  lista_imagenes[i]=new Image();
  lista_imagenes[i].src=imagenesacargar[i];
 }
}

editaritem="";
function escribiendo(e){
 if(window.event){ // IE
  keynum=e.keyCode
 }else if(e.which){ // Netscape/Firefox/Opera
  keynum=e.which
 }
 keychar=String.fromCharCode(keynum)
 if(editaritem!=""){
  if(keynum==13){
   document.getElementById(editaritem).value=document.getElementById(editaritem).value+'<br/>';
   editaritem="";
  }else{
   //return(event.keyCode=keynum);
  }
 }
}

var nav4 = window.Event ? true : false;
function acceptNum(evt,nobj,maxnum){
 // NOTE: Backspace = 8, Enter = 13, '0' = 48, '9' = 57
 var key = nav4 ? evt.which : evt.keyCode;
 //alert(key)
 //alert(nobj.value)
 return(((key <= 13 || (key >= 48 && key <= 57) || (key >= 96 && key <= 105))&&(nobj.value.length<maxnum))||(key==8));
}

function checkacantcar(nombrecoso,cantcar){
 document.getElementById(nombrecoso).value=document.getElementById(nombrecoso).value.substring(0,(cantcar-1));
}

function editarcategoria(){
 location.href='?sec=categorias.admin&evento='+document.getElementById('categoriaelegida').value;
}
function agregaracateg(){
 location.href='?sec=categorias.agregar&evento='+document.getElementById('categelegidapnueva').value;
}
function editarinscripcion(){
 location.href='?sec=inscripciones.admin&evento='+document.getElementById('celegidapedinscri').value;
}
function confirm_entry(nombreaborrar,volvera,nmtabla,nroid){
 input_box=confirm('Seguro desea borrar '+nombreaborrar);
 if(input_box==true)
  location.href='borrar?tabla='+nmtabla+'&id='+nroid+'&volvera='+volvera;
}
function confirm_dupli(nombreadupl,nroid){
 input_box=confirm('Duplicar '+nombreadupl);
 if(input_box==true)
  location.href='duplicar?id='+nroid;
}

function subirorden(nroid){
  ordensubir = document.getElementById('orden'+nroid).value;
  antcamb1  = document.getElementById('contorden'+(ordensubir-1)+'_1').innerHTML;
  antcamb2  = document.getElementById('contorden'+(ordensubir-1)+'_2').innerHTML;
  antcamb3  = document.getElementById('contorden'+(ordensubir-1)+'_3').innerHTML;
  antcamb4  = document.getElementById('contorden'+(ordensubir-1)+'_4').innerHTML;
  antcamb5  = document.getElementById('contorden'+(ordensubir-1)+'_5').innerHTML;
  antcamb6  = document.getElementById('contorden'+(ordensubir-1)+'_6').innerHTML;
  antcamb7  = document.getElementById('contorden'+(ordensubir-1)+'_7').innerHTML;
  antcamb8  = document.getElementById('contorden'+(ordensubir-1)+'_8').innerHTML;
  antcamb9  = document.getElementById('contorden'+(ordensubir-1)+'_9').innerHTML;
  antcamb10 = document.getElementById('contorden'+(ordensubir-1)+'_10').innerHTML;
  antcamb11 = document.getElementById('contorden'+(ordensubir-1)+'_11').innerHTML;
  antcamb12 = document.getElementById('contorden'+(ordensubir-1)+'_12').innerHTML;
  document.getElementById('contorden'+(ordensubir-1)+'_1').innerHTML = document.getElementById('contorden'+ordensubir+'_1').innerHTML;
  document.getElementById('contorden'+(ordensubir-1)+'_2').innerHTML = document.getElementById('contorden'+ordensubir+'_2').innerHTML;
  document.getElementById('contorden'+(ordensubir-1)+'_3').innerHTML = document.getElementById('contorden'+ordensubir+'_3').innerHTML;
  document.getElementById('contorden'+(ordensubir-1)+'_4').innerHTML = document.getElementById('contorden'+ordensubir+'_4').innerHTML;
  document.getElementById('contorden'+(ordensubir-1)+'_5').innerHTML = document.getElementById('contorden'+ordensubir+'_5').innerHTML;
  document.getElementById('contorden'+(ordensubir-1)+'_6').innerHTML = document.getElementById('contorden'+ordensubir+'_6').innerHTML;
  document.getElementById('contorden'+(ordensubir-1)+'_7').innerHTML = document.getElementById('contorden'+ordensubir+'_7').innerHTML;
  document.getElementById('contorden'+(ordensubir-1)+'_8').innerHTML = document.getElementById('contorden'+ordensubir+'_8').innerHTML;
  document.getElementById('contorden'+(ordensubir-1)+'_9').innerHTML = document.getElementById('contorden'+ordensubir+'_9').innerHTML;
  document.getElementById('contorden'+(ordensubir-1)+'_10').innerHTML = document.getElementById('contorden'+ordensubir+'_10').innerHTML;
  document.getElementById('contorden'+(ordensubir-1)+'_11').innerHTML = document.getElementById('contorden'+ordensubir+'_11').innerHTML;
  document.getElementById('contorden'+(ordensubir-1)+'_12').innerHTML = document.getElementById('contorden'+ordensubir+'_12').innerHTML;
  document.getElementById('contorden'+ordensubir+'_1').innerHTML = antcamb1;
  document.getElementById('contorden'+ordensubir+'_2').innerHTML = antcamb2;
  document.getElementById('contorden'+ordensubir+'_3').innerHTML = antcamb3;
  document.getElementById('contorden'+ordensubir+'_4').innerHTML = antcamb4;
  document.getElementById('contorden'+ordensubir+'_5').innerHTML = antcamb5;
  document.getElementById('contorden'+ordensubir+'_6').innerHTML = antcamb6;
  document.getElementById('contorden'+ordensubir+'_7').innerHTML = antcamb7;
  document.getElementById('contorden'+ordensubir+'_8').innerHTML = antcamb8;
  document.getElementById('contorden'+ordensubir+'_9').innerHTML = antcamb9;
  document.getElementById('contorden'+ordensubir+'_10').innerHTML = antcamb10;
  document.getElementById('contorden'+ordensubir+'_11').innerHTML = antcamb11;
  document.getElementById('contorden'+ordensubir+'_12').innerHTML = antcamb12;

  ordenant=document.getElementById('orden'+nroid).value;
  document.getElementById('orden'+nroid).value=(ordensubir-1);
  document.getElementById('orden'+arrayIdxOrden[(ordensubir-1)]).value=ordenant;
  arrayIdxOrden[ordensubir]=arrayIdxOrden[(ordensubir-1)];
  arrayIdxOrden[(ordensubir-1)]=nroid;

  //document.getElementById('contorden'+ordensubir).style.backgroundColor='transparent;';
}
function bajarorden(nroid){
 ordensubir=document.getElementById('orden'+nroid).value;

 antcamb1=document.getElementById('contorden'+((ordensubir*1)+1)+'_1').innerHTML;
 antcamb2=document.getElementById('contorden'+((ordensubir*1)+1)+'_2').innerHTML;
 antcamb3=document.getElementById('contorden'+((ordensubir*1)+1)+'_3').innerHTML;
 antcamb4=document.getElementById('contorden'+((ordensubir*1)+1)+'_4').innerHTML;
 antcamb5=document.getElementById('contorden'+((ordensubir*1)+1)+'_5').innerHTML;
 antcamb6=document.getElementById('contorden'+((ordensubir*1)+1)+'_6').innerHTML;
 antcamb7=document.getElementById('contorden'+((ordensubir*1)+1)+'_7').innerHTML;
 antcamb8=document.getElementById('contorden'+((ordensubir*1)+1)+'_8').innerHTML;
 antcamb9=document.getElementById('contorden'+((ordensubir*1)+1)+'_9').innerHTML;
 antcamb10=document.getElementById('contorden'+((ordensubir*1)+1)+'_10').innerHTML;
 document.getElementById('contorden'+((ordensubir*1)+1)+'_1').innerHTML=document.getElementById('contorden'+ordensubir+'_1').innerHTML;
 document.getElementById('contorden'+((ordensubir*1)+1)+'_2').innerHTML=document.getElementById('contorden'+ordensubir+'_2').innerHTML;
 document.getElementById('contorden'+((ordensubir*1)+1)+'_3').innerHTML=document.getElementById('contorden'+ordensubir+'_3').innerHTML;
 document.getElementById('contorden'+((ordensubir*1)+1)+'_4').innerHTML=document.getElementById('contorden'+ordensubir+'_4').innerHTML;
 document.getElementById('contorden'+((ordensubir*1)+1)+'_5').innerHTML=document.getElementById('contorden'+ordensubir+'_5').innerHTML;
 document.getElementById('contorden'+((ordensubir*1)+1)+'_6').innerHTML=document.getElementById('contorden'+ordensubir+'_6').innerHTML;
 document.getElementById('contorden'+((ordensubir*1)+1)+'_7').innerHTML=document.getElementById('contorden'+ordensubir+'_7').innerHTML;
 document.getElementById('contorden'+((ordensubir*1)+1)+'_8').innerHTML=document.getElementById('contorden'+ordensubir+'_8').innerHTML;
 document.getElementById('contorden'+((ordensubir*1)+1)+'_9').innerHTML=document.getElementById('contorden'+ordensubir+'_9').innerHTML;
 document.getElementById('contorden'+((ordensubir*1)+1)+'_10').innerHTML=document.getElementById('contorden'+ordensubir+'_10').innerHTML;
 document.getElementById('contorden'+ordensubir+'_1').innerHTML=antcamb1;
 document.getElementById('contorden'+ordensubir+'_2').innerHTML=antcamb2;
 document.getElementById('contorden'+ordensubir+'_3').innerHTML=antcamb3;
 document.getElementById('contorden'+ordensubir+'_4').innerHTML=antcamb4;
 document.getElementById('contorden'+ordensubir+'_5').innerHTML=antcamb5;
 document.getElementById('contorden'+ordensubir+'_6').innerHTML=antcamb6;
 document.getElementById('contorden'+ordensubir+'_7').innerHTML=antcamb7;
 document.getElementById('contorden'+ordensubir+'_8').innerHTML=antcamb8;
 document.getElementById('contorden'+ordensubir+'_9').innerHTML=antcamb9;
 document.getElementById('contorden'+ordensubir+'_10').innerHTML=antcamb10;

 ordenant=document.getElementById('orden'+nroid).value;
 document.getElementById('orden'+nroid).value=((ordensubir*1)+1);
 document.getElementById('orden'+arrayIdxOrden[((ordensubir*1)+1)]).value=ordenant;
 arrayIdxOrden[ordensubir]=arrayIdxOrden[((ordensubir*1)+1)];
 arrayIdxOrden[((ordensubir*1)+1)]=nroid;

 //document.getElementById('contorden'+ordensubir).style.backgroundColor='transparent;';
}
function activalimiteedad(nobjt){
 if(nobjt.checked){
  document.getElementById('edadesmaxmin').style.display='block';
 }else{
  document.getElementById('edadesmaxmin').style.display='none';
  //document.getElementById('edadminima').value='';
  //document.getElementById('edadmaxima').value='';
 }
}

function minimizarmenu(){
 document.getElementById('menulateral').style.width        = '9px';
 document.getElementById('restocontenidomenu').style.width = '1px';
 document.getElementById('minimizar').style.display        = 'none';
 document.getElementById('main').style.paddingLeft         = '26px';
}
function maximizarmenu(){
 document.getElementById('menulateral').style.width        = '140px';
 document.getElementById('restocontenidomenu').style.width = '100%';
 document.getElementById('minimizar').style.display        = 'inline';
 document.getElementById('main').style.paddingLeft         = '155px';
}

function displayHTML(){
 var inf=document.getElementById('descrevent').value;
 win=window.open(", ", 'popup', 'toolbar=no,scrollbars=1,status=no');
 win.document.write("" + inf + "");
}

empiezaarras=false;
function tocacal(nrocal,nombreid,diaencal,nrodia,nromes,nroanio){
 fechaencaso=String(nroanio)+("0"+String(nromes)).substr(("0"+String(nromes)).length-2,2)+("0"+String(nrodia)).substr(("0"+String(nrodia)).length-2,2);
 colactual=diaencal.style.backgroundColor.toString().toUpperCase();
 var ja=new Array();
 ja=document.getElementById(nombreid).value.toString().split(" ");
 if((colactual=='#C9DAEE')||(colactual=='RGB(201, 218, 238)')){
  diaencal.style.backgroundColor='white';
 }else{
  diaencal.style.backgroundColor='#C9DAEE';
  if(ultfechatoc[nrocal]!='1')
   ultfechatoc[nrocal].style.backgroundColor='white';
  ultfechatoc[nrocal]=diaencal;
 }
 document.getElementById(nombreid).value=fechaencaso;
}

function disableSelection(target){
 if(typeof target.onselectstart!="undefined") //IE route
  target.onselectstart=function(){return false}
 else if(typeof target.style.MozUserSelect!="undefined") //Firefox route
  target.style.MozUserSelect="none"
 else //All other route (ie: Opera)
  target.onmousedown=function(){return false}
 target.style.cursor = "default"
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
  respuesta=http.responseText;
  if((http.responseText.length>0)&&(http.responseText.length!=298))
   seccionaactualizar.innerHTML=''+respuesta;
  //alert(seccionaactualizar)
  //eval(http.responseText)
 }
}

seccionaactualizar=''
function leemes(objaact,id,campo,nromes,nroanio){
 if(ajaxlibre){
  seccionaactualizar=document.getElementById(objaact);
  //document.getElementById('nota').style.backgroundImage='url(images/ajax-loader.gif)';
  ajaxlibre=false;
  seccionaactualizar.innerHTML='';
  var mandValue="?vars=";
  var mandValue=mandValue+"&nobjeto="+objaact;

  var mandValue=mandValue+"&id="+id;
  var mandValue=mandValue+"&campo="+campo;
  var mandValue=mandValue+"&mes="+nromes;
  var mandValue=mandValue+"&anio="+nroanio;
  var mandValue=mandValue+"&valrand="+Math.random();
  http.open("GET",'leemes.php'+mandValue,true);
   http.onreadystatechange=handleHttpResponse;
  http.send(null);
 }
}
// para ver nube de busquedas realizadas
ultnubvist='';

function cmbcheck(acambiar,tabla,campo,id,va){
 if(ajaxlibre){
  seccionaactualizar=acambiar;
  acambiar.innerHTML='<img src="images/load1.gif" alt=""/>';
  ajaxlibre=false;
  http.open("GET",'cambiacheck.php?tabla='+tabla+'&campo='+campo+'&id='+id+'&va='+va+'&rand='+Math.random(),true);
  http.onreadystatechange=handleHttpResponse;
  http.send(null);
 }
}
