<?

/*******Credit Card********/	
/**************************/		
if($arrySale[0]['PaymentTerm'] == 'Credit Card' && !empty($SaleID)){ 
	$arryCard = $objSale->GetSaleCreditCard($OrderID);
	//Sales Order Data				 
	$SaleOrderID = $objSale->getOrderIDBySaleID($SaleID);
	$TotalCharge = $objCard->GetTransactionTotal($SaleOrderID,'Charge',$arrySale[0]['PaymentTerm']);
	$TotalRefund = $objCard->GetTransactionTotal($SaleOrderID,'Void',$arrySale[0]['PaymentTerm']);
	if(empty($arryCard[0]["CardType"])){
		unset($arryCard[0]);
		$arryCard = $objSale->GetSaleCreditCard($SaleOrderID);
	}
	$PaymentSO = $TotalCharge - $TotalRefund;

	$inputBoxClass = 'readonly class="disabled_inputbox"';

	if($PaymentSO>0){
		/********Payment For Extra Amount**********/		
		//Invoice Total Data
		$AllInvoiceTotal = $objSale->AllInvoiceTotalBySaleID($SaleID);
		$AllShipFreight = 0; //$objSale->AllShipFreightBySaleID($SaleID); //Not Needed PK
		$InvoiceSpend = $AllInvoiceTotal + $AllShipFreight;
		 
		$TotalChargeAllInvoice = $objCard->GetInvoiceTransactionBySaleID($SaleID,'Charge',$arrySale[0]['PaymentTerm']);
		$TotalRefundAllInvoice = $objCard->GetInvoiceTransactionBySaleID($SaleID,'Void',$arrySale[0]['PaymentTerm']);
		
		$PaymentInvTotal = $TotalChargeAllInvoice - $TotalRefundAllInvoice;
		if($PaymentInvTotal>0){
			$PaymentSO += $PaymentInvTotal;
		}
		$InvoiceSpend = round($InvoiceSpend,2);
		$PaymentSO = round($PaymentSO,2);
		//echo $InvoiceSpend.'#'.$PaymentSO;
		if($InvoiceSpend>$PaymentSO){
			$AmountToCharge = $InvoiceSpend - $PaymentSO;
			$CreditCardFlag = 1;
		
			$arrySalesCardTransaction = $objCard->GetLastSalesTransaction($SaleOrderID,'Charge',$arrySale[0]['PaymentTerm']);	

			$ProviderName = $arrySalesCardTransaction[0]['ProviderName'];
			$ProviderID = $arrySalesCardTransaction[0]['ProviderID'];

			if(empty($ProviderID)){
				$arryProvider = $objCard->GetProviderByCard($arryCard[0]['CardType']);
				$ProviderName = $arryProvider[0]['ProviderName'];
				$ProviderID = $arryProvider[0]['ProviderID'];
			}
			
		
			$AuthorizeCardUrl = "editInvoice.php?OrderID=".base64_encode($OrderID)."&Action=PCard&curP=".$_GET["curP"]."&Amnt=".base64_encode($AmountToCharge)."&ExtraCharge=1"; 
 
		}

	
	}else{  
		/********Payment For Individual Invoice**********/
		$TotalChargeInv = $objCard->GetTransactionTotal($OrderID,'Charge',$arrySale[0]['PaymentTerm']);
		$TotalRefundInv = $objCard->GetTransactionTotal($OrderID,'Void',$arrySale[0]['PaymentTerm']);

		$PaymentInvoice = $TotalChargeInv - $TotalRefundInv;
		$InvoiceSpend =  $arrySale[0]['TotalInvoiceAmount']; //+ $ShipFreight

		#echo $TotalChargeInv.'#'.$TotalRefundInv;

		if($InvoiceSpend>$PaymentInvoice){
			$AmountToCharge = $InvoiceSpend - $PaymentInvoice;
			$CreditCardFlag = 1;

			$arrySalesCardTransaction = $objCard->GetLastSalesTransaction($OrderID,'Charge',$arrySale[0]['PaymentTerm']);	

			$ProviderName = $arrySalesCardTransaction[0]['ProviderName'];
			$ProviderID = $arrySalesCardTransaction[0]['ProviderID'];

			if(empty($ProviderID)){
				$arryProvider = $objCard->GetProviderByCard($arryCard[0]['CardType']);
				$ProviderName = $arryProvider[0]['ProviderName'];
				$ProviderID = $arryProvider[0]['ProviderID'];
			}

			$AuthorizeCardUrl = "editInvoice.php?OrderID=".base64_encode($OrderID)."&Action=PCard&curP=".$_GET["curP"]."&Amnt=".base64_encode($AmountToCharge); 
		

		}else if($PaymentInvoice>0){
			$AmountToRefund = $PaymentInvoice;
			$CreditCardFlag = 1;

			$arrySalesCardTransaction = $objCard->GetLastSalesTransaction($OrderID,'Charge',$arrySale[0]['PaymentTerm']);	

			$ProviderName = $arrySalesCardTransaction[0]['ProviderName'];
			$ProviderID = $arrySalesCardTransaction[0]['ProviderID'];

			if(empty($ProviderID)){
				$arryProvider = $objCard->GetProviderByCard($arryCard[0]['CardType']);
				$ProviderName = $arryProvider[0]['ProviderName'];
				$ProviderID = $arryProvider[0]['ProviderID'];
			}

			$VoidCardUrl = "editInvoice.php?OrderID=".base64_encode($OrderID)."&Action=VCard&curP=".$_GET["curP"]."&Amnt=".base64_encode($AmountToRefund); 


		}
		/***********************************************/
	}
}
/*************************/
/*************************/

?>
