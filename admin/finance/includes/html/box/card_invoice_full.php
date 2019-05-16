<?
if($CreditCardFlag==1 && !empty($ProviderName) && $arrySale[0]['PostToGL'] != "1" ){ 
	if($AmountToCharge>0){		 
		echo '<div style="float:right;display:none2"><a href="'.$AuthorizeCardUrl.'" class="grey_bt"  onclick="return confirmAction(this, \'Authorize Credit Card\', \''.AUTH_CARD.'\')" >Authorize Credit Card for '.$AmountToCharge.' '.$arrySale[0]['CustomerCurrency'].'</a></div>';
	}else if($AmountToRefund>0){	
			echo '<div style="float:right;display:none2"><a href="'.$VoidCardUrl.'" class="grey_bt"  onclick="return confirmAction(this, \'Void Credit Card\', \''.VOID_CARD.'\')" >Void Credit Card for '.$AmountToRefund.' '.$arrySale[0]['CustomerCurrency'].'</a></div>';		
	} 		 
}
?>
