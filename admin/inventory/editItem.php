<?php

/* * *********************************************** */
$ThisPageName = 'viewItem.php';   $EditPage=1;
/* * *********************************************** */

// require_once("phpuploader/include_phpuploader.php");
require_once("../includes/header.php");
$Config['DepID'] = $CurrentDepID;

require_once($Prefix . "classes/item.class.php");
require_once($Prefix . "classes/inv_category.class.php");
require_once($Prefix . "classes/inv.condition.class.php");
require_once($Prefix . "classes/region.class.php");
require_once($Prefix . "classes/inv.class.php");
require_once($Prefix . "classes/drop_class.php");
require_once($Prefix . "classes/supplier.class.php");
require_once($Prefix . "classes/inv_tax.class.php");
require_once($Prefix . "classes/manufacturer.class.php");
require_once($Prefix . "classes/cartsettings.class.php");
require_once($Prefix."classes/function.class.php");
require_once($Prefix."classes/warehouse.class.php");
require_once($Prefix."classes/variant.class.php");
require_once($Prefix."classes/inv.condition.class.php");

$objvariant=new varient();
$objCommon = new common();
$objSupplier = new supplier();
$objTax = new tax();
$objDrop = new dropdown();
$objFunction = new functions();
$objRegion = new region();
$objCondition = new condition();
$objItem = new items();
$objRegion = new region();
$objManufacturer = new Manufacturer();
$objcartsettings = new Cartsettings();
$arryTaxClasses = $objcartsettings->getClasses();
$objCategory = new category();


$validate=$ButtonID=$ButtonTitle=$DisabledButton=$tabUrl=$WorkOrder='';

(empty($AllocatedQty))?($AllocatedQty=""):("");  
(empty($onHandQty))?($onHandQty=""):("");  
(empty($availableQty))?($availableQty=""):("");  
(empty($finalCost))?($finalCost="0"):("");  
(empty($lastPrice))?($lastPrice="0"):("");  
(empty($on_sale_order))?($on_sale_order="0"):("");  
(empty($RecievedQty))?($RecievedQty="0"):(""); 
(empty($OrderQty))?($OrderQty="0"):("");  

$listAllCategory = $objCategory->ListAllCategories();

 $ItemPurchaseTax = $objItem->getInvSettingVariable('Item_Purchase_Tax');

$ItemSaleTax = $objItem->getInvSettingVariable('Item_Sale_Tax');

$RedirectURL = "viewItem.php?curP=" . $_GET['curP'] . "";
/*$EditUrl = "editItem.php?edit=".$_GET["edit"]."&curP=".$_GET["curP"]."&tab="; 
$ActionUrl = $EditUrl.$_GET["tab"];*/
$ModuleName = "Item";


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


$MaxTotalImageC = $objItem->GetTotalImagesCount($_GET['edit']);
$MaxTotalImageCount = $MaxTotalImageC[0]['total'];
//exit;
if ($MaxTotalImageCount > 0) {
    $startImageCount = $MaxTotalImageCount + 1;
    $MaxProductImage = $MaxTotalImageCount + 3;
} else {
    $startImageCount = 1;
    $MaxProductImage = 3;
}


if ($_GET['edit'] != "") {
    $MaxProductImageArr = $objItem->GetAlternativeImage($_GET['edit']);
    $Sku = $objItem->GetItemSku($_GET['edit']);
}



if (!empty($_POST['CategoryID'])) {
    $categoryIdGetPost = $_POST['CategoryID'];
} else {
    $categoryIdGetPost = $_GET['CatID'];
}

$EditUrl = "editItem.php?edit=" . $_GET["edit"] . "&curP=" . $_GET["curP"] . "&CatID=" . $categoryIdGetPost . "&tab=";
if ($_GET["tab"] != "") {
    if ($_GET["tab"] == "editattributes" || $_GET["tab"] == "addattributes")
        $tabUrl = "viewattributes";
    elseif ($_GET["tab"] == "editDiscount")
        $tabUrl = "discount";
    else
        $tabUrl = $_GET["tab"];
}
$ActionUrl = $EditUrl . $tabUrl;


 
    $arryCategory = $objCategory->GetCategoriesListing(0, 0);
    $numCategory = $objCategory->numRows();




/* * *******  Multiple Actions To Perform ********* */
if (!empty($_GET['multiple_action_id'])) {
    $multiple_action_id = rtrim($_GET['multiple_action_id'], ",");
    $RedirectURLPage = "viewItem.php?curP=" . $_GET['curP'] . "&CatID=" . $_GET['dCatID'];
    switch ($_GET['multipleAction']) {
        case 'delete':
            $objItem->RemoveMultipleItem($multiple_action_id, 0);
            $_SESSION['mess_product'] = 'Item(s) ' . REMOVED;
            break;
        case 'active':
            $objItem->MultipleItemStatus($multiple_action_id, 1);
            $_SESSION['mess_product'] = 'Item(s) ' . ACTIVATED;
            break;
        case 'inactive':
            $objItem->MultipleItemStatus($multiple_action_id, 0);
            $_SESSION['mess_product'] = 'Item(s) ' . INACTIVATED;
            break;
    }
    header("location: " . $RedirectURLPage);
}

/* * *******  End Multiple Actions ********* */

if ($_GET['del_id'] && !empty($_GET['del_id'])) {
    $_SESSION['mess_product'] = 'Item(s) ' . REMOVED;
    $objItem->RemoveItem($_GET['del_id'], $_GET['CategoryID'], 0);
    header("location: " . $RedirectURL);
}

if(!empty($_GET['del_image'])){ 
		$_SESSION['mess_product'] = 'Item(s) ' . REMOVED;
		$objItem->deleteImage($_GET['edit'],$_GET['del_image']);
		header("Location:".$ActionUrl);
		exit;
	}


if ($_GET['MoveID'] && !empty($_GET['MoveID'])) {
    $_SESSION['mess_product'] = 'Item ' . REMOVED;
    $objItem->MoveItem($_GET['MoveID']);
    header("location: " . $RedirectURL);
}


if ($_GET['featured_id'] && !empty($_GET['featured_id'])) {

    $_SESSION['mess_product'] = 'Featured ' . STATUS;
    $objItem->changeFeaturedStatus($_GET['featured_id']);
    header("location: " . $RedirectURL);
    exit;
}

if ($_GET['active_id'] && !empty($_GET['active_id'])) {
    $_SESSION['mess_product'] = $ModuleName . STATUS;
    $objItem->changeItemStatus($_GET['active_id']);
    header("location: " . $RedirectURL);
    exit;
}



if (is_object($objItem)) {

    if ($_POST) {
		CleanPost();


	$_POST['Sku'] = strtoupper($_POST['Sku']);
	
        if (!empty($_POST['ItemID'])) {
            
            $ImageId = $_POST['ItemID'];
	$ItemsArray['ItemID'][] = $_POST['ItemID'];
            switch ($_GET['tab']) {
                case 'basic':
                    	$objItem->UpdateBasic($_POST);
		 $objItem->AddUpdateModelGen($ImageId,$_POST);
                   	$_SESSION['mess_product'] = UPDATE_BASIC;
                    	break;
                case 'Price':
		    	$objItem->PriceNotification($_POST);
                  
                    	$objItem->UpdatePrice($_POST);				   
                    	$_SESSION['mess_product'] = UPDATE_PRICE;
                    	break;
                case 'Supplier':
                    	$objItem->UpdateSuplier($_POST);
                    	$_SESSION['mess_product'] = UPDATE_SUPP;
                    	break;
                case 'Dimensions':
                    	$objItem->UpdateDimensions($_POST);
                    	$_SESSION['mess_product'] = UPDATE_DIMENSION;
                    	break;              
		case 'Quantity':
                    	$objItem->UpdateQuantity($_POST);
                    	$_SESSION['mess_product'] = UPDATE_QTY;
                    	break;
                case 'binlocation':		
			$objItem->AddItemBin($_POST);
			$_SESSION['mess_product'] = ADD_BIN;
			break;
                case 'model_genration':
		        $objItem->AddModelGen($_POST);
		        $_SESSION['mess_product'] = ADD_MODELGEN;
		        break;
		 case 'Required':
		        $objItem->AddUpdateRequiredItem($_POST['ItemID'],$_POST); 
		        $_SESSION['mess_product'] = UPDATE_RQUEIRED;
			
			 // for Company to Company Sync by karishma || 2 Dec 2015
		             if ($_SESSION['DefaultInventoryCompany'] == '1' ) {
		             		$Companys = $objCompany->SelectAutomaticSyncCompany();
		             		for($count=0;$count<count($Companys);$count++){
		             			$CmpID=$Companys[$count]['CmpID'];
		             			$objCompany->syncInventoryCompany($CmpID,$_POST['ItemID'],'required items');
		             			
		             		}
		             }
		             // end
		        break;
		case 'Alias':
if($_GET['del_id']>0){
			$_SESSION['mess_product'] = 'Item(s) ' . REMOVED;
			$objItem->RemoveItem($_GET['del_id'], $_GET['CategoryID'], 0);
			header("location: " . $RedirectURL);
exit;
}          
      $objItem->AddAliasItem($_POST);
			$_SESSION['mess_product'] = UPDATE_ALIAS;
		break;
		 case 'Component':
                        $objItem->UpdateShoworNoComponentItem($_POST); 
		        $_SESSION['mess_product'] = UPDATE_COMPONENT;
		  break;
		case 'Variant':
                        
		        $objItem->UpdateVariantItem($_POST); 
		        $_SESSION['mess_product'] = VARIANT_UPDATED;
		  break;
		case 'addattributes':
			$_POST['ProductID'] = $ImageId;
			 $PattID = $objItem->InsertAttributes($_POST);
			$_POST['PattID'] = $PattID;
			$objItem->AddUpdateGlobalAttOption('',$_POST);
			$_SESSION['mess_product'] = INSERT_ATTRIBUTES;
			break;
		case 'editattributes':
			$_POST['ProductID'] = $ImageId;
			$objItem->UpdateAttributes($_POST);
			$_POST['PattID'] = $_POST['AttributeId'];
			$objItem->AddUpdateGlobalAttOption('',$_POST);
			$_SESSION['mess_product'] = UPDATE_ATTRIBUTES;
			break;					 
            }

	/******************************/
	if ($_SESSION['sync_type'] == 'automatic') {
	$objItem->sync_items($ItemsArray);
	}

	/******************************/

// for Company to Company Sync by karishma || 2 Dec 2015
			if ($_SESSION['DefaultInventoryCompany'] == '1' && $_POST['is_exclusive']=='No') {
				$Companys = $objCompany->SelectAutomaticSyncCompany();
				for($count=0;$count<count($Companys);$count++){
					$CmpID=$Companys[$count]['CmpID'];
					
					$objCompany->syncInventoryCompany($CmpID,$_POST['ItemID'],'items');

				}
				
			} 
			// end
         	 
        } else {

            $_SESSION['mess_product'] = 'Product' . ADDED;
           
            $ImageId = $objItem->AddItem($_POST);
if(!empty($ImageId)){
$objItem->AddUpdateModelGen($ImageId,$_POST);
 // for Company to Company Sync by karishma || 2 Dec 2015 
            // if ($_SESSION['DefaultInventoryCompany'] == '1' && $_POST['is_exclusive']=='No') {
            
             if ($_SESSION['DefaultInventoryCompany'] == '1') {
             		$Companys = $objCompany->SelectAutomaticSyncCompany();
             		for($count=0;$count<count($Companys);$count++){
             			$CmpID=$Companys[$count]['CmpID'];
             			$objCompany->syncInventoryCompany($CmpID,$ImageId,'items');
             			
             		}
             }
             // end
}
             $_POST['ItemID'] = $ImageId;
	/********************Sync Item During added**********************/
	$ItemsArray['ItemID'][] = $ImageId;
	 if ($_SESSION['sync_type'] == 'automatic') {
	     $objItem->sync_items($ItemsArray);
	 }
	/*****************************************/
               /***********Insert Dimension***************/
		if(!empty($_POST['CopyItemID'])) {
		$objItem->UpdateDimensions($_POST);
		 $objItem->AddUpdateRequiredItem($_POST['ItemID'],$_POST); 
		}
		/*****************************/
        }
		
		

        /*****************************/
	/*****************************/
        if ($_FILES['Image']['name'] != '') {
        
	$FileInfoArray['FileType'] = "Image";
		$FileInfoArray['FileDir'] = $Config['Items'];
		$FileInfoArray['FileID'] = $_POST['Sku'];
		$FileInfoArray['OldFile'] = $_POST['OldImage'];
		$FileInfoArray['UpdateStorage'] = '1';
		$ResponseArray = $objFunction->UploadFile($_FILES['Image'], $FileInfoArray);
		if($ResponseArray['Success']=="1"){				 
			$objItem->UpdateImage($ResponseArray['FileName'], $ImageId);			
		}else{
			$ErrorMsg = $ResponseArray['ErrorMsg'];
		}

	if(!empty($ErrorMsg)){
		if(!empty($_SESSION['mess_product'])) $ErrorPrefix = '<br><br>';
		$_SESSION['mess_product'] .= $ErrorPrefix.$ErrorMsg;
	}
      }
      /*****************************/
      /*****************************/




               /*****************************/
		if ($_GET['tab'] == "alterimages") {

		for ($i = 1; $i <= $_POST['MaxProductImage']; $i++) {
		if ($_FILES['Image' . $i]['name'] != '') {
	
		$FileInfoArray['FileType'] = "Image";
		$FileInfoArray['FileDir'] = $Config['ItemsSecondary'];
		 $FileInfoArray['FileID'] = $Sku . "_" . $i;
		//$FileInfoArray['OldFile'] = $_POST['OldImage'];
		$alt_text = $_POST['alt_text' . $i];
		$FileInfoArray['UpdateStorage'] = '1';
		$ResponseArray = $objFunction->UploadFile($_FILES['Image'. $i], $FileInfoArray);
		//pr($ResponseArray);die;
		if($ResponseArray['Success']=="1"){				 
			#$objItem->UpdateImage($ResponseArray['FileName'], $ImageId);
			$objItem->UpdateAlternativeImage($ImageId, $ResponseArray['FileName'], $alt_text);			
		}else{
			$ErrorMsg = $ResponseArray['ErrorMsg'];
		}

		if(!empty($ErrorMsg)){
			if(!empty($_SESSION['mess_product'])) $ErrorPrefix = '<br><br>';
			 $_SESSION['mess_product'] .= $ErrorPrefix.$ErrorMsg;
			}
		}
	    }
	}

        /************************** */

        if (!empty($_GET['edit'])) {
            header("Location:" . $ActionUrl);
            exit;
        } else {
            $EditRedirectURL = "editItem.php?edit=" . $ImageId . "&curP=1&CatID=" . $_POST['CategoryID'] . "&tab=basic";
            header("Location:" . $EditRedirectURL);
            exit;
        }
    }
/**********Copy Item******************/
if(!empty($_GET['bc'])) {
	$arryProduct = $objItem->GetItemById($_GET['bc']);
	$ParentID = $arryProduct[0]['ParentID'];
	$SuppCode = $arryProduct[0]['SuppCode'];
	$arryProduct[0]['Sku'] ='';

	$EditableSku =1;	

}
/**********End Copy Item******************/
/**********Edit Item******************/
    if(!empty($_GET['edit'])) {
    //$arryProduct =array();
	$arryProduct = $objItem->GetItemById($_GET['edit']);
	$BomID = $objItem->GetBOMById($_GET['edit']);
	


	if($BomID>0){
		if($arryProduct[0]['GenOrder']>0 && !empty($arryProduct[0]['GenOrder'])){ $selt ="checked";}else{ $selt ="";}

		if($arryProduct[0]['ReorderLevel']!='' && !empty($arryProduct[0]['ReorderLevel'])){
		$OrderHide ='';
		}else{
		$OrderHide ='style="display:none;"';

		}
		$WorkOrder = '<tr id="gOrder" style="'.$OrderHide.'"><td valign="top" height="30" align="right"  class="blackbold">Generate Work Order :  </td><td valign="top" align="left">
		<input type="checkbox" '.$selt.' value="1" id="GenOrder" name="GenOrder" class="textbox">
		</td></tr>';

	}

if(isset($arryProduct[0])){
        $ParentID = $arryProduct[0]['ParentID'];
        $SuppCode = $arryProduct[0]['SuppCode'];
	if($arryProduct[0]['non_inventory']=='No'){
		$DisplayNone = 'style="display:none;"';
	}else{
		$DisplayNone = 'style="display:block;"';
	}
	}else{
	 $ParentID = 0;
        $SuppCode = '';
	
	}

	if($_GET['tab'] == 'basic' && !empty($arryProduct[0]['Sku'])){
		$EditableSku = 1;		
		if($objItem->isSkuTransactionExist($arryProduct[0]['Sku'])){
			$EditableSku = 0;
		}
		//echo $EditableSku;
$arryModGen = $objItem->GetModGen($arryProduct[0]['ItemID'],'');
		$class = '';
	    foreach ($arryModGen as $ModGen) {
	        $class .= $ModGen['model'] . ",";
	      //$Genclass .= $ModGen['genration'] . ",";
	       
	    }
             $Mod = rtrim($class, ",");


	}

/********************************/
if($_GET['tab'] == "viewattributes")
                 {
$AttributesArr = $objItem->GetProductAttributes($_GET['edit']); 
}
 if($_GET['attID'] != "")
                 {
                    $productAttribute = $objItem->GetAttributeByID($_GET['attID']);
		if($productAttribute[0]['gaid']>0){
		$arrayOptionList= $objItem->GetOptionList($productAttribute[0]['gaid']);
		

		}else{
		$arrayOptionList= $objItem->GetProductOptionList($_GET['attID']);
		}
		$NumLine = sizeof($arrayOptionList);
                 }
/********************************/

if(!empty($arryProduct[0]['ReorderLevel'])){
	$displayReorder = 'style="display:block;"';
	}else{
	$displayReorder = 'style="display:none;"';
	}



		if($_GET['tab'] == 'Alias'){
		 $arryAlias = $objItem->GetAliasbySku($arryProduct[0]['Sku']);
		 //$arryAlias = $objItem->GetAliasbyItemID($arryProduct[0]['ItemID']);
                $AliasNum=COUNT($arryAlias);
			if(!empty($_GET['del_alias'])){
				$_SESSION['mess_product'] = ALIAS_REMOVED;
				$objItem->RemoveAlias($_GET['del_alias'], $_GET['CategoryID'], 0);
                                $_SESSION['mess_product'] = ALIAS_REMOVED;
				header("location: editItem.php?edit=".$_GET['edit']."&CatID=".$_GET['CatID']."&tab=Alias");
			}
		}


        if ($ParentID > 0) {
            $CategoryID = $ParentID;
            if(isset($arryProduct[0])){
            $SubCategoryID = $arryProduct[0]['CategoryID'];
             }else{
            $SubCategoryID =0;
            
            }
        } else {
        if(isset($arryProduct[0])){
            $CategoryID = $arryProduct[0]['CategoryID'];
            }else{
            $CategoryID =0;
            
            }
        }

        $ItemID = $_GET['edit'];

/**********Purchase Order******************/
	/*if(!empty($arryProduct[0][Sku])){
		  $arryItemOrder=$objItem->GetPurchasedPriceItem($arryProduct[0]['Sku']);
		  $num=$objItem->numRows();
		  $pagerLink=$objPager->getPager($arryItemOrder,$RecordsPerPage,$_GET['curP']);
		  ( count($arryItemOrder)>0)?($arryItemOrder=$objPager->getPageRecords()):("");
$arryIAdjOrder=$objItem->GetAdjustmentPriceItem($arryProduct[0]['Sku']);
$num2=$objItem->numRows();

	}*/




/**********finish******************/
if($_GET['tab'] == 'binlocation'){
if(!empty($arryProduct[0]['Sku'])){
$arryWbin=$objItem->GetBinBySku($arryProduct[0]['Sku']);
//echo "<pre>";
//print_r($arryWbin);
}




if(!empty($_GET['delete_Sid']) && $_GET['delete_Sid']!='' ){
           $objItem->RemoveBinStock($_GET['delete_Sid']);
 $RedURL = "editItem.php?edit=" . $_GET['edit'] . "&curP=1&CatID=" . $_GET['CatID'] . "&tab=".$_GET['tab'];
 $_SESSION['mess_product'] = DEL_BIN;
            header("Location:" . $RedURL);
            exit;
}

$arryQtyCond=$objItem->GetConQtyForBin($arryProduct[0]['Sku'],$arryProduct[0]['ItemID'],$_GET['WID']);

}

/**********Sales Order******************/
/*if(!empty($arryProduct[0][Sku])){
	$arryItemOrder=$objItem->GetPurchasedPriceItem($arryProduct[0]['Sku']);	
	$num=$objItem->numRows();
	$pagerLink=$objPager->getPager($arryItemOrder,$RecordsPerPage,$_GET['curP']);
	( count($arryItemOrder)>0)?($arryItemOrder=$objPager->getPageRecords()):("");
}*/

/**********finish******************/
/*if($_GET['tab'] == 'model_genration'){
	$arryModelGen = $objItem->GetModelGen($_GET['edit']);
}*/


/**********finish******************/
/**********Item Quantity******************/
if($_GET['tab'] == 'Quantity' || $_GET['tab'] == 'Price'){



	/******Get Item Records***********/	
	$Config['RecordsPerPage'] = $RecordsPerPage;
	$arryItemOrder=$objItem->GetPurchasedPriceItem($arryProduct[0]['Sku'],$_GET['curP']);	
	/**********Count Records**************/	
	$Config['GetNumRecords'] = 1;
        $arryCount=$objItem->GetPurchasedPriceItem($arryProduct[0]['Sku'],$_GET['curP']);	
	$NumCount1 =$arryCount[0]['NumCount'];	
	$pagerLink=$objPager->getPaging($NumCount1,$RecordsPerPage,$_GET['curP']);	
	/*************************************/	


	
$arryIAdjOrder=$objItem->GetAdjustmentPriceItem($arryProduct[0]['Sku']);

if($_GET['Condition']!=''){

$Config['Condition'] = $_GET['Condition'];




	/********purchase Qty**************/
	$OrderQty=$objItem->GetOrderdedQty($arryProduct[0]['Sku']);
$OrderQty = $objItem->GetRecievedQty($arryProduct[0]['Sku']);
	$AdjQty=$objItem->GetAdjustmentQty($arryProduct[0]['Sku']);
	
	//$onHandQty = $arryProduct[0]['qty_on_hand'];
	/**********************/

	/**********************/
	$RecvedQtyCon=$objItem->getItemCondion($arryProduct[0]['Sku'],$_GET['Condition']);
	if(!empty($RecvedQtyCon[0]['condition_qty'])){	
		$RecievedQty=$RecvedQtyCon[0]['condition_qty'];


	/*******On Sales Order***************/
	$SaleOrderQty=$objItem->GetSaleOrderdedQty($arryProduct[0]['Sku']);
	 $on_sale_order=$SaleOrderQty[0]['sales_qty'];

$qtyInvoice=$SaleOrderQty[0]['qtyInvoice'];
$onHandQty=$OrderQty+$AdjQty-$qtyInvoice;
	/**********************/

	/**********Allocation Qty************/
	$AllocatedQty=$objItem->GetAssemblyQty($arryProduct[0]['Sku']);

	/**********************/
	$availableQty=$onHandQty-$on_sale_order-$AllocatedQty;
$onHandQty = $availableQty;






}else{
	$RecievedQty=0;
	

}
	/**********************/



$_POST['allocated_qty'] =$AllocatedQty;
$_POST['qty_on_hand']  =$onHandQty;
$_POST['qty_on_demand']=$arryProduct[0]['qty_on_demand'];
$_POST['ItemID'] = $arryProduct[0]['ItemID'];
$objItem->UpdateQuantity($_POST);


$onHandQty = $availableQty;


}
	/**********************/

}

/**********Item Price******************/
if($_GET['tab'] == 'Price'){



//$arryCost = $objItem->GetCostofGood($arryProduct[0]['Sku'],2);

if(!empty($_GET['Condition'])){

//added by chetan 10Feb//
$fprice = $objItem->getItemCondionQty($arryProduct[0]['Sku'],$_GET['Condition']);
if(!empty($fprice)) $arryProduct[0] = array_merge($arryProduct[0],$fprice[0]); 
//End//


if(!empty($arryCost)) {
	$finalCost = ($arryCost['CostOfGood']+$arryCost['LastCost']/2);
}
//$avgArr = $objItem->getAvgCostForSku($arryProduct[0]['Sku']);


if($arryProduct[0]['evaluationType'] =='LIFO'){

$_GET['LMT'] = 1;
$_GET['Ordr'] = 'ASC';
$_GET['Sku']  = $arryProduct[0]['Sku'];
$arryVendorPrice=$objItem->GetAvgTransPrice($arryProduct[0]['ItemID'],$_GET);
 //$arryVendorPrice[0]['price']."LIFO"; 
}else if($arryProduct[0]['evaluationType'] =='FIFO'){

$_GET['LMT'] = 1;
$_GET['Ordr'] = 'DESC';
$_GET['Sku']  = $arryProduct[0]['Sku'];
$arryVendorPrice=$objItem->GetAvgTransPrice($arryProduct[0]['ItemID'],$_GET);
 //$arryVendorPrice[0]['price']."FIFO"; 

}else{
$_GET['Sku']  = $arryProduct[0]['Sku'];
$arryVendorPrice=$objItem->GetAvgSerialPrice($arryProduct[0]['ItemID'],$_GET);

//if($_GET['Do']==1){ echo $arryVendorPrice[0]['price']."/".$arryVendorPrice[0]['total'];}

 //$arryVendorPrice[0]['price'] = $arryVendorPrice[0]['price']/$arryVendorPrice[0]['total'];
  
}

$avgCost = $arryVendorPrice[0]['price'];

$avgCost = number_format($avgCost,2);


$_GET['LMT'] = 1;
$_GET['Ordr'] = 'DESC';
$_GET['Sku']  = $arryProduct[0]['Sku'];
$arryLastPrice=$objItem->GetAvgTransPrice($arryProduct[0]['ItemID'],$_GET,'');

if(!empty($arryLastPrice[0]['price'])){
  $lastPrice =  number_format($arryLastPrice[0]['price'], 2);
}

#round($arryLastPrice[0]['price'],2);
$arryConPrice = $objItem->getItemCondionQty($arryProduct[0]['Sku'],$_GET['Condition']);

if(!empty($arryConPrice[0]['SalePrice'])){
	$arryProduct[0]['sell_price']  = $arryConPrice[0]['SalePrice'];
}


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
}else{

if($_SESSION['SelectOneItem'] != 0){
$finalCost = ($arryCost['CostOfGood']+$arryCost['LastCost']/2);
//$avgArr = $objItem->getAvgCostForSku($arryProduct[0]['Sku']);


if($arryProduct[0]['evaluationType'] =='LIFO'){

$_GET['LMT'] = 1;
$_GET['Ordr'] = 'DESC';
$_GET['Sku']  = $arryProduct[0]['Sku'];
$arryVendorPrice=$objItem->GetAvgTransPrice($arryProduct[0]['ItemID'],$_GET);
 //$arryVendorPrice[0]['price']."LIFO"; 
}else if($arryProduct[0]['evaluationType'] =='FIFO'){

$_GET['LMT'] = 1;
$_GET['Ordr'] = 'ASC';
$_GET['Sku']  = $arryProduct[0]['Sku'];
$arryVendorPrice=$objItem->GetAvgTransPrice($arryProduct[0]['ItemID'],$_GET);
 //$arryVendorPrice[0]['price']."FIFO"; 

}else{
$_GET['Sku']  = $arryProduct[0]['Sku'];
$arryVendorPrice=$objItem->GetAvgSerialPrice($arryProduct[0]['ItemID'],$_GET);

//if($_GET['Do']==1){ echo $arryVendorPrice[0]['price']."/".$arryVendorPrice[0]['total'];}

 //$arryVendorPrice[0]['price'] = $arryVendorPrice[0]['price']/$arryVendorPrice[0]['total'];
  
}

$avgCost = $arryVendorPrice[0]['price'];

//$avgCost = number_format($arryVendorPrice[0]['price'],2);


$_GET['LMT'] = 1;
$_GET['Ordr'] = 'DESC';
$_GET['Sku']  = $arryProduct[0]['Sku'];
$arryLastPrice=$objItem->GetAvgTransPrice($arryProduct[0]['ItemID'],$_GET);
$lastPrice =  number_format($arryLastPrice[0]['price'], 2, '.', '');
#round($arryLastPrice[0]['price'],2);
$arryConPrice = $objItem->getItemCondionQty($arryProduct[0]['Sku'],$_GET['Condition']);
#$arryProduct[0]['sell_price']  = $arryProduct[0]['sell_price'];

}else{
$arryProduct[0]['sell_price'] = '0.00';
 $lastPrice = '0.00';
$avgCost = '0.00';
}

}
}



/**********finish******************/

/**********Supplier Detail******************/
		if($_GET['tab'] == 'Supplier'){
			if(!empty($SuppCode)){
				$arrySupplier = $objSupplier->GetSupplier('', $SuppCode, 1);
			}

		 }
/**********finish******************/






    }
/**********Edit End******************/
if(isset($arryProduct[0])){
            if ($arryProduct[0]['Status'] != '') {
                $ProductStatus = $arryProduct[0]['Status'];
            } else {
                $ProductStatus = 1;
            }
          }else{
          
          $ProductStatus =1;
          
          }
}
/********** Master array for  drop down value ****************/
	$arryUnit = $objCommon->GetCrmAttribute('Unit', '');
	$arryProcurement = $objCommon->GetCrmAttribute('Procurement', '');
	if(isset($arryProduct[0])){
	$arryProduct[0]['procurement_method'] =$arryProduct[0]['procurement_method'];
	$arryProduct[0]['Model'] = $arryProduct[0]['Model'];
	$arryProduct[0]['Generation'] = $arryProduct[0]['Generation'];
	$arryProduct[0]['Condition'] = $arryProduct[0]['Condition'];
	}else{
	$arryProduct[0]['procurement_method'] ='';
	$arryProduct[0]['Model'] = '';
	$arryProduct[0]['Generation'] = '';
	$arryProduct[0]['Condition']='';
	}
	
	$dropList = $objDrop->multi_dropdown('procurement_method', $arryProcurement, 'attribute_value', 'attribute_value', $arryProduct[0]['procurement_method']);

$arryModel = $objCommon->GetCrmAttribute('Model', '');
#echo "===".$arryProduct[0]['Generation'];
$dropModel = $objDrop->multi_dropdown('Model', $arryModel, 'attribute_value', 'attribute_value', $arryProduct[0]['Model']);

$arryGeneration = $objCommon->GetCrmAttribute('Generation', '');
$dropGeneration = $objDrop->multi_dropdown('Generation', $arryGeneration, 'attribute_value', 'attribute_value', $arryProduct[0]['Generation']);

	$arryEvaluationType = $objCommon->GetCrmAttribute('EvaluationType', '');
	$arryItemType = $objCommon->GetCrmAttribute('ItemType', '');
	
	
	$arryCondition = $objCommon->GetCrmAttribute('Condition', '');
	$arryExtended = $objCommon->GetCrmAttribute('Extended', '');
	$arryManufacture = $objCommon->GetCrmAttribute('Manufacture', '');
        $arryReorder = $objCommon->GetCrmAttribute('Reorder', '');
$ConditionDrop  =$objCondition-> GetConditionDropValue($arryProduct[0]['Condition']);


if($_GET['tab']=='Variant'){

 	$GetVariantList=$objvariant->GetVariant('','');
        //echo '<pre>'; print_r($GetVariantList);die;
        $num = $objvariant->numRows();
        //echo $num;
        $pagerLink = $objPager->getPager($GetVariantList, $RecordsPerPage, $_GET['curP']);
        (count($GetVariantList) > 0) ? ($GetVariantList = $objPager->getPageRecords()) : ("");

$varient = explode(",",$arryProduct[0]['variant_id']);
//print_r($varient);


}
/********** Finish ****************/

// Tax Master
$arrySaleTax = $objTax->GetTaxRate('1');
$arryPurchaseTax = $objTax->GetTaxRate('2');
$arryModel = $objItem->GetModelGen('');
// Finish
$CategoryID = $categoryIdGetPost;
$_GET['key'] = 1;
$_GET['sortby'] = "w.Status";
$objWarehouse=new warehouse();
$arryWarehouse=$objWarehouse->ListWarehouse('',$_GET['key'],$_GET['sortby'],$_GET['asc'],'');

//$warehouse_listted = $objItem->ItemWarehouse($arryProduct[0]['warehouse']);
if($_GET['WID'] !=''){
	$arryBin=$objWarehouse->ListManageBin($_GET['WID'],$_GET['key'],$_GET['sortby'],$_GET['asc'],'');
}
#$listAllCondition =  $objCondition->ListAllCondition();
if($_GET['tab'] == 'addattributes'){
//attID
$NumLine =2;

}
//$objCondition=new condition();
$ConditionSelectedDrop  =$objCondition-> GetConditionDropValue($_GET["Condition"]);
//$arryCondQty=$objItem->getItemCondionQty($arryProduct[0]['Sku'],'');
require_once("../includes/footer.php");
?>
