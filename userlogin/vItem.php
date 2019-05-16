<?php
                /**************************************************/
	$ThisPageName = 'viewItem.php'; 
	/**************************************************/
	require_once("includes/header.php");
	require_once($Prefix."classes/item.class.php");
	require_once($Prefix."classes/inv_category.class.php");
	require_once($Prefix."classes/region.class.php");
        require_once($Prefix."classes/inv_tax.class.php");
        require_once($Prefix."classes/supplier.class.php");
		
        
	$objRegion=new region();
	$objTax=new tax();
	$objSupplier = new supplier();
	$objCategory=new category();	         
	
	$listAllCategory =  $objCategory->ListAllCategories();

	(empty($_GET['CatID']))?($_GET['CatID']=""):(""); 

	$RedirectURL = "viewItem.php?curP=".$_GET['curP']."";

	$ModuleName  = "Item";

	$objItem=new items();
        
	$MaxTotalImageC = $objItem->GetTotalImagesCount($_GET['view']);
	$MaxTotalImageCount = $MaxTotalImageC[0]['total'];
 
	if($MaxTotalImageCount > 0){
	    $startImageCount = $MaxTotalImageCount + 1;
	    $MaxProductImage = $MaxTotalImageCount + 3;
	}else{
	    $startImageCount = 1;
	    $MaxProductImage = 3;
	}


if ($_GET['view'] != "") {
    $MaxProductImageArr = $objItem->GetAlternativeImage($_GET['view']);
	
	
    $Sku = $objItem->GetItemSku($_GET['edit']);
}
       
             
                 $EditUrl = "vItem.php?view=".$_GET["view"]."&curP=".$_GET["curP"]."&CatID=".$_GET['CatID']."&tab="; 
		
		$tabUrl = '';
                /* if($_GET["tab"] != "")
                 {
                     if($_GET["tab"] == "editattributes")
                     $tabUrl = "addattributes";
                     elseif($_GET["tab"] == "editDiscount")
                     $tabUrl = "discount";
                     else
                         $tabUrl = $_GET["tab"];
                 }*/
	$ActionUrl = $EditUrl.$tabUrl;
                  
	 
	  	 
		$arryCategory=$objCategory->GetCategoriesListing(0,0);
		$numCategory=$objCategory->numRows();
	 


	
 	if (is_object($objItem)) {	
		
		if ($_GET['view'] && !empty($_GET['view'])) {
			$arryItem = $objItem->GetItemById($_GET['view']);
                       
                        $arryModel = $objItem->GetModel($arryItem[0]['Model']);

		        $ParentID    = $arryItem[0]['ParentID'];
                        $SuppCode  = $arryItem[0]['SuppCode'];
			if($_GET['tab'] == 'Alias'){
				$arryAlias = $objItem->GetAliasbySku($arryItem[0]['Sku']);
				 $AliasNum=COUNT($arryAlias);
				
			}

			//$ManufacturerName = $objManufacturer->getManufacturerByItemId($arryItem[0]['Mid']);
			
			if($ParentID > 0){
				$CategoryID	   = $ParentID;
				$SubCategoryID = $arryItem[0]['CategoryID'];
			}else{
				$CategoryID = $arryItem[0]['CategoryID'];
			}
			$ItemID   = $_GET['view'];

			if(!empty($arryItem[0]["Sku"])){
				$arryItemOrder=$objItem->GetPurchasedPriceItem($arryItem[0]["Sku"]);
				$num=$objItem->numRows();
 
				$pagerLink=$objPager->getPager($arryItemOrder,$RecordsPerPage,$_GET['curP']);
				( count($arryItemOrder)>0)?($arryItemOrder=$objPager->getPageRecords()):("");
			}


if($_GET['tab'] == 'binlocation'){
if(!empty($arryItem[0]['Sku'])){


$arryWbin=$objItem->GetBinBySku($arryItem[0]['Sku']);

}


}	
if($_GET['tab'] == 'Price'){
if($arryItemOrder[0]['price']!=$arryItemOrder[1]['price']){

$finalCost= ($arryItemOrder[0]['price']+$arryItemOrder[1]['price'])/2;
	if($arryItemOrder[0]['Currency']!=$Config['Currency']){
		$avgCost= CurrencyConvertor($finalCost,$arryItemOrder[0]['Currency'],$Config['Currency']);
		$lastPrice= CurrencyConvertor($arryItemOrder[0]['price'],$arryItemOrder[0]['Currency'],$Config['Currency']);
	}else{
		$avgCost=$finalCost;
		$lastPrice=$arryItemOrder[0]['price'];
	}
   } else{
		$finalCost=$arryItemOrder[0]['price'];
		if($arryItemOrder[0]['Currency']!=$Config['Currency']){
		$avgCost= CurrencyConvertor($finalCost,$arryItemOrder[0]['Currency'],$Config['Currency']);
		$lastPrice= CurrencyConvertor($finalCost,$arryItemOrder[0]['Currency'],$Config['Currency']);
		}else{
		$avgCost=$finalCost;
		$lastPrice=$finalCost;
		
		}
   }

}
if($_GET['tab'] == 'Quantity'){
        /********purchase Qty**************/
		$OrderQty=$objItem->GetOrderdedQty($arryItem[0][Sku]);
		$AdjQty=$objItem->GetAdjustmentQty($arryItem[0][Sku]);
		$onHandQty=$OrderQty+$AdjQty;
		/**********************/
		
		/**********************/
		$RecvedQty=$objItem->GetRecievedQty($arryItem[0][Sku]);
		if($RecievedQty>0){	$RecievedQty=$RecvedQty;}else{$RecievedQty=0;}
		/**********************/
		
		/*******On Sales Order***************/
		$SaleOrderQty=$objItem->GetSaleOrderdedQty($arryItem[0][Sku]);
		$on_sale_order=$SaleOrderQty;
		/**********************/
		
		/**********Allocation Qty************/
		$AllocatedQty=$objItem->GetAssemblyQty($arryItem[0][Sku]);
		
		/**********************/
		$availableQty=$onHandQty-$on_sale_order-$AllocatedQty;
		
		
		/**********************/	  
                  }
}
      if($_GET['tab'] == 'Supplier'){
                         $arrySupplier = $objSupplier->GetSupplier('',$SuppCode,1);
		
		 }		
		if(!empty($arryItem[0]['Status'])){
			$ItemStatus = $arryItem[0]['Status'];
		}else{
			$ItemStatus = 1;
		}



}
	
	
	
	//if(empty($arryMemberDetail[0]['currency_id'])) 
	//$arryMemberDetail[0]['currency_id']=9;
	//$arryCurrency = $objRegion->getCurrency($arryMemberDetail[0]['currency_id'],'');
	//$StoreCurrency = $arryCurrency[0]['symbol_left'].$arryCurrency[0]['symbol_right'];

        $arrySaleTax = $objTax->GetTaxRate('1');
	$arryPurchaseTax = $objTax->GetTaxRate('2');
	
	$CategoryID = $_GET['CatID'];
	
	require_once("includes/footer.php"); 
	
?>
