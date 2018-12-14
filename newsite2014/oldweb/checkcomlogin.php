<?
if(!(is_resource($conexio)))
    mysql_select_db("inscribite_base",mysql_connect("localhost","inscribite_user","iW7zNKpRWkSHHwplBhUO"));

    if($_GET['dni']=="")$_GET['dni']='ac98';

	$result1=mysql_query('SELECT * FROM inscribite_comercial WHERE dni="'.$_GET['dni'].'" LIMIT 1 ');
	if(mysql_num_rows($result1)>0)
        echo 'document.getElementById(seccionaactualizar).innerHTML='."'".'<label>Contraseña</label><input type="password" name="passw" id="inputpassw" value="" style="width:150px;"/>'."';document.getElementById(".'"'."formdelogin".'"'.").action='';";
    else
        echo 'location.href="registrate"';

  if(is_resource($result1))mysql_free_result($result1);
  if(is_resource($result2))mysql_free_result($result2);
  if(is_resource($result3))mysql_free_result($result3);
  mysql_close();
?>