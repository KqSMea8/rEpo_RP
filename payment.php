<?php 
require_once("includes/header.php");

include_once("includes/header_menu.php");
  

if(empty($_SESSION["guestId"])){
 ValidateMemberSession($ThisPage);
}
else{}

if(empty($arryNumCart[0]['NumCartItem'])) {
		header('location:cart.php');
		exit;
	}
      
   
   
   //Get Cart Contents
  if(empty($_SESSION["guestId"])){
         $Cid = isset($_SESSION['Cid'])?$_SESSION['Cid']:"";
        }else{
            $Cid = isset($_SESSION["guestId"])?$_SESSION["guestId"]:"";
        }
   $arryCart = $objOrder->GetCart($Cid);	
   $numCart  = $objOrder->numRows();
  

   //Get Shipping Charge
   
	if($numCart>0){
		$TotalWeight = 0;
                $SubTotal = 0;
                $TotalItems = 0;
                
		foreach($arryCart as $key=>$values){
		    if(empty($values['Weight'])) $values['Weight'] = 1;      
                        if($values['FreeShipping'] == "No")
                         {
                             $TotalWeight += ($values['Quantity']*$values['Weight']);
                             $SubTotal += $values['Quantity'] * $values['Price'];
                             $TotalItems += $values['Quantity'];
                         }   
		}
		
                if(!empty($_POST['Ssid'])){
		 $_SESSION['Ssid'] = isset($_POST['Ssid'])?$_POST['Ssid']:"";
                }
              
                 
                 if(!empty($_SESSION['Ssid'])){
                     
                   $shippingCharge =  $objcartsettings->getCustomShippingPrice($_SESSION['Ssid'],$TotalWeight,$TotalItems,$SubTotal); 
                   $shippingMethod =  $objcartsettings->getShippingMethodById($_SESSION['Ssid']);
                 }
                 
               
                 
                 $shippingCharge = number_format($shippingCharge, 2,'.','');
                 

	}

 //End Code
        
  //Get Payment Methods
        $arrayPaymentMethods = $objPayment->getActivePaymentMethods();
   //End Code     

//For Shipping AND Billing Addresses
        
  $arryCustomer = $objCustomer->getCustomerById($Cid);
  $address = $objCustomer->getShippingAddressById($_SESSION['shipping_address_id']);

  
  /********Connecting to main database*********/
        $Config['DbName'] = $Config['DbMain'];
        $objConfig->dbName = $Config['DbName'];
        $objConfig->connect();
      /*******************************************/
        
          if(!empty($arryCustomer[0]['State'])) {
                    $arryState = $objRegion->getStateName($arryCustomer[0]['State']);
                    $BillingStateName = stripslashes($arryState[0]["name"]);
                    }else if(!empty($arryCustomer[0]['OtherState'])){
                     $BillingStateName = stripslashes($arryCustomer[0]['OtherState']);
                    }

                    if(!empty($arryCustomer[0]['City'])) {
                    $arryCity = $objRegion->getCityName($arryCustomer[0]['City']);
                    $BillingCityName = stripslashes($arryCity[0]["name"]);
                    }else if(!empty($arryCustomer[0]['OtherCity'])){
                     $BillingCityName = stripslashes($arryCustomer[0]['OtherCity']);
                    }

                    if($arryCustomer[0]['Country']>0){
                    $arryCountryName = $objRegion->GetCountryName($arryCustomer[0]['Country']);
                    $BillingCountryName = stripslashes($arryCountryName[0]["name"]);
            }
  
  $BillingName = ucfirst($arryCustomer[0]['FirstName'])." ".ucfirst($arryCustomer[0]['LastName']); 
  $BillingCompany = $arryCustomer[0]['Company'];
  $BillingAddress = $arryCustomer[0]['Address1']. " ".$arryCustomer[0]['Address2'];;
  $BillingCityName = $BillingCityName;
  $BillingStateName = $BillingStateName;
  $BillingCountryName = $BillingCountryName;
  $BillingZipCode = $arryCustomer[0]['ZipCode'];
  $BillingPhone = $arryCustomer[0]['Phone'];
  $BillingEmail = $arryCustomer[0]['Email'];
  
  
  
 if($_SESSION['shipping_address_id'] == "new")
 {
      
         if(!empty($arryCustomer[0]['ShippingState'])) {
                    $arryState = $objRegion->getStateName($arryCustomer[0]['ShippingState']);
                    $ShippStateName = stripslashes($arryState[0]["name"]);
                    }else if(!empty($arryCustomer[0]['OtherShippingState'])){
                     $ShippStateName = stripslashes($arryCustomer[0]['OtherShippingState']);
                    }

                    if(!empty($arryCustomer[0]['ShippingCity'])) {
                    $arryCity = $objRegion->getCityName($arryCustomer[0]['ShippingCity']);
                    $ShippCityName = stripslashes($arryCity[0]["name"]);
                    }else if(!empty($arryCustomer[0]['OtherShippingCity'])){
                     $ShippCityName = stripslashes($arryCustomer[0]['OtherShippingCity']);
                    }

                    if($arryCustomer[0]['ShippingCountry']>0){
                    $arryCountryName = $objRegion->GetCountryName($arryCustomer[0]['ShippingCountry']);
                    $ShippCountryName = stripslashes($arryCountryName[0]["name"]);
            }
            
   $ShippingName = stripslashes($arryCustomer[0]['ShippingName']);
   $ShippingCompany = stripslashes($arryCustomer[0]['ShippingCompany']);
   $ShippingAddress = stripslashes($arryCustomer[0]['ShippingAddress1']." ".$arryCustomer[0]['ShippingAddress2']);
   $ShippingCity = stripslashes($ShippCityName);
   $ShippingState = stripslashes($ShippStateName);
   $ShippingCountry = stripslashes($ShippCountryName);
   $ShippingZip = $arryCustomer[0]['ShippingZip'];
   $ShippingPhone = $arryCustomer[0]['ShippingPhone'];
 
 }  
 
 else
 {
     

     if(!empty($address[0]['State'])) {
                    $arryState = $objRegion->getStateName($address[0]['State']);
                    $ShippStateName = stripslashes($arryState[0]["name"]);
                    }else if(!empty($address[0]['OtherState'])){
                     $ShippStateName = stripslashes($address[0]['OtherState']);
                    }

                    if(!empty($address[0]['City'])) {
                    $arryCity = $objRegion->getCityName($address[0]['City']);
                    $ShippCityName = stripslashes($arryCity[0]["name"]);
                    }else if(!empty($address[0]['OtherCity'])){
                     $ShippCityName = stripslashes($address[0]['OtherCity']);
                    }

                    if($address[0]['Country']>0){
                    $arryCountryName = $objRegion->GetCountryName($address[0]['Country']);
                    $ShippCountryName = stripslashes($arryCountryName[0]["name"]);
            }
    
            $ShippingName = stripslashes($address[0]['Name']);
            $ShippingCompany = stripslashes($address[0]['Company']);
            $ShippingAddress = stripslashes($address[0]['Address1']." ".$address[0]['Address2']);
            $ShippingCity = stripslashes($ShippCityName);
            $ShippingState = stripslashes($ShippStateName);
            $ShippingCountry = stripslashes($ShippCountryName);
            $ShippingZip = $address[0]['Zip'];
            $ShippingPhone = $address[0]['Phone'];
        
 }
   //End Code For Shipping 
  
 
require_once("includes/footer.php"); 
?>