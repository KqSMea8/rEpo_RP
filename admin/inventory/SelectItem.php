<?php 
	$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'viewItem.php'; 
	/**************************************************/
 	include_once("../includes/header.php");
	require_once($Prefix."classes/item.class.php");
	$objItem=new items();
 
	
	/******Get Item Records***********/	
	$_GET['Status'] = 1;
	$Config['RecordsPerPage'] = $RecordsPerPage;
	$arryProduct=$objItem->GetItemsView($_GET);	
	/**********Count Records**************/	
	$Config['GetNumRecords'] = 1;
        $arryCount=$objItem->GetItemsView($_GET);	
	$num=$arryCount[0]['NumCount'];	
	$pagerLink=$objPager->getPaging($num,$RecordsPerPage,$_GET['curP']);	
	/*************************************/		  

  	require_once("../includes/footer.php");
?>
