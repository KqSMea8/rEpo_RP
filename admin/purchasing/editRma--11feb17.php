<?php 
	/**************************************************/
	$ThisPageName = "viewRma.php"; $EditPage = 1; $SetFullPage = 1;
	/**************************************************/

	include_once("../includes/header.php");
	require_once($Prefix."classes/rma.purchase.class.php");
	require_once($Prefix."classes/inv_tax.class.php");
	require_once($Prefix."classes/purchasing.class.php");
	$objCommon=new common();
	$objPurchase=new purchase();
	$objTax=new tax();

	$Module = "RMA";
    	$ModuleIDTitle = "Invoice Number"; $ModuleID = "InvoiceID"; $PrefixSale = "RMA";   
	$RedirectURL = "viewRma.php?curP=".$_GET['curP'];

	if($_GET['active_id'] && !empty($_GET['active_id'])){
		$_SESSION['mess_return'] = RMA_CLOSED;
		$objPurchase->closeRMAStatus($_GET['active_id']);
		$objPurchase->SendRmaMail($_GET['active_id']);
		header("Location:".$RedirectURL);
		exit;
	}


	if($_GET['del_id'] && !empty($_GET['del_id'])){
		$_SESSION['mess_return'] = RMA_REMOVED;
		$objPurchase->RemovePurchase($_GET['del_id']);
		header("Location:".$RedirectURL);
		exit;
	}


	/***************************/
	if($_POST){
		CleanPost();	

		if(!empty($_POST['ReturnID'])){
			if($objPurchase->isReturnExists($_POST['ReturnID'],$_POST['OrderID'])){
				$errMsg = str_replace("[MODULE]","RMA Number", ALREADY_EXIST);
			}
		}

		if(empty($errMsg)){	
			if(!empty($_POST['ReturnOrderID'])){		
				$OrderID = $objPurchase->ReturnOrderRma($_POST);			
				$_SESSION['mess_return'] = RMA_ADDED;				
			}else if(!empty($_POST['OrderID'])){		
				$objPurchase->UpdateReturnRma($_POST);
				$OrderID = $_POST['OrderID'];
				$_SESSION['mess_return'] = RMA_UPDATED;				
			} 
			if($_POST['Status']=='Completed'){  
				$objPurchase->AddCreditPOFromRMA($OrderID); //Credit Note and purchase Order
			}
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
	
    	$ListRmaValues=$objPurchase->listRmaAction();
	$ListRmaReasonVal=$objPurchase->listRmaReason();

	require_once("../includes/footer.php"); 	 
?>


