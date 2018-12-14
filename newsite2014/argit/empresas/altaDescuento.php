<?php
require_once dirname(__FILE__) . '/../general/header_empresa.php';

$parameters = parseParameters($_POST);

$parameters['fechausado'] = "";

insertRow('inscribite_descuentos', $parameters, $mysqli);

echo 1;