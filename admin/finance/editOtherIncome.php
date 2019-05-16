<?php
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
		$ModuleName = "Income";
		$arryBankAccount=$objBankAccount->getBankAccountForReceivePayment();  
		$arryCustomer = $objCustomer->ListCustomer($_GET);
		$arryPaymentMethod = $objCommon->GetAttribValue('PaymentMethod','');
		//$arryIncomeType = $objCommon->GetAttribValue('Income','');
                $arryIncomeType = $objBankAccount->getBankAccount('15','','','','');	
		$arryTax = $objTax->GetTaxRate();
		
		if(!empty($_GET['edit'])){
		$IncomeID = $_GET['edit'];
		$_GET['IncomeID'] = $_GET['edit'];
		$arryOtherIncome=$objBankAccount->getOtherIncome($_GET);
		}
		if(!empty($_GET['del_id'])){
			$_SESSION['mess_add_income'] = TRANSACTION_REMOVED;
			$objBankAccount->RemoveOtherIncome($_GET['del_id']);
			header("location:".$ListUrl);
			exit;
		} 
		 
		 
 	if (is_object($objBankAccount)) {
            
            if ($_POST) {
			 /******************************/
					CleanPost();
				/******************************/

			$CustCode = $objCommon->getCustomerCode($_POST['ReceivedFrom']);	
			$_POST['CustCode'] = $CustCode;		 

			if(empty($_POST['IncomeTypeID']) || empty($_POST['PaymentMethod']) || ($_POST['Amount'] == '0.00')) {
				        			
					$_SESSION['mess_add_income'] = FILL_ALL_MANDANTRY_FIELDS;
					header("Location:editOtherIncome.php");
					exit;
				}else{
				
				if (!empty($IncomeID)) {
					$_SESSION['mess_add_income'] = TRANSACTION_UPDATED;
					 $objBankAccount->updateOtherIncome($_POST);
					header("Location:".$ListUrl);
					exit;
				}else{
					$_SESSION['mess_add_income'] = TRANSACTION_SAVED;
					
					$objBankAccount->addOtherIncome($_POST);
					header("Location:".$ListUrl);
					exit;
				}
			}	
              }

         }
	


   require_once("../includes/footer.php"); 
 
 
 ?>
