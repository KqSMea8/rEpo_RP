<?php 
	include_once("../includes/header.php");
	require_once($Prefix."classes/sales.quote.order.class.php");
	$ModuleName = "Sales";
	$objSale = new sale();
        
      	$_GET['EntryType'] = 'recurring';

	(!$_GET['module'])?($_GET['module']='Quote'):(""); 
	$module = $_GET['module'];
	/**************/
	$ModuleArray = array('Quote','Order'); 
	if(!in_array($_GET['module'],$ModuleArray)){
		header("location:home.php");die;		 
	}
	/**************/


	$ModuleName = "Recurring Sales ".$_GET['module'];
              
	$ViewUrl = "viewRecurringSO.php?module=".$module;
	$AddUrl = "editRecurringSO.php?module=".$module;
	$EditUrl = "editRecurringSO.php?module=".$module."&curP=".$_GET['curP'];
	$ViewUrl = "vSalesQuoteOrder.php?module=".$module."&curP=".$_GET['curP'];

	$RedirectURL = "viewRecurringSO.php?module=".$module;

	/*************************/

	if($_GET['cancel_id'] && !empty($_GET['cancel_id'])){
		$_SESSION['mess_rec_so'] = $ModuleName.CANCELLED;
		$objSale->RemoveSaleRecurring($_GET['cancel_id']);
		header("Location:".$RedirectURL);
		exit;
	}





	/*************************/

	if($_GET['module']=='Quote'){	
		$ModuleIDTitle = "Quote Number"; $ModuleID = "QuoteID";
	}elseif($_GET['module']=='Invoice'){	
		$ModuleIDTitle = "Invoice Number"; $ModuleID = "InvoiceID";
	}else{
		$ModuleIDTitle = "SO Number"; $ModuleID = "SaleID";
	}
	/*************************/ 

	/*************************/	
	$Config['RecordsPerPage'] = $RecordsPerPage;
	$arrySale=$objSale->ListRecurringOrder($_GET);

	/*******Count Records**********/	
	$Config['GetNumRecords'] = 1;
        $arryCount=$objSale->ListRecurringOrder($_GET);
	$num=$arryCount[0]['NumCount'];	

	$pagerLink=$objPager->getPaging($num,$RecordsPerPage,$_GET['curP']);

	/*************************/
             
	require_once("../includes/footer.php"); 	
?>


