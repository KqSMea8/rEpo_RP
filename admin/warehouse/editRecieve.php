<?php 
	/**************************************************/
	$ThisPageName = "viewRecieve.php";	$EditPage = 1;
	/**************************************************/

	include_once("../includes/header.php");
	require_once($Prefix."classes/warehouse.recieve.order.class.php");
	
	require_once($Prefix."classes/sales.quote.order.class.php");
	require_once($Prefix."classes/inv_tax.class.php");
	
	require_once($Prefix."classes/warehousing.class.php");

	require_once($Prefix."classes/warehouse.class.php");
	
	$objCommon=new common();
	$objWrecieve = new wrecieve();
	$objWarehouse = new warehouse();
	$objSale = new sale();
	$objTax=new tax();


	$Module = "Return";
	$ModuleIDTitle = "Return Number"; $ModuleID = "RecieveID"; $PrefixSale = "RTN";  $NotExist = NOT_EXIST_ORDER;
	$RedirectURL = "viewRecieve.php?curP=".$_GET['curP'];

	if($_GET['del_id'] && !empty($_GET['del_id'])){
		$_SESSION['mess_return'] = RETURN_REMOVED;
		$objWrecieve->RemoveRecieve($_GET['del_id']);
		header("Location:".$RedirectURL);
		exit;
	}
	 
	/* if($_POST){
			echo "<pre>";
			print_r($_POST);
			exit;
	 }
	*/
	if(!empty($_POST['ReturnOrderID'])){   
		 $objWrecieve->RecieveOrder($_POST);
		$_SESSION['mess_return'] = RETURN_ADDED;
		header("Location:".$RedirectURL);
		exit;
	}else if(!empty($_POST['RecieveOrderID'])){  
		$objWrecieve->UpdateRecieve($_POST);
		$_SESSION['mess_return'] = RETURN_UPDATED;
		header("Location:".$RedirectURL);
		exit;
	}
	if(!empty($_GET['InvoiceID'])){
	$arryCheckID = $objWrecieve->isReturnSo($_GET['InvoiceID']);


	//$arryIn = $objSale->GetInvoice('',$_GET['InvoiceID'],'');
	}
	/********************************************/
	if(!empty($arryCheckID)){

	   $arrySale = $objWrecieve->GetShipSale('',$arryCheckID,'');

           $ReturnID = $arrySale[0]['ReturnID'];
	   $OrderID = $arrySale[0]['OrderID'];	
           $so = $arrySale[0]['SaleID'];			 
		if($OrderID>0){
                   $ref = 1;
		   $RecieveSo = $OrderID;
		   $arrySaleItem = $objWrecieve->GetShipSaleItem($OrderID);	
		   $NumLine = sizeof($arrySaleItem);
		   $arrySale[0]['transaction_ref'] = $arrySaleItem[0]['SaleID'];
		   $SaleID = $arrySale[0]['SaleID'];
		   #$arryInvoiceOrder = $objInbound->GetInvoiceOrder($PurchaseID);
		}

	}else {
		$arrySale = $objSale->GetInvoice('',$_GET['InvoiceID'],'');
	
                 $OrderID   = $arrySale[0]['OrderID'];
                  $so = $arrySale[0]['SaleID'];
                //$arrySaleAdd = $objSale->GetInvoice($_GET['edit'],$_GET['InvoiceID'],'Invoice');
		       
			if($OrderID>0){
				$ReturnSo = $OrderID;
				$arrySaleItem = $objSale->GetSaleItem($OrderID);
				$NumLine = sizeof($arrySaleItem);

				$SaleID = $arrySale[0]['SaleID'];
				$TotalGenerateReturn = $objSale->GetQtyReturned($OrderID);
					#$arryInvoiceOrder = $objSale->GetInvoiceOrder($SaleID);
				
					/*if($TotalGenerateReturn[0]['QtyInvoiced'] == $TotalGenerateReturn[0]['QtyReturned']){

					  $HideSubmit = 1;
					  $RtnInvoiceMess = SO_ITEM_TO_NO_RETURN;
					}*/
							$NumLine = sizeof($arrySaleItem);
							$arryInbound[0]['transaction_ref'] = $arryPurchase[0]['PurchaseID'];
							$SaleID = $arrySale[0]['SaleID'];
							#$arryInvoiceOrder = $objInbound->GetInvoiceOrder($PurchaseID);
						}else{
							$ErrorMSG = NOT_EXIST_ORDER;
							}
				$ModuleName = "Add ".$Module;			
	}
		

		
                     if(!empty($_GET['edit'])){

		         $arrySale = $objWrecieve->GetShipSale($_GET['edit'],'','');

			 $OrderID = $arrySale[0]['OrderID'];
                         $ReturnID = $arrySale[0]['RecieveID'];
                         $so = $arrySale[0]['SaleID'];
			  $ref = 1;
			if($OrderID>0){
			  $RecieveSo = $OrderID;
			  $arrySaleItem = $objWrecieve->GetShipSaleItem($OrderID);
			  $NumLine = sizeof($arrySaleItem);
			  $arryInbound[0]['transaction_ref'] = $arrySaleItem[0]['SaleID'];
			 $SaleID = $arrySale[0]['SaleID'];
				
			}else{
				$ErrorMSG = NOT_EXIST_RETURN;
				}
	}
	
	/*******************************************/
	
	

   /*******************************************/
	if(empty($NumLine)) $NumLine = 1;	
	$arrySaleTax = $objTax->GetTaxRate('2');
    $arryWarehouse=$objWarehouse->ListWarehouse('',$_GET['key'],'','',1);
	$arryPaid = $objCommon->GetAttribValue('Paid','');
	$arryTrasport = $objCommon->GetAttribValue('Transport','');
	$arryCharge = $objCommon->GetAttribValue('Charge','');
	$arryPackageType = $objCommon->GetAttribValue('PackageType','');
  /********************************************/
	require_once("../includes/footer.php"); 	 
?>


