<?php 
	if(!empty($_GET['pop']))$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'viewAsset.php'; 
	/**************************************************/
	include_once("../includes/header.php");
	require_once($Prefix."classes/asset.class.php");
	require_once($Prefix."classes/vendor.class.php");
	$objAsset=new asset();
	$objVendor=new vendor();
	
	$ModuleName = "Asset";
	$SubHeading = "Asset Details";
	$RedirectURL = "viewAsset.php?curP=".$_GET['curP'];

	$EditUrl = "editAsset.php?edit=".$_GET["view"]."&curP=".$_GET["curP"]; 
	$ViewUrl = "vAsset.php?view=".$_GET["view"]."&curP=".$_GET["curP"]; 


	if (!empty($_GET['view'])) {
		$arryAsset = $objAsset->GetAsset($_GET['view'],'','');
		$PageHeading = 'Asset: '.stripslashes($arryAsset[0]['AssetName']);
		$AssetID   = $_REQUEST['view'];	
		if(empty($arryAsset[0]['AssetID'])){
			$ErrorMSG = ASSET_NOT_EXIST;
		}

	}else{
		header('location:'.$RedirectURL);
		exit;
	}

	#$arryCustomField = $objConfigure->CustomFieldList($CurrentDepID,'Asset','');	

	require_once("../includes/footer.php"); 	 
?>
