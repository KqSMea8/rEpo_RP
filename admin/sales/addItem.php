<?php

/* * *********************************************** */
$ThisPageName = 'editSalesQuoteOrder.php'; $EditPage = 1; $HideNavigation = 1;
/* * *********************************************** */

// require_once("phpuploader/include_phpuploader.php");
require_once("../includes/header.php");
$Config['DepID'] = $CurrentDepID;

require_once($Prefix . "classes/item.class.php");
require_once($Prefix . "classes/inv_category.class.php");
require_once($Prefix . "classes/region.class.php");
require_once($Prefix . "classes/inv.class.php");
require_once($Prefix . "classes/drop_class.php");
require_once($Prefix . "classes/supplier.class.php");
require_once($Prefix . "classes/inv_tax.class.php");
require_once($Prefix . "classes/manufacturer.class.php");
require_once($Prefix . "classes/cartsettings.class.php");

$objCommon = new common();
$objSupplier = new supplier();
$objTax = new tax();
$objDrop = new dropdown();



 
$objRegion = new region();
$objManufacturer = new Manufacturer();
$objcartsettings = new Cartsettings();
$arryTaxClasses = $objcartsettings->getClasses();

$objCategory = new category();


(empty($_GET["Sku"]))?($_GET["Sku"]=""):("");
(empty($_GET["ParentID"]))?($_GET["ParentID"]=""):("");
(empty($_GET["ParentID"]))?($_GET["ParentID"]=""):("");
(empty($_GET["selectid"]))?($_GET["selectid"]=""):("");


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






if (!empty($_POST['CategoryID'])) {
    $categoryIdGetPost = $_POST['CategoryID'];
} else {
    $categoryIdGetPost = (!empty($_GET['CatID']))?($_GET['CatID']):('');
}



 
    $objCategory = new category();
    $arryCategory = $objCategory->GetCategoriesListing(0, 0);
    $numCategory = $objCategory->numRows();
 








 

    if ($_POST) {
       
		$ImageId = $objItem->AddItem($_POST);

		$_SESSION['mess_product'] = 'Product' . ADDED;

		echo '<script>window.parent.location.href="'.$RedirectURL.'";</script>';

		exit;
        }
   



            
        $ProductStatus = 1;
            

$arryUnit = $objCommon->GetCrmAttribute('Unit', '');
$arryProcurement = $objCommon->GetCrmAttribute('Procurement', '');


$dropList = $objDrop->multi_dropdown('procurement_method', $arryProcurement, 'attribute_value', 'attribute_value', ''); //$arryProduct[0]['procurement_method']

$arryEvaluationType = $objCommon->GetCrmAttribute('EvaluationType', '');
$arryItemType = $objCommon->GetCrmAttribute('ItemType', '');

$arrySaleTax = $objTax->GetTaxRate(1);
$ItemSaleTax = $objItem->getInvSettingVariable('Item_Sale_Tax');
$arryPurchaseTax = $objTax->GetTaxRate('2');

$CategoryID = $categoryIdGetPost;


if(empty($arryProduct)){
	$arryProduct = $objConfigure->GetDefaultArrayValue('inv_items');
}



require_once("../includes/footer.php");
?>
