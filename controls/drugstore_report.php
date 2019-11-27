<?php

include 'libraries/drugstores.class.php';
$drugstoresObj = new drugstores();

$formErrors = null;
$fields = array();
$formSubmitted = false;

$data = array();
if(empty($_POST['submit'])) {
	
	// rodome ataskaitos parametrų įvedimo formą
	include 'templates/drugstore_report_form.tpl.php';
} else {
	$formSubmitted = true;
	
	// nustatome laukų validatorių tipus
	$validations = array (
			'pasirininkimas' => 'positivenumber');
	
	// sukuriame validatoriaus objektą
	include 'utils/validator.class.php';
	$validator = new validator($validations);
	
	
	if($validator->validate($_POST)) {
		// suformuojame laukų reikšmių masyvą SQL užklausai
		$data = $validator->preparePostFieldsForSQL();
		
		// išrenkame ataskaitos duomenis
		$drugstoresData = $drugstoresObj->getDrugstoreReport($data['pasirinkimas']);
		//$salesStats = $salesObj->getDrugStoreSales2($data['dataNuo'], $data['dataIki']);
		
		// rodome ataskaitą
		include 'templates/drugstore_report_show.tpl.php';
	} else {
		// gauname klaidų pranešimą
		$formErrors = $validator->getErrorHTML();
		// gauname įvestus laukus
		$fields = $_POST;
		
		// rodome ataskaitos parametrų įvedimo formą su klaidomis ir sustabdome scenarijaus vykdym1
		include 'templates/drugstore_report_form.tpl.php';
	}
}

