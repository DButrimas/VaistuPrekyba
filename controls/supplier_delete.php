<?php

include 'libraries/suppliers.class.php';
$suppliersObj = new suppliers();

if(!empty($id)) {
	// patikriname, ar darbuotojas neturi sudarytų sutarčių
	$count = $suppliersObj->getSuppliersCountOfShipments($id);
        $count2 = $suppliersObj->getSuppliersCountOfOrders($id);

	$removeErrorParameter = '';
	if($count == 0 && $count2 == 0) {
		// šaliname darbuotoją
		$suppliersObj->deleteSupplier($id);
	} else {
		// nepašalinome, nes darbuotojas sudaręs bent vieną sutartį, rodome klaidos pranešimą
		$removeErrorParameter = '&remove_error=1';
	}

	// nukreipiame į darbuotojų puslapį
	header("Location: index.php?module={$module}&action=list{$removeErrorParameter}");
	die();
}

?>