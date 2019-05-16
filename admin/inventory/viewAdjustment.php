<?php 
 	include_once("../includes/header.php");
	require_once($Prefix."classes/item.class.php");
	require_once($Prefix."classes/category.class.php");
			include_once("includes/FieldArray.php");
	$objItem=new items();
	$objCategory=new category();

	/******Get Adjustment Records***********/	
	$Config['RecordsPerPage'] = $RecordsPerPage;
	$arryAdjustment = $objItem->ListingAdjustment('',$_GET['key'],$_GET['sortby'],$_GET['asc'],$_GET['Status'],$_GET['FromDate'],$_GET['ToDate']);
	/**********Count Records**************/	
	$Config['GetNumRecords'] = 1;
        $arryCount=$objItem->ListingAdjustment('',$_GET['key'],$_GET['sortby'],$_GET['asc'],$_GET['Status'],$_GET['FromDate'],$_GET['ToDate']);
	$num=$arryCount[0]['NumCount'];	
	$pagerLink=$objPager->getPaging($num,$RecordsPerPage,$_GET['curP']);	
	/*************************/	
	
		  

  require_once("../includes/footer.php");

?>
