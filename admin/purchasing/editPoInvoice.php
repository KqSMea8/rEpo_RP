<?php 
	/**************************************************/
	$ThisPageName = 'viewPoInvoice.php'; $EditPage = 1;
	/**************************************************/

	include_once("../includes/header.php");
	require_once($Prefix."classes/purchase.class.php");
	require_once($Prefix."classes/purchasing.class.php");
	$objCommon=new common();
	$objPurchase=new purchase();
	$ModuleName = "Invoice";
	$RedirectURL = "viewPoInvoice.php?curP=".$_GET['curP']."&po=".$_GET['po'];

	if(!empty($_GET['po'])){
		$MainModuleName = "Invoices for PO Number# ".$_GET['po'];
	}


	if($_GET['del_id'] && !empty($_GET['del_id'])){
		$_SESSION['mess_invoice'] = INVOICE_REMOVED;
		$objPurchase->RemovePurchase($_GET['del_id']);
		header("Location:".$RedirectURL);
		exit;
	}



	 if($_POST){
		 if(!empty($_POST['OrderID'])) {
			$objPurchase->UpdateInvoice($_POST);
			$order_id = $_POST['OrderID'];
			$_SESSION['mess_invoice'] = INVOICE_UPDATED;


			/***********************************/
			if($_POST['InvoicePaid']==1 && $_POST['OldInvoicePaid']!=$_POST['InvoicePaid']){
				$objPurchase->sendInvPayEmail($_POST['OrderID']); 
			}
			/***********************************/


			header("Location:".$RedirectURL);
			exit;
		}
	}
		

	if(!empty($_GET['edit'])){
		$arryPurchase = $objPurchase->GetPurchase($_GET['edit'],'','Invoice');
		$OrderID   = $arryPurchase[0]['OrderID'];	
		if($OrderID>0){
			$arryPurchaseItem = $objPurchase->GetPurchaseItem($OrderID);
			$NumLine = sizeof($arryPurchaseItem);

			/****************************
			$arryOrder = $objPurchase->GetPurchase('',$arryPurchase[0]['PurchaseID'],'Order');
			$arryPurchase[0]['Status'] = $arryOrder[0]['Status'];
			//////////*/

		}else{
			$ErrorMSG = NOT_EXIST_INVOICE;
		}
	}else{
		$ErrorMSG = SELECT_PO_FIRST;
	}
				

	if(empty($NumLine)) $NumLine = 1;	

	$arryPaymentMethod = $objConfigure->GetAttribFinance('PaymentMethod','');

	require_once("../includes/footer.php"); 	 
?>
