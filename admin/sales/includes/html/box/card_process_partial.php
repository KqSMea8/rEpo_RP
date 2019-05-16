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
	if(!empty($ProviderID) && $AmountToCharge>0 && empty($_GET['Action'])){
		$card_process_link = '<a href="paySO.php?OrderID='.$OrderID.'&Action=PCard"  class="fancybox authcard grey_bt fancybox.iframe"   >Authorize Credit Card for '.number_format($AmountToCharge,2).' '.$arrySale[0]['CustomerCurrency'].'</a>';
		echo '<div style="float:right">'.$card_process_link.'</div>';  
	} 	 	 
	/**************************/

}
?>
<script language="JavaScript1.2" type="text/javascript">
    $(document).ready(function() {
        $(".authcard").fancybox({
            'width': 500
        });
    });
</script>
