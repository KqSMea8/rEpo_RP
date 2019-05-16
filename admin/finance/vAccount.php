<?php
	/**************************************************/
	$ThisPageName = 'viewAccount.php'; $EditPage = 1;
	/**************************************************/
 	include_once("../includes/header.php");
	require_once($Prefix."classes/finance.class.php");
	require_once($Prefix."classes/finance.account.class.php");
           
  (!$_GET['curP'])?($_GET['curP']=1):(""); // current page number
  
	$objCommon=new common();
	
	if (class_exists(BankAccount)) {
		$objBankAccount=new BankAccount();
	} else {
		echo "Class Not Found Error !! Bank Account Class Not Found !";
		exit;
	}
        
            
		$BankAccountID = isset($_REQUEST['view'])?$_REQUEST['view']:"";	
		$ListUrl = "viewAccount.php?curP=".$_GET['curP'];
		$ModuleName = "Bank Account";
		$EditUrl = "editAccount.php?edit=".$BankAccountID."&curP=".$_GET['curP'];
		
		 
                
		if(!empty($BankAccountID)){
		   $arryBankAccount = $objBankAccount->getBankAccountById($BankAccountID);
		  
		}
                
		
   $arryAccountType = $objCommon->GetAttribValue('AccountType','');
   require_once("../includes/footer.php"); 
 
 
 ?>
