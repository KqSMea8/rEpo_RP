<?php 
	include_once("../includes/header.php");
	require_once($Prefix."classes/sales.quote.order.class.php");
	include_once("includes/FieldArray.php");
	$objSale = new sale();

	$RedirectURL = "viewReturn.php";
	$ModuleName = "Return";
	if(!empty($_GET['so'])){
		$MainModuleName = "Returns for SO Number : ".$_GET['SaleID'];
		$RedirectURL = "viewReturn.php?so=".$_GET['SaleID'];
	}

	/*************************/
	$arryReturn=$objSale->ListReturn($_GET);
	$num=$objSale->numRows();

	$pagerLink=$objPager->getPager($arryReturn,$RecordsPerPage,$_GET['curP']);
	(count($arryReturn)>0)?($arryReturn=$objPager->getPageRecords()):("");
	/*************************/
 
  	//$ErrorMSG = UNDER_CONSTRUCTION; // Disable Temporarly

	require_once("../includes/footer.php"); 	
?>


