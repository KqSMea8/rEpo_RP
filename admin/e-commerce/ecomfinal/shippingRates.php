<?php
/**************************************************/
$ThisPageName = 'viewShipping.php'; $EditPage = 1;
/**************************************************/
include_once("includes/header.php");

require_once("classes/cartsettings.class.php");

(!$_GET['curP'])?($_GET['curP']=1):(""); // current page number
if (class_exists(cartsettings)) {
	$objcartsettings=new Cartsettings();
} else {
	echo "Class Not Found Error !! Cart Settings Class Not Found !";
	exit;
}

$Ssid = isset($_REQUEST['Ssid'])?$_REQUEST['Ssid']:"";
$MethodId = isset($_REQUEST['MethodId'])?$_REQUEST['MethodId']:"";
$Srid = isset($_REQUEST['Srid'])?$_REQUEST['Srid']:"";
if ($Srid && !empty($Srid)) {$shipHeading  = "Edit Shipping Rate";}  else {$shipHeading  = "Add New Shipping Rate";}
$ModuleName = 'Shipping Rates';
$ListTitle  = 'Shipping';
$ListUrl = "shippingRates.php?curP=".$_GET['curP']."&Ssid=".$Ssid."&MethodId=".$MethodId;
$ParentID = 0;
$BlankMessage  = $MSG[11];
$InsertMessage = $MSG[12];
$UpdateMessage = $MSG[13];
$DeleteMessage = $MSG[14];
 

if ($Ssid && !empty($Ssid))
{
	$ShippingRatesArr = $objcartsettings->getShippingRatesById($Ssid);
}

if ($Srid && !empty($Srid))
{
	$ShippingRateArr = $objcartsettings->getShippingRateById($Srid);
}
 

if(!empty($_GET['active_id'])){
	$_SESSION['mess_ship'] = $ModuleName.$MSG[104];
	$objcartsettings->changeManufacturerStatus($_REQUEST['active_id']);
	header("location:".$ListUrl);
}




if(!empty($_GET['del_id'])){

	 
	$_SESSION['mess_ship'] = $ModuleName.$MSG[103];
	$objcartsettings->deleteManufacturer($_GET['del_id']);
	header("location:".$ListUrl);
	exit;
}



if (is_object($objcartsettings)) {
		
	if ($_POST) {

		if (!empty($Srid)) {

			$_SESSION['mess_ship'] = $ModuleName.$MSG[102];
			$objcartsettings->updateShippingRate($_POST);
			 
		} else {
			$_SESSION['mess_ship'] = $ModuleName.$MSG[101];
			$lastShipId = $objcartsettings->addShippingRate($_POST);

			 
		}


		header("location:".$ListUrl);
		exit;
			
	}





	if($arryManufacturer[0]['Status'] != ''){
		$ManufacturerStatus = $arryManufacturer[0]['Status'];
	}else{
		$ManufacturerStatus = 1;
	}
}



require_once("includes/footer.php");


?>
