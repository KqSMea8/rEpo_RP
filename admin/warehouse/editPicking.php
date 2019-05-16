<?php 
	/**************************************************/
$ThisPageName = "viewPicking.php";
	$EditPage = 1; $SetFullPage = 1;
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

		$Module = "Order";
		$ModuleIDTitle = "Picking Number"; $ModuleID = "ShippedID"; $PrefixSale = "SHIP";  $NotExist = NOT_EXIST_ORDER;
		$RedirectURL = $ThisPageName."?curP=".$_GET['curP']."&batch=".$_GET['batch'];
		$ModDepName='WhouseBatchMgt';//by sachin
		 $DownloadUrl ="../pdfCommonhtml.php?SHIP=".$_GET["edit"] ."&ModuleDepName=". $ModDepName ."&curP=". $_GET['curP']."";

		 

		if($_GET['del_id'] && !empty($_GET['del_id'])){
			$_SESSION['mess_Sale'] = PICK_REMOVED;
			$objShipment->RemovePicking($_GET['del_id']);
			//$objShipment->RemoveShipmentInvoice($_GET);
			  header("Location:".$RedirectURL);			
			exit;
		}
	 
 
 if($_POST){
	
	


	if(empty($errMsg)) {


		
		if(!empty($_POST['OrderID'])){
		  $objShipment->UpdatePicking($_POST);
			$_SESSION['mess_ship'] = SHIP_UPDATED.$OtherMsg;
	   		$OrderID = $_POST['OrderID'];	
		}else {  
	    //$OrderID = $objShipment->AddPickOrder($_POST);
			$_POST['OrderID'] = $OrderID ;
			$_SESSION['mess_ship'] = SHIP_ADDED.$OtherMsg;		
			/*******************************************/		
		}      

		
		$objShipment->PickOrderQtyUpdate($_POST);
		

		


		header("Location:".$RedirectURL);
		exit;


		}

        
        
        
        }
		
	
$Config['droppick'] =1;

 if(!empty($_GET['edit'])){

$NextModuleID = "PICK".$_GET['edit'];
		$arrySale = $objShipment->GetShipment($_GET['edit'],'',$Module);

              if($arrySale[0]['PickID']==$NextModuleID && ($_GET['so']!='' || $_GET['SaleID']!='') ) {
									$_SESSION['mess_Sale'] = $_GET['so']." ".ALREADY_PICK;
		              header('location:../sales/viewSalesQuoteOrder.php?module=Order&curP='. $_GET['curP']);
		              exit;
               } 
		/*****code for get document by sachin******/
		$OrderIDForOrderDocumentArry=$objSale->GetOrderIDForOrderDocument($arrySale[0]['SaleID'],'Order');
		$_GET['OrderID']=$OrderIDForOrderDocumentArry[0]['OrderID'];
		$_GET['Module']='SalesOrder';
		$_GET['ModuleName']='Sales';
		$getDocumentArry=$objConfig->GetOrderDocument($_GET);
		/*****code for get document by sachin******/

		$OrderID   = $arrySale[0]['OrderID'];	
		$SaleID = $arrySale[0]['SaleID'];

		/*****************/
		if($Config['vAllRecord']!=1){	
			if($arrySale[0]['SalesPersonID'] != $_SESSION['AdminID'] && $arrySale[0]['AdminID'] != $_SESSION['AdminID']){
			header('location:'.$RedirectURL);
			exit;
			}
		}
		/*****************/
	

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
		//$ErrorMSG = SELECT_SO_FIRST;
		$ModuleName = "Add ".$Module;
	}
				

	
	if(empty($NumLine)) $NumLine = 1;	
	$arrySaleTax = $objTax->GetTaxRate('1');
	
	//$NextModuleID = $objConfigure->GetNextModuleID('s_order','Shipment'); //Not Created Yet
	$NextInvModuleID = $objConfigure->GetNextModuleID('s_order','Picking');
	
	 unset($_SESSION["Shipping"]);

	if(empty($arryShip[0]['WarehouseCode']) && empty($arryShip[0]['WarehouseName']) && empty($arryShip[0]['WID']) ){
		$defultware = $objWarehouse->GetDefaultWarehouseBrief(1);

		$arryShip[0]['WarehouseCode'] = $defultware[0]['warehouse_code'];
		$arryShip[0]['WarehouseName'] = $defultware[0]['warehouse_name'];
		$arryShip[0]['WID']   =         $defultware[0]['WID'];

	}

	if(empty($arryShip[0]['PickStatus'])) $arryShip[0]['PickStatus']='';

	$TaxableBilling = $objConfigure->getSettingVariable('TaxableBilling');

	require_once("../includes/footer.php"); 	 



?>
