<?php

include 'libraries/chemists.class.php';
$chemistsObj = new chemists();

if(!empty($id)) {
	// patikriname, ar šalinamas modelis nenaudojamas, t.y. nepriskirtas jokiam automobiliui
	
		// pašaliname modelį
		$chemistsObj->deleteChemist($id);
	

	// nukreipiame į modelių puslapį
	header("Location: index.php?module={$module}&action=list{$removeErrorParameter}");
	die();
}

?>