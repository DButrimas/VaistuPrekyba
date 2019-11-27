<?php

// sukuriame darbuotojų klasės objektą
include 'libraries/suppliers.class.php';
$suppliersObj = new suppliers();

// suskaičiuojame bendrą įrašų kiekį
$elementCount = $suppliersObj->getSuppliersListCount();

// sukuriame puslapiavimo klasės objektą
include 'utils/paging.class.php';
$paging = new paging(config::NUMBER_OF_ROWS_IN_PAGE);

// suformuojame sąrašo puslapius
$paging->process($elementCount, $pageId);

// išrenkame nurodyto puslapio darbuotojus
$data = $suppliersObj->getSuppliersList($paging->size, $paging->first);

// įtraukiame šabloną
include 'templates/supplier_list.tpl.php';

?>