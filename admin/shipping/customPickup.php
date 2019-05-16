<?php
$HideNavigation = 1;
/**************************************************/
/**************************************************/
include_once("../includes/header.php");
require_once($Prefix."classes/warehouse.shipment.class.php");
require_once($Prefix."classes/warehouse.class.php");
require_once($Prefix."classes/sales.customer.class.php");
require_once($Prefix."classes/supplier.class.php");
require_once($Prefix."classes/function.class.php");
$objFunction=new functions();
$objShipment = new shipment();
$objWarehouse=new warehouse();
$objCustomer=new Customer();
$objSupplier = new supplier();
 
$strPath='';

$AutoFreightBilling = $objConfigure->getSettingVariable('AutoFreightBilling');

$_GET['Status'] = '1';
$arryVendor = $objSupplier->GetSupplierList($_GET);
 

?>

<script language="JavaScript1.2" type="text/javascript">
var AutoFreightBilling = '<?=$AutoFreightBilling?>';

function SetShippingRate(TotalFrieght,InsureAmount,InsureValue){
	
	//parent.$("#ShippingRateTr").show();
	parent.$("#ShippingRateVal").val(TotalFrieght);
	parent.$("#InsureAmount").val(InsureAmount);
	parent.$("#InsureValue").val(InsureValue);

	parent.$("#ActualFreightDiv").show();
	parent.$("#ActualFreight").val(TotalFrieght);

	if(AutoFreightBilling=='1'){
		if(window.parent.document.getElementById("Freight") != null){
			window.parent.document.getElementById("Freight").value=TotalFrieght;
			parent.calculateGrandTotal(); 
		}
	}

	parent.jQuery.fancybox.close();	 
}
</script>

<? 


if(!empty($_POST['Action'])){
	CleanPost();
	
	#pr($_POST,1);
	
	    $InsureAmount=0;
	    $InsureValue=0;
	    $freightVal = $_POST['Freight'];
	    $freightCurrency = $_POST['Currency'];
		$trackingString = implode(',', $_POST['TrackingNo']);
		
		$_SESSION['Shipping']['ShipType'] = ucfirst('Customer Pickup');
		$_SESSION['Shipping']['totalFreight'] = ($freightVal>0) ? $freightVal: 0;
		$_SESSION['Shipping']['freightCurrency'] = $freightCurrency;
 
		if(!empty($_POST['InPersonPickup'])){
			$_SESSION['Shipping']['tracking_id'] = (!empty($trackingString)) ? $trackingString : '';				
			$_SESSION['Shipping']['CustomerPickupCarrier'] = $_POST['CustomerPickupCarrier'];
		}else{
			$_SESSION['Shipping']['tracking_id']='..';
			$_SESSION['Shipping']['CustomerPickupCarrier']='None';
		}
		
		echo "<script>SetShippingRate('".$freightVal."','".$InsureAmount."','".$InsureValue."');</script>";
		exit;

	}
 
 

require_once("../includes/footer.php");
?>

