<?php 
	if($_GET['pop']==1)$HideNavigation = 1;


	/**************************************************/
	$ThisPageName = 'viewInvoice.php'; $EditPage = 1;$SetFullPage = 1;
	/**************************************************/

	include_once("../includes/header.php");
	require_once($Prefix."classes/sales.quote.order.class.php");
	require_once($Prefix."classes/inv_tax.class.php");
	require_once($Prefix."classes/sales.class.php");
	require_once($Prefix."classes/item.class.php");
        require_once($Prefix."classes/inv.condition.class.php");

	$objSale = new sale();
	$objTax = new tax();
	$objItem = new items();
	$objCondition = new condition();
	$objCommon = new common();

	$module = 'Invoice';
	$ModuleName = "Edit Invoice";
	$RedirectURL = "vbatchmgmt.php?view=".$_GET['batch']."&curP=".$_GET['curP'];
	$EditUrl = "editshipInvoice.php?InvoiceID=".$_GET["InvoiceID"]."&edit=".$_GET["edit"]."&curP=".$_GET["curP"]; 

	$ModuleIDTitle = "Invoice Number";   $NotExist = NOT_EXIST_INVOICE;
	
	$_GET['del_id'] = (int)$_GET['del_id'];
	$_GET['edit'] = (int)$_GET['edit'];


 	if($_GET['del_id'] && !empty($_GET['del_id'])){
		$_SESSION['mess_Invoice'] = $module.REMOVED;
		$objSale->RemoveInvoice($_GET['del_id']);
		header("Location:".$RedirectURL);
		exit;
	}



	if($_POST) {    
		CleanPost();

		 if(!empty($_POST['OrderID'])) {			
			$objSale->UpdateSHIPInvoice($_POST);


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


			$_SESSION['mess_Invoice'] = INVOICE_UPDATED;
			header("Location:".$RedirectURL);
			exit;
		 } 
	}	


	if(!empty($_GET['edit']) || $_GET['InvoiceID']!='' ){
		$arrySale = $objSale->GetInvoice($_GET['edit'],'',$module);

		$OrderID   = $arrySale[0]['OrderID'];	
if(empty($_GET['edit'])){
$_GET['edit'] = $OrderID;
}
		$SaleID   = $arrySale[0]['SaleID'];
		$InvoiceComment = stripslashes($arrySale[0]['InvoiceComment']);
		if($OrderID>0){
			$arrySaleItem = $objSale->GetSaleItem($OrderID);
			$NumLine = sizeof($arrySaleItem);	

			/***********************/
			if(!empty($arrySale[0]['TrackingNo'])){
				$arryShippInfo = $objCommon->GetShippInfoByTrackingId($arrySale[0]['TrackingNo']);
				$ShipType = $arryShippInfo[0]['ShipType'];
				$ShipTrackingID = $arryShippInfo[0]['trackingId'];
				$ShipFreight = $arryShippInfo[0]['totalFreight'];				 
			}			
			/***********************/

			$SalesPersonID   = $arrySale[0]['SalesPersonID'];
			$Commition = $objSale->GetUserCommision($SalesPersonID);

			
		}else{
			$ErrorMSG = $NotExist;
		}
		//$ErrorMSG = UNDER_CONSTRUCTION;
	}

	


		
	if(empty($NumLine)) $NumLine = 1;	


	$arrySaleTax = $objTax->GetTaxRate('1');
//$arrySaleTax = $objTax->GetTaxByLocation('1',$arryCurrentLocation[0]['country_id'],$arryCurrentLocation[0]['state_id']);

	//$arrySaleTax = $objTax->GetTaxRate('1');
	$arryPaymentTerm = $objConfigure->GetTerm('','1');
	$arryPaymentMethod = $objConfigure->GetAttribFinance('PaymentMethod','');
	$arryShippingMethod = $objConfigure->GetAttribValue('ShippingMethod','attribute_value');
	$arryOrderStatus = $objCommon->GetFixedAttribute('OrderStatus','');		
	$arryOrderType = $objCommon->GetFixedAttribute('OrderType','');		
$arryOrderSource = $objCommon->GetFixedAttribute('OrderSource','');	
        $ConditionDrop  =$objCondition-> GetConditionDropValue('');
	
	$_SESSION['DateFormat']= $Config['DateFormat'];

	
	require_once("../includes/footer.php"); 	 
?>
