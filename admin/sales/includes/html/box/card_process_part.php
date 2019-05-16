<?
/*******Credit Card Partial Amount Process********/
/**********************************************/
if(!empty($OrderID) && $module=='Order' && $arrySale[0]['PaymentTerm']=='Credit Card' && $arrySale[0]['RecurringOption'] != "Yes"  &&  $arrySale[0]['Approved'] == "1"){
	/****ProviderID******/	
	$arryCard = $objSale->GetSaleCreditCard($OrderID); 
	$AmountToCharge=0;
	if(!empty($arryCard)){
		$arryProvider = $objCard->GetProviderByCard($arryCard[0]['CardType']);
		$ProviderName = $arryProvider[0]['ProviderName'];
		$ProviderID = $arryProvider[0]['ProviderID'];
		/******AmountToCharge***********/
		$arryAmountInfo = $objCard->GetAmountCardSO($OrderID, 'Charge');
		$AmountToCharge = $arryAmountInfo["AmountToCharge"];		
	}
	/*******Credit Card Link********/
	/*******************************/ 
	if(!empty($ProviderID) && $AmountToCharge>0){
		$AuthorizeCardUrl = "editSalesQuoteOrder.php?OrderID=".$OrderID."&Action=PCard&curP=".$_GET["curP"]."&ID=".$arryCard[0]['ID']; 
	 	$card_process_link = '<a href="#authorize_card_div"  class="fancybox grey_bt" >Authorize Credit Card for '.$AmountToCharge.' '.$arrySale[0]['CustomerCurrency'].'</a>';
		echo '<div style="float:right">'.$card_process_link.'</div>'; 
		include("includes/html/box/authorize_card_div.php");
	} 	 	 
	/**************************/

}
?>
