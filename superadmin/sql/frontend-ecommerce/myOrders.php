<?php   
require_once("includes/header.php");
include_once("includes/header_menu.php");

ValidateMemberSession($ThisPage);


if(!empty($_SESSION['Cid'])){
    $arrayMyOrders = $objOrder->GetMyOrders($_SESSION['Cid']);
    
    }

require_once("includes/footer.php"); 

               
?>