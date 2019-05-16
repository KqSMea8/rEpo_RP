<?php 
	/**************************************************/
	if(!empty($_GET['batchId'])) { $_GET['batch'] = $_GET['batchId']; }

	if(!empty($_GET['batch'])){
		$ThisPageName = "viewbatchmgmt.php";	
	}else{
		$ThisPageName = "viewShipment.php";
	}	
	$EditPage = 1; $SetFullPage = 1;
	/**************************************************/

		include_once("../includes/header.php");

		require_once($Prefix."classes/item.class.php");
    
		require_once($Prefix."classes/sales.quote.order.class.php");
		require_once($Prefix."classes/inv_tax.class.php");
		require_once($Prefix."classes/warehouse.shipment.class.php");
		require_once($Prefix."classes/inv.condition.class.php");
		require_once($Prefix."classes/warehouse.class.php");
		require_once($Prefix."classes/finance.account.class.php");
		require_once($Prefix."classes/finance.report.class.php");
		require_once($Prefix."classes/finance.journal.class.php");
		require_once($Prefix."classes/finance.transaction.class.php");
		require_once($Prefix."classes/card.class.php");
    		require_once($Prefix."classes/archive.class.php");
		require_once($Prefix."classes/warehousing.class.php");

		$objSale = new sale();
		$objTax=new tax();
		$objShipment = new shipment();
		$objCondition=new condition();
		$objWarehouse=new warehouse();
		$objItem=new items();
		$objBankAccount = new BankAccount();
		$objReport = new report();
		$objTransaction=new transaction();
		$objCard = new card();
		$objShipment = new shipment();
		$objArchive = new archive();
 		$objCommon=new common();

		$Module = "Shipment";
		$ModuleIDTitle = "Shipment Number"; $ModuleID = "ShippedID"; $PrefixSale = "SHIP";  $NotExist = NOT_EXIST_ORDER;
		$RedirectURL = $ThisPageName."?curP=".$_GET['curP']."&batch=".$_GET['batch'];
		$ModDepName='WhouseBatchMgt';//by sachin
		 $DownloadUrl ="../pdfCommonhtml.php?SHIP=".$_GET["edit"] ."&ModuleDepName=". $ModDepName ."&curP=". $_GET['curP']."";

		
	/**********Temp************
	if($_GET['pkkkk'] == '385325235' ){		
		require_once($Prefix."classes/product.class.php");
		$arryProduct = new product();
		$arryProduct->upadateSingleShipping($Prefix, '16102');
		die;
	}
	/**********************/ 
 




 if(!empty($_POST)){
	
	$OtherMsg='';

	if(!empty($_POST['ShippedID'])){
		if($objShipment->isShipmentNumberExists($_POST['ShippedID'],$_POST['OrderID'])){
			$OtherMsg = str_replace("[MODULE]","Shipment No", ALREADY_EXIST_ASSIGNED);
			$_POST['ShippedID'] = $objConfigure->GetNextModuleID('s_order','Shipment');
		}
	}
 
	if(!empty($_POST['RefInvoiceID']) && $_POST['ShipStatus']=='Shipped'){
		if($objSale->isInvoiceNumberExists($_POST['RefInvoiceID'],'')){
			//$errMsg = str_replace("[MODULE]","Invoice Number", ALREADY_EXIST);
			$OtherMsg = str_replace("[MODULE]","Invoice Number", ALREADY_EXIST_ASSIGNED);
			$_POST['RefInvoiceID'] = $objConfigure->GetNextModuleID('s_order','Invoice');
		}
	}
	if(empty($errMsg)) {
		//$_SESSION['Shipping']['totalFreight']=20;$_SESSION['Shipping']['ShipType'] = 'Fedex';

		$_POST['file_name']=$_SESSION['Shipping']['file_name'];
		$_POST['freigh']=$_SESSION['Shipping']['freigh'];
		$_POST['totalFreight']=$_SESSION['Shipping']['totalFreight'];
		$_POST['tracking_id']=$_SESSION['Shipping']['tracking_id'];
		$_POST['COD']= $_SESSION['Shipping']['COD'];
		$_POST['sendingLabel']= $_SESSION['Shipping']['sendingLabel'];
		$_POST['ShipType']= $_SESSION['Shipping']['ShipType'];
		
		if(!empty($_SESSION['Shipping']['ShipAccountNumber'])){
			$_POST['ShipAccountNumber']= $_SESSION['Shipping']['ShipAccountNumber'];
		}

		if(!empty($_POST['ShippedOrderID'])){
			$OrderID = $objShipment->ShipOrder($_POST);
			$_POST['OrderID'] = $OrderID ;
			$_SESSION['mess_ship'] = SHIP_ADDED.$OtherMsg;
			
			/***************multiple shipment***************
			if(!empty($_POST['multipleShip'])){
				$TempOrderID = $_POST['OrderID'];
				$TempShipID = $_POST['shipID'];

				$multipleShipVal = $_POST['multipleShip'];
				$multipleShipData = explode(",", $multipleShipVal);

				if(sizeof($multipleShipData)>0){
					$_SESSION['Shipping']['Multiple']= 1;
					$_SESSION['Shipping']['MultipleOrderID']= $multipleShipVal;

					foreach($multipleShipData as $multipleOrderID){
						$_POST['OrderID'] = $multipleOrderID;
						$_POST['shipID'] = $objShipment->GetShipmentID($multipleOrderID);
						if(!empty($_POST['shipID'])){
							$objShipment->UpdateShipment($_POST);
							#$objShipment->UpdateFreightShipment($multipleOrderID, $_POST['totalFreight']); //not needed
						}
					}
					$_POST['OrderID'] = $TempOrderID;
					$_POST['shipID'] = $TempShipID;	
					$objShipment->UpdateMultipleOrderID($_POST['OrderID']);
				}else{	
					$_SESSION['Shipping']['Multiple']= 0;
					$_SESSION['Shipping']['MultipleOrderID']= '';
				}

			}
			/*******************************************/



		}else if(!empty($_POST['shipID']) && ($_POST['Submit'] == "Save")){  
			$objShipment->UpdateShip($_POST);
			$objShipment->UpdateShipment($_POST);
			$_SESSION['mess_ship'] = SHIP_UPDATED.$OtherMsg;
	   		$OrderID = $_POST['OrderID'];			
		}      


		/***************multiple shipment***************/
		if(!empty($_POST['multipleShip'])){
			$TempOrderID = $_POST['OrderID'];
			$TempShipID = $_POST['shipID'];

			$multipleShipVal = $_POST['multipleShip'];
			$multipleShipData = explode(",", $multipleShipVal);

			if(sizeof($multipleShipData)>0){
				$_SESSION['Shipping']['Multiple']= 1;
				$_SESSION['Shipping']['MultipleOrderID']= $multipleShipVal;

				foreach($multipleShipData as $multipleOrderID){
					$_POST['OrderID'] = $multipleOrderID;
					$_POST['shipID'] = $objShipment->GetShipmentID($multipleOrderID);
					if(!empty($_POST['shipID'])){
						$objShipment->UpdateShipment($_POST);
						#$objShipment->UpdateFreightShipment($multipleOrderID, $_POST['totalFreight']); //not needed
					}
				}
				$_POST['OrderID'] = $TempOrderID;
				$_POST['shipID'] = $TempShipID;	
				$objShipment->UpdateMultipleOrderID($_POST['OrderID']);
			}else{	
				$_SESSION['Shipping']['Multiple']= 0;
				$_SESSION['Shipping']['MultipleOrderID']= '';
			}

		}
		/*******************************************/
		


		/********** update Shipment Using api by Sanjiv ********/
		if(!empty($OrderID) && !empty($_SESSION['Shipping']['tracking_id'])){
			require_once($Prefix."classes/product.class.php");
			$arryProduct = new product();
			$arryProduct->upadateSingleShipping($Prefix, $OrderID);
		}
		
		/************Remove labels on UpdateShipment************************/
		if(isset($Config['UnlinkShipLable']['ShipType'])){
			require_once($Prefix."classes/function.class.php");
			$objFunction=new functions();
			$LabelFolder = strtolower($Config['UnlinkShipLable']['ShipType'])."/";
			$LabelPath = "../shipping/upload/".$LabelFolder.$_SESSION['CmpID']."/";
			foreach($Config['UnlinkShipLable']['ShipLabel'] as $UnShipLabel){
				$objFunction->DeleteDocStorage($LabelPath, $LabelFolder,$UnShipLabel);
			}
		}
		/********** end of update Shipment ********/
		if($_POST['ShipStatus']=='Shipped'){
			$InvoiceData['OrderID'] =$OrderID;
			$InvoiceData['InvoiceID'] = $_POST['RefInvoiceID'];
			$InvoiceData['TotalAmount'] = $_POST['TotalAmount'];
			$InvoiceData['Freight'] = $_POST['Freight'];
			$InvoiceData['taxAmnt'] ='';
			$InvoiceData['ShippedDate']=$_POST['ShippedDate'];
			$InvoiceData['wCode'] = $_POST['WarehouseCode'];
			$InvoiceData['wName'] = $_POST['WarehouseName'];
			$InvoiceData['InvoiceComment'] = $_POST['ShipmentComment'];
			$InvoiceData[0]['ShippingMethod']=$_POST['chooseItem'];
			$_POST['TrackingNo'] = $_POST['tracking_id'];
			$_POST['InvoiceID'] = $_POST['RefInvoiceID'];

			$arrysalItem = $objSale->GetSaleItem($_POST['OrderID']);

			$order_inv_id = $objSale->GenerateInVoice($_POST);
	
			if($order_inv_id>0){
					$Invoice['order_id'] = $order_inv_id;
					//$objSale->AddInvoiceItem($order_inv_id, $_POST);
					$objSale->AddShipmentInvoiceItem($order_inv_id, $_POST);
					$objSale->UpdateInvoiceIDInShip($_POST,$order_inv_id,$OrderID);
					$PostedOrderID = $order_inv_id;
			} 

		}

		$objShipment->ShipOrderQtyUpdate($_POST);
		#$objShipment->UpdateFreightShipment($OrderID, $_POST['totalFreight']);

		$objShipment->UpdateFreightInInvoice($OrderID);
		$objShipment->UpdateFreightInEDIPO($OrderID);

		if($order_inv_id>0){

				$arryData = $objSale->GetSale($order_inv_id, '', '');

				/*********************/				
				$TotalInvoiceAmount = $arryData[0]['TotalInvoiceAmount'];
				$PaymentTerm = $arryData[0]['PaymentTerm'];
				$CardOrderID = $order_inv_id;
				include_once("../finance/includes/html/box/edit_invoice_credit.php"); //AmountToCharge
				/*********************/



				/*****AutoPostToGl**********/
				if($_SESSION['batchmgmt'] != 1 && empty($AmountToCharge)){
					include_once("../includes/AutoPostToGlArInvoice.php");
				}
				/**************************/


				/*******Generate PDF************/			
				$PdfArray['ModuleDepName'] = "SalesInvoice";
				$PdfArray['Module'] = "Invoice";
				$PdfArray['ModuleID'] = "InvoiceID";
				$PdfArray['TableName'] =  "s_order";
				$PdfArray['OrderColumn'] =  "OrderID";
				$PdfArray['OrderID'] =  $order_inv_id;
				$PdfArray['UploadPrefix'] =  "../finance/";
				$objConfigure->GeneratePDF($PdfArray);
				/*******************************/
				
		}


		header("Location:".$RedirectURL);
		exit;


		}

        
        
        
        }


if( !empty($_GET['del_id'])){
			$_SESSION['mess_ship'] = SHIP_REMOVED;
      require_once($Prefix."classes/function.class.php");
			$objFunction=new functions();

			$objArchive->AddToArchiveSO($_GET['del_id']);
			$objShipment->RemoveShipment($_GET['del_id']);
			//$objShipment->RemoveShipmentInvoice($_GET);
			if($_SESSION['batchmgmt'] ==1){
				header("location:vbatchmgmt.php?view=".$_GET['batch']);
			}else{
			  header("Location:".$RedirectURL);
			}
		exit;
	}



		
	if(!empty($_GET['edit']) && !empty($_GET['SaleID'])){
		//$arrySale = $objSale->GetInvoice($_GET['edit'],$_GET['SaleID'],'Order');
		$module = 'Order';
		$arrySale = $objSale->GetSale($_GET['edit'],'',$module);
		$OrderID   = $arrySale[0]['OrderID'];

		/*****************/
		if($Config['vAllRecord']!=1){	
			if($arrySale[0]['SalesPersonID'] != $_SESSION['AdminID'] && $arrySale[0]['AdminID'] != $_SESSION['AdminID']){
			header('location:'.$RedirectURL);
			exit;
			}
		}
		/*****************/

                /****GET Document by sachin****/
      
	       $_GET['OrderID']=$_GET['edit'];
	       $_GET['Module']='Sales'.$module;
	       $_GET['ModuleName']='Sales';
	       $getDocumentArry=$objConfig->GetOrderDocument($_GET);
	       //PR($arrySale);
	       /****GET Document by sachin****/
		
 
		if($OrderID>0){
			$arrySaleItem = $objSale->GetSaleItem($OrderID);
			#if($_GET['this'] == 1){ echo "<pre>"; print_r($arrySaleItem); }
			$NumLine = sizeof($arrySaleItem);
			
			$SaleID = $arrySale[0]['SaleID'];
			#$arryInvoiceOrder = $objSale->GetInvoiceOrder($SaleID);
			$TotalGenerateReturn = $objShipment->GetQtyShipped($OrderID);
			if($TotalGenerateReturn[0]['QtyInvoiced'] == $TotalGenerateReturn[0]['QtyShipped']){
		           $HideSubmit = 1;
			   $RtnInvoiceMess = SO_ITEM_TO_NO_SHIP;
			}
			
		}else{
			$ErrorMSG = NOT_EXIST_DATA;
		}

		$ModuleName = "Add ".$Module;

		
		$arryShip = $objConfigure->GetDefaultArrayValue('w_shipment');
 
	}else if(!empty($_GET['edit']) && !empty($_GET['ship'])){
		$arrySale = $objShipment->GetShipment($_GET['edit'],$_GET['ship'],'Shipment');
                $arryShip = $objShipment->GetWarehouseShip('',$_GET['edit']);
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
			 
			if(!empty($arrySale[0]['InvoiceID'])){
				   $arryInvoice = $objSale->GetInvoice('', $arrySale[0]['InvoiceID'], 'Invoice');
				if(!empty($arryInvoice[0]['PostToGL'])){
					$ErrorMSG = SHIPMENT_POSTED_TO_GL;
				}

			}

		
		$OrderID   = $arrySale[0]['OrderID'];	
		$SaleID = $arrySale[0]['SaleID'];
$arrySale[0]['GenrateShipInvoice'] = $arryShip[0]['GenrateShipInvoice'];


		/*****************/
		if($Config['vAllRecord']!=1){	
			if($arrySale[0]['SalesPersonID'] != $_SESSION['AdminID'] && $arrySale[0]['AdminID'] != $_SESSION['AdminID']){
			header('location:'.$RedirectURL);
			exit;
			}
		}
		/*****************/

		$arryShippInfo = $objShipment->listingShipmentDetail($_GET['edit']);

		if($OrderID>0){
			$arrySaleItem = $objSale->GetSaleItem($OrderID);
			$NumLine = sizeof($arrySaleItem);
			
			$TotalGenerateReturn = $objShipment->GetQtyShipped($OrderID);
			if($TotalGenerateReturn[0]['QtyInvoiced'] == $TotalGenerateReturn[0]['QtyShipped']){
		      $HideSubmit = 1;
			  $RtnInvoiceMess = SO_ITEM_TO_NO_SHIP;
			}
			
		}else{
			$ErrorMSG = NOT_EXIST_DATA;
		}
		$ModuleName = "Edit ".$Module;
		$HideSubmit = 1;
	}else{
		$ErrorMSG = SELECT_SO_FIRST;
		$ModuleName = "Add ".$Module;
	}
				
 
	
	if(empty($NumLine)) $NumLine = 1;	
	$arrySaleTax = $objTax->GetTaxRate('1');
	
	$NextModuleID = $objConfigure->GetNextModuleID('s_order','Shipment');  
	$NextInvModuleID = $objConfigure->GetNextModuleID('s_order','Invoice');
	
	 unset($_SESSION["Shipping"]);

	if(empty($arryShip[0]['WarehouseCode']) && empty($arryShip[0]['WarehouseName']) && empty($arryShip[0]['WID']) ){
		$defultware = $objWarehouse->GetDefaultWarehouseBrief(1);

		$arryShip[0]['WarehouseCode'] = $defultware[0]['warehouse_code'];
		$arryShip[0]['WarehouseName'] = $defultware[0]['warehouse_name'];
		$arryShip[0]['WID']   =         $defultware[0]['WID'];

	}


	$TaxableBilling = $objConfigure->getSettingVariable('TaxableBilling');


	require_once("../includes/footer.php"); 	 



?>
