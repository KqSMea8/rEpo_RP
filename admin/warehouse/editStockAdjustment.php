<?php 
	/**************************************************/
	$ThisPageName = "viewStockTransfer.php";	$EditPage = 1;
	/**************************************************/

	include_once("../includes/header.php");
	require_once($Prefix."classes/warehouse.recieve.order.class.php");
	require_once($Prefix."classes/sales.quote.order.class.php");
	require_once($Prefix."classes/inv_tax.class.php");
	require_once($Prefix."classes/warehousing.class.php");
	require_once($Prefix."classes/warehouse.class.php");
	require_once($Prefix."classes/item.class.php");
	$objCommon=new common();
	$objWrecieve = new wrecieve();
	$objItem = new items();
	$objWarehouse = new warehouse();
	$objSale = new sale();
	$objTax=new tax();

	$Module = "Stock Transfer";
	$ModuleIDTitle = "Recieve Number"; $ModuleID = "RecieveID"; $PrefixSale = "RTN";  $NotExist = NOT_EXIST_ORDER;
	$RedirectURL = "viewStockTransfer.php?curP=".$_GET['curP'];

	if($_GET['del_id'] && !empty($_GET['del_id'])){
		$_SESSION['mess_return'] = RETURN_REMOVED;
		$objWrecieve->RemoveTransferRecieve($_GET['del_id']);
		header("Location:".$RedirectURL);
		exit;
	}
	 
	 
	
	if(!empty($_POST['RecieveOrderID'])){   
		$OrderID = $objWrecieve->RecieveTransferOrder($_POST);
		$_SESSION['mess_return'] = RETURN_ADDED;
		header("Location:".$RedirectURL);
		exit;
	}else if(!empty($_POST['rtnID']) && ($_POST['Submit'] == "Save")){  
		$objWrecieve->UpdateTransferRecieve($_POST);
		$_SESSION['mess_return'] = RETURN_UPDATED;
		header("Location:".$RedirectURL);
		exit;
	}
		
	if(!empty($_GET['tn'])){
       $arryTransfer = $objItem->ListingTransfer($_GET['tn'],'','','','');
	   $CheckID =$objWrecieve->isInvoice($_GET['tn']);
	   if($CheckID>0){
		$arrySale = $objWrecieve->GetWInvoice($CheckID,$_GET['tn'],'');
		$OrderID   = $arrySale[0]['OrderID'];
		if($OrderID>0){
			$arrySaleItem = $objWrecieve->GetSaleItem($OrderID);
			
			$NumLine = sizeof($arrySaleItem);
			$SaleID = $arrySale[0]['SaleID'];
			#$arryInvoiceOrder = $objWrecieve->GetInvoiceOrder($SaleID);
			$TotalGenerateRecieve = $objWrecieve->GetQtyRecieved($OrderID);
			if($TotalGenerateRecieve[0]['QtyInvoiced'] == $TotalGenerateRecieve[0]['QtyRecieved']){
		      $HideSubmit = 1;
			  $RtnInvoiceMess = SO_ITEM_TO_NO_RETURN;
			}
			
		 }else{
			$ErrorMSG = NOT_EXIST_ORDER;
		}
	   }else{

          $arrySale = $objSale->GetInvoice($_GET['edit'],$_GET['InvoiceID'],'Invoice');
		  $OrderID   = $arrySale[0]['OrderID'];
		  if($OrderID>0){
			$arrySaleItem = $objSale->GetSaleItem($OrderID);
			$NumLine = sizeof($arrySaleItem);

			$SaleID = $arrySale[0]['SaleID'];
			#$arryInvoiceOrder = $objSale->GetInvoiceOrder($SaleID);
			$TotalGenerateReturn = $objSale->GetQtyReturned($OrderID);
			/*if($TotalGenerateReturn[0]['QtyInvoiced'] == $TotalGenerateReturn[0]['QtyReturned']){

		      $HideSubmit = 1;
			  $RtnInvoiceMess = SO_ITEM_TO_NO_RETURN;
			}*/
			
		}else{
			$ErrorMSG = NOT_EXIST_ORDER;
		}

	  }

		$ModuleName = "Recieve ".$Module;

	}else if(!empty($_GET['edit']) && !empty($_GET['rtn'])){
		$arrySale = $objWrecieve->GetRecieve($_GET['edit'],$_GET['rtn'],'');
		$OrderID   = $arrySale[0]['OrderID'];	
		$SaleID = $arrySale[0]['SaleID'];
		$arryInbound = $objWrecieve->GetSoDetails('',$OrderID);

		if($OrderID>0){
			$arrySaleItem = $objWrecieve->GetSaleItem($OrderID);
			$NumLine = sizeof($arrySaleItem);
			
			$TotalGenerateRecieve = $objWrecieve->GetQtyRecieved($OrderID);
			//if($TotalGenerateRecieve[0]['QtyInvoiced'] == $TotalGenerateRecieve[0]['QtyRecieved']){
			//if($TotalGenerateRecieve[0]['QtyInvoiced'] == $TotalGenerateRecieve[0]['QtyRecieved']){
		      $HideSubmit = 1;
			  //$RtnInvoiceMess = SO_ITEM_TO_NO_RETURN;
			//}
			
		}else{
			$ErrorMSG = NOT_EXIST_RETURN;
		}
		$ModuleName = "Edit ".$Module;
		//$HideSubmit = 1;
	}else{
		$ErrorMSG = SELECT_SO_FIRST;
		$ModuleName = "Add ".$Module;
	}
	/******************************/
	$arryShipItem = $objWrecieve->GetSaleItem($OrderID);
	/******************************/	

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


