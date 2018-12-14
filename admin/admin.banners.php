   <div>
    <div class="titulosec">Banners &gt; Admin
    </div>
    <table>
     <tr>
      <th style="text-align:left;">Nombre</th>
      <th style="text-align:left;">Publicado</th>
      <th style="text-align:left;">Link</th>
      <th style="text-align:left;">Evento</th>
      <th style="text-align:left;">Formato</th>
      <th>&nbsp;</th>
     </tr>
<? $result1 = mysql_query('SELECT * FROM inscribite_banners ');
  while ($row1 = mysql_fetch_array($result1)) { ?>
     <tr>
      <td>
       <a href="?sec=banners.editar&amp;editando=<?=$row1['id']?>">
        <?=$row1['nombre']?>
       </a>
      </td>
      <td>
        <a href="cambiacheck.php?tabla=inscribite_banners&amp;campo=ver&amp;id=<?=$row1['id']?>&amp;volvera=banners.admin" onclick="cmbcheck(this.parentNode,'inscribite_banners', 'ver',<?=$row1['id']?>,'<?=$_GET['sec']?>');return false" title="Cambiar">
          <img src="images/<?=($row1['ver'] == 1)?'checkboxchecked.gif':'checkbox.gif'?>" alt="" style="margin-top:0px;"/>
        </a>
      </td>
      <td>
       <a href="?sec=banners.editar&amp;editando=<?=$row1['id']?>">
        <?=str_replace('&amp;amp;', '&amp;', str_replace('&', '&amp;', $row1['link']))?>
       </a>
      </td>
      <td>
       <a href="?sec=banners.editar&amp;editando=<?=$row1['id']?>">
        <?
          $result2 = mysql_query('SELECT * FROM inscribite_eventos WHERE id = '.$row1['evento']);
          $row2 = mysql_fetch_array($result2);
          echo $row2['nombre']?>
       </a>
      </td>
      <td>
       <a href="?sec=banners.editar&amp;editando=<?=$row1['id']?>">
        <?
          if ($row1['width1'] == 160) echo '160px x 60px';
          if ($row1['width1'] == 544) echo '544px x 60px';
        ?>
       </a>
      </td>
      <td>
       <a href="javascript:confirm_entry('<?=$row1['nombre']?>', 'banners.admin', 'inscribite_banners',<?=$row1['id']?>)"><img src="images/deletex.gif" alt="Eliminar"/></a>
      </td>
     </tr>
<?		} ?>
    </table>
   </div>
