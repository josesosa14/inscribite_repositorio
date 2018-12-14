<? //header("Content-type: text/html; charset=UTF-8"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es" >
<head>
<? //<link rel="SHORTCUT ICON" href="" /> ?>
<title>decoder</title>

<meta name="ROBOTS" content="NOARCHIVE" />

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style type="text/css" >
<!--
.cadaoperacion {
	background-color:#FFFF99;
}
-->
</style>
<script type="text/javascript" >
<!--
	function muestraborrar(nro) {
		nuevoestado = 'visible';
		if ( document.getElementById('borra'+nro).style.visibility == 'visible' )
			nuevoestado = 'hidden';
			
		document.getElementById('borra'+nro).style.visibility = nuevoestado;
	}
	function muestra(nro) {
		nuevoestado = 'block';
		if ( document.getElementById('masinfo'+nro).style.display == 'block' )
			nuevoestado = 'none';
			
		document.getElementById('masinfo'+nro).style.display = nuevoestado;
	}
-->
</script>
</head>
<body>
<?
	$conte = $HTTP_POST_VARS["conte"];
?>
<div>
<? /*Record Code:<br />
<? echo substr($conte,0,1); ?><br /> */ ?>
Fecha:<br />
<? echo substr($conte,7,2); ?>/<? echo substr($conte,5,2); ?>/<? echo substr($conte,1,4); ?>
<br />
Origin Name:<br />
<? echo substr($conte,9,25); ?><br />
Empresa:<br />
<? echo substr($conte,34,9); ?><br />
Empresa:<br />
<? echo substr($conte,43,15); ?><br />
<? //echo substr($conte,78,50); ?><br />

<? /*Record Code:<br />
<? echo substr($conte,130,1); ?><br />
*/ ?>
Fecha:<br />
<? echo substr($conte,137,2); ?>/<? echo substr($conte,135,2); ?>/<? echo substr($conte,131,4); ?>
<br />
Lote:<br />
<? echo substr($conte,139,6); ?><br />
Empresa:<br />
<? echo substr($conte,145,15); ?>
<? //echo substr($conte,180,78); ?>
</div>
<table style="border:1px black solid; margin-top:0px; float:left;">
<tr>
<? /*<td>
Record Code:
</td> */ ?>
<td>
Secuencia:
</td>
<td>
Código de Transacción:
</td>
<td>
Fecha de proceso:
</td>
<td>
Fecha de creación:
</td>
<td>
Id del cliente:
</td>
<td>
Moneda:
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
Número de secuencia en terminal:
</td>
<td>
Código de barras:
</td>
<td>
Moneda:
</td>
<td>
Efectivo o Cheque
</td>
</tr>
<? 
$posant = 260;
while ( substr($conte,$posant,1) == 5 ) {
?>
<tr class="cadaoperacion">
<? /*<td>
<? echo substr($conte,$posant,1); ?>
</td> */ ?>
<td>
<? echo substr($conte,$posant+1,5); ?>
</td>
<td>
<? echo substr($conte,$posant+6,2); ?>
</td>
<td>
<? echo substr($conte,$posant+14,2); ?>/<? echo substr($conte,$posant+12,2); ?>/<? echo substr($conte,$posant+8,4); ?>
</td>
<td>
<? echo substr($conte,$posant+22,2); ?>/<? echo substr($conte,$posant+20,2); ?>/<? echo substr($conte,$posant+16,4); ?>
</td>
<td>
<? echo substr($conte,$posant+24,20); ?> <a href="vercliente.php?dni=<? echo (substr($conte,$posant+30,15)+0); ?>">Ver</a>
</td>
<td>
<? echo substr($conte,$posant+45,3); ?>
</td>
<td>
<? echo (substr($conte,$posant+48,8)+0); ?>,<? echo substr($conte,316,2); ?>
</td>
<td>
<? echo substr($conte,$posant+58,6); ?>
</td>
<td>
<? echo substr($conte,$posant+70,2); ?>/<? echo substr($conte,$posant+68,2); ?>/<? echo substr($conte,$posant+64,4); ?>
</td>
<td>
<? echo substr($conte,$posant+72,2); ?>:<? echo substr($conte,$posant+74,2); ?>
</td>
<td>
<? echo substr($conte,$posant+76,4); ?>
</td>
<? //echo substr($conte,$posant+78,48); ?>

<? /* echo substr($conte,$posant+130,1); ?> */ //Record Code ?>
<td>
<? echo (substr($conte,$posant+131,80)); ?>
</td>
<? //echo substr($conte,$posant+211,46); ?>
<? /* <td>
<? echo substr($conte,$posant+260,1); ?>
</td> */ ?>
<td>
<? echo substr($conte,$posant+261,3); ?>
</td>
<td>
<? echo substr($conte,$posant+264,1); ?>
</td>

</tr>

<? 
$posant = $posant + 390;
 } 
?>
</table>

<? /*Record Code:<br />
<? echo substr($conte,$posant,1); ?><br />
*/ ?>
Fecha:<br />
<? echo substr($conte,$posant+7,2); ?>/<? echo substr($conte,$posant+5,2); ?>/<? echo substr($conte,$posant+1,4); ?>
<br />
Número Batch:<br />
<? echo substr($conte,$posant+9,6); ?><br />
Cantidad de transacciones del lote:<br />
<? echo substr($conte,$posant+15,7); ?><br />
Importe total cobrado del lote:<br />
<? echo (substr($conte,$posant+22,10)+0); ?>,<? echo substr($conte,$posant+32,2); ?><br />


</body>
</html>
