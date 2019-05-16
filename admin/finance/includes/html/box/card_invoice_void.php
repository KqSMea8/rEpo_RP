<?
 /*******Sales Invoice Void**********/
 if(!empty($_GET['OrderID']) && !empty($_GET['PID'])  && $_GET['Action']=='VCard'){
	$OrderID = (int)$_GET['OrderID'];
	$arrySale = $objSale->GetSalesBrief($OrderID, '', '');

	$PaymentTerm = $arrySale[0]['PaymentTerm'];
	$TotalInvoiceAmount = $arrySale[0]['TotalInvoiceAmount'];
	$SaleID = $arrySale[0]['SaleID'];
	$InvoiceEntry = $arrySale[0]['InvoiceEntry'];
	$Module = $arrySale[0]['Module']; 
	$CardOrderID = $OrderID;
	
	if(!empty($_GET['ID'])){
		/******Partial********/
		$ID = base64_decode($_GET['ID']);

		$AmountToRefund = $objCard->GetTotalTransactionBySaleID($SaleID,$PaymentTerm,'Charge');

		if($AmountToRefund>0){  
			$objCard->VoidSaleCreditCard($OrderID, "", $ID);


			/****UpdateBalance*****/
			$arryStatus = $objSale->GetSalesBrief($OrderID, '', '');	
			$arrStatusMsg = explode("#",$arryStatus[0]['StatusMsg']);
			$Status = $arrStatusMsg[0];
			if($Status==1){
				if($InvoiceEntry=="0"){ 				
					include("includes/html/box/edit_invoice_credit.php");
					$BalanceAmount = $AmountToCharge;
					$objSale->UpdateCardBalance($OrderID, $BalanceAmount);		
				} 						
			} 
			/******************/	



		}else{ 
			$_SESSION['mess_Sale'] = str_replace("[ErrorMSG]", $arryAmountInfo["ErrorMSG"]  , CARD_VOID_FAILED); 		 
		} 
		/********************/
	} 

	if(!empty($_SESSION['mess_Sale'])){
		$_SESSION['mess_Invoice'] = $_SESSION['mess_Sale'];
		unset($_SESSION['mess_Sale']);			
	}
	$EditUrl = "editInvoice.php?edit=".$OrderID."&curP=".$_GET["curP"]; 	
	header("Location:".$EditUrl);
	exit;
}
/*************************************/
?>
