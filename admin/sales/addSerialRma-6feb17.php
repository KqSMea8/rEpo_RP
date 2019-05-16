<?php
/* * *********************************************** */
#$ThisPageName = 'generateInvoice.php';
/* * *********************************************** */
$HideNavigation = 1;
include_once("../includes/header.php");
require_once($Prefix."classes/sales.quote.order.class.php");
require_once($Prefix."classes/rma.sales.class.php");
$objSale = new sale();
$objrmasale = new rmasale();
if(!empty($_GET['sku'])){
    $arrySerialNumber = $_GET['SerialValue'];
    #$arrySerialNumber = $objSale->selectSerialNumberForItem($_GET['sku']);
    
    $arrySerialNumber = $objSale->getSerialNumberForItemById($_GET['OrderID'],$_GET['item_id'],$_GET['sku']);
    
}
 

require_once("../includes/footer.php");
?>
