<?php  
       if(!empty($_GET['pop']))$HideNavigation = 1;
	/**************************************************/
        
           if($_GET['IE'] > 0){
                   $ThisPageName = 'viewPoInvoice.php';
                }else{
                   $ThisPageName = 'viewPurchasePayments.php';
                }
	
        
        $EditPage = 1;
	/**************************************************/
	include_once("../includes/header.php");
	require_once($Prefix."classes/finance.class.php");
	require_once($Prefix."classes/finance.account2.class.php");
	//require_once($Prefix."classes/finance_tax.class.php");
	require_once($Prefix."classes/inv_tax.class.php");
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
        
                if($_GET['IE'] > 0){
                    $ListUrl = "viewPoInvoice.php?curP=".$_GET['curP'];
                }else{
                    $ListUrl = "viewPurchasePayments.php?curP=".$_GET['curP'];
                }
                
		$EditUrl = "editOtherExpense.php?edit=".$_GET['view']."&curP=".$_GET['curP'];
		$ModuleName = "Payment History";
		$arryBankAccount=$objBankAccount->getBankAccount('',1,'','','');  
		$arryCustomer = $objCustomer->ListCustomer($_GET);
		$arryPaymentMethod = $objCommon->GetAttribValue('PaymentMethod','');
		$arryIncomeType = $objCommon->GetAttribValue('Expenses','');	
		
		
		
		if(!empty($_GET['view'])){
		$IncomeID = $_GET['view'];
		$_GET['ExpenseID'] = $_GET['view'];
			$arryOtherExpense=$objBankAccount->getOtherExpense($_GET);
			$arryTax = $objTax->getTaxById($arryOtherExpense[0]['TaxID']);
                        
                        
                        //Get Multi Account
                         
                         $arryMultiAccount=$objBankAccount->getMultiAccount($_GET['view']);
                        
                        //End

		}
		 
		 
		 
  


   require_once("../includes/footer.php"); 
 
 
 ?>
