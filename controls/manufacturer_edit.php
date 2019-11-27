<?php
	
include 'libraries/manufacturers.class.php';
$manufacturersObj = new manufacturers();

$formErrors = null;
$data = array();

// nustatome privalomus formos laukus
$required = array('id', 'pavadinimas', 'adresas');

// maksimalūs leidžiami laukų ilgiai
$maxLengths = array (
	'id' => 11,
	'pavadinimas' => 40,
	'adresas' => 45
);

// vartotojas paspaudė išsaugojimo mygtuką
if(!empty($_POST['submit'])) {
	include 'utils/validator.class.php';

	// nustatome laukų validatorių tipus
	$validations = array (
		'id' => 'alfanum',
		'pavadinimas' => 'alfanum',
		'adresas' => 'alfanum');

	// sukuriame laukų validatoriaus objektą
	$validator = new validator($validations, $required, $maxLengths);

	// laukai įvesti be klaidų
	if($validator->validate($_POST)) {
		// suformuojame laukų reikšmių masyvą SQL užklausai
		$dataPrepared = $validator->preparePostFieldsForSQL();

		// redaguojame klientą
		$manufacturersObj->updateManufacturer($dataPrepared);

		// nukreipiame vartotoją į klientų puslapį
		header("Location: index.php?module={$module}&action=list");
		die();
	}
	else {
		// gauname klaidų pranešimą
		$formErrors = $validator->getErrorHTML();

		// laukų reikšmių kintamajam priskiriame įvestų laukų reikšmes
		$data = $_POST;
	}
} else {
	// išrenkame klientą
	$data = $manufacturersObj->getManufacturer($id);
}

// nustatome požymį, kad įrašas redaguojamas norint išjungti ID redagavimą šablone
$data['editing'] = 1;

// įtraukiame šabloną
include 'templates/manufacturer_form.tpl.php';

?>