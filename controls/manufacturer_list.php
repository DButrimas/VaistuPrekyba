<?php

// sukuriame darbuotojų klasės objektą
include 'libraries/manufacturers.class.php';
$manufacturersObj = new manufacturers();

// suskaičiuojame bendrą įrašų kiekį
$elementCount = $manufacturersObj->getManufacturersListCount();

// sukuriame puslapiavimo klasės objektą
include 'utils/paging.class.php';
$paging = new paging(config::NUMBER_OF_ROWS_IN_PAGE);

// suformuojame sąrašo puslapius
$paging->process($elementCount, $pageId);

// išrenkame nurodyto puslapio darbuotojus
$data = $manufacturersObj->getManufacturersList($paging->size, $paging->first);

// įtraukiame šabloną
include 'templates/manufacturer_list.tpl.php';

?>