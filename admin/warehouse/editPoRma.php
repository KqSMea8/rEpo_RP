<?php 
	/**************************************************/
	$ThisPageName = "viewPoRma.php"; $EditPage = 1; $SetFullPage = 1;
	/**************************************************/

	include_once("../includes/header.php");
	require_once($Prefix."classes/item.class.php");
	require_once($Prefix."classes/rma.purchase.class.php");
	require_once($Prefix."classes/warehouse.purchase.rma.class.php");
	require_once($Prefix."classes/inv_tax.class.php");
	require_once($Prefix . "classes/warehousing.class.php");
	require_once($Prefix."classes/inv.condition.class.php");
	require_once($Prefix."classes/finance.transaction.class.php");
	require_once($Prefix."classes/finance.account.class.php");
	require_once($Prefix."classes/finance.report.class.php");
	$objItem=new items();
	$objPurchase=new purchase();
	$objWarehouse = new warehouse();
	$objTax=new tax();
	$objCommon = new common();
	$objCondition=new condition();
    	$objTransaction=new transaction();
	$objBankAccount = new BankAccount();
	$objReport = new report();

    	$Module = "RMA";
	$ModuleIDTitle = "Receipt Number"; $ModuleID = "ReceiptID"; $PrefixSale = "RMA";  $NotExist = NOT_EXIST_ORDER;
	$RedirectURL = "viewPoRma.php?curP=".$_GET['curP'];


	(empty($Receipt_id))?($Receipt_id=""):("");

	if(!empty($_GET['del_id'])){
		$_SESSION['mess_RECEIPT'] = RMA_RECEIPT_REMOVED;
		$objWarehouse->RemovePurchaseReceipt($_REQUEST['del_id']);
		header("Location:".$RedirectURL);
		exit;
	}
	if(!empty($_GET['active_id'])){	 		
		unset($_SESSION["WPR_CreditID"]);
		$_SESSION['mess_RECEIPT'] = RECEIPT_STATUS_CHANGED;
		$objWarehouse->VendorRmaPostToGL($_GET['active_id']);
		$objWarehouse->changePurchaseReceiptStatus($_GET['active_id']);
		$objWarehouse->AddCreditPOFromReceipt($_GET['active_id']);
		$objWarehouse->APInvoiceForActualFreightPO($_GET['active_id']); 


		/*****AutoPostToGl CreditMemo******/
		if($_SESSION["WPR_CreditID"]>0){
			$PostedOrderID = $_SESSION["WPR_CreditID"];
			$Approved = $objConfigure->getSettingVariable('PO_APPROVE');
			include_once("../includes/AutoPostToGlApCreditMemo.php");
			unset($_SESSION["WPR_CreditID"]);
		}
		/**********************************/

		header("Location:".$RedirectURL);
		exit;
	}
	

	if(!empty($_POST)){
		CleanPost();
		$_POST['ReceiptNo'] = $_POST['VReceiptNo'] ;
		if(!empty($_POST['ReceiptNo'])){
			if($objWarehouse->ReceiptNo($_POST['ReceiptNo'],$_POST['rcptID'])){
				$OtherMsg = str_replace("[MODULE]","Receipt No", ALREADY_EXIST_ASSIGNED);
				$_POST['ReceiptNo'] = $objConfigure->GetNextModuleID('w_receiptpo','Receipt'); 
			}
		}
		 
		 
		unset($_SESSION["WPR_CreditID"]);
		
		/******** By Ravi **********/
		for ($r=1;$r<=$_POST['NumLine']; $r++){
if($_POST['SerialValue'.$r]!=''){
			$qty=$_POST['qty'.$r];
			$SerialValue=$_POST['SerialValue'.$r];
			$allSerialArray=explode(',',$SerialValue);
			 
			if(count($allSerialArray)>$qty){
			
				$remainserial=array_slice($allSerialArray,0,$qty);
			
			$_POST['serial_value'.$r]=implode(',',$remainserial);
			
			}else{
					$_POST['serial_value'.$r]=implode(',',$allSerialArray);
			
			}
			
}
		
		}
		
	
		
		
		if(!empty($_POST['ReturnOrderID'])){		
			$ReceiptID = $objWarehouse->RecieptOrderPO($_POST);
			$_SESSION['mess_RECEIPT'] = RMA_RECEIPT_ADDED.$OtherMsg;			
		}else if(!empty($_POST['rcptID']) && ($_POST['Submit'] == "Save")){  
			$PurchaseID   = $arryPurchase[0]['PurchaseID'];
			$ReceiptID = $_POST['rcptID'];
			$objWarehouse->UpdatePurchaseReturn($_POST);
			$_SESSION['mess_RECEIPT'] = RMA_RECEIPT_UPDATED.$OtherMsg;			
		}
		if($_POST['ReceiptStatus']=='Completed'){  
		
			$objWarehouse->VendorRmaPostToGL($ReceiptID);
		
		
			$objWarehouse->AddCreditPOFromReceipt($ReceiptID); //Credit Note and PO
			
			$objPurchase->updateRMASerialQTY($_POST);

			
			#$objWarehouse->APInvoiceForActualFreightPO($ReceiptID); 
	
			/*****AutoPostToGl CreditMemo******/
			if($_SESSION["WPR_CreditID"]>0){
				$PostedOrderID = $_SESSION["WPR_CreditID"];
				$Approved = $objConfigure->getSettingVariable('PO_APPROVE');
				include_once("../includes/AutoPostToGlApCreditMemo.php");
				unset($_SESSION["WPR_CreditID"]);
			}
			/**********************************/
			
			
        	}
		header("Location:".$RedirectURL);
		exit;
	}


/***/	

if(!empty($_GET['edit']) && !empty($_GET['rtn'])){
            
	/************************ Warehouse RMA Return Info *************************/
	
        $arryRMA = $objPurchase->GetPurchaseReturn($_GET['edit'],'','RMA');
		$OrderID   = $arryRMA[0]['OrderID'];
		$InvoiceID = $arryRMA[0]["InvoiceID"];
        //$Receipt_id = $objWarehouse->CheckPurchaseReceipt($OrderID); //not required in add

		if(!empty($OrderID)){
 
			if(!empty($Receipt_id)){

                 $arryRMAItem = $objWarehouse->GetPurchaseReceiptItem($Receipt_id,$OrderID);
                 //echo "<pre>";print_r($arryRMAItem);exit;
                
			}else{
	
				$arryRMAItem = $objPurchase->GetPurchaseItem($OrderID);
				//echo "<pre>";print_r($arryRMAItem);exit;
			}
			
			//echo "<pre>";var_dump($arryPurchaseItem);
			$NumLine = sizeof($arryRMAItem);

			$PurchaseID = $arryRMA[0]['PurchaseID'];
			
			#$arryInvoiceOrder = $objSale->GetInvoiceOrder($SaleID);
			$TotalGenerateReturn = $objWarehouse->GetPurchaseSumQtyReturned($OrderID);
			
			$ValReciept = $objWarehouse->GetPurchaseSumQtyReceipt($arryRMAItem[0]["OrderID"],$arryRMAItem[0]["item_id"]);
			
		}else{
			$ErrorMSG = NOT_EXIST_ORDER;
		}

		$NextModuleID = $objConfigure->GetNextModuleID('w_receiptpo','Receipt'); 

}
	/************************ End Warehouse RMA Return Info *************************/
		
		
	/************************ Warehouse RMA Return View Info *************************/

	else if(!empty($_GET['edit']) && !empty($_GET['rcpt'])){
		
		$arryPurchase = $objWarehouse->GetPurchaseReceipt($_GET['edit'],$_GET['rcpt'],'Receipt');
		$OrderID   = $arryPurchase[0]['ReceiptID'];	
		$PurchaseID = $arryPurchase[0]['OrderID'];
	
		if($Config['vAllRecord']!=1){	
			if($arryPurchase[0]['AssignedEmpID'] != $_SESSION['AdminID'] && $arrySale[0]['AdminID'] != $_SESSION['AdminID']){
			header('location:'.$RedirectURL);
			exit;
			}
		}

		if($OrderID>0){
			
			$arryPurchase = $objWarehouse->GetPurchaseReceiptItem($OrderID,'');


			$NumLine = sizeof($arryPurchase);
			
			$TotalGenerateReturn = $objPurchase->GetPurchaseQtyReturned($OrderID);
			
			
			//if($TotalGenerateReturn[0]['QtyInvoiced'] == $TotalGenerateReturn[0]['QtyReturned']){
		     // $HideSubmit = 1;
			  //$RtnInvoiceMess = RMA_SO_ITEM_TO_NO_RECEIPT;
			//}
			
		}else{
			$ErrorMSG = NOT_EXIST_RECEIPT;
		}
		$ModuleName = "Edit ".$Module;
		//$HideSubmit = 1;
	}else{
		$ErrorMSG = SELECT_SO_FIRST;
		$ModuleName = "Add ".$Module;
	}

	
	/************************ End Warehouse RMA Return View Info *************************/

if(empty($NumLine)) $NumLine = 1;

$ConditionDrop  =$objCondition-> GetConditionDropValue('');

$arryPurchaseTax = $objTax->GetTaxRate('2');
//$arryWarehouse = $objWarehouse->ListWarehouse('', $_GET['key'], '', '', 1);
$arryPaymentMethod = $objConfigure->GetAttribFinance('PaymentMethod','');
$RestockingGlobal = $objConfigure->getSettingVariable('RES_FEE_P');

 $TaxableBillingAp = $objConfigure->getSettingVariable('TaxableBillingAp');

	require_once("../includes/footer.php"); 	 
?>



