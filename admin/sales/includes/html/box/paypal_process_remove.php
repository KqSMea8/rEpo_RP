<? 
 /************************ refund invoice paypal******************/
$responce=array();
$PaymentProviderData=$objpaypalInvoice->GetPaymentProvider(1);
$arrySale = $objSale->GetSale($_GET['del_id'],'',$module);		
if(!empty($arrySale[0]['paypalInvoiceId'])){ 	
	if(!empty($PaymentProviderData[0]['PaypalToken'])){
		$paypalUsername=$PaymentProviderData[0]['paypalID'];
		$PaypalToken=$PaymentProviderData[0]['PaypalToken'];
		  require_once("../includes/html/box/cancelPaypalInvoice.php");
	}
}
/***************End*********/
?>
