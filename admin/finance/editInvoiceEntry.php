<?php 
	/**************************************************/
	$ThisPageName = 'viewInvoice.php'; $EditPage = 1;$SetFullPage = 1;
	/**************************************************/

	include_once("../includes/header.php");
	require_once($Prefix . "classes/item.class.php");
	require_once($Prefix."classes/sales.quote.order.class.php");
	require_once($Prefix."classes/sales.class.php");
	require_once($Prefix."classes/inv_tax.class.php");
	require_once($Prefix."classes/sales.class.php");
	require_once($Prefix."classes/sales.customer.class.php");
	require_once($Prefix . "classes/inv.condition.class.php");
	require_once($Prefix."classes/variant.class.php");
	require_once($Prefix."classes/finance.account.class.php");
	require_once($Prefix."classes/card.class.php");
	require_once($Prefix."classes/finance.report.class.php");
	require_once($Prefix."classes/finance.journal.class.php");
	require_once($Prefix."classes/finance.transaction.class.php");
 	require_once($Prefix."classes/function.class.php");

	$objFunction=new functions();
        $objvariant=new varient();
	$objSale = new sale();
	$objTax = new tax();
	$objItem = new items();
	$objCondition = new condition();
	$objCommon = new common();
	$objBankAccount=new BankAccount();
	$objCard = new card();
	$objReport = new report();
	$objTransaction=new transaction();

	(empty($_GET['OrderID']))?($_GET['OrderID']=""):("");
	 $AccountReceivable = $objCommon->getSettingVariable('AccountReceivable');
	


	$_GET["OrderID"] = (int)$_GET["OrderID"];
	if($_GET["edit"]>0)$_GET["OrderID"]=$_GET["edit"];
	
	$_GET['module']='invoice';
	$module = $_GET['module'];
	$ModuleName = "Invoice Entry";
	$RedirectURL = "viewInvoice.php?curP=".$_GET['curP'];
	$EditUrl = "editInvoiceEntry.php?edit=".$_GET["OrderID"]."&curP=".$_GET["curP"]; 

        $BackURL = "viewInvoice.php?curP=".$_GET['curP'];
	$ModuleIDTitle = "Invoice Number"; $ModuleID = "SaleInvoiceID"; $PrefixSale = "INVE";  $NotExist = NOT_EXIST_ORDER;

	$objCustomer=new Customer();
	

	include("includes/html/box/card_process_void.php");
	
	/**********************************/
	if(!empty($_POST['GenerateInVoice']) && $_POST['GLAccountLineItemType'] == "LineItem" ) { 
	    	CleanPost();  
		$_POST['InvoiceID'] = $_POST['SaleInvoiceID'];

		if(!empty($_POST['SaleInvoiceID'])){
			if($objSale->isInvoiceNumberExists($_POST['SaleInvoiceID'],$_POST['OrderID'])){
				//$errMsg = str_replace("[MODULE]","Invoice Number", ALREADY_EXIST);
				$OtherMsg = str_replace("[MODULE]","Invoice Number", ALREADY_EXIST_ASSIGNED);
				$_POST['SaleInvoiceID'] =  $objConfigure->GetNextModuleID('s_order','Invoice');
			}
		}
		if(!empty($errMsg)) {
			$_SESSION['mess_Invoice'] = $errMsg;			
			header("Location:".$EditUrl);
               		exit;
		}


		/*****************/
		unset($_SESSION['mess_Invoice']);
		for($i=1;$i<=$_POST['NumLine'];$i++){			
			$ItemID = $_POST['item_id'.$i];
			$Sku = $_POST['sku'.$i];
			$Qty = $_POST['qty'.$i];
                        $DropshipCheck = $_POST['DropshipCheck'.$i];
                       
			$msg = '';			
			if($Qty>0 && !empty($Sku) && !empty($ItemID)){				
				$arryItem = $objItem->GetItemById($ItemID);				
				if($arryItem[0]['evaluationType']=='Serialized' && $DropshipCheck!= 'on'){
					$NumSerial = $objSale->CountSkuSerialNo($Sku);
					/*$_GET['Sku']=$Sku;
					$arrySerial=$objItem->ListSerialNumber($_GET);
					$NumSerial = sizeof($arrySerial);*/

					if($Qty > $NumSerial){
						$msg = str_replace("[Sku]",$Sku,SERIALIZE_NUM_MSG);
						$msg = str_replace("[NumSerial]",$NumSerial,$msg);
						$msg = str_replace("[Qty]",$Qty,$msg);
						$_SESSION['mess_Invoice'] .= $msg;
					}
				}
			}
		}
		
		
		if(!empty($_SESSION['mess_Invoice'])){
			$_SESSION['mess_Invoice'] = INVOICE_NOT_GENERATED.'<br>'.$_SESSION['mess_Invoice'];
			
			$RedirectURL = "editInvoiceEntry.php"; 
			header("Location:".$RedirectURL);
			exit;
		}
		/*****************/ 
		if(strtolower(trim($_POST['PaymentTerm']))=='prepayment'){
			$_POST["AccountID"] = $_POST["BankAccount"] ;
		}
		/*****************/ 

		 
		if($_POST['ShippingAccNO']=="Add New"){
		    $_POST['ShippingAccNO']=$_POST['AddNewAcc'];
		}
		if(!empty($_POST['AddNewAcc']) && !empty($_POST['ShippingAccountAdjust']) && !empty($_POST['ShippingAccountCustomer'])){
			$addshippingaccount['CustID']=$_POST['CustID'];
			$addshippingaccount['api_account_number']=$_POST['AddNewAcc'];
			$addshippingaccount['api_name']=$_POST['ShippingMethod'];
			$objCustomer->AddCustShipAcount($addshippingaccount,1);
		}
		
		/*****************/ 


		if(!empty($_POST['OrderID'])) {	
			$order_id = $_POST['OrderID'];	
			
			include("includes/html/box/card_process_line.php");

			$objSale->UpdateARInvoiceEntry($_POST);
			$objSale->RemoveInvoiceEntryItem($order_id); 
			

			if(!empty($_SESSION['mess_Sale'])){
				$_SESSION['mess_Invoice'] = INVOICE_ENT_UPDATED.'<br>'.$_SESSION['mess_Sale'];
				unset($_SESSION['mess_charge_refund']);
			}else{
				$_SESSION['mess_Invoice'] = INVOICE_ENT_UPDATED.$OtherMsg;
			}		
			
		}else{ 
			$order_id = $objSale->GenerateInVoiceEntry($_POST);
			$PostedOrderID = $order_id;
			$_SESSION['mess_Invoice'] = INVOICE_GENERATED_MESSAGE.$OtherMsg;
			$EditUrl = "editInvoiceEntry.php?edit=".$order_id;
		}
		$objSale->AddInvoiceItemForEntry($order_id, $_POST); 
                
                 /********************UPDATE SERIAL NUMBER***********/
                
                        for($k=1;$k<=$_POST['NumLine'];$k++){

                               $serial_value = $_POST['serial_value'.$k];
                               $DropshipCheckForSerial = $_POST['DropshipCheck'.$k];

                               $explodeSerialVal = explode(",",$serial_value);
                               $SerailSize = sizeof($explodeSerialVal);

                               for($j=0;$j<$SerailSize;$j++){

                                   $arraySerailData['serialNumber'] = trim($explodeSerialVal[$j]);
                                   $arraySerailData['warehouse'] = $_POST['wCode'];
                                   $arraySerailData['Sku'] = $_POST['sku'.$k];

                                   if($arraySerailData['serialNumber'] != "" && $DropshipCheckForSerial != 'on'){
                                       $objSale->addSerailNumberForInvoice($arraySerailData);
                                   }
                               }



                       }
                
                /***********************END SERIAL NUMBER****************************************************/
/***code for add document by sachin***/
					
					$i=0;
				
					$errorFileDoc='';
                    foreach($_FILES['FileName']['name'] as $val){
                         	
                       if($val!= ''){


				/***********/
				$ArryFileName['name'] = $_FILES['FileName']['name'][$i];
				$ArryFileName['tmp_name'] = $_FILES['FileName']['tmp_name'][$i];
				$OldFile = $_POST['OldFile'][$i]; 


				$heading = "SalesInvoice_".$order_id."_".$i;

				$FileInfoArray['FileType'] = "Document";
				$FileInfoArray['FileDir'] = $Config['S_DocomentDir'];
				$FileInfoArray['FileID'] =  $heading;
				$FileInfoArray['OldFile'] = $OldFile;
				$FileInfoArray['UpdateStorage'] = '1';
				$ResponseArray = $objFunction->UploadFile($ArryFileName, $FileInfoArray); 
				if($ResponseArray['Success']=="1"){  
					$documentArry= array('OrderID'=>$order_id,'ModuleName'=>'SalesInvoice','Module'=>'SalesInvoice','FileName'=>$ResponseArray['FileName']); 
					$objConfig->UpdateDoc($documentArry);
				}else{
					$ErrorMsg = $ResponseArray['ErrorMsg'];
				}
				/***********/
			  	 
			  	 
			  }
			  $i++;
			}//end foreach
					 
                        
/**********************************************************************/
		if($_FILES['UploadDocuments']['name'] != ''){  			

			$imageName = "Documents_".$order_id;			

			$FileInfoArray['FileType'] = "Scan";
			$FileInfoArray['FileDir'] = $Config['S_DocomentDir'];
			$FileInfoArray['FileID'] =  $imageName;
			$FileInfoArray['OldFile'] = $_POST['OldUploadDocuments'];
			$FileInfoArray['UpdateStorage'] = '1';
			$ResponseArray = $objFunction->UploadFile($_FILES['UploadDocuments'], $FileInfoArray);
			if($ResponseArray['Success']=="1"){  
				$objSale->UpdateUploadDocuments($ResponseArray['FileName'],$order_id);
			}else{
				$ErrorMsg = $ResponseArray['ErrorMsg'];
			} 
			 
				 
			if(!empty($ErrorMsg)){
				$_SESSION['mess_Invoice'] .= '<br><br>'.$ErrorMsg;
			}
		}	

/*********************************************************************/





     		$objSale->AddUpdateCreditCard($order_id, $_POST); 

		/***************log by sanjiv********************/
     		$_POST['ModuleType'] ='SalesInvoiceEntry';
     		$objConfig->AddUpdateLogs($order_id, $_POST);
     		/***********************************/

		
		/*****AutoPostToGl**********
		include_once("../includes/AutoPostToGlArInvoice.php");
		/**************************/
		/*******Generate PDF************/			
		$PdfArray['ModuleDepName'] = "SalesInvoice";
		$PdfArray['Module'] = "Invoice";
		$PdfArray['ModuleID'] = "InvoiceID";
		$PdfArray['TableName'] =  "s_order";
		$PdfArray['OrderColumn'] =  "OrderID";
		$PdfArray['OrderID'] =  $order_id;		 	
		$objConfigure->GeneratePDF($PdfArray);
		/*******************************/ 

		if($_POST['PaymentTerm']=='Credit Card'){
			
			$RedirectURL = $EditUrl;
		}

		header("Location:".$RedirectURL);
		exit;
	 }

	/**********************************/
	if(!empty($_POST['GenerateInVoice']) && $_POST['GLAccountLineItemType'] == "GLAccount" ) {		 	 
              	CleanPost();  
	 
		if(!empty($_POST['SoInvoiceIDGL'])){
			if($objSale->isInvoiceNumberExists($_POST['SoInvoiceIDGL'],$_POST['OrderID'])){
				//$errMsg = str_replace("[MODULE]","Invoice Number", ALREADY_EXIST);
				$OtherMsg = str_replace("[MODULE]","Invoice Number", ALREADY_EXIST_ASSIGNED);
				$_POST['SoInvoiceIDGL'] =  $objConfigure->GetNextModuleID('s_order','Invoice');
			}
		}
		if(!empty($errMsg)) {
			$_SESSION['mess_Invoice'] = $errMsg;			
			header("Location:".$EditUrl);
               		exit;
		}


			/******************************/
			 if($_POST['GlEntryType'] == "Multiple"){   
				$TotGlAmount=0;
				 for($i=1;$i<=$_POST['NumLine1'];$i++){
		                	if( $_POST['invoice_check_'.$i] ==1 && ($_POST['GlAmnt'.$i] > 0 || $_POST['GlAmnt'.$i] < 0) && !empty($_POST['AccountID'.$i])){  
						$TotGlAmount += $_POST['GlAmnt'.$i];
					} 
				}

 
				if(round($TotGlAmount,2) != round($_POST['Amount'],2)){
					$_SESSION['mess_Invoice'] = INVOICE_ENT_MULTIPLE_ERROR;
					$RedirectURL = "editInvoiceEntry.php?edit=".$_GET['edit']; 
					 header("Location:".$RedirectURL);
		       			 exit;
				}
					    
			 }  
			/******************************/
	
	 
			$_POST['InvoiceID'] = $_POST['SoInvoiceIDGL'];
		        $_POST['EntryType'] = $_POST['EntryTypeGL'];
		        $_POST['EntryDate'] = $_POST['EntryDateGL'];
		        $_POST['EntryFrom'] = $_POST['EntryFromGL'];
		        $_POST['EntryTo'] = $_POST['EntryToGL'];                
		        $_POST['EntryInterval'] = $_POST['EntryIntervalGL'];
		        $_POST['EntryMonth'] = $_POST['EntryMonthGL'];
		        $_POST['EntryWeekly'] = $_POST['EntryWeeklyGL'];                
		        $_POST['PaymentMethod'] = $_POST['PaymentMethodGL'];
		        $_POST['InvoiceComment'] = $_POST['InvoiceCommentGL'];
			$_POST['Currency'] = $_POST['CurrencyGL'];  
			$_POST['ConversionRate'] = $_POST['ConversionRateGL'];
			$_POST['PaymentTerm'] = $_POST['PaymentTermGL'];

			if(!empty($_POST['CreditCardType2']) && !empty($_POST['CreditCardNumber2'])){
				 $_POST['PaymentTerm'] = 'Credit Card';
			}

			if(empty($_POST['ConversionRate']) && !empty($_POST['Currency']) && $_POST['Currency']!=$Config['Currency']){
				$_POST['ConversionRate'] = CurrencyConvertor(1,$_POST['Currency'],$Config['Currency'],'AR',$_POST['PaymentDate']);
			}
			if(empty($_POST['ConversionRate'])) $_POST['ConversionRate']=1; 
			 /***************/
			if($_POST['OrderID']>0){  
				$OrderID = $_POST['OrderID'];
				$_SESSION['mess_Invoice'] = INVOICE_ENT_UPDATED.$OtherMsg;			
				$objBankAccount->updateInvoiceGL($_POST);
			}else{			
				$_SESSION['mess_Invoice'] = INVOICE_GENERATED_MESSAGE.$OtherMsg;
				$OrderID = $objBankAccount->addInvoiceGL($_POST);
				$PostedOrderID = $OrderID;
				$RedirectURL = "editInvoiceEntry.php?edit=".$OrderID;
			}	

			/***********************/
			$_POST['CreditCardType'] = $_POST['CreditCardType2'];
			$_POST['CreditCardNumber'] = $_POST['CreditCardNumber2'];
			$_POST['CreditCardNumberTemp'] = $_POST['CreditCardNumberTemp2'];
			$_POST['CreditCardID'] = $_POST['CreditCardID2']; 
			$_POST['CreditExpiryMonth'] = $_POST['CreditExpiryMonth2'];  
			$_POST['CreditExpiryYear'] = $_POST['CreditExpiryYear2'];  
			$_POST['CreditSecurityCode'] = $_POST['CreditSecurityCode2'];  
			$_POST['CreditCardHolderName'] = $_POST['CreditCardHolderName2'];  
			$_POST['CreditAddress'] = $_POST['CreditAddress2'];  
			$_POST['CreditCountry'] = $_POST['CreditCountry2']; 
			$_POST['CreditState'] = $_POST['CreditState2'];
			$_POST['CreditCity'] = $_POST['CreditCity2'];
			$_POST['CreditZipCode'] = $_POST['CreditZipCode2'];

			$objSale->AddUpdateCreditCard($OrderID, $_POST); 
			/***********************/		


			/***************log by sanjiv********************/
			$_POST['ModuleType'] ='SalesInvoiceEntry';
			$objConfig->AddUpdateLogs($OrderID, $_POST);
			/***********************************/

		/*****AutoPostToGl**********
		include_once("../includes/AutoPostToGlArInvoice.php");
		/**************************/

		/*******Generate PDF************/			
		$PdfArray['ModuleDepName'] = "SalesInvoiceGl";
		$PdfArray['Module'] = "Invoice";
		$PdfArray['ModuleID'] = "InvoiceID";
		$PdfArray['TableName'] =  "s_order";
		$PdfArray['OrderColumn'] =  "OrderID";
		$PdfArray['OrderID'] =  $OrderID;		 			
		$objConfigure->GeneratePDF($PdfArray);
		/*******************************/
		 

		include("includes/html/box/card_process_gl.php");


                header("Location:".$RedirectURL);
                exit;
	}
	/**********************************/







	$GLAccountLineItem = 'GL Account';	
	$GLAccountLineItemType = 'GLAccount';
	
	 $amntChecked=$TransactionExist='';

	if(!empty($_GET['edit'])){		
		$arrySale = $objSale->GetSale($_GET['edit'],'',$module);
		$OrderID   = $arrySale[0]['OrderID'];
 		$TotalInvoiceAmount =  $arrySale[0]['TotalInvoiceAmount'];
         

           //modified by nisha on 18sept2018
		$SalesPerson='';
            if(!empty($arrySale[0]['SalesPersonID'])){
          	    $empSalesPersonName = $objConfig->getSalesPersonName($arrySale[0]['SalesPersonID'],0);
			    $SalesPerson = $empSalesPersonName;
            }
           if(!empty($arrySale[0]['VendorSalesPerson'])){
            	$venSalesPersonName = $objConfig->getSalesPersonName($arrySale[0]['VendorSalesPerson'],1);
			    $SalesPerson = $venSalesPersonName;
            }
            if((!empty($empSalesPersonName)) && (!empty($venSalesPersonName))){
            	 $SalesPerson = $empSalesPersonName.",".$venSalesPersonName;
            }
             $arrySale[0]['SalesPerson'] = $SalesPerson;
		//end code here

		if($OrderID>0){
                   /****GET Document by sachin****/
       $_GET['OrderID']=$OrderID;
       $_GET['Module']='SalesInvoice';
       $_GET['ModuleName']='SalesInvoice';
       $getDocumentArry=$objConfig->GetOrderDocument($_GET);
       //PR($getDocumentArry);
       /****GET Document by sachin****/
			if($arrySale[0]['InvoiceEntry']==2 || $arrySale[0]['InvoiceEntry']==3 ){
				$GLAccountLineItem = 'GL Account';
				$GLAccountLineItemType = 'GLAccount';
				$_GET['IncomeID'] = $arrySale[0]['IncomeID'];	

				if($_GET['IncomeID']>0){	
					$arryOtherIncome=$objBankAccount->getOtherIncomeGL($_GET);

					if($arryOtherIncome[0]['GlEntryType']=="Multiple"){
						$arryMultiAccount=$objBankAccount->getMultiAccountgl($_GET['IncomeID']);
		           			$NumLine = sizeof($arryMultiAccount);
						$amntChecked = "checked";
					}else{
					$arryMultiAccount = $objConfigure->GetDefaultArrayValue('f_multi_account');
					}
				}
				$arrySaleItem  = $objConfigure->GetDefaultArrayValue('s_order_item');

				

			}else{
				$GLAccountLineItem = 'Line Item';
				$GLAccountLineItemType = 'LineItem';
				$arrySaleItem = $objSale->GetSaleItem($OrderID);
				$NumLine = sizeof($arrySaleItem);
				
 
				$arryOtherIncome = $objConfigure->GetDefaultArrayValue('f_income');
				$arryMultiAccount = $objConfigure->GetDefaultArrayValue('f_multi_account');
				 
				/*******Setting Default Shipping Account*********/
				$arryShipAccount=$objCustomer->ListCustShipAccount($arrySale[0]['ShippingMethod'],$arrySale[0]['CustID']);
				if(!empty($arrySale[0]['ShippingAccountNumber'])){
					if(!empty($arryShipAccount)){ 					 
						foreach($arryShipAccount as $vals) {
							if($vals['api_account_number']==$arrySale[0]['ShippingAccountNumber']){
							 $ShipAccExist=1;break;
							}
						}
					}
					if(empty($ShipAccExist)) 
						$arryShipAccount[]['api_account_number'] = $arrySale[0]['ShippingAccountNumber'];		 
				 
				}
				/**********************/
			}
			
		  			
			if(!empty($arrySale[0]['PaymentTerm'])){					
				$TransactionExist = $objSale->isSalesTransactionExist($OrderID);
				//$TransactionExist = 1;
			}
			 

		}else{
			$ErrorMSG = $NotExist;
		}
		
	}else{
		$NextModuleID = $objConfigure->GetNextModuleID('s_order','Invoice');
		$OrderID='';
	}


	 	
	$ConditionDrop  =$objCondition-> GetConditionDropValue('');		
 $WarehouseDrop  =$objCondition-> GetWarehouseDropValue('');	
	if(empty($NumLine)) $NumLine = 1;	


	$arrySaleTax = $objTax->GetTaxRate('1');
	
	$_SESSION['DateFormat']= $Config['DateFormat'];
        
        $arryPaymentTerm = $objConfigure->GetTerm('','1');
	$arryPaymentMethod = $objConfigure->GetAttribFinance('PaymentMethod','');
	$arryShippingMethod = $objConfigure->GetAttribValue('ShippingMethod','attribute_value');
	$arryOrderSource = $objCommon->GetFixedAttribute('OrderSource','');	
	$TaxableBilling = $objConfigure->getSettingVariable('TaxableBilling');

	/*************/
	$Config['NormalAccount']=1;
	$arryBankAccount=$objBankAccount->getBankAccountWithAccountType();
	$arryBankAccountList = $arryBankAccount;
	/*************/
	$arryBankAccountVal=$objBankAccount->getBankAccountForReceivePayment();

	if(empty($_GET['edit']) || $arrySale[0]['InvoiceEntry']==2 || $arrySale[0]['InvoiceEntry']==3 ){	 
		$arryCustomer=$objBankAccount->getCustomerList();				 
	}	


	/**************************/	
	if($GLAccountLineItemType == 'GLAccount'){
		$GlDivHide = '';
		$LineItemDivHide = 'style="display:none"';
	}else{
		$GlDivHide = 'style="display:none"';
		$LineItemDivHide = '';	
	}
	/**************************/
 	
	if(empty($AccountReceivable)){
		 $ErrorMSG = SELECT_GL_AR_ALL; 
	}

 	
	require_once("../includes/footer.php"); 	 
?>


