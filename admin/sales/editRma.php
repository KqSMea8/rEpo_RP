<?php 
	/**************************************************/
	$ThisPageName = "viewRma.php";	$EditPage = 1; $SetFullPage = 1; $Tooltip = 1;
	/**************************************************/

	include_once("../includes/header.php");
	require_once($Prefix."classes/sales.quote.order.class.php");
	require_once($Prefix."classes/rma.sales.class.php");
	require_once($Prefix."classes/rma.purchase.class.php");
	require_once($Prefix."classes/inv_tax.class.php");
	require_once($Prefix."classes/inv.condition.class.php");
	require_once($Prefix."classes/warehouse.rma.class.php"); 
	require_once($Prefix."classes/finance.transaction.class.php");
	require_once($Prefix."classes/finance.account.class.php");
	require_once($Prefix."classes/finance.report.class.php");
	require_once($Prefix."classes/function.class.php");
	require_once($Prefix."classes/archive.class.php");

	$objFunction=new functions();
	$objrmasale = new rmasale();
	$objTax=new tax();
	$objPurchase=new purchase();
	$objSale = new sale();
	$objCondition=new condition();	
	$objwarehouserma = new warehouserma(); 
	$objTransaction=new transaction();
	$objBankAccount = new BankAccount();
	$objArchive = new archive();

	$Module = "RMA";
	$ModuleIDTitle = "RMA Number"; $ModuleID = "ReturnID"; $PrefixSale = "RTN";   
	$RedirectURL = "viewRma.php?curP=".$_GET['curP'];

	if(!empty($_GET['del_id'])){
		$_SESSION['mess_return'] = RMA_REMOVED;
		$objArchive->AddToArchiveSO($_GET['del_id']);
		$objConfig->RemoveStandAloneShipment($_GET['del_id'], 'SalesRMA'); 
		$objrmasale->RemoveReturn($_GET['del_id']);
		header("Location:".$RedirectURL);
		exit;
	}

	if(!empty($_GET['active_id'])){
		$_SESSION['mess_return'] = RMA_CLOSED;
		$objrmasale->UpdateStatusRma($_GET['active_id']);
		$objwarehouserma->sendSalesEmailClose($_GET['active_id']);
		header("Location:".$RedirectURL);
		exit;
		
	}
	
	/***************************/
	if(!empty($_POST)){
		CleanPost();	
		unset($_SESSION["SR_CreditID"]);
		if(!empty($_POST['ReturnID'])){
			if($objSale->isReturnExists($_POST['ReturnID'],$_POST['OrderID'])){
				$errMsg = str_replace("[MODULE]","RMA Number", ALREADY_EXIST);
			}
		}

		if(empty($errMsg)){	
				if(!empty($_POST['ReturnOrderID'])){   			 
					$OrderID = $objrmasale->ReturnOrder($_POST); //RMA	
					$_SESSION['mess_return'] = RMA_ADDED;
			
				}else if(!empty($_POST['OrderID'])){  
					$OrderID = $_POST['OrderID'];			
					$objrmasale->UpdateRma($_POST);
					$_SESSION['mess_return'] = RMA_UPDATED;			
				} 


				if(!empty($OrderID)){ 			
					$objConfig->AddUpdateStandAloneShipment($OrderID, 'SalesRMA'); 
					unset($_SESSION["Shipping"]);
				}

				if($_POST['Status']=='Completed'){  
					$objrmasale->AddCreditSalesFromRMA($OrderID); //Credit Note and Sales Order

					/*****AutoPostToGl CreditMemo******/
					if($_SESSION["SR_CreditID"]>0){
						$PostedOrderID = $_SESSION["SR_CreditID"];
						$Approved = $objConfigure->getSettingVariable('SO_APPROVE'); 				
						include_once("../includes/AutoPostToGlArCreditMemo.php");
						unset($_SESSION["SR_CreditID"]);
					}
					/**********************************/


					/***************
					if($objConfigure->getSettingVariable('SO_SOURCE')==1){
						if(empty($arryCompany[0]['Department']) || substr_count($arryCompany[0]['Department'],2)==1){
							$objTransaction->CreateCashReceiptFromRMA($OrderID,0); 		 
						}
					}		
					/***************/

					$objConfig->CreateAPInvoiceForStandAloneFreight($OrderID, 'SalesRMA', ''); 
					
					
					//EDI Purchase RMA After complete sales RMA
					
					if($_POST['EDIRefNo']!=''){

                 if(!empty($OrderID)){
													$arrySale = $objrmasale->GetSale($OrderID,'','');
													
													if(!empty($arrySale[0]['EdiRefInvoiceID']) && $arrySale[0]['EdiRefInvoiceID']!=''){
													
																$_POST['ReceivedDate'] =$_POST['ReturnDate'];
																$_POST['ExpiryDate'] = $_POST['ReturnDate'];
																$_POST['PostedDate'] = $_POST['ReturnDate'];
																$_POST['Restocking'] = $_POST['ReSt'];
																$_POST['InvoiceComment'] =$_POST['ReturnComment'];
																
																
																if($arrySale[0]['EDICompName']!=''){
																			$DB = 'erp_'.$arrySale[0]['EDICompName'].'.';
																			$arryPurchase = $objPurchase->GetInvoice($_POST['EdiRefInvoiceID'],$DB);
																			$_POST['EdiRefInvoiceID'] = $arrySale[0]['InvoiceID'];
																			$_POST['ReturnOrderID'] = $arryPurchase[0]['OrderID'];
																			unset($_POST['ReturnID']);
																			#print_r($arryPurchase); exit;
																			$OrderRmaID = $objPurchase->ReturnOrderRma($_POST,$DB);
																			
																			if(!empty($OrderRmaID)){
																			
																			  $objPurchase->AddCreditPOFromRMA($OrderRmaID,$DB); //Credit Note and purchase Order
																			
																			}
																			
																			
													       }
													
													
													
													}
													
													
									}

										  

						}
					
					// End
					
					
					
					
					
					
					
					
					 
				}


				/*******Generate PDF************/			
				$PdfArray['ModuleDepName'] = "SalesRMA";
				$PdfArray['Module'] = "RMA";
				$PdfArray['ModuleID'] = "ReturnID";
				$PdfArray['TableName'] =  "s_order";
				$PdfArray['OrderColumn'] =  "OrderID";
				$PdfArray['OrderID'] =  $OrderID;		 	
				$objConfigure->GeneratePDF($PdfArray);
				/*******************************/ 

				 
				header("Location:".$RedirectURL);
				exit;
		}
        }
	/***************************/
		
	if(!empty($_GET['Inv'])){	
		$arrySale = $objrmasale->GetInvoice($_GET['Inv'],'','');
		$OrderID   = $arrySale[0]['OrderID'];
		$InvoiceID = $arrySale[0]['InvoiceID'];
		$InvoiceOrderID = $OrderID;
		if($OrderID>0){
			$arrySaleItem = $objrmasale->GetSaleItem($OrderID);
			$NumLine = sizeof($arrySaleItem);
			$SaleID = $arrySale[0]['SaleID'];			
			$TotalGenerateReturn = $objrmasale->GetQtyReturned($OrderID);			
		}else{
			$ErrorMSG = NOT_EXIST_INVOICE;
		}
		$ModuleName = "Add ".$Module;
		$ButtonTitle = 'Process';
 		$arrySale[0]['Status']='Parked';
		$arrySale[0]['ReturnDate']='';
		$arrySale[0]['ExpiryDate']='';
		$arrySale[0]['Freight'] = '0.00';
	}else if(!empty($_GET['edit'])){ 
		$arrySale = $objrmasale->GetRma($_GET['edit'],'','');
		$OrderID   = $arrySale[0]['OrderID'];	
		$SaleID = $arrySale[0]['SaleID'];
		$InvoiceID = $arrySale[0]['InvoiceID'];
		$arryInvoiceData = $objrmasale->GetInvoice('',$InvoiceID,'Invoice');
		$InvoiceOrderID = $arryInvoiceData[0]['OrderID'];
		if($OrderID>0){
			$arrySaleItem = $objrmasale->GetSaleItem($OrderID);
			$NumLine = sizeof($arrySaleItem);
			$TotalGenerateReturn = $objrmasale->GetQtyReturned($OrderID);	
		}else{
			$ErrorMSG = NOT_EXIST_RETURN;
		}
		$ModuleName = "Edit ".$Module;

		if($arrySale[0]['Status'] != "Parked"){$HideSubmit = 1;}
		$ButtonTitle = 'Update';

		
		
	}else{
		$ErrorMSG = SELECT_INV_FIRST;
		$ModuleName = "Add ".$Module;
	}
	//if($_GET['pk']){echo '<pre>';print_r($arrySaleItem);exit; }			

	#if(empty($NumLine)) $NumLine = 1;	
	$arrySaleTax = $objTax->GetTaxRate('1');

   	$ConditionDrop  =$objCondition-> GetConditionDropValue('');
$WarehouseDrop  =$objCondition-> GetWarehouseDropValue('');
	$RsValhidden = $objConfigure->getSettingVariable('RES_FEE_S');
	$ListRmaValues=$objrmasale->listRmaAction();
	$ListRmaReasonVal=$objrmasale->listRmaReason();
	$TaxableBilling = $objConfigure->getSettingVariable('TaxableBilling');

	require_once("../includes/footer.php"); 	 
?>


