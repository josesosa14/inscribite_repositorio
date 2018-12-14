<?	$fullurl = $_SERVER['REQUEST_URI'];
	$aruri1 = explode('/', $fullurl);
	$perfilenurl = end($aruri1);
	if (strpos($perfilenurl, '?') > -1) {
		$ar_separagets = explode('?', $perfilenurl); $perfilenurl = $ar_separagets[0];
	}
