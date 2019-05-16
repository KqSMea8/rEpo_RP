<?php 
	$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'viewAssignAsset.php'; 
	/**************************************************/

	include_once("../includes/header.php");
	require_once($Prefix."classes/asset.class.php");
	require_once($Prefix."classes/hrms.class.php");
	require_once($Prefix."classes/function.class.php");
	require_once($Prefix."classes/vendor.class.php");
	$objVendor=new vendor();
	$objFunction=new functions();
	$objCommon=new common();
	$objAsset=new asset();


	$_GET['AssignID'] = 1;
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


