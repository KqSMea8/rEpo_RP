<?
$AutoPostToGl = $objConfigure->getSettingVariable('AutoPostToGlAp');


if($AutoPostToGl=="1" && $PostedOrderID>0){ //PostedOrderID
	unset($arryPostData);
	$AccountPayable = $objConfigure->getSettingVariable('AccountPayable');
	$InventoryAP = $objConfigure->getSettingVariable('InventoryAR');
	$FreightExpense = $objConfigure->getSettingVariable('FreightExpense');
	$CostOfGoods = $objConfigure->getSettingVariable('CostOfGoods');
	$PurchaseClearing = $objConfigure->getSettingVariable('PurchaseClearing');
	$SalesTaxAccount = $objConfigure->getSettingVariable('SalesTaxAccount');
	$ApGainLoss = $objConfigure->getSettingVariable('ApGainLoss');

	$PostToGLDate = $objConfigure->GetOrderDate($PostedOrderID, 'PostedDate', 'p_order'); //Date

	if(empty($AccountPayable) || empty($InventoryAP) || empty($CostOfGoods) || empty($PurchaseClearing)){
		$ErrorMSGPostToGl  = SELECT_GL_AP_ALL;
	}
	
	if($AccountPayable>0 && ($AccountPayable == $InventoryAP || $AccountPayable == $CostOfGoods)){
		$ErrorMSGPostToGl  = SAME_GL_SELECTED_AP;
	}

	if(empty($ErrorMSGPostToGl)){ 			
		$arryPostData['PaymentType'] = 'Vendor Invoice';
		$arryPostData['AccountPayable'] = $AccountPayable;
		$arryPostData['InventoryAP'] = $InventoryAP;
		$arryPostData['FreightExpense'] = $FreightExpense;
		$arryPostData['CostOfGoods'] = $CostOfGoods;
		$arryPostData['PurchaseClearing'] = $PurchaseClearing;
		$arryPostData['SalesTaxAccount'] = $SalesTaxAccount;
		$arryPostData['ApGainLoss'] = $ApGainLoss;	

		$arryPostData['PostToGLDate'] = $PostToGLDate;
		$objReport->PoInvoicePostToGL($PostedOrderID,$arryPostData);	 
	}	
	
}
 
?>
