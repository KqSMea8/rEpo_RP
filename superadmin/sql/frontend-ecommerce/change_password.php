<?php 
require_once("includes/header.php");
include_once("includes/header_menu.php");

ValidateMemberSession($ThisPage);


if(!empty($_POST))
 {
    
   $objCustomer->changePassword($_POST);
   $_SESSION['successMsg'] = PASSWORD_UPDATED;
    header("location: account.php");										
    exit;
 }
 

require_once("includes/footer.php"); 
?>