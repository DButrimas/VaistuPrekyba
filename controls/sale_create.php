<?php
	
include 'libraries/sales.class.php';
$salesObj = new sales();

include 'libraries/drugstores.class.php';
$drugstoresObj = new drugstores();

include 'libraries/chemists.class.php';
$chemistsObj = new chemists();

include 'libraries/drugs.class.php';
$drugsObj = new drugs();

//include 'libraries/services.class.php';
//$servicesObj = new services();

$formErrors = null;
$data = array();

// nustatome privalomus laukus
$required = array('fk_vaistine', 'fk_vaistininkas', 'bendra_suma','data','id');

// maksimalūs leidžiami laukų ilgiai
$maxLengths = array (
	'fk_vaistine' => 11,
	'fk_vaistininkas' => 11,
        'bendra_suma' => 11,
        `id`=>11,
        'data' => 25
);

// paspaustas išsaugojimo mygtukas
if(!empty($_POST['submit'])) {
	// nustatome laukų validatorių tipus
	$validations = array (
		'fk_vaistine' => 'anything',
		'fk_vaistininkas' => 'anything',
		'bendra_suma' => 'anything',
                'id' => 'positivenumber',
		'data' => 'date');

	// sukuriame validatoriaus objektą
	include 'utils/validator.class.php';
	$validator = new validator($validations, $required, $maxLengths);

	// laukai įvesti be klaidų
	if($validator->validate($_POST)) {
		// suformuojame laukų reikšmių masyvą SQL užklausai
		$dataPrepared = $validator->preparePostFieldsForSQL();
		
                $isiminti = $dataPrepared['id'];
		// įrašome naują pasaugą ir gauname jos id
		$dataPrepared['id'] = $salesObj->insertSale($dataPrepared);
		
		// įrašome paslaugų kainas
		$salesObj->insertSaleDetails($dataPrepared,$isiminti);
        //	
        	$data111 = $drugsObj->getDrugsList();
//
		// nukreipiame į modelių puslapį
		header("Location: index.php?module={$module}&action=list");
		die();
	} else {
		// gauname klaidų pranešimą
		$formErrors = $validator->getErrorHTML();
		// gauname įvestus laukus
		$data = $_POST;
		if(isset($_POST['kainos']) && sizeof($_POST['kainos']) > 0) {
			$i = 0;
			foreach($_POST['kainos'] as $key => $val) {
				$data['paslaugos_kainos'][$i]['kaina'] = $val;
				$data['paslaugos_kainos'][$i]['galioja_nuo'] = $_POST['datos'][$key];
				$data['paslaugos_kainos'][$i]['neaktyvus'] = $_POST['neaktyvus'][$key];
				$i++;
			}
		}
	}
}

// įtraukiame šabloną
include 'templates/sale_form.tpl.php';

?>