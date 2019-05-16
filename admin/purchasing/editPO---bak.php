<?php 
	/**************************************************/
	$ThisPageName = 'viewPO.php'; $EditPage = 1; $SetFullPage = 1;
	/**************************************************/

include_once("../includes/header.php");
require_once($Prefix."classes/item.class.php");
require_once($Prefix."classes/purchase.class.php");
require_once($Prefix."classes/inv_tax.class.php");
require_once($Prefix."classes/purchasing.class.php");
require_once($Prefix."classes/sales.quote.order.class.php");
require_once($Prefix."classes/inv.condition.class.php");
require_once($Prefix."classes/supplier.class.php");
require_once($Prefix."classes/finance.account.class.php");
require_once($Prefix."classes/warehouse.class.php");
require_once($Prefix."classes/function.class.php"); 
require_once($Prefix."classes/warehouse.shipment.class.php");
$objShipment = new shipment();
	$objFunction=new functions();
	$objCommon=new common();
	$objPurchase=new purchase();
	$objSale = new sale();
	$objTax=new tax();
	$objBankAccount = new BankAccount();
	$objWarehouse = new warehouse();
	$objCondition = new condition();		
	$objSupplier = new supplier();
  $objItem=new items();

	(!$_GET['module'])?($_GET['module']='Quote'):(""); 
	$module = $_GET['module'];
	/**************/
	$ModuleArray = array('Quote','Order'); 
	if(!in_array($_GET['module'],$ModuleArray)){
		header("location:home.php");die;		 
	}
	/**************/
	
	$ModuleName = "Purchase ".$_GET['module'];

	$RedirectURL = "viewPO.php?module=".$module."&curP=".$_GET['curP'];
	$EditUrl = "editPO.php?module=".$module."&curP=".$_GET['curP'];


	if($module=='Quote'){	
		$ModuleIDTitle = "Quote Number"; $ModuleID = "QuoteID"; $PrefixPO = "QT"; 
		$UpdateMSG = PO_QUOTE_UPDATED;  $AddMSG = PO_QUOTE_ADDED; $RemoveMSG = PO_QUOTE_REMOVED; $NotExist = NOT_EXIST_QUOTE; 

		$ApproveMSG = APPROVE_QT_MSG; $ApprovedSucc = APPROVED_QT;
		$CancelMSG = CANCEL_QT_MSG; $CanceledSucc = CANCELED_QT;
		$RejectMSG = REJECT_QT_MSG; $RejectedSucc = REJECT_QT;

		
	}else{
		$ModuleIDTitle = "PO Number"; $ModuleID = "PurchaseID"; $PrefixPO = "PO"; 
		$UpdateMSG = PO_ORDER_UPDATED;  $AddMSG = PO_ORDER_ADDED; $RemoveMSG = PO_ORDER_REMOVED; $NotExist = NOT_EXIST_ORDER;

		$ApproveMSG = APPROVE_PO_MSG; $ApprovedSucc = APPROVED_PO;
		$CancelMSG = CANCEL_PO_MSG; $CanceledSucc = CANCELED_PO;
		$RejectMSG = REJECT_PO_MSG; $RejectedSucc = REJECT_PO;
		
	}




	 if(!empty($_GET['Approve'])){
		$_SESSION['mess_purchase'] = $ApprovedSucc;
		$objPurchase->AuthorizePurchase($_GET['Approve'],1,'');
		$EditUrl .= "&edit=".$_GET['Approve'];
		header("Location:".$EditUrl);
		exit;
	}else if(!empty($_GET['Cancel'])){
		$_SESSION['mess_purchase'] = $CanceledSucc;
		$objPurchase->AuthorizePurchase($_GET['Cancel'],2,'');
		$EditUrl .= "&edit=".$_GET['Cancel'];
		header("Location:".$EditUrl);
		exit;
	}else if(!empty($_GET['Reject'])){
		$_SESSION['mess_purchase'] = $RejectedSucc;
		$objPurchase->AuthorizePurchase($_GET['Reject'],3,'');
		$EditUrl .= "&edit=".$_GET['Reject'];
		header("Location:".$EditUrl);
		exit;

	}else if(!empty($_GET['Complete'])){
		$_SESSION['mess_purchase'] = COMPLETED_PO;
		$objPurchase->AuthorizePurchase($_GET['Complete'],'',1);
		$EditUrl .= "&edit=".$_GET['Complete'];
		header("Location:".$EditUrl);
		exit;

	}else if($_GET['del_id'] && !empty($_GET['del_id'])){
		$retn =1;
	  $retn = $objPurchase->RemovePurchase($_GET['del_id']);
		if($retn!=1){
		$_SESSION['mess_purchase'] = ERROREDI_REMOVED."<br> <a class='action_bt' href='editPO.php?module=Order&rquest=".$retn."'>Yes</a>";
		}else{
		$_SESSION['mess_purchase'] = $RemoveMSG;
		}
		header("Location:".$RedirectURL);
		exit;
	}else if(!empty($_GET['rquest'])){
	
	   $objPurchase->RequestCancellationSO($_GET['rquest']);
	   
	   $_SESSION['mess_purchase'] = REQUEST_SEND;
	
	header("Location:".$RedirectURL);
		exit;
	}


	
	 if($_POST) {
	 
	              if(strtolower(trim($_POST['PaymentTerm']))=='prepayment'){
					$_POST["AccountID"] = $_POST["BankAccount"] ;
		      }	
			CleanPost();
			if(!empty($_POST['ConvertOrderID'])) {
				$objPurchase->ConvertToPo($_POST['ConvertOrderID'],$_POST['PurchaseID']);
				$_SESSION['mess_purchase'] = QUOTE_TO_PO_CONVERTED;
				$RedirectURL = "viewPO.php?module=Order";
				header("Location:".$RedirectURL);
				exit;
			 } 

			 
			 if($_POST['OrderType']!='Dropship') {
				$_POST['SaleID']='';
			 }

			/***********************/
			if($_POST['PrepaidFreight']!='1') {
				$_POST['PrepaidVendor']='';
				$_POST['PrepaidAmount']='';
			}


			/***********************/
			if(empty($_POST['SuppCode'])) {
				$errMsg = ENTER_SUPPLIER_ID;
			}else if(!empty($_POST['PurchaseID']) && $module=='Order'){
				if($objPurchase->isPurchaseExists($_POST['PurchaseID'],$_POST['OrderID'])){
					//$errMsg = str_replace("[MODULE]","PO Number", ALREADY_EXIST);
					$OtherMsg = str_replace("[MODULE]","PO Number", ALREADY_EXIST_ASSIGNED);
					$_POST['PurchaseID'] = $objConfigure->GetNextModuleID('p_order',$module);
				}
			}else if(!empty($_POST['QuoteID']) && $module=='Quote'){
				if($objPurchase->isQuoteExists($_POST['QuoteID'],$_POST['OrderID'])){
					//$errMsg = str_replace("[MODULE]","Quote Number", ALREADY_EXIST);
					$OtherMsg = str_replace("[MODULE]","Quote Number", ALREADY_EXIST_ASSIGNED);
					$_POST['QuoteID'] = $objConfigure->GetNextModuleID('p_order',$module);
				}
			}
			/***********************/ 


			 if(empty($errMsg)) {
				if(!empty($_POST['OrderID'])) {
					$objPurchase->UpdatePurchase($_POST);
					$order_id = $_POST['OrderID'];
					$objPurchase->EdiUpdateSo($_POST);
					$_SESSION['mess_purchase'] = $UpdateMSG.$OtherMsg;
				}else{	
					if($module=='Order'){
						$AutomaticApprove = $objConfigure->getSettingVariable('PO_APPROVE');
						$_POST['Approved'] = $AutomaticApprove; 
					}

					$order_id = $objPurchase->AddPurchase($_POST); 
					$_SESSION['mess_purchase'] = $AddMSG.$OtherMsg;
					
					$objPurchase->sendPurchaseEmail($order_id);					
				}

				/**********
				if(!empty($_POST['DelItem'])){
					$strSQL = "select sku from p_order_item where id in(".$_POST['DelItem'].")"; 
					$arryDelItem = $objPurchase->query($strSQL, 1);
					foreach($arryDelItem as $key=>$values){ 
						$arrayDelSku[] =  $values['sku'];
					}	

				}
				/**********/	

				$objPurchase->AddUpdateItem($order_id, $_POST); 
				
				if(!empty($_POST['SaleID']) && $_POST['OrderType']=='Dropship' && $module=='Order')  {
					$objPurchase->AlterSalesForDropship($order_id, $_POST); 
				}


				/***********************************/
				if($_POST['EmpID']>0 && $_POST['OldEmpID']!=$_POST['EmpID']){
					$objPurchase->sendAssignedEmail($order_id, $_POST['EmpID']); 
				}
				/***********************************/
				/***************log by sanjiv********************/
				$_POST['ModuleType'] ='Purchases'.$module;
				$objConfig->AddUpdateLogs($order_id, $_POST);
				/***********************************/


				/*******Generate PDF************/			
				$PdfArray['ModuleDepName'] = "Purchase";
				$PdfArray['Module'] = $module;
				$PdfArray['ModuleID'] = $ModuleID;
				$PdfArray['TableName'] =  "p_order";
				$PdfArray['OrderColumn'] =  "OrderID";
				$PdfArray['OrderID'] =  $order_id;		 	
				$objConfigure->GeneratePDF($PdfArray);
				/*******************************/ 

				header("Location:".$RedirectURL);
				exit;
				
			}
		}
		



	if(!empty($_GET['edit'])){
		$arryPurchase = $objPurchase->GetPurchase($_GET['edit'],'',$module);
		$OrderID   = $arryPurchase[0]['OrderID'];
		$SaleID   = $arryPurchase[0]['SaleID'];

		/*****************/
		if($Config['vAllRecord']!=1){
			if($arryPurchase[0]['AssignedEmpID'] != $_SESSION['AdminID'] && $arryPurchase[0]['AdminID'] != $_SESSION['AdminID']){
			header('location:'.$RedirectURL);
			exit;
			}
		}
		/*****************/

	
		if($OrderID>0){
			$arryPurchaseItem = $objPurchase->GetPurchaseItem($OrderID);
			$NumLine = sizeof($arryPurchaseItem);
			$NumPoItem = sizeof($arryPurchaseItem);
		}else{
			$ErrorMSG = $NotExist;
		}
	}else{
		$arryPurchase[0]['Taxable'] = 'Yes';
		//Update by bhoodev 17Mar//	
		//$_GET['primaryVendor'] = 1;
		//$arryPurchase = $objSupplier->GetSupplierList($_GET);
		$Config['primaryVendor'] = '1';
		//$arryPurchase = $objSupplier->GetShippingBilling('','billing',null,'');
//echo "<pre>";
//print_r($arryPurchase);

		//End//
		$NextModuleID = $objConfigure->GetNextModuleID('p_order',$module);
		
	}
				

	$arryPurchaseTax = $objTax->GetTaxByLocation('2',$arryCurrentLocation[0]['country_id'],$arryCurrentLocation[0]['state_id']);

	//$arryPurchaseTax = $objTax->GetTaxRate('2');

	$arryPaymentTerm = $objConfigure->GetTerm('','1');
	$arryPaymentMethod = $objConfigure->GetAttribFinance('PaymentMethod','');
	$arryShippingMethod = $objConfigure->GetAttribValue('ShippingMethod','attribute_value');
	$arryOrderType = $objCommon->GetFixedAttribute('OrderType','');		
	$AllocationMethod = $objConfigure->getSettingVariable('ALLOC_METHOD_P');
	$arryBankAccount=$objBankAccount->getBankAccountForPaidPayment();

	/*******************/
	$OrderIsOpen = '';
	$CancelledRejected = '';
	$Completed = '';
	$arryOrderStatusTemp = $objCommon->GetFixedAttribute('OrderStatus','');		
	for($i=0;$i<sizeof($arryOrderStatusTemp);$i++) {
		$arryOrderStatus[] = $arryOrderStatusTemp[$i]['attribute_value'];
	}
	if(in_array($arryPurchase[0]['Status'],$arryOrderStatus) && $arryPurchase[0]['Approved'] == 1){
		$OrderIsOpen = 1;
	}else if($arryPurchase[0]['Status'] == 'Cancelled' || $arryPurchase[0]['Status'] == 'Rejected'){
		$CancelledRejected = 1;
		$HideSubmit = 1;
	}else if($arryPurchase[0]['Status'] == 'Completed'){
		$Completed = 1;
		//$HideSubmit = 1;
	}
	/*******************/
 	if(!empty($_GET['SaleID'])){
		include("includes/html/box/dropship_so.php"); 
	}else if(empty($_GET['edit'])){
    		$arryWarehouse = $objWarehouse->GetDefaultWarehouseBrief(1);

    		$arryPurchase[0]['wName'] =  $arryWarehouse[0]['warehouse_name'];
		$arryPurchase[0]['wAddress'] =  $arryWarehouse[0]['Address'];
		$arryPurchase[0]['wCity'] =  $arryWarehouse[0]['City'];
		$arryPurchase[0]['wState'] =  $arryWarehouse[0]['State'];
		$arryPurchase[0]['wCountry'] =  $arryWarehouse[0]['Country'];
		$arryPurchase[0]['wZipCode'] =  $arryWarehouse[0]['ZipCode'];
		$arryPurchase[0]['wContact'] =  $arryWarehouse[0]['ContactName'];
		$arryPurchase[0]['wMobile'] =  $arryWarehouse[0]['mobile_number'];
		$arryPurchase[0]['wLandline'] =  $arryWarehouse[0]['phone_number'];
		$arryPurchase[0]['wEmail'] =  $arryWarehouse[0]['email'];
	}
	
	
	/*******Setting Default Shipping Account*********/
	$arryShipAccount=$objShipment->ListShipAccount($arryPurchase[0]['ShippingMethod'],$arryPurchase[0]['SuppCode']);
			
			if(!empty($arryPurchase[0]['ShippingAccountNumber'])){
				if(!empty($arryShipAccount)){ 					 
					foreach($arryShipAccount as $vals) {
						if($vals['api_account_number']==$arryPurchase[0]['ShippingAccountNumber']){
						 $ShipAccExist=1;break;
						}
					}
				}
				if(empty($ShipAccExist)) 
					$arryShipAccount[]['api_account_number'] = $arryPurchase[0]['ShippingAccountNumber'];		 
			 
			}
			/**********************/
	/************************************/
	$_GET['Status'] = '1';
	$arryVendor = $objSupplier->GetSupplierList($_GET);
        $ConditionDrop  =$objCondition-> GetConditionDropValue();
 $WarehouseDrop  =$objCondition-> GetWarehouseDropValue('');

	$_GET['CreditCard'] = '1';
	$arryCreditCardVendor = $objSupplier->GetSupplierList($_GET);

	if(empty($NumLine)) $NumLine = 1;

	//$ErrorMSG = UNDER_CONSTRUCTION; 
if($module=='Quote'){
    $NextPurchaseModuleID = $objConfigure->GetNextModuleID('p_order','Order');  
}
	

	require_once("../includes/footer.php"); 	 
?>


