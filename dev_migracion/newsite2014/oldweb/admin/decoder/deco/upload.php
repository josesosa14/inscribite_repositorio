<html>
<head>
<?php //<meta http-equiv="refresh" content="0;URL=index.php"> ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>
<style type="text/css">
<!--
	body {
	font-family:Arial, Helvetica, sans-serif;
	font-size:12px;
	}
	table {
	font-family:Arial, Helvetica, sans-serif;
	font-size:12px;
	margin-top:10px;
	margin-bottom:10px;
	/*float:left;*/
	display:block;
	}
	tr{
		border:1px black solid;
	}
	td{
		border:1px #DDDDDD solid;
	}
	.textoidcliente{
		color:#AAAAAA;
	}
	.nombredato{
	color:#999999;
	}
	div{
		/*float:left;*/
	}
-->
</style>
<body>
<?
//$directorio = '/';
$directorio = '../images/';
$newnombre =  $_FILES['archivo_usuario']['name'];

//echo $newnombre;

if (move_uploaded_file($_FILES['archivo_usuario']['tmp_name'], $directorio . $_FILES['archivo_usuario']['name']))
{
    //print "El archivo fue subido con éxito.";
	
	//abrimos el archivo en lectura
	$archivo = '../images/'.$newnombre;
	$fp = fopen($archivo,'r');
	
	//leemos el archivo
	$texto = fread($fp, filesize($archivo));
	
	//transformamos los saltos de línea en etiquetas <br>
	//$texto = nl2br($texto);
	
	//echo $texto;
	
	$conte = $texto;
?>
<div>
<?php /*Record Code:<br />
<?php echo substr($conte,0,1); ?><br /> */ ?>
<span class="nombredato">Fecha:</span><br />
<?php echo substr($conte,7,2); ?>/<?php echo substr($conte,5,2); ?>/<?php echo substr($conte,1,4); ?>
<br />
<span class="nombredato">Origin Name:</span><br />
<?php echo substr($conte,9,25); ?><br />
<span class="nombredato">ID Empresa:</span><br />
<?php echo substr($conte,34,9); ?><br />
<span class="nombredato">Empresa</span>:<br />
<?php echo substr($conte,43,15); ?><br />
<?php //echo substr($conte,78,50); ?><br />

<?php /*Record Code:<br />
<?php echo substr($conte,130,1); ?><br />
*/ ?>
<span class="nombredato">Fecha:</span><br />
<?php echo substr($conte,137,2); ?>/<?php echo substr($conte,135,2); ?>/<?php echo substr($conte,131,4); ?>
<br />
<span class="nombredato">Lote:</span><br />
<?php echo substr($conte,139,6); ?><br />
<span class="nombredato">Empresa:</span><br />
<?php echo substr($conte,145,15); ?>
<?php //echo substr($conte,180,78); ?>
</div>
<br />
<table style="border:1px black solid; margin-top:0px; float:left; width:100%;">
<tr>
<?php /*<td>
Record Code:
</td> */ ?>
<td>
Nro.
</td>
<td>
<?php //Código de Transacción: ?>
</td>
<td>
<?php //Fecha de proceso: ?>
</td>
<td>
<?php //Fecha de creación: ?>
</td>
<td>
Id del cliente:
</td>
<td>
&nbsp;
</td>
<td>
Monto:
</td>
<td>
Realizado en Terminal:
</td>
<td>
Fecha:
</td>
<td>
Hora:
</td>
<td>
<?php //Número de secuencia en terminal: ?>
</td>
<td>
<?php //Código de barras: ?>
</td>
<td>
<?php //Moneda: ?>
</td>
<td>
<?php //Efectivo o Cheque ?>
</td>
</tr>
<?php 
$posant = 260;
while ( substr($conte,$posant,1) == 5 ) {
?>
<tr class="cadaoperacion">
<?php /*<td>
<?php echo substr($conte,$posant,1); ?>
</td> */ ?>
<td>
<?php echo (substr($conte,$posant+1,5)+0); ?>
</td>
<td>
<?php //echo substr($conte,$posant+6,2); ?>
</td>
<td>
<?php /*echo substr($conte,$posant+14,2); ?>/<?php echo substr($conte,$posant+12,2); ?>/<?php echo substr($conte,$posant+8,4); */?>
</td>
<td>
<?php /*echo substr($conte,$posant+22,2); ?>/<?php echo substr($conte,$posant+20,2); ?>/<?php echo substr($conte,$posant+16,4); */?>
</td>
<td>
<?
//echo substr($conte,$posant+24,20); 

$conexio = mysql_connect("localhost", "maritimo_beebee", "beebee");
mysql_select_db ("maritimo_login", $conexio) OR die ("No se puede conectar");

$result = mysql_query('SELECT * FROM inscribite_usuarios WHERE dni = "'.(substr($conte,$posant+30,15)+0).'" LIMIT 1 ');
while($row = mysql_fetch_array($result)) {
echo ucwords($row["nombre"])." ".ucwords($row["apellido"])." ";
mysql_query ('UPDATE inscribite_usuarios SET confirmado0 = 1 WHERE dni = "'.(substr($conte,$posant+30,15)+0).'" ');
}

echo '<span class="textoidcliente">evento: </span>'.substr(substr($conte,$posant+24,20),0,2)." ";
echo '<span class="textoidcliente">categoría: </span>'.substr(substr($conte,$posant+24,20),2,2)." ";
echo '<span class="textoidcliente">edad computada: </span>'.substr(substr($conte,$posant+24,20),4,2)." ";

?> - <a href="vercliente.php?dni=<?php echo (substr($conte,$posant+30,15)+0); ?>">Ver</a>
</td>
<td>
<?php 
if ( substr($conte,$posant+45,3) == "PES" ) {
echo "$"; 
} else {
echo substr($conte,$posant+45,3);
}


?>
</td>
<td>
<?php echo (substr($conte,$posant+48,8)+0); ?>,<?php echo substr($conte,316,2); ?>
</td>
<td>
<?php echo substr($conte,$posant+58,6); ?>
</td>
<td>
<?php echo substr($conte,$posant+70,2); ?>/<?php echo substr($conte,$posant+68,2); ?>/<?php echo substr($conte,$posant+64,4); ?>
</td>
<td>
<?php echo substr($conte,$posant+72,2); ?>:<?php echo substr($conte,$posant+74,2); ?>
</td>
<td>
<?php //echo substr($conte,$posant+76,4); ?>
</td>
<?php //echo substr($conte,$posant+78,48); ?>

<?php /* echo substr($conte,$posant+130,1); ?> */ //Record Code ?>
<td>
<?php //echo (substr($conte,$posant+131,80)); ?>
</td>
<?php //echo substr($conte,$posant+211,46); ?>
<?php /* <td>
<?php echo substr($conte,$posant+260,1); ?>
</td> */ ?>
<td>
<?php //echo substr($conte,$posant+261,3); ?>
</td>
<td>
<?php //echo substr($conte,$posant+264,1); ?>
</td>

</tr>

<?php 

$posant = $posant + 390;
 } 
?>
</table>

<?php /*Record Code:<br />
<?php echo substr($conte,$posant,1); ?><br />
*/ ?>
<span class="nombredato">Fecha:</span><br />
<?php echo substr($conte,$posant+7,2); ?>/<?php echo substr($conte,$posant+5,2); ?>/<?php echo substr($conte,$posant+1,4); ?>
<br />
<span class="nombredato">Número Batch:</span><br />
<?php echo substr($conte,$posant+9,6); ?></span><br />
<span class="nombredato">Cantidad de transacciones del lote:</span><br />
<?php echo substr($conte,$posant+15,7); ?></span><br />
<span class="nombredato">Importe total cobrado del lote:</span><br />
<?php echo (substr($conte,$posant+22,10)+0); ?>,<?php echo substr($conte,$posant+32,2); ?><br />

<?
}
else
{
	
    print "Error al intentar subir el archivo.";
	
}

?>
</body>
</html>