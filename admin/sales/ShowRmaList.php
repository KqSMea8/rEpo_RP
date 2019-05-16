<?php 
	$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'viewSalesQuoteOrde.php';
	/**************************************************/

	include_once("../includes/header.php");
	require_once($Prefix."classes/rma.sales.class.php");
	require_once($Prefix."classes/sales.customer.class.php");
	
	$objCustomer=new Customer();
	$objrmasale = new rmasale();

	$ModuleName = "Sales by Customer";
	$ViewUrl = "viewSalesbyCustomer.php";
	$RedirectURL = "viewSalesbyCustomer.php";

    	$arryCustomer=$objrmasale->getCustomersList();
    
	if((!empty($_GET['CustCode']))){

		/*********Get Invoices*********/		
		$Config['RecordsPerPage'] = $RecordsPerPage;
		$arrySale=$objrmasale->ListInvoiceByCustomer($_GET);
		/*******Count Records**********/	
		$Config['GetNumRecords'] = 1;
		$arryCount=$objrmasale->ListInvoiceByCustomer($_GET);
		$num=$arryCount[0]['NumCount'];	
		$pagerLink=$objPager->getPaging($num,$RecordsPerPage,$_GET['curP']);        
		/******************************/
	
	}
 
	require_once("../includes/footer.php"); 	

?>


