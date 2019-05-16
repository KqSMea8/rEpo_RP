<?php 
	/**************************************************/
	$ThisPageName = 'viewPurchasePayments.php'; $EditPage = 1;
	/**************************************************/

	include_once("../includes/header.php");
	require_once($Prefix."classes/purchase.class.php");
	require_once($Prefix."classes/inv_tax.class.php");

	$objPurchase=new purchase();
	$objTax=new tax();

	$ModuleName = "Invoice Entry";
	//$RedirectURL = "viewPO.php?module=Order&curP=".$_GET['curP'];
	$RedirectURL = "viewPoInvoice.php";
	
	if(!empty($_POST['ReceiveOrderID'])){  
		 CleanPost();   
		$_POST['InvoiceID'] = $_POST['PoInvoiceID'];		
		/***************/
		$OrderID = $objPurchase->ReceiveOrderInvoiceEntry($_POST);
                $objPurchase->AddItemForInvoiceEntry($OrderID, $_POST); 
		$_SESSION['mess_invoice'] = INVOICE_GENERATED_MESSAGE;
		header("Location:".$RedirectURL);
		exit;
	 } 
		
				

	if(empty($NumLine)) $NumLine = 1;	
	$arryPurchaseTax = $objTax->GetTaxRate('2');
        
        $arryPaymentTerm = $objConfigure->GetTerm('','1');
	$arryPaymentMethod = $objConfigure->GetAttribFinance('PaymentMethod','');
	$arryShippingMethod = $objConfigure->GetAttribValue('ShippingMethod','');

	//$ErrorMSG = UNDER_CONSTRUCTION; // Disable Temporarly

	require_once("../includes/footer.php"); 	 
?>


