<?php
require_once dirname(__FILE__) . '/../general/header_empresa.php';

if (!isset($_SESSION['empresa'])) {
    header('Location:'.$general_path.'empresas/index.php');
}

$op_id = addslashes(filter_input(INPUT_POST,'op_id'));
$cupo = addslashes(filter_input(INPUT_POST,'cupo'));
$evento = addslashes(filter_input(INPUT_POST,'evento'));


$query = "UPDATE inscribite_opciones SET cupo = $cupo WHERE id = $op_id";

runQuery($query,$mysqli);
header('Location:'.$general_path.'empresas/evolucionEvento.php?cod_evento='.$evento);
