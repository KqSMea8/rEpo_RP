<?php 
	if($_GET['pop']==1)$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'viewSalesPayments.php';
	/**************************************************/

	include_once("../includes/header.php");
	require_once($Prefix."classes/sales.quote.order.class.php");
	require_once($Prefix."classes/inv_tax.class.php");
	require_once($Prefix."classes/finance.class.php");
	require_once($Prefix."classes/finance.account.class.php");
        
       (!$_GET['curP'])?($_GET['curP']=1):(""); // current page number
                
         if (class_exists(BankAccount)) {
                      $objBankAccount = new BankAccount();
              } else {
                      echo "Class Not Found Error !! Bank Account Class Not Found !";
                      exit;
              }
	
	$objCommon = new common();
	$objSale = new sale();
	$objTax = new tax();
	
	$module = 'Invoice';
	$ModuleName = "Receive Payments";
	$RedirectURL = "viewSalesPayments.php?curP=".$_GET['curP'];
	/*$EditUrl = "payInvoice.php?edit=".$_GET["edit"]."&curP=".$_GET["curP"]; 
	$DownloadUrl = "pdfInvoice.php?IN=".$_GET["edit"].""; */

	$ModuleIDTitle = "Invoice Number"; $ModuleID = "InvoiceID"; $PrefixSale = "IN";  $NotExist = NOT_EXIST_ORDER;
	
	if ($_POST) {
				/******************************/
					CleanPost();
				/******************************/
			if(!empty($_POST['savePaymentInfo'])) {


				if(empty($_POST['PaidTo']) || empty($_POST['Method']) || empty($_POST['ReceivedAmount']) || ($_POST['ReceivedAmount'] == '0') || ($_POST['ReceivedAmount'] > $_POST['TotalPaidAmount'])) {

					$_SESSION['mess_Invoice'] = ERROR_IN_PAY_INVOICE;
					header("Location:".$ListUrl);
					exit;
				}else{		

					$objBankAccount->addPaymentInformation($_POST);
					//$objBankAccount->sendSalesPaymentEmail($_POST);
					$_SESSION['mess_Invoice'] = ADD_PAYMENT_INFORMATION;
                                        $EditUrl = "payInvoice.php?edit=".$_GET["edit"]."&InvoiceID=".$_GET["InvoiceID"];
					header("Location:".$EditUrl);
					exit;

				}
			 } 
		}	

	if(!empty($_GET['edit']) || !empty($_GET['so'])){
		$arrySale = $objSale->GetSale($_GET['edit'],$_GET['so'],$module);
		
		$arryBankAccount=$objBankAccount->getBankAccountForReceivePayment();
	
		
		$OrderID   = $arrySale[0]['OrderID'];	
		$SaleID   = $arrySale[0]['SaleID'];
		$InvoiceID = $arrySale[0]['InvoiceID'];
		
		if($OrderID>0){
			$arrySaleItem = $objSale->GetSaleItem($OrderID);
			$NumLine = sizeof($arrySaleItem);
			
			//get payment history
			 
			 $arryPaymentInvoice = $objBankAccount->GetSalesPaymentInvoice($_GET['edit'],$_GET['InvoiceID']);
			
			 /*$paidAmnt = $objBankAccount->GetSalesTotalPaymentAmntForInvoice($InvoiceID);
			
			 $paidOrderAmnt = $objBankAccount->GetSalesTotalPaymentAmntForOrder($SaleID);
			 $InvoiceAmount  = $arrySale[0]['TotalInvoiceAmount'];
			 $TotalOrderedAmount  = $arrySale[0]['TotalAmount'];
			 //echo "=>".$paidAmnt;
			 if($paidAmnt > 0){
				   $remainInvoiceAmount = $InvoiceAmount-$paidAmnt;
				   $objSale->updateInvoiceStatus($OrderID,1);
				 }else{
					 $remainInvoiceAmount = $InvoiceAmount;
				 }
			 if($paidAmnt >= $InvoiceAmount){
				    $objSale->updateInvoiceStatus($OrderID,2);
				 }
				
			 if($paidOrderAmnt >= $TotalOrderedAmount){
			 
				    $objSale->updateOrderStatus($SaleID);
				 }*/
			//end
			
			
		}else{
			$ErrorMSG = $NotExist;
		}
	}

	
 
		
	if(!empty($_GET['edit'])){
		$arrySale = $objSale->GetSale($_GET['edit'],'',$module);
		$OrderID   = $arrySale[0]['OrderID'];	
		if($OrderID>0){
			$arrySaleItem = $objSale->GetSaleItem($OrderID);
			$NumLine = sizeof($arrySaleItem);
		}else{
			$ErrorMSG = $NotExist;
		}
	}
		
	if(empty($NumLine)) $NumLine = 1;	


	$arrySaleTax = $objTax->GetTaxRate('2');
	$arryPaymentMethod = $objCommon->GetAttribValue('PaymentMethod','');
	
	$_SESSION['DateFormat']= $Config['DateFormat'];

	require_once("../includes/footer.php"); 	 
?>
