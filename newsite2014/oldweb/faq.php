<? include 'includes/head.php'?>

    <div class="columnacentral" style="overflow:visible;height:auto;">
      <div class="contenidoseccioncentral">

        <div class="titu"><strong>Ayuda. </strong>Preguntas Frecuentes de Usuarios</div>
<p>
<strong>
<?
$result1=mysql_query('SELECT * FROM inscribite_faq ORDER BY numero ');
while($row=mysql_fetch_array($result1)){ ?>
  <a href="#<?=$row['numero']?>"><?=$row['pregunta']?></a><br>
<? } ?>
</strong>
</p>
<hr/>

<?
mysql_data_seek($result1,0);
while($row=mysql_fetch_array($result1)){ ?>
<p>
<strong><a name="<?=$row['numero']?>"></a><?=$row['pregunta']?></strong><br>
<?=preg_replace("(\r\n|\n|\r)","<br/>",$row['respuesta'])?>
<? } ?>

			</div>

		</div>

<? include 'includes/colder.php'?>