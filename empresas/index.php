<?	$usrenvista = $_SERVER['REQUEST_URI'];
	$dire_array = array();
	$dire_array = split("/", $usrenvista);
	$usrenvista = end($dire_array);
	if (strpos(end($dire_array), "?") != "")
		$usrenvista = substr(end($dire_array), 0, strpos(end($dire_array), "?"));
	$usrenvista = str_replace("_", " ", $usrenvista);

	mysql_select_db("inscribite_base", mysql_connect("localhost", "inscribite_user", "iW7zNKpRWkSHHwplBhUO"));

	$result = mysql_query('SELECT * FROM inscribite_empresas WHERE (password != "") AND password="'.$_POST['passw'].'" ');
	while ($row = mysql_fetch_array($result)) {
		$vocalesca = array('á', 'é', 'í', 'ó', 'ú', 'Á', 'É', 'Í', 'Ó', 'Ú', ' ');
		$vocalessa = array('a', 'e', 'i', 'o', 'u', 'A', 'E', 'I', 'O', 'U', '');
		$nombresinac = str_replace($vocalesca,   $vocalessa, $row['nombre']);
		$usernamesinac = str_replace($vocalesca, $vocalessa, $_POST['empresa']);
		if (strtolower($usernamesinac) == strtolower($nombresinac)) $sihay = true;
		$nombreempresa = $row['nombre'];
	}
	if ($sihay2) { /* ?>
		<form name="myform" action="http://www.inscribiteonline.com.ar/verinscripciones" method="post">
		<input type="hidden" value="<?=strtolower($_POST['empresa'])?>" name="empresa"/>
		<input type="submit" value="" style="overflow:hidden;background:none;border:none;width:1px;height:1px;"/>
		</form>
		<script type="text/javascript">
		<!--
		//location.href='http://www.inscribiteonline.com.ar/verinscripciones';
		document.myform.submit();
		-->
		</script><? */
	} else {
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es" >
<head>
<title>Inscribite Online</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<link href="http://www.inscribiteonline.com.ar/estilo.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript">
<!--
	function muestraborrar(nro){
		nuevoestado='visible';
		if(document.getElementById('borra'+nro).style.visibility=='visible')
			nuevoestado='hidden';
		document.getElementById('borra'+nro).style.visibility=nuevoestado;
	}
	var imagenesacargar=new Array("http://www.inscribiteonline.com.ar/webimages/solapa1.gif");
	var lista_imagenes=new Array();
	function cargarimagenes(){
	   for(i in imagenesacargar){
		 lista_imagenes[i]=new Image();
		 lista_imagenes[i].src=imagenesacargar[i];
		}
	}
	function mostrar(nombreid){
		if (nombreid != ''){
			nuevoestado='block';
			if(document.getElementById(nombreid).style.display=='block')
				nuevoestado='none';
			document.getElementById(nombreid).style.display=nuevoestado;
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
-->
</script>
<style type="text/css">
<!--
body{
    outline:0;
}
*{
    outline:0;
}
.contenidoseccioncentral{
	color:#000000;
}
form{
    width:100%;
}
-->
</style>
</head>
<body>
<div class="centrado">
	<div class="lineainicioyfinal">
	</div>
	<div class="header">
		<div class="separacionsolapas">
			<a href="http://www.inscribiteonline.com.ar/" class="logolinkalhome" ></a>
		</div>
	</div>
	<div class="content">
<?		if ($sihay) { ?>
		<div class="columnacentral" style="height:auto;width:100%;">
      <div style="margin-top:10px;margin-bottom:10px;">
		  	<strong><?=$nombreempresa?></strong>
      </div>
<?			$cuenta1 = 0;
			$result = mysql_query('SELECT * FROM inscribite_eventos WHERE ver = 1 AND empresa = "'.$nombreempresa.'" ');
			while ($row = mysql_fetch_array($result)) {
				$cuenta1++;
				if ($cuenta1 == 1) { ?>
      <div style="font-size:15px;margin-bottom:8px;">
        Eventos online:
      </div>
<?	} ?>
	<div style="float:left;clear:left;width:100%;">
		<input type="checkbox" name="paradescargar" class="paradescargar" value="<?=$row['codigo']?>" style="float:left;margin:5px 6px 1px 0px;"/>
		<a href="http://www.inscribiteonline.com.ar/verinscripciones?evento=<?=$row['codigo']?>"><?=trim($row['nombre'])?>: (<?
			$result2 = mysql_query('SELECT 1 FROM inscribite_inscripciones WHERE deevento = "'.$row['codigo'].'"');
			echo mysql_num_rows($result2)?> inscriptos) <span style="font-size:13px;">Ver - </span></a>
		<a href="http://www.inscribiteonline.com.ar/descargarinscripciones?evento=<?=$row['codigo']?>" style="font-size:13px;">Descargar</a>
	</div>
<?			}
			$cuenta2 = 0;
			$result = mysql_query('SELECT * FROM inscribite_eventos WHERE ver = 0 AND empresa = "'.$nombreempresa.'" ');
			while ($row = mysql_fetch_array($result)) {
				$cuenta2++;
				if ($cuenta2 == 1) { ?>
      <div style="font-size:15px;<? if ($cuenta1 > 0) echo 'margin-top:10px;'?>margin-bottom:8px;">
        Eventos offline:
      </div>
<?				} ?>
		<div style="float:left;clear:left;width:100%;">
			<input type="checkbox" name="paradescargar" class="paradescargar" value="<?=$row['codigo']?>" style="float:left;margin:5px 6px 1px 0px;"/>
			<a href="http://www.inscribiteonline.com.ar/verinscripciones?evento=<?=$row['codigo']?>"><?=$row['nombre']?>: <span style="font-size:13px;">Ver - </span></a>
			<a href="http://www.inscribiteonline.com.ar/descargarinscripciones?evento=<?=$row['codigo']?>" style="font-size:13px;">Descargar</a>
		</div>
<?			} ?>
        <div style="margin-top:10px;">
      <a href="#" onclick="
      var inputs=document.getElementsByTagName('input');
      idsparad = '';
      for(var i=0;i<inputs.length;i++) {
        if (inputs[i].className='paradescargar') {
          if (inputs[i].checked) {
            idsparad += inputs[i].value+',';
          }
        }
      }
      if (idsparad != '')
        location.href='../descargarinscripciones.php?eventos='+idsparad;
      return false;" style="color:#0682B8;font-weight:bold;">Descargar seleccionados</a>
        </div>
      </div>

<?		} else { ?>
		<div class="columnacentral" style="overflow:visible;width:100%;">
			<form action="" method="post">
			  <div style="text-align:left;width:300px;margin-left:auto;margin-right:auto;margin-top:30px;">
            <? if ($_POST['empresa'] != '')
                echo '<div style="color:red;">Nombre de usuario o contraseña incorrectos</div>'?>
			Empresa<br/>
			<input type="text" value="<?=$_GET['empresa']?>" id="inputempresa" name="empresa" style="width:160px" autocomplete="off"/><br/>
			Password<br/>
			<input type="password" name="passw" id="inputpassword" style="width:160px" autocomplete="off"/><br/>
<script type="text/javascript">
<!--
  document.getElementById('inputempresa').value = '<?=$_POST['empresa']?>';
  document.getElementById('inputpassword').value = '<?=$_POST['passw']?>';
-->
</script>
			<input type="submit" value="Entrar"/>
              <div style="margin-top:20px;">
				Si olvidó su contraseña comuniquese con <a href="mailto:info@maritimopro.com.ar">info@maritimopro.com.ar</a>
              </div>
		   	</div>
      </form>
		</div>
<?		} ?>

      </div>
      <div class="footer">
        Inscribite on line es un producto de MARITIMO SRL / 4641-4423 4643-1124 /  <a href="mailto:consultas@inscribiteonline.com.ar">consultas@inscribiteonline.com.ar</a>
      </div>
      <div class="lineainicioyfinal"></div>
    </div>
  </body>
</html><?php
	}
	if (is_resource($result)) mysql_free_result($result);
	if (is_resource($result2)) mysql_free_result($result2);
	mysql_close();
?>