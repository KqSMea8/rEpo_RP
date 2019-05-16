<?php 
	/**************************************************/
	$ThisPageName = 'viewPoReceipt.php'; $EditPage = 1;
	/**************************************************/

	include_once("../includes/header.php");
	require_once($Prefix."classes/item.class.php");
	require_once($Prefix."classes/purchase.class.php");
	require_once($Prefix."classes/purchasing.class.php");
	require_once($Prefix."classes/finance.account.class.php");
	require_once($Prefix."classes/finance.transaction.class.php");
	require_once($Prefix."classes/finance.report.class.php");
  	require_once($Prefix."classes/function.class.php"); 
	$objCommon=new common();
	$objPurchase=new purchase();
	$objItems=new items();
	$objBankAccount= new BankAccount();
	$objTransaction=new transaction();
	$objReport = new report();
	$objFunction=new functions();
	$ModuleName = "Receipt";
	$RedirectURL = "viewPoReceipt.php?curP=".$_GET['curP']."&po=".$_GET['po'];
	$ListUrl = "viewPoReceipt.php?curP=".$_GET['curP'];
	$EditURL = "editPoReceipt.php?edit=".$_GET['edit']."&curP=".$_GET['curP']; 

	if(!empty($_GET['po'])){
		$MainModuleName = "Receipts for PO Number# ".$_GET['po'];
	}
	
	$InventoryAP = $objConfigure->getSettingVariable('InventoryAR');
	$PurchaseClearing = $objConfigure->getSettingVariable('PurchaseClearing');
	$AccountPayable = $objConfigure->getSettingVariable('AccountPayable');
	$CostOfGoods = $objConfigure->getSettingVariable('CostOfGoods');
	$AutoPostToGl = $objConfigure->getSettingVariable('AutoPostToGlAp');


/**********************/
/**********************
if(!empty($_GET['PK34534545435'])) { //editPoReceipt.php?PK34534545435=5&sortby=o.ReceiptStatus&key=Completed&asc=Asc&search=Search
	$arryReceipt=$objPurchase->ListReceipt($_GET);

	foreach ($arryReceipt as $key => $values) { 
		
		if(!empty($values['ReceiptID']) && $values['ReceiptStatus']=="Completed"){ // Post To GL 		
			$strSQL = "select p.PaymentID from p_order r inner join f_payments p on (p.ReferenceNo=r.ReceiptID and p.PostToGl='Yes' and p.PaymentType='PO Receipt') WHERE r.Module='Receipt' and r.ReceiptID='".$values['ReceiptID']."'  order by PaymentID desc limit 0,1";
			$arryPayment = $objPurchase->query($strSQL, 1);

			if(empty($arryPayment[0]['PaymentID'])){
				$arryPostData['InvoiceID'] = $values['RefInvoiceID']; 
				$arryPostData['PaymentType'] = 'PO Receipt';
				$arryPostData['AccountPayable'] = $AccountPayable;
				$arryPostData['InventoryAP'] = $InventoryAP;
				$arryPostData['PurchaseClearing'] = $PurchaseClearing;
				$arryPostData['CostOfGoods'] = $CostOfGoods;
				echo $values['ReceiptID']; pr($arryPostData,0);

				$objTransaction->PoReceiptPostToGL($values['OrderID'],$arryPostData);
			}
 
		}
		
 	}
	die;
}
**********************/
/**********************/




	if($_GET['del_id'] && !empty($_GET['del_id'])){
		$_SESSION['mess_Receipt'] = PO_RECEIPT_REMOVED;
		require_once($Prefix."classes/function.class.php");
		$objPurchase->UpdatePoStatusByReceipt($_GET['del_id']);
		$objPurchase->RemovePurchase($_GET['del_id']);		
		header("Location:".$RedirectURL);
		exit;
	}



	 if($_POST){
		CleanPost(); 


		if(!empty($_POST['RefInvoiceID']) && $_POST['GenrateInvoice']=='1' && $_POST['ReceiptStatus']=="Completed"){
			if($objPurchase->isInvoiceExists($_POST['RefInvoiceID'],'')){
				$errMsg = str_replace("[MODULE]","Invoice Number", ALREADY_EXIST);
			}
			if(!empty($errMsg)){
				$_SESSION['mess_Receipt'] = $errMsg;			
				header("Location:".$EditURL);
				exit;
			} 			
		}


		/**************/
		if($_POST['ReceiptStatus']=="Completed"){
			if(empty($AccountPayable) || empty($InventoryAP) || empty($PurchaseClearing)){
				$ErrorMSG  = SELECT_GL_RECEIPT;
			}
			if(!empty($ErrorMSG)){
				$_SESSION['mess_Receipt'] = $ErrorMSG;
				$RedirectURL = $EditURL;
				header("Location:".$RedirectURL);
				exit;
			} 
		}
		/**************/ 
		 

		 if(!empty($_POST['OrderID'])) {
			$objPurchase->UpdateReceipt($_POST);
			$order_id = $_POST['OrderID'];
			$_SESSION['mess_Receipt'] = PO_RECEIPT_UPDATED;

			$arryPurchase = $objPurchase->GetPurchase($_POST['OrderID'],'','');
			if($_POST['GenrateInvoice']==1 ) {
				$_POST['ReceiveOrderID'] = $_POST['OrderID']; 

				$_POST['PurchaseID'] =$arryPurchase[0]["PurchaseID"];	
				$_POST['Freight'] = $arryPurchase[0]["Freight"];
				$_POST['taxAmnt'] =	$arryPurchase[0]["taxAmnt"];
				//$arryPurchase[0]["tax_auths"] = $tax_auths;
				$_POST['TotalAmount'] =	$arryPurchase[0]["TotalAmount"];	
				$_POST['InvoicePaid'] =$arryPurchase[0]["InvoicePaid"];	
				$_POST['PrepaidAmount'] = $arryPurchase[0]["PrepaidAmount"];
				$_POST['InvoiceID'] = $_POST["RefInvoiceID"];
				$_POST['PostedDate'] = $_POST['RefInvoiceDate'];
				$arryPurchaseItem = $objPurchase->GetPurchaseItem($_POST['OrderID']);
				$line =0;
				foreach($arryPurchaseItem as $key => $value) {   
					$line++; 
					$_POST['sku'.$line] = $value['sku']; 
					$_POST['id'.$line] = $value['id'];
					$_POST['item_id'.$line] = $value['item_id'];
					$_POST['description'.$line]  =$value['description'];
					$_POST['price'.$line] = $value['price'];
					$_POST['qty'.$line]  = $value['qty_received']; //$value['qty'];
					//$_POST['qty_received'.$line]  = $value['qty_received'];
					$_POST['oldqty'.$line]  = $value['oldqty'];
					$_POST['DropshipCheck'.$line] = $value['DropshipCheck'];
					$_POST['DropshipCost'.$line] = $value['DropshipCost'];
					$_POST['serial_value'.$line] = $value['SerialNumbers'];
					$_POST['amount'.$line]  = $value['amount'];
					$_POST['freight_cost'.$line]  = $value['freight_cost'];
					$_POST['item_taxable'.$line]  = $value['Taxable'];
					$_POST['Condition'.$line]  = $value['Condition'];
					$_POST['tax'.$line]  = $value['tax'];
					$_POST['on_hand_qty'.$line]  = $value['on_hand_qty'];
				}
				$_POST['NumLine'] = sizeof($arryPurchaseItem);

				$InvOrderID = $objPurchase->ReceiveOrder($_POST);
				$PostedOrderID = $InvOrderID;

				
				/*****AutoPostToGl**********/
				include_once("../includes/AutoPostToGlApInvoice.php");
				/**************************/
				
				/*******Generate PDF************/			
				$PdfArray['ModuleDepName'] = "PurchaseInvoice";
				$PdfArray['Module'] = 'Invoice';
				$PdfArray['ModuleID'] = 'InvoiceID';
				$PdfArray['TableName'] =  "p_order";
				$PdfArray['OrderColumn'] =  "OrderID";
				$PdfArray['OrderID'] =  $InvOrderID;		 	
				$objConfigure->GeneratePDF($PdfArray);
				/*******************************/ 

			}
if($order_id>0 && $_POST['ReceiptStatus']=="Completed" ){

      $objPurchase->ReceivePurchaseQtyOrder($order_id);

}

			/**************/	
			if($order_id>0 && $_POST['ReceiptStatus']=="Completed"){ //Receipt Post To GL			
				$arryPostData['InvoiceGenerated'] = $_POST['GenrateInvoice']; 
				$arryPostData['InvoiceID'] = $_POST['InvoiceID']; 
				$arryPostData['PostToGLDate'] = $_POST['PostToGLDate']; //empty now
				$arryPostData['PaymentType'] = 'PO Receipt';
				$arryPostData['AccountPayable'] = $AccountPayable;
				$arryPostData['InventoryAP'] = $InventoryAP;
				$arryPostData['PurchaseClearing'] = $PurchaseClearing;
				$arryPostData['CostOfGoods'] = $CostOfGoods;

				$objTransaction->PoReceiptPostToGL($order_id,$arryPostData);
			}
			/**************/ 	



			/***********************************/
			if($_POST['InvoicePaid']==1 && $_POST['OldInvoicePaid']!=$_POST['InvoicePaid']){
				$objPurchase->sendInvPayEmail($_POST['OrderID']); 
			}
			/***********************************/

			header("Location:".$ListUrl);
			exit;
		}
	}
		

	if(!empty($_GET['edit'])){
		$arryPurchase = $objPurchase->GetPurchase($_GET['edit'],'','Receipt');
		$OrderID   = $arryPurchase[0]['OrderID'];	
		if($OrderID>0){
			$arryPurchaseItem = $objPurchase->GetPurchaseItem($OrderID);
			$NumLine = sizeof($arryPurchaseItem);

			/****************************
			$arryOrder = $objPurchase->GetPurchase('',$arryPurchase[0]['PurchaseID'],'Order');
			$arryPurchase[0]['Status'] = $arryOrder[0]['Status'];
			//////////*/
				$NextInvModuleID = $objConfigure->GetNextModuleID('p_order','Invoice');
		}else{
			$ErrorMSG = NOT_EXIST_Receipt;
		}
	}else{
		$ErrorMSG = SELECT_PO_FIRST;
	}
				

	if(empty($NumLine)) $NumLine = 1;	

	$TaxableBillingAp = $objConfigure->getSettingVariable('TaxableBillingAp');

	require_once("../includes/footer.php"); 	 
?>
