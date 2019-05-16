<?php

/**************************************************/
$ThisPageName = 'dashboard.php?curP=1&tab=quote';
/**************************************************/

include_once("includes/header.php");
require_once($Prefix."classes/sales.quote.order.class.php");
require_once($Prefix."classes/inv_tax.class.php");
require_once($Prefix."classes/sales.class.php");

$objSale = new sale();
$objTax = new tax();
(!$_GET['module'])?($_GET['module']='Quote'):("");
$module = $_GET['module'];
$ModuleName = "Sale ".$_GET['module'];

$RedirectURL='dashboard.php?curP=1&tab=salesorder';

$convertUrl = "vSalesQuoteOrder.php?module=".$module."&curP=".$_GET["curP"]."&view=".$_GET["view"]."&convert=1";

if($_GET['module']=='Quote'){
	$ModuleIDTitle = "Quote Number"; $ModuleID = "QuoteID"; $PrefixPO = "QT";  $NotExist = NOT_EXIST_QUOTE;
}else{
	$ModuleIDTitle = "Sales Order Number"; $ModuleID = "SaleID"; $PrefixPO = "PO";  $NotExist = NOT_EXIST_ORDER;
}

if(!empty($_GET['view']) || !empty($_GET['so'])){
	$arrySale = $objSale->GetSale($_GET['view'],$_GET['so'],$module);
	$OrderID   = $arrySale[0]['OrderID'];

	//Get Purchase Order Status
	$PONumber   = $arrySale[0]['PONumber'];
	if(!empty($PONumber)){
		$POStatus = $objSale->GetPOStatus($PONumber);
	}

	 




	if($OrderID>0){
		$arrySaleItem = $objSale->GetSaleItem($OrderID);
		$NumLine = sizeof($arrySaleItem);
	}else{
		$ErrorMSG = $NotExist;
	}
}else{
	header("Location:".$RedirectURL);
	exit;
}



if(empty($NumLine)) $NumLine = 1;


$arrySaleTax = $objTax->GetTaxRate('1');

$_SESSION['DateFormat']= $Config['DateFormat'];

require_once("includes/footer.php");
?>


