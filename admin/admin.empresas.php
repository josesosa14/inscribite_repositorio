   <div class="titulosec">Empresas &gt; Admin</div>
    <table>
     <tr>
      <th>Nombre</th>
      <th>Password</th>
      <th>Panel de empresa</th>
      <th>&nbsp;</th>
      <th>&nbsp;</th>
     </tr>
<? $result1 = mysql_query('SELECT * FROM inscribite_empresas ORDER BY nombre ');
while ($row1 = mysql_fetch_array($result1)) { ?>
      <tr>
       <td>
        <a href="?sec=empresas.editar&amp;editando=<?=$row1['id']?>">
         <?=$row1['nombre']?>
        </a>
       </td>
       <td>
        <a href="?sec=empresas.editar&amp;editando=<?=$row1['id']?>">
         <?=$row1['password']?>
        </a>
       </td>
       <td>
        <a href="../empresas/?empresa=<?=$row1['nombre']?>">
          Ver
        </a>
       </td>
       <td>&nbsp;</td>
       <td>
        <a href="javascript:confirm_entry('<?=$row1['nombre']?>', 'empresas.admin', 'inscribite_empresas',<?=$row1['id']?>)"><img src="images/deletex.gif" alt="Eliminar"/></a>
       </td>
      </tr>
<? } ?>
     </table>
