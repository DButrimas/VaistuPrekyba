<?php

include 'libraries/orders.class.php';
$ordersObj = new orders();
include 'libraries/drugstores.class.php';
$drugstoresObj = new drugstores();

$formErrors = null;
$fields = array();
$formSubmitted = false;

$data = array();
if(empty($_POST['submit'])) {
	
	// rodome ataskaitos parametrų įvedimo formą
	include 'templates/order_report_form.tpl.php';
} else {
	$formSubmitted = true;
	
	// nustatome laukų validatorių tipus
	$validations = array (
			'dataNuo' => 'date',
			'dataIki' => 'date',
            'pasirinkimas'=>'positivenumber');
	
	// sukuriame validatoriaus objektą
	include 'utils/validator.class.php';
	$validator = new validator($validations);
	
	
	if($validator->validate($_POST)) {
		// suformuojame laukų reikšmių masyvą SQL užklausai
		$data = $validator->preparePostFieldsForSQL();
		
		// išrenkame ataskaitos duomenis
		$ordersData = $ordersObj->getOrderes($data['dataNuo'], $data['dataIki'],$data['pasirinkimas']);
		$ordersStats = $ordersObj->getOrderes2($data['dataNuo'], $data['dataIki'],$data['pasirinkimas']);
		
		// rodome ataskaitą
		include 'templates/order_report_show.tpl.php';
	} else {
		// gauname klaidų pranešimą
		$formErrors = $validator->getErrorHTML();
		// gauname įvestus laukus
		$fields = $_POST;
		
		// rodome ataskaitos parametrų įvedimo formą su klaidomis ir sustabdome scenarijaus vykdym1
		include 'templates/order_report_form.tpl.php';
	}
}

