<?php
/****************************************************/
$ThisPageName = 'viewInvoice.php'; $HideNavigation = 1;  $EditPage = 1;
/****************************************************/

include_once("../includes/header.php");
require_once($Prefix . "classes/sales.quote.order.class.php");
require_once($Prefix."classes/card.class.php");
$objSale = new sale();
$objCard = new card();
(empty($_GET['Action']))?($_GET['Action']=""):("");
(empty($_GET['OrderID']))?($_GET['OrderID']=""):("");
$Action = $_GET['Action'];
$OrderID = $_GET['OrderID'];

echo '<script>RestrictIframe();</script>';	
if(!empty($OrderID) && ($Action=='PCard' || $Action=='VCard')){
	$arrySale = $objSale->GetSalesBrief($OrderID, '', '');
	$OrderID = $arrySale[0]['OrderID'];
	$SaleID = $arrySale[0]['SaleID'];
	$Module = $arrySale[0]['Module']; 
	$InvoiceEntry = $arrySale[0]['InvoiceEntry'];
	$PaymentTerm = $arrySale[0]['PaymentTerm'];

	if(!empty($OrderID) && $Module=="Invoice"){
		if($InvoiceEntry=="0"){ /******Sales Invoice********/
			$TotalInvoiceAmount = $arrySale[0]['TotalInvoiceAmount'];
			$CardOrderID = $OrderID;
			include("includes/html/box/edit_invoice_credit.php"); 
			
		}else if($InvoiceEntry>0){ /*****Invoice Entry*******/
			include("includes/html/box/card_process_partial.php");
		}
		

/*******Credit Card Process**********/
/***********************************/
if($Action=='PCard' && !empty($_POST["AuthCardSubmit"])){
	$FormSubmitFlag = 1;
	$AmountToChargeMax = $AmountToCharge;
	if($_POST["AmountToCharge"]>0 && $AmountToChargeMax>0 && $_POST["AmountToCharge"]<=$AmountToChargeMax){
		$objCard->ProcessSaleCreditCard($OrderID,'',$_POST["AmountToCharge"]);		
		$CardProcessedFlag = 1;
	}else{			
		$_SESSION['mess_Sale'] = str_replace("[ErrorMSG]", $arryAmountInfo["ErrorMSG"] , CARD_PROCESSED_FAILED);
	}
	if(!empty($_SESSION['mess_Sale'])){
		$_SESSION['mess_Invoice'] = $_SESSION['mess_Sale'];
		unset($_SESSION['mess_Sale']);			
	}
	 
}else if(!empty($_GET['PID']) && !empty($_GET['ID']) && $Action=='VCard'){
	$FormSubmitFlag = 1;	
	$ID = base64_decode($_GET['ID']);
 	
	if($InvoiceEntry=="0" && !empty($SaleID)){ 
		$AmountToRefund = $objCard->GetTotalTransactionBySaleID($SaleID,$PaymentTerm,'Charge');
	}
	
	if($AmountToRefund>0){  
		$objCard->VoidSaleCreditCard($OrderID, '', $ID);
		$CardProcessedFlag = 1;
	}else{ 
		$_SESSION['mess_Sale'] = str_replace("[ErrorMSG]", $arryAmountInfo["ErrorMSG"]  , CARD_VOID_FAILED); 		 
	} 
	if(!empty($_SESSION['mess_error_sale'])){
		$_SESSION['mess_Sale'] = $_SESSION['mess_error_sale'];
		unset($_SESSION['mess_error_sale']);			
	}
	if(!empty($_SESSION['mess_Sale'])){
		$_SESSION['mess_Invoice'] = $_SESSION['mess_Sale'];
		unset($_SESSION['mess_Sale']);			
	}

	 
}

/****FormSubmitted*****/
if(!empty($FormSubmitFlag)){

	if(!empty($CardProcessedFlag)){
		/****UpdateBalance*****/
		$arryStatus = $objSale->GetSalesBrief($OrderID, '', '');	
		$arrStatusMsg = explode("#",$arryStatus[0]['StatusMsg']);
		$Status = $arrStatusMsg[0];
		if($Status==1){
			if($InvoiceEntry=="0"){ 				
				include("includes/html/box/edit_invoice_credit.php");
			}else if($InvoiceEntry>0){ 
				include("includes/html/box/card_process_partial.php");
			}
			$BalanceAmount = $AmountToCharge;
			$objSale->UpdateCardBalance($OrderID, $BalanceAmount);				
		} 
		/******************/
	}
	
	echo '<script>parent.location.reload(true);</script>';		 
	exit;
}

/***********************************/


	
		/****************/ 		
		if($Action=="PCard"){			
			if(!empty($ProviderID) && $AmountToCharge>0){
				$ChargeCreditCard = 1;
			}else{
				$ErrorMSG = str_replace("[ErrorMSG]", '' , CARD_PROCESSED_FAILED);
			}
		}		
		/****************/
	}else{
		$ErrorMSG = NOT_EXIST_INVOICE;
	}

	if($Action=='PCard'){ 
		$Heading = 'Authorize Credit Card';
	}else if($Action=='VCard'){
		$Heading = 'Void Credit Card';
	}

} else {
    $ErrorMSG = NOT_EXIST_INVOICE;
}
 	
 

require_once("../includes/footer.php");
?>


