<?php 
	$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'viewSalesQuoteOrde.php';
	/**************************************************/
	include_once("../includes/header.php");
	require_once($Prefix."classes/finance.account.class.php");
	$ModuleName = "Sales";
	if (class_exists(BankAccount)) {
		$objBankAccount=new BankAccount();
	} else {
		echo "Class Not Found Error !! Bank Account Class Not Found !";
		exit;
	}

      /*************************/
        $EditURL = "editVendorInvoiceEntry.php";
        
	$arrySale=$objBankAccount->ListUnPaidInvoice($_GET);
	$num=$objBankAccount->numRows();

	$pagerLink=$objPager->getPager($arrySale,$RecordsPerPage,$_GET['curP']);
	(count($arrySale)>0)?($arrySale=$objPager->getPageRecords()):("");
	/*************************/
 
	require_once("../includes/footer.php"); 	
?>


