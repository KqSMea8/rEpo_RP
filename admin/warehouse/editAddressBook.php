<?php
/**************************************************/
$ThisPageName = 'addressBook.php';
/**************************************************/
include_once("../includes/header.php");
require_once($Prefix."classes/warehouse.shipment.class.php");
$objShipment = new shipment();

$RedirectURL = "addressBook.php";




	if($_GET['del_id'] && !empty($_GET['del_id'])){
		
		$_SESSION['mess_addbook_profile'] = SHIPMENT_ADDBOOK_REMOVE;
		$objShipment->RemoveAddressBook($_GET['del_id']);
		header("Location:".$RedirectURL);
		exit;
		
	}
 

	if(!empty($_GET['edit']) && !empty($_POST['adbID'])){
		CleanPost();
		$_SESSION['mess_addbook_profile'] = SHIPMENT_ADDBOOK_UPDATE;
		$objShipment->UpdateAddBook($_POST,$_POST['adbID']);
		$RedirectURL1 = "addressBook.php?type=".$_GET['type'];
		header("Location:".$RedirectURL1);
		exit;
		
	}

if(!empty($_GET['edit'])){
   $arryaddBook = $objShipment->GetAddBookByID($_GET['edit']);
}else{
  $arryaddBook = $objConfigure->GetDefaultArrayValue('w_addressbook');
}
   
if(!empty($_GET['type'])){$Type= $_GET['type'];}else{ $Type= 'ShippingTo';}

require_once("../includes/footer.php");


?>
