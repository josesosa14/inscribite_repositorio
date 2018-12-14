<? header('Content-type: text/xml; charset=UTF-8');
ob_start();
$conexio=mysql_connect("localhost","maritimo_beebee","beebee");
mysql_select_db("maritimo_login",$conexio) OR die ("No se puede conectar");
echo '<?xml version="1.0" encoding="utf-8"?>'?>
<rss version="2.0"
	xmlns:content="http://purl.org/rss/1.0/modules/content/"
	xmlns:wfw="http://wellformedweb.org/CommentAPI/"
>
<channel>
	<title><![CDATA[ Inscribite Online ]]></title>
	<link>http://www.inscribiteonline.com.ar/</link>
	<description><![CDATA[ Inscribite Online ]]></description>
	<pubDate><?=date('D')?>, <?=date('d')?> <?=date('M')?> <?=date('Y')?> <?=date("H:i:s")?> -0300</pubDate>
<?
$result=mysql_query('SELECT * FROM inscribite_eventos WHERE ver = 1 ');
while($row=mysql_fetch_array($result)){ ?>
<item>
<guid>http://www.inscribiteonline.com.ar/iniciainscri?evento=<?=str_replace(" ","_",$row['nombre'])?></guid>
<title><?=str_replace("_"," ",$row['nombre'])?></title>
<link>http://www.inscribiteonline.com.ar/</link>
<pubDate><?=$row["pubdate"]?></pubDate>
<content:encoded><![CDATA[
<?
$descrip=strip_tags($row['descripcion']);
$descrip=preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/","\n",$descrip);
$descrip=str_replace("
", '', $descrip);
$descrip = eregi_replace(" +", " ",$descrip);
echo $descrip.chr(13)?> <br />
<a href="http://www.inscribiteonline.com.ar/iniciainscri?evento=<?=str_replace(" ","_",$row['nombre'])?>">Iniciar Inscripción</a>
]]></content:encoded>
</item>
<? } ?>
</channel>
</rss>
<?
if(is_resource($result)) mysql_free_result($result);
if(is_resource($result2)) mysql_free_result($result2);
if(is_resource($result3)) mysql_free_result($result3); ?>