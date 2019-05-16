<?php
$HideNavigation = 1;
(empty($_GET['action']))?($_GET['action']=""):("");
/**************************************************/
$ThisPageName = 'editReturn.php';
/**************************************************/
#(!isset($_GET['action']))?($_GET['action']=""):("");

if(!empty($_GET['action']) && $_GET['action']=="TrackStatus"){
	include_once("../includes/settings.php");
}else{
	include_once("../includes/header.php");
}

require_once($Prefix."classes/warehouse.shipment.class.php");
require_once($Prefix."classes/warehouse.class.php");

$objShipment = new shipment();
$objWarehouse=new warehouse();

(empty($_GET['acc']))?($_GET['acc']=""):("");


$ShipAccountNumber = $_GET['acc'];


#$arryApiACDetails=$objShipment->ListShipmentAPIDetailByName('UPS');
$arryApiACDetails=$objShipment->ShipAccountByDeault('UPS');

if(!empty($ShipAccountNumber)){
	$ShipAccountDetail=$objShipment->ShipAccountByACNumber($ShipAccountNumber,'UPS');
	$Config['ups_account_number']= $ShipAccountDetail[0]['api_account_number'];
	$Config['ups_key']= $ShipAccountDetail[0]['api_key'];
	$Config['ups_password']= $ShipAccountDetail[0]['api_password'];
}else{
	$Config['ups_account_number']= $arryApiACDetails[0]['api_account_number'];
	$Config['ups_key']= $arryApiACDetails[0]['api_key'];
	$Config['ups_password']= $arryApiACDetails[0]['api_password'];
}





if(empty($Config['ups_account_number']) || empty($Config['ups_key']) || empty($Config['ups_password'])){
	$ermsg = SHIPPING_ACCOUNT_NOT_SETUP;
}else{

	require('classes/class.ups.php');
	require('classes/class.upsTrack.php');

	$accessNumber=$username=$password='';

	// Get credentials from a form
	/*$accessNumber = '2CF8EA8CA48FB215';;
	$username ='mkbtechnology';
	$password = 'mkbTech2014#';*/

	$trackingNumber = $_GET['view'];
		
	$ups_connect = new ups($accessNumber,$username,$password);
	$ups_connect->setTemplatePath('xml/');
	$ups_connect->setTestingMode(0); //Change this to 0 for production

	$upsTrack = new upsTrack($ups_connect);

	$tracking_data = $upsTrack->track($trackingNumber);

	$response = $upsTrack->returnResponseArray();

	$ermsg = $response['TrackResponse']['Response']['Error']['ErrorDescription']['VALUE'];
}



if(!empty($_GET['pk'])){
	echo "<pre>";print_r($response);exit;
}
	/*******************************/
	if($_GET['action']=="TrackStatus"){
		$StatusCode = $response['TrackResponse']['Shipment']['Package']['Activity']['Status']['StatusType']['Code']['VALUE']; 	 
		if(!empty($StatusCode)){			  
			$Status = $response['TrackResponse']['Shipment']['Package']['Activity']['Status']['StatusType']['Description']['VALUE'];
			
			$ImgCode=$objShipment->GetShippingStatusImg($StatusCode,'UPS');	
			$EstimatedDelivery = $response['TrackResponse']['Shipment']['ScheduledDeliveryDate']['VALUE'];
			if(!empty($EstimatedDelivery)){
				$EstimatedDelivery = substr($EstimatedDelivery,0,4).'-'.substr($EstimatedDelivery,4,2).'-'.substr($EstimatedDelivery,6,2);
				$EstimatedDelivery = date($Config['DateFormat'], strtotime($EstimatedDelivery));
			}	 
		}else{
			if(empty($ermsg)) $ermsg = 'Invalid tracking number !!';
			$Status = $ermsg;
		}
		echo $Status.'#'.$ImgCode.'#'.$StatusCode.'#'.$EstimatedDelivery;;
		exit;
	}
	/*******************************/

    
require_once("../includes/footer.php");
?>

