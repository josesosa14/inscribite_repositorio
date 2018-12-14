<?
header ("Cache-Control: no-cache, must-revalidate");  // HTTP/1.1
header ("Pragma: no-cache");                          // HTTP/1.0

$conexio = mysql_connect("localhost", "maritimo_beebee", "beebee");
mysql_select_db ("maritimo_login", $conexio) OR die ("No se puede conectar");

if ( $HTTP_GET_VARS["stat"] == 'true' ) {
	mysql_query ("UPDATE inscribite_usuarios SET confirmado0 = 1 WHERE id = '".$HTTP_GET_VARS["id"]."' ");
}
if ( $HTTP_GET_VARS["stat"] == 'false' ) {
	mysql_query ("UPDATE inscribite_usuarios SET confirmado0 = 0 WHERE id = '".$HTTP_GET_VARS["id"]."' ");
}
//include("agenda.php");

	mysql_free_result($result);
	mysql_close();
?>