<?php   if(!empty($_GET['pop']))$HideNavigation = 1;
	/**************************************************/
	if(!empty($_GET['batch'])){
		$ThisPageName = "viewbatchmgmt.php";	
	}else{
		$ThisPageName = "viewShipment.php";	
	}

	$EditPage = 1; $SetFullPage = 1;
	/**************************************************/

include_once("../includes/header.php");
require_once($Prefix."classes/sales.quote.order.class.php");
require_once($Prefix."classes/inv_tax.class.php");
require_once($Prefix."classes/warehouse.shipment.class.php");
require_once($Prefix . "classes/finance.account.class.php");

$objBankAccount = new BankAccount();
$objSale = new sale();
$objShipment = new shipment();
$objTax=new tax();

	$Module = "Shipment";
	$ModuleDepName='WhouseBatchMgt';//by sachin
	$ModuleIDTitle = "Shipment Number"; $ModuleID = "ShippedID"; $PrefixPO = "SHIP";  $NotExist = NOT_EXIST_ORDER;
	$RedirectURL = $ThisPageName."?curP=".$_GET['curP'];
	//$DownloadUrl = "pdfShipment.php?SHIP=".$_GET["view"]."";
	 $DownloadUrl ="../pdfCommonhtml.php?SHIP=".$_GET["view"] ."&ModuleDepName=". $ModuleDepName ."&curP=". $_GET['curP']."";

	

   	if(!empty($_GET['view']) && !empty($_GET['ship'])){
		$arryShippInfo = $objShipment->listingShipmentDetail($_GET['view']);

		$arrySale = $objShipment->GetShipment($_GET['view'],$_GET['ship'],'Shipment');

                $arryShip = $objShipment->GetWarehouseShip('',$_GET['view']);

						if($arryShip[0]['RefID']!='' ){
						   $arryInvoice = $objSale->GetInvoice('', $arryShip[0]['RefID'], 'Invoice');

						}


			if(empty($arrySale[0]['InvoiceID'])){
			$arrySale[0]['InvoiceID'] = $arryShip[0]['RefID'];

			}
		$OrderID   = $arrySale[0]['OrderID'];	
		$SaleID = $arrySale[0]['SaleID'];
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
		

		/*****************/
		if($Config['vAllRecord']!=1 && $HideNavigation != 1){
			if($arrySale[0]['SalesPersonID'] != $_SESSION['AdminID'] && $arrySale[0]['AdminID'] != $_SESSION['AdminID']){
			header('location:'.$RedirectURL);
			exit;
			}
		}
		/*****************/

		/****start code for get tempalte name for dynamic pdf by sachin***/
		$_GET['ModuleName']=$ModuleDepName;
		$_GET['Module']=$ModuleDepName.$_GET['module'];
		$_GET['ModuleId']=$_GET['view'];
		$_GET['listview']='1';
		$GetPFdTempalteNameArray=$objConfig->GetSalesPdfTemplate($_GET);	
		/****end code for get tempalte name for dynamic pdf by sachin***/ 


		if($OrderID>0){
			$arrySaleItem = $objSale->GetSaleItem($OrderID);
			$NumLine = sizeof($arrySaleItem);
			 
			$TotalGenerateReturn = $objSale->GetQtyReturned($OrderID);
			if($TotalGenerateReturn[0]['QtyInvoiced'] == $TotalGenerateReturn[0]['QtyReturned']){
		      $HideSubmit = 1;
			  $RtnInvoiceMess = SO_ITEM_TO_NO_RETURN;
			}
			
		}else{
			$ErrorMSG = NOT_EXIST_DATA;
		}
		$ModuleName = "View ".$Module;
		$HideSubmit = 1;
	} 
				

	if(empty($NumLine)) $NumLine = 1;	
	$arrySaleTax = $objTax->GetTaxRate('1');
	$TaxableBilling = $objConfigure->getSettingVariable('TaxableBilling');

	require_once("../includes/footer.php"); 	 
?>


