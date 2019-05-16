<?php 
	$Tooltip = 1;
	include_once("../includes/header.php");
	require_once($Prefix."classes/sales.quote.order.class.php");
	$ModuleName = "Sales";
	$objSale = new sale();
        
      	$_GET['EntryType'] = 'recurring';
	(empty($_GET['type']))?($_GET['type']=""):("");
	(empty($_GET['cancel_id']))?($_GET['cancel_id']=""):("");
	(empty($_GET['intv']))?($_GET['intv']=""):("");
	(empty($_GET['module']))?($_GET['module'] = "Invoice"):("");
	(empty($_GET['status']))?($_GET['status'] = "Active"):("");

	$ModuleName = "Recurring Invoice";
              
	$ViewUrl = "viewRecurringInvoice.php";
	$AddUrl = "editRecurringInvoice.php";
	$EditUrl = "editRecurringInvoice.php?curP=".$_GET['curP'];
	$ViewUrl = "vInvoice.php?curP=".$_GET['curP'];

	$RedirectURL = "viewRecurringInvoice.php?type=".$_GET['type'];
	$ModuleIDTitle = "Invoice Number"; $ModuleID = "InvoiceID";
	/*************************/

	if($_GET['cancel_id'] && !empty($_GET['cancel_id'])){
		$_SESSION['mess_rec_inv'] = $ModuleName.CANCELLED;
		$objSale->RemoveInvoiceRecurring($_GET['cancel_id'],$_GET['id']);
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
	$arrySale=$objSale->ListRecurringInvoice($_GET);
	$num=sizeof($arrySale);//temp
	/*******Count Records**********	
	$Config['GetNumRecords'] = 1;
        $arryCount=$objSale->ListRecurringInvoice($_GET);
	$num=$arryCount[0]['NumCount'];	
	$pagerLink=$objPager->getPaging($num,$RecordsPerPage,$_GET['curP']);   
         /*************************/	
	//echo '<pre>';print_r($arrySale);exit;
             
	require_once("../includes/footer.php"); 	
?>


