<?

/*******Credit Card********/	
/**************************/	
if($PaymentTerm == 'Credit Card' && !empty($CardOrderID)){ 
	$SaleID = $objSale->getSaleID($CardOrderID); 
	if(!empty($SaleID)){

		$arryCard = $objSale->GetSaleCreditCard($CardOrderID);
		//Sales Order Data				 
		$SaleOrderID = $objSale->getOrderIDBySaleID($SaleID);
		$TotalCharge = $objCard->GetTransactionTotal($SaleOrderID,'Charge',$PaymentTerm);
		$TotalRefund = $objCard->GetTransactionTotal($SaleOrderID,'Void',$PaymentTerm);
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
			 
			$TotalChargeAllInvoice = $objCard->GetInvoiceTransactionBySaleID($SaleID,'Charge',$PaymentTerm);
			$TotalRefundAllInvoice = $objCard->GetInvoiceTransactionBySaleID($SaleID,'Void',$PaymentTerm);
		
			$PaymentInvTotal = $TotalChargeAllInvoice - $TotalRefundAllInvoice;
			if($PaymentInvTotal>0){
				$PaymentSO += $PaymentInvTotal;
			}
			$InvoiceSpend = round($InvoiceSpend,2);
			$PaymentSO = round($PaymentSO,2);
			//echo $InvoiceSpend.'#'.$PaymentSO;
			if($InvoiceSpend>$PaymentSO){
				$AmountToCharge = $InvoiceSpend - $PaymentSO;
				$AmountToCharge = round($AmountToCharge,2);
				$CreditCardFlag = 1;
		
				$arrySalesCardTransaction = $objCard->GetLastSalesTransaction($SaleOrderID,'Charge',$PaymentTerm);	

				$ProviderName = $arrySalesCardTransaction[0]['ProviderName'];
				$ProviderID = $arrySalesCardTransaction[0]['ProviderID'];

				if(empty($ProviderID)){
					$arryProvider = $objCard->GetProviderByCard($arryCard[0]['CardType']);
					$ProviderName = $arryProvider[0]['ProviderName'];
					$ProviderID = $arryProvider[0]['ProviderID'];
				}
			
		
				$AuthorizeCardUrl = "editInvoice.php?OrderID=".base64_encode($CardOrderID)."&Action=PCard&curP=".$_GET["curP"]."&Amnt=".base64_encode($AmountToCharge)."&ExtraCharge=1"; 
	 
			}

	
		}else{  
			/********Payment For Individual Invoice**********/
			$TotalChargeInv = $objCard->GetTransactionTotal($CardOrderID,'Charge',$PaymentTerm);
			$TotalRefundInv = $objCard->GetTransactionTotal($CardOrderID,'Void',$PaymentTerm);

			$PaymentInvoice = $TotalChargeInv - $TotalRefundInv;
			$InvoiceSpend =  $TotalInvoiceAmount; //+ $ShipFreight

			#echo $InvoiceSpend.'#ppp'.$PaymentInvoice;

			if($InvoiceSpend>$PaymentInvoice){
				$AmountToCharge = $InvoiceSpend - $PaymentInvoice;
				$AmountToCharge = round($AmountToCharge,2);
				$CreditCardFlag = 1;

				$arrySalesCardTransaction = $objCard->GetLastSalesTransaction($CardOrderID,'Charge',$PaymentTerm);	

				$ProviderName = $arrySalesCardTransaction[0]['ProviderName'];
				$ProviderID = $arrySalesCardTransaction[0]['ProviderID'];

				if(empty($ProviderID)){
					$arryProvider = $objCard->GetProviderByCard($arryCard[0]['CardType']);
					$ProviderName = $arryProvider[0]['ProviderName'];
					$ProviderID = $arryProvider[0]['ProviderID'];
				}

				$AuthorizeCardUrl = "editInvoice.php?OrderID=".base64_encode($CardOrderID)."&Action=PCard&curP=".$_GET["curP"]."&Amnt=".base64_encode($AmountToCharge); 
		

			}else if($PaymentInvoice>0){
				$AmountToRefund = $PaymentInvoice;
				$AmountToRefund = round($AmountToRefund,2);
				$CreditCardFlag = 1;

				$arrySalesCardTransaction = $objCard->GetLastSalesTransaction($CardOrderID,'Charge',$PaymentTerm);	

				$ProviderName = $arrySalesCardTransaction[0]['ProviderName'];
				$ProviderID = $arrySalesCardTransaction[0]['ProviderID'];

				if(empty($ProviderID)){
					$arryProvider = $objCard->GetProviderByCard($arryCard[0]['CardType']);
					$ProviderName = $arryProvider[0]['ProviderName'];
					$ProviderID = $arryProvider[0]['ProviderID'];
				}

				$VoidCardUrl = "editInvoice.php?OrderID=".base64_encode($CardOrderID)."&Action=VCard&curP=".$_GET["curP"]."&Amnt=".base64_encode($AmountToRefund); 


			}
			/***********************************************/
		}

	$objSale->UpdateCardBalance($CardOrderID,$AmountToCharge);
	}
	
}
/*************************/
/*************************/

?>
