<?php 
require_once("includes/header.php");
include_once("includes/header_menu.php");

 if(!empty($_POST['Email']))
 {
    $_SESSION['MsgSubscriber'] = SUBSCRIBER_MSG;
    $addEmail = $objCustomer->addSubcribeEmail($_POST['Email']);
 }
 else{
     $_SESSION['MsgSubscriber'] = NOT_SUBSCRIBER_MSG;
 }

require_once("includes/footer.php"); 
 ?>


