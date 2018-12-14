<?php include 'includes/head.php'?>
		<div class="columnacentral" style="overflow:visible;">
			<div class="contenidoseccioncentral">
<?
$result1=mysql_query('SELECT empresa FROM inscribite_eventos WHERE codigo="'.$_GET['evento'].'" LIMIT 1 ');
$row=mysql_fetch_array($result1);
$result2=mysql_query('SELECT * FROM inscribite_empresas WHERE nombre="'.$row['empresa'].'" LIMIT 1 ');
$row2=mysql_fetch_array($result2);
$result3=mysql_query('SELECT * FROM inscribite_eventos WHERE codigo="'.$_GET['evento'].'" LIMIT 1 ');
$row3=mysql_fetch_array($result3);
?>
				<?=$row3['nombre']?>:<br/><br/>
				<strong>Inscripción cerrada.</strong> Consultá sobre la disponibilidad de vacantes en <a href="mailto:<?=(strlen(strpos($row2['email'],"@"))>0)?$row2['email']:'info@maritimopro.com.ar'?>" style="text-decoration:underline;"><?=(strlen(strpos($row2['email'],"@"))>0)?$row2['email']:'info@maritimopro.com.ar'?></a>

			</div>
		</div>
<?php include 'includes/colder.php'?>