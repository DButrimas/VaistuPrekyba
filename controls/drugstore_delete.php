<?php

include 'libraries/drugstores.class.php';
$drugstoresObj = new drugstores();


if(!empty($id)) {
	// patikriname, ar darbuotojas neturi sudarytų sutarčių
	$count = $drugstoresObj->getDrugstoresCountOforders($id);
        $count2 = $drugstoresObj->getDrugstoresCountOfSales($id);
        $count3 = $drugstoresObj->getDrugstoresCountOfPayments($id);
        $count4 = $drugstoresObj->getDrugstoresCountOfShipments($id);
        
        

	$removeErrorParameter = '';
	if($count == 0 && $count2 == 0 && $count3 == 0 && $count4 == 0) {
		// šaliname darbuotoją
                $drugstoresObj->deleteChemists($id);
		$drugstoresObj->deleteDrugstore($id);
                
	} else {
		// nepašalinome, nes darbuotojas sudaręs bent vieną sutartį, rodome klaidos pranešimą
		$removeErrorParameter = '&remove_error=1';
	}

	// nukreipiame į darbuotojų puslapį
	header("Location: index.php?module={$module}&action=list{$removeErrorParameter}");
	die();
}

?>