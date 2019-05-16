<?php 
	include_once("../includes/header.php");
	require_once($Prefix."classes/warehouse.rma.class.php");
	include_once("includes/FieldArray.php");
	$objWarehouserma = new warehouserma();

	$RedirectURL = "viewReturn.php";
	$ModuleName = "Return";
	if(!empty($_GET['so'])){
		$MainModuleName = "Returns for SO Number : ".$_GET['SaleID'];
		$RedirectURL = "viewSalesReturn.php?so=".$_GET['SaleID'];
		
		
	}
		

	/******Get RMA Records***********/	
	$Config['RecordsPerPage'] = $RecordsPerPage;
	$arryReturn=$objWarehouserma->ListReceiptRma($_GET);
	/**********Count Records**************/
	$Config['GetNumRecords'] = 1;
        $arryCount=$objWarehouserma->ListReceiptRma($_GET);
	$num=$arryCount[0]['NumCount'];	
	$pagerLink=$objPager->getPaging($num,$RecordsPerPage,$_GET['curP']);	
	/*************************************/	

	require_once("../includes/footer.php"); 	
?>


