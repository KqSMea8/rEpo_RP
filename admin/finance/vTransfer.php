<?php
	if(!empty($_GET['pop']))$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'viewTransfer.php'; $EditPage = 1;
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
        
		$TransferID = isset($_GET['view'])?$_GET['view']:"";	
		$ListUrl = "viewTransfer.php?curP=".$_GET['curP'];
		$EditUrl = "editTransfer.php?edit=".$TransferID."&curP=".$_GET['curP'];
		$ModuleName = "Transfer";
		
	       $_GET['TransferID'] = $TransferID;	 
               $arryTransfer=$objBankAccount->getTransfer($_GET);

		 


   require_once("../includes/footer.php"); 
 
 
 ?>
