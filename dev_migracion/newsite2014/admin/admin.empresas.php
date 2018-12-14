   <div class="titulosec">Empresas &gt; Admin</div>
    <table>
     <tr>
      <th>Nombre</th>
	  <th>User</th>
      <th>Password</th>
      <th>Panel de empresa</th>
      <th>&nbsp;</th>
      <th>&nbsp;</th>
     </tr>
<?php $result1 = mysql_query('SELECT * FROM empresa ORDER BY emp_nombre ');
while ($row1 = mysql_fetch_array($result1)) { ?>
      <tr>
       <td>
        <a href="?sec=empresas.editar&amp;editando=<?=$row1['emp_id']?>">
         <?=$row1['emp_nombre']?>
        </a>
       </td>
       <td>
        <a href="?sec=empresas.editar&amp;editando=<?=$row1['emp_id']?>">
         <?=$row1['emp_usuario']?>
        </a>
       </td>
	   <td>
        <a href="?sec=empresas.editar&amp;editando=<?=$row1['emp_id']?>">
         <?=$row1['emp_password']?>
        </a>
       </td>
       <td>
        <a href="?sec=empresas.editar&amp;editando=<?=$row1['emp_id']?>">
          Ver
        </a>
       </td>
       <td>&nbsp;</td>
       <td>
        <a href="javascript:confirm_entry('<?=$row1['emp_nombre']?>', 'empresas.admin', 'empresa',<?=$row1['emp_id']?>)"><img src="images/deletex.gif" alt="Eliminar"/></a>
       </td>
      </tr>
<?php } ?>
     </table>
