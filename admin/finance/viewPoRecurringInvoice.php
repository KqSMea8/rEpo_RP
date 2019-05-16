<?php 
	include_once("../includes/header.php");
	require_once($Prefix."classes/purchase.class.php");
	$objPurchase = new purchase();
       
      	$_GET['EntryType'] = 'recurring';
	(empty($_GET['type']))?($_GET['type']=""):("");
	(empty($_GET['cancel_id']))?($_GET['cancel_id']=""):("");
	(empty($_GET['intv']))?($_GET['intv']=""):("");
	(empty($_GET['status']))?($_GET['status'] = "Active"):("");

	$ModuleName = "Recurring Invoice";
              
	$AddUrl = "editPoRecurringInvoice.php";
	$EditUrl = "editPoRecurringInvoice.php?curP=".$_GET['curP'];
	$RedirectURL = "viewPoRecurringInvoice.php";	
	/*************************/

	if($_GET['cancel_id'] && !empty($_GET['cancel_id'])){
		$_SESSION['mess_recpo_inv'] = $ModuleName.CANCELLED;
		$objPurchase->RemovePurchaseRecurring($_GET['cancel_id']);
		header("Location:".$RedirectURL);
		exit;
	}

	
	$arryInterval = array('biweekly','semi_monthly','monthly','yearly');
	if(!in_array($_GET['intv'],$arryInterval)){
		$_GET['intv']='';
	}


        /*************************/	
	$_GET['EntryInterval'] = $_GET['intv'];
	//$Config['RecordsPerPage'] = $RecordsPerPage;
	$arryPurchase=$objPurchase->ListRecurringPoInvoice($_GET);
	$num=sizeof($arryPurchase);//temp
	/*******Count Records**********	
	$Config['GetNumRecords'] = 1;
        $arryCount=$objPurchase->ListRecurringPoInvoice($_GET);
	$num=$arryCount[0]['NumCount'];	
	$pagerLink=$objPager->getPaging($num,$RecordsPerPage,$_GET['curP']);   
         /*************************/	
	
             
	require_once("../includes/footer.php"); 	
?>


