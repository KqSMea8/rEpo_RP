<?php 
	/**************************************************/
	$ThisPageName = 'viewPoInvoice.php'; $EditPage = 1; $SetFullPage = 1;
	/**************************************************/

	include_once("../includes/header.php");
	require_once($Prefix."classes/purchase.class.php");
	require_once($Prefix."classes/purchasing.class.php");
  	require_once($Prefix."classes/finance.account.class.php");
 require_once($Prefix."classes/function.class.php");
	$objFunction=new functions();
	$objCommon=new common();
	$objPurchase=new purchase();
	$objBankAccount= new BankAccount();
	$ModuleName = "Invoice";
	$RedirectURL = "viewPoInvoice.php?curP=".$_GET['curP'];
	$EditUrl = "editPoInvoice.php?edit=".$_GET["edit"]."&curP=".$_GET["curP"]; 

	(empty($_GET['del_adj']))?($_GET['del_adj']=""):("");

	if(!empty($_GET['po'])){
		$MainModuleName = "Invoices for PO Number# ".$_GET['po'];
	}


	if($_GET['del_adj'] && !empty($_GET['del_adj'])){
		$_SESSION['mess_invoice'] = INVOICE_ADJ_REMOVED;
		$objBankAccount->RemovePOAdjustment($_GET['del_adj']);
		header("Location:".$RedirectURL);
		exit;
	}

	if($_GET['del_id'] && !empty($_GET['del_id'])){
		$_SESSION['mess_invoice'] = INVOICE_REMOVED;
		$objBankAccount->RemovePOInvoice($_GET['del_id'],$_GET['exp']);
		header("Location:".$RedirectURL);
		exit;
	}



	 if($_POST){
		 CleanPost();
		if($_POST['TotalAmount']<=0){
			 $errMsg = "Grand Total must be greater than 0.";
		}

		if(!empty($_POST['PoInvoiceID'])){
			if($objPurchase->isInvoiceExists($_POST['PoInvoiceID'],$_POST['OrderID'])){
				//$errMsg = str_replace("[MODULE]","Invoice Number", ALREADY_EXIST);
				$OtherMsg = str_replace("[MODULE]","Invoice Number", ALREADY_EXIST_ASSIGNED);
				$_POST['PoInvoiceID'] = $objConfigure->GetNextModuleID('p_order','Invoice');
			}
		}

		if(empty($errMsg)) {


			 if(!empty($_POST['OrderID'])) {
				$objPurchase->UpdatePOInvoice($_POST);
				$order_id = $_POST['OrderID'];
				$_SESSION['mess_invoice'] = INVOICE_UPDATED.$OtherMsg;
			
				if($_FILES['UploadDocuments']['name'] != ''){ 

					$imageName = "Document_".$order_id;
					$FileInfoArray['FileType'] = "Scan";
					$FileInfoArray['FileDir'] = $Config['P_DocomentDir'];
					$FileInfoArray['FileID'] =  $imageName;
					$FileInfoArray['OldFile'] = $_POST['OldUploadDocuments'];
					$FileInfoArray['UpdateStorage'] = '1';
					$ResponseArray = $objFunction->UploadFile($_FILES['UploadDocuments'], $FileInfoArray);

					if($ResponseArray['Success']=="1"){
						
						$objPurchase->UpdateUploadDocuments($ResponseArray['FileName'],$order_id);
					 
					}else{
						$ErrorMsg = $ResponseArray['ErrorMsg'];
					}



				if(!empty($ErrorMsg)){
				   $_SESSION['mess_Invoice'] .= '<br><br>'.$ErrorMsg;
				}


	}

				/***********************************
				if($_POST['InvoicePaid']==1 && $_POST['OldInvoicePaid']!=$_POST['InvoicePaid']){
					$objPurchase->sendInvPayEmail($_POST['OrderID']); 
				}
				/***********************************/
			/***********************************/
			$_POST['ModuleType'] ='PurchasesInvoice';
			$objConfig->AddUpdateLogs($order_id, $_POST);
			/***********************************/


			/*******Generate PDF************/			
			$PdfArray['ModuleDepName'] = "PurchaseInvoice";
			$PdfArray['Module'] = 'Invoice';
			$PdfArray['ModuleID'] = 'InvoiceID';
			$PdfArray['TableName'] =  "p_order";
			$PdfArray['OrderColumn'] =  "OrderID";
			$PdfArray['OrderID'] =  $order_id;		 	
			$objConfigure->GeneratePDF($PdfArray);
			/*******************************/ 



				header("Location:".$RedirectURL);
				exit;
			}
		}
	}
		

	if(!empty($_GET['edit'])){

		//$ErrorMSG = UNDER_MAINT;

		$arryPurchase = $objPurchase->GetPurchase($_GET['edit'],'','Invoice');
		$OrderID   = $arryPurchase[0]['OrderID'];
		//echo '<pre>';print_r($arryPurchase);echo '</pre>';	
		if($OrderID>0){
			$arryPurchaseItem = $objPurchase->GetPurchaseItem($OrderID);
			$NumLine = sizeof($arryPurchaseItem);

			/****************************
			$arryOrder = $objPurchase->GetPurchase('',$arryPurchase[0]['PurchaseID'],'Order');
			$arryPurchase[0]['Status'] = $arryOrder[0]['Status'];
			//////////*/

			$BankAccount='';
			if(strtolower(trim($arryPurchase[0]['PaymentTerm']))=='prepayment' && !empty($arryPurchase[0]['AccountID'])){
			    $arryBankAccount = $objBankAccount->getBankAccountById($arryPurchase[0]['AccountID']);
			    $BankAccount = $arryBankAccount[0]['AccountName'] . ' [' . $arryBankAccount[0]['AccountNumber'] . ']';
			}

		}else{
			$ErrorMSG = NOT_EXIST_INVOICE;
		}
	}else{
		$ErrorMSG = SELECT_PO_FIRST;
	}
				

	if(empty($NumLine)) $NumLine = 1;	

	$TaxableBillingAp = $objConfigure->getSettingVariable('TaxableBillingAp');

	$arryPaymentMethod = $objConfigure->GetAttribFinance('PaymentMethod','');
	/*****************************/
	$arryAllocationSetting = $objConfigure->getSettingVariableAll('ALLOC_METHOD_P');
	$AllocationMethod = $arryAllocationSetting[0]['setting_value'];
	$arryAllocation = explode(",",$arryAllocationSetting[0]['options']);
	$AllocDropdown = '<select name="AllocationMethod" id="AllocationMethod" class="textbox" onchange="Javascript:ProcessFreight();" style="width:138px">';
	foreach($arryAllocation as $Allocation){
		$sel = ($AllocationMethod==$Allocation)?("selected"):("");
		$AllocDropdown .= '<option value="'.$Allocation.'" '.$sel.'>'.$Allocation.'</option>';
	}
	$AllocDropdown .= '</select>';
	/*****************************/
	require_once("../includes/footer.php"); 	 
?>
