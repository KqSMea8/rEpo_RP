<?php   
require_once("includes/header.php");
include_once("includes/header_menu.php");

ValidateMemberSession($ThisPage);

$oid = isset($_REQUEST['oid'])?$_REQUEST['oid']:"";
if(!empty($oid)){
     $arryOrderIfo = $objOrder->getOrdererInfo($oid);
      $arryOrderProduct = $objOrder->getOrderedProductById($oid);
    
    }

require_once("includes/footer.php"); 

               
?>