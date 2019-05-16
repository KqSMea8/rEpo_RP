<?php 
	include_once("../includes/header.php");
	require_once($Prefix."classes/sales.quote.order.class.php");
	$objSale = new sale();

	$RedirectURL = "viewCredit.php";
	$ModuleName = "RMA";
	if(!empty($_GET['so'])){
		$MainModuleName = "Returns for SO Number : ".$_GET['SaleID'];
		$RedirectURL = "viewCredit.php?so=".$_GET['SaleID'];
	}

	/*************************/
	$arryReturn=$objSale->ListCustCredit($_GET);
	$num=$objSale->numRows();

	$pagerLink=$objPager->getPager($arryReturn,$RecordsPerPage,$_GET['curP']);
	(count($arryReturn)>0)?($arryReturn=$objPager->getPageRecords()):("");
	/*************************/

  	//$ErrorMSG = UNDER_CONSTRUCTION; // Disable Temporarly

	require_once("../includes/footer.php"); 	
?>
