<?php include_once 'includes/header.php';
$result1 = mysql_query('SELECT empresa FROM '.pftables.'eventos WHERE codigo="'.$_GET['evento'].'" LIMIT 1 ');
$row1 = mysql_fetch_array($result1);
$result2 = mysql_query('SELECT * FROM '.pftables.'empresas WHERE nombre="'.$row1['empresa'].'" LIMIT 1 ');
$row2 = mysql_fetch_array($result2);
$result3 = mysql_query('SELECT * FROM '.pftables.'eventos WHERE codigo="'.$_GET['evento'].'" LIMIT 1 ');
$row3 = mysql_fetch_array($result3);
?>
<div class="left" style="width:710px;">
<h1><?=$row3['nombre']?>: <strong>Inscripción cerrada.</strong> </h1>
<p><br/>
  Consultá sobre la disponibilidad de vacantes en <a href="mailto:<?=(strlen(strpos($row2['email'],"@"))>0)?$row2['email']:'consultas@inscribiteonline.com.ar'?>" style="text-decoration:underline;"><?=(strlen(strpos($row2['email'],"@"))>0)?$row2['email']:'consultas@inscribiteonline.com.ar'?></a>
<?php include_once 'includes/footerfull.php'?>
</p>
