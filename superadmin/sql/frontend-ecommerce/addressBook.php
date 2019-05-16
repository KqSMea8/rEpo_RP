<?php 
require_once("includes/header.php");
 
//include_once("includes/header_menu.php");


ValidateMemberSession($ThisPage);



if(!empty($_POST) && $_POST['action'] == "save_address")
 {
    
   $objCustomer->addShippingAddress($_POST);
   $_SESSION['successMsg'] = SAVE_SHIPPINGADDRESS;
    header("location: addressBook.php");										
    exit;
 }
 
 if(!empty($_REQUEST['Csid']) && $_REQUEST['action'] == "delete_address")
 {
    
   $objCustomer->deleteShippingAddress($_REQUEST['CustId'],$_REQUEST['Csid']);
    $_SESSION['successMsg'] = DELETE_SHIPPINGADDRESS;
    header("location: addressBook.php");										
    exit;
 }
 
 
 $addresses = $objCustomer->getShippingAddresses($Cid);

require_once("includes/footer.php"); 
?>