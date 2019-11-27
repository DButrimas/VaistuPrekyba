<?php

include 'libraries/cars.class.php';
$carsObj = new cars();

include 'libraries/brands.class.php';
$brandsObj = new brands();

include 'libraries/models.class.php';
$modelsObj = new models();

$formErrors = null;
$data = array();

// nustatome privalomus laukus
$required = array('id','telefono_nr','vardas','fk_vaistine');

// maksimalūs leidžiami laukų ilgiai
$maxLengths = array (
    'id'=>11,
	'telefono_nr' => 20,
    'vardas'=>15
);

// paspaustas išsaugojimo mygtukas
if(!empty($_POST['submit'])) {
	// nustatome laukų validatorių tipus
	$validations = array (
                'id'=>'positivenumber',
		'telefono_nr' => 'anything',
                'vardas' => 'anything',
		'fk_vaistine' => 'positivenumber');


	// sukuriame laukų validatoriaus objektą
	include 'utils/validator.class.php';
	$validator = new validator($validations, $required, $maxLengths);

	// laukai įvesti be klaidų
	if($validator->validate($_POST)) {
		// suformuojame laukų reikšmių masyvą SQL užklausai
		$dataPrepared = $validator->preparePostFieldsForSQL();

		// atnaujiname duomenis
		$chemistsObj->updateChemist($dataPrepared);

		// nukreipiame vartotoją į automobilių puslapį
		header("Location: index.php?module={$module}&action=list");
		die();
	} else {
		// gauname klaidų pranešimą
		$formErrors = $validator->getErrorHTML();
		// laukų reikšmių kintamajam priskiriame įvestų laukų reikšmes
		$data = $_POST;
	}
} else {
	// išrenkame elemento duomenis ir jais užpildome formos laukus.
	$data = $chemistsObj->getChemist($id);
}

// įtraukiame šabloną
include 'templates/chemist_form.tpl.php';

?>