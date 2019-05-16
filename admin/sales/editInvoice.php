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
	$ModuleName = "Edit Invoice";
	$RedirectURL = "viewInvoice.php?curP=".$_GET['curP'];
	$EditUrl = "editInvoice.php?edit=".$_GET["edit"]."&curP=".$_GET["curP"]; 
	$DownloadUrl = "pdfInvoice.php?IN=".$_GET["edit"].""; 

	$ModuleIDTitle = "Invoice Number"; $ModuleID = "InvoiceID"; $PrefixSale = "IN";  $NotExist = NOT_EXIST_ORDER;
	
	if ($_POST) {
			
			if(!empty($_POST['savePaymentInfo'])) {
				$objSale->addPaymentInformation($_POST);
				$objSale->sendSalesPaymentEmail($_POST);
				$_SESSION['mess_Invoice'] = ADD_PAYMENT_INFORMATION;
				header("Location:".$EditUrl);
				exit;
			 } 
		}	

	if(!empty($_GET['edit']) || !empty($_GET['so'])){
		$arrySale = $objSale->GetSale($_GET['edit'],$_GET['so'],$module);
		
		$OrderID   = $arrySale[0]['OrderID'];	
		$SaleID   = $arrySale[0]['SaleID'];
		
		if($OrderID>0){
			$arrySaleItem = $objSale->GetSaleItem($OrderID);
			$NumLine = sizeof($arrySaleItem);
			
			//get payment history
			 
			 $arryPaymentInvoice = $objSale->GetPaymentInvoice($OrderID);
			 $paidAmnt = $objSale->GetTotalPaymentAmntForInvoice($OrderID);
			 $paidOrderAmnt = $objSale->GetTotalPaymentAmntForOrder($SaleID);
			 $InvoiceAmount  = $arrySale[0]['TotalInvoiceAmount'];
			 $TotalOrderedAmount  = $arrySale[0]['TotalAmount'];
			
			 if($paidAmnt > 0){
				   $remainInvoiceAmount = $InvoiceAmount-$paidAmnt;
				   $objSale->updateInvoiceStatus($OrderID,1);	
				 }else{
					 $remainInvoiceAmount = $InvoiceAmount;
				 }
			 if($paidAmnt == $InvoiceAmount){
				    $objSale->updateInvoiceStatus($OrderID,2);
				 }
				
			 if($paidOrderAmnt == $TotalOrderedAmount){
			 
				    $objSale->updateOrderStatus($SaleID);
				 }
			//end
			
			
		}else{
			$ErrorMSG = $NotExist;
		}
	}

	
 if($_GET['del_id'] && !empty($_GET['del_id'])){
		$_SESSION['mess_Invoice'] = $module.REMOVED;
		$objSale->RemoveInvoice($_GET['del_id']);
		header("Location:".$RedirectURL);
		exit;
	}
				
	
		
	if(!empty($_GET['edit'])){
		$arrySale = $objSale->GetSale($_GET['edit'],'',$module);
		$OrderID   = $arrySale[0]['OrderID'];	
		if($OrderID>0){
			$arrySaleItem = $objSale->GetSaleItem($OrderID);
			$NumLine = sizeof($arrySaleItem);
		}else{
			$ErrorMSG = $NotExist;
		}
	}
		
	if(empty($NumLine)) $NumLine = 1;	


	$arrySaleTax = $objTax->GetTaxRate('1');
	$arryPaymentMethod = $objConfigure->GetAttribFinance('PaymentMethod','');
	
	$_SESSION['DateFormat']= $Config['DateFormat'];

	require_once("../includes/footer.php"); 	 
?>
