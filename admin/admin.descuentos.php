   <div class="titulosec">Descuentos &gt; Admin</div>
    <table>
     <tr>
      <th style="text-align:left;">Código</th>
      <th style="text-align:left;">Evento</th>
      <th style="text-align:left;">DNI</th>
      <th style="text-align:left;">Email</th>
      <th style="text-align:left;">Porcentaje</th>
      <th>&nbsp;</th>
      <th>&nbsp;</th>
     </tr>
<?
$result1 = mysql_query('SELECT * FROM inscribite_descuentos ');
while ($row1 = mysql_fetch_array($result1)) {
?>
      <tr>
       <td>
        <a href="?sec=descuentos.editar&amp;editando=<?=$row1['id']?>">
         <?=agceros($row1['codevento'],4).agceros($row1['coddni'],8).agceros($row1['porcentajedescuento'],3);?>
        </a>
       </td>
       <td>
        <a href="?sec=descuentos.editar&amp;editando=<?=$row1['id']?>">
         <?=agceros($row1['codevento'],4)?>
        </a>
       </td>
       <td>
        <a href="?sec=descuentos.editar&amp;editando=<?=$row1['id']?>">
         <?=agceros($row1['coddni'],8)?>
        </a>
       </td>
       <td>
        <a href="?sec=descuentos.editar&amp;editando=<?=$row1['id']?>">
         <?
$result2 = mysql_query('SELECT email FROM inscribite_usuarios WHERE dni = '.agceros($row1['coddni'],8).' ');
$row2 = mysql_fetch_array($result2);
         echo $row2['email'].'<a href="'.$row2['email'].'" title="mailto:'.$row2['email'].'"><img src="images/miniemail.gif" alt="" style="margin-left:5px;"></a>';
?>
        </a>
       </td>
       <td>
        <a href="?sec=descuentos.editar&amp;editando=<?=$row1['id']?>">
         <?=$row1['porcentajedescuento']?>%
        </a>
       </td>
       <td>&nbsp;</td>
       <td>
        <a href="javascript:confirm_entry('<?=agceros($row1['codevento'],4).agceros($row1['coddni'],8).agceros($row1['porcentajedescuento'],3);?>', 'descuentos.admin', 'inscribite_descuentos',<?=$row1['id']?>)"><img src="images/deletex.gif" alt="Eliminar"/></a>
       </td>
      </tr>
<? } ?>
     </table>
