<?php

include 'libraries/drugstores.class.php';
$drugstoresObj = new drugstores();

include 'libraries/chemists.class.php';
$chemistsObj = new chemists();

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

	// sukuriame validatoriaus objektą
	include 'utils/validator.class.php';
	$validator = new validator($validations, $required, $maxLengths);

	// laukai įvesti be klaidų
	if($validator->validate($_POST)) {
		// suformuojame laukų reikšmių masyvą SQL užklausai
		$dataPrepared = $validator->preparePostFieldsForSQL();

		// atnaujiname duomenis
		$chemistsObj->insertChemist($dataPrepared);

		// nukreipiame į modelių puslapį
		header("Location: index.php?module={$module}&action=list");
		die();
	} else {
		// gauname klaidų pranešimą
		$formErrors = $validator->getErrorHTML();
		// gauname įvestus laukus
		$data = $_POST;
	}
} else {
	// tikriname, ar nurodytas elemento id. Jeigu taip, išrenkame elemento duomenis ir jais užpildome formos laukus.
	if(!empty($id)) {
		$data = $chemistsObj->getChemist($id);
	}
}

// įtraukiame šabloną
include 'templates/chemist_form.tpl.php';

?>