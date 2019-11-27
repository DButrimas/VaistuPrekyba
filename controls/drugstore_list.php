<?php

// sukuriame darbuotojų klasės objektą
include 'libraries/drugstores.class.php';
$drugstoresObj = new drugstores();

// suskaičiuojame bendrą įrašų kiekį
$elementCount = $drugstoresObj->getDrugstoresListCount();

// sukuriame puslapiavimo klasės objektą
include 'utils/paging.class.php';
$paging = new paging(config::NUMBER_OF_ROWS_IN_PAGE);

// suformuojame sąrašo puslapius
$paging->process($elementCount, $pageId);

// išrenkame nurodyto puslapio darbuotojus
$data = $drugstoresObj->getDrugstoresList($paging->size, $paging->first);

// įtraukiame šabloną
include 'templates/drugstore_list.tpl.php';

?>