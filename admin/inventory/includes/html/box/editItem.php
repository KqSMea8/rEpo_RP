<?php

/* * *********************************************** */
$ThisPageName = 'viewItem.php';
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



(!$_GET['curP']) ? ($_GET['curP'] = 1) : (""); // current page number
$objRegion = new region();
$objManufacturer = new Manufacturer();
$objcartsettings = new Cartsettings();
$arryTaxClasses = $objcartsettings->getClasses();

if (class_exists(category)) {
    $objCategory = new category();
} else {
    echo "Class Not Found Error !! Category Class Not Found !";
    exit;
}
$listAllCategory = $objCategory->ListAllCategories();


$RedirectURL = "viewItem.php?curP=" . $_GET['curP'] . "";

$ModuleName = "Item";

$objItem = new items();
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


if (class_exists(category)) {
    $objCategory = new category();
    $arryCategory = $objCategory->GetCategoriesListing(0, 0);
    $numCategory = $objCategory->numRows();
} else {
    echo "Class Not Found Error !! Category Class Not Found !";
    exit;
}



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
			$_SESSION['mess_product'] = 'Item(s) ' . REMOVED;
			$objItem->RemoveItem($_GET['del_id'], $_GET['CategoryID'], 0);
			header("location: " . $RedirectURL);           $objItem->AddAliasItem($_POST);
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
         $FileArray = $objFunction->CheckUploadedFile($_FILES['Image'],"Image");
          if(empty($FileArray['ErrorMsg'])){
            $ImageExtension = GetExtension($_FILES['Image']['name']);
            $imageName = $_POST['Sku'] . "." . $ImageExtension;
            $MainDir = "upload/items/images/".$_SESSION['CmpID']."/";						
	   if (!is_dir($MainDir)) {
		mkdir($MainDir);
		chmod($MainDir,0777);
	   }
	    $ImageDestination = $MainDir.$imageName;

	    if(!empty($_POST['OldImage']) && file_exists($_POST['OldImage'])){
		$OldImageSize = filesize($_POST['OldImage'])/1024; //KB
		unlink($_POST['OldImage']);		
	    }

            if (@move_uploaded_file($_FILES['Image']['tmp_name'],$ImageDestination)) {
                $objItem->UpdateImage($imageName, $ImageId);
		$objConfigure->UpdateStorage($ImageDestination,$OldImageSize,0);
            }
      }else{
	 $ErrorMsg = $FileArray['ErrorMsg'];
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
		$FileArray = $objFunction->CheckUploadedFile($_FILES['Image' . $i],"Image");
		if(empty($FileArray['ErrorMsg'])){
		$ImageExtension = GetExtension($_FILES['Image' . $i]['name']);
		$imageName = $Sku . "_" . $i . "." . $ImageExtension;
		$MainDir = "upload/items/images/secondary/".$_SESSION['CmpID']."/";

		if (!is_dir($MainDir)) {
			mkdir($MainDir);
			chmod($MainDir,0777);
		}
		//$MainDir = "upload/items/".$_SESSION['CmpID']."/"; 
		$ImageDestination = $MainDir.$imageName;  
		$alt_text = $_POST['alt_text' . $i];
		if (@move_uploaded_file($_FILES['Image' . $i]['tmp_name'], $ImageDestination)) {
		 $objItem->UpdateAlternativeImage($ImageId, $imageName, $alt_text);
		 $objConfigure->UpdateStorage($ImageDestination,0,0);
		}
		}else{
		 $ErrorMsg = $FileArray['ErrorMsg'];
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
if ($_GET['bc'] && !empty($_GET['bc'])) {
	$arryProduct = $objItem->GetItemById($_GET['bc']);
	$ParentID = $arryProduct[0]['ParentID'];
	$SuppCode = $arryProduct[0]['SuppCode'];
	$arryProduct[0]['Sku'] ='';

	$EditableSku =1;	

}
/**********End Copy Item******************/
/**********Edit Item******************/
    if ($_GET['edit'] && !empty($_GET['edit'])) {
	$arryProduct = $objItem->GetItemById($_GET['edit']);
        $ParentID = $arryProduct[0]['ParentID'];
        $SuppCode = $arryProduct[0]['SuppCode'];
	if($arryProduct[0]['non_inventory']=='No'){
	$DisplayNone = 'style="display:none;"';
	}else{
	$DisplayNone = 'style="display:block;"';
	}

	if($_GET['tab'] == 'basic' && !empty($arryProduct[0]['Sku'])){
		$EditableSku = 1;		
		if($objItem->isSkuTransactionExist($arryProduct[0]['Sku'])){
			$EditableSku = 0;
		}
		//echo $EditableSku;
$arryModGen = $objItem->GetModGen($arryProduct[0]['ItemID'],'');
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
			if($_GET['del_alias'] && !empty($_GET['del_alias'])){
				$_SESSION['mess_product'] = ALIAS_REMOVED;
				$objItem->RemoveAlias($_GET['del_alias'], $_GET['CategoryID'], 0);
                                $_SESSION['mess_product'] = ALIAS_REMOVED;
				header("location: editItem.php?edit=".$_GET['edit']."&CatID=".$_GET['CatID']."&tab=Alias");
			}
		}


        if ($ParentID > 0) {
            $CategoryID = $ParentID;
            $SubCategoryID = $arryProduct[0]['CategoryID'];
        } else {
            $CategoryID = $arryProduct[0]['CategoryID'];
        }

        $ItemID = $_GET['edit'];

/**********Purchase Order******************/
	if(!empty($arryProduct[0][Sku])){
		  $arryItemOrder=$objItem->GetPurchasedPriceItem($arryProduct[0]['Sku']);
		  $num=$objItem->numRows();
		  $pagerLink=$objPager->getPager($arryItemOrder,$RecordsPerPage,$_GET['curP']);
		  ( count($arryItemOrder)>0)?($arryItemOrder=$objPager->getPageRecords()):("");
	}

/**********finish******************/
if($_GET['tab'] == 'binlocation'){
if(!empty($arryProduct[0]['Sku'])){
$arryWbin=$objItem->GetBinBySku($arryProduct[0]['Sku']);

}
if(!empty($_GET['delete_Sid']) && $_GET['delete_Sid']!='' ){
           $objItem->RemoveBinStock($_GET['delete_Sid']);
 $RedURL = "editItem.php?edit=" . $_GET['edit'] . "&curP=1&CatID=" . $_GET['CatID'] . "&tab=".$_GET['tab'];
 $_SESSION['mess_product'] = DEL_BIN;
            header("Location:" . $RedURL);
            exit;
}

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

/**********Item Price******************/
if($_GET['tab'] == 'Price'){



$arryCost = $objItem->GetCostofGood($arryProduct[0]['Sku'],2);


$finalCost = ($arryCost['CostOfGood']+$arryCost['LastCost']/2);

$avgCost= $arryCost['CostOfGood'];
$lastPrice =$arryCost['LastCost'];

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
}
/**********finish******************/
/**********Item Quantity******************/
if($_GET['tab'] == 'Quantity'){
	/********purchase Qty**************/
	$OrderQty=$objItem->GetOrderdedQty($arryProduct[0][Sku]);
	$AdjQty=$objItem->GetAdjustmentQty($arryProduct[0][Sku]);
	//$onHandQty=$OrderQty+$AdjQty;
	$onHandQty = $arryProduct[0]['qty_on_hand'];
	/**********************/

	/**********************/
	$RecvedQty=$objItem->GetRecievedQty($arryProduct[0][Sku]);
	if($RecievedQty>0){	$RecievedQty=$RecvedQty;}else{$RecievedQty=0;}
	/**********************/

	/*******On Sales Order***************/
	$SaleOrderQty=$objItem->GetSaleOrderdedQty($arryProduct[0][Sku]);
	$on_sale_order=$SaleOrderQty;
	/**********************/

	/**********Allocation Qty************/
	$AllocatedQty=$objItem->GetAssemblyQty($arryProduct[0][Sku]);

	/**********************/
	$availableQty=$onHandQty-$on_sale_order-$AllocatedQty;


	/**********************/

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
            if ($arryProduct[0]['Status'] != '') {
                $ProductStatus = $arryProduct[0]['Status'];
            } else {
                $ProductStatus = 1;
            }
}
/********** Master array for  drop down value ****************/
	$arryUnit = $objCommon->GetCrmAttribute('Unit', '');
	$arryProcurement = $objCommon->GetCrmAttribute('Procurement', '');
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
$Conditionsel = explode(",",$arryProduct[0]['Condition']);
$ConditionDrop  =$objCondition-> GetConditionMultiDropValue($Conditionsel);


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
$arryWarehouse=$objWarehouse->ListWarehouse('',$_GET['key'],$_GET['sortby'],$_GET['asc']);

//$warehouse_listted = $objItem->ItemWarehouse($arryProduct[0]['warehouse']);
if($_GET['WID'] !=''){
$arryBin=$objWarehouse->ListManageBin($_GET['WID'],$_GET['key'],$_GET['sortby'],$_GET['asc']);
}
#$listAllCondition =  $objCondition->ListAllCondition();
if($_GET['tab'] == 'addattributes'){
//attID
$NumLine =2;

}
require_once("../includes/footer.php");
?>
