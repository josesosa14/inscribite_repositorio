<? include_once 'includes/head.php'?>

    <div class="columnacentral" style="overflow:visible;height:auto;">
      <div class="contenidoseccioncentral">

        <div class="titu"><strong>Ayuda. </strong>Preguntas Frecuentes de Usuarios</div>
<p>
<strong>
<?
$result1=mysql_query('SELECT * FROM '.pftables.'faq ORDER BY numero ');
while ($row1 =mysql_fetch_array($result1)) { ?>
  <a href="#<?=$row1['numero']?>"><?=$row1['pregunta']?></a><br>
<? } ?>
</strong>
</p>
<hr/>

<?
mysql_data_seek($result1,0);
while ($row1 =mysql_fetch_array($result1)) { ?>
<p>
<strong><a name="<?=$row1['numero']?>"></a><?=$row1['pregunta']?></strong><br>
<?=preg_replace("(\r\n|\n|\r)","<br/>",$row1['respuesta'])?>
<? } ?>

			</div>

		</div>

<? include_once 'includes/colder.php'?>