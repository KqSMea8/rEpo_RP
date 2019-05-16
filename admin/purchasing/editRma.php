<?php 
	/**************************************************/
	$ThisPageName = "viewRma.php"; $EditPage = 1; $SetFullPage = 1;
	/**************************************************/

	include_once("../includes/header.php");
	require_once($Prefix."classes/rma.purchase.class.php");
	require_once($Prefix."classes/inv_tax.class.php");
	require_once($Prefix."classes/purchasing.class.php");
	require_once($Prefix."classes/item.class.php");
	require_once($Prefix."classes/inv.condition.class.php");
	require_once($Prefix."classes/finance.transaction.class.php");
	require_once($Prefix."classes/finance.account.class.php");
	require_once($Prefix."classes/finance.report.class.php");
	require_once($Prefix."classes/function.class.php"); 
		require_once($Prefix."classes/edi.class.php");
	require_once($Prefix."classes/rma.sales.class.php");

	$objFunction=new functions();
	$objCommon=new common();
	$objPurchase=new purchase();
	$objItem=new items();
	$objTax=new tax();
	$objCondition=new condition();
	$objTransaction=new transaction();
	$ediObj =new edi();
	$objrmasale = new rmasale();
	
	$Module = "RMA";
	$ModuleIDTitle = "Invoice Number"; $ModuleID = "InvoiceID"; $PrefixSale = "RMA";   
	$RedirectURL = "viewRma.php?curP=".$_GET['curP'];

	if(!empty($_GET['del_id'])){
		$_SESSION['mess_return'] = RMA_REMOVED;
		$objConfig->RemoveStandAloneShipment($_GET['del_id'], 'PurchaseRMA'); 
		$objPurchase->RemovePurchase($_GET['del_id']);
		header("Location:".$RedirectURL);
		exit;
	}

	if(!empty($_GET['active_id'])){
		$_SESSION['mess_return'] = RMA_CLOSED;
		$objPurchase->closeRMAStatus($_GET['active_id']);
		$objPurchase->SendRmaMail($_GET['active_id']);
		header("Location:".$RedirectURL);
		exit;
	}


	/***************************/
	if(!empty($_POST)){
		CleanPost();	
		unset($_SESSION["PR_CreditID"]);
		if(!empty($_POST['ReturnID'])){
			if($objPurchase->isReturnExists($_POST['ReturnID'],$_POST['OrderID'])){
				$errMsg = str_replace("[MODULE]","RMA Number", ALREADY_EXIST);
			}
		}

		if(empty($errMsg)){	
			if(!empty($_POST['ReturnOrderID'])){		
				$OrderID = $objPurchase->ReturnOrderRma($_POST);	
				
				
//Start EDi Functionality for return item//
if($_POST['EDIRefNo']!='' ){

	$arryPurchase = $objPurchase->GetPurchase($_POST['ReturnOrderID'],'','');
	
	$EdiRefArry = explode("/",$_POST['EDIRefNo']);
	$DisplayName=$ediObj->GetCompanyForEDI($EdiRefArry[1],$Config['DbMain']);
	#echo $DisplayName;exit;
	//$OrderID = $objrmasale->ReturnOrder($_POST,$DisplayName); //sales RMA			
  if($arryPurchase[0]['EdiRefInvoiceID']!=''){
	   $arrySale = $objrmasale->GetInvoice('',$arryPurchase[0]['EdiRefInvoiceID'],'Invoice',$DisplayName);
			
		$NextModuleID = $objConfigure->GetNextModuleID('s_order','RMA',$DisplayName);  //change in configure class
		$arryDetails["ReturnID"] = $NextModuleID;
		$arryDetails["ReturnDate"] = $_POST['ReceivedDate'];
		$arryDetails["TotalAmount"] = $_POST['TotalAmount'];
		$arryDetails["ReturnPaid"] = $_POST['ReturnPaid'];
		$arryDetails["ReturnComment"] = $_POST['ReturnComment'];
		$arryDetails["ExpiryDate"] = $_POST['ExpiryDate'];
		$arryDetails["ReSt"] = $_POST['ReSt'];
		$arryDetails["ReStocking"] = $_POST['ReStocking']; 
		$arryDetails["Restocking_fee"] = $_POST['Restocking_fee'];
		$arryDetails["Status"] = $_POST['Status']; 	
		$arryDetails["TDiscount"] = $_POST['TDiscount']; 
		$arryDetails["ReturnOrderID"] = $arrySale[0]['OrderID']; 
		$arryDetails["taxAmntR"] = $_POST['taxAmnt'];
		$arryDetails['EDIRefNo']  = $_POST['EDIRefNo']."/".$_POST['ReturnID'];
		$_POST['ReturnOrdID'] = $arrySale[0]['OrderID'];
	    $arryDetails["EdiRefInvoiceID"] = $arryPurchase[0]['InvoiceID'];

		$Order_ID = $objrmasale->AddReturnMAOrder($arryDetails,$DisplayName); //RMA	
		if($Order_ID>0){
				$_POST['order_id'] = $Order_ID;
				$objrmasale->AddRMAOrderItem($_POST,$DisplayName); //RMA	
		}
   }
}	
////END EDi Functionality for return item//


				
				
				
				
				
				
				
				
				
						
				$_SESSION['mess_return'] = RMA_ADDED;				
			}else if(!empty($_POST['OrderID'])){		
				$objPurchase->UpdateReturnRma($_POST);
				$OrderID = $_POST['OrderID'];
				$_SESSION['mess_return'] = RMA_UPDATED;				
			} 

			if(!empty($OrderID)){ 			
				$objConfig->AddUpdateStandAloneShipment($OrderID, 'PurchaseRMA');
				unset($_SESSION["Shipping"]); 
			}

			if($_POST['Status']=='Completed'){  
				$objPurchase->AddCreditPOFromRMA($OrderID); //Credit Note and purchase Order

				/*****AutoPostToGl CreditMemo******/
				if($_SESSION["PR_CreditID"]>0){
					$PostedOrderID = $_SESSION["PR_CreditID"];
					$Approved = $objConfigure->getSettingVariable('PO_APPROVE');
					include_once("../includes/AutoPostToGlApCreditMemo.php");
					unset($_SESSION["PR_CreditID"]);
				}
				/**********************************/

				$objConfig->CreateAPInvoiceForStandAloneFreight($OrderID, 'PurchaseRMA', ''); 
			}


			 
			/*******Generate PDF************/			
			$PdfArray['ModuleDepName'] = "PurchaseRMA";
			$PdfArray['Module'] = "RMA";
			$PdfArray['ModuleID'] = "ReturnID";
			$PdfArray['TableName'] =  "p_order";
			$PdfArray['OrderColumn'] =  "OrderID";
			$PdfArray['OrderID'] =  $OrderID;		 	
			$objConfigure->GeneratePDF($PdfArray);
			/*******************************/ 

			header("Location:".$RedirectURL);
			exit;  
		}
        }
	/***************************/
	
		

	if(!empty($_GET['Inv'])){       
		$arryPurchase = $objPurchase->GetPurchaseInvoice($_GET['Inv'],'' ,'');
		$OrderID   = $arryPurchase[0]['OrderID'];
		$po =  $arryPurchase[0]['PurchaseID'];
		$InvoiceID = $arryPurchase[0]['InvoiceID'];
		$PurchaseID = $arryPurchase[0]['PurchaseID'];
		$InvoiceOrderID = $_GET['Inv'];
		if($OrderID>0){
			$arryPurchaseItem = $objPurchase->GetPurchaseItem($OrderID);
			$NumLine = sizeof($arryPurchaseItem);
		}else{
			$ErrorMSG = NOT_EXIST_RMA;
		}

		$ModuleName = "Add ".$Module;
		$ButtonTitle = 'Process';
		$arryPurchase[0]['Status']='Parked';
		$arryPurchase[0]['PostedDate']='';
		$arryPurchase[0]['ReceivedDate']='';
		$arryPurchase[0]['ExpiryDate']='';
$arryPurchase[0]['Freight'] ='0.00';
	}else if(!empty($_GET['edit'])){       
		$arryPurchase = $objPurchase->GetPurchaserma($_GET['edit'],'','');
		$OrderID   = $arryPurchase[0]['OrderID'];	
		$po = $arryPurchase[0]['PurchaseID'];
		$InvoiceID = $arryPurchase[0]['InvoiceID'];
		$PurchaseID = $arryPurchase[0]['PurchaseID'];
		$arryInvoiceData = $objPurchase->GetPurchaseInvoice('', $arryPurchase[0]["InvoiceID"] ,'Invoice');
		$InvoiceOrderID = $arryInvoiceData[0]['OrderID'];
		if($OrderID>0){
			$arryPurchaseItem = $objPurchase->GetPurchaseItem($OrderID);		
			$NumLine = sizeof($arryPurchaseItem);
		}else{
			$ErrorMSG = NOT_EXIST_RMA;
		}
		$ModuleName = "Edit ".$Module;
 
		if($arryPurchase[0]['Status'] != "Parked"){$HideSubmit = 1;}
		$ButtonTitle = 'Update';
	}else{
		$ErrorMSG = SELECT_INV_FIRST;
		$ModuleName = "Add ".$Module;
	}
				

	if(empty($NumLine)) $NumLine = 1;	
	$arryPurchaseTax = $objTax->GetTaxRate('2');
	$arryPaymentMethod = $objConfigure->GetAttribFinance('PaymentMethod','');
	$RestockingGlobal = $objConfigure->getSettingVariable('RES_FEE_P');
	$WarehouseDrop  =$objCondition-> GetWarehouseDropValue('');
	$ListRmaValues=$objPurchase->listRmaAction();
	$ListRmaReasonVal=$objPurchase->listRmaReason();
	$TaxableBillingAp = $objConfigure->getSettingVariable('TaxableBillingAp');


	require_once("../includes/footer.php"); 	 
?>


