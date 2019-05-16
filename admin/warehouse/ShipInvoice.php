<?php 
	if(!empty($_GET['pop']))$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'viewSale.php'; $EditPage = 1;
	/**************************************************/

	include_once("../includes/header.php");
	require_once($Prefix."classes/sales.quote.order.class.php");
	require_once($Prefix."classes/inv_tax.class.php");
	require_once($Prefix."classes/sales.class.php");
	require_once($Prefix."classes/warehouse.class.php");
        //require_once($Prefix."classes/warehousing.class.php");
		

	
		
	
        //$objCommon = new common();
	$objSale = new sale();
	$objTax = new tax();
	$objWarehouse = new warehouse();
	(!$_GET['module'])?($_GET['module']='Order'):(""); 
	$module = $_GET['module'];
	$ModuleName = "Sale Order ";
	
	$RedirectURL = "viewSale.php?key=".$_GET['so']."&curP=".$_GET['curP'];
	//$EditUrl = "editInvoice.php?edit=".$_GET["invoice"]."&module=".$module."&curP=".$_GET["curP"]; 
	$ModuleIDTitle = "Invoice Number"; $ModuleID = "InvoiceID"; $PrefixPO = "IN";  $NotExist = NOT_EXIST_ORDER;

	if(!empty($_GET['shipid']) || !empty($_GET['so'])){
		$arrySale = $objSale->GetInvoice('',$_GET['shipid'],'');
		$OrderID = $arrySale[0]['OrderID'];
		if($OrderID>0){
			$arrySaleItem = $objSale->GetSaleItem($OrderID);
			$NumLine = sizeof($arrySaleItem);
		}else{
			$ErrorMSG = $NotExist;
		}
	}else{
		header("Location:".$RedirectURL);
		exit;
	}
				

		if(!empty($_POST['ShipInVoice'])) {

		
				$ship_id = $objWarehouse->GenerateShipping($_POST);
				
				$_SESSION['mess_Invoice'] = SHIPPING_GENERATED_MESSAGE;
				$objWarehouse->AddShippingItem($ship_id, $_POST); 
				$RedirectURL = "viewShipOrder.php";
				header("Location:".$RedirectURL);
				exit;
			 } 
				
				
	if(empty($NumLine)) $NumLine = 1;	
	$arryBin = $objWarehouse->GetWarehouseBin($arrySale[0]['wCode']);
	$arrySaleTax = $objTax->GetTaxRate('2');
	$_SESSION['DateFormat']= $Config['DateFormat'];

        //$arryPaid = $objCommon->GetAttribValue('Paid','');
	//$arryTrasport = $objCommon->GetAttribValue('Transport','');
	//$arryCharge = $objCommon->GetAttribValue('Charge','');

	require_once("../includes/footer.php"); 	 
?>


