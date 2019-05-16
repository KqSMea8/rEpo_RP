<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
 <HEAD>
  <TITLE>+++++ Paypal Pro +++++</TITLE>
  <META NAME="Generator" CONTENT="Paypal Pro">
  <META NAME="Author" CONTENT="Paypal Pro">
  <META NAME="Keywords" CONTENT="Paypal Pro">
  <META NAME="Description" CONTENT="Paypal Pro">
 </HEAD>
 <BODY>
 <table border='0' width='40%' cellspacing='2' cellpadding='2' align="center">
<?php
require_once("paypal_pro.inc.php");
$firstName =urlencode( $_POST['firstName']);
$lastName =urlencode( $_POST['lastName']);
$creditCardType =urlencode( $_POST['creditCardType']);
$creditCardNumber = urlencode($_POST['creditCardNumber']);
$expDateMonth =urlencode( $_POST['expDateMonth']);
$padDateMonth = str_pad($expDateMonth, 2, '0', STR_PAD_LEFT);
$expDateYear =urlencode( $_POST['expDateYear']);
$cvv2Number = urlencode($_POST['cvv2Number']);
$address1 = urlencode($_POST['address1']);
$address2 = urlencode($_POST['address2']);
$city = urlencode($_POST['city']);
$state =urlencode( $_POST['state']);
$zip = urlencode($_POST['zip']);
$amount = urlencode($_POST['amount']);
$currencyCode="USD";



$paymentAction = urlencode("Sale");
if($_POST['recurring'] == 1) // For Recurring
{
	$profileStartDate = urlencode(date('Y-m-d h:i:s'));
	$billingPeriod = urlencode($_POST['billingPeriod']);// or "Day", "Week", "SemiMonth", "Year"
	$billingFreq = urlencode($_POST['billingFreq']);// combination of this and billingPeriod must be at most a year
	$initAmt = $amount;
	$failedInitAmtAction = urlencode("ContinueOnFailure");
	$desc = urlencode("Recurring $".$amount);
	$autoBillAmt = urlencode("AddToNextBilling");
	$profileReference = urlencode("Anonymous");
	$methodToCall = 'CreateRecurringPaymentsProfile';
	$nvpRecurring ='&BILLINGPERIOD='.$billingPeriod.'&BILLINGFREQUENCY='.$billingFreq.'&PROFILESTARTDATE='.$profileStartDate.'&INITAMT='.$initAmt.'&FAILEDINITAMTACTION='.$failedInitAmtAction.'&DESC='.$desc.'&AUTOBILLAMT='.$autoBillAmt.'&PROFILEREFERENCE='.$profileReference;
}
else
{
	$nvpRecurring = '';
	$methodToCall = 'doDirectPayment';
}

//echo $padDateMonth.$expDateYear;exit;

$nvpstr='&PAYMENTACTION='.$paymentAction.'&AMT='.$amount.'&CREDITCARDTYPE='.$creditCardType.'&ACCT='.$creditCardNumber.'&EXPDATE='.         $padDateMonth.$expDateYear.'&CVV2='.$cvv2Number.'&FIRSTNAME='.$firstName.'&LASTNAME='.$lastName.'&STREET='.$address1.'&CITY='.$city.'&STATE='.$state.'&ZIP='.$zip.'&COUNTRYCODE=US&CURRENCYCODE='.$currencyCode.$nvpRecurring;


$paypalPro = new paypal_pro('sdk-three_api1.sdk.com', 'QFZCWN5HZM8VBG7Q', 'A.d9eRKfd1yVkRrtmMfCFLTqa6M9AyodL0SJkhYztxUi8W9pCXF6.4NI', '', '', FALSE, FALSE );

#$paypalPro = new paypal_pro('parwez005_api1.gmail.com', '7GPLGKJD6HLV2JHC', 'AFcWxV21C7fd0v3bYYYRCpSSRl31Am26NvqAaekKYq.ky1YrGx1aKog-', '', '', TRUE, FALSE );  //LIVE 

#$paypalPro = new paypal_pro('parwez005-facilitator_api1.gmail.com', 'VZ8ANLYUWL5ZU5KH', 'AiPC9BjkCyDFQXbSkoZcgqH3hpacA5FK1QUvMQ5hdFo8pO4K4hkdVCmL', '', '', FALSE, FALSE );

$resArray = $paypalPro->hash_call($methodToCall,$nvpstr);
$ack = strtoupper($resArray["ACK"]);
$transactionid = $resArray['TRANSACTIONID'];
//echo '<h3>Charge</h3><pre>';print_r($resArray); 


//$transactionid = '60P86127DK898545P';
//$transactionid = '99V25776BC881071N';
/******Transaction Details************/
$nvpRecurring = '';
$methodToCall = 'GetTransactionDetails';	 
$nvpstr = '&TRANSACTIONID=' . $transactionid . $nvpRecurring;	

$paypalPro = new paypal_pro('sdk-three_api1.sdk.com', 'QFZCWN5HZM8VBG7Q', 'A.d9eRKfd1yVkRrtmMfCFLTqa6M9AyodL0SJkhYztxUi8W9pCXF6.4NI', '', '', FALSE, FALSE );

#$paypalPro = new paypal_pro('parwez005_api1.gmail.com', '7GPLGKJD6HLV2JHC', 'AFcWxV21C7fd0v3bYYYRCpSSRl31Am26NvqAaekKYq.ky1YrGx1aKog-', '', '', TRUE, FALSE );

#$paypalPro = new paypal_pro('admin_api1.virtualstacks.com', 'LFVHZUKECP9LUTTP', 'AFcWxV21C7fd0v3bYYYRCpSSRl31AkcWpUe5S.hEq6uDlWHv5umDiMF4', '', '', TRUE, FALSE );

$resArrayFee = $paypalPro->hash_call($methodToCall,$nvpstr);

echo '<h3>Charge</h3><pre>';print_r($resArrayFee); 
/**********Transaction Void/Refund*********/
//$transactionid = '0FL71630NJ928784Y';
$methodToCall = 'RefundTransaction';  //DoVoid	 
$nvpstr = '&TRANSACTIONID=' . $transactionid ;//.'&REFUNDTYPE=Partial&AMT=10&CURRENCYCODE=USD';
$paypalPro = new paypal_pro('sdk-three_api1.sdk.com', 'QFZCWN5HZM8VBG7Q', 'A.d9eRKfd1yVkRrtmMfCFLTqa6M9AyodL0SJkhYztxUi8W9pCXF6.4NI', '', '', FALSE, FALSE );

#$paypalPro = new paypal_pro('ravisolanki343-facilitator_api1.gmail.com', '1387540400', 'AW3wZm8iuG-ybETBKJ4rdHXsiN8DA4ks-a1x39Hub0-k8hl6ITLE3-53', '', '', FALSE, FALSE );

$resArrayRef = $paypalPro->hash_call($methodToCall,$nvpstr);
echo '<h3>Refund</h3><pre>';print_r($resArrayRef);exit;
/*********/

if($ack!="SUCCESS")
{


	
	echo '<tr>';
		echo '<td colspan="2" style="font-weight:bold;color:red;" align="center">Error! Please check that u will provide all information correctly :(</td>';
	echo '</tr>';
	echo '<tr>';
		echo '<td align="right">Ack:</td>';
		echo '<td>'.$resArray["ACK"].'</td>';
	echo '</tr>';
	echo '<tr>';
		echo '<td align="right">Correlation ID:</td>';
		echo '<td>'.$resArray['CORRELATIONID'].'</td>';
	echo '</tr>';
}
else
{
	echo '<tr>';
		echo '<td colspan="2" style="font-weight:bold;color:Green" align="center">Thank You For Your Payment :)</td>';
	echo '</tr>';
	echo '<tr>';
		echo '<td align="right"> Transaction ID:</td>';
		echo '<td>'.$resArray["TRANSACTIONID"].'</td>';
	echo '</tr>';
	echo '<tr>';
		echo '<td align="right"> Amount:</td>';
		echo '<td>'.$currencyCode.$resArray['AMT'].'</td>';
	echo '</tr>';
}
?>
</table>
 </BODY>
</HTML>
