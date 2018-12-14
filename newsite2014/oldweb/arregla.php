<?
mysql_select_db("inscribite_base", mysql_connect("localhost","inscribite_user","iW7zNKpRWkSHHwplBhUO"));

$result1 = mysql_query('SELECT * FROM inscribite_eventos ');
while ($row1 = mysql_fetch_array($result1)) {
  $idActual = $row1['id'];
  //01234567
  //01/06/08
  mysql_query("UPDATE inscribite_eventos SET fechaord = '20".substr($row1['fecha'], 6, 2)."m".substr($row1['fecha'], 3, 2)."d".substr($row1['fecha'], 0, 2)."' WHERE id=$idActual");
}
if (is_resource($result1)) mysql_free_result($result1);
mysql_close();
?>