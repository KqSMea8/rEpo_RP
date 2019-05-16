<? 
$AutoPostToGl = $objConfigure->getSettingVariable('AutoPostToGlArCredit');
//$AutoPostToGl = 0; //comment this
if($AutoPostToGl=="1" && $Approved=="1" && $PostedOrderID>0){ 
	unset($arryPostData);
	$AccountReceivable = $objConfigure->getSettingVariable('AccountReceivable');
	$InventoryAR = $objConfigure->getSettingVariable('InventoryAR');
	$FreightAR = $objConfigure->getSettingVariable('FreightAR');
	$SalesReturn = $objConfigure->getSettingVariable('ArReturn');
	$CostOfGoods = $objConfigure->getSettingVariable('CostOfGoods');
	$SalesTaxAccount = $objConfigure->getSettingVariable('SalesTaxAccount');
	$PostToGLDate = $objConfigure->GetOrderDate($PostedOrderID, 'PostedDate', 's_order');	
	 
	if(empty($AccountReceivable) || empty($InventoryAR) || empty($FreightAR) || empty($SalesReturn) || empty($CostOfGoods) || empty($SalesTaxAccount)) {
		$ErrorMSGPostToGl = SELECT_GL_AR_ALL;
	}
	if($AccountReceivable > 0 && $AccountReceivable == $SalesReturn) {
		$ErrorMSGPostToGl = SAME_GL_SELECTED_AR;
	}
	
	if(empty($ErrorMSGPostToGl)){ 
		if(empty($arryCompany[0]['Department']) || in_array("12",$arryCmpDepartment)){
			$arryPostData['PosFlag'] = 1;		 
		}

		$arryPostData['AccountReceivable'] = $AccountReceivable;
		$arryPostData['InventoryAR'] = $InventoryAR;
		$arryPostData['FreightAR'] = $FreightAR;
		$arryPostData['SalesReturn'] = $SalesReturn;
		$arryPostData['CostOfGoods'] = $CostOfGoods;
		$arryPostData['SalesTaxAccount'] = $SalesTaxAccount;
		$arryPostData['PostToGLDate'] = $PostToGLDate;	
		$objTransaction->ARCreditMemoPostToGL($PostedOrderID, $arryPostData); 
	}
	
} 
?>
