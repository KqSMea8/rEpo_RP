<?php

/* * *********************************************** */
$ThisPageName = 'viewItem.php'; $EditPage = 1; $HideNavigation = 1;
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



$objCategory = new category();
$objRegion = new region();
$objManufacturer = new Manufacturer();
$objcartsettings = new Cartsettings();
$arryTaxClasses = $objcartsettings->getClasses();

 
$listAllCategory = $objCategory->ListAllCategories();


$RedirectURL = "viewItem.php?curP=" . $_GET['curP'] . "";

$ModuleName = "Item";

$objItem = new items();

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
    $categoryIdGetPost = $_GET['CatID'];
}



 
   
    $arryCategory = $objCategory->GetCategoriesListing(0, 0);
    $numCategory = $objCategory->numRows();
 








 

    if ($_POST) {
		CleanPost();
       
       //$ImageId = $objItem->AddItem($_POST);
        
            $_SESSION['mess_product'] = 'Product' . ADDED;
         
		 //echo '<script>window.parent.location.href="'.$RedirectURL.'";</script>';
           
            //exit;
        }
   



            if ($arryProduct[0]['Status'] != '') {
                $ProductStatus = $arryProduct[0]['Status'];
            } else {
                $ProductStatus = 1;
            }

$arryUnit = $objCommon->GetCrmAttribute('Unit', '');
$arryProcurement = $objCommon->GetCrmAttribute('Procurement', '');


$dropList = $objDrop->multi_dropdown('procurement_method', $arryProcurement, 'attribute_value', 'attribute_value', $arryProduct[0]['procurement_method']);

$arryEvaluationType = $objCommon->GetCrmAttribute('EvaluationType', '');
$arryItemType = $objCommon->GetCrmAttribute('ItemType', '');

$arrySaleTax = $objTax->GetTaxRate(1);
$arryPurchaseTax = $objTax->GetTaxRate('2');

$CategoryID = $categoryIdGetPost;

require_once("../includes/footer.php");
?>
