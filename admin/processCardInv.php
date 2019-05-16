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
	$arrySale = $objSale->GetSalesBrief($OrderID, '', ''); //required for sales invoice only
	$OrderID = $arrySale[0]['OrderID'];
	$SaleID = $arrySale[0]['SaleID']; 
	$Module = $arrySale[0]['Module']; 
	$InvoiceEntry = $arrySale[0]['InvoiceEntry'];
	$PaymentTerm = $arrySale[0]['PaymentTerm'];
 
	if(!empty($OrderID) && $PaymentTerm=='Credit Card'){	 
						 
			if($Module=="Invoice" && $InvoiceEntry=="0"){ /******Sales Invoice********/
				$TotalInvoiceAmount = $arrySale[0]['TotalInvoiceAmount'];
				$CardOrderID = $OrderID;
				include_once("finance/includes/html/box/edit_invoice_credit.php"); 
				if(!empty($CreditCardFlag) && !empty($ProviderName)){		 
					if($_GET['action']=="PCard" && $AmountToCharge>0){		 
						/*****Auth Card for Sales Invoice*******/
						/***************************************/
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
						/**************End Auth***********************/
					}else if($_GET['action']=="VCard" && $AmountToRefund>0){	
						/*****Void Card for Invoice Entry*******/
						/***************************************/
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
						/**************End Void***********************/
					} 		 
				}


			}else if($_GET['action']=="PCard" && $Module=="Invoice" && $InvoiceEntry>0){
				/*****Auth Card for Invoice Entry*******/
				/***************************************/
				$arryAmountInfo = $objCard->GetAmountCardInv($OrderID, 'Charge');
				$AmountToCharge = $arryAmountInfo["AmountToCharge"];
 
				if($AmountToCharge>0){ 				
					$objCard->ProcessSaleCreditCard($OrderID,'','');
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
				/**************End Auth***********************/

			}else if($_GET['action']=="VCard" && $Module=="Invoice" && $InvoiceEntry>0){
 
				/*****Void Card for Invoice Entry*******/
				/***************************************/
				$arryAmountInfo = $objCard->GetAmountCardInv($OrderID, 'Void');
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
				/**************End Void***********************/
			}


		 
	}else{
		$ErrorMSG = NOT_EXIST_DATA;
	}
} else {
    $ErrorMSG = NOT_EXIST_DATA;
}
 
 

if(empty($Status) && empty($ErrorMSG)){ 
	$ErrorMSG = str_replace("[ErrorMSG]", '' , CARD_PROCESSED_FAILED);
}


 
$MsgArray['Status'] = $Status;
$MsgArray['MSG'] = $MSG;
$MsgArray['ErrorMSG'] = $ErrorMSG;

echo json_encode($MsgArray);exit;

 
 
?>


