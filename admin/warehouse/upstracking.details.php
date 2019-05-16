<?php
$HideNavigation = 1;
/**************************************************/
$ThisPageName = 'editReturn.php';
/**************************************************/
if($_GET['action']=="TrackStatus"){
	include_once("../includes/settings.php");
}else{
	include_once("../includes/header.php");
}

require_once($Prefix."classes/warehouse.shipment.class.php");
require_once($Prefix."classes/warehouse.class.php");

$objShipment = new shipment();
$objWarehouse=new warehouse();

$arryApiACDetails=$objShipment->ListShipmentAPIDetailByName('UPS');

$Config['ups_account_number']= $arryApiACDetails[0]['api_account_number'];
$Config['ups_key']= $arryApiACDetails[0]['api_key'];
$Config['ups_password']= $arryApiACDetails[0]['api_password'];

require('classes/class.ups.php');
require('classes/class.upsTrack.php');


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


	/*******************************/
	if($_GET['action']=="TrackStatus"){
		$StatusCode = $response['TrackResponse']['Shipment']['Package']['Activity']['Status']['StatusType']['Code']['VALUE']; 	 
		if(!empty($StatusCode)){			  
			$Status = $response['TrackResponse']['Shipment']['Package']['Activity']['Status']['StatusType']['Description']['VALUE'];
			
			$ImgCode=$objShipment->GetShippingStatusImg($StatusCode,'UPS');		 
		}else{
			if(empty($ermsg)) $ermsg = 'Invalid tracking number !!';
			$Status = $ermsg;
		}
		echo $Status.'#'.$ImgCode.'#'.$StatusCode;
		exit;
	}
	/*******************************/

    
require_once("../includes/footer.php");
?>

