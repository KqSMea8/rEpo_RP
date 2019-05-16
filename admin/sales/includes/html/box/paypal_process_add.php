<? 
   if(!empty($_POST['paypalemail']) AND $_POST['PaymentTerm']=='PayPal'){
	  $_POST['OrderID']=$order_id;
	//  $responce=$objpaypalInvoice->CreatePaypalInvoice($_POST);
/**** Paypal Invoice Create*********/
		  $responce=array();
  $PaymentProviderData=$objpaypalInvoice->GetPaymentProvider(1);	
		if(!empty($PaymentProviderData[0]['PaypalToken'])){
				$paypalUsername=$PaymentProviderData[0]['paypalID'];
				$PaypalToken=$PaymentProviderData[0]['PaypalToken'];
				require_once($Prefix."admin/includes/html/box/paypalInvoiceSave.php");
		}else{
		$_SESSION['mess_Sale'] .= '<br>Invalid Paypal Token. <br>Please setup this under Payment Provider of Finance Settings.';
}
if($_GET['ravi']==6){
	pr($responce);
}

	  if($responce['success']==1){						  
	   $sql="Update s_order SET paypalInvoiceId='".$responce['InvoiceID']."' , paypalInvoiceNumber='".$responce['InvoiceNumber']."' WHERE OrderID='".$order_id."'";
	   $objpaypalInvoice->query($sql);
		// save in transaction
		$arryTr['OrderID'] = $order_id;
		$arryTr['ProviderID'] = 1;
		$arryTr['TransactionID'] = $responce['InvoiceID'];
		$arryTr['TransactionType'] = 'Invoice';
		$arryTr['TotalAmount'] = $_POST['TotalAmount'];
		$arryTr['Currency'] = $_POST['CustomerCurrency'];
		$arryTr['PaymentTerm'] = 'PayPal';
		$objCard->SaveCardProcess($arryTr);



		$_SESSION['mess_Sale'] .= '<br>Paypal invoice has been generated and email has been sent to customer.';
	  }else{
		$_SESSION['mess_Sale'] .= '<br>Invalid Paypal Credentials : '.$responce['errors'][0].'<br>Please setup this under Payment Provider of Finance Settings.';
	  }


	  if($_GET['ravi']==6){
	  	echo $_SESSION['mess_Sale'];

die('die');

	  }
	//echo '<pre>';print_r($responce['errors']);exit;
  }
?>
