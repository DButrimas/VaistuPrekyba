<?php

include 'libraries/manufacturers.class.php';
$manufacturersObj = new manufacturers();

if(!empty($id)) {
	// patikriname, ar darbuotojas neturi sudarytų sutarčių
	$count = $manufacturersObj->getDrugsCountOfManufacturers($id);

	$removeErrorParameter = '';
	if($count == 0) {
		// šaliname darbuotoją
		$manufacturersObj->deleteManufacturer($id);
	} else {
		// nepašalinome, nes darbuotojas sudaręs bent vieną sutartį, rodome klaidos pranešimą
		$removeErrorParameter = '&remove_error=1';
	}

	// nukreipiame į darbuotojų puslapį
	header("Location: index.php?module={$module}&action=list{$removeErrorParameter}");
	die();
}

?>