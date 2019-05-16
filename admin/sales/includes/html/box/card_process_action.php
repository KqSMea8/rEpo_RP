<? 

	/*******Credit Card Process**********/
	if(!empty($_GET['OrderID']) && !empty($_GET['ID']) && $_GET['Action']=='PCard'){
		$arryAmountInfo = $objCard->GetAmountCardSO($_GET['OrderID'], 'Charge');
		$AmountToCharge = $arryAmountInfo["AmountToCharge"]; //Max

		/******Partial : working on paySO.php******
		if(!empty($_POST["AuthCardSubmit"]) && $_POST["AmountToCharge"]>0 && $AmountToCharge>0 && $_POST["AmountToCharge"]<=$AmountToCharge){
			$objCard->ProcessSaleCreditCard($_GET['OrderID'],'',$_POST["AmountToCharge"]);
		}else{			
			$_SESSION['mess_Sale'] = str_replace("[ErrorMSG]", $arryAmountInfo["ErrorMSG"] , CARD_PROCESSED_FAILED);
		}		 
		/******Full********/
		if($AmountToCharge>0){ 
			$objCard->ProcessSaleCreditCard($_GET['OrderID'],'',$AmountToCharge);
		}else{			
			$_SESSION['mess_Sale'] = str_replace("[ErrorMSG]", $arryAmountInfo["ErrorMSG"] , CARD_PROCESSED_FAILED);
		}
		/***************/
		
		header("Location:".$EditUrl);
		exit;
	}else if(!empty($_GET['OrderID']) && !empty($_GET['PID']) && $_GET['Action']=='VCard'){	
		$arryAmountInfo = $objCard->GetAmountCardSO($_GET['OrderID'], 'Void');
		$AmountToRefund = $arryAmountInfo["AmountToRefund"];
		//if(!empty($_GET['ID'])){
			/******Partial********
			$ID = base64_decode($_GET['ID']);
			if($AmountToRefund>0){  
				$objCard->VoidSaleCreditCard($_GET['OrderID'], "", $ID);
			}else{ 
				$_SESSION['mess_Sale'] = str_replace("[ErrorMSG]", $arryAmountInfo["ErrorMSG"]  , CARD_VOID_FAILED); 		 
			} 
			/********************/
		//}else{
			/*********Full********/
			if(!empty($_GET['Amnt']))$Amnt = base64_decode($_GET['Amnt']);	

		 	if($AmountToRefund>0){  
				$objCard->VoidSaleCreditCard($_GET['OrderID'], $Amnt);
			}else{ 
				$_SESSION['mess_Sale'] = str_replace("[ErrorMSG]", $arryAmountInfo["ErrorMSG"]  , CARD_VOID_FAILED); 		 
			} 
			/***************/
		//}

		if(!empty($_SESSION['mess_error_sale'])){
			$_SESSION['mess_Sale'] = $_SESSION['mess_error_sale'];
			unset($_SESSION['mess_error_sale']);			
		}
		header("Location:".$EditUrl);
		exit;
	}
	/***********************************/
?>
