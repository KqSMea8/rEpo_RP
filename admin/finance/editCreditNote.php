<?php 
	/**************************************************/
	$ThisPageName = 'viewCreditNote.php'; $EditPage = 1; $SetFullPage = 1;
	/**************************************************/

	include_once("../includes/header.php");
	require_once($Prefix."classes/sales.quote.order.class.php");
	require_once($Prefix."classes/inv_tax.class.php");
	require_once($Prefix."classes/sales.class.php");
        require_once($Prefix."classes/inv.condition.class.php");
	require_once($Prefix."classes/finance.account.class.php");
	require_once($Prefix."classes/item.class.php");
	require_once($Prefix . "classes/finance.transaction.class.php");
	require_once($Prefix."classes/function.class.php"); 
	require_once($Prefix."classes/archive.class.php");

	$objFunction=new functions();
	$objTransaction = new transaction();
	$objCommon = new common();
	$objSale = new sale();
	$objTax=new tax();
	$objCondition=new condition();
	$objBankAccount=new BankAccount();
	$objArchive = new archive();

	$ModuleName = "Credit Memo";
	$RedirectURL = "viewCreditNote.php?curP=".$_GET['curP'];
	$AutomaticApprove = $objConfigure->getSettingVariable('SO_APPROVE'); 
	 

	
	if(!empty($_GET['del_id'])){
		$_SESSION['mess_credit'] = CREDIT_REMOVED;
		$objArchive->AddToArchiveSO($_GET['del_id']);
		$objSale->RemoveCreditNote($_GET['del_id']);
		header("Location:".$RedirectURL);
		exit;
	}



	 if ($_POST) {  
	    	CleanPost();

		if(!empty($_POST['SaleCreditID'])){
			if($objSale->isCreditIDExists($_POST['SaleCreditID'],$_POST['OrderID'])){
				//$errMsg = str_replace("[MODULE]","Credit Memo ID", ALREADY_EXIST);
				$OtherMsg = str_replace("[MODULE]","Credit Memo ID", ALREADY_EXIST_ASSIGNED);
				$_POST['SaleCreditID'] = $objConfigure->GetNextModuleID('s_order','Credit');
			}
		}

		if(empty($errMsg)) {
			$_POST['CreditID'] = $_POST['SaleCreditID'];
		
			if($_POST['AccountID']>0){
				$_POST['TotalAmount'] = $_POST['GlAmount'];
			}
			/*****************/

			 if(empty($_POST['CustCode'])) {
				$errMsg = ENTER_CUSTOMER_ID;
			 } else {
				if(!empty($_POST['OrderID'])) {
					$objSale->UpdateSale($_POST);
					$order_id = $_POST['OrderID'];
					$_SESSION['mess_credit'] = CREDIT_UPDATED.$OtherMsg;
				}else{	 
					  $_POST['Approved'] = $AutomaticApprove;
					  $order_id = $objSale->AddSale($_POST); 
					  $_SESSION['mess_credit'] = CREDIT_ADDED.$OtherMsg;
					  $PostedOrderID = $order_id; 
					  $Approved = $_POST['Approved'];
				}

				if($_POST['AccountID']>0){
					$objSale->RemoveSaleItem($order_id); 
				}else{
					$objSale->AddUpdateItem($order_id, $_POST); 
				}

				/*******Generate PDF************/			
				$PdfArray['ModuleDepName'] = "SalesCreditMemo";
				$PdfArray['Module'] = "Credit";
				$PdfArray['ModuleID'] = "CreditID";
				$PdfArray['TableName'] =  "s_order";
				$PdfArray['OrderColumn'] =  "OrderID";
				$PdfArray['OrderID'] =  $order_id;				 					$objConfigure->GeneratePDF($PdfArray);
				/*******************************/
				

				/*****AutoPostToGl**********/
				include_once("../includes/AutoPostToGlArCreditMemo.php");
				/**************************/

				header("Location:".$RedirectURL);
				exit;
				
			}
		  }
		}
		

	if(!empty($_GET['edit'])){
		$arrySale = $objSale->GetSale($_GET['edit'],'','');
		$OrderID   = $arrySale[0]['OrderID'];	
		if($OrderID>0){
			$arrySaleItem = $objSale->GetSaleItem($OrderID);
			$NumLine = sizeof($arrySaleItem);
		}else{
			$ErrorMSG = $NotExist;
		}
	}else{
		$NextModuleID = $objConfigure->GetNextModuleID('s_order','Credit');
	}
				

	if(empty($NumLine)) $NumLine = 1;	

 $arrySaleTax = $objTax->GetTaxByLocation('1',$arryCurrentLocation[0]['country_id'],$arryCurrentLocation[0]['state_id']);
$ConditionDrop  =$objCondition-> GetConditionDropValue('');

	//$arrySaleTax = $objTax->GetTaxRate('1');
	$arryPaymentTerm = $objConfigure->GetTerm('','1');
	$arryPaymentMethod = $objConfigure->GetAttribFinance('PaymentMethod','');
	$arryShippingMethod = $objConfigure->GetAttribValue('ShippingMethod','');
	$arryOrderStatus = $objCommon->GetFixedAttribute('OrderStatus','');		
	$arryOrderType = $objCommon->GetFixedAttribute('OrderType','');		
	$RsValhidden = $objConfigure->getSettingVariable('RES_FEE_S');
 	$TaxableBilling = $objConfigure->getSettingVariable('TaxableBilling');
 
	if($arrySale[0]['AccountID']>0)$Config['IncludeAccount'] = $arrySale[0]['AccountID'];
	$Config['NormalAccount']=1;
	$arryBankAccount=$objBankAccount->getBankAccountWithAccountType();
	//$ErrorMSG = UNDER_CONSTRUCTION; 

	require_once("../includes/footer.php"); 	 
?>


