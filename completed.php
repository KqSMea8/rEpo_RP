<?php 
 session_start();
require_once("includes/header.php");
 
include_once("includes/header_menu.php");



if(empty($_SESSION["guestId"])){
 ValidateMemberSession($ThisPage);
}
else{}

$_SESSION['SUCC_TITLE'] = ORDER_PROCESSED;
$_SESSION['mess_account'] = ORDER_PROCESSED_MSG; 

$OrderId = isset($_GET['OrderID'])?base64_decode($_GET['OrderID']) : "";
$Cid = isset($_GET['cid'])?base64_decode($_GET['cid']):"";

$PaymentMethod = isset($_GET['pg'])?$_GET['pg']:"";


if(!empty($OrderId) && !empty($Cid)){
    
        $objOrder->PaymentDone($Cid,$OrderId,$_GET['pg']);
        $objOrder->RemoveCart($Cid);

}


//Unset All Sessions Variables

    unset($_SESSION['DelivaryDate']);
    unset($_SESSION['shipping_address_id']);
    unset($_SESSION['add_to_address_book']);
    unset($_SESSION['OrderID']);
    unset($_SESSION['Amount']);
    unset($_SESSION['ProductIDs']);
    unset($_SESSION['Ssid']);
    unset($_SESSION['shipping_address_id']);
    unset($_SESSION['AddressType']);
    
    unset($_SESSION['discountAmount']);
    unset($_SESSION['discountValue']);
    unset($_SESSION['discountType']);
    unset($_SESSION['promo_campaign_id']);
    unset($_SESSION['promo_discount_amount']);
    unset($_SESSION['promo_code']);

//end

require_once("includes/footer.php"); 
?>