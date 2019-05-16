<?php 
require_once("includes/header.php");
include_once("includes/header_menu.php");

ValidateMemberSession($ThisPage);

if(!empty($Cid)){$arrayMyProfile = $objCustomer->getCustomerById($Cid);}

if(!empty($_POST))
 {
    
   $objCustomer->UpdateMyProfile($_POST);
   $_SESSION['successMsg'] = PROFILE_UPDATED;
    header("location: account.php");										
    exit;
 }
 

require_once("includes/footer.php"); 
?>