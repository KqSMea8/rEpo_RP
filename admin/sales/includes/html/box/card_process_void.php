<? 
	/*******Credit Card Void**********/
	if(!empty($_GET['OrderID']) && !empty($_GET['PID']) && $_GET['Action']=='VCard'){	
		$arryAmountInfo = $objCard->GetAmountCardSO($_GET['OrderID'], 'Void');
		$AmountToRefund = $arryAmountInfo["AmountToRefund"];
		if(!empty($_GET['ID'])){
			/******Partial********/
			$ID = base64_decode($_GET['ID']);
			if($AmountToRefund>0){  
				$objCard->VoidSaleCreditCard($_GET['OrderID'], "", $ID);
			}else{ 
				$_SESSION['mess_Sale'] = str_replace("[ErrorMSG]", $arryAmountInfo["ErrorMSG"]  , CARD_VOID_FAILED); 		 
			} 
			/********************/
		} 
		if(!empty($_SESSION['mess_error_sale'])){
			$_SESSION['mess_Sale'] = $_SESSION['mess_error_sale'];
			unset($_SESSION['mess_error_sale']);			
		}
		header("Location:".$EditUrl);
		exit;
	}
	/***********************************/
?>
