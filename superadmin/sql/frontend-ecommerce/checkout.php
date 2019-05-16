<?php 
require_once("includes/header.php");

//include_once("includes/header_menu.php");

if(empty($arryNumCart[0]['NumCartItem'])) {
		header('location:cart.php');
		exit;
	}


if($_GET['user'] == "guest"){
		 
   $guestCustomerId = $objCustomer->expressLogin();
   $Cid = $_SESSION["guestId"];	
   $arryCart = $objOrder->GetCart(session_id());	
    $numCart  = $objOrder->numRows(); 
    if($numCart > 0){
            $PrdIDs = '';
            foreach($arryCart as $key=>$values){
                    $PrdIDs .= $values['ProductID'].',';
            }
            $objCustomer->UpdateCustomerCart($_SESSION['guestId'],$PrdIDs);
            //header('location:checkout.php');
            //exit;
    }
}
else{
   // ValidateMemberSession($ThisPage);
    $Cid = !empty($_SESSION['Cid'])?$_SESSION['Cid']:"";				 
   
}

$arryCustomer=$addresses=array();
if(!empty($Cid)){
   $arryCustomer = $objCustomer->getCustomerById($Cid);
    $addresses = $objCustomer->getShippingAddresses($Cid);      
}
        
         
  	

require_once("includes/footer.php"); 

?>
