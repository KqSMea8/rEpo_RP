<?php
include_once("includes/header.php");
require_once("classes/category.class.php");


 
$cat_title = 'Category';
$DelMessage = ALL_PRODUCT_AND_SUBCAT_DELETE;


$objCategory=new category();
$LevelCategory = 1;
 
if (is_object($objCategory)) {
	 
	//$arryCategoriesAndSubcategories=$objCategory->ListAllCategoriesAndSubcategories();
	$arryCategory=$objCategory->ListCategories($ParentID,$_GET['key'],$_GET['sortby'],$_GET['asc']);
	 
	$num=$objCategory->numRows();

	if($ParentID > 0){
		$LevelCategory = 2;

		$arrayParentCategory = $objCategory->GetCategoryNameByID($ParentID);
			
		$ParentCategory  = ' &raquo; '.stripslashes($arrayParentCategory[0]['Name']);

		if($arrayParentCategory[0]['ParentID']>0){
			$LevelCategory = 3;

			$BackParentID = $arrayParentCategory[0]['ParentID'];
			$arrayMainParentCategory = $objCategory->GetCategoryNameByID($arrayParentCategory[0]['ParentID']);
			$MainParentCategory  = ' &raquo; '.stripslashes($arrayMainParentCategory[0]['Name']);


			if($arrayMainParentCategory[0]['ParentID']>0){
				$LevelCategory = 4;
					
				$arrayMainRootParentCategory = $objCategory->GetCategoryNameByID($arrayMainParentCategory[0]['ParentID']);
				$MainParentCategory  = ' &raquo; '.stripslashes($arrayMainRootParentCategory[0]['Name']).$MainParentCategory;


				if($arrayMainRootParentCategory[0]['ParentID']>0){
					$LevelCategory = 5;

					$arrayLastParentCategory = $objCategory->GetCategoryNameByID($arrayMainRootParentCategory[0]['ParentID']);
					$MainParentCategory  = ' &raquo; '.stripslashes($arrayLastParentCategory[0]['Name']).$MainParentCategory;
				}



			}


		}
			
	}

}

require_once("includes/footer.php");

?>
