<?php 
	$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'viewAsset.php'; 
	/**************************************************/
	include_once("../includes/header.php");
	require_once($Prefix."classes/asset.class.php");

	require_once($Prefix."classes/vendor.class.php");
	$objAsset=new asset();
	$objVendor=new vendor();

	if (!empty($_GET['view'])) {
		$arryAsset = $objAsset->GetAsset('',$_GET['view'],'');
		$arryVendor = $objVendor->GetVendor($arryAsset[0]['Vendor'],'','');
		$AssetID   = $_GET['view'];	
		if(empty($arryAsset[0]['AssetID'])){
			$ErrorMSG = NOT_EXIST_SUPP;
		}
	}else{
		$ErrorMSG = INVALID_GET;
	}
	require_once("../includes/footer.php"); 	 
?>


