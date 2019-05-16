<?php 
	/**************************************************/
	$ThisPageName = "viewSalesReturn.php";	$EditPage = 1; $SetFullPage = 1;
	/**************************************************/

	include_once("../includes/header.php");
	require_once($Prefix."classes/sales.quote.order.class.php");
	require_once($Prefix."classes/rma.sales.class.php");
	require_once($Prefix."classes/warehouse.rma.class.php");
	require_once($Prefix."classes/inv_tax.class.php");
	require_once($Prefix . "classes/warehousing.class.php");
	require_once($Prefix."classes/inv.condition.class.php");
	require_once($Prefix."classes/finance.transaction.class.php");
	require_once($Prefix."classes/finance.account.class.php");
	require_once($Prefix."classes/finance.report.class.php");
        $objSaleRma = new rmasale();
        $objWarehouseRma = new warehouserma();
        $objTax=new tax();
        $objCommon = new common();
        $objCondition=new condition();
	$objSale = new sale();
	$objTransaction=new transaction();
	$objBankAccount = new BankAccount();
	$objReport = new report();

	$Module = "Receipt";
	$ModuleIDTitle = "Receipt Number"; $ModuleID = "ReceiptID"; $PrefixSale = "RCPT";  $NotExist = NOT_EXIST_ORDER;
	$RedirectURL = "viewSalesReturn.php?curP=".$_GET['curP'];

	
	(empty($Receipt_id))?($Receipt_id=""):(""); 

 

	if(!empty($_GET['del_id'])){
		$_SESSION['mess_RECEIPT'] = RECEIPT_REMOVED;
		#$objConfig->RemoveStandAloneShipment($_GET['del_id'], 'CustomerRMA'); 
		$objWarehouseRma->RemoveReceipt($_GET['del_id']);
		header("Location:".$RedirectURL);
		exit;
	}

	if(!empty($_GET['active_id'])){
		unset($_SESSION["WSR_CreditID"]);
		$_SESSION['mess_RECEIPT'] = RECEIPT_STATUS_CHANGED;
		$objWarehouseRma->CustomerRmaPostToGL($_GET['active_id']);
		$objWarehouseRma->changeReceiptStatus($_GET['active_id']);		
		$objWarehouseRma->AddCreditSalesFromReceipt($_GET['active_id']);
		$objWarehouseRma->APInvoiceForActualFreight($_GET['active_id']); 

		/*****AutoPostToGl CreditMemo******/
		if($_SESSION["WSR_CreditID"]>0){
			$PostedOrderID = $_SESSION["WSR_CreditID"];
			$Approved = $objConfigure->getSettingVariable('SO_APPROVE');
			include_once("../includes/AutoPostToGlArCreditMemo.php");
			unset($_SESSION["WSR_CreditID"]);
		}
		/**********************************/

		/***************
		if($objConfigure->getSettingVariable('SO_SOURCE')==1){
			if(empty($arryCompany[0]['Department']) || substr_count($arryCompany[0]['Department'],2)==1){
				$objTransaction->CreateCashReceiptFromRMA($_GET['active_id'],1); 	//ReceiptID	 
			}
		}		
		/***************/
		header("Location:".$RedirectURL);
		exit;
	}


	 
	if(!empty($_POST)){
		CleanPost();	
		
		if(!empty($_POST['ReceiptNo'])){
			if($objWarehouseRma->ReceiptNo($_POST['ReceiptNo'],$_POST['rcptID'])){
				$OtherMsg = str_replace("[MODULE]","Receipt No", ALREADY_EXIST_ASSIGNED);
				$_POST['ReceiptNo'] = $objConfigure->GetNextModuleID('w_receipt', 'Receipt');  
			}
		}
		 

		unset($_SESSION["WSR_CreditID"]);
		
		if(!empty($_POST['ReturnOrderID'])){   
			$ReceiptID = $objWarehouseRma->RecieptOrder($_POST);
			$_SESSION['mess_RECEIPT'] = RECEIPT_ADDED.$OtherMsg;			
		}else if(!empty($_POST['rcptID']) && ($_POST['Submit'] == "Save")){ //not implemented
			$objWarehouseRma->UpdateSalesReturn($_POST);
			$ReceiptID = $_POST['rcptID'];
			$_SESSION['mess_RECEIPT'] = RECEIPT_UPDATED.$OtherMsg;			
		}

   		if($_POST['ReceiptStatus']=='Completed'){  
			$objWarehouseRma->CustomerRmaPostToGL($ReceiptID);
			$objWarehouseRma->AddCreditSalesFromReceipt($ReceiptID); //Credit Note and Sales Order
			#$objWarehouseRma->APInvoiceForActualFreight($ReceiptID); 


			$objSaleRma->updateRMASerialQTY($_POST);

			/*****AutoPostToGl CreditMemo******/
			if($_SESSION["WSR_CreditID"]>0){
				$PostedOrderID = $_SESSION["WSR_CreditID"];
				$Approved = $objConfigure->getSettingVariable('SO_APPROVE');
				include_once("../includes/AutoPostToGlArCreditMemo.php");
				unset($_SESSION["WSR_CreditID"]);
			}
			/**********************************/

			/***************
			if($objConfigure->getSettingVariable('SO_SOURCE')==1){
				if(empty($arryCompany[0]['Department']) || substr_count($arryCompany[0]['Department'],2)==1){
					$objTransaction->CreateCashReceiptFromRMA($ReceiptID,1); 		 
				}
			}		
			/***************/


        	}

		/*************** Standalone Shipment ***************
		if(!empty($ReceiptID)){ 			
			$objConfig->AddUpdateStandAloneShipment($ReceiptID, 'CustomerRMA'); 
		}
		/*******************************************/


		header("Location:".$RedirectURL);
		exit;          
        }
		
	if(!empty($_GET['edit']) && !empty($_GET['rtn'])){
            
            $arrySale = $objSaleRma->GetReturn($_GET['edit'],$_GET['rtn'],'RMA');
            
		#$arrySale = $objSaleRma->GetInvoice($_GET['edit'],$_GET['InvoiceID'],'Invoice');
           
              //if($_GET['this']==1){echo "<pre>"; print_r($arrySale);}
		       $OrderID   = $arrySale[0]['OrderID'];

               //$Receipt_id = $objWarehouseRma->CheckReceipt($OrderID);



		/*****************/
		/*if($Config['vAllRecord']!=1){	
			if($arrySale[0]['SalesPersonID'] != $_SESSION['AdminID'] && $arrySale[0]['AdminID'] != $_SESSION['AdminID']){
			header('location:'.$RedirectURL);
			exit;
			}
		}*/
		/*****************/

                
		if($OrderID>0){

			if(!empty($Receipt_id)){
				

              			$arrySaleItem = $objWarehouseRma->GetSaleReceiptItem($Receipt_id,$OrderID);
              
             			
              
              
			}else{
				$arrySaleItem = $objSaleRma->GetSaleItem($OrderID);
			}

			$NumLine = sizeof($arrySaleItem);

			$SaleID = $arrySale[0]['SaleID'];
			#$arryInvoiceOrder = $objSaleRma->GetInvoiceOrder($SaleID);
			 $TotalGenerateReturn = $objWarehouseRma->GetSumQtyReturned($OrderID);
			#print_r($TotalGenerateReturn);
			$QtyReturned = (!empty($TotalGenerateReturn[0]['QtyReturned']))?($TotalGenerateReturn[0]['QtyReturned']):('');
			$QtyReceipt = (!empty($TotalGenerateReturn[0]['QtyReceipt']))?($TotalGenerateReturn[0]['QtyReceipt']):('');

 
			if($QtyReturned>0 && $QtyReturned == $QtyReceipt){
		      		$HideSubmit = 1;
			  	$RtnInvoiceMess = SO_ITEM_TO_NO_RECEIPT;
			 
			}
			
			
		}else{
			$ErrorMSG = NOT_EXIST_ORDER;
		}

		#$ModuleName = "Add ".$Module;
		$NextModuleID = $objConfigure->GetNextModuleID('w_receipt','Receipt');  
	}else if(!empty($_GET['edit']) && !empty($_GET['rcpt'])){
		$arrySale = $objWarehouseRma->GetReceipt($_GET['edit'],$_GET['rcpt'],'Receipt');
		$OrderID   = $arrySale[0]['ReceiptID'];	
		$SaleID = $arrySale[0]['OrderID'];

               
		
		if($Config['vAllRecord']!=1){	
			if($arrySale[0]['SalesPersonID'] != $_SESSION['AdminID'] && $arrySale[0]['AdminID'] != $_SESSION['AdminID']){
			header('location:'.$RedirectURL);
			exit;
			}
		}
		


		if($OrderID>0){
			$arrySaleItem = $objWarehouseRma->GetSaleReceiptItem($OrderID,'');


			$NumLine = sizeof($arrySaleItem);
			
			$TotalGenerateReturn = $objSaleRma->GetQtyReturned($OrderID);

			$QtyInvoiced = (!empty($TotalGenerateReturn[0]['QtyInvoiced']))?($TotalGenerateReturn[0]['QtyInvoiced']):('');
			$QtyReturned = (!empty($TotalGenerateReturn[0]['QtyReturned']))?($TotalGenerateReturn[0]['QtyReturned']):('');

			if($QtyInvoiced>0 && $QtyInvoiced == $QtyReturned){
		      		$HideSubmit = 1;
			  $RtnInvoiceMess = SO_ITEM_TO_NO_RECEIPT;
			}
			
		}else{
			$ErrorMSG = NOT_EXIST_RECEIPT;
		}
		$ModuleName = "Edit ".$Module;
		$HideSubmit = 1;
	}else{
		$ErrorMSG = SELECT_SO_FIRST;
		$ModuleName = "Add ".$Module;
	}
 

 
 

if(empty($NumLine)) $NumLine = 1;	
$arrySaleTax = $objTax->GetTaxRate('1');

$arryWarehouse = $objWarehouseRma->ListWarehouse('', $_GET['key'], '', '', 1);
$arryPaid = $objCommon->GetAttribValue('Paid', '');
$arryTrasport = $objCommon->GetAttribValue('Transport', '');
$arryCharge = $objCommon->GetAttribValue('Charge', '');
$arryPackageType = $objCommon->GetAttribValue('PackageType', '');

$ConditionDrop  = $objCondition->GetConditionDropValue('');
$RsValhidden = $objConfigure->getSettingVariable('RES_FEE_S');

$TaxableBilling = $objConfigure->getSettingVariable('TaxableBilling');

	require_once("../includes/footer.php"); 	 
?>


