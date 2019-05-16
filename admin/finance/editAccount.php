<?php
	/**************************************************/
	$ThisPageName = 'viewAccount.php'; $EditPage = 1;
	/**************************************************/
 	include_once("../includes/header.php");
	require_once($Prefix."classes/finance.account.class.php");        
  
	$objBankAccount=new BankAccount();
	                 
	$BankAccountID = (int)$_GET['edit'];	
	$ListUrl = "viewAccount.php?curP=".$_GET['curP'];
	$ActionUrl = "editAccount.php?curP=".$_GET['curP'];

	$ModuleName = "Account";
	
	if(!empty($_GET['del_id'])){
		$_SESSION['mess_bank_account'] = $ModuleName.REMOVED;
		$objBankAccount->RemoveBankAccount($_GET['del_id']);
		header("location:".$ListUrl);
		exit;
	}

	if(!empty($_GET['active_id'])){
		$_SESSION['mess_bank_account'] = $ModuleName.STATUS;
		$objBankAccount->changeBankAccountStatus($_GET['active_id']);
		header("location:".$ListUrl);
		exit;
	}
	
		

            
	if ($_POST) {
		CleanPost();
		/****************/
		if(empty($_POST['AccountName']) || empty($_POST['AccountNumber'])) {
			$_SESSION['mess_bank_account'] = FILL_ALL_MANDANTRY_FIELDS;
			if($BankAccountID>0)$ActionUrl .= "&edit=".$BankAccountID;                
			header("location: ".$ActionUrl);
			exit;
		}
		/****************/
		if(!empty($BankAccountID)) {
			$_SESSION['mess_bank_account'] = $ModuleName.UPDATED;
			$objBankAccount->updateBankAccount($_POST);
		}else{	
			$_SESSION['mess_bank_account'] = $ModuleName.ADDED;
			$BankAccountID = $objBankAccount->addBankAccount($_POST);
		} 
		header("location:".$ListUrl);
		exit;

	}


		
    
	if(!empty($BankAccountID)){
		$arryBankAccount = $objBankAccount->getBankAccountById($BankAccountID);		   
		$ButtonAction = 'Update';
		if($arryBankAccount[0]['BankFlag']==1){
			$BankUrl = "editBankAccount.php?curP=".$_GET['curP']."&edit=".$BankAccountID;
			header("location:".$BankUrl);
			exit;
		}
		$EditableClass = 'class="disabled_inputbox" readonly';
	}else{
		$ButtonAction = 'Submit';
		$EditableClass = 'class="inputbox" ';
	}
	
      
   	require_once("../includes/footer.php"); 
 
 
 ?>
