<?php

include 'libraries/sales.class.php';
$salesObj = new sales();

$formErrors = null;
$fields = array();
$formSubmitted = false;

$data = array();
if(empty($_POST['submit'])) {
	
	// rodome ataskaitos parametrų įvedimo formą
	include 'templates/sale_report_form.tpl.php';
} else {
	$formSubmitted = true;
	
	// nustatome laukų validatorių tipus
	$validations = array (
			'dataNuo' => 'date',
			'dataIki' => 'date');
	
	// sukuriame validatoriaus objektą
	include 'utils/validator.class.php';
	$validator = new validator($validations);
	
	
	if($validator->validate($_POST)) {
		// suformuojame laukų reikšmių masyvą SQL užklausai
		$data = $validator->preparePostFieldsForSQL();
		
		// išrenkame ataskaitos duomenis
		$salesData = $salesObj->getDrugStoreSales($data['dataNuo'], $data['dataIki']);
		$salesStats = $salesObj->getDrugStoreSales2($data['dataNuo'], $data['dataIki']);
		
		// rodome ataskaitą
		include 'templates/sale_report_show.tpl.php';
	} else {
		// gauname klaidų pranešimą
		$formErrors = $validator->getErrorHTML();
		// gauname įvestus laukus
		$fields = $_POST;
		
		// rodome ataskaitos parametrų įvedimo formą su klaidomis ir sustabdome scenarijaus vykdym1
		include 'templates/sale_report_form.tpl.php';
	}
}

