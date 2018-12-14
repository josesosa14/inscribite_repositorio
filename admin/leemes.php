<? header("Content-type: text/html; charset=UTF-8");

include_once "../inc.config.php";

$nombremes = array("", "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
$anioactual = $_GET['anio'];
$mesactual = $_GET['mes'];
if ($mesactual == 13){
  $mesactual = 1;
  $anioactual++;
}
if ($mesactual == 0){
  $mesactual = 12;
  $anioactual--;
}
$primdiames = date("w", mktime(0, 0, 0, $mesactual, 1, $anioactual));
$ultdiames  = date("t", mktime(0, 0, 0, $mesactual, 1, $anioactual))+$primdiames;
$result1 = mysql_query('SELECT * FROM inscribite_categorias WHERE id = '.$_GET['id'].'" LIMIT 1 ');
$row1 = mysql_fetch_array($result1);
?><div style="height:24px;"><span class="mespaatras"><a class="flechitasmes" href="#" onclick="leemes('<?=$_GET['nobjeto']."', '".$_GET['id']."', '".$_GET['campo']."',".($mesactual-1)?>,<?=$anioactual?>);return false;">&laquo;</a></span><span class="nombremesencal"><?=$nombremes[$mesactual].' '.substr('0'.($anioactual-2000),-2,2)?></span><span class="mespaadelante"><a class="flechitasmes" href="#" onclick="leemes('<?=$_GET['nobjeto']."', '".$_GET['id']."', '".$_GET['campo']."',".($mesactual+1)?>,<?=$anioactual?>);return false;">&raquo;</a></span></div><div onmouseup="empiezaarras = false"><div class="lineacal" style="letter-spacing:17px;text-indent:8px;">DLMMJVS</div><div class="lineacal"><?
for ($ndia = 1; $ndia <= $ultdiames; $ndia++){
 $fdia = $ndia-$primdiames;
 $colordfd = '';
 if ($row1[$_GET['campo']] == $anioactual.substr('0'.$mesactual,-2,2).substr('0'.$fdia,-2,2))
  $colordfd = ' style="background-color:#C9DAEE;"';
 if ($fdia<1)
  echo '<span></span>';
 else
  echo '<a onmousedown="tocacal('.str_replace('calendario', '', $_GET['nobjeto']).', '."'".$_GET['campo']."'".',this,'.$fdia.', '.$mesactual.', '.$anioactual.');empiezaarras = true" onmouseover="if (empiezaarras) tocacal(this,'.$fdia.', '.$mesactual.', '.$anioactual.')"'.$colordfd.'>'.$fdia.'</a>';
 if ($ndia%7 == 0)echo '</div><div class="lineacal">';
} ?></div></div><?
if (is_resource($result1))mysql_free_result($result1);
if (is_resource($result2))mysql_free_result($result2);
if (is_resource($result3))mysql_free_result($result3);
mysql_close()?>