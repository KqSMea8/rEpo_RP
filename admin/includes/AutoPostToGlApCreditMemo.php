<? 
$AutoPostToGl = $objConfigure->getSettingVariable('AutoPostToGlApCredit');
//$AutoPostToGl = 0; //comment this
if($AutoPostToGl=="1" && $Approved=="1" && $PostedOrderID>0){ 
	unset($arryPostData);
	$AccountPayable = $objConfigure->getSettingVariable('AccountPayable');
	$InventoryAP = $objConfigure->getSettingVariable('InventoryAR');
	$FreightExpense = $objConfigure->getSettingVariable('FreightExpense');
	$CostOfGoods = $objConfigure->getSettingVariable('CostOfGoods');
	$PurchaseReturn = $objConfigure->getSettingVariable('ApReturn');
	$SalesTaxAccount = $objConfigure->getSettingVariable('SalesTaxAccount');
	$PostToGLDate = $objConfigure->GetOrderDate($PostedOrderID, 'PostedDate', 'p_order'); //Date
		 
	if(empty($AccountPayable) || empty($InventoryAP) || empty($FreightExpense)  || empty($CostOfGoods) ){
		// || empty($PurchaseReturn
		$ErrorMSGPostToGl  = SELECT_GL_AP_ALL;
	}	 	
	if($AccountPayable>0 && ($AccountPayable == $InventoryAP)){
		$ErrorMSGPostToGl  = SAME_GL_SELECTED_AP;
	}
	if(empty($ErrorMSGPostToGl)){ 		
		$arryPostData['AccountPayable'] = $AccountPayable;
		$arryPostData['InventoryAP'] = $InventoryAP;
		$arryPostData['FreightExpense'] = $FreightExpense;
		$arryPostData['CostOfGoods'] = $CostOfGoods;
		$arryPostData['PurchaseReturn'] = $PurchaseReturn;
		$arryPostData['SalesTaxAccount'] = $SalesTaxAccount;
		$arryPostData['PostToGLDate'] = $PostToGLDate;	
		$objTransaction->APCreditMemoPostToGL($PostedOrderID,$arryPostData); 
	}	
	
}
 
?>
