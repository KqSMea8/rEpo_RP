<?php  
       if(!empty($_GET['pop']))$HideNavigation = 1;
	/**************************************************/
        
           /*if($_GET['IE'] > 0){
                   $ThisPageName = 'viewPoInvoice.php';
                }else{
                   $ThisPageName = 'viewPurchasePayments.php';
                }*/
	$ThisPageName = 'viewPoInvoice.php';
        
        $EditPage = 1;
	/**************************************************/
	include_once("../includes/header.php");
	require_once($Prefix."classes/finance.class.php");
	require_once($Prefix."classes/finance.account.class.php");
	//require_once($Prefix."classes/finance_tax.class.php");
	require_once($Prefix."classes/inv_tax.class.php");
	require_once($Prefix."classes/sales.customer.class.php");
	require_once($Prefix."classes/purchase.class.php");
	require_once($Prefix."classes/finance.transaction.class.php");

	$objCustomer = new Customer();
	$objCommon=new common();
	$objTax=new tax();
	$objBankAccount= new BankAccount();
	$objPurchase=new purchase();
	$objTransaction=new transaction();
               
	$ModuleName = "Invoice";
	$module = $ModuleName;
	(empty($_GET['pay']))?($_GET['pay']=""):("");
                $ListUrl = "viewPoInvoice.php?curP=".$_GET['curP'];
		$EditUrl = "editOtherExpense.php?edit=".$_GET['view']."&curP=".$_GET['curP'];
		$ModuleName = "Payment History";
		$arryBankAccount=$objBankAccount->getBankAccount('',1,'','','');  
		$arryCustomer = $objCustomer->ListCustomer($_GET);
		$arryPaymentMethod = $objCommon->GetAttribValue('PaymentMethod','');
		$arryIncomeType = $objCommon->GetAttribValue('Expenses','');	
		
		

		/*********************/
		/*********************/		
		if(!empty($_GET['CloneID'])){
			$CloneID = base64_decode($_GET['CloneID']);
			$NewCloneID = $objPurchase->CreateCloneGlInvoice($CloneID,$module);
			if(!empty($NewCloneID)){
				$CloneCreated = str_replace("[MODULE]", $module, CLONE_CREATED);
				$CloneCreated = str_replace("[MODULE_ID]", $NewCloneID, $CloneCreated);
				$_SESSION['mess_invoice'] = $CloneCreated;
			}else{
				$_SESSION['mess_invoice'] = CLONE_NOT_CREATED;
			}
			header("Location:".$ListUrl);
			exit;
		}
		/*********************/
		/*********************/


		
		if(!empty($_GET['view'])){
			$IncomeID = $_GET['view'];
			$_GET['ExpenseID'] = $_GET['view'];
			$arryOtherExpense=$objBankAccount->getOtherExpense($_GET);
 
			if(!empty($arryOtherExpense[0]['TaxID'])){
				$arryTax = $objTax->getTaxById($arryOtherExpense[0]['TaxID']);
                        }

			$OrderID   = $arryOtherExpense[0]['OrderID'];			
			
			$arryPurchase = $objPurchase->GetPurchase($OrderID,'','Invoice');

			$InvoiceID = $arryPurchase[0]['InvoiceID'];	
			$arryOtherExpense[0]['InvoiceID'] = $arryPurchase[0]['InvoiceID'];		
                        //Get Multi Account
                         
                         $arryMultiAccount=$objBankAccount->getMultiAccount($_GET['view']);
                   //    echo '<pre>'; print_r( $arryOtherExpense);
                        //End
			if(!empty($_GET['pay'])) {
				$arryPaymentInvoice = $objBankAccount->GetPurchasesPaymentInvoice($OrderID,$InvoiceID);	
			}

			$CloneURL = "vOtherExpense.php?curP=".$_GET['curP']."&CloneID=".base64_encode($OrderID); 
		}
		 
		 
		 
  


   require_once("../includes/footer.php"); 
 
 
 ?>
