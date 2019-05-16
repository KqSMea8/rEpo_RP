<?php 
 	include_once("../includes/header.php");
	require_once($Prefix."classes/finance.account.class.php");
        
       (!$_GET['curP'])?($_GET['curP']=1):(""); // current page number
                
         if (class_exists(BankAccount)) {
                      $objBankAccount=new BankAccount();
              } else {
                      echo "Class Not Found Error !! Bank Account Class Not Found !";
                      exit;
              }
			  
			  
			$ListUrl = "viewAccount.php?curP=".$_GET['curP'];
			$ModuleName = "Bank Account";
			  
			/* Default Entry for Cash in Hand Account */

			$num=$objBankAccount->getCashAccount($_SESSION['locationID'],1);
			 
				if($num<=0){
					
					$_POST['AccountName'] = 'Cash in Hand';
					$_POST['AccountType'] = 'Cash in Hand';
					$_POST['LocationID'] = $_SESSION['locationID'];
					$_POST['Currency'] = $Config['Currency'];
					$_POST['Status'] = 'Yes';
					$_POST['CashFlag'] = '1';

					$_SESSION['mess_bank_account'] = $ModuleName.ADDED;
					$BankAccountID = $objBankAccount->addBankAccount($_POST);
					header("Location:".$ListUrl);
					exit;
				}
			/***************************/
	
	 if (is_object($objBankAccount)) {
			$arryBankAccount=$objBankAccount->getBankAccount($id,$_GET['status'],$_GET['key'],$_GET['sortby'],$_GET['asc']);
			$num=$objBankAccount->numRows();       
           
		   }
  
         require_once("../includes/footer.php");
  
?>
