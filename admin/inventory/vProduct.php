<?php
                /**************************************************/
	$ThisPageName = 'viewProduct.php'; 
	/**************************************************/
	require_once("../includes/header.php");
	require_once($Prefix."classes/product.class.php");
	require_once($Prefix."classes/category.class.php");
	require_once($Prefix."classes/region.class.php");
	require_once($Prefix."classes/manufacturer.class.php");

	(!$_GET['curP'])?($_GET['curP']=1):(""); // current page number
	$objRegion=new region();
	$objManufacturer = new Manufacturer();
	
	$arryManufacturer = $objManufacturer->getManufacturer('','',1);
	
         if (class_exists(category)) {
	  	$objCategory=new category();
	} else {
  		echo "Class Not Found Error !! Category Class Not Found !";
		exit;
  	}
	
	   $listAllCategory =  $objCategory->ListAllCategories();
	
	   $RedirectURL = "viewProduct.php?curP=".$_GET['curP']."";
	
	$ModuleName  = "Product";
	
	$objProduct=new product();
        
                    $MaxTotalImageCount = $objProduct->GetTotalImagesCount($_GET['view']);
                    if($MaxTotalImageCount > 0)
                    {   $startImageCount = $MaxTotalImageCount+1;
                         $MaxProductImage =$MaxTotalImageCount+3;
                    }
                else {
                                    $startImageCount =1;
                                    $MaxProductImage =3;
                    }
	  
           
               if($_GET['view'] != "")
                 {
                     $MaxProductImageArr = $objProduct->GetAlternativeImage($_GET['view']); 
                     $AttributesArr = $objProduct->GetProductAttributes($_GET['view']); 
                     $DiscountArr = $objProduct->GetProductDiscount($_GET['view']); 
                 }
                if($_GET['attID'] != "")
                 {
                    $productAttribute = $objProduct->GetAttributeByID($_GET['attID']);
                 }
                 
                if($_GET['disID'] != "")
                 {
                    $productDiscount = $objProduct->GetDiscountByID($_GET['disID']);
                 }
                 
             
                 $EditUrl = "vProduct.php?view=".$_GET["view"]."&curP=".$_GET["curP"]."&CatID=".$_GET['CatID']."&tab="; 
                 if($_GET["tab"] != "")
                 {
                     if($_GET["tab"] == "editattributes")
                     $tabUrl = "addattributes";
                     elseif($_GET["tab"] == "editDiscount")
                     $tabUrl = "discount";
                     else
                         $tabUrl = $_GET["tab"];
                 }
	$ActionUrl = $EditUrl.$tabUrl;
                  
	if (class_exists(category)) {
	  	$objCategory=new category();
		$arryCategory=$objCategory->GetCategoriesListing(0,0);
		$numCategory=$objCategory->numRows();
	} else {
  		echo "Class Not Found Error !! Category Class Not Found !";
		exit;
  	}



	
	 
	
	
	
 	if (is_object($objProduct)) {	
		
		if ($_GET['view'] && !empty($_GET['view'])) {
			$arryProduct = $objProduct->GetProducts($_GET['view'],0,0,0);
			$ParentID    = $arryProduct[0]['ParentID'];
			$ManufacturerName = $objManufacturer->getManufacturerByProductId($arryProduct[0]['Mid']);
			
			if($ParentID > 0){
				$CategoryID	   = $ParentID;
				$SubCategoryID = $arryProduct[0]['CategoryID'];
			}else{
				$CategoryID = $arryProduct[0]['CategoryID'];
			}
			$ProductID   = $_GET['view'];
		}
				
		if($arryProduct[0]['Status'] != ''){
			$ProductStatus = $arryProduct[0]['Status'];
		}else{
			$ProductStatus = 1;
		}
}
	
	
	
	//if(empty($arryMemberDetail[0]['currency_id'])) 
	//$arryMemberDetail[0]['currency_id']=9;
	//$arryCurrency = $objRegion->getCurrency($arryMemberDetail[0]['currency_id'],'');
	//$StoreCurrency = $arryCurrency[0]['symbol_left'].$arryCurrency[0]['symbol_right'];


	
	$CategoryID = $_GET['CatID'];
	
	require_once("../includes/footer.php"); 
	
?>
