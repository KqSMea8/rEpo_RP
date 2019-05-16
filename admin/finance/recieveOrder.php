<?php 
	/**************************************************/
	if($_GET['invoice']==1) $ThisPageName = 'viewPoInvoice.php';
	else $ThisPageName = 'viewPoInvoice.php'; //'viewPO.php?module=Order'; 
	
	$EditPage = 1; $SetFullPage = 1;
	/**************************************************/

	include_once("../includes/header.php");
	require_once($Prefix."classes/purchase.class.php");
	require_once($Prefix."classes/inv_tax.class.php");

	$objPurchase=new purchase();
	$objTax=new tax();

	$ModuleName = "Receive Purchase Order";

	//$RedirectURL = "viewPO.php?module=Order&curP=".$_GET['curP'];
	$RedirectURL = "viewPoInvoice.php";
	        
	if(!empty($_POST['ReceiveOrderID'])){  
		 CleanPost();   
		$_POST['InvoiceID'] = $_POST['PoInvoiceID'];		
		/***************/
		$OrderID = $objPurchase->ReceiveOrder($_POST);
		$_SESSION['mess_invoice'] = PO_ORDER_RECIEVED;
		$RedirectURL = "vPoInvoice.php?view=".$OrderID;
		header("Location:".$RedirectURL);
		exit;
	 } 
		

	if(!empty($_GET['po'])){
		$arryPurchase = $objPurchase->GetPurchase($_GET['po'],'','Order');
		$OrderID   = $arryPurchase[0]['OrderID'];	
		if($OrderID>0){
			$arryPurchaseItem = $objPurchase->GetPurchaseItem($OrderID);
			$NumLine = sizeof($arryPurchaseItem);

			$PurchaseID = $arryPurchase[0]['PurchaseID'];
			#$arryInvoiceOrder = $objPurchase->GetInvoiceOrder($PurchaseID);
		}else{
			$ErrorMSG = NOT_EXIST_ORDER;
		}
	}else{
		header("Location:".$RedirectURL);
		exit;
	}
				

	if(empty($NumLine)) $NumLine = 1;	
	$arryPurchaseTax = $objTax->GetTaxRate('2');

	//$ErrorMSG = UNDER_CONSTRUCTION; // Disable Temporarly

	require_once("../includes/footer.php"); 	 
?>


