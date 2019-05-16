<?php
	/**************************************************/
	$ThisPageName = 'viewDeposit.php'; $EditPage = 1;
	/**************************************************/
	include_once("../includes/header.php");
	require_once($Prefix."classes/finance.class.php");
	require_once($Prefix."classes/finance.account.class.php");
	
	require_once($Prefix."classes/sales.customer.class.php");
	$objCustomer = new Customer();
           
  (!$_GET['curP'])?($_GET['curP']=1):(""); // current page number
  
	$objCommon=new common();
	
	if (class_exists(BankAccount)) {
		$objBankAccount= new BankAccount();
	} else {
		echo "Class Not Found Error !! Bank Account Class Not Found !";
		exit;
	}
        
		$ListUrl = "viewDeposit.php?curP=".$_GET['curP'];
		$ModuleName = "Bank Deposit";
 
		 
		 $arryBankAccount=$objBankAccount->getBankAccountForReceivePayment();  
		 $arryCustomer = $objCustomer->ListCustomer($_GET);
		 $arryPaymentMethod = $objCommon->GetAttribValue('PaymentMethod','');
		 
		if(!empty($_GET['del_id'])){
			$_SESSION['mess_deposit'] = $ModuleName.REMOVED;
			$objBankAccount->RemoveDeposit($_GET['del_id']);
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
				
				if(empty($_POST['AccountID']) || empty($_POST['Method']) || ($_POST['Amount'] == '0.00')) {
				        			
					$_SESSION['mess_deposit'] = FILL_ALL_MANDANTRY_FIELDS;
					header("Location:".$ListUrl);
					exit;
				}else{
					//$MsgVal = $Config['Currency']." ".$_POST['Amount'];
					$_SESSION['mess_deposit'] = DEPOSIT_MSG;
					$BankAccountID = $objBankAccount->addBankDeposit($_POST);
					header("Location:".$ListUrl);
					exit;
				}
				
            }

         }
		

   require_once("../includes/footer.php"); 
 
 
 ?>
