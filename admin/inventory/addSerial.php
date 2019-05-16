<?php

/* * *********************************************** */
$ThisPageName = 'generateInvoice.php';
/* * *********************************************** */
$HideNavigation = 1;
include_once("../includes/header.php");
require_once($Prefix."classes/sales.quote.order.class.php");
$objSale = new sale();
 
if(!empty($_GET['Sku'])){
    $arrySerialNumber = $objSale->selectSerialNumberForItem($_GET['Sku']);
}
 

require_once("../includes/footer.php");
?>
