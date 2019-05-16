<?

class card extends dbClass
{ 

	var $tables;	
	 
	function card(){
		global $configTables;
		$this->tables=$configTables;
		$this->dbClass();
	}

	function ProcessSaleCreditCard($OrderID){
		global $Config;
		$objSale = new sale();
		$arryCard = $objSale->GetSaleCreditCard($OrderID);
		$arryOrder = $objSale->GetSale($OrderID,'','');
		
		if(!empty($arryCard[0]['CardType'])){			
			$arryProvider = $this->GetProviderByCard($arryCard[0]['CardType']);
			$ProviderID = $arryProvider[0]['ProviderID'];
			if(!empty($ProviderID)){
				$Fee=0;
				/*****************************************/
				$CardNumber = str_replace("-","",$arryCard[0]['CardNumber']);
				$CustomerNameArry = explode(" ",$arryCard[0]['CardHolderName']);

				$firstName =urlencode($CustomerNameArry[0]);
				$lastName =urlencode($CustomerNameArry[1]);
				$creditCardType =urlencode($arryCard[0]['CardType']);
				$creditCardNumber = urlencode($CardNumber);
				$expDateMonth =urlencode($arryCard[0]['ExpiryMonth']);				 
				$expDateYear =urlencode($arryCard[0]['ExpiryYear']);
				$cvv2Number = urlencode($arryCard[0]['SecurityCode']);
				$address1 = urlencode($arryCard[0]['Address']);
				$address2 = urlencode('');
				$city = urlencode($arryCard[0]['City']);
				$state =urlencode($arryCard[0]['State']);
				$country = urlencode($arryCard[0]['Country']);
				$zip = urlencode($arryCard[0]['ZipCode']);				
				$amount = urlencode($arryOrder[0]['TotalAmount']);
				$currencyCode=$arryOrder[0]['CustomerCurrency'];
				$orderDescription = urlencode("Payment of Sales Order");
				/*****************************************/
				 
				switch($ProviderID){
					case 1: //PayPal Standard Pro
/*****************************************/
/*****************************************/
require_once("../api/PaypalPro/paypal_pro.inc.php");
$paymentAction = urlencode("Sale");
$nvpRecurring = '';
$methodToCall = 'doDirectPayment';

$nvpstr='&PAYMENTACTION='.$paymentAction.'&AMT='.$amount.'&CREDITCARDTYPE='.$creditCardType.'&ACCT='.$creditCardNumber.'&EXPDATE='.$expDateMonth.$expDateYear.'&CVV2='.$cvv2Number.'&FIRSTNAME='.$firstName.'&LASTNAME='.$lastName.'&STREET='.$address1.'&CITY='.$city.'&STATE='.$state.'&ZIP='.$zip.'&COUNTRYCODE='.$country.'&CURRENCYCODE='.$currencyCode;

//echo $nvpstr;exit;
$paypalPro = new paypal_pro($arryProvider[0]['paypalUsername'], $arryProvider[0]['paypalPassword'], $arryProvider[0]['paypalSignature'], '', '', FALSE, FALSE );
$arryTransaction = $paypalPro->hash_call($methodToCall,$nvpstr);
//echo '<pre>';print_r($arryTransaction); 
$TransactionID = $arryTransaction['TRANSACTIONID'];
$ACK = $arryTransaction['ACK'];
$MSG = $arryTransaction['L_SHORTMESSAGE0'].' : '.$arryTransaction['L_LONGMESSAGE0'];
if($ACK=='Success' && !empty($TransactionID)){
	$ProcessedFlag=1;
	/******Transaction Details for Fee************/
	$Fee = $this->getPaypalFee($TransactionID);
	/*$nvpRecurring = '';
	$methodToCall = 'GetTransactionDetails';	 
	$nvpstr = '&TRANSACTIONID='.$TransactionID ;
	$paypalPro = new paypal_pro($arryProvider[0]['paypalUsername'], $arryProvider[0]['paypalPassword'], $arryProvider[0]['paypalSignature'], '', '', FALSE, FALSE );
	$resArrayFee = $paypalPro->hash_call($methodToCall,$nvpstr);
	$Fee = $resArrayFee['FEEAMT'];
	//echo '<pre>';print_r($resArrayFee);exit;
	/*********************/
} 
/*****************************************/
/*****************************************/
						break;






					case 2: //PayPal Payflow

/*****************************************/
/*****************************************/
require_once("../api/PaypalPayflow/paypalfunctions.php");
$paymentType = "Sale"; 
$arryTransaction = DirectPayment ( $paymentType, $amount, $creditCardType, $creditCardNumber, $expDateMonth.$expDateYear, $cvv2Number, $firstName, $lastName, $address1, $city, $state, $zip, $country, $currencyCode, $orderDescription,'' );
$MSG = $arryTransaction["RESPMSG"];
$TransactionID = $arryTransaction['PNREF'];
$TransactionIDOther = $arryTransaction['PPREF'];
//echo '<pre>'; print_r($arryTransaction);
if($MSG=='Approved' && !empty($TransactionID)){
	$ProcessedFlag=1;
	/******Transaction Details for Fee************/
	$Fee = $this->getPaypalFee($TransactionIDOther);
	//PENDING
	/*********************/
}
/*****************************************/
/*****************************************/

						 
						break;
					case 3: //Authorize.Net

/*****************************************/
/*****************************************/
require_once("../api/Authorize.Net/config.php");
$authnet_values	= array
(
	"x_login"			=> $auth_net_login_id,
 	"x_tran_key"			=> $auth_net_tran_key,
	"x_version"			=> $auth_version,
	"x_delim_char"			=> $auth_delim_char,
	"x_delim_data"			=> $auth_delim_data,
	"x_type"			=> "AUTH_CAPTURE",
	"x_method"			=> "CC",
	"x_Invoice_Num"			=> $arryOrder[0]['SaleID'].'_'.rand(9,999),
	"x_card_num"			=> $creditCardNumber,
	"x_exp_date"			=> $expDateMonth.$expDateYear,
	"x_description"			=> $orderDescription,
	"x_amount"			=> $amount,
	"x_currency_code"		=> $currencyCode,
	"x_Cust_ID"			=> $arryOrder[0]['CustID'],
	"x_first_name"			=> $firstName,
	"x_last_name"			=> $lastName,	
	"x_address"			=> $address1,
	"x_city"			=> $city,
	"x_state"			=> $state,
	"x_country"			=> $country,
	"x_zip"				=> $zip	
	
);
$fields = "";
foreach( $authnet_values as $key => $value ) $fields .= "$key=" . urlencode( $value ) . "&";
//echo $fields;exit;
$ch = curl_init($auth_net_url); 
curl_setopt($ch, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // Returns response data instead of TRUE(1)
curl_setopt($ch, CURLOPT_POSTFIELDS, rtrim( $fields, "& " )); // use HTTP POST to send form data
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // uncomment this line if you get no gateway response. ###
$resp = curl_exec($ch); //execute post and get results
curl_close ($ch);
//echo '<pre>';print_r($resp);exit;
	
if(!empty($resp)){
	$TestArry = explode($auth_delim_char,$resp);	
	if($TestArry[0]==1){		
		$TransactionID = $TestArry[6];
		$x_Auth_Code = $TestArry[4];
		$TransactionIDOther = $x_Auth_Code;
		if(!empty($TransactionID)){			
			$ProcessedFlag=1;
		}
	}else{
		$MSG = $TestArry[3];
	} 
}else{
	$MSG = "Transaction can't be processed.";
}	


/******Transaction Details for Fee************/
if($ProcessedFlag==1){	
	$Fee = round(($amount * 2.9)/100 + 0.30,2);
	
	// 2.9% plus $0.30
	/*
	$authnet_values	= array
	(
		"x_login"			=> $auth_net_login_id,
	 	"x_tran_key"			=> $auth_net_tran_key,
		"x_version"			=> $auth_version,
		"x_delim_char"			=> $auth_delim_char,
		"x_delim_data"			=> $auth_delim_data,
		"x_type"			=> "PRIOR_AUTH_CAPTURE",
		"x_Auth_Code"			=> $x_Auth_Code	,		
		"x_Trans_ID"			=> $TransactionID
			 
		
	);
	$fields = "";
	foreach( $authnet_values as $key => $value ) $fields .= "$key=" . urlencode( $value ) . "&";
	//echo $fields;exit;
	$ch = curl_init($auth_net_url); 
	curl_setopt($ch, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // Returns response data instead of TRUE(1)
	curl_setopt($ch, CURLOPT_POSTFIELDS, rtrim( $fields, "& " )); // use HTTP POST to send form data
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // uncomment this line if you get no gateway response. ###
	$respFee = curl_exec($ch); //execute post and get results
	curl_close ($ch);

	echo '<pre>';print_r($respFee);exit;*/



}
/*****************************************/
/*****************************************/




						
						break;
				}
				
				/*******************/
				if($ProcessedFlag==1){					
					$arryTr['OrderID'] = $OrderID;
					$arryTr['ProviderID'] = $ProviderID;
					$arryTr['TransactionID'] = $TransactionID;
					$arryTr['TransactionIDOther'] = $TransactionIDOther;
					$arryTr['TransactionType'] = 'Charge';
					$arryTr['CardNumber'] = $arryCard[0]['CardNumber'];
					$arryTr['CardType'] = $arryCard[0]['CardType'];
					$arryTr['CardHolderName'] = $arryCard[0]['CardHolderName'];
					$arryTr['TotalAmount'] = $arryOrder[0]['TotalAmount'];
					$arryTr['Fee'] = $Fee;
					$arryTr['Currency'] = $arryOrder[0]['CustomerCurrency'];
					$arryTr['PaymentTerm'] = $arryOrder[0]['PaymentTerm'];
					$this->SaveCardProcess($arryTr);
					$ErrorMsg = str_replace("[TransactionID]", $TransactionID, CARD_PROCESSED);
					$_SESSION['mess_Sale'] = $ErrorMsg;
					
					$sql="UPDATE s_order SET OrderPaid='1',Fee='".$Fee."' WHERE OrderID='".$OrderID."'";
					$this->query($sql,0);	
				}else{
					$ErrorMsg = str_replace("[ErrorMSG]", $MSG, CARD_PROCESSED_FAILED);
					$_SESSION['mess_Sale'] = $ErrorMsg;
				}
			}else{
				$ErrorMsg = str_replace("[CARD_TYPE]", $arryCard[0]['CardType'], CARD_NOT_MAPPED);
				$_SESSION['mess_Sale'] = $ErrorMsg;
			}
			
		}
		
		return true;
	}


 


	function  SaveCardProcess($arryTr){
		global $Config;
		extract($arryTr);
		$IPAddress = GetIPAddress();
//print_r($arryTr);exit;

		$sql = "INSERT INTO s_order_transaction SET OrderID='".$OrderID."',ProviderID='".$ProviderID."', TransactionID='".$TransactionID."', TransactionIDOther='".$TransactionIDOther."', TransactionType='".$TransactionType."', CardNumber=ENCODE('" .$CardNumber. "','".$Config['EncryptKey']."'), CardType='".$CardType."', CardHolderName='".$CardHolderName."',  TotalAmount='".$TotalAmount."', Fee='".$Fee."', Currency='".$Currency."', PaymentTerm='".$PaymentTerm."',TransactionDate='".$Config['TodayDate']."', IPAddress='".$IPAddress."', AdminID='".$_SESSION['AdminID']."' , AdminType='".$_SESSION['AdminType']."' ";
		$this->query($sql, 1);
		


		return true;
	}	
	
	function GetSalesCardTransaction($OrderID,$TransactionType,$PaymentTerm){
		global $Config;
		$strSQLQuery = "select t.*, DECODE(t.CardNumber,'". $Config['EncryptKey']."') as CardNumber , p.ProviderName  from s_order_transaction t left outer join f_payment_provider p on t.ProviderID=p.ProviderID  where t.OrderID='".$OrderID."' and t.TransactionType='".$TransactionType."'  and t.PaymentTerm='".$PaymentTerm."'"; 
		return $this->query($strSQLQuery, 1);
		
	}
	 

	function GetProviderByCard($CardType){
		$strSQLQuery = "select * from f_payment_provider where CardType like '%".$CardType."%' and Status=1";
		return $this->query($strSQLQuery, 1);	

	}

	function GetProviderByID($ProviderID){
		$strSQLQuery = "select * from f_payment_provider where ProviderID = '".$ProviderID."' and Status=1";
		return $this->query($strSQLQuery, 1);	

	}

	function getPaypalFee($TransactionID){	
		$arryProvider = $this->GetProviderByID(1);
		if(!empty($arryProvider[0]['paypalUsername']) && !empty($arryProvider[0]['paypalPassword']) && !empty($arryProvider[0]['paypalSignature'])){
			require_once("../api/PaypalPro/paypal_pro.inc.php");		
			
			
			/*****For testing live**********
			$TransactionID='60P86127DK898545P'; //test 
			$arryProvider[0]['paypalUsername'] = 'admin_api1.virtualstacks.com';
		        $arryProvider[0]['paypalPassword'] = 'LFVHZUKECP9LUTTP';
		        $arryProvider[0]['paypalSignature'] = 'AFcWxV21C7fd0v3bYYYRCpSSRl31AkcWpUe5S.hEq6uDlWHv5umDiMF4';
			/************************/


			$nvpRecurring = '';
			$methodToCall = 'GetTransactionDetails';	 
			$nvpstr = '&TRANSACTIONID='.$TransactionID ;
			$paypalPro = new paypal_pro($arryProvider[0]['paypalUsername'], $arryProvider[0]['paypalPassword'], $arryProvider[0]['paypalSignature'], '', '', FALSE, FALSE );
			$resArrayFee = $paypalPro->hash_call($methodToCall,$nvpstr);
			//echo '<pre>';print_r($resArrayFee);exit;
			$Fee = $resArrayFee['FEEAMT'];
			return $Fee;
		}
              
	}


	function VoidSaleCreditCard($OrderID,$ProviderID){
		global $Config;
		$objSale = new sale(); 
		$PaymentTerm = 'Credit Card';	
		$arryCard = $objSale->GetSaleCreditCard($OrderID);	 
		$arryCardTransaction = $this->GetSalesCardTransaction($OrderID,'Charge',$PaymentTerm);
		//echo '<pre>';print_r($arryCardTransaction);exit;		
		if(!empty($arryCardTransaction[0]['CardType']) && !empty($arryCardTransaction[0]['CardNumber']) && !empty($arryCardTransaction[0]['TransactionID'])  && !empty($ProviderID)){			
			$arryProvider = $this->GetProviderByID($ProviderID);		 
			 
			/*****************************************/
			$CardNumber = str_replace("-","",$arryCardTransaction[0]['CardNumber']);
			$CustomerNameArry = explode(" ",$arryCardTransaction[0]['CardHolderName']);

			$firstName =urlencode($CustomerNameArry[0]);
			$lastName =urlencode($CustomerNameArry[1]);
			$creditCardType =urlencode($arryCardTransaction[0]['CardType']);
			$creditCardNumber = urlencode($CardNumber);	
			$expDateMonth =urlencode($arryCard[0]['ExpiryMonth']);				 
			$expDateYear =urlencode($arryCard[0]['ExpiryYear']);						
			$amount = urlencode($arryCardTransaction[0]['TotalAmount']);
			$currencyCode=$arryCardTransaction[0]['Currency'];			 
			/*****************************************/
			 
			switch($ProviderID){
				case 1: //PayPal Standard Pro
/*****************************************/
/*****************************************/
require_once("../api/PaypalPro/paypal_pro.inc.php");
$paymentAction = urlencode("Sale");
$methodToCall = 'RefundTransaction';  
$nvpstr = '&TRANSACTIONID=' . $arryCardTransaction[0]['TransactionID'];	
//echo $nvpstr;exit;
$paypalPro = new paypal_pro($arryProvider[0]['paypalUsername'], $arryProvider[0]['paypalPassword'], $arryProvider[0]['paypalSignature'], '', '', FALSE, FALSE );
$arryTransaction = $paypalPro->hash_call($methodToCall,$nvpstr);
//echo '<pre>';print_r($arryTransaction); exit;
$TransactionID = $arryTransaction['REFUNDTRANSACTIONID'];
$Fee = $arryTransaction['FEEREFUNDAMT'];
$GrossAmount = $arryTransaction['GROSSREFUNDAMT'];
$CurrencyCode = $arryTransaction['CURRENCYCODE'];
$RefundAmount = $arryTransaction['NETREFUNDAMT'];
$ACK = $arryTransaction['ACK'];
$MSG = $arryTransaction['L_SHORTMESSAGE0'].' : '.$arryTransaction['L_LONGMESSAGE0'];
if($ACK=='Success' && !empty($TransactionID)){
	$ProcessedFlag=1;	
} 
/*****************************************/
/*****************************************/
						break;






					case 2: //PayPal Payflow

/*****************************************/
/*****************************************/
require_once("../api/PaypalPayflow/paypalfunctions.php");
$paymentType = "Refund"; 
$arryTransaction = DirectPayment ( $paymentType, $amount, $creditCardType, $creditCardNumber, $expDateMonth.$expDateYear, $cvv2Number, $firstName, $lastName, $address1, $city, $state, $zip, $country, $currencyCode, $orderDescription, $arryCardTransaction[0]['TransactionID']);
$MSG = $arryTransaction["RESPMSG"];
$TransactionID = $arryTransaction['PNREF'];
$TransactionIDOther = $arryTransaction['PPREF'];

$Fee = $arryCardTransaction[0]['Fee'];
$GrossAmount = $arryCardTransaction[0]['TotalAmount'];
$CurrencyCode = $arryCardTransaction[0]['Currency'];
$RefundAmount = $GrossAmount-$Fee;

if($MSG=='Approved' && !empty($TransactionID)){
	$ProcessedFlag=1;	
}
/*****************************************/
/*****************************************/

						 
						break;
					case 3: //Authorize.Net

/*****************************************/
/*****************************************/
require_once("../api/Authorize.Net/config.php");

$Fee = $arryCardTransaction[0]['Fee'];
$GrossAmount = $arryCardTransaction[0]['TotalAmount'];
$CurrencyCode = $arryCardTransaction[0]['Currency'];
$RefundAmount = $GrossAmount-$Fee;

$authnet_values	= array
(
	"x_login"			=> $auth_net_login_id,
 	"x_tran_key"			=> $auth_net_tran_key,
	"x_version"			=> $auth_version,
	"x_delim_char"			=> $auth_delim_char,
	"x_delim_data"			=> $auth_delim_data,
	"x_type"			=> "CREDIT",	
	"x_card_num"			=> $creditCardNumber,	
	"x_exp_date"			=> $expDateMonth.$expDateYear,
	"x_amount"			=> $RefundAmount,
	"x_currency_code"		=> $CurrencyCode,
	"x_Trans_ID"			=> $arryCardTransaction[0]['TransactionID'],
	"x_test_request"		=> $TEST_MODE
	
);
$fields = "";
foreach( $authnet_values as $key => $value ) $fields .= "$key=" . urlencode( $value ) . "&";
$ch = curl_init($auth_net_url); 
curl_setopt($ch, CURLOPT_HEADER, 0); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, rtrim( $fields, "& " ));
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
$resp = curl_exec($ch); 
curl_close ($ch);
	
if(!empty($resp)){
	$TestArry = explode($auth_delim_char,$resp);	
	if($TestArry[0]==1){		
		$TransactionID = $TestArry[6];
		$x_Auth_Code = $TestArry[4];
		$TransactionIDOther = $x_Auth_Code;		 		
		$ProcessedFlag=1;		 
	}else{
		$MSG = $TestArry[3];
	} 
}else{
	$MSG = "Void Transaction can't be processed.";
}	


						
						break;
				}
				
				/*******************/
				if($ProcessedFlag==1){					
					$arryTr['OrderID'] = $OrderID;
					$arryTr['ProviderID'] = $ProviderID;
					$arryTr['TransactionID'] = $TransactionID;
					$arryTr['TransactionIDOther'] = $TransactionIDOther;
					$arryTr['TransactionType'] = 'Void';
					$arryTr['CardNumber'] = $arryCardTransaction[0]['CardNumber'];
					$arryTr['CardType'] = $arryCardTransaction[0]['CardType'];
					$arryTr['CardHolderName'] = $arryCardTransaction[0]['CardHolderName'];
					$arryTr['TotalAmount'] = $RefundAmount;
					$arryTr['Fee'] = $Fee;
					$arryTr['Currency'] = $CurrencyCode;
					$arryTr['PaymentTerm'] = $PaymentTerm;
					$this->SaveCardProcess($arryTr);
					$ErrorMsg = str_replace("[TransactionID]", $TransactionID, CARD_VOIDED);
					$_SESSION['mess_Sale'] = $ErrorMsg;
					
					$sql="UPDATE s_order SET OrderPaid='0',Fee='0' WHERE OrderID='".$OrderID."'";
					$this->query($sql,0);	
				}else{
					$ErrorMsg = str_replace("[ErrorMSG]", $MSG, CARD_VOID_FAILED);
					$_SESSION['mess_Sale'] = $ErrorMsg;
				}
			 
			
		}
		
		return true;
	}



}
?>
