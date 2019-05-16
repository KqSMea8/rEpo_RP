<?php 
	if(!empty($_GET['pop']))$HideNavigation = 1;
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
	$ModuleName = $module;

	$RedirectURL = "viewInvoice.php?curP=".$_GET['curP'];
	$EditUrl = "editInvoice.php?edit=".$_GET["view"]."&curP=".$_GET["curP"]; 
	$DownloadUrl = "pdfInvoice.php?IN=".$_GET["view"].""; 

	$ModuleIDTitle = "Invoice Number"; $ModuleID = "InvoiceID"; $PrefixSale = "IN";  $NotExist = NOT_EXIST_ORDER;

	
	/*if ($_POST) {
			
			if(!empty($_POST['savePaymentInfo'])) {
				$objSale->addPaymentInformation($_POST);
				$_SESSION['mess_Invoice'] = ADD_PAYMENT_INFORMATION;
				header("Location:".$EditUrl);
				exit;
			 } 
		}*/	
		
	if(!empty($_GET['view']) || !empty($_GET['so'])){
		$arrySale = $objSale->GetSale($_GET['view'],$_GET['so'],$module);
		
		$OrderID   = $arrySale[0]['OrderID'];	
		if($OrderID>0){
			$arrySaleItem = $objSale->GetSaleItem($OrderID);
			$NumLine = sizeof($arrySaleItem);
			
			//get payment history
			 
			 $arryPaymentInvoice = $objSale->GetPaymentInvoice($OrderID);
			 $paidAmnt = $objSale->GetTotalPaymentAmntForInvoice($OrderID);
			
			 $InvoiceAmount  = $arrySale[0]['TotalInvoiceAmount'];
			
			 if($paidAmnt > 0){
				   $remainInvoiceAmount = $InvoiceAmount-$paidAmnt;
				 }else{
					 $remainInvoiceAmount = $InvoiceAmount;
				 }
			 if($paidAmnt == $InvoiceAmount){
				    $objSale->updateInvoiceStatus($OrderID);
				 }
			//end
		}else{
			$ErrorMSG = $NotExist;
		}
	}else{
		header("Location:".$RedirectURL);
		exit;
	}
				

	if(empty($NumLine)) $NumLine = 1;	


	$arrySaleTax = $objTax->GetTaxRate('1');
    $arryPaymentMethod = $objConfigure->GetAttribFinance('PaymentMethod','');
	$_SESSION['DateFormat']= $Config['DateFormat'];

	require_once("../includes/footer.php"); 	 
?>


