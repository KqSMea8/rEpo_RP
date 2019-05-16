<?php 
	$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'viewPO.php?module=Order';
	/**************************************************/
	include_once("../includes/header.php");
	require_once($Prefix."classes/sales.quote.order.class.php");
	$ModuleName = "Sales";
	$objSale = new sale();

	$RedirectURL = "viewPO.php?module=Order";

	$EditURL = "editPO.php?module=Order";
	if($_GET['o']>0) $EditURL .= "&edit=".$_GET['o'];
	/*************************/
	


	/*********Get Sales*************/
	$_GET['Status'] = 'Open';
	$_GET['Approved'] = '1';	 
	$_GET['module'] = 'Order';
	$_GET['Droplist'] = '1';
	$_GET['list'] = '1';

	$Config['RecordsPerPage'] = $RecordsPerPage;
	$arrySale=$objSale->ListSale($_GET);
	/*******Count Records**********/
	$Config['GetNumRecords'] = 1;
        $arryCount=$objSale->ListSale($_GET);
	$num=$arryCount[0]['NumCount'];	
	if($Config['batchmgmt']==1){
		$num=count($arryCount);
	}
	$pagerLink=$objPager->getPaging($num,$RecordsPerPage,$_GET['curP']);
	/******************************/



	require_once("../includes/footer.php"); 	
?>


