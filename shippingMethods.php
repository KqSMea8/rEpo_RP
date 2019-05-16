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
        
        if(empty($_SESSION["guestId"])){
         $Cid = isset($_SESSION['Cid'])?$_SESSION['Cid']:"";
        }else{
            $Cid = isset($_SESSION["guestId"])?$_SESSION["guestId"]:"";
        }
         $_SESSION['DelivaryDate'] = isset($_POST['DelivaryDate'])?$_POST['DelivaryDate']:"";
         $_SESSION['shipping_address_id'] = isset($_POST['shipping_address_id'])?$_POST['shipping_address_id']:"";
         $_SESSION['add_to_address_book'] = isset($_POST['add_to_address_book'])?$_POST['add_to_address_book']:"";
         $countryId = isset($_POST['country_id_shipp'])?$_POST['country_id_shipp']:"";
         
         $stateId = isset($_POST['main_state_id_shipp'])?$_POST['main_state_id_shipp']:"";
         $_SESSION['AddressType'] = isset($_POST['AddressType'])?$_POST['AddressType']:"";
         
         if(!empty($_POST))
          {
                $objCustomer->UpdateCustomerFromCheckoutPage($_POST);
           }


            if($_POST['add_to_address_book'] == "Yes")
            {
                $objCustomer->addShippingAddressFromCheckout($_POST);
            }
	
             
	 $arryCustomer = $objCustomer->getCustomerById($Cid);
         if($_POST['shipping_address_id'] == "new"){
              $countryId = $countryId;
              $stateId = $stateId;
          
         }else{
             
                $address = $objCustomer->getShippingAddressById($_SESSION['shipping_address_id']);
                $countryId = $address[0]['Country'];
                $stateId = $address[0]['State'];
             
            }
         
         
         $arryCart = $objOrder->GetCart($Cid);
         $numCart  = $objOrder->numRows();
            
         //Get Shipping Methods
         
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
	
	}
         
     
        
         $arrayShippingMethods =  $objcartsettings->getShippingMethods($countryId,$stateId);
         $i = 0;
         foreach($arrayShippingMethods as $method){
             $CustomPrice =  $objcartsettings->getCustomShippingPriceBySsid($method['Ssid'],$method['MethodId'],$TotalWeight, $TotalItems,$SubTotal);
             $arrayShippingMethods[$i]['CarrierPrice'] = $CustomPrice[0]['Price'];
             $arrayShippingMethods[$i]['CarrierPriceType'] = $CustomPrice[0]['PriceType'];
            $i++;
         }
      
         
        //Get TaxRates
	
	
         foreach ($arryCart as $key => $values) {
             if($values['IsTaxable'] == "Yes")
             {
                $strTaxRates =  $objcartsettings->getTaxRates($values['TaxClassId'],$countryId,$stateId);
                if($strTaxRates != "NoTaxes"){
                    $arrayTaxRates = explode("#", $strTaxRates);
                    $TaxRate = $arrayTaxRates[0];
                    $TaxDescription = $arrayTaxRates[1];
                    $objOrder->UpdateCartWithTax($Cid,$values['ProductID'],$TaxRate,$TaxDescription);
                }
             }
         }
    	
   //End Code
         
require_once("includes/footer.php"); 
?>