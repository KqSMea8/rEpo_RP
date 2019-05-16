<?php
   // $_POST['OrderID']=26284;

	$sql="Select * from s_order WHERE OrderID='".$_POST['OrderID']."'";
	$orderdetail= $objSale->query($sql, 1);
	
	
	require_once("/var/www/html/erp/lib/paypal/sdk/vendor/paypal/rest-api-sdk-php/sample/bootstrap.php");	
	use PayPal\Api\BillingInfo;
	use PayPal\Api\Currency;
	use PayPal\Api\Invoice;
	use PayPal\Api\InvoiceAddress;
	use PayPal\Api\InvoiceItem;
	use PayPal\Api\MerchantInfo;
	use PayPal\Api\PaymentTerm;
	use PayPal\Api\ShippingInfo;
	
	
	$invoice = new Invoice();
if($_SESSION['CmpID']==37){
		//print_r($apiContext);
		
		$apiContext->setConfig( array('mode' => 'sandbox'));
		
		//die('sdfsd');
}
// ### Invoice Info
// Fill in all the information that is
// required for invoice APIs
$invoice
    ->setMerchantInfo(new MerchantInfo())
    ->setBillingInfo(array(new BillingInfo()))
   // ->setNote("Medical Invoice 16 Jul, 2013 PST")
    ->setPaymentTerm(new PaymentTerm());    
  $invoice->setNumber($orderdetail[0]['SaleID'].'_'.rand());

// ### Merchant Info
// A resource representing merchant information that can be
// used to identify merchant
$invoice->getMerchantInfo()
    // This would be the email address of third party merchant.
    ->setEmail($paypalUsername)
    ->setFirstName($arryCompany['ContactPerson'])  
    ->setbusinessName($arryCompany['CompanyName'])
    ->setAddress(new InvoiceAddress());

// ### Address Information
// The address used for creating the invoice
$invoice->getMerchantInfo()->getAddress()
    ->setLine1($arryCurrentLocation[0]['Address'])
    ->setCity($arryCurrentLocation[0]['City'])
    ->setState($arryCurrentLocation[0]['StateCode'])
    ->setPostalCode($arryCurrentLocation[0]['ZipCode'])
    ->setCountryCode($arryCurrentLocation[0]['CountryCode']);

// ### Billing Information
// Set the email address for each billing
$billing = $invoice->getBillingInfo();
$billing[0]
    ->setEmail($_POST['paypalemail']);

$billing[0]->setBusinessName($_POST['CustomerCompany'])   
    ->setAddress(new InvoiceAddress());

$billing[0]->getAddress()
    ->setLine1($_POST['Address'])
    ->setCity($_POST['City'])
    ->setState($_POST['State'])
    ->setPostalCode($_POST['ZipCode'])
    ->setCountryCode("US");
    
    
   

// ### Items List
// You could provide the list of all items for
// detailed breakdown of invoice   
$items = array();


						for($i=1;$i<=$_POST['NumLine'];$i++){
						
						$items[$i-1] = new InvoiceItem();
						$items[$i-1]->setName($_POST['description'.$i])
									
									->setQuantity($_POST['qty'.$i])
									 ->setUnitPrice(new Currency());
						if(!empty($_POST['PFromDate'.$i])){			 
								$items[$i-1] ->setDate($_POST['PFromDate'.$i]);
						}
						$items[$i-1]->getUnitPrice()
								    ->setCurrency("USD")
								    ->setValue($_POST['price'.$i]);		

						if(!empty($_POST['taxAmnt'])){
							    $taxamt=$_POST['taxAmnt'];
							    $taxnames=explode(':',$_POST['TaxRate']);
							    
							     $tax = new \PayPal\Api\Tax();
						     	 $tax->setPercent($taxnames[2])->setName($taxnames[1]);
							     $items[$i-1]->setTax($tax);
							    }
					}
					 
					
	$invoice->setItems($items);				

$invoice->getPaymentTerm()->setTermType("NET_45");
    
    
// For Sample Purposes Only.
$request = clone $invoice;

// This would be refresh token retrieved from http://paypal.github.io/PayPal-PHP-SDK/sample/doc/lipp/ObtainUserConsent.html
//$refreshToken = "SCNWVZfdg43XaOmoEicazpkXyda32CGnP208EkuQ_QBIrXCYMhlvORFHHyoXPT0VbEMIHYVJEm0gVf1Vf72YgJzPScBenKoVPq__y1QRT7wwJo3WYADwUW4Q5ic";
//$refreshToken = "imrqBWnVB9ycbzn0DBQ0KedwS7XJffGhKPEgpBDwvEzHLfiDVT53gwIi2sErH7V58DYYSf-nJFyFm0QhT8DNruym2wlc30una9-RsCKYsBlPI2k58ia6BioURCY";

//$refreshToken = "sde6dGXpVp2V31ycZ6WEMbevuyiNQf-mzEquFCLRQRCs3EAeU0h5koXkOEwrkfH3SJPfcPyhxZNZzflBEJD7YWU95E-jHyJCk7JMp5sb33BcW7jHspetxOdJ7IQ";
$refreshToken =$PaypalToken;
//$refreshToken ='sde6dGXpVp2V31ycZ6WEMbevuyiNQf';

try {
    // ### Use Refresh Token. MAKE SURE TO update `MerchantInfo.Email` based on
    $invoice->updateAccessToken($refreshToken, $apiContext);

    // ### Create Invoice
    // Create an invoice by calling the invoice->create() method
    // with a valid ApiContext (See bootstrap.php for more on `ApiContext`)
    $invoice->create($apiContext);    
    $responce['success']=1;
    $responce['InvoiceID']=$invoice->getId();
    $responce['InvoiceNumber']=$invoice->getNumber();
   // print_r($responce);
} catch (Exception $ex) {
//print_r($ex);die;
	$errors=json_decode($ex->getData());
	$responce['errors'][]=$errors->error_description;
    // NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
 	//ResultPrinter::printError("Create Invoice", "Invoice", null, $request, $ex);
  //  exit(1);
}


// NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
 //ResultPrinter::printResult("Create Invoice", "Invoice", $invoice->getId(), $request, $invoice);


// ### Send Invoice
try {
    // ### Send Invoice
    $invoice->send($apiContext);
    $invoice = Invoice::get($invoice->getId(), $apiContext);
    
} catch (Exception $ex) {
$responce['errors'][]=$errors->error_description;
    // NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
   // ResultPrinter::printError("Send Invoice", "Invoice", null, $request, $ex);
  //  exit(1);
}
// NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
//ResultPrinter::printResult("Send Invoice", "Invoice", $invoice->getId(), $request, $invoice);
	
	//die;
?>
