<?php
require_once("includes/settings.php");
require_once("../classes/sales.quote.order.class.php");
require_once("../classes/sales.customer.class.php");
$action =  $_POST['action'];
$objSale = new sale();
$objCustomer = new Customer();

switch($action){

	case 'addToCart':
		$error='';
		
		foreach($_POST['ProductID'] as $key=>$val){ 
			$ProductID=$val;
			$Quantity=$_POST['Quantity'][$val];
			$response=$objSale->getCartProductQty($ProductID);

			$totalQty=$Quantity;
			if(!empty($response[0]['Quantity'])){
				$totalQty+=$response[0]['Quantity'];
			}
			
		}

			$res=$objSale->addToCartCustomer($_POST);

			$responce['message']='1';
		
		


		echo json_encode($responce);
		break;

	case 'getCartItem':

		$res=$objSale->getCartItem();
		
		if(count($res)>0){
			$responce['message']='1';
		}else{
			$responce['message']='2';
		}

		echo json_encode($responce);
		break;

	case 'validateaddress':
	
		$shipto=$_POST['shipto'];
		$Cid=$_SESSION['UserData']['CustID'];
		
		$arryCustomerShip = $objCustomer->GetCustomerShippingContact($Cid,$shipto);
//print_r($arryCustomerShip); exit;
		$FirstName=$arryCustomerShip[0]['FirstName'];
		$LastName=$arryCustomerShip[0]['LastName'];		
		$ShippingAddress=$arryCustomerShip[0]['Address'];
		$ShippingCity=$arryCustomerShip[0]['CityName'];
		$ShippingState=$arryCustomerShip[0]['StateName'];
		$ShippingCountry=$arryCustomerShip[0]['CountryName'];
		
		if(!empty($FirstName)) $address .=$FirstName.',';
		if(!empty($LastName)) $address .=$LastName.',';
		if(!empty($ShippingAddress)) $address .=$ShippingAddress.',';
		if(!empty($ShippingCity)) $address .=$ShippingCity.',';
		if(!empty($ShippingState)) $address .=$ShippingState.',';
		if(!empty($ShippingCountry)) $address .=$ShippingCountry.',';
		
		$address=substr($address,0,-1);
		$responce['message']=$address;
		



		echo json_encode($responce);
		break;

} if(!empty($AjaxHtml)){ echo $AjaxHtml; exit;}
?>
