<?php 
require_once("includes/header.php");
 
include_once("includes/header_menu.php");


ValidateMemberSession($ThisPage);

 $address_id = isset($_GET['address_id'])?$_GET['address_id']:"";
 if(!empty($address_id)){
   $address = $objCustomer->getShippingAddressById($address_id);
 }
 
 if(!empty($_POST) && $_POST['action'] == "edit_address")
 {
    $objCustomer->updateShippingAddress($_POST);
    $_SESSION['successMsg'] = EDIT_SHIPPINGADDRESS;
    header("location: addressBook.php");										
    exit;
 }

require_once("includes/footer.php"); 
?>