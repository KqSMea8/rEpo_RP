<?php 
	if(!empty($_GET['pop']))$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'viewInvoice.php'; $EditPage = 1;$SetFullPage = 1;
	/**************************************************/

	include_once("../includes/header.php");
	require_once($Prefix."classes/sales.quote.order.class.php");
	require_once($Prefix."classes/inv_tax.class.php");
	require_once($Prefix."classes/sales.class.php");
	require_once($Prefix . "classes/item.class.php");
        require_once($Prefix . "classes/inv.condition.class.php");
	require_once($Prefix."classes/finance.account.class.php");
	require_once($Prefix."classes/finance.report.class.php");
	require_once($Prefix."classes/finance.journal.class.php");
	require_once($Prefix."classes/finance.transaction.class.php");
	require_once($Prefix."classes/card.class.php");

	$objCommon = new common();
	$objSale = new sale();
	$objTax = new tax();
	$objItem = new items();
	$objCondition = new condition();
	$objBankAccount = new BankAccount();
	$objReport = new report();
	$objTransaction=new transaction();
	$objCard = new card();

	$_GET['module']='Order';
	$module = $_GET['module'];
	$ModuleName = "Sale ".$_GET['module'];
	$RedirectURL = "viewInvoice.php?curP=".$_GET['curP'];
	$EditUrl = "editInvoice.php?edit=".$_GET["invoice"]."&curP=".$_GET["curP"]; 
	$ModuleIDTitle = "Invoice Number"; $ModuleID = "SaleInvoiceID"; $PrefixSale = "IN";  $NotExist = NOT_EXIST_ORDER;

		
	if(!empty($_POST['GenerateInVoice'])) {	
		 CleanPost();   
		

		if(!empty($_POST['SaleInvoiceID'])){
			if($objSale->isInvoiceNumberExists($_POST['SaleInvoiceID'],$_POST['OrderID'])){
				//$errMsg = str_replace("[MODULE]","Invoice Number", ALREADY_EXIST);
				$OtherMsg = str_replace("[MODULE]","Invoice Number", ALREADY_EXIST_ASSIGNED);
				$_POST['SaleInvoiceID'] = $objConfigure->GetNextModuleID('s_order','Invoice');
			}
		}
		if(empty($errMsg)) {
			
			$_POST['InvoiceID'] = $_POST['SaleInvoiceID'];
			/*****************/
		        
			unset($_SESSION['mess_gen']);
			for($i=1;$i<=$_POST['NumLine'];$i++){			
				$ItemID = $_POST['item_id'.$i];
				$Sku = $_POST['sku'.$i];
				$Qty = $_POST['qty'.$i];
		                
		               
		                
				$DropshipCheck = $_POST['DropshipCheck'.$i];
				$msg = '';			
				if($Qty>0 && !empty($Sku) && !empty($ItemID)){				
					$arryItem = $objItem->GetItemById($ItemID);				
					/*if($arryItem[0]['evaluationType']=='Serialized' && $DropshipCheck!=1){
						$NumSerial = $objSale->CountSkuSerialNo($Sku);
						$_GET['Sku']=$Sku;
						$arrySerial=$objItem->ListSerialNumber($_GET);
						$NumSerial = sizeof($arrySerial);
		                               
						if($Qty > $NumSerial){
							$msg = str_replace("[Sku]",$Sku,SERIALIZE_NUM_MSG);
							$msg = str_replace("[NumSerial]",$NumSerial,$msg);
							$msg = str_replace("[Qty]",$Qty,$msg);
							$_SESSION['mess_gen'] .= $msg;
						}
					}*/
				}
			}
		
		
			if(!empty($_SESSION['mess_gen'])){
				$_SESSION['mess_gen'] = INVOICE_NOT_GENERATED.'<br>'.$_SESSION['mess_gen'];
			
				$RedirectURL = "generateInvoice.php?so=".$_GET['so']."&invoice=".$_GET['invoice']; 
				header("Location:".$RedirectURL);
				exit;
			}
		
			/*****************/
			/********* Copy comments by Sanjiv *************/
		if(!empty($_POST['InvoiceComment'])){
			$MultiComment = explode("##",$_POST['InvoiceComment']);
			if(!empty($MultiComment[1])){
				$cmtIDS = array_filter($MultiComment);
				$cmtIDS = implode(',', $cmtIDS);
				$CommentData = $objBankAccount->getComment($cmtIDS, true);
				$generateComments = $objBankAccount->CopyingComments($CommentData);
				$_POST['InvoiceComment'] = $generateComments;
			}
		}
		
		/*if($_SESSION['DisplayName']=='sakshay'){
			pr($_POST,1);
		}*/

		/********* End of Copy comments *************/
			$order_id = $objSale->GenerateInVoice($_POST);
			$_SESSION['mess_Invoice'] = INVOICE_GENERATED_MESSAGE.$OtherMsg;
			$objSale->AddInvoiceItem($order_id, $_POST); 
		        $PostedOrderID = $order_id;
		        
		        
			/********************UPDATE SERIAL NUMBER*******************************************/
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
			/***********************END SERIAL NUMBER****************************************************/
		        

			/*********************/
			$TotalInvoiceAmount = $_POST['TotalAmount'];
			$PaymentTerm = $_POST['PaymentTerm'];
			$CardOrderID = $order_id;
			include_once("includes/html/box/edit_invoice_credit.php"); //AmountToCharge
			/*********************/
			

			/*****AutoPostToGl**********/
			if(empty($AmountToCharge)){
				include_once("../includes/AutoPostToGlArInvoice.php");
			}
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


			$RedirectURL = "viewInvoice.php";
			header("Location:".$RedirectURL);
			exit;

		}
		

	 } 
				
		


	if(!empty($_GET['invoice']) || !empty($_GET['so'])){
		$arrySale = $objSale->GetSale($_GET['invoice'],$_GET['so'],$module);
               
		$OrderID   = $arrySale[0]['OrderID'];	
		$InvoiceComment = stripslashes($arrySale[0]['Comment']);
		if($OrderID>0){
			$arrySaleItem = $objSale->GetSaleItem($OrderID);   

                 
			$NumLine = sizeof($arrySaleItem);

			/***********************/
			$ShipTrackingID='';
			$arryShippInfo = $objCommon->GetShippInfoByOrder($OrderID);
			if(!empty($arryShippInfo[0]['ShipType'])){
				$ShipType = $arryShippInfo[0]['ShipType'];
				$ShipTrackingID = $arryShippInfo[0]['trackingId'];
				$ShipFreight = $arryShippInfo[0]['totalFreight'];
			}
			$arrySale[0]['TrackingNo'] = $ShipTrackingID;
			 
			/***********************/


			$BankAccount='';
			 if(strtolower(trim($arrySale[0]['PaymentTerm']))=='prepayment' && !empty($arrySale[0]['AccountID'])){
			    $arryBankAccount = $objBankAccount->getBankAccountById($arrySale[0]['AccountID']);
			    $BankAccount = $arryBankAccount[0]['AccountName'] . ' [' . $arryBankAccount[0]['AccountNumber'] . ']';
			}


			$_GET['OrderID']=$OrderID;
		        $_GET['Module']='SalesOrder';
		        $_GET['ModuleName']='Sales';
	 
		        $getDocumentArry=$objConfig->GetOrderDocument($_GET);

		}else{
			$ErrorMSG = $NotExist;
		}
	}else{
		header("Location:".$RedirectURL);
		exit;
	}


	$NextModuleID = $objConfigure->GetNextModuleID('s_order','Invoice');
	$arryShippingMethod = $objConfigure->GetAttribValue('ShippingMethod','attribute_value');

	$TaxableBilling = $objConfigure->getSettingVariable('TaxableBilling');
	
	if(empty($NumLine)) $NumLine = 1;	


	$arrySaleTax = $objTax->GetTaxRate('1');
	
	$_SESSION['DateFormat']= $Config['DateFormat'];

	require_once("../includes/footer.php"); 	 
?>


