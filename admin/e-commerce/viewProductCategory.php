<?php 
	/**************************************************/
	$ThisPageName = 'viewProduct.php'; 
	/**************************************************/

	include_once("../includes/header.php");
	require_once($Prefix."classes/category.class.php");
	
	$objCategory=new category();
	$arryCategory=$objCategory->GetParentCategories(1);
	$num=$objCategory->numRows();
	  
	require_once("../includes/footer.php");
?>

