<?php 
	if(!empty($_GET['pop']))$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'viewInvoice.php'; $EditPage = 1;$SetFullPage = 1;
	/**************************************************/

	include_once("../includes/header.php");
	require_once($Prefix."classes/item.class.php");
	require_once($Prefix."classes/sales.quote.order.class.php");
	require_once($Prefix."classes/inv_tax.class.php");
	require_once($Prefix."classes/sales.class.php");
	
        require_once($Prefix."classes/inv.condition.class.php");
	require_once($Prefix."classes/finance.account.class.php");
 	require_once($Prefix."classes/function.class.php");
	require_once($Prefix."classes/card.class.php");
	require_once($Prefix."classes/archive.class.php");

	$objFunction=new functions();
	$objSale = new sale();
	$objTax = new tax();
	$objItem = new items();
	$objCondition = new condition();
	$objCommon = new common();
	$objBankAccount = new BankAccount();
	$objCard = new card();
	$objArchive = new archive();

	$module = 'Invoice';
	$ModuleName = "Edit Invoice";
	$RedirectURL = "viewInvoice.php?curP=".$_GET['curP'];
	$EditUrl = "editInvoice.php?edit=".$_GET["edit"]."&curP=".$_GET["curP"]; 

	$ModuleIDTitle = "Invoice Number";   $NotExist = NOT_EXIST_INVOICE;
	
	$_GET['del_id'] = (int)$_GET['del_id'];
	$_GET['edit'] = (int)$_GET['edit'];


 	if(!empty($_GET['del_id'])){
		$_SESSION['mess_Invoice'] = $module.REMOVED;
		$objArchive->AddToArchiveSO($_GET['del_id']);
		$objSale->RemoveInvoice($_GET['del_id']);
		header("Location:".$RedirectURL);
		exit;
	}

  	include("includes/html/box/card_invoice_void.php");
	
	if($_POST) {    
		CleanPost();

		$_POST['TrackingNo'] = implode(':',$_POST['TrackingNo']);

		if(!empty($_POST['SaleInvoiceID'])){
			if($objSale->isInvoiceNumberExists($_POST['SaleInvoiceID'],$_POST['OrderID'])){
				#$errMsg = str_replace("[MODULE]","Invoice Number", ALREADY_EXIST);
				$OtherMsg = str_replace("[MODULE]","Invoice Number", ALREADY_EXIST_ASSIGNED);
				$_POST['SaleInvoiceID'] = $objConfigure->GetNextModuleID('s_order','Invoice');
			}
		}
		if(!empty($errMsg)) {
			$_SESSION['mess_Invoice'] = $errMsg;			
			header("Location:".$EditUrl);
               		exit;
		}


 

		 if(!empty($_POST['OrderID'])) {
			$OrderID = $_POST['OrderID'] ;			
			//$objSale->UpdateSOInvoice($_POST);
			$objSale->UpdateSHIPInvoice($_POST);
			$objSale->UpdateEdiPO($_POST);
if($_FILES['UploadDocuments']['name'] != ''){  


					$imageName = "Documents_".$OrderID;			

					$FileInfoArray['FileType'] = "Scan";
					$FileInfoArray['FileDir'] = $Config['S_DocomentDir'];
					$FileInfoArray['FileID'] =  $imageName;
					$FileInfoArray['OldFile'] = $_POST['OldUploadDocuments'];
					$FileInfoArray['UpdateStorage'] = '1';
					$ResponseArray = $objFunction->UploadFile($_FILES['UploadDocuments'], $FileInfoArray);
					if($ResponseArray['Success']=="1"){  
						$objSale->UpdateUploadDocuments($ResponseArray['FileName'],$OrderID);
					 
					}else{
						$ErrorMsg = $ResponseArray['ErrorMsg'];
					}

				if(!empty($ErrorMsg)){
				     $_SESSION['mess_Invoice'] .= '<br><br>'.$ErrorMsg;
				}


				}

			/********************UPDATE SERIAL NUMBER*******************************************
			for($k=1;$k<=$_POST['NumLine'];$k++){
				$serial_value = $_POST['serial_value'.$k];

				$explodeSerialVal = explode(",",$serial_value);
				$SerailSize = sizeof($explodeSerialVal);

				for($j=0;$j<$SerailSize;$j++){

				$arraySerailData['serialNumber'] = trim($explodeSerialVal[$j]);
				$arraySerailData['warehouse'] = $_POST['wCode'];
				$arraySerailData['Sku'] = $_POST['sku'.$k];

					if($arraySerailData['serialNumber'] != ""){
						$objSale->addSerailNumberForInvoice($arraySerailData);
					}
				}
			}
			***********************END SERIAL NUMBER****************************************************/
			$objSale->AddUpdateCreditCard($OrderID, $_POST); 
	   		/***************log by sanjiv********************/
			$_POST['ModuleType'] ='SalesInvoice';
			$objConfig->AddUpdateLogs($OrderID, $_POST);
			/***********************************/

			/*******Generate PDF************/			
			$PdfArray['ModuleDepName'] = "SalesInvoice";
			$PdfArray['Module'] = "Invoice";
			$PdfArray['ModuleID'] = "InvoiceID";
			$PdfArray['TableName'] =  "s_order";
			$PdfArray['OrderColumn'] =  "OrderID";
			$PdfArray['OrderID'] =  $OrderID;
			$objConfigure->GeneratePDF($PdfArray);
			/*******************************/

			if($_POST['PaymentTerm']=='Credit Card'){			
				$RedirectURL = $EditUrl;
			}

			$_SESSION['mess_Invoice'] = INVOICE_UPDATED.$OtherMsg;
			header("Location:".$RedirectURL);
			exit;
		 } 
	}	

	$inputBoxClass = 'class="datebox"';
	$CreditCardFlag = '';

	if(!empty($_GET['edit'])){
		$arrySale = $objSale->GetSale($_GET['edit'],'',$module);
		 
		$OrderID   = $arrySale[0]['OrderID'];	
		$SaleID   = $arrySale[0]['SaleID'];
                /*****code for get document by sachin******/

		 $OrderIDForOrderDocumentArry=$objSale->GetOrderIDForOrderDocument($arrySale[0]['SaleID'],'Order');
		 //PR($OrderIDForOrderDocumentArry);
		 //echo $OrderIDForOrderDocumentArry[0]['OrderID'];
	        $_GET['OrderID']=$OrderIDForOrderDocumentArry[0]['OrderID'];
                $_GET['Module']='SalesOrder';
                $_GET['ModuleName']='Sales';
                $getDocumentArry=$objConfig->GetOrderDocument($_GET);
                //PR($getDocumentArry);
		/*****code for get document by sachin******/
		$InvoiceComment = stripslashes($arrySale[0]['InvoiceComment']);
		if($OrderID>0){
			$arrySaleItem = $objSale->GetSaleItem($_GET['edit']);

			$NumLine = sizeof($arrySaleItem);	

			/***********************/
			
			$arryShippInfo = $objCommon->GetShippingInfoInvoice($arrySale[0]['TrackingNo'],$arrySale[0]['InvoiceID']);
			if(!empty($arryShippInfo[0]['ShipType'])){
				$ShipType = $arryShippInfo[0]['ShipType'];
				$ShipTrackingID = $arryShippInfo[0]['trackingId'];
				$ShipFreight = $arryShippInfo[0]['totalFreight'];				 
			}			
			/***********************/

			$SalesPersonID   = $arrySale[0]['SalesPersonID'];
			$Commition = $objSale->GetUserCommision($SalesPersonID);


			$BankAccount='';
			if(strtolower(trim($arrySale[0]['PaymentTerm']))=='prepayment' && !empty($arrySale[0]['AccountID'])){
			    $arryBankAccount = $objBankAccount->getBankAccountById($arrySale[0]['AccountID']);
			    $BankAccount = $arryBankAccount[0]['AccountName'] . ' [' . $arryBankAccount[0]['AccountNumber'] . ']';
			}
			
			/*********************/
			$TotalInvoiceAmount = $arrySale[0]['TotalInvoiceAmount'];
			$PaymentTerm = $arrySale[0]['PaymentTerm'];
			$CardOrderID = $OrderID;
			include_once("includes/html/box/edit_invoice_credit.php");
			/*********************/

		}else{
			$ErrorMSG = $NotExist;
		}
		//$ErrorMSG = UNDER_CONSTRUCTION;
	}

	


		
	if(empty($NumLine)) $NumLine = 1;	


	$arrySaleTax = $objTax->GetTaxRate('1');
	$arryPaymentTerm = $objConfigure->GetTerm('','1');
	$arryPaymentMethod = $objConfigure->GetAttribFinance('PaymentMethod','');
	$arryShippingMethod = $objConfigure->GetAttribValue('ShippingMethod','attribute_value');
	$arryOrderStatus = $objCommon->GetFixedAttribute('OrderStatus','');		
	$arryOrderType = $objCommon->GetFixedAttribute('OrderType','');		
	$arryOrderSource = $objCommon->GetFixedAttribute('OrderSource','');	
        $ConditionDrop  =$objCondition-> GetConditionDropValue('');
	$_SESSION['DateFormat']= $Config['DateFormat'];
	$TaxableBilling = $objConfigure->getSettingVariable('TaxableBilling');
	 
	require_once("../includes/footer.php"); 	 
?>
