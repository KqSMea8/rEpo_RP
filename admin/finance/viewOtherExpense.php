<?php 
	/**************************************************/
	$ThisPageName = 'viewOtherExpense.php'; 
	/**************************************************/
	include_once("../includes/header.php");
	require_once($Prefix."classes/finance.account.class.php");
        
       (!$_GET['curP'])?($_GET['curP']=1):(""); // current page number
                
         if (class_exists(BankAccount)) {
                      $objBankAccount=new BankAccount();
              } else {
                      echo "Class Not Found Error !! Bank Account Class Not Found !";
                      exit;
              }

	  $RedirectURL = 'viewOtherExpense.php';

	 if (is_object($objBankAccount)) {
			$arryOtherExpense = $objBankAccount->getOtherExpense($_GET);
			 
			$num=$objBankAccount->numRows();       
               }
	/*************************/
 
	require_once("../includes/footer.php"); 	
?>


