<div class="footer">
<p><a href="<?=url?>">Home</a> &middot; <a href="<?=url?>acerca">Acerca Inscribite on line</a> &middot; <a href="<?=url?>quepagar">Qu&eacute; pagar con  Inscribite on line</a> &middot; <a href="<?=url?>faqs">Preguntas frecuentes</a> &middot; <a href="<?=url?>contacto">Contacto</a>
<br/>
&copy; Copyright 2011 / Inscribite on line es un producto de MARITIMO SRL / 4641-4423 4643-1124 /
<a href="mailto:<?=emaildeconsulta?>"><?=emaildeconsulta?></a>
</p>
</div>
</div>
</body>
</html>
<?
if(is_resource($result1))mysql_free_result($result1);
if(is_resource($result2))mysql_free_result($result2);
if(is_resource($result3))mysql_free_result($result3);
mysql_close();
?>