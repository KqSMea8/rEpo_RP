<?php 
 	include_once("includes/header.php");
	require_once("../classes/region.class.php");
	

	if (class_exists(region)) {
		$objRegion=new region();
	} else {
		echo "Class Not Found Error !! Region Class Not Found !";
		exit;
	}

	  if (is_object($objRegion)) {
		$arryRegion=$objRegion->ListCurrency('',$_GET['key'],$_GET['sortby'],$_GET['asc']);
		$num=$objRegion->numRows();
 	 }
	 
	 
	 require_once("includes/footer.php");
	 
?>



