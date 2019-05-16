<?
	/*******Invoice Entry Void**********/
	 if(!empty($_GET['OrderID']) && !empty($_GET['PID']) && $_GET['Action']=='VCard'){	
		$OrderID = (int)$_GET['OrderID'];
		$arryAmountInfo = $objCard->GetAmountCardInv($OrderID, 'Void');
		$AmountToRefund = $arryAmountInfo["AmountToRefund"];

		if(!empty($_GET['ID'])){
			/******Partial********/
			$ID = base64_decode($_GET['ID']);
			if($AmountToRefund>0){  
				$objCard->VoidSaleCreditCard($OrderID, "", $ID);

				/****UpdateBalance*****/
				$arryStatus = $objSale->GetSalesBrief($OrderID, '', '');
				$InvoiceEntry = $arryStatus[0]['InvoiceEntry'];	
				$arrySale[0]['PaymentTerm'] =   $arryStatus[0]['PaymentTerm'];	
				$arrStatusMsg = explode("#",$arryStatus[0]['StatusMsg']);
				$Status = $arrStatusMsg[0];
				if($Status==1){
					if($InvoiceEntry>0){ 
						include("includes/html/box/card_process_partial.php");
						$BalanceAmount = $AmountToCharge;
						$objSale->UpdateCardBalance($OrderID, $BalanceAmount);			
					}						
				} 
				/******************/


			}else{ 
				$_SESSION['mess_Sale'] = str_replace("[ErrorMSG]", $arryAmountInfo["ErrorMSG"]  , CARD_VOID_FAILED); 		 
			} 
			/********************/
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
