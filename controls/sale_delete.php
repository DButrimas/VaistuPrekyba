<?php

include 'libraries/sales.class.php';
$salesObj = new sales();

if(!empty($id)) {
	// patikriname, ar šalinama paslauga nenaudojama jokioje sutartyje
	//$contractCount = $servicesObj->getContractCountOfService($id);

	$removeErrorParameter = '';
	//if($contractCount == 0) {
		// pašaliname paslaugos kainas
		$salesObj->deleteSaleDatails($id);

		// pašaliname paslaugą
		$salesObj->deleteSale($id);
	//} else {
		// nepašalinome, nes modelis priskirtas bent vienam automobiliui, rodome klaidos pranešimą
	//	$removeErrorParameter = '&remove_error=1';
	//}

	// nukreipiame į paslaugų puslapį
	header("Location: index.php?module={$module}&action=list{$removeErrorParameter}");
	die();
}
	
?>