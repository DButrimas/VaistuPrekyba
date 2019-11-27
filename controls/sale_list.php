<?php

// sukuriame klientų klasės objektą
include 'libraries/sales.class.php';
$salesObj = new sales();

// suskaičiuojame bendrą įrašų kiekį
$elementCount = $salesObj->getSalesListCount();

// sukuriame puslapiavimo klasės objektą
include 'utils/paging.class.php';
$paging = new paging(config::NUMBER_OF_ROWS_IN_PAGE);

// suformuojame sąrašo puslapius
$paging->process($elementCount, $pageId);

// išrenkame nurodyto puslapio klientus
$data = $salesObj->getSalestList($paging->size, $paging->first);

// įtraukiame šabloną
include 'templates/sale_list.tpl.php';

?>