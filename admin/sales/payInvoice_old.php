<?php 
	$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'viewInvoice.php'; 
	/**************************************************/
	include_once("../includes/header.php");
	require_once($Prefix."classes/sales.quote.order.class.php");
	require_once($Prefix."classes/inv_tax.class.php");
	require_once($Prefix."classes/sales.class.php");
	
	$objCommon = new common();
	$objSale = new sale();
	$objTax = new tax();
	
	$module = 'Invoice';
	$EditUrl = "editInvoice.php?edit=".$_GET["pay"]."&module=".$module."&curP=".$_GET["curP"];
	if(!empty($_GET['pay'])){
			$arrySale = $objSale->GetSale($_GET['pay'],'',$module);
			$OrderID   = $arrySale[0]['OrderID'];	
			if($OrderID>0){
				$arrySaleItem = $objSale->GetSaleItem($OrderID);
				$NumLine = sizeof($arrySaleItem);
				
				//get total payment amount for a invoice
				
				 $paidAmnt = $objSale->GetTotalPaymentAmntForInvoice($OrderID);
				 $InvoiceAmount  = $arrySale[0]['TotalInvoiceAmount'];
				 if($paidAmnt > 0){
				   $InvoiceAmount = $InvoiceAmount-$paidAmnt;
				 }
				 
				
				 
				//end code
				
			}else{
				$ErrorMSG = $NotExist;
			}
		}
	if ($_POST) {
			
			if(!empty($_POST['savePaymentInfo'])) {
				$objSale->addPaymentInformation($_POST);
				/*$_SESSION['mess_Invoice'] = ADD_PAYMENT_INFORMATION;
				$RedirectURL = "viewInvoice.php?module=Invoice&curP=".$_GET["curP"];
				header("Location:".$RedirectURL);*/
				exit;
			 } 
		}	
		
	$arrySaleTax = $objTax->GetTaxRate('1');
	$arryPaymentMethod = $objCommon->GetAttribValue('PaymentMethod','');
	
	$_SESSION['DateFormat']= $Config['DateFormat'];
	
	/*************************/
 
	require_once("../includes/footer.php"); 	
	
?>


