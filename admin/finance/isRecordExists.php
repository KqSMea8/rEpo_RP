<?php	session_start();
		$Prefix = "../../"; 
		require_once($Prefix."includes/config.php");
		require_once($Prefix."includes/function.php");
		require_once($Prefix."classes/dbClass.php");
		require_once($Prefix."classes/admin.class.php");
		require_once($Prefix."classes/finance.class.php");
	        require_once($Prefix."classes/finance.account.class.php");
		require_once($Prefix."classes/finance.journal.class.php");
		require_once($Prefix."classes/inv_tax.class.php");
		require_once($Prefix."classes/sales.customer.class.php");
		require_once($Prefix."classes/sales.quote.order.class.php");
		require_once($Prefix."classes/supplier.class.php");
		require_once($Prefix."classes/purchase.class.php");
		

		if(empty($_SERVER['HTTP_REFERER'])){
			echo 'Protected.';exit;
		}
		$objConfig=new admin();	

		CleanGet();

		(empty($_GET['Type']))?($_GET['Type']=""):("");
		(empty($_GET['editID']))?($_GET['editID']=""):("");

		/* Checking for Customer Login existance */
		if($_GET['Type'] == "Customer" && $_GET['Email'] != ""){
			$_GET['ref_id'] = $_GET['editID'];
			$_GET['user_type'] = $_GET['Type'];
			$_GET['CmpID'] = $_SESSION['CmpID'];
			if($objConfig->isUserEmailDuplicate($_GET)){	
				echo "1";exit;
			}
		
		}

		/* Checking for Supplier Login existance */
		if($_GET['Type'] == "Supplier" && $_GET['Email'] != ""){
			$_GET['ref_id'] = $_GET['editID'];
			$_GET['user_type'] = 'vendor';
			$_GET['CmpID'] = $_SESSION['CmpID'];
			if($objConfig->isUserEmailDuplicate($_GET)){	
				echo "1";exit;
			}
		
		}	



		/********Connecting to main database*********/
		$Config['DbName'] = $_SESSION['CmpDatabase'];
		$objConfig->dbName = $Config['DbName'];
		$objConfig->connect();
		/*******************************************/
		

	
	/* Checking for  Account Number existance */
	if(!empty($_GET['AccountNumber'])){
		$objBankAccount = new BankAccount();
		if($objBankAccount->isBankAccountExists($_GET['AccountNumber'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}

	/* Checking for Bank Account Number existance */
	 
	if(!empty($_GET['BankAccountNumber'])){
		$objBankAccount = new BankAccount();
		if($objBankAccount->isBankAccountNumberExists($_GET['BankAccountNumber'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}

	/* Checking for Journal NO existance */
 
	if(!empty($_GET['JournalNo'])){
		$objJournal = new journal();
		if($objJournal->isJournalNoExists($_GET['JournalNo'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}		

	/* Checking for Attribute existance */
	if(!empty($_GET['AttributeValue'])){	 
		$objCommon=new common();
		if($objCommon->isAttributeExists($_GET['AttributeValue'],$_GET['attribute_id'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}
	/* Checking for Fixed Attribute existance */
	 
	if(!empty($_GET['AttribValue'])){	 
		$objCommon=new common();
		if($objCommon->isAttribExists($_GET['AttribValue'],$_GET['attribute_id'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}

	/* Checking for Fixed Attribute existance */
	 
	if(!empty($_GET['FAttribValue'])){	
		$objCommon=new common();
		if($objCommon->isAttribExists($_GET['FAttribValue'],$_GET['attribute_id'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}

	/* Checking for termName existance */
	 
	if(!empty($_GET['termName'])){	
		$objCommon=new common();
		if($objCommon->isTermExists($_GET['termName'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}
        
        /* Checking for invoice number existance */
	 
	if(!empty($_GET['InvoiceID'])){	
		$objBankAccount = new BankAccount();
		if($objBankAccount->isInvoiceNumberExists($_GET['InvoiceID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}
        
	if(!empty($_GET['IncomeInvoiceID'])){	
		$objBankAccount = new BankAccount();
		if($objBankAccount->isInvoiceNumberExistsForIncome($_GET['IncomeInvoiceID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}
	/* Checking for Tax existance */
	 
	if(!empty($_GET['RateDes'])){	
		$objTax = new tax();
		if($objTax->isTaxNameExists($_GET['RateDes'],$_GET['Class'],$_GET['country'],$_GET['state'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
                
                
                
	}

	/* Checking for Customer existance */
	if($_GET['Type'] == "Customer" && $_GET['Email'] != ""){
		$objCustomer = new Customer();
		if($objCustomer->isEmailExists($_GET['Email'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}	
	
	/* Checking for CustCode existance */
	 
	if(!empty($_GET['CustCode'])){	
		$objCustomer = new Customer();
		if($objCustomer->isCustCodeExists($_GET['CustCode'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}

	/* Checking for Sale Invoice number existance */
	 
	if(!empty($_GET['SaleInvoiceID'])){	
		$objSale = new sale();
		if($objSale->isInvoiceNumberExists($_GET['SaleInvoiceID'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}

	/* Checking for SaleCreditID existance */
	 
	if(!empty($_GET['SaleCreditID'])){	
		$objSale=new sale();
		if($objSale->isCreditIDExists($_GET['SaleCreditID'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}

	/* Checking for Supplier Company existance */
	if(!empty($_GET['Multiple']) && $_GET['CompanyName'] != ""){
		$objSupplier = new supplier();
		if($objSupplier->isCompanyExists($_GET['CompanyName'],$_GET['editID'])){
			echo "2";
		}else{
			if($_GET['Email'] != ""){
				if($objSupplier->isEmailExists($_GET['Email'],$_GET['editID'])){
					echo "1";
				}else{
					echo "0";
				}
			}else{
				echo "0";
			}
		}
		exit;
	}


	/* Checking for Supplier existance */
	if($_GET['Type'] == "Supplier" && $_GET['Email'] != ""){
		$objSupplier = new supplier();
		if($objSupplier->isEmailExists($_GET['Email'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}	

	/* Checking for SuppCode existance */
	 
	if(!empty($_GET['SuppCode'])){	
		$objSupplier = new supplier();
		if($objSupplier->isSuppCodeExists($_GET['SuppCode'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}

	/* Checking for Supplier Company existance */
	  
	if(!empty($_GET['CompanyName'])){	
		$objSupplier = new supplier();
		if($objSupplier->isCompanyExists($_GET['CompanyName'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}

	/* Checking for PoInvoiceID existance */
	 
	if(!empty($_GET['PoInvoiceID'])){
		$objPurchase=new purchase();
		if($objPurchase->isInvoiceExists($_GET['PoInvoiceID'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}
        
        /* Checking for PoInvoiceID existance */
	 
	if(!empty($_GET['PoInvoiceIDGL'])){
		$objPurchase=new purchase();
		if($objPurchase->isInvoiceExists($_GET['PoInvoiceIDGL'],$_GET['editID'])){ 
			if(!empty($_GET['CheckForAdjust'])){
				$InvoiceEntry = $objPurchase->GetInvoiceEntryVal($_GET['PoInvoiceIDGL']);
				echo $InvoiceEntry;				
			}else{
				echo "1";
			}
		}else{
			echo "0";
		}
		exit;
	}
	

	/* Checking for PoCreditID existance */
	 
	if(!empty($_GET['PoCreditID'])){
		$objPurchase=new purchase();
		if($objPurchase->isCreditIDExists($_GET['PoCreditID'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}

	/* Checking for termName existance */
	 
	if(!empty($_GET['termName'])){
		$objCommon=new common();
		if($objCommon->isTermExists($_GET['termName'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}

	   /* checking for Group Name existance By shravan 1 july 2015*/
       
        if(!empty($_GET['AccountPlusGroup'])){            
		
               $Total_Data=explode("_",$_GET['AccountPlusGroup']);
               
               $objBankAccount = new BankAccount();
		if($objBankAccount->isGroupAccountExists($Total_Data[0],$Total_Data[1],$Total_Data[2],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}
	 
	if(!empty($_GET['GroupNumber'])){        
                $objBankAccount = new BankAccount();
		if($objBankAccount->isGroupNumberExists($_GET['GroupNumber'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}
          
	if(!empty($_GET['GroupName'])){               
                $objBankAccount = new BankAccount();
		if($objBankAccount->isGroupNameExists($_GET['GroupName'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}
	 
	if(!empty($_GET['VendorCheckNumber'])){         
                $objBankAccount = new BankAccount();
		if($objBankAccount->isVendorCheckNumberExists($_GET['VendorCheckNumber'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}

	/* Checking for BatchName existance */
	 
	if(!empty($_GET['BatchName'])){          
		$objCommon=new common();
		if($objCommon->isBatchExists($_GET['BatchName'],$_GET['BatchType'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}
	
	 /* Checking for methodName existance */
	 
	if(!empty($_GET['methodName'])){         
		$objCommon=new common();
		if($objCommon->isMethodExists($_GET['methodName'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}

?>
