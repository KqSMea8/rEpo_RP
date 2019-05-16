<?php
/**************************************************/
$ThisPageName = 'apiGlobalSetting.php';
/**************************************************/
include_once("../includes/header.php");
require_once($Prefix."classes/warehouse.shipment.class.php");
$objShipment = new shipment();

$RedirectURL = "apiGlobalSetting.php";

CleanPost();

if(!empty($_GET['edit']) && $_POST['id'] && empty($_POST['Check'])){

	$_SESSION['mess_shipment_profile'] = mess_warehouse_global_setting;
	$objShipment->UpdateShipmentAPIDetail($_POST,$_GET['id']);
	header("Location:".$RedirectURL);
	exit;
	
}
//echo "<pre>";print_r($_POST);die;
/****************Check*****************/
/**********************************/
if(!empty($_POST['Check'])) {

	if($_POST['ProviderID']==1){
          
		include_once 'fedex_crediantial_validate.php';
		
	}else if($_POST['ProviderID']==2){
		
		include_once 'ups_crediantial_validate.php';
	
	}else if($_POST['ProviderID']==3){
		
		include_once 'usps_crediantial_validate.php';

	}else if($_POST['ProviderID']==4){

		include_once 'dhl_crediantial_validate.php';
	}

	

	if($_SESSION['mess_ship']==1){
			
		 $_SESSION['mess_ship_msg'] = 'Authentication Validated Successfully';
	}else{
	 	$_SESSION['mess_ship_msg'] = 'Authentication Failed';
	} 
	
  	
 	$RedirectURL = "editApiGlobalSetting.php?edit=".$_POST['ProviderID'];
	header("Location:" . $RedirectURL);
	exit; 
}
/**********************************/
/**********************************/

		
$arryShipmentProfile = $objShipment->ListShipmentAPIDetailById($_GET['edit']);

require_once("../includes/footer.php");


?>
