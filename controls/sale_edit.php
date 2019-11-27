<?php

include 'libraries/sales.class.php';
$salesObj = new sales();

include 'libraries/drugstores.class.php';
$drugstoresObj = new drugstores();

include 'libraries/chemists.class.php';
$chemistsObj = new chemists();

include 'libraries/drugs.class.php';
$drugsObj = new drugs();

$formErrors = null;
$data = array();

// nustatome privalomus laukus
$required = array();

// maksimalūs leidžiami laukų ilgiai
$maxLengths = array (
	'bendra_suma' => 20,
	'id' => 11,
        'data' => 20
    
);

// vartotojas paspaudė išsaugojimo mygtuką
if(!empty($_POST['submit'])) {
	include 'utils/validator.class.php';

	// nustatome laukų validatorių tipus
	$validations = array (
		'fk_vaistine' => 'anything',
		'fk_vaistininkas' => 'anything',
		'bendra_suma' => 'anything',
		'data' => 'anything',
		'vaistai' => 'anything',
		'id' => 'anything',
		'detales_id' => 'anything',
		'kiekis' => 'anything',
		'vieneto_kaina' => 'anything');

	// sukuriame laukų validatoriaus objektą
	$validator = new validator($validations, $required);

	// laukai įvesti be klaidų
	if($validator->validate($_POST)) {
		// suformuojame laukų reikšmių masyvą SQL užklausai
		$dataPrepared = $validator->preparePostFieldsForSQL();
                
                
               // $isiminti = $dataPrepared['id'];
		// atnaujiname sutartį
		$salesObj->updateSale($dataPrepared);

		// atnaujiname užsakytas paslaugas
		$salesObj->updateSaleDetails($dataPrepared);

		// nukreipiame vartotoją į sutarčių puslapį
		if($formErrors == null) {
			header("Location: index.php?module={$module}&action=list");
			die();
		}
	} else {
		// gauname klaidų pranešimą
		$formErrors = $validator->getErrorHTML();

		// laukų reikšmių kintamajam priskiriame įvestų laukų reikšmes
		$data = $_POST;
		if(isset($_POST['kiekiai']) && sizeof($_POST['kiekiai']) > 0) {
			$i = 0;
			foreach($_POST['kiekiai'] as $key => $val) {
				$data['uzsakytos_paslaugos'][$i]['kiekis'] = $val;
				$i++;
			}
		}
	}
} else {
	if(!empty($id)) {
		$data = $salesObj->getSale($id);
		$tmp = $salesObj->getSaleDetails($id);
		if(sizeof($tmp) > 0) {
			foreach($tmp as $key => $val) {
				// jeigu paslaugos kaina yra naudojama, jos koreguoti neleidziame ir įvedimo laukelį padarome neaktyvų
				
				$data['pardavimu_detales'][] = $val;
			}
		}
	}
}

// nustatome požymį, kad įrašas redaguojamas norint išjungti ID redagavimą šablone
$data['editing'] = 1;

// įtraukiame šabloną
include 'templates/sale_form.tpl.php';

?>