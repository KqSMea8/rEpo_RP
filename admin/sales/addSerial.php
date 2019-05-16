<?php

/* * *********************************************** */
#$ThisPageName = 'generateInvoice.php';
/* * *********************************************** */
$HideNavigation = 1;
include_once("../includes/header.php");
require_once($Prefix."classes/sales.quote.order.class.php");
$objSale = new sale();
 
if(!empty($_GET['sku'])){
    $SelSerialNumber = $_GET['SerialValue'];//print_r($_GET);
    $arrySerialNumber = $objSale->selectSerialNumberForItem($_GET['sku']);//print_r($arrySerialNumber);
}
 

require_once("../includes/footer.php");
?>
