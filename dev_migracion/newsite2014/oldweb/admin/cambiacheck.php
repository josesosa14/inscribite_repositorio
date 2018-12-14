<?php mysql_select_db("inscribite_base", mysql_connect("localhost", "inscribite_user", "iW7zNKpRWkSHHwplBhUO"));

$result1 = mysql_query('SELECT '.$_GET['campo'].' FROM '.$_GET['tabla'].' WHERE id = '.$_GET['id'].' LIMIT 1 ');
$row1 = mysql_fetch_array($result1);

if ($row1[$_GET['campo']] == 1)
  mysql_query('UPDATE '.$_GET['tabla'].' SET '.$_GET['campo'].' = 0 WHERE id = '.$_GET['id']);

if ($row1[$_GET['campo']] == 0)
  mysql_query('UPDATE '.$_GET['tabla'].' SET '.$_GET['campo'].' = 1 WHERE id = '.$_GET['id']);

if (isset($_GET['volvera'])) {
?><script type="text/javascript">
<!--
    location.href = './?sec=<?=str_replace('amp;', '&', $volvera)?>';
-->
</script>
<?
} else {
  if ($row1[$_GET['campo']] == 1)
    echo '<a href="cambiacheck.php?tabla='.$_GET['tabla'].'&amp;campo='.$_GET['campo'].'&amp;id='.$_GET['id'].'&amp;volvera='.$_GET['va'].'" onclick="'."cmbcheck(this.parentNode,'".$_GET['tabla']."', '".$_GET['campo']."',".$_GET['id'].",'".$_GET['va']."');return false;".'" title="Publicado / No Publicado"><img src="images/checkbox.gif" alt="" style="margin-top:0px;"/></a>';
  if ($row1[$_GET['campo']] == 0)
    echo '<a href="cambiacheck.php?tabla='.$_GET['tabla'].'&amp;campo='.$_GET['campo'].'&amp;id='.$_GET['id'].'&amp;volvera='.$_GET['va'].'" onclick="'."cmbcheck(this.parentNode,'".$_GET['tabla']."', '".$_GET['campo']."',".$_GET['id'].",'".$_GET['va']."');return false;".'" title="Publicado / No Publicado"><img src="images/checkboxchecked.gif" alt="" style="margin-top:0px;"/></a>';
}
if (is_resource($result1)) mysql_free_result($result1);
mysql_close()?>