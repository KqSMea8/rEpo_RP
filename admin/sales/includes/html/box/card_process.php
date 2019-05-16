<?
/*******Credit Card Full Amount Process********/
/**********************************************/
if(!empty($OrderID) && $module=='Order' && $arrySale[0]['PaymentTerm']=='Credit Card' && $arrySale[0]['RecurringOption'] != "Yes"  &&  $arrySale[0]['Approved'] == "1"){
	/****ProviderID******/	
	$arryCard = $objSale->GetSaleCreditCard($OrderID); 
	if(!empty($arryCard)){
		$arryProvider = $objCard->GetProviderByCard($arryCard[0]['CardType']);
		$ProviderName = $arryProvider[0]['ProviderName'];
		$ProviderID = $arryProvider[0]['ProviderID'];		
	}	
	$TotalCharge = $objCard->GetTransactionTotal($OrderID,'Charge',$arrySale[0]['PaymentTerm']);	
	$InvoiceSpend=$AmountToRefund=0;  
	if($TotalCharge>0){
		$arrySalesCardTransaction = $objCard->GetLastSalesTransaction($OrderID,'Charge',$arrySale[0]['PaymentTerm']);			
		$ProviderName =  $arrySalesCardTransaction[0]['ProviderName'];
		$ProviderID = $arrySalesCardTransaction[0]['ProviderID'];

		/******AmountToRefund***********/
		$arryAmountInfo = $objCard->GetAmountCardSO($OrderID, 'Void');
		$AmountToRefund = $arryAmountInfo["AmountToRefund"];
		$InvoiceSpend = $arryAmountInfo["InvoiceSpend"]; 			
	} 
	/*****************************/				


	/*******Credit Card Link********/
	/*******************************/	 
	if(!empty($ProviderID)){ 		 
		 if($AmountToRefund>0 && $InvoiceSpend<=0 ){		
			$VoidCardUrl = "editSalesQuoteOrder.php?OrderID=".$OrderID."&Action=VCard&curP=".$_GET["curP"]."&PID=".$ProviderID."&Amnt=".base64_encode($AmountToRefund); 
			$ButtonVoidTxt = ' for '.$AmountToRefund.' '.$arrySale[0]['CustomerCurrency'];
				
			$card_process_link = '<a href="'.$VoidCardUrl.'" class="grey_bt"  onclick="return confirmAction(this, \'Void Credit Card\', \''.VOID_CARD.'\')" >Void Credit Card'.$ButtonVoidTxt.'</a>';		
		}else if($InvoiceSpend<=0){
			$AuthorizeCardUrl = "editSalesQuoteOrder.php?OrderID=".$OrderID."&Action=PCard&curP=".$_GET["curP"]."&ID=".$arryCard[0]['ID']; 
			$card_process_link =  '<a href="'.$AuthorizeCardUrl.'" class="grey_bt"  onclick="return confirmAction(this, \'Authorize Credit Card\', \''.AUTH_CARD.'\')" >Authorize Credit Card</a>';
		} 

		if(!empty($card_process_link)){
			echo '<div style="float:right">'.$card_process_link.'</div>'; 
		} 
	 }
	/**************************/

}
?>
