<?php

/* * *********************************************** */
$ThisPageName = 'generateInvoice.php';
/* * *********************************************** */
$HideNavigation = 1;
include_once("../includes/header.php");
require_once($Prefix."classes/sales.quote.order.class.php");
$objSale = new sale();
 

(empty($_GET['sku']))?($_GET['sku']=""):(""); 
(empty($_GET['MainSku']))?($_GET['MainSku']=""):(""); 
(empty($_GET['SerialValue']))?($_GET['SerialValue']=""):(""); 
(empty($_GET['Module']))?($_GET['Module']=""):(""); 
(empty($_GET['OrderID']))?($_GET['OrderID']=""):(""); 
(empty($_GET['serial_value_sel']))?($_GET['serial_value_sel']=""):(""); 
(empty($_GET['cond']))?($_GET['cond']=""):(""); 
(empty($_GET['WID']))?($_GET['WID']=""):(""); 
(empty($_GET['LineID']))?($_GET['LineID']=""):(""); 
(empty($_GET['total']))?($_GET['total']=""):(""); 
(empty($_GET['binid']))?($_GET['binid']=""):("");

if(!empty($_GET['sku'])){

	if(!empty($_GET['MainSku'])){
		$_GET['sku'] =$_GET['MainSku'];
	}
	
	
/*$Config['Condition'] = $_GET['cond'];
$Config['warehouse'] = $_GET['WID'];
$Config['LineID'] =$_GET['LineID'];
$Config['OrderID'] =$_GET['OrderID'];
$Config['binid'] =$_GET['binid'];

	$arrySerialNumber = $objSale->selectSerialNumberForItem($_GET['sku']);*/
	
	#pr($arrySerialNumber); exit;

	if(!empty($_GET['SerialValue'])){ $SelSerialNumber = $_GET['SerialValue'];} else{ $SelSerialNumber ='';}
 

	$Config['Condition'] = $_GET['cond'];
	$Config['warehouse'] = $_GET['WID'];
	$Config['LineID'] =$_GET['LineID'];
	if($_GET['Module'] == 'editinvoice'){
		$Config['UsedSerial'] = 1;
	}
   
}
 
require_once("../includes/footer.php");
?>
