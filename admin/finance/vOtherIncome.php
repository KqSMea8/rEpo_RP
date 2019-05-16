<?php  if(!empty($_GET['pop']))$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'viewOtherIncome.php'; $EditPage = 1;
	/**************************************************/
	include_once("../includes/header.php");
	require_once($Prefix."classes/finance.class.php");
	require_once($Prefix."classes/finance.account.class.php");
	require_once($Prefix."classes/finance_tax.class.php");
	require_once($Prefix."classes/sales.customer.class.php");
	$objCustomer = new Customer();
           
  (!$_GET['curP'])?($_GET['curP']=1):(""); // current page number
  
	$objCommon=new common();
	$objTax=new tax();
	if (class_exists(BankAccount)) {
		$objBankAccount= new BankAccount();
	} else {
		echo "Class Not Found Error !! Bank Account Class Not Found !";
		exit;
	}
        
		$ListUrl = "viewOtherIncome.php?curP=".$_GET['curP'];
		$EditUrl = "editOtherIncome.php?edit=".$_GET['view']."&curP=".$_GET['curP'];
		$ModuleName = "Income";
		$arryBankAccount=$objBankAccount->getBankAccount('',1,'','','');  
		$arryCustomer = $objCustomer->ListCustomer($_GET);
		$arryPaymentMethod = $objCommon->GetAttribValue('PaymentMethod','');
		$arryIncomeType = $objCommon->GetAttribValue('Income','');	
		
		
		
		if(!empty($_GET['view'])){
		$IncomeID = $_GET['view'];
		$_GET['IncomeID'] = $_GET['view'];
			$arryOtherIncome=$objBankAccount->getOtherIncome($_GET);
			$arryTax = $objTax->getTaxById($arryOtherIncome[0]['TaxID']);

		}
		 
		 
		 
  


   require_once("../includes/footer.php"); 
 
 
 ?>
