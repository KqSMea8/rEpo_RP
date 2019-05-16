<?php  
        if(!empty($_GET['pop']))$HideNavigation = 1;
	/**************************************************/        
        $ThisPageName = 'viewInvoice.php';           
	/**************************************************/
	include_once("../includes/header.php");
	require_once($Prefix."classes/finance.class.php");
	require_once($Prefix."classes/finance.account.class.php");
	require_once($Prefix."classes/sales.quote.order.class.php");
	require_once($Prefix."classes/sales.customer.class.php");
	$objCustomer = new Customer(); 
	$objSale = new sale();
	$objBankAccount= new BankAccount();	
 
        $ListUrl = "viewInvoice.php?curP=".$_GET['curP'];
	$EditUrl = "editInvoiceEntry.php?edit=".$_GET['view']."&curP=".$_GET['curP'];
	$module = 'Invoice';
        $ModuleName = $module;		
	$NotExist = NOT_EXIST_INVOICE;
	
	$CreditCardFlag='';
	/*********************/
	/*********************/
	$CloneURL = "vInvoiceGl.php?curP=".$_GET['curP']."&CloneID=".base64_encode($_GET['view']); 
	if(!empty($_GET['CloneID'])){
		$CloneID = base64_decode($_GET['CloneID']);
		$NewCloneID = $objSale->CreateCloneGlInvoice($CloneID,$module);
		if(!empty($NewCloneID)){
			$CloneCreated = str_replace("[MODULE]", $module, CLONE_CREATED);
			$CloneCreated = str_replace("[MODULE_ID]", $NewCloneID, $CloneCreated);
			$_SESSION['mess_Invoice'] = $CloneCreated;
		}else{
			$_SESSION['mess_Invoice'] = CLONE_NOT_CREATED;
		}
		header("Location:".$ListUrl);
		exit;
	}
	/*********************/
	/*********************/



	if(!empty($_GET['view'])){			
		$_GET['OrderID'] = $_GET['view'];
		$arrySale = $objSale->GetSale($_GET['view'],'',$module);
		$_GET['IncomeID'] = $arrySale[0]['IncomeID'];
		$OrderID = $arrySale[0]['OrderID'];

		if($_GET['IncomeID']>0){		 
			$arryOtherIncome=$objBankAccount->getOtherIncomeGL($_GET);
			if($arryOtherIncome[0]['GlEntryType']=="Multiple"){
		  		$arryMultiAccount=$objBankAccount->getMultiAccountgl($_GET['IncomeID']);
			}
 			/********************/
			$arryCard = $objSale->GetSaleCreditCard($OrderID);
			if(sizeof($arryCard)>0){
				$CreditCardFlag = 1;
			}
     			/********************/
		}else{
			$ErrorMSG = $NotExist;
		}		 
		     
	}else{
		$ErrorMSG = $NotExist;
	}
		 	 
  
	//$arryBankAccount=$objBankAccount->getBankAccount('',1,'','','');  

   	require_once("../includes/footer.php"); 
 ?>
