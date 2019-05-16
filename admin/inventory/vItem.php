<?php
	if(!empty($_GET['pop']))$HideNavigation = 1;	        
        /**************************************************/
	$ThisPageName = 'viewItem.php'; 
	/**************************************************/
	require_once("../includes/header.php");
	require_once($Prefix."classes/item.class.php");
	require_once($Prefix."classes/inv_category.class.php");
	require_once($Prefix."classes/region.class.php");
        require_once($Prefix."classes/inv_tax.class.php");
        require_once($Prefix."classes/supplier.class.php");
	require_once($Prefix . "classes/inv.condition.class.php");
	
	$objCondition = new condition();

	$objRegion=new region();
	$objTax=new tax();
	$objSupplier = new supplier();
	$objCategory=new category();
 	$objItem = new items();

	   $listAllCategory =  $objCategory->ListAllCategories();
	
	   $RedirectURL = "viewItem.php?curP=".$_GET['curP']."";
	
	$ModuleName  = "Item";
	$ButtonID=$ButtonTitle=$DisabledButton=$tabUrl='';
	$num2=0;
	$avgTotCost=0;
	$totalQty=0;
(empty($AllocatedQty))?($AllocatedQty=""):("");  
(empty($onHandQty))?($onHandQty=""):("");  
(empty($availableQty))?($availableQty=""):("");  
(empty($finalCost))?($finalCost="0"):("");  
(empty($lastPrice))?($lastPrice="0"):("");  
(empty($on_sale_order))?($on_sale_order="0"):("");  
(empty($RecievedQty))?($RecievedQty="0"):(""); 
(empty($OrderQty))?($OrderQty="0"):("");  



$arryDashboardIcon=$objConfigure->GetInventryMenuItems();
//echo "<pre>";print_r($arryDashboardIcon);
     foreach($arryDashboardIcon as $key=>$mainmenuvalues)
	  { 
	  	$arryMainmenuSection[$mainmenuvalues['Module']]=$mainmenuvalues['Status']; 
	  
	  }
     $arrySubmenu=$objConfigure->GetInventrySumMenuItems();
     
     foreach($arrySubmenu as $key=>$values)
	  { 
	  	$arrySection[$values['Link']]=$values['Status']; 
	  
	  }
        
$MaxTotalImageC = $objItem->GetTotalImagesCount($_GET['view']);
$MaxTotalImageCount = $MaxTotalImageC[0]['total'];
//exit;
if ($MaxTotalImageCount > 0) {
    $startImageCount = $MaxTotalImageCount + 1;
    $MaxProductImage = $MaxTotalImageCount + 3;
} else {
    $startImageCount = 1;
    $MaxProductImage = 3;
}


if ($_GET['view'] != "") {
    $MaxProductImageArr = $objItem->GetAlternativeImage($_GET['view']);
	
	
    $Sku = $objItem->GetItemSku($_GET['edit']);
}
       
             
                 $EditUrl = "vItem.php?view=".$_GET["view"]."&curP=".$_GET["curP"]."&CatID=".$_GET['CatID']."&tab="; 
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
				//$arryAlias = $objItem->GetAliasbyItemID($arryItem[0]['ItemID']);
				 $AliasNum=COUNT($arryAlias);
				
			}

if($_GET['tab'] == 'basic'){

$arryModGen = $objItem->GetModGen($arryItem[0]['ItemID'],'');
	$classtt ='';
 foreach ($arryModGen as $ModGen) {
                $classtt .= $ModGen['model'] . ",";
             
               
            }
             $Mod = rtrim($classtt, ",");
}

			//$ManufacturerName = $objManufacturer->getManufacturerByItemId($arryItem[0]['Mid']);
			
			if($ParentID > 0){
				$CategoryID	   = $ParentID;
				$SubCategoryID = $arryItem[0]['CategoryID'];
			}else{
				$CategoryID = $arryItem[0]['CategoryID'];
			}
			$ItemID   = $_GET['view'];

			if(!empty($arryItem[0]['Sku'])){
				$arryItemOrder=$objItem->GetPurchasedPriceItem($arryItem[0]['Sku']);
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

if($_GET['Condition']!='' ||  $_SESSION['SelectOneItem'] != 0){	 
$arryCost = $objItem->GetCostofGood($arryItem[0]['Sku'],2);


$finalCost = ($arryCost['CostOfGood']+$arryCost['LastCost']/2);
//$avgArr = $objItem->getAvgCostForSku($arryItem[0]['Sku']);


if($arryItem[0]['evaluationType'] =='LIFO'){

$_GET['LMT'] = 1;
$_GET['Ordr'] = 'DESC';
$_GET['Sku']  = $arryItem[0]['Sku'];
$arryVendorPrice=$objItem->GetAvgTransPrice($arryItem[0]['ItemID'],$_GET,'');
 //$arryVendorPrice[0]['price']."LIFO"; 
}else if($arryItem[0]['evaluationType'] =='FIFO'){

$_GET['LMT'] = 1;
$_GET['Ordr'] = 'ASC';
$_GET['Sku']  = $arryItem[0]['Sku'];
$arryVendorPrice=$objItem->GetAvgTransPrice($arryItem[0]['ItemID'],$_GET,'');
 //$arryVendorPrice[0]['price']."FIFO"; 

}else{
$_GET['Sku']  = $arryItem[0]['Sku'];
$arryVendorPrice=$objItem->GetAvgSerialPrice($arryItem[0]['ItemID'],$_GET);

//if($_GET['Do']==1){ echo $arryVendorPrice[0]['price']."/".$arryVendorPrice[0]['total'];}

 //$arryVendorPrice[0]['price'] = $arryVendorPrice[0]['price']/$arryVendorPrice[0]['total'];
  
}



$avgCost = (!empty($arryVendorPrice[0]['price']))?($arryVendorPrice[0]['price']):(0);


$_GET['LMT'] = 1;
$_GET['Ordr'] = 'DESC';
$_GET['Sku']  = $arryItem[0]['Sku'];
$arryLastPrice=$objItem->GetAvgTransPrice($arryItem[0]['ItemID'],$_GET,'');


  $lastPrice =  (!empty($arryLastPrice[0]['price']))?(number_format($arryLastPrice[0]['price'], 2)):(0);

//$lastPrice =$arryCost['LastCost'];
//$lastPrice =$arryCost['LastCost'];
//$lastPrice =$avgCost;

   /*if($arryItemOrder[0]['price']!=$arryItemOrder[1]['price']){
   
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
   }*/

$arryConPrice = $objItem->getItemCondionQty($arryItem[0]['Sku'],$_GET['Condition']);
//$arryItem[0]['sell_price']  = $arryConPrice[0]['SalePrice'];

if($_SESSION['SelectOneItem'] != 0){

$arryItem[0]['sell_price'] = $arryItem[0]['sell_price'];
}	else{


$arryItem[0]['sell_price']  = (!empty($arryConPrice[0]['SalePrice']))?($arryConPrice[0]['SalePrice']):(0);
}



}else{

$arryItem[0]['sell_price'] = '0.00';
 $lastPrice = '0.00';
$avgCost = '0.00';

}

}

}


if($_GET['tab'] == 'Quantity'){

if($_GET['Condition']!='' ||  $_SESSION['SelectOneItem'] != 0){

$Config['Condition'] = $_GET['Condition'];


	$OrderQty=$objItem->GetOrderdedQty($arryItem[0]['Sku']);
	$OrderQty = $objItem->GetRecievedQty($arryItem[0]['Sku']);
	$AdjQty=$objItem->GetAdjustmentQty($arryItem[0]['Sku']);
	
	//$onHandQty = $arryItem[0]['qty_on_hand'];
	/**********************/

	/**********************/

$RecvedQtyCon=$objItem->getItemCondion($arryItem[0]['Sku'],$_GET['Condition']);
	if(!empty($RecvedQtyCon[0]['condition_qty'])){
		$RecievedQty=$RecvedQtyCon[0]['condition_qty'];
	}

	/**********************/

	/*******On Sales Order***************/
		$SaleOrderQty=$objItem->GetSaleOrderdedQty($arryItem[0]['Sku']);
	$on_sale_order=$SaleOrderQty[0]['sales_qty'];
	$qtyInvoice=$SaleOrderQty[0]['qtyInvoice'];
	$onHandQty=$OrderQty+$AdjQty-$qtyInvoice;
	/**********************/

	/**********Allocation Qty************/
	$AllocatedQty=$objItem->GetAssemblyQty($arryItem[0]['Sku']);

	/**********************/
	$availableQty=$onHandQty-$on_sale_order-$AllocatedQty;
	$onHandQty = $availableQty;

$_POST['allocated_qty'] =$AllocatedQty;
$_POST['qty_on_hand']  =$onHandQty;
$_POST['qty_on_demand']=$arryItem[0]['qty_on_demand'];
$_POST['ItemID'] = $arryItem[0]['ItemID'];
//$objItem->UpdateQuantity($_POST);


$onHandQty = $availableQty;

$availableQty = $availableQty+$on_sale_order;
}
}




      		if($_GET['tab'] == 'Supplier' && !empty($SuppCode)){
                         $arrySupplier = $objSupplier->GetSupplier('',$SuppCode,1);
		
		 }		
		if($arryItem[0]['Status'] != ''){
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
	$arrySubmenu=$objConfigure->GetInventrySumMenuItems();
 foreach($arrySubmenu as $key=>$values)
	  { 
	  	$arrySection[$values['Link']]=$values['Status']; 
	  
	  }

$ConditionSelectedDrop  =$objCondition-> GetConditionDropValue($_GET["Condition"]);
	require_once("../includes/footer.php"); 
	
?>
