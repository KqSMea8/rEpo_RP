<?
$AutoPostToGl = $objConfigure->getSettingVariable('AutoPostToGlAr');


if($AutoPostToGl=="1" && $PostedOrderID>0){ //PostedOrderID
	unset($arryPostData);
	$AccountReceivable = $objConfigure->getSettingVariable('AccountReceivable');
	$InventoryAR = $objConfigure->getSettingVariable('InventoryAR');
	$SalesAccount = $objConfigure->getSettingVariable('Sales');
	$CostOfGoods = $objConfigure->getSettingVariable('CostOfGoods');
	$FreightAR = $objConfigure->getSettingVariable('FreightAR');
	$SalesTaxAccount = $objConfigure->getSettingVariable('SalesTaxAccount');
	$PostToGLDate = $objConfigure->GetOrderDate($PostedOrderID, 'InvoiceDate', 's_order'); //Date

	if(empty($AccountReceivable) || empty($InventoryAR) || empty($SalesAccount) || empty($CostOfGoods)){
			$ErrorMSGPostToGl  = SELECT_GL_AR_ALL;
	}
	if($AccountReceivable>0 && $AccountReceivable == $SalesAccount){
		$ErrorMSGPostToGl  = SAME_GL_SELECTED_AR;
	}

	if(empty($ErrorMSGPostToGl)){ 		
		if(empty($arryCompany[0]['Department']) || in_array("2",$arryCmpDepartment)){
			$arryPostData['EcommFlag'] = 1;		 
		}
		if(empty($arryCompany[0]['Department']) || in_array("12",$arryCmpDepartment)){
			$arryPostData['PosFlag'] = 1;		 
		}
		$arryPostData['HostbillActive'] = $objConfig->isHostbillActive();
		
		$arryPostData['AccountReceivable'] = $AccountReceivable;
		$arryPostData['InventoryAR'] = $InventoryAR;
		$arryPostData['FreightAR'] = $FreightAR;
		$arryPostData['SalesAccount'] = $SalesAccount;
		$arryPostData['CostOfGoods'] = $CostOfGoods;		 
		$arryPostData['SalesTaxAccount'] = $SalesTaxAccount;	
		$arryPostData['ShippingCareerVal'] = $arryCompany[0]['ShippingCareerVal'];

		$arryPostData['PostToGLDate'] = $PostToGLDate;

		 
		$objReport->SoInvoicePostToGL($PostedOrderID,$arryPostData);	 
	}	
	
}
 
?>
