<?php

require_once dirname(__FILE__) . '/../general/barcode/class/BCGFontFile.php';
require_once dirname(__FILE__) . '/../general/barcode/class/BCGColor.php';
require_once dirname(__FILE__) . '/../general/barcode/class/BCGDrawing.php';
require_once dirname(__FILE__) . '/../general/barcode/class/BCGcode128.barcode.php';

/* * ****************Bar Code Generator************** */

// The arguments are R, G, and B for color.
$colorFront = new BCGColor(0, 0, 0);
$colorBack = new BCGColor(255, 255, 255);

//font
//$font = new BCGFontFile($general_path.'general/barcode/font/Arial.ttf', 18);

$code = new BCGcode128(); // Or another class name from the manual
$code->setScale(1); // Resolution
$code->setThickness(30); // Thickness
$code->setForegroundColor($colorFont); // Color of bars
$code->setBackgroundColor($colorBack); // Color of spaces
$code->setFont(2); // Font (or 0)
/* * ************************************************ */



//vamos a pintar el código
$code->parse($d_cod_barra); // Text
$drawing = new BCGDrawing('', $colorBack);
$drawing->setBarcode($code);
$drawing->draw();

//header magic
//header('Content-Type: image/png');
//FINISHIIING
$drawing->finish(BCGDrawing::IMG_FORMAT_PNG);
