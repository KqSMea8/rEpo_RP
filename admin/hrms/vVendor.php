<?php 
	if(!empty($_GET['pop']))$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'viewVendor.php'; 
	/**************************************************/
	include_once("../includes/header.php");
	require_once($Prefix."classes/vendor.class.php");


	$objVendor=new vendor();
	
	$ModuleName = "Vendor";
	$RedirectURL = "viewVendor.php?curP=".$_GET['curP'];
	if(empty($_GET['tab'])) $_GET['tab']="general";

	$EditUrl = "editVendor.php?edit=".$_GET["view"]."&curP=".$_GET["curP"]."&tab=".$_GET['tab']; 
	$ViewUrl = "vVendor.php?view=".$_GET["view"]."&curP=".$_GET["curP"]."&tab="; 


	if (!empty($_GET['view'])) {
		$arryVendor = $objVendor->GetVendor($_GET['view'],'','');
		$VendorID   = $_REQUEST['view'];	
		if(empty($arryVendor[0]['VendorID'])){
			$ErrorMSG = VENDOR_NOT_EXIST;
		}

	}else{
		header('location:'.$RedirectURL);
		exit;
	}



	#$arryCustomField = $objConfigure->CustomFieldList($CurrentDepID,'Vendor','');	

	

	require_once("../includes/footer.php"); 	 
?>


