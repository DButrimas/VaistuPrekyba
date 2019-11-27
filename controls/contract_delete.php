<?php

include 'libraries/contracts.class.php';
$contractsObj = new contracts();

if(!empty($id)) {
	// pašaliname užsakytas paslaugas
	$contractsObj->deleteOrderedServices($id);

	// šaliname sutartį
	$contractsObj->deleteContract($id);

	// nukreipiame į sutarčių puslapį
	header("Location: index.php?module={$module}&action=list");
	die();
}

?>