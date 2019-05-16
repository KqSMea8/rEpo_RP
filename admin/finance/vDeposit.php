<?php
	if($_GET['pop']==1)$HideNavigation = 1;	
	/**************************************************/
	$ThisPageName = 'viewDeposit.php'; $EditPage = 1;
	/**************************************************/
	include_once("../includes/header.php");
	require_once($Prefix."classes/finance.class.php");
	require_once($Prefix."classes/finance.account.class.php");
	
	require_once($Prefix."classes/sales.customer.class.php");
	$objCustomer = new Customer();
           
  (!$_GET['curP'])?($_GET['curP']=1):(""); // current page number
  
	$objCommon=new common();
	
	if (class_exists(BankAccount)) {
		$objBankAccount= new BankAccount();
	} else {
		echo "Class Not Found Error !! Bank Account Class Not Found !";
		exit;
	}
        
		$DepositID = isset($_GET['view'])?$_GET['view']:"";	
		$ListUrl = "viewDeposit.php?curP=".$_GET['curP'];
		$ModuleName = "Bank Deposit";
 
	    if(!empty($DepositID)){	
	       $arryDeposit = $objBankAccount->getDeposit($DepositID);
	   }
		

   require_once("../includes/footer.php"); 
 
 
 ?>
