<?
	/*******Credit Card Process**********/
	$CreditCardFlag = 0;
	if(!empty($_GET['OrderID']) && !empty($_GET['ID']) && $_GET['Action']=='PCard'){

		$arryAmountInfo = $objCard->GetAmountCardInv($_GET['OrderID'], 'Charge');
		$AmountToCharge = $arryAmountInfo["AmountToCharge"];
		if($AmountToCharge>0){ 
			$objCard->ProcessSaleCreditCard($_GET['OrderID'],'',$AmountToCharge);
		}else{			
			$_SESSION['mess_Sale'] = str_replace("[ErrorMSG]", $arryAmountInfo["ErrorMSG"] , CARD_PROCESSED_FAILED);
		}		 
		
		if(!empty($_SESSION['mess_Sale'])){
			$_SESSION['mess_Invoice'] = $_SESSION['mess_Sale'];
			unset($_SESSION['mess_Sale']);			
		}
		header("Location:".$EditUrl);
		exit;
	}else if(!empty($_GET['OrderID']) && !empty($_GET['PID']) && $_GET['Action']=='VCard'){	

		$arryAmountInfo = $objCard->GetAmountCardInv($_GET['OrderID'], 'Void');
		$AmountToRefund = $arryAmountInfo["AmountToRefund"];
	 	if($AmountToRefund>0){  
			$objCard->VoidSaleCreditCard($_GET['OrderID'], $AmountToRefund);
		}else{ 
			$_SESSION['mess_Sale'] = str_replace("[ErrorMSG]", $arryAmountInfo["ErrorMSG"]  , CARD_VOID_FAILED); 		 
		} 	 
 
		if(!empty($_SESSION['mess_error_sale'])){
			$_SESSION['mess_Invoice'] = $_SESSION['mess_error_sale'];
			unset($_SESSION['mess_error_sale']);			
		}
		if(!empty($_SESSION['mess_Sale'])){
			$_SESSION['mess_Invoice'] = $_SESSION['mess_Sale'];
			unset($_SESSION['mess_Sale']);			
		}
		header("Location:".$EditUrl);
		exit;
	}
	/***********************************/
?>
