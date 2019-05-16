<?php 
	/**************************************************/
	$ThisPageName = 'viewPoReceipt.php'; $EditPage = 1; $SetFullPage = 1;
	/**************************************************/

	include_once("../includes/header.php");
	
	require_once($Prefix."classes/inv_tax.class.php");
	require_once($Prefix . "classes/item.class.php");
	require_once($Prefix."classes/purchasing.class.php");
	require_once($Prefix."classes/purchase.class.php");
	require_once($Prefix."classes/sales.quote.order.class.php");
	require_once($Prefix."classes/finance.transaction.class.php");
	require_once($Prefix."classes/finance.account.class.php");
	require_once($Prefix."classes/finance.report.class.php");
	require_once($Prefix."classes/edi.class.php");
	$objPurchase=new purchase();
	$objTax=new tax();        
	$objItem = new items();
	$objTransaction=new transaction();
	$objBankAccount = new BankAccount();
	$objReport = new report();
  $objSale = new sale();
	$ediObj=new edi();
	$ModuleName = "Receive Purchase Order";	
	$RedirectURL = "viewPoReceipt.php";
	$EditURL = "receiptOrder.php?po=".$_GET['po']."&invoice=1"; 

	$AccountPayable = $objConfigure->getSettingVariable('AccountPayable');
	$InventoryAP = $objConfigure->getSettingVariable('InventoryAR');
	$PurchaseClearing = $objConfigure->getSettingVariable('PurchaseClearing');
	$CostOfGoods = $objConfigure->getSettingVariable('CostOfGoods');
	$AutoPostToGl = $objConfigure->getSettingVariable('AutoPostToGlAp');



	if(!empty($_POST['ReceiveOrderID'])){ 
		CleanPost();
		  
		/*if($_POST['TotalAmount']<=0){
			 $errMsg = "Grand Total must be greater than 0.";
		}*/
		
		if(!empty($_POST['RefInvoiceID']) && $_POST['GenrateInvoice']=='1' && $_POST['ReceiptStatus']=="Completed"){
			if($objPurchase->isInvoiceExists($_POST['RefInvoiceID'],'')){
				//$errMsg = str_replace("[MODULE]","Invoice Number", ALREADY_EXIST);
				$OtherMsg = str_replace("[MODULE]","Invoice Number", ALREADY_EXIST_ASSIGNED);
				$_POST['RefInvoiceID'] = $objConfigure->GetNextModuleID('p_order','Invoice');
			}			
		}
		 

		if(empty($errMsg)){

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
			$_POST['ReceiptID'] = $_POST['PoReceiptID'];			
			$OrderID = $objPurchase->ReceiptOrder($_POST);
			 
			if($_POST['GenrateInvoice']=='1' && $_POST['ReceiptStatus']=="Completed"){
				$_POST['InvoiceID'] = $_POST['RefInvoiceID'];
				$_POST['PostedDate'] = $_POST['RefInvoiceDate'];
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

if( $OrderID>0 && $_POST['ReceiptStatus']=="Completed" ){


/*$post_data = array();
			$post_data[] = urlencode('CmpID') . '=' . urlencode($_SESSION['CmpID']);
			$post_data[] = urlencode('AdminID') . '=' . urlencode($_SESSION['AdminID']);
			$post_data[] = urlencode('AdminType') . '=' . urlencode($_SESSION['AdminType']);
$post_data[] = urlencode('OrderID') . '=' . urlencode($OrderID);
$post_data[] = urlencode('locationID') . '=' . urlencode($_SESSION['locationID']);
$post_data[] = urlencode('cu') . '=' . urlencode($_SESSION['currency_id']);


 */


/*foreach ($_POST as $k => $v)
   {
       $post_data[] = urlencode($k) . '=' . urlencode($v);
   }*/

//$post_data = implode('&', $post_data);
#echo 'php /var/www/html/erp/cron/ImportSerial.php "'.$post_data.'" > /dev/null & echo $!;';die();
//$pid = exec('php /var/www/html/erp/cron/ImportSerial.php "'.$post_data.'" > /dev/null & echo $!;', $output, $return); 

#echo $pid; exit;
      $objPurchase->ReceivePurchaseQtyOrder($OrderID);

}

			/**************/	
			if($OrderID>0 && $_POST['ReceiptStatus']=="Completed"){ //Receipt Post To GL			
				$arryPostData['InvoiceGenerated'] = $_POST['GenrateInvoice']; 
				$arryPostData['InvoiceID'] = $_POST['InvoiceID']; 
				$arryPostData['PostToGLDate'] = $_POST['PostToGLDate']; //empty now
				$arryPostData['PaymentType'] = 'PO Receipt';
				$arryPostData['AccountPayable'] = $AccountPayable;
				$arryPostData['InventoryAP'] = $InventoryAP;
				$arryPostData['PurchaseClearing'] = $PurchaseClearing;
				$arryPostData['CostOfGoods'] = $CostOfGoods;

				$objTransaction->PoReceiptPostToGL($OrderID,$arryPostData);
			}
			/**************/ 	
			$_SESSION['mess_Receipt'] = PO_ORDER_RECIEVED.$OtherMsg;
			$RedirectURL = "vPoReceipt.php?view=".$OrderID;
			header("Location:".$RedirectURL);
			exit;
		 
		}
		
	 } 		

	if(!empty($_GET['po'])){
		$arryPurchase = $objPurchase->GetPurchase($_GET['po'],'','Order');
		$OrderID   = $arryPurchase[0]['OrderID'];	

				$CountPO = $objPurchase->getCountReceiptPO($arryPurchase[0]['PurchaseID']);
				if($CountPO>0){
						$POReceipt=1;
				}else{
          $POReceipt = 0;

       }

		if($OrderID>0){
			//$arryPurchaseItem = $objPurchase->GetPurchaseItem($OrderID);
	      if($arryPurchase[0]['EDIRefNo']!='' && $POReceipt!=1){
							$EdiRefArry = explode("/",$arryPurchase[0]['EDIRefNo']);
						$DisplayName=$ediObj->GetCompanyForEDI($EdiRefArry[1],$Config['DbMain']);
       $arrySales = $objSale->GetSale('',$EdiRefArry[4],'Invoice',$DisplayName);
       
       if($arrySales[0]['OrderID']>0){
							$arryPurchaseItem = $objSale->GetSaleItem($EdiRefArry[3],$DisplayName);
						
							}
							
					}else{
					    $arryPurchaseItem = $objPurchase->GetPurchaseItem($OrderID);
					}

			$NumLine = sizeof($arryPurchaseItem);

			$PurchaseID = $arryPurchase[0]['PurchaseID'];	

			$BankAccount='';
			if(strtolower(trim($arryPurchase[0]['PaymentTerm']))=='prepayment' && !empty($arryPurchase[0]['AccountID'])){
			    $arryBankAccount = $objBankAccount->getBankAccountById($arryPurchase[0]['AccountID']);
			    $BankAccount = $arryBankAccount[0]['AccountName'] . ' [' . $arryBankAccount[0]['AccountNumber'] . ']';
			}		 
		}else{
			$ErrorMSG = NOT_EXIST_ORDER;
		}
	}else{
		header("Location:".$RedirectURL);
		exit;
	}
				

	if(empty($NumLine)) $NumLine = 1;	
	$arryPurchaseTax = $objTax->GetTaxRate('2');
	$NextModuleID = $objConfigure->GetNextModuleID('p_order','Receipt');
	$NextInvModuleID = $objConfigure->GetNextModuleID('p_order','Invoice');

	/*****************************/
	$arryAllocationSetting = $objConfigure->getSettingVariableAll('ALLOC_METHOD_P');
	$AllocationMethod = $arryAllocationSetting[0]['setting_value'];
	$arryAllocation = explode(",",$arryAllocationSetting[0]['options']);
	$AllocDropdown = '<select name="AllocationMethod" id="AllocationMethod" class="textbox" onchange="Javascript:ProcessFreight();" style="width:138px">';
	foreach($arryAllocation as $Allocation){
		$sel = ($AllocationMethod==$Allocation)?("selected"):("");
		$AllocDropdown .= '<option value="'.$Allocation.'" '.$sel.'>'.$Allocation.'</option>';
	}
	$AllocDropdown .= '</select>';
	/*****************************/
 
	$TaxableBillingAp = $objConfigure->getSettingVariable('TaxableBillingAp');

	//$ErrorMSG = UNDER_CONSTRUCTION; // Disable Temporarly

	require_once("../includes/footer.php"); 	 
?>


