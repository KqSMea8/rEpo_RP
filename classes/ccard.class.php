<?

class card extends dbClass
{ 

	var $tables;	
	 
	function card(){
		global $configTables;
		$this->tables=$configTables;
		$this->dbClass();
	}

	function ProcessSaleCreditCard($OrderID,$ProviderID,$PartialAmount=0){
		global $Config;
		$objSale = new sale();
		$objConfigure = new configure();
		$arryOrder = $objSale->GetSale($OrderID,'','');
		if(!empty($Config['PaymentTerm'])){
			$arryOrder[0]['PaymentTerm'] = $Config['PaymentTerm'];
		} 


		if($Config['SalesInvoiceExtraCharge']==1){
			/***************************/
			if(!empty($arryOrder[0]['SaleID'])){
				$SaleOrderID = $objSale->getOrderIDBySaleID($arryOrder[0]['SaleID']);
				$arryCard = $objSale->GetSaleCreditCard($SaleOrderID);  
				$arrySalesCardTransaction = $this->GetLastSalesTransaction($SaleOrderID,'Charge',$arryOrder[0]['PaymentTerm']);
				$ProviderID = $arrySalesCardTransaction[0]['ProviderID'];
			}
			/***************************/
		}else{
			$arryCard = $objSale->GetSaleCreditCard($OrderID);
		}
		if(empty($Config['ProviderApiPath'])) $Config['ProviderApiPath'] = '../';
		
		if(!empty($arryCard[0]['CardType'])){
			 
			/***************/			
			$ArryCardTypeGL = $this->getCreditCardGlAccount($arryCard[0]['CardType']);			 
			if(empty($ArryCardTypeGL[0]['glAccount'])){
				$ErrorMsg = str_replace("[CARD_TYPE]", $arryCard[0]['CardType'], CARD_GL_MISSING);
			}
			$AccountReceivable = $objConfigure->getSettingVariable('AccountReceivable');
			$CreditCardFee = $objConfigure->getSettingVariable('CreditCardFee');	
			if(empty($AccountReceivable) || empty($CreditCardFee)){
				$ErrorMsg .= '<br>'.SELECT_GL_CARD_TYPE;	
			}			 			 
			/***************/
			if($PartialAmount>0 && $ProviderID>0){//partial payment
				$arryProvider = $this->GetProviderByID($ProviderID);
				$PaymentAmount = $PartialAmount;	
			}else{//default payment
				$arryProvider = $this->GetProviderByCard($arryCard[0]['CardType']);
				$ProviderID = $arryProvider[0]['ProviderID'];
				$PaymentAmount = $arryOrder[0]['TotalAmount'];
			}
   

			if(!empty($ProviderID) && empty($ErrorMsg)){
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
				$amount = urlencode($PaymentAmount);
				$currencyCode=$arryOrder[0]['CustomerCurrency'];
				$orderDescription = urlencode("Payment of Sales Order");
				$ReferenceNo = urlencode(($arryOrder[0]['Module']=="Invoice")?($arryOrder[0]['InvoiceID']):($arryOrder[0]['SaleID']));
				/*****************************************/
				$ProcessedFlag=0;
				 
				//echo $PartialAmount.'#'.$ProviderID;exit;

				switch($ProviderID){
					case 1: //PayPal Standard Pro
/*****************************************/
/*****************************************/
$expDateYear = substr($expDateYear,2,2);
require_once($Config['ProviderApiPath']."api/PaypalPro/paypal_pro.inc.php");
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
$expDateYear = substr($expDateYear,2,2);
require_once($Config['ProviderApiPath']."api/PaypalPayflow/paypalfunctions.php");
$paymentType = "Sale"; 
$arryTransaction = DirectPayment ( $paymentType, $amount, $creditCardType, $creditCardNumber, $expDateMonth.$expDateYear, $cvv2Number, $firstName, $lastName, $address1, $city, $state, $zip, $country, $currencyCode, $orderDescription,'' );
$MSG = $arryTransaction["RESPMSG"];
$TransactionID = $arryTransaction['PNREF'];
$TransactionIDOther = $arryTransaction['PPREF'];
if($_GET['pkp']==1){
	
	echo '<pre>'; print_r($arryTransaction);exit;
}
if($MSG=='Approved' && !empty($TransactionID)){
	$ProcessedFlag=1;
	/******Transaction Details for Fee************/
	$Fee = $this->getPaypalFee($TransactionIDOther);
	//PENDING
	if(empty($Fee)){
		$Fee = round(($amount * 2.9)/100 + 0.30,2);
	}
	/*********************/
}
/*****************************************/
/*****************************************/

						 
						break;
					case 3: //Authorize.Net

/*****************************************/
/*****************************************/
require_once($Config['ProviderApiPath']."api/Authorize.Net/config.php");
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
//echo $auth_net_url;exit;
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
}
/*****************************************/
/*****************************************/

						
						break;



				case 4: //NAB Velocity
/*****************************************/
/*****************************************/
$expDateYear = substr($expDateYear,2,2);
require_once($Config['ProviderApiPath']."api/Velocity/velocityApi.php");
$objVelocity = new Velocity($arryProvider[0]);
$arryTransaction = $objVelocity->processPayment($OrderID,$amount,$creditCardType,$creditCardNumber,$expDateMonth.$expDateYear,$cvv2Number,$firstName,$lastName,$address1,$city,$state,$zip,$country,$currencyCode,$ReferenceNo);
//echo '<pre>';print_r($arryTransaction);exit;
$TransactionID = $arryTransaction['TransactionId'];
$TransactionStatus = $arryTransaction['Status'];
$Fee = $arryTransaction['FeeAmount'];
if(!empty($TransactionID) && $TransactionStatus == 'Successful'){
	$ProcessedFlag=1;                       
	/******Transaction Details for Fee************/	 
	$Fee = round(($amount * 3)/100 ,2);	 
	/*********************/	 		
}else{
	$MSG = $arryTransaction['errors'];
	if(empty($MSG)){
		$MSG = "Transaction can't be processed.";
	}
}
//echo $MSG;exit;
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
					$arryTr['TotalAmount'] = $PaymentAmount;
					$arryTr['Fee'] = $Fee;
					$arryTr['Currency'] = $arryOrder[0]['CustomerCurrency'];
					$arryTr['PaymentTerm'] = $arryOrder[0]['PaymentTerm'];
					$arryTr['Recurring'] = $Config['Recurring'];
					$this->SaveCardProcess($arryTr);
					$ErrorMsg = str_replace("[TransactionID]", $TransactionID, CARD_PROCESSED);					
					$FinalFee = $arryOrder[0]['Fee']+$Fee;

					$sql="UPDATE s_order SET OrderPaid='1',Fee='".$FinalFee."',NextBillingFrequency='".$Config['NextBillingFrequency']."' WHERE OrderID='".$OrderID."'";
					$this->query($sql,0);	
				}else{
					$ErrorMsg = str_replace("[ErrorMSG]", $MSG, CARD_PROCESSED_FAILED);					
				}
			}else{
				if(empty($ProviderID)){
					$ErrorMsg = str_replace("[CARD_TYPE]", $arryCard[0]['CardType'], CARD_NOT_MAPPED);
				}
				
			}

			/***************/
			$_SESSION['mess_Sale'] = $ErrorMsg;
			$StatusMsg = $ProcessedFlag.'#'.$ErrorMsg;
			$sqlm="UPDATE s_order SET StatusMsg='".addslashes($StatusMsg)."' WHERE OrderID='".$OrderID."'";
		 	$this->query($sqlm,0);	
			/***************/

		}
		
		return true;
	}


 


	function  SaveCardProcess($arryTr){
		global $Config;
		extract($arryTr);
		$IPAddress = GetIPAddress();
//print_r($arryTr);exit;

		$sql = "INSERT INTO s_order_transaction SET OrderID='".$OrderID."',ProviderID='".$ProviderID."', TransactionID='".$TransactionID."', TransactionIDOther='".$TransactionIDOther."', TransactionType='".$TransactionType."', CardNumber=ENCODE('" .$CardNumber. "','".$Config['EncryptKey']."'), CardType='".$CardType."', CardHolderName='".$CardHolderName."',  TotalAmount='".$TotalAmount."', Fee='".$Fee."', Currency='".$Currency."', PaymentTerm='".$PaymentTerm."',TransactionDate='".$Config['TodayDate']."', IPAddress='".$IPAddress."', AdminID='".$_SESSION['AdminID']."' , AdminType='".$_SESSION['AdminType']."', CreditOrderID='".$CreditOrderID."', Recurring='".$Recurring."' ";
		$this->query($sql, 1);
		


		return true;
	}	
	
	function GetSalesCardTransaction($OrderID,$TransactionType,$PaymentTerm){
		global $Config;
		$strSQLQuery = "select t.*, DECODE(t.CardNumber,'". $Config['EncryptKey']."') as CardNumber , p.ProviderName  from s_order_transaction t left outer join f_payment_provider p on t.ProviderID=p.ProviderID  where t.OrderID='".$OrderID."' and t.TransactionType='".$TransactionType."'  and t.PaymentTerm='".$PaymentTerm."'"; 
		return $this->query($strSQLQuery, 1);
		
	}
	
	function GetLastSalesTransaction($OrderID,$TransactionType,$PaymentTerm){
		global $Config;
		$strSQLQuery = "select t.*, DECODE(t.CardNumber,'". $Config['EncryptKey']."') as CardNumber , p.ProviderName  from s_order_transaction t left outer join f_payment_provider p on t.ProviderID=p.ProviderID  where t.OrderID='".$OrderID."' and t.TransactionType='".$TransactionType."'  and t.PaymentTerm='".$PaymentTerm."' order by t.ID desc limit 0,1"; 
		return $this->query($strSQLQuery, 1);
		
	}

	function GetUnrefundTransaction($OrderID,$TransactionType,$PaymentTerm){
		global $Config;
		 $strSQLQuery = "select t.*, DECODE(t.CardNumber,'". $Config['EncryptKey']."') as CardNumber from s_order_transaction t   where t.OrderID='".$OrderID."' and t.TransactionType='".$TransactionType."'  and t.PaymentTerm='".$PaymentTerm."' and RefundedAmount<TotalAmount order by t.ID asc "; 
		return $this->query($strSQLQuery, 1);
		
	}

	function GetTransactionTotal($OrderID,$TransactionType,$PaymentTerm){		 
		 $strSQLQuery = "select sum(TotalAmount) as FullAmount from s_order_transaction t   where t.OrderID='".$OrderID."' and t.TransactionType='".$TransactionType."'  and t.PaymentTerm='".$PaymentTerm."' "; 
		$arryRow =  $this->query($strSQLQuery, 1);
		return $arryRow[0]['FullAmount'];
		
	}


	function GetInvoiceTransactionBySaleID($SaleID,$TransactionType,$PaymentTerm){
		if(!empty($SaleID)){
			 $strSQLQuery = "select sum(t.TotalAmount) as FullAmount from s_order_transaction t inner join s_order o on t.OrderID=o.OrderID   where o.Module='Invoice' and o.SaleID='".$SaleID."' and t.TransactionType='".$TransactionType."'  and t.PaymentTerm='".$PaymentTerm."' "; 
			$arryRow =  $this->query($strSQLQuery, 1);
			return $arryRow[0]['FullAmount'];
		}
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
		global $Config;
		$arryProvider = $this->GetProviderByID(1);
		if(empty($Config['ProviderApiPath'])) $Config['ProviderApiPath'] = '../';

		if(!empty($arryProvider[0]['paypalUsername']) && !empty($arryProvider[0]['paypalPassword']) && !empty($arryProvider[0]['paypalSignature'])){
			require_once($Config['ProviderApiPath']."api/PaypalPro/paypal_pro.inc.php");		
			
			
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


	function VoidSaleCreditCard($OrderID, $PartialAmount=0){
		global $Config;
		$objSale = new sale(); 
		$PaymentTerm = 'Credit Card';	
		$arryOrder = $objSale->GetSale($OrderID,'','');
		$arryCard = $objSale->GetSaleCreditCard($OrderID);	 
		$arryCardTransaction = $this->GetUnrefundTransaction($OrderID,'Charge',$PaymentTerm);
	
		if(empty($arryCardTransaction[0]['ID'])){
			if($arryOrder[0]['Module']=='Invoice' && !empty($arryOrder[0]['SaleID'])){
				$SaleOrderID = $objSale->getOrderIDBySaleID($arryOrder[0]['SaleID']);
				if($SaleOrderID>0){
					$arryCard = $objSale->GetSaleCreditCard($SaleOrderID);	 
					$arryCardTransaction = $this->GetUnrefundTransaction($SaleOrderID,'Charge',$PaymentTerm);
				}
			}
		}

	

	 	foreach($arryCardTransaction as $key => $values) {//Start Loop	
			/**************************/		
			if($PartialAmount>0){ //Partial Refund
				$MainRefundAmount = ($Processing==1)?($PendingAmount):($PartialAmount);
			}else{  //Full Refund
				$MainRefundAmount = $values['TotalAmount'];
			}
			if($MainRefundAmount<=0){break;}

			$Processing = 1;
			$Balance = $values['TotalAmount'] - $values['RefundedAmount'];
			if($MainRefundAmount<=$Balance){
				$PendingAmount = 0;
				$AmountToRefund = $MainRefundAmount;	
			}else{
				$PendingAmount = $MainRefundAmount - $Balance;
				$AmountToRefund = $Balance; 
			}
			/**************************/	
		 

		if(!empty($values['CardType']) && !empty($values['CardNumber']) && !empty($values['TransactionID'])  && !empty($values['ProviderID'])){			
			$arryProvider = $this->GetProviderByID($values['ProviderID']);  
			
			/*****************************************/
			$CardNumber = str_replace("-","",$values['CardNumber']);
			$CustomerNameArry = explode(" ",$values['CardHolderName']);

			$firstName =urlencode($CustomerNameArry[0]);
			$lastName =urlencode($CustomerNameArry[1]);
			$creditCardType =urlencode($values['CardType']);
			$creditCardNumber = urlencode($CardNumber);	
			$expDateMonth =urlencode($arryCard[0]['ExpiryMonth']);				 
			$expDateYear =urlencode($arryCard[0]['ExpiryYear']);						
			$amount = urlencode($AmountToRefund);
			$currencyCode=$values['Currency'];			 
			/*****************************************/
			 $ProcessedFlag=0;
			switch($values['ProviderID']){
				case 1: //PayPal Standard Pro
/*****************************************/
/*****************************************/
require_once("../api/PaypalPro/paypal_pro.inc.php");
$paymentAction = urlencode("Sale");
$methodToCall = 'RefundTransaction';  

$nvpstr = '&TRANSACTIONID='.$values['TransactionID'];	

$nvpstr .= '&REFUNDTYPE=Partial&AMT='.$amount.'&CURRENCYCODE='.$currencyCode;


$paypalPro = new paypal_pro($arryProvider[0]['paypalUsername'], $arryProvider[0]['paypalPassword'], $arryProvider[0]['paypalSignature'], '', '', FALSE, FALSE );
$arryTransaction = $paypalPro->hash_call($methodToCall,$nvpstr);
//echo '<pre>';print_r($arryTransaction); exit;
$TransactionID = $arryTransaction['REFUNDTRANSACTIONID'];
$Fee = $arryTransaction['FEEREFUNDAMT'];
$GrossAmount = $arryTransaction['GROSSREFUNDAMT'];
//$RefundAmount = $arryTransaction['NETREFUNDAMT'];
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
$arryTransaction = DirectPayment ( $paymentType, $amount, $creditCardType, $creditCardNumber, $expDateMonth.$expDateYear, $cvv2Number, $firstName, $lastName, $address1, $city, $state, $zip, $country, $currencyCode, $orderDescription, $values['TransactionID']);
$MSG = $arryTransaction["RESPMSG"];
$TransactionID = $arryTransaction['PNREF'];
$TransactionIDOther = $arryTransaction['PPREF'];

$Fee = round(($amount * 2.9)/100,2);
$GrossAmount = $amount;
//$RefundAmount = $GrossAmount-$Fee;

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

$Fee = round(($amount * 2.9)/100,2);
$GrossAmount = $amount;
//$RefundAmount = $GrossAmount-$Fee;

$xml = '<?xml version="1.0"?>
<createTransactionRequest xmlns="AnetApi/xml/v1/schema/AnetApiSchema.xsd">
  <merchantAuthentication>
    <name>'.$auth_net_login_id.'</name>
    <transactionKey>'.$auth_net_tran_key.'</transactionKey>
  </merchantAuthentication>
  <refId>'.rand(999,99999999).'</refId>
  <transactionRequest>
    <transactionType>refundTransaction</transactionType>
    <amount>'.$amount.'</amount>
    <currencyCode>'.$currencyCode.'</currencyCode>
    <payment>
      <creditCard>
        <cardNumber>'.$creditCardNumber.'</cardNumber>
        <expirationDate>'.$expDateMonth.$expDateYear.'</expirationDate>
      </creditCard>
    </payment>
    <authCode>'.$values['TransactionIDOther'].'</authCode>
  </transactionRequest>
</createTransactionRequest>';
 
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$XML_URL);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/xml'));
curl_setopt($ch, CURLOPT_VERBOSE, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt($ch, CURLOPT_TIMEOUT, 0); 	
curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE); 
$info = curl_getinfo($ch);
$err = curl_error($ch); 	
curl_close($ch);
$AraryResponse = xml2array($response);
//echo '<pre>';print_r($AraryResponse);exit;
$TransactionID = $AraryResponse['createTransactionResponse']['transactionResponse']['transId']['value'];	
if(!empty($TransactionID)){
	$ProcessedFlag=1;	
}else{
	$MSG = $AraryResponse['createTransactionResponse']['transactionResponse']['errors']['error']['errorText']['value'];	
}				
						break;




				case 4: //NAB Velocity 

/*****************************************/
/*****************************************/
require_once("../api/Velocity/velocityApi.php");
$objVelocity = new Velocity($arryProvider[0]);
$arryTransaction = $objVelocity->voidPayment($values['TransactionID']);

$TransactionID = $arryTransaction['TransactionId'];
$TransactionStatus = $arryTransaction['Status'];
//pr($arryTransaction); exit;
if(!empty($TransactionID) && $TransactionStatus == 'Successful'){
	$ProcessedFlag=1;
}else{
	$MSG = $arryTransaction['errors'];
	if(empty($MSG)){
		$MSG = "Transaction can't be voided.";
	}
}
$Fee = round(($amount * 3)/100,2);
$GrossAmount = $amount;
/*****************************************/
/*****************************************/


				break;





				}
				
				/*******************/
				if($ProcessedFlag==1){					
					$arryTr['OrderID'] = $OrderID;
					$arryTr['ProviderID'] = $values['ProviderID'];
					$arryTr['TransactionID'] = $TransactionID;
					$arryTr['TransactionIDOther'] = $TransactionIDOther;
					$arryTr['TransactionType'] = 'Void';
					$arryTr['CardNumber'] = $values['CardNumber'];
					$arryTr['CardType'] = $values['CardType'];
					$arryTr['CardHolderName'] = $values['CardHolderName'];
					$arryTr['TotalAmount'] = $AmountToRefund;
					$arryTr['Fee'] = $Fee;  //not needed in refund
					$arryTr['Currency'] = $currencyCode;
					$arryTr['PaymentTerm'] = $PaymentTerm;
					$arryTr['CreditOrderID'] = $Config["CreditOrderID"];
					$this->SaveCardProcess($arryTr);
					//$ErrorMsg = str_replace("[TransactionID]", $TransactionID, CARD_VOIDED);					
					
					$FinalFee = $arryOrder[0]['Fee']-$Fee; //fee not refunded
					$sql="UPDATE s_order SET Fee='".$FinalFee."' WHERE OrderID='".$OrderID."'";
					$this->query($sql,0);

					$sqltr = "update s_order_transaction set RefundedAmount=RefundedAmount+".$AmountToRefund." where ID='".$values['ID']."'"; 
					$this->query($sqltr,0);

					$TotalRefundedProcess += $AmountToRefund;
				}else{

					$_SESSION['mess_error_sale'] = str_replace("[ErrorMSG]", $MSG, CARD_VOID_FAILED); 		 
					break;
				}
			 
			
		  }
		} //End foreach

		
		/*****************/
		$TotalCharge = $this->GetTransactionTotal($OrderID,'Charge',$PaymentTerm);
		$TotalRefund = $this->GetTransactionTotal($OrderID,'Void',$PaymentTerm);
		if($TotalCharge<=$TotalRefund && $TotalRefund>0){
			$sql="UPDATE s_order SET OrderPaid='2',Fee='0' WHERE OrderID='".$OrderID."'";
			$this->query($sql,0);
		}
		if($TotalCharge>=$TotalRefund && $TotalRefund>0){ //BalanceAmount
			$ChargeAmnt = $TotalCharge - $TotalRefund;
			$BalanceAmount = $arryOrder[0]['TotalAmount'] - $ChargeAmnt;
			$sql2="UPDATE s_order SET BalanceAmount='".$BalanceAmount."' WHERE OrderID='".$OrderID."'";
			$this->query($sql2,0);
		}


		if($Config["CreditOrderID"]>0 && $TotalRefund>0){ //credit memo refund
			$CreditRefund = ($TotalRefund>=$TotalCharge)?(2):(3);
			$sqlc="UPDATE s_order SET OrderPaid='".$CreditRefund."' WHERE OrderID='".$Config["CreditOrderID"]."'";
			$this->query($sqlc,0);
		}

		/*****************/
		if($TotalRefundedProcess>0){
			$_SESSION['mess_Sale'] = str_replace("[RefundedAmount]", number_format($TotalRefundedProcess,2), CARD_REFUNDED);			
		}
		/*****************/

		/***************/
		if(!empty($_SESSION['mess_error_sale'])){
			$_SESSION['mess_Sale'] = $_SESSION['mess_error_sale'];		 		
		}		 
		$StatusMsg = $ProcessedFlag.'#'.$_SESSION['mess_Sale'];
		$sqlm="UPDATE s_order SET StatusMsg='".addslashes($StatusMsg)."' WHERE OrderID='".$OrderID."'";
	 	$this->query($sqlm,0);	
		/***************/
 

		return true;
	}

/*****************************************/
/*************9 Jan 2017*******************/


	function getCreditCardGlAccount($CardType){
		$strSQLQuery = "select p.ProviderID, p.AccountPaypal, p.AccountPaypalFee, p.VisaGL , p.MasterCardGL, p.DiscoverGL, p.AmexGL, p.CardType from f_payment_provider p where CardType  like '%".$CardType."%' order by p.ProviderID desc limit 0,1";		 
		$arryRow = $this->query($strSQLQuery, 1);
		$arryRow[0]['glAccount']=0;
		if(!empty($arryRow[0]['ProviderID']) && !empty($arryRow[0]['CardType'])){	
			switch($CardType){
				case 'Visa': $arryRow[0]['glAccount'] = $arryRow[0]['VisaGL'];  break;
				case 'MasterCard': $arryRow[0]['glAccount'] = $arryRow[0]['MasterCardGL'];  break;
				case 'Discover': $arryRow[0]['glAccount'] = $arryRow[0]['DiscoverGL'];  break;
				case 'Amex': $arryRow[0]['glAccount'] = $arryRow[0]['AmexGL'];  break;
			}
		}	
		return $arryRow;
	
	}




	/*****************************************/
	/*****************************************/

	function salesOrderCardRecurring()
	{
	
		global $Config;
		$Config['CronEntry']=1;
		$Config['Recurring']=1;
		$arryDate = explode(" ", $Config['TodayDate']);

		$arryDay = explode("-", $arryDate[0]);
		$Month = (int)$arryDay[1];
		$Day = $arryDay[2];	
		$Din = date("l",strtotime($arryDate[0]));
		$objSale = new sale();	


		$strSQLQuery = "select o.* from s_order o where Module in ('Order') and RecurringOption='Yes' and BillingFrequency>NextBillingFrequency  order by o.OrderID desc";
			
		$GerOrderarry = $this->query($strSQLQuery, 1);
			
		// pr($GerOrderarry);exit;
		   
		for($i=0;$i<sizeof($GerOrderarry);$i++){
		
			$OrderID=$GerOrderarry[$i]['OrderID'];
			$arryCard = $objSale->GetSaleCreditCard($OrderID);

			if(!empty($arryCard[0]['CardType'])){
				$arryProvider = $this->GetProviderByCard($arryCard[0]['CardType']);
				$ProviderID = $arryProvider[0]['ProviderID'];


				$TotalAmount=$GerOrderarry[$i]['TotalAmount'];
				$RecurringOption=$GerOrderarry[$i]['RecurringOption'];
				$RecurringDate=$GerOrderarry[$i]['RecurringDate'];
				$BillingPeriod=$GerOrderarry[$i]['BillingPeriod'];
				$BillingFrequency=$GerOrderarry[$i]['BillingFrequency'];
				$NextBillingFrequency=$GerOrderarry[$i]['NextBillingFrequency'];
				$Config['NextBillingFrequency'] = $NextBillingFrequency;

				$LastEntry=$GerOrderarry[$i]['LastEntry'];


				$partial_amt=$TotalAmount/$BillingFrequency;

				$paymentAction = urlencode("Sale");

				$RecurringDate=$GerOrderarry[$i]['RecurringDate'];

				$partial_amt=round($partial_amt,2);
			// echo $OrderID.'#'.$ProviderID.'#'.$partial_amt; exit;
				if($BillingFrequency>=$NextBillingFrequency && $RecurringDate>0 && $ProviderID>0) { 
		 			if($NextBillingFrequency>0){
						 $strQuery="SELECT DATE_ADD('".$RecurringDate."', INTERVAL $NextBillingFrequency $BillingPeriod) as Nextdate";
						 $arryGetDate = $this->myquery($strQuery, 1);
								
					}

					if(($arryGetDate[0]['Nextdate']==$arryDate[0]) || ($RecurringDate==$arryDate[0] && $NextBillingFrequency==0))
					{			
						$Config['NextBillingFrequency']=$NextBillingFrequency+1;	
						$this->ProcessSaleCreditCard($OrderID,$ProviderID,$partial_amt);
						
						
					

					}

				}

	
			}
		} //end for 
	}


	/*****************************************/
	/*****************************************/
	function  GetCreditCard($OrderID){
		global $Config;
		$strSQLQuery = "select c.*, DECODE(c.CardNumber,'". $Config['EncryptKey']."') as CardNumber  from s_order_card c where c.OrderID='".$OrderID."' and c.CardNumber!='' and c.CardType!=''";			
		return $this->query($strSQLQuery, 1);
	}
	/*****************************************/
	/*****************************************/
	function ChargeCardOnOrder(){	
		global $Config;
		$objConfigure = new configure();
		$objReport = new report();

		$Config['CronEntry']=1;		
		$arryDate = explode(" ", $Config['TodayDate']);	
		$arryDay = explode("-", $arryDate[0]);
		$Day = $arryDay[2];

		$strSQLQuery = "select o.* from s_order o where Module in ('Invoice') and CardCharge='1' and CardChargeDate='".$Day."' and PostToGL != '1' and EntryBy='C' and OrderPaid='0'  order by o.OrderID asc";			
		$arryRow = $this->query($strSQLQuery, 1);		
		
 		//pr($arryRow);exit;
		/*******************/		
		$AccountReceivable = $objConfigure->getSettingVariable('AccountReceivable');
		$InventoryAR = $objConfigure->getSettingVariable('InventoryAR');
		$SalesAccount = $objConfigure->getSettingVariable('Sales');
		$CostOfGoods = $objConfigure->getSettingVariable('CostOfGoods');
		$FreightAR = $objConfigure->getSettingVariable('FreightAR');
		$SalesTaxAccount = $objConfigure->getSettingVariable('SalesTaxAccount');
		$PostToGLDate = $arryDate[0];
		if(empty($AccountReceivable) || empty($InventoryAR) || empty($SalesAccount) || empty($CostOfGoods)){
			$ErrorMSGPostToGl  = SELECT_GL_AR_ALL;
		}
		if($AccountReceivable>0 && $AccountReceivable == $SalesAccount){
			$ErrorMSGPostToGl  = SAME_GL_SELECTED_AR;
		}
		/*******************/
		

		for($i=0;$i<sizeof($arryRow);$i++){	
				
			$OrderID=$arryRow[$i]['OrderID'];
			$this->ProcessSaleCreditCard($OrderID,'','');	
			$TotalCharge = $this->GetTransactionTotal($OrderID,'Charge','Credit Card');
			//echo 'a #'.$_SESSION['mess_Sale'].' : '.$arryRow[$i]['InvoiceID'];exit;
			 if($TotalCharge>0){
				$strSQL = "update s_order set BalanceAmount='0' where OrderID=".$OrderID.""; 	
				$this->query($strSQL, 0);

				if(empty($ErrorMSGPostToGl)){ 
					unset($arryPostData);
					$arryPostData['AccountReceivable'] = $AccountReceivable;
					$arryPostData['InventoryAR'] = $InventoryAR;
					$arryPostData['FreightAR'] = $FreightAR;
					$arryPostData['SalesAccount'] = $SalesAccount;
					$arryPostData['CostOfGoods'] = $CostOfGoods;		 
					$arryPostData['SalesTaxAccount'] = $SalesTaxAccount;	
					$arryPostData['PostToGLDate'] = $PostToGLDate;
					$objReport->SoInvoicePostToGL($OrderID,$arryPostData);	
					//echo '<br>Posted '.$OrderID; 
				}
			}
			
			
		}
		//exit; //temp
	}
	/*****************************************/
	/*****************************************/	
	function  VoidReverseOrderTransaction($OrderID,$PaymentTerm){
		global $Config;
		$objSale = new sale();
 		$Date = $Config['TodayDate'];
		$ipaddress = GetIPAddress(); 	
		if($OrderID>0){
			$arryCardTransaction = $objSale->GetSalesTransaction($OrderID,$PaymentTerm);
			$VoidAmount = $arryCardTransaction[0]['TotalAmount'];		
			$OriginalAmount = $VoidAmount;
			$VoidFee = $arryCardTransaction[0]['Fee'];
			$OriginalFee = $VoidFee;
			
			if($arryCardTransaction[0]["TransactionType"]=="Void" && $VoidAmount>0){
				$ReverseTransaction=1;	
			}
		}

 
		if($ReverseTransaction==1){
			 $strSQLQuery = "SELECT s.* from s_order s where s.OrderID = '".trim($OrderID)."' and PostToGL = '1'";
			$arryRow = $this->query($strSQLQuery, 1);

			if($Config["CreditOrderID"]>0){
				$strSQLQ = "SELECT s.CreditID from s_order s where s.OrderID = '".trim($Config["CreditOrderID"])."' ";
				$arryCredit = $this->query($strSQLQ, 1);
				$ReferenceNo = $arryCredit[0]["CreditID"].' - '.$arryRow[0]["InvoiceID"];
			}else{
				$ReferenceNo = $arryRow[0]["InvoiceID"];
			}
		
			
			if(!empty($arryRow[0]["InvoiceID"])){
				/********Void Amount Reverse***********/
				$strSql = "select p.* from f_payments p where OrderID='".$arryRow[0]["OrderID"]."' and InvoiceID='".$arryRow[0]["InvoiceID"]."' and ReferenceNo='".$arryRow[0]['InvoiceID']."' and  CustID = '".$arryRow[0]['CustID']."' and PaymentType='Sales' and PostToGL='Yes' "; 
				$arryDebit = $this->query($strSql, 1);
					
				if(!empty($arryDebit[0]['AccountID'])){					
					$strSql2 = "select p.* from f_payments p where PID='".$arryDebit[0]["PaymentID"]."'  "; 
					$arryCredit = $this->query($strSql2, 1);
					$DebitAccount = $arryDebit[0]['AccountID'];
					$CreditAccount = $arryCredit[0]['AccountID'];

					if($DebitAccount>0 && $CreditAccount>0){
						/**************************/
						$ConversionRate = $arryCredit[0]['ConversionRate'];
						if(empty($ConversionRate))$ConversionRate = 1;
						
						if($arryCredit[0]["ModuleCurrency"]!=$Config['Currency']){		
							$VoidAmount = round(GetConvertedAmount($ConversionRate, $VoidAmount),2);
							
						}			
						
						$ReferenceNoVal = $ReferenceNo.' [Void]';
						/*****Debit Payment*****/
					        $strSQLQuery = "INSERT INTO f_payments SET  ConversionRate = '".$ConversionRate."', OrderID = '".$OrderID."', CustID = '".$arryDebit[0]['CustID']."', CustCode = '".$arryDebit[0]['CustCode']."', SaleID = '".$arryDebit[0]['SaleID']."', InvoiceID='".$arryDebit[0]['InvoiceID']."', DebitAmnt = ENCODE('" .$VoidAmount. "','".$Config['EncryptKey']."'), CreditAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), AccountID = '".$CreditAccount."',  ReferenceNo = '".addslashes($ReferenceNoVal)."', PaymentDate = '".$Date."', Method= '".addslashes($arryDebit[0]['Method'])."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='Sales',IPAddress='".$ipaddress."', CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."', AdminID = '". $_SESSION['AdminID']."', AdminType = '". $_SESSION['AdminType']."', ModuleCurrency = '".$arryDebit[0]['ModuleCurrency']."' , OriginalAmount=ENCODE('".$OriginalAmount. "','".$Config['EncryptKey']."'), TransactionType='D' , PostToGL='Yes',PostToGLDate = '".$Date."'";
					        $this->query($strSQLQuery, 0);
					        $PID = $this->lastInsertId(); 
						/*****Credit Payment*****/
					        $strSQLQuery2 = "INSERT INTO f_payments SET PID='".$PID."', ConversionRate = '".$ConversionRate."', CreditAmnt = ENCODE('" .$VoidAmount. "','".$Config['EncryptKey']."'), DebitAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), AccountID = '".$DebitAccount."',  CustID = '".$arryDebit[0]['CustID']."', CustCode = '".$arryDebit[0]['CustCode']."',  ReferenceNo = '".addslashes($ReferenceNoVal)."', PaymentDate = '".$Date."',Method= '".addslashes($arryDebit[0]['Method'])."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='Sales', Flag =1, IPAddress='".$ipaddress."' , CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."', AdminID = '". $_SESSION['AdminID']."', AdminType = '". $_SESSION['AdminType']."', ModuleCurrency = '".$arryDebit[0]['ModuleCurrency']."' , OriginalAmount=ENCODE('".$OriginalAmount. "','".$Config['EncryptKey']."'), TransactionType='C' , PostToGL='Yes',PostToGLDate = '".$Date."'" ;
					        $this->query($strSQLQuery2, 0);
						 
					}
					
				   /*****************************/
				}

				/********Void Fee Reverse***********/
				if($VoidFee>0){
					$DebitAccount='';$CreditAccount='';
					$JournalMemo = $PaymentTerm.'-'.$arryRow[0]['InvoiceID'];
					$strSQL = "select JournalID,JournalNo from f_gerenal_journal where JournalMemo='".$JournalMemo."' and PostToGL = 'Yes' ";
					$arryJor = $this->query($strSQL, 1);	
					if(!empty($arryJor[0]["JournalNo"])){
						$strSql = "select p.* from f_payments p where JournalID='".$arryJor[0]["JournalID"]."' and ReferenceNo='".$arryJor[0]["JournalNo"]."' and PaymentType='Journal Entry' and PostToGL='Yes' order by PaymentID asc"; 
						$arryJorTran = $this->query($strSql, 1);

						if($arryJorTran[0]["TransactionType"]=="D"){
							$DebitAccount = $arryJorTran[0]['AccountID'];
							$CreditAccount = $arryJorTran[1]['AccountID'];
						}else{
							$DebitAccount = $arryJorTran[1]['AccountID'];
							$CreditAccount = $arryJorTran[0]['AccountID'];
						}
						
					if($DebitAccount>0 && $CreditAccount>0){
						$ConversionRate = $arryRow[0]['ConversionRate'];
						if(empty($ConversionRate))$ConversionRate = 1;
 
						if($arryRow[0]["CustomerCurrency"]!=$Config['Currency']){		
							$VoidFee = round(GetConvertedAmount($ConversionRate, $VoidFee),2);
							
						}
						$ReferenceNoVal = $ReferenceNo.' - '.$arryJor[0]["JournalNo"].' [Void]';
						/*****Debit Payment*****/
					        $strSQLQuery = "INSERT INTO f_payments SET   JournalID='".$arryJorTran[0]['JournalID']."', AccountID='".$CreditAccount."', DebitAmnt = ENCODE('".$VoidFee."','".$Config['EncryptKey']."'), CreditAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), ReferenceNo = '".$ReferenceNoVal."', PaymentDate = '".$Date."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='Journal Entry', PostToGL='Yes',PostToGLDate = '".$Date."',  CreatedDate = '".$Date."' ,UpdatedDate='". $Date."', IPAddress='".$ipaddress."'  , AdminID = '". $_SESSION['AdminID']."', AdminType = '". $_SESSION['AdminType']."' , ModuleCurrency = '".$arryJorTran[0]['ModuleCurrency']."', ConversionRate = '".$arryJorTran[0]['ConversionRate']."' , OriginalAmount=ENCODE('".$OriginalFee. "','".$Config['EncryptKey']."'), TransactionType='D' ";			
					        $this->query($strSQLQuery, 0);
					        $PID = $this->lastInsertId(); 
						/*****Credit Payment*****/
					        $strSQLQuery2 = "INSERT INTO f_payments SET  JournalID='".$arryJorTran[0]['JournalID']."', AccountID='".$DebitAccount."', DebitAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), CreditAmnt = ENCODE('".$VoidFee."','".$Config['EncryptKey']."'),  ReferenceNo = '".$ReferenceNoVal."', PaymentDate = '".$Date."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='Journal Entry', PostToGL='Yes',PostToGLDate = '".$Date."', CreatedDate = '".$Date."',UpdatedDate='". $Date."', IPAddress='".$ipaddress."'  , AdminID = '". $_SESSION['AdminID']."', AdminType = '". $_SESSION['AdminType']."' , ModuleCurrency = '".$arryJorTran[0]['ModuleCurrency']."' , ConversionRate = '".$arryJorTran[0]['ConversionRate']."' , OriginalAmount=ENCODE('".$OriginalFee. "','".$Config['EncryptKey']."'), TransactionType='C' ";
					        $this->query($strSQLQuery2, 0);
						  
						}





					}
				} 
		
				/***********************************/
			}
		}

		
	}
	/*****************************************/
}
?>
