<? 
 if($_POST['PaymentTerm']=='PayPal'){
					
	$arrySale = $objSale->GetSale($order_id,'',$module);
	$invoiceid=$arrySale[0]['paypalInvoiceId'];
		
	if(!empty($invoiceid)){
		if($arrySale[0]['OrderPaid']!=0){
			$_SESSION['mess_Sale'] = 'This sales order is already paid.';							
			header("Location:".$EditUrl);
			exit;						
		}
		$responce=array();
		$PaymentProviderData=$objpaypalInvoice->GetPaymentProvider(1);	
		
		if(!empty($PaymentProviderData[0]['PaypalToken'])){
		
			$paypalUsername=$PaymentProviderData[0]['paypalID'];
			$PaypalToken=$PaymentProviderData[0]['PaypalToken'];

			//$paypalUsername='ravisolanki343-facilitator@gmail.com';
			//$PaypalToken='sde6dGXpVp2V31ycZ6WEMbevuyiNQf-mzEquFCLRQRCs3EAeU0h5koXkOEwrkfH3SJPfcPyhxZNZzflBEJD7YWU95E-jHyJCk7JMp5sb33BcW7jHspetxOdJ7IQ';
		
			require_once($Prefix."admin/includes/html/box/paypalInvoiceUpdate.php");
		}else{
			$_SESSION['mess_Sale'] .= '<br>Invalid Paypal Token. <br>Please setup this under Payment Provider of Finance Settings.';
			header("Location:".$EditUrl);
			exit;					
		}
		if(!empty($responce['errors'])){				
			$_SESSION['mess_Sale']=$responce['errors'];
			header("Location:".$EditUrl);
			exit;	

		}	
	}		

if($_SESSION['CmpID']==37){
	//	die('Paypal');

}
}
?>
