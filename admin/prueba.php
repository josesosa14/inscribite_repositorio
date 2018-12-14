<?php
function agceros($nombreag, $cantceros) {
	while (strlen($nombreag) < $cantceros) $nombreag = "0".$nombreag;
	return $nombreag;
}
  $fechvencenjul = '09237';
  $dejulianaagreg = JDToGregorian(gregoriantojd(1, 1, (2000+substr($fechvencenjul, 0 , 2)*1))+substr($fechvencenjul, 2, 3)-1);
  // formato 8/25/2009
  $arrayfechgreg = Array();
  $arrayfechgreg = split('/', $dejulianaagreg);
  echo $arrayfechgreg[2].agceros($arrayfechgreg[0], 2).agceros($arrayfechgreg[1], 2)

?>