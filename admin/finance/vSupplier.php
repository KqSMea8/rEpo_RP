<?php 
	if(!empty($_GET['pop']))$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'viewSupplier.php'; 
	/**************************************************/

	include_once("../includes/header.php");

	require_once($Prefix."classes/supplier.class.php");
	require_once($Prefix."classes/finance.account.class.php");
	require_once($Prefix."classes/finance.report.class.php");
	require_once($Prefix."classes/purchase.class.php");
	$objSupplier=new supplier();
	$objBankAccount=new BankAccount();
	$objPurchase = new purchase();
	$objReport = new report();
	$ModuleName = "Vendor";
	$RedirectURL = "viewSupplier.php?curP=".$_GET['curP'];
	if(empty($_GET['tab'])) $_GET['tab']="general";

	$EditUrl = "editSupplier.php?edit=".$_GET["view"]."&curP=".$_GET["curP"]."&tab=".$_GET['tab']; 
	$ViewUrl = "vSupplier.php?view=".$_GET["view"]."&curP=".$_GET["curP"]."&tab="; 


	if (!empty($_GET['view'])) {
		$arrySupplier = $objSupplier->GetSupplier($_GET['view'],'','');
		$SuppID   = $_GET['view'];	
		
		if(empty($arrySupplier[0]['SuppID'])){
			$ErrorMSG = NOT_EXIST_SUPP;
		}else{
			$SuppCode = $arrySupplier[0]['SuppCode'];

			$DefaultAccount = NOT_SPECIFIED;
			if(!empty($arrySupplier[0]['AccountID'])){
				$arryBankAccount = $objBankAccount->getBankAccountById($arrySupplier[0]['AccountID']);
				$DefaultAccount = $arryBankAccount[0]['AccountName'].' ['.$arryBankAccount[0]['AccountNumber'].']';
			}

		}
		
	}else{
		header('location:'.$RedirectURL);
		exit;
	}

	$HideEdit='';

	if($_GET['tab']=='shipping'){
		$SubHeading = 'Shipping Address';
	}else if($_GET['tab']=='billing'){
		$SubHeading = 'Billing Address';
	}else if($_GET['tab']=='bank'){
		$SubHeading = 'Bank Details';
	}else if($_GET['tab']=='contacts'){
		$SubHeading = 'Contacts'; 
	}else if($_GET['tab']=='currency'){
		$SubHeading = 'Currency';
	}else if($_GET['tab']=='linkcustomer'){
		$SubHeading = 'Linked Customer';
	}else if($_GET['tab']=='invoice'){
		$SubHeading = 'Invoices'; $HideEdit= 'style="display:none"';
	}else if($_GET['tab']=='payment'){
		$SubHeading = 'Payment History'; $HideEdit= 'style="display:none"';
	}else if($_GET['tab']=='deposit'){
		//$SubHeading = 'Deposits'; 
		$SubHeading = 'Payment History'; $HideEdit= 'style="display:none"';
	}else if($_GET['tab']=='purchase'){
		$SubHeading = 'Purchase History'; $HideEdit= 'style="display:none"';
	}else if($_GET['tab']=='Email'){
		$SubHeading = 'Emails';  $HideEdit= 'style="display:none"';
	}else{
		$SubHeading = ucfirst($_GET["tab"])." Information";
		$arryCustomField = $objConfigure->CustomFieldList($CurrentDepID,'Supplier','');	
	}



	

	require_once("../includes/footer.php"); 	 
?>


