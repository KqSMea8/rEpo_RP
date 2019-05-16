<?php
     /**************************************************/
	$ThisPageName = 'viewItem.php'; $HideNavigation = 1;
	/**************************************************/
	require_once("../includes/header.php");
	require_once($Prefix."classes/item.class.php");
	require_once($Prefix."classes/category.class.php");
	require_once($Prefix."classes/region.class.php");
        require_once($Prefix."classes/inv_tax.class.php");
	

	(!$_GET['curP'])?($_GET['curP']=1):(""); // current page number
        
	$objRegion=new region();
        	$objTax=new tax();
	
	
         if (class_exists(category)) {
	  	$objCategory=new category();
	} else {
  		echo "Class Not Found Error !! Category Class Not Found !";
		exit;
  	}
	
	   $listAllCategory =  $objCategory->ListAllCategories();
	
	   $RedirectURL = "viewItem.php?curP=".$_GET['curP']."";
	
	$ModuleName  = "Item";
	
	$objItem=new items();
        
                   /* $MaxTotalImageCount = $objItem->GetTotalImagesCount($_GET['view']);
                    if($MaxTotalImageCount > 0)
                    {   $startImageCount = $MaxTotalImageCount+1;
                         $MaxItemImage =$MaxTotalImageCount+3;
                    }
                else {
                                    $startImageCount =1;
                                    $MaxItemImage =3;
                    }*/
	  
           
               /* if($_GET['view'] != "")
                 {
                     $MaxItemImageArr = $objItem->GetAlternativeImage($_GET['view']); 
                     $AttributesArr = $objItem->GetItemAttributes($_GET['view']); 
                     $DiscountArr = $objItem->GetItemDiscount($_GET['view']); 
                 }
                if($_GET['attID'] != "")
                 {
                    $itemAttribute = $objItem->GetAttributeByID($_GET['attID']);
                 }
                 
                if($_GET['disID'] != "")
                 {
                    $itemDiscount = $objItem->GetDiscountByID($_GET['disID']);
                 }
                 */
             
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
                  
	if (class_exists(category)) {
	  	$objCategory=new category();
		$arryCategory=$objCategory->GetCategoriesListing(0,0);
		$numCategory=$objCategory->numRows();
	} else {
  		echo "Class Not Found Error !! Category Class Not Found !";
		exit;
  	}



	
	 
	
	
	
 	if (is_object($objItem)) {	
		
		if ($_GET['view'] && !empty($_GET['view'])) {
			$arryItem = $objItem->GetItemById($_GET['view']);
                       
                        
			$ParentID    = $arryItem[0]['ParentID'];
			//$ManufacturerName = $objManufacturer->getManufacturerByItemId($arryItem[0]['Mid']);
			
			if($ParentID > 0){
				$CategoryID	   = $ParentID;
				$SubCategoryID = $arryItem[0]['CategoryID'];
			}else{
				$CategoryID = $arryItem[0]['CategoryID'];
			}
			$ItemID   = $_GET['view'];
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
	
	require_once("../includes/footer.php"); 
	
?>
