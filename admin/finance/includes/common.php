<?
/*****Variable Define & Default Array for empty edit********/
/****************************/  

(empty($_GET['c']))?($_GET['c']=""):(""); 
(empty($_GET['s']))?($_GET['s']=""):(""); 
(empty($_GET['d']))?($_GET['d']=""):(""); 
(empty($_GET['st']))?($_GET['st']=""):(""); 
(empty($_GET['dv']))?($_GET['dv']=""):(""); 
(empty($_GET['From']))?($_GET['From']=""):(""); 
(empty($_GET['To']))?($_GET['To']=""):("");
(empty($_GET['CustCode']))?($_GET['CustCode']=""):("");
(empty($_GET['SuppCode']))?($_GET['SuppCode']=""):(""); 
(empty($_GET['Tax']))?($_GET['Tax']=""):(""); 
(empty($_GET['id']))?($_GET['id']=""):(""); 
(empty($_GET['link']))?($_GET['link']=""):(""); 
(empty($_GET['creditnote']))?($_GET['creditnote']=""):(""); 
(empty($_GET['state_id']))?($_GET['state_id']=""):(""); 
(empty($_GET['country_id']))?($_GET['country_id']=""):(""); 

(empty($CurrentPeriodDate))?($CurrentPeriodDate=""):(""); 
(empty($IECurrentPeriod))?($IECurrentPeriod=""):(""); 
(empty($strBackDate))?($strBackDate=""):(""); 
(empty($ModuleName))?($ModuleName=""):(""); 
(empty($EcommFlag))?($EcommFlag=""):(""); 
(empty($EmpID))?($EmpID=""):(""); 
(empty($SuppID))?($SuppID=""):(""); 
 #echo $MainModuleID;

if($EditPage==1 && empty($_GET['edit'])){
	switch($MainModuleID) {
		case '816': 
			$arryGroup = $objConfigure->GetDefaultArrayValue('f_group');
			$arryBankAccount = $objConfigure->GetDefaultArrayValue('f_account');
			break;
		case '817': 
			$arryTransaction = $objConfigure->GetDefaultArrayValue('f_transaction');
			break;
		case '819': 
			$arryTax = $objConfigure->GetDefaultArrayValue('inv_tax_rates');
			break;
		case '825': 
			$arryTransaction = $objConfigure->GetDefaultArrayValue('f_transaction');
			break;
		case '865': 
			$arrySale = $objConfigure->GetDefaultArrayValue('s_order');
			$arrySaleItem  = $objConfigure->GetDefaultArrayValue('s_order_item');
			$arryOtherIncome = $objConfigure->GetDefaultArrayValue('f_income');
			$arryMultiAccount = $objConfigure->GetDefaultArrayValue('f_multi_account');
			break;	
		case '866': 
			$arrySale = $objConfigure->GetDefaultArrayValue('s_order');
			$arrySaleItem  = $objConfigure->GetDefaultArrayValue('s_order_item');
			break;
		case '870': 
			$arrySupplier = $objConfigure->GetDefaultArrayValue('p_supplier');
			break;	
		case '876': 
			$arryBatch = $objConfigure->GetDefaultArrayValue('f_batch');
			break;
		case '880': 
			$arryPurchase = $objConfigure->GetDefaultArrayValue('p_order');
			$arryPurchaseItem = $objConfigure->GetDefaultArrayValue('p_order_item');
			$arryOtherExpense = $objConfigure->GetDefaultArrayValue('f_expense');
			$arryMultiAccount = $objConfigure->GetDefaultArrayValue('f_multi_account_payment');
			break;	
		case '881': 
			$arryPurchase = $objConfigure->GetDefaultArrayValue('p_order');
			$arryPurchaseItem = $objConfigure->GetDefaultArrayValue('p_order_item');
			break;	
		case '823': 
			$arryJournal = $objConfigure->GetDefaultArrayValue('f_gerenal_journal');
			$arryJournalEntry = $objConfigure->GetDefaultArrayValue('f_gerenal_journal_entry');
			$arryJournalAttachment = $objConfigure->GetDefaultArrayValue('f_gerenal_journal_attachment');
			break;
				 	
	}
	 
}

/****************************/
/****************************/


?>
