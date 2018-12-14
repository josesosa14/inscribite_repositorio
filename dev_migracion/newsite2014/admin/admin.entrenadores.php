	        Entrenadores &gt; Admin
      <table>
        <tr>
          <th>Nombre</th>
          <th>&nbsp;</th>
          <th>&nbsp;</th>
        </tr>
<?		$result1 = mysql_query('SELECT * FROM inscribite_entrenadores ');
		while ($row1 = mysql_fetch_array($result1)) { ?>
        <tr>
          <td>
            <a href="?sec=entrenadores.editar&amp;editando=<?=$row1['id']?>">
              <span style="color:#777;font-weight:normal;"><?=$row1['codigo']?></span> <?=$row1['nombre']?>
            </a>
          </td>
          <td>
              <a href="javascript:confirm_entry('<?=$row1['nombre']?>', 'entrenadores.admin', 'inscribite_entrenadores',<?=$row1['id']?>)"><img src="images/deletex.gif" alt="Eliminar"/></a>
          </td>
        </tr>
<?		} ?>
      </table>
