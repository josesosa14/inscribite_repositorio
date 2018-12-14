<?php include_once 'includes/header.php'?>
  <div class="left">
    <h1>Empresa adheridas</h1>
<?php $result1 = mysql_query('SELECT * FROM '.pftables.'empresas ORDER BY nombre ');
while ($row1 = mysql_fetch_array($result1)) { ?>
         <h2>- <?=$row1['nombre']?></h2>
<?php }
include_once 'includes/footerfull.php'?>