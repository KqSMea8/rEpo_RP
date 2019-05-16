<?php
	/**************************************************/
	$ThisPageName = 'viewPurchasePayments.php'; $EditPage = 1;
	/**************************************************/
	include_once("../includes/header.php");
	require_once($Prefix."classes/finance.class.php");
	require_once($Prefix."classes/finance.account.class.php");
	//require_once($Prefix."classes/finance_tax.class.php");
	require_once($Prefix."classes/inv_tax.class.php");
	require_once($Prefix."classes/supplier.class.php");
         require_once($Prefix."classes/finance.report.class.php");
	
	 
        $objReport = new report();
	$objSupplier = new supplier();
           
  (!$_GET['curP'])?($_GET['curP']=1):(""); // current page number
  
	$objCommon=new common();
	$objTax=new tax();
	if (class_exists(BankAccount)) {
		$objBankAccount= new BankAccount();
	} else {
		echo "Class Not Found Error !! Bank Account Class Not Found !";
		exit;
	}
        
             //GET FISCAL YEAR
             $FiscalYearStartDate = $objCommon->getSettingVariable('FiscalYearStartDate');
             $FiscalYearEndDate = $objCommon->getSettingVariable('FiscalYearEndDate');
             
            //GET CURRENT PERIOD
            $IECurrentPeriod =  $objReport->getCurrentPeriod('IE');
            $currentDate = date('Y-m-d');
            $CurrentPeriodDate = $objReport->getCurrentPeriodDate('IE');

            //GET BACK OPEN MONTH
            $arryBackMonth = $objReport->getBackOpenMonth('IE');

            $strBackDate = '';
            for($i=0;$i<count($arryBackMonth);$i++)
            {

            $strBackDate .= $arryBackMonth[$i]['PeriodYear'].'-'.$arryBackMonth[$i]['PeriodMonth'].',';
            }

            $strBackDate = rtrim($strBackDate,",");
       
         //end
            
        
		$ListUrl = "viewPurchasePayments.php?curP=".$_GET['curP'];
		$ModuleName = "Invoice Entry";
		$arryBankAccount=$objBankAccount->getBankAccountForPaidPayment();  
		

		$arryPaymentMethod = $objCommon->GetAttribValue('PaymentMethod','');
		//$arryExpenseType = $objCommon->GetAttribValue('Expenses','');	
                
                $arryExpenseType = $objBankAccount->getBankAccount('','Yes','','','');	
                
                
		//$arryTax = $objTax->GetTaxRate();

		$arryTax = $objTax->GetTaxAll('2');


		
		if(!empty($_GET['edit'])){
			$ExpenseID = $_GET['edit'];
			$_GET['ExpenseID'] = $_GET['edit'];
			$arryOtherExpense=$objBankAccount->getOtherExpense($_GET);
			
		}
		if(!empty($_GET['del_id'])){
			$_SESSION['mess_add_expense'] = TRANSACTION_REMOVED;
			$objBankAccount->RemoveOtherExpense($_GET['del_id']);
			header("location:".$ListUrl);
			exit;
		} 
		 
		$_GET['key'] = 'active';
		$arrySupplier = $objSupplier->ListSupplier($_GET);
		 
 	if (is_object($objBankAccount)) {
            
            if ($_POST) {
			 /******************************/
					CleanPost();
				/******************************/
			if(empty($_POST['ExpenseTypeID']) || empty($_POST['PaymentMethod']) || empty($_POST['BankAccount']) || ($_POST['Amount'] == '0.00')) {
				        			
					$_SESSION['mess_add_expense'] = FILL_ALL_MANDANTRY_FIELDS;
					header("Location:editOtherExpense.php");
					exit;
				}else{	

					if (!empty($ExpenseID)) {
						$_SESSION['mess_add_expense'] = TRANSACTION_UPDATED;
						 $objBankAccount->updateOtherExpense($_POST);
						header("Location:".$ListUrl);
						exit;
					}else{
						$_SESSION['mess_add_expense'] = TRANSACTION_SAVED;
						$objBankAccount->addOtherExpense($_POST);
						header("Location:".$ListUrl);
						exit;
					}
			            }			
			}

        	 }
	


   require_once("../includes/footer.php"); 
 
 
 ?>
