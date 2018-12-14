<?php
require_once dirname(__FILE__) . '/../general/header_empresa.php';
echo '</div>';

$query = "DELETE FROM inscribite_descuentos WHERE fechausado is not null AND fechausado <> '' AND codevento in (SELECT codigo FROM inscribite_eventos WHERE tipo = 'Deportivos' or tipo = 'CapacitaciÃ³n')";
runQuery($query,$mysqli);

echo '<h3>Descuentos Borrados</h3>';