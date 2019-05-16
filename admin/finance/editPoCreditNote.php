<?php 
	/**************************************************/
	$ThisPageName = 'viewPoCreditNote.php'; $EditPage = 1; $SetFullPage = 1;
	/**************************************************/

	include_once("../includes/header.php");
	require_once($Prefix."classes/purchase.class.php");
	require_once($Prefix."classes/inv_tax.class.php");
	require_once($Prefix."classes/purchasing.class.php");
	require_once($Prefix."classes/finance.account.class.php");
	require_once($Prefix . "classes/finance.transaction.class.php");
	require_once($Prefix."classes/function.class.php"); 
	$objFunction=new functions();
	$objTransaction = new transaction();
	$objCommon=new common();
	$objPurchase=new purchase();
	$objTax=new tax();
	$objBankAccount=new BankAccount();
	$ModuleName = "Credit Memo";
	$RedirectURL = "viewPoCreditNote.php?curP=".$_GET['curP'];
	$AutomaticApprove = $objConfigure->getSettingVariable('PO_APPROVE'); 

	if($_GET['del_id'] && !empty($_GET['del_id'])){
		$_SESSION['mess_credit'] = CREDIT_REMOVED;
		$objPurchase->RemovePurchase($_GET['del_id']);
		header("Location:".$RedirectURL);
		exit;
	}


	
	 if($_POST) { 
		CleanPost();
		if(!empty($_POST['PoCreditID'])){
			if($objPurchase->isCreditIDExists($_POST['PoCreditID'],$_POST['OrderID'])){
				//$errMsg = str_replace("[MODULE]","Credit Memo ID", ALREADY_EXIST);
				$OtherMsg = str_replace("[MODULE]","Credit Memo ID", ALREADY_EXIST_ASSIGNED);
				$_POST['PoCreditID'] = $objConfigure->GetNextModuleID('p_order','Credit');
			}
		}

		if(empty($errMsg)) {

			$_POST['CreditID'] = $_POST['PoCreditID'];

			if($_POST['AccountID']>0){
				$_POST['TotalAmount'] = $_POST['GlAmount'];
			}		
			/***************/
			 if(empty($_POST['SuppCode'])) {
				$errMsg = ENTER_SUPPLIER_ID;
			 }else {
				if(!empty($_POST['OrderID'])) {
					$objPurchase->UpdatePurchase($_POST);
					$order_id = $_POST['OrderID'];
					$_SESSION['mess_credit'] = CREDIT_UPDATED.$OtherMsg;
				}else{	 
					$_POST['Approved'] = $AutomaticApprove;
					$order_id = $objPurchase->AddPurchase($_POST); 
					$_SESSION['mess_credit'] = CREDIT_ADDED.$OtherMsg;
					$PostedOrderID = $order_id; 
					$Approved = $_POST['Approved'];
				}

				if($_POST['AccountID']>0){
					$objPurchase->RemovePOItem($order_id); 
				}else{
					$objPurchase->AddUpdateItem($order_id, $_POST); 
				}


				/*******Generate PDF************/			
				$PdfArray['ModuleDepName'] = "PurchaseCreditMemo";
				$PdfArray['Module'] = "Credit";
				$PdfArray['ModuleID'] = "CreditID";
				$PdfArray['TableName'] =  "p_order";
				$PdfArray['OrderColumn'] =  "OrderID";
				$PdfArray['OrderID'] =  $order_id;				 					$objConfigure->GeneratePDF($PdfArray);
				/*******************************/


				/*****AutoPostToGl**********/
				include_once("../includes/AutoPostToGlApCreditMemo.php");
				/**************************/
				
				header("Location:".$RedirectURL);
				exit;
				
			}
		   }
		}
		

	if(!empty($_GET['edit'])){
		$arryPurchase = $objPurchase->GetPurchase($_GET['edit'],'','Credit');
		$OrderID   = $arryPurchase[0]['OrderID'];	
		if($OrderID>0){
			$arryPurchaseItem = $objPurchase->GetPurchaseItem($OrderID);
			$NumLine = sizeof($arryPurchaseItem);


			if(!empty($arryPurchase[0]['AccountID']) && empty($NumLine)){
				$arryPurchaseItem = $objConfigure->GetDefaultArrayValue('p_order_item');
			}



		}else{
			$ErrorMSG = NOT_EXIST_CREDIT;
		}
	}else{
		$arryPurchase[0]['Taxable'] = 'Yes';
		$NextModuleID = $objConfigure->GetNextModuleID('p_order','Credit');
	}
				

	if(empty($NumLine)) $NumLine = 1;	



	$arryPurchaseTax = $objTax->GetTaxByLocation('2',$arryCurrentLocation[0]['country_id'],$arryCurrentLocation[0]['state_id']);
	//$arryPurchaseTax = $objTax->GetTaxRate('2');
	$arryOrderStatus = $objCommon->GetFixedAttribute('OrdStatus','');		

	if($arryPurchase[0]['AccountID']>0)$Config['IncludeAccount'] = $arryPurchase[0]['AccountID'];
	$Config['NormalAccount']=1;
	$arryBankAccount=$objBankAccount->getBankAccountWithAccountType();
	$RsValhidden = $objConfigure->getSettingVariable('RES_FEE_P');
	//$ErrorMSG = UNDER_CONSTRUCTION; 

	$TaxableBillingAp = $objConfigure->getSettingVariable('TaxableBillingAp');

	require_once("../includes/footer.php"); 	 
?>


