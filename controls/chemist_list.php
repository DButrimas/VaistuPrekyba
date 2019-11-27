<?php

// sukuriame modelių klasės objektą
include 'libraries/chemists.class.php';
$chemistsObj = new chemists();

// suskaičiuojame bendrą įrašų kiekį
$elementCount = $chemistsObj->getChemistListCount();

// sukuriame puslapiavimo klasės objektą
include 'utils/paging.class.php';
$paging = new paging(config::NUMBER_OF_ROWS_IN_PAGE);

// suformuojame sąrašo puslapius
$paging->process($elementCount, $pageId);

// išrenkame nurodyto puslapio modelius
$data = $chemistsObj->getChemistList($paging->size, $paging->first);

// įtraukiame šabloną
include 'templates/chemist_list.tpl.php';
	
?>