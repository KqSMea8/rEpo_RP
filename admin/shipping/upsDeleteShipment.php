<?php
$HideNavigation = 1;
/**************************************************/
if($_GET['batch']>0){
	$ThisPageName = "viewbatchmgmt.php";	
}else{
	$ThisPageName = "viewShipment.php";	
}
/**************************************************/
include_once("../includes/header.php");
    

require_once($Prefix."classes/warehouse.shipment.class.php");
require_once($Prefix."classes/warehouse.class.php");

$objShipment = new shipment();
$objWarehouse=new warehouse();

$arryApiACDetails=$objShipment->ListShipmentAPIDetailByName('UPS');

$Config['ups_account_number']= $arryApiACDetails[0]['api_account_number'];
$Config['ups_key']= $arryApiACDetails[0]['api_key'];
$Config['ups_password']= $arryApiACDetails[0]['api_password'];
$Config['tracking_number'] = $_GET['trackingId'];
$RedirectURL='vShipment.php?view='.$_GET['view'].'&ship='.$_GET['ship'].'&batch='.$_GET['batch'];


	require('classes/class.ups.php');
	require('classes/class.upsVoid.php');

   $ShipmentIdentificationNumber = $_GET['trackingId'];
	//Initiate the main UPS class
	$upsConnect = new ups($Config['ups_account_number'],$Config['ups_key'],$Config['ups_password']);
	$upsConnect->setTemplatePath('xml/');
	$upsConnect->setTestingMode(0); // Change this to 0 for production
	$upsVoid = new upsVoid($upsConnect);

	$upsVoid->buildRequestXML($ShipmentIdentificationNumber);

	$RemMsg = $upsVoid->responseXML;	
	
	$arr=xml2array($RemMsg);

    if ($arr['VoidShipmentResponse']['Response']['ResponseStatusDescription']['value']!='Failure'){

    	$RemMsg = "<div class='greenmsg' align='center'>Success</div>"; 
	$arryApiACDetails=$objShipment->DeleteFedexShip($Config['tracking_number']);
    	
    }else{

        $RemMsg = "<div class='redmsg' align='center'>".$arr['VoidShipmentResponse']['Response']['Error']['ErrorDescription']['value']."</div>"; 
    	
    } 
    
  
	if($arr['VoidShipmentResponse']['Response']['ResponseStatusDescription'] !='Failure'){
		
		$_SESSION['mess_shiment_delete'] = $RemMsg;
		header("Location:".$RedirectURL);
		exit;
    	}

    
require_once("../includes/footer.php");
?>

