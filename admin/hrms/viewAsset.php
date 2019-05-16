<?php 
	include_once("../includes/header.php");
	require_once($Prefix."classes/asset.class.php");
	require_once($Prefix."classes/vendor.class.php");
	include_once("includes/FieldArray.php");
	$objAsset=new asset();
	$objVendor=new vendor();
    	$ModuleName = "Asset";


	/******Get Asset Records***********/	
	$Config['RecordsPerPage'] = $RecordsPerPage;
	$arryAsset=$objAsset->ListAsset($_GET);
	/**********Count Records**************/	
	$Config['GetNumRecords'] = 1;
        $arryCount=$objAsset->ListAsset($_GET);
	$num=$arryCount[0]['NumCount'];	
	$pagerLink=$objPager->getPaging($num,$RecordsPerPage,$_GET['curP']);	
	/*************************************/	
 
	require_once("../includes/footer.php"); 	
?>


