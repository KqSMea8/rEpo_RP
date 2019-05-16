<?php 
	include_once("../includes/header.php");
	require_once($Prefix."classes/purchase.class.php");
	$objPurchase = new purchase();

	$RedirectURL = "viewPoCredit.php";
	$ModuleName = "RMA";
	$module="Credit Memo";
        $SendUrl = "sendCreditMemo.php?module=".$module."&curP=".$_GET['curP'];
	if(!empty($_GET['po'])){
		$MainModuleName = "RMA for Invoice Number : ".$_GET['po'];
		$RedirectURL = "viewPoCredit.php?po=".$_GET['po'];
	}

	/*************************/

	$arryReturn=$objPurchase->ListCreditNoteRMA($_GET);
	#echo "<pre>";print_r($arryReturn);
	#die;
	$num=$objPurchase->numRows();

	$pagerLink=$objPager->getPager($arryReturn,$RecordsPerPage,$_GET['curP']);
	(count($arryReturn)>0)?($arryReturn=$objPager->getPageRecords()):("");
	/*************************/
 

  	//$ErrorMSG = UNDER_CONSTRUCTION; // Disable Temporarly

	require_once("../includes/footer.php"); 	
?>


