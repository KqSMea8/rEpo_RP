<?php 
 	include_once("includes/header.php");
	require_once("../classes/region.class.php");

	$objRegion=new region();
	(empty($_GET['country']))?($_GET['country']=1):(""); 

	if($_GET['country']>0){
		#$arryRegion=$objRegion->ListState('',$_GET['key'],$_GET['sortby'],$_GET['asc']);
		$arryRegion=$objRegion->getStateByCountry($_GET['country']);
		$num=$objRegion->numRows();
	}
	 
	$arryCountry = $objRegion->getCountry('','');		

	require_once("includes/footer.php");
?>
