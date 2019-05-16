<?php
$HideNavigation = 1;  $EditPage = 1;
 
include_once("includes/settings.php");
require_once($Prefix . "classes/sales.quote.order.class.php");
require_once($Prefix."classes/card.class.php");
$objSale = new sale();
$objCard = new card();
 
$Status=0; $MSG = $ErrorMSG = '';
$Config['ProviderApiPath'] = '../admin/';
 
if(!empty($_GET['OrderID'])) {
	$OrderID = (int)$_GET['OrderID']; 
	if($_GET['action']=="PCard"){
		/*****Auth Card for SO*******/
		$arryAmountInfo = $objCard->GetAmountCardSO($OrderID, 'Charge');
		$AmountToCharge = $arryAmountInfo["AmountToCharge"];
		if($AmountToCharge>0){ 
			$objCard->ProcessSaleCreditCard($OrderID,'',$AmountToCharge);
			unset($_SESSION['mess_Sale']);

			$arryStatus = $objSale->GetSalesBrief($OrderID, '', '');	
			$arrStatusMsg = explode("#",$arryStatus[0]['StatusMsg']);
			$Status = $arrStatusMsg[0];
			if($Status==1){
				$MSG = $arrStatusMsg[1];
				$objSale->UpdateCardBalance($OrderID,'0');	 
			}else{
				$ErrorMSG = $arrStatusMsg[1];
			}
		}else{			
			$ErrorMSG = str_replace("[ErrorMSG]", $arryAmountInfo["ErrorMSG"] , CARD_PROCESSED_FAILED);
		}
		/*****************/
	}else if($_GET['action']=="VCard"){

		/*****Void Card for Sales Order*******/				
		$arryAmountInfo = $objCard->GetAmountCardSO($OrderID, 'Void');
		$AmountToRefund = $arryAmountInfo["AmountToRefund"];

		if($AmountToRefund>0){  
			$objCard->VoidSaleCreditCard($OrderID, $AmountToRefund);
			unset($_SESSION['mess_Sale']);

			$arryStatus = $objSale->GetSalesBrief($OrderID, '', '');	
			$arrStatusMsg = explode("#",$arryStatus[0]['StatusMsg']);
			$Status = $arrStatusMsg[0];
			if($Status==1){
				$MSG = $arrStatusMsg[1];
			}else{
				$ErrorMSG = $arrStatusMsg[1];
			}		 
		}else{ 
			$ErrorMSG = str_replace("[ErrorMSG]", $arryAmountInfo["ErrorMSG"]  , CARD_VOID_FAILED); 		 
		} 		 
		/*****************/
		 
		 
	}


		 
	 
} else {
    $ErrorMSG = NOT_EXIST_DATA;
}
 
 
$MsgArray['Status'] = $Status;
$MsgArray['MSG'] = $MSG;
$MsgArray['ErrorMSG'] = $ErrorMSG;

echo json_encode($MsgArray);exit;

 
 
?>


