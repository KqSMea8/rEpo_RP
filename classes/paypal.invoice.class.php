<?php 
if(!empty($_GET['testpaypal'])){
require  __DIR__ . '/../lib/paypal/sdk/vendor/paypal/rest-api-sdk-php/sample/bootstrap.php';
//require  '/var/www/html/erp/lib/paypal/sdk/vendor/paypal/rest-api-sdk-php/sample/bootstrap.php';
//error_reporting(E_ALL);
//ini_set('display_errors', '1');
/*use PayPal\Api\BillingInfo;
use PayPal\Api\Currency;
use PayPal\Api\Invoice;
use PayPal\Api\InvoiceAddress;
use PayPal\Api\InvoiceItem;
use PayPal\Api\MerchantInfo;
use PayPal\Api\PaymentTerm;
use PayPal\Api\ShippingInfo;*/
echo 'sdfsdf';
}

class paypalInvoice extends dbClass
{
	/*public $paypal_username='ravisolanki343-facilitator_api1.gmail.com';
	public $paypal_password='1387540400';
	public $paypal_signature='AW3wZm8iuG-ybETBKJ4rdHXsiN8DA4ks-a1x39Hub0-k8hl6ITLE3-53';*/
	
	/*public $paypal_username='admin-facilitator_api1.virtualstacks.com';
	public $paypal_password='CHLPKZUUTLL6NWUF';
	public $paypal_signature='APJZCVE1tBem.RcCAlzrK6S7nsxJAHsqotFKSBcq4d4K7XgaI9DtUdat';*/

	public $paypal_username='';
	public $paypal_password='';
	public $paypal_signature='';
	public $application_id='';

	public $developer_account_email='';
	public $sandbox=false;
	

	//public $application_id='APP-80W284485P519543T';
  	//public $application_id='APP-4F1565487B866862N';	
	public $device_id='';
	public $device_ip_address = '';
	public $print_headers = false;
	public $log_results = '';
	public $log_path = '';
	//public $MerchantEmail='ravisolanki343-facilitator@gmail.com';
	public $MerchantEmail='admin-facilitator@virtualstacks.com';
	
	public $paypalDir='/var/www/html/erp/lib/paypal/paypal_pro.inc.php';
	public $basedir='/var/www/html/erp/admin';
	
	
	function __construct($data=array()){
		//$a=$this->GetTempHostbillSetting();	
		$detail=$this->GetPaypalDetail();
		$paypaldetail=array();
		$this->paypal_username=$detail[0]['paypalUsername'];
		$this->paypal_password=$detail[0]['paypalPassword'];
		$this->paypal_signature=$detail[0]['paypalSignature'];
		$this->MerchantEmail=$detail[0]['paypalID'];
		$this->application_id=$detail[0]['paypalAppid'];

		if($_SESSION['AdminID']==37 || !empty($_GET['paypalsandbox'])){
			$this->sandbox=true;
		}

		/*$this->paypal_username=empty($this->paypal_username)?$paypaldetail['api_url']:$this->paypal_username;
		$this->paypal_password=empty($this->paypal_password)?$paypaldetail['api_key']:$this->paypal_password;
		$this->paypal_signature=empty($this->paypal_signature)?$paypaldetail['api_id']:$this->paypal_signature;	*/
	}
	
	function GetPaypalDetail($ProviderID=1,$Status='1'){
		$strAddQuery = " where 1 ";
		$strAddQuery .= (!empty($ProviderID))?(" and ProviderID='".$ProviderID."'"):("");
		$strAddQuery .= ($Status>0)?(" and Status='".$Status."'"):("");
		$strSQLQuery = "select * from f_payment_provider  ".$strAddQuery." order by ProviderName desc";

		return $this->query($strSQLQuery, 1);
	}		

	function CreatePaypalInvoice($post){
	
	$sql="Select * from s_order WHERE OrderID='".$post['OrderID']."'";
	$orderdetail= $this->query($sql, 1);
	$post['Country']='US';
	$post['ShippingCountry']='US';
	
	$PayPalConfig = array(
					  'Sandbox' => $this->sandbox,
					  'DeveloperAccountEmail' =>$this->developer_account_email,
					  'ApplicationID' => $this->application_id,
					  'DeviceID' => $this->device_id,
					  'IPAddress' => '',
					  'APIUsername' => $this->paypal_username,
					  'APIPassword' => $this->paypal_password,
					  'APISignature' => $this->paypal_signature,
					  'APISubject' => '',
                      'PrintHeaders' => $this->print_headers, 
					  'LogResults' => $this->log_results, 
					  'LogPath' => $this->log_path,
					);

$PayPal = new Adaptive($PayPalConfig);

// Prepare request arrays
$CreateInvoiceFields = array(
							'MerchantEmail' => $this->MerchantEmail, 				// Required.  Merchant email address.
							'PayerEmail' => $post['paypalemail'], 				// Required.  Payer email address.
							'Number' => $orderdetail[0]['SaleID'].'_'.rand(), 					// Unique ID for the invoice.
							'CurrencyCode' =>!empty($post['CurrencyCode'])?$post['CurrencyCode']:'USD', 				// Required.  Currency used for all invoice item amounts and totals.
							'InvoiceDate' => '', 				// Date on which the invoice is enabled.
							'DueDate' => '', 					// Date on which the invoice payment is due.
							'PaymentTerms' => 'DueOnReceipt', 				// Required.  Terms by which the invoice payment is due.  Values are:  DueOnReceipt, DueOnSpecified, Net10, Net15, Net30, Net45
							'DiscountPercent' => '', 			// Discount percent applied to the invoice.
							'DiscountAmount' => '', 			// Discount amount applied to the invoice.  If DiscountPercent is provided, DiscountAmount is ignored.
							'Terms' => '', 						// General terms for the invoice.
							'Note' => '', 						// Note to the payer company.
							'MerchantMemo' => '', 				// Memo for bookkeeping that is private to the merchant.
							'ShippingAmount' => '', 			// Cost of shipping
							'ShippingTaxName' => '', 			// Name of the applicable tax on the shipping cost.
							'ShippingTaxRate' => '', 			// Rate of the applicable tax on the shipping cost.
							'LogoURL' => 'https://www.eznetcrm.com/img/eZnetLogo.png'						// Complete URL to an external image used as the logo, if any.
							);
							
$BusinessInfo = array(
					'FirstName' => $post['CustomerName'], 							// First name of the company contact.
					'LastName' => '', 							// Last name of the company contact.
					'BusinessName' => $post['CustomerCompany'], 						// Company business name.
					'Phone' => $post['Mobile'], 								// Phone number for contacting the company.
					'Fax' => $post['Fax'], 								// Fax number used by the company.
					'Website' => '', 							// Website used by the company.
					'Custom' => '' 								// Custom value to be displayed in the contact information details.
					);
					
$BusinessInfoAddress = array(
							'Line1' => $post['Address'], 						// Required. First line of address.
							'Line2' => '', 						// Second line of address.
							'City' => $post['City'], 						// Required. City of the address.
							'State' => $post['State'], 						// State for the address.
							'PostalCode' => $post['ZipCode'], 				// Postal code of the address
							'CountryCode' =>'US'					// Required.  Country code of the address.
							);

$BillingInfo = array(
					'FirstName' => $post['BillingName'], 							// First name of the company contact.
					'LastName' => '', 							// Last name of the company contact.
					'BusinessName' => $post['CustomerCompany'], 						// Company business name.
					'Phone' =>  $post['Mobile'], 								// Phone number for contacting the company.
					'Fax' => $post['Fax'], 								// Fax number used by the company.
					'Website' => '', 							// Website used by the company.
					'Custom' => '' 								// Custom value to be displayed in the contact information details.
					);
					
$BillingInfoAddress = array(
						'Line1' => $post['Address'],						// Required. First line of address.
						'Line2' => '', 						// Second line of address.
						'City' => $post['City'], 						// Required. City of the address.
						'State' => $post['State'], 						// State for the address.
						'PostalCode' => $post['ZipCode'],			// Postal code of the address
						'CountryCode' =>$post['Country']					// Required.  Country code of the address.
						);

$ShippingInfo = array(
					'FirstName' => $post['ShippingName'], 							// First name of the company contact.
					'LastName' => '', 							// Last name of the company contact.
					'BusinessName' => $post['ShippingCompany'], 						// Company business name.
					'Phone' => $post['ShippingLandline'], 								// Phone number for contacting the company.
					'Fax' => $post['ShippingFax'], 								// Fax number used by the company.
					'Website' => '', 							// Website used by the company.
					'Custom' => '' 								// Custom value to be displayed in the contact information details.
					);
					
$ShippingInfoAddress = array(
						'Line1' => $post['ShippingName'], 						// Required. First line of address.
						'Line2' => '', 						// Second line of address.
						'City' => $post['ShippingCity'], 						// Required. City of the address.
						'State' => $post['ShippingState'], 						// State for the address.
						'PostalCode' => $post['ShippingZipCode'], 				// Postal code of the address
						'CountryCode' => $post['ShippingCountry']					// Required.  Country code of the address.
						);

// For invoice items you populate a nested array with multiple $InvoiceItem arrays.  Normally you'll be looping through cart items to populate the $InvoiceItem 
// array and then push it into the $InvoiceItems array at the end of each loop for an entire collection of all items in $InvoiceItems.

$InvoiceItems = array();
			for($i=1;$i<=$post['NumLine'];$i++){
				$InvoiceItem = array(
					'Name' => 'Test Widget 1', 							// Required.  SKU or name of the item.
					'Description' => $post['description'.$i], 					// Item description.
					'Date' => $post['PFromDate'.$i], 							// Date on which the product or service was provided.
					'Quantity' => $post['qty'.$i], 						// Required.  Item count.  Values are:  0 to 10000
					'UnitPrice' => $post['price'.$i], 						// Required.  Price of the item, in the currency specified by the invoice.
					'TaxName' => '', 						// Name of the applicable tax.
					'TaxRate' => ''							// Rate of the applicable tax.
					);
array_push($InvoiceItems,$InvoiceItem);
					
					}




$PayPalRequestData = array(
						   'CreateInvoiceFields' => $CreateInvoiceFields, 
						   'BusinessInfo' => $BusinessInfo, 
						   'BusinessInfoAddress' => $BusinessInfoAddress, 
						   'BillingInfo' => $BillingInfo, 
						   'BillingInfoAddress' => $BillingInfoAddress, 
						   'ShippingInfo' => $ShippingInfo, 
						   'ShippingInfoAddress' => $ShippingInfoAddress, 
						   'InvoiceItems' => $InvoiceItems
						   );

// Pass data into class for processing with PayPal and load the response array into $PayPalResult
//$PayPalResult = $PayPal->CreateInvoice($PayPalRequestData);
$PayPalResult = $PayPal->CreateAndSendInvoice($PayPalRequestData);
// Write the contents of the response array to the screen for demo purposes.
if(strtolower($PayPalResult['Ack'])=='success'){
$this->SavePaypalEmail(array('customer_id'=>$post['CustID'],'email'=>$post['paypalemail']));
//print_r($PayPalResult);
//return $invoiceId=$PayPalResult['InvoiceID'];

return array('success'=>1,'InvoiceID'=>$PayPalResult['InvoiceID'],'InvoiceNumber'=>$PayPalResult['InvoiceNumber']);


}else{
//print_r($PayPalResult);
return array('errors'=>$PayPalResult['Errors']);
}


	}
	
	function SavePaypalEmail($arg){
	$sql="Select count(id) as c FROM s_customers_paypalEmail WHERE email='".$arg['email']."' AND  customer_id='".$arg['customer_id']."'";
	$responce= $this->query($sql, 1);
		if(empty($responce[0]['c'])){		
			$sql="INSERT INTO s_customers_paypalEmail SET email='".$arg['email']."' , customer_id='".$arg['customer_id']."'";
			$responce= $this->query($sql, 0);
		}
	}
	
	function getCustomerPaypalEmail($customerid){
	$sql="Select * FROM s_customers_paypalEmail WHERE  customer_id='".$customerid."'";
	return $responce= $this->query($sql, 1);
	
	}
	
	function SavePaypalInvoiceTransaction(){
		global $Config;
		$objCard = new card();
		$isonline=($this->sandbox===false)?TRUE:FALSE;
		$sql="Select OrderID,paypalInvoiceId,paypalInvoiceNumber,TotalAmount,CustomerCurrency FROM s_order WHERE MODULE ='Order' AND paypalInvoiceId IS NOT NULL AND OrderPaid=0";
		$responce= $this->query($sql, 1);
			$PayPalConfig = array(
					  'Sandbox' => true,
					  'DeveloperAccountEmail' =>$this->developer_account_email,
					  'ApplicationID' => $this->application_id,
					  'DeviceID' => $this->device_id,
					  'IPAddress' => '',
					  'APIUsername' => $this->paypal_username,
					  'APIPassword' => $this->paypal_password,
					  'APISignature' => $this->paypal_signature,
			 		   'APIVersion' => '57.0',
					  'APISubject' => '',
                      'PrintHeaders' => $this->print_headers, 
					  'LogResults' => $this->log_results, 
					  'LogPath' => $this->log_path,
					);

			$PayPal = new Adaptive($PayPalConfig);
			if(!empty($responce)){
				foreach($responce as $result){
				    $PayPalResult = $PayPal->GetInvoiceDetails($result['paypalInvoiceId']);
				//print_r($PayPalResult);
					if(!empty($PayPalResult['PayPalTransactionID'])){
					/*$GTDFields = array(
					'transactionid' => '8X142579CJ2394256'							// PayPal transaction ID of the order you want to get details for.
				);
				
					$PayPalRequestData = array('GTDFields'=>$GTDFields);
					
					$PayPalResultdd = $PayPal->GetTransactionDetails($PayPalRequestData);*/
							//print_r($PayPalResultdd);
							
					 require_once($this->paypalDir);
					  $nvpRecurring = '';
		              $methodToCall = 'GetTransactionDetails';
					  $tid=$PayPalResult['PayPalTransactionID'];
					  $nvpstr = '&TRANSACTIONID=' . $tid . $nvpRecurring;
					  $Username = $this->paypal_username;
		              $APIPassword = $this->paypal_password;
		              $APISignature = $this->paypal_signature;
		              $paypalPro = new paypal_pro($Username, $APIPassword, $APISignature, '', '', $isonline, FALSE);
		              $resArray = $paypalPro->hash_call($methodToCall, $nvpstr);
				/**Fee Pending */

							$arryTr['OrderID'] = $result['OrderID'];
							$arryTr['ProviderID'] = 1;
							$arryTr['TransactionID'] = $resArray['TRANSACTIONID'];
							$arryTr['TransactionType'] = 'Invoice Payment';
							$arryTr['TotalAmount'] = $result['TotalAmount'];
							$arryTr['Currency'] = $result['CustomerCurrency'];
							$arryTr['PaymentTerm'] = 'PayPal';
							$objCard->SaveCardProcess($arryTr);

		          			 $sql="Update s_order SET OrderPaid=1 , Fee='".$resArray['FEEAMT']."'";
							$this->query($sql, 0);
	         
					}
					
					
				}
			}
	}
	
	function checkCredential(){	
	
	$isonline=($this->sandbox===false)?TRUE:FALSE;
	 require_once($this->paypalDir);
					  $nvpRecurring = '';
		              $methodToCall = 'GetPalDetails';
					  $tid=$PayPalResult['PayPalTransactionID'];
					 // $nvpstr = '&TRANSACTIONID=' . $tid . $nvpRecurring;
					  $Username = $this->paypal_username;
		              $APIPassword = $this->paypal_password;
		              $APISignature = $this->paypal_signature;


		              $paypalPro = new paypal_pro($Username, $APIPassword, $APISignature, '', '', $isonline, FALSE,'94.0');
//print_r($paypalPro);
		              
		              $resArray = $paypalPro->hash_call($methodToCall, $nvpstr);
	

	if(strtolower($resArray['ACK'])=='failure'){			
			return array('status'=>0,'errors'=>'Api Credentials is invalid');
	}else{
	
	 					$PaymentProviderData=$this->GetPaymentProvider(1);	
					
							if(!empty($PaymentProviderData[0]['PaypalToken'])){
									$paypalUsername=$PaymentProviderData[0]['paypalUsername'];
									$PaypalToken=$PaymentProviderData[0]['PaypalToken'];
									$dataresponce= require_once($this->basedir."/includes/html/box/paypalInvoiceUserInfo.php");

									if($dataresponce['status']==1){
										return array('status'=>1,'message'=>'Authentication Validated Successfully.');
									}else{
											return array('status'=>0,'errors'=>'Api Credentials Valid but Paypal Authorize invalid.');
									
									}
							
							}else{
								return array('status'=>1,'message'=>'Authentication Validated Successfully.');
							
							}
	
	
	}
	

	    /*   $PayPalConfig = array(
					  'Sandbox' => $this->sandbox,
					  'DeveloperAccountEmail' =>$this->developer_account_email,
					  'ApplicationID' => $this->application_id,
					  'DeviceID' => $this->device_id,
					  'IPAddress' => '',
					  'APIUsername' => $this->paypal_username,
					  'APIPassword' => $this->paypal_password,
					  'APISignature' => $this->paypal_signature,
					  'APISubject' => '',
                      'PrintHeaders' => $this->print_headers, 
					  'LogResults' => $this->log_results, 
					  'LogPath' => $this->log_path,
					);

			$PayPal = new Adaptive($PayPalConfig);
			
			// Prepare request arrays
$AttributeList = array(
						'http://axschema.org/namePerson/first',
						'http://axschema.org/namePerson/last',
						'http://axschema.org/contact/email',
						'http://axschema.org/contact/fullname',
						'http://openid.net/schema/company/name',
						'http://axschema.org/contact/country/home',
						'https://www.paypal.com/webapps/auth/schema/payerID'
					);
					
// Pass data into class for processing with PayPal and load the response array into $PayPalResult
		$PayPalResult = $PayPal->GetBasicPersonalData($AttributeList);
		
		print_r($PayPalResult);
		$PayPalResult;
		if(empty($PayPalResult['Errors'])){
		
		return array('status'=>1);
		
		}else{
		
		return array('status'=>0,'errors'=>$PayPalResult['Errors'][0]['Message']);
		}*/
	
	}
	
	function isActivePaypalInvoice(){
	$ProviderID=1;
	$Status=1;
		$strAddQuery = " where 1 ";
		$strAddQuery .= (!empty($ProviderID))?(" and ProviderID='".$ProviderID."'"):("");
		$strAddQuery .= ($Status>0)?(" and Status='".$Status."'"):("");
		$strSQLQuery = "select * from f_payment_provider  ".$strAddQuery." order by ProviderName desc";
			$res= $this->query($strSQLQuery, 1);
		if(empty($res)){
			return 1;
		
		}else{
		
		return 0;
		}
	
	}


function DeletePaypalInvoice($invoiceId){
				$PayPalConfig = array(
					  'Sandbox' => $this->sandbox,
					  'DeveloperAccountEmail' =>$this->developer_account_email,
					  'ApplicationID' => $this->application_id,
					  'DeviceID' => $this->device_id,
					  'IPAddress' => '',
					  'APIUsername' => $this->paypal_username,
					  'APIPassword' => $this->paypal_password,
					  'APISignature' => $this->paypal_signature,
					  'APISubject' => '',
                      'PrintHeaders' => $this->print_headers, 
					  'LogResults' => $this->log_results, 
					  'LogPath' => $this->log_path,
					);

			$PayPal = new Adaptive($PayPalConfig);		
			
			
			// Prepare request arrays
$CancelInvoiceFields = array(
							'InvoiceID' => $invoiceId, 			// ID of the invoice.
							'Subject' => 'Invoice has been canceled.', 			// Subject of the cancelation notification.
							'NoteForPayer' => 'Note for Payer.', 		// Note to send the payer within the cancelation notification.
							'SendCopyToMerchant' => 'true'	// Indicates whether to send a copy of the cancelation notification to the merchant.  Values are:  true/false
							);

$PayPalRequestData = array('CancelInvoiceFields' => $CancelInvoiceFields);

// Pass data into class for processing with PayPal and load the response array into $PayPalResult
$PayPalResult = $PayPal->CancelInvoice($PayPalRequestData);
			
		//	$PayPalResult = $PayPal->DeleteInvoice($invoiceId);
			return $PayPalResult;
		}

function GetPaymentProvider($ProviderID,$Status){
		$strAddQuery = " where 1 ";
		$strAddQuery .= (!empty($ProviderID))?(" and ProviderID='".$ProviderID."'"):("");
		$strAddQuery .= ($Status>0)?(" and Status='".$Status."'"):("");

		$strSQLQuery = "select * from f_payment_provider  ".$strAddQuery." order by ProviderName desc";

		return $this->query($strSQLQuery, 1);
	}

	function updateInvoiceRefund($PayPalResult){
		 require_once($this->paypalDir);
		$isonline=($this->sandbox===false)?TRUE:FALSE;
		$nvpRecurring = '';
		$methodToCall = 'RefundTransaction';
		$tid=$PayPalResult['PayPalTransactionID'];
		$amount=$PayPalResult['amount'];
		$currency=!empty($PayPalResult['currency'])?$PayPalResult['currency']:'USD';
		$nvpstr = '&TRANSACTIONID=' . $tid .'&REFUNDTYPE=Partial&AMT='.$amount.'&CURRENCYCODE='.$currency.$nvpRecurring;
		$Username = $this->paypal_username;
		$APIPassword = $this->paypal_password;
		$APISignature = $this->paypal_signature;
	//	pr($nvpstr,1);

		$paypalPro = new paypal_pro($Username, $APIPassword, $APISignature, '', '', $isonline, FALSE);
		$resArray = $paypalPro->hash_call($methodToCall, $nvpstr);
		return $resArray;
	}

	function getFeebyTransactionRefund($PayPalResult){
		 require_once($this->paypalDir);
		$isonline=($this->sandbox===false)?TRUE:FALSE;
		$nvpRecurring = '';
		$methodToCall = 'GetTransactionDetails';
		$tid=$PayPalResult['PayPalTransactionID'];
		$nvpstr = '&TRANSACTIONID=' . $tid .$nvpRecurring;
		$Username = $this->paypal_username;
		$APIPassword = $this->paypal_password;
		$APISignature = $this->paypal_signature;
	//	pr($nvpstr,1);

		$paypalPro = new paypal_pro($Username, $APIPassword, $APISignature, '', '', $isonline, FALSE);
		$resArray = $paypalPro->hash_call($methodToCall, $nvpstr);
		return $resArray;

	}
	
	function getFeebyTransactionSearch($PayPalResult){
		require_once($this->paypalDir);
		$isonline=($this->sandbox===false)?TRUE:FALSE;
		$nvpRecurring = '';
		$methodToCall = 'TransactionSearch';
		$tid=$PayPalResult['PayPalTransactionID'];
		$sdate=$PayPalResult['startDate'];
		//2018-10-16T04:57:16Z
		$nvpstr = '&STARTDATE='.$sdate.'&TRANSACTIONID=' . $tid .$nvpRecurring;
		$Username = $this->paypal_username;
		$APIPassword = $this->paypal_password;
		$APISignature = $this->paypal_signature;
	//	pr($nvpstr,1);

		$paypalPro = new paypal_pro($Username, $APIPassword, $APISignature, '', '', $isonline, FALSE);
		$resArray = $paypalPro->hash_call($methodToCall, $nvpstr);
		return $resArray;
	}

	function updatePaypalOrderitem($postValue,$predetail){

		$response=array();
		$response['refundAmount']=0;
		//pr($postValue);
		//pr($predetail);
		//pr($predetail['TotalAmount']);
		//pr($postValue['TotalAmount']);
		if($predetail['TotalAmount'] > $postValue['TotalAmount']){

			if(!empty($postValue['NumLine'])){

				for($i=1;$i<=$postValue['NumLine'];$i++){

					$sql="UPDATE s_order_item SET qty='".$postValue['qty'.$i]."' , amount='".$postValue['TotalAmount']."' WHERE id='".$postValue['id'.$i]."'";
					$this->query($sql, 0);
				}
			}
				$sql="UPDATE s_order SET TotalAmount='".$postValue['TotalAmount']."' where OrderID ='".$postValue['OrderID']."'";
				$this->query($sql, 0);		

			$response['refundAmount']=$predetail['TotalAmount']-$postValue['TotalAmount'];
			
		}


			

			return $response;
	}



}


?>
