<?php
   // $_POST['OrderID']=26284;
 
require_once("/var/www/html/erp/lib/paypal/sdk/vendor/paypal/rest-api-sdk-php/sample/bootstrap.php");	
	use PayPal\Api\BillingInfo;
	use PayPal\Api\Currency;
	use PayPal\Api\Invoice;
	use PayPal\Api\InvoiceAddress;
	use PayPal\Api\InvoiceItem;
	use PayPal\Api\MerchantInfo;
	use PayPal\Api\PaymentTerm;
	use PayPal\Api\ShippingInfo;
	use PayPal\Api\ShippingCost;
	
	$invoice = new Invoice();

	$invoice->setId($invoiceid);
	$refreshToken =$PaypalToken;
	try {
    // ### Use Refresh Token. MAKE SURE TO update `MerchantInfo.Email` based on
    
	 $invoice->updateAccessToken($refreshToken, $apiContext);
	}catch (Exception $ex) {
	
	return $responce=array('errors'=>'invalid token');
	}
	
	
	$invoice = $invoice->get($invoiceid, $apiContext);  
	    if($invoice->getStatus()!='SENT'){
	    return $responce=array('errors'=>'paypal invoice already'.$invoice->getStatus());	    
	    }
	
// ### Invoice Info
// Fill in all the information that is
// required for invoice APIs
$invoice
    ->setMerchantInfo(new MerchantInfo())
    ->setBillingInfo(array(new BillingInfo()))
   // ->setNote("Medical Invoice 16 Jul, 2013 PST")
    ->setPaymentTerm(new PaymentTerm());    
    
    
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
    ->setEmail($arrySale[0]['paypalEmail']);

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
						/*if(!empty($_POST['PFromDate'.$i])){			 
							//	$items[$i-1] ->setDate($_POST['PFromDate'.$i]);
						}*/
						$items[$i-1]->getUnitPrice()
								    ->setCurrency("USD")
								    ->setValue($_POST['price'.$i]);		
						$_POST['taxAmnt']=(float)$_POST['taxAmnt'];
						if(!empty($_POST['taxAmnt'])){
							    $taxamt=$_POST['taxAmnt'];
							     $taxnames=explode(':',$_POST['MainTaxRate']);							
							     $tax = new \PayPal\Api\Tax();
						     	 $tax->setPercent($taxnames[2])->setName($taxnames[1]);
							     $items[$i-1]->setTax($tax);
							    }
					}
				
				
	$invoice->setItems($items);				

$invoice->getPaymentTerm()->setTermType("DUE_ON_RECEIPT");
    
	if(!empty($_POST['Freight'])){
	    $amt=(float)$_POST['Freight'];
		$cun=new Currency();
		$cun->setCurrency('USD');
		$cun->setValue($amt);
		$ShippingCost = new ShippingCost();
		$ShippingCost->setAmount($cun);
		$invoice->setShippingCost($ShippingCost);
	}
    
// For Sample Purposes Only.
$request = clone $invoice;
try {
    // ### Use Refresh Token. MAKE SURE TO update `MerchantInfo.Email` based on
  $invoice->update($apiContext);
    $responce['success']=1;
    $responce['InvoiceID']=$invoice->getId();
    $responce['InvoiceNumber']=$invoice->getNumber();
if($_SESSION['CmpID']==37){
					//	print_r($errors);
					//die('done');
					}
} catch (Exception $ex) {
	if($_SESSION['CmpID']==37){
					//	print_r($ex);
				//	die('test');
					}
	$errors=json_decode($ex->getData());
	$responce['errors']=!empty($errors->error_description)?$errors->error_description:'some technical problem';
}
return $responce;

?>
