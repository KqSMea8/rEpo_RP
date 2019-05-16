<?php
require_once("lib/paypal/sdk/vendor/paypal/rest-api-sdk-php/sample/bootstrap.php");	
	use PayPal\Api\Address;
	use PayPal\Api\BillingInfo;
	use PayPal\Api\Cost;
	use PayPal\Api\Currency;
	use PayPal\Api\Invoice;
	use PayPal\Api\InvoiceAddress;
	use PayPal\Api\InvoiceItem;
	use PayPal\Api\MerchantInfo;
	use PayPal\Api\PaymentTerm;
	use PayPal\Api\Phone;
	use PayPal\Api\ShippingInfo;
	$invoice = new Invoice();
	require_once("lib/paypal/paypal_pro.inc.php");
	$apiContext = getApiContext($clientId, $clientSecret);
	$refreshToken=$PaypalToken;
    $invoice->updateAccessToken($refreshToken, $apiContext);
ini_set('display_errors',1);
    //$invoice->setId('INV2-K2PF-TE9G-TP7F-SJPE');
    //$invoiceId = $invoice->getId();

		//pr($result['paypalInvoiceId']);
		 
			try{
   		// $invoice = Invoice::get($invoiceId, $apiContext);
   		 //echo 'sdfsdfsd';

		$invoices = Invoice::getAll(array('page' => 0, 'page_size' => 20, 'total_count_required' => "true"), $apiContext);
   		// $status=$invoice->getStatus();
			}catch (Exception $ex) {
				print_r($ex);
			
			echo 'Error';
			
			}

		
		print_r($invoices);die;
			echo $invoices->total_count;
			echo "<br/>";
			if(!empty($invoices)){

				foreach($invoices->invoices as $invoi){

					echo "Invoice Number :". $invoi->getId();
					echo "----";
					echo $invoi->getInvoiceDate();
					echo "<br/>";
				}
			}
			echo  $status;
	echo 'testtt';die;
/*
$ch = curl_init(); 
curl_setopt($ch, CURLOPT_URL, "https://tlstest.paypal.com/"); 
curl_setopt($ch, CURLOPT_CAINFO, 'cacert.pem');
// Some environments may be capable of TLS 1.2 but it is not in their list of defaults so need the SSL version option to be set.
curl_setopt($ch, CURLOPT_SSLVERSION, 6);
curl_exec($ch);
echo "\n";
if ($err = curl_error($ch)) {
echo "Errororororo";
	var_dump($err);
	echo "DEBUG INFORMATION:\n###########\n";
	echo "CURL VERSION:\n";
	echo json_encode(curl_version(), JSON_PRETTY_PRINT);
}*/
?>
