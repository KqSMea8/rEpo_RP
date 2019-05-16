<?php
/****************************************************/
$ThisPageName = 'viewSalesQuoteOrder.php'; $HideNavigation = 1;  $EditPage = 1;
/****************************************************/

include_once("../includes/header.php");
require_once($Prefix . "classes/sales.quote.order.class.php");
require_once($Prefix."classes/card.class.php");
$objSale = new sale();
$objCard = new card();
(empty($_GET['Action']))?($_GET['Action']=""):("");
(empty($_GET['OrderID']))?($_GET['OrderID']=""):("");
$Action = $_GET['Action'];
$OrderID = $_GET['OrderID'];


echo '<script>RestrictIframe();</script>';	

/*******Credit Card Process**********/
if(!empty($OrderID) && $Action=='PCard' && !empty($_POST["AuthCardSubmit"])){
	/****************/
	/****************/
	$arryAmountInfo = $objCard->GetAmountCardSO($OrderID, 'Charge');
	$AmountToChargeMax = $arryAmountInfo["AmountToCharge"]; //Max

	if($_POST["AmountToCharge"]>0 && $AmountToChargeMax>0 && $_POST["AmountToCharge"]<=$AmountToChargeMax){
		$objCard->ProcessSaleCreditCard($OrderID,'',$_POST["AmountToCharge"]);
		 
      		/****UpdateBalance*****/
		$arryStatus = $objSale->GetSalesBrief($OrderID, '', '');	
		$arrStatusMsg = explode("#",$arryStatus[0]['StatusMsg']);
		$Status = $arrStatusMsg[0];
		if($Status==1){
			$arryBalance = $objCard->GetAmountCardSO($OrderID, 'Charge');
			$BalanceAmount = $arryBalance["AmountToCharge"];
			if(isset($BalanceAmount)) $objSale->UpdateCardBalance($OrderID, $BalanceAmount);				
		} 
		/******************/
	}else{			
		$_SESSION['mess_Sale'] = str_replace("[ErrorMSG]", $arryAmountInfo["ErrorMSG"] , CARD_PROCESSED_FAILED);
	}
	echo '<script>parent.location.reload(true);</script>';		 
	exit;
	/****************/

}else if(!empty($OrderID) && !empty($_GET['PID']) && !empty($_GET['ID']) && $Action=='VCard'){	
	/****************/
	/****************/
	$ID = base64_decode($_GET['ID']);
	$arryAmountInfo = $objCard->GetAmountCardSO($OrderID, 'Void');
	$AmountToRefund = $arryAmountInfo["AmountToRefund"];
 	if($AmountToRefund>0){  
		$objCard->VoidSaleCreditCard($OrderID, '', $ID);
	}else{ 
		$_SESSION['mess_Sale'] = str_replace("[ErrorMSG]", $arryAmountInfo["ErrorMSG"]  , CARD_VOID_FAILED); 		 
	} 
	if(!empty($_SESSION['mess_error_sale'])){
		$_SESSION['mess_Sale'] = $_SESSION['mess_error_sale'];
		unset($_SESSION['mess_error_sale']);			
	}
	echo '<script>parent.location.reload(true);</script>';		 
	exit;
	/****************/
}
/***********************************/



if(!empty($OrderID) && ($Action=='PCard' || $Action=='VCard')){
	if($Action=='PCard'){ 
		$Heading = 'Authorize Credit Card';
	}else if($Action=='VCard'){
		$Heading = 'Void Credit Card';
	}
	$arrySale = $objSale->GetSale($OrderID, '', 'Order');
	$OrderID = $arrySale[0]['OrderID'];
	$module = $arrySale[0]['Module'];

	if(!empty($OrderID)){	
		/****************/ 		
		if($Action=="PCard"){
			include("includes/html/box/card_process_partial.php");
			if(!empty($ProviderID) && $AmountToCharge>0){
				$ChargeCreditCard = 1;
			}else{
				$ErrorMSG = str_replace("[ErrorMSG]", '' , CARD_PROCESSED_FAILED);
			}
		}		
		/****************/
	}else{
		$ErrorMSG = NOT_EXIST_ORDER;
	}
} else {
    $ErrorMSG = NOT_EXIST_ORDER;
}
 	
 

require_once("../includes/footer.php");
?>


