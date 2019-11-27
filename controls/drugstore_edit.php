<?php
	
include 'libraries/drugstores.class.php';
$drugstoresObj = new drugstores();

$formErrors = null;
$data = array();

// nustatome privalomus formos laukus
$required = array('id', 'pavadinimas', 'adresas','telefono_nr','darbo_laikas');

// maksimalūs leidžiami laukų ilgiai
$maxLengths = array (
	'id' => 11,
	'pavadinimas' => 30,
	'adresas' => 45,
        'telefono_nr' => 15,
	'tinklapis' => 25,
        'el_pasto_adresas' => 28,
	'darbo_laikas' => 20,
);

// vartotojas paspaudė išsaugojimo mygtuką
if(!empty($_POST['submit'])) {
	include 'utils/validator.class.php';

	// nustatome laukų validatorių tipus
	$validations = array (
		'id' => 'alfanum',
		'pavadinimas' => 'anything',
		'adresas' => 'anything',
                'telefono_nr' => 'anything',
		'tinklapis' => 'anything',
		'el_pasto_adresas' => 'anything',
                'darbo_laikas' => 'anything');

	// sukuriame laukų validatoriaus objektą
	$validator = new validator($validations, $required, $maxLengths);

	// laukai įvesti be klaidų
	if($validator->validate($_POST)) {
		// suformuojame laukų reikšmių masyvą SQL užklausai
		$dataPrepared = $validator->preparePostFieldsForSQL();

		// redaguojame klientą
		$drugstoresObj->updateDrugstore($dataPrepared);

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
	$data = $drugstoresObj->getDrugstores($id);
}

// nustatome požymį, kad įrašas redaguojamas norint išjungti ID redagavimą šablone
$data['editing'] = 1;

// įtraukiame šabloną
include 'templates/drugstore_form.tpl.php';

?>