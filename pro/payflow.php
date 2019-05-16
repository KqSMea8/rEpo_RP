<?php
	/*==================================================================
	 Payflow Direct Payment Call
	 ===================================================================
	*/
require_once ("paypalfunctions.php");

$PaymentOption = "Visa";

if ( $PaymentOption == "Visa" || $PaymentOption == "MasterCard" || $PaymentOption == "Amex" || $PaymentOption == "Discover" )
{
	/*
	'------------------------------------
	' The paymentAmount is the total value of 
	' the shopping cart, that was set 
	' earlier in a session variable 
	' by the shopping cart page
	'------------------------------------
	*/
	
	$finalPaymentAmount =  10;

	$creditCardType 		= "Visa"; //' Set this to one of the acceptable values (Visa/MasterCard/Amex/Discover) match it to what was selected on your Billing page
	$creditCardNumber 	= "4699222514723889"; // ' Set this to the string entered as the credit card number on the Billing page
	$expDate 				= "012015"; // ' Set this to the credit card expiry date entered on the Billing page
	$cvv2 				= "962"; // ' Set this to the CVV2 string entered on the Billing page 
	$firstName 			= "Parwez"; // ' Set this to the customer's first name that was entered on the Billing page 
	$lastName 			= "Khan"; // ' Set this to the customer's last name that was entered on the Billing page 
	$street 				= "NA"; // ' Set this to the customer's street address that was entered on the Billing page 
	$city 				= "New Delhi"; // ' Set this to the customer's city that was entered on the Billing page 
	$state 				= "Delhi"; // ' Set this to the customer's state that was entered on the Billing page 
	$zip 					= "110044"; // ' Set this to the zip code of the customer's address that was entered on the Billing page 
	$countryCode 			= "IN"; // ' Set this to the PayPal code for the Country of the customer's address that was entered on the Billing page 
	$currencyCode 		= "USD"; // ' Set this to the PayPal code for the Currency used by the customer
	$orderDescription 	= "Payment of Item"; // ' Set this to the textual description of this order 

	$paymentType			= "Sale";
	
	/*
	'------------------------------------
	'
	' The DirectPayment function is defined in the file PayPalFunctions.php,
	' that is included at the top of this file.
	'-------------------------------------------------
	*/

	$resArray = DirectPayment ( $paymentType, $finalPaymentAmount, $creditCardType, $creditCardNumber, $expDate, $cvv2, $firstName, $lastName, $street, $city, $state, $zip, $countryCode, $currencyCode, $orderDescription );
	 $ack = $resArray["RESULT"];
echo '<pre>'; print_r($resArray);exit;
	if( $ack != "0" ) 
	{
		// See pages 50 through 65 in https://cms.paypal.com/cms_content/US/en_US/files/developer/PP_PayflowPro_Guide.pdf for a list of RESULT values (error codes)
		//Display a user friendly Error on the page using any of the following error information returned by Payflow
		$ErrorCode = $ack;
		$ErrorMsg = $resArray["RESPMSG"];
		
		echo "Credit Card transaction failed. ";
		echo "Error Message: " . $ErrorMsg;
		echo "Error Code: " . $ErrorCode;
	}
}		
		
?>
