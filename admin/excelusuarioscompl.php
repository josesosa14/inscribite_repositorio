<?php
include_once "../inc.config.php";

header("Content-type: application/vnd.ms-excel; charset=ISO-8859-1");
header("Content-Disposition: attachment; filename=usuarioscompleto-".date('j-n-y').".xls");

if (1 == 1) { ?>
<table><tr><th>Nro</th><th>Nombre</th><th>Apellido</th><th>DNI</th><th>Nac.</th><th>Sexo</th><th>Mail</th><th>Puntos</th><th>Pass</th><th>Tel. Part.</th><th>Tel. Lab.</th><th>Tel. Cel.</th><th>Domicilio</th><th>Pcia</th><th>Pa&iacute;s</th></tr><?
  $result1 = mysql_query('SELECT * FROM inscribite_usuarios ORDER BY apellido, nombre ');
  while($row1 = mysql_fetch_array($result1)){ ?>
<tr>
<td><?=$row1['id']?></td>
<td><?=$row1['nombre']?></td>
<td><?=$row1['apellido']?></td>
<td><a href="./?sec=usuarios.editar&amp;editando=<?=$row1['id']?>" class="dni"><?=$row1['dni']?></a></td>
<td><?=substr($row1['fechanac'],6,2)."/".substr($row1['fechanac'],4,2)."/".substr($row1['fechanac'],0,4)?></td>
<td><?=substr(ucfirst($row1['sexo']),0,1)?></td>
<td><?=strtolower($row1['email'])?></td>
<td><?=$row1['puntos']?></td>
<td><?=$row1['password']?></td>
<td><?=$row1['telefonoparticular']?></td>
<td><?=$row1['telefonolaboral']?></td>
<td><?=$row1['telefonocelular']?></td>
<td><?=$row1['domicilio']?></td>
<td><?=ucfirst(strtolower($row1['provincia']))?></td>
<td><?=ucfirst(strtolower(substr($row1['pais'],0,2)))?></td>
<?
    $antedni = $row1['dni'];
}
?></tr></table><?
mysql_free_result($result1);
mysql_close();
} else { ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es" >
<head>
  <title>Inscribite Online - Administración</title>
  <meta name="ROBOTS" content="NOARCHIVE"/>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <style type="text/css">
  <!--
  body{
    font-family:      Arial, Helvetica, sans-serif;
    font-size:12px;
  }
  .submit{
    border:           1px #555 solid;
    width:            100px;
    background-color: white;
    font-size:        12px;
    margin-left:      auto;
    margin-right:     auto;
    display:          block;
    margin-top:       20px;
  }
    -->
    </style>
  </head>
  <body>
    <div style="width:200px;margin-left:auto;margin-right:auto;margin-top:100px;">
      <form action="./" method="post">
        <div>
          Nombre de usuario<br/>
          <input type="text" name="admin_username" style="width:150px;"/><br/>
          Contraseña<br/>
          <input type="password" name="admin_password" style="width:150px;"/><br/>
          <input type="submit" value="Entrar" class="submit"/>
        </div>
      </form>
    </div>
  </body>
</html>
<? } ?>