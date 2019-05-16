<?php 
 	include_once("includes/header.php");
	require_once("../classes/region.class.php");

	$objRegion=new region();
	(empty($_GET['ch']))?($_GET['ch']='A'):(""); 

	$_GET['key'] = $_GET['ch'];
	$arryRegion=$objRegion->ListCountry('',$_GET['key'],$_GET['sortby'],$_GET['asc']);
	$num=$objRegion->numRows();
	 
	 require_once("includes/footer.php");	 
?>


