<? 
 if(!empty($OrderID) && $arrySale[0]['PaymentTerm']=='Credit Card'){
	/****ProviderID******/	
	$arryCard = $objSale->GetSaleCreditCard($OrderID); 
	if(!empty($arryCard)){
		$arryProvider = $objCard->GetProviderByCard($arryCard[0]['CardType']);
		$ProviderName = $arryProvider[0]['ProviderName'];
		$ProviderID = $arryProvider[0]['ProviderID'];		
	} 
	/****AmountToCharge******/
	$arryAmountInfo = $objCard->GetAmountCardInv($OrderID, 'Charge');
	$AmountToCharge = $arryAmountInfo["AmountToCharge"];
	$CardPaymentFailed = $arryAmountInfo["CardPaymentFailed"];		 
	if($AmountToCharge>0){						
		$CreditCardFlag = 1;			
	}
	/****AmountToRefund******/
	$arryAmountInfo = $objCard->GetAmountCardInv($OrderID, 'Void');
	$AmountToRefund = $arryAmountInfo["AmountToRefund"];
	if($AmountToRefund>0){					
		$arrySalesCardTransaction = $objCard->GetLastSalesTransaction($OrderID,'Charge',$arrySale[0]['PaymentTerm']);
		$ProviderName = $arrySalesCardTransaction[0]['ProviderName'];
		$ProviderID = $arrySalesCardTransaction[0]['ProviderID'];		
		$CreditCardFlag = 1;
		$AmountToCharge = 0;		 
	}
	/**********************/	
	$objSale->UpdateCardBalance($OrderID,$AmountToCharge);	

	/*******Credit Card Link********/
	/*******************************/
	 if(!empty($ProviderID)){	 
		 if($AmountToRefund>0){
			$VoidCardUrl = "editInvoiceEntry.php?OrderID=".$_GET["edit"]."&Action=VCard&curP=".$_GET["curP"]."&PID=".$ProviderID; 						
			$card_process_link = '<a href="'.$VoidCardUrl.'" class="grey_bt"  onclick="return confirmAction(this, \'Void Credit Card\', \''.VOID_CARD.'\')" >Void Credit Card</a>'; 		
		}else{
			$AuthorizeCardUrl = "editInvoiceEntry.php?OrderID=".$_GET["edit"]."&Action=PCard&curP=".$_GET["curP"]."&ID=".$arryCard[0]['ID']; 
			$card_process_link = '<a href="'.$AuthorizeCardUrl.'" class="grey_bt"  onclick="return confirmAction(this, \'Authorize Credit Card\', \''.AUTH_CARD.'\')" >Authorize Credit Card</a>';

		}
		if(!empty($card_process_link)){
			echo '<div style="float:right">'.$card_process_link.'</div>'; 
		} 
	}
	/**************************/
}

?>
