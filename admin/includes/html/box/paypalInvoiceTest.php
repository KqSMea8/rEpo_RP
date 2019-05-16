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
	use PayPal\Api\RefundDetail;

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
	
	if(!empty($_GET['Action']) && $_GET['Action']=='VPaypal'){

		$allpayments=$invoice->getPayments();
		$allrefunds=$invoice->getRefunds();

		$totalPayamount=0;
		$totalRefundAmount=0;
		if(!empty($allpayments)){

			foreach($allpayments as $allpaymentValue){

					$totalPayamount +=$allpaymentValue->amount['value'];
			}
		}

		if(!empty($allrefunds)){

			foreach($allrefunds as $allrefundsValue){

					$totalRefundAmount +=$allrefundsValue->amount['value'];
			}
		}

		$refundamount= $totalPayamount-$totalRefundAmount;


	}
$refundamount=!empty($refundamount)?$refundamount:0;
	//echo $totalPayamount;
	//echo "<br/>";
	//echo $totalRefundAmount ;



    
// For Sample Purposes Only.
$request = clone $invoice;
try {
	//setlocale(LC_MONETARY,"en_US");
	$amoutwihoutformat=$refundamount;
	$refundamount=money_format('%i',$refundamount);
	$sendArray=array();
	$sendArray['PayPalTransactionID']=$invoice->getPayments()[0]->getTransactionId();
	$sendArray['amount']= $refundamount;
	$sendArray['currency']=$orderDetail['CustomerCurrency'];

$res=$objpaypalInvoice->updateInvoiceRefund($sendArray);
//pr($res);

							$arryTr=array();
							$arryTr['OrderID'] = $orderDetail['OrderID'];
							$arryTr['ProviderID'] = 1;
							$arryTr['TransactionID'] = $res['REFUNDTRANSACTIONID'];
							$arryTr['TransactionType'] = 'Invoice Refund';
							$arryTr['TotalAmount'] =$amoutwihoutformat;
							$arryTr['Currency'] = $orderDetail['CustomerCurrency'];
							$arryTr['PaymentTerm'] = 'PayPal';	
							
						//	pr($arryTr,1);
if($res['ACK']=='Success'){

	$objCard->SaveCardProcess($arryTr);	
				

$invoice = $invoice->get($invoiceid, $apiContext); 

$allpayments=$invoice->getPayments();
$allrefunds=$invoice->getRefunds();

//pr($allrefunds);
//	pr($allpayments);
	$totalFee=0;

				$sendArray=array();				
				$sendArray['PayPalTransactionID']=$allpayments[0]->getTransactionId();
				$sendArray['startDate']=$allpayments[0]->date;
				$transactionData=$objpaypalInvoice->getFeebyTransactionSearch($sendArray);
				
				$Totalfee=0;
				$addamount=0;
				$subamount=0;
				foreach($transactionData as $key=>$value){					
					if(strpos($key, 'L_FEEAMT')===0){
						if($value > 0){
							$subamount += abs($value);
						}else{						
							$addamount += abs($value);
						}
					}
					
				}			
				
				$Totalfee=$addamount-$subamount;
			

			$orderPaid=3;
			if(!empty($_GET['Action']) && $_GET['Action']=='VPaypal'){
				$orderPaid=2;
			}

   				$sql="Update s_order SET OrderPaid='".$orderPaid."' , Fee='".$Totalfee."' WHERE OrderID='".$orderDetail['OrderID']."'";
					$objpaypalInvoice->query($sql,1);
					$responce['success']=1;
			}else{
	$responce['success']=0;
	$responce['errors']=$res['L_LONGMESSAGE'];

			}

} catch (Exception $ex) {
	//pr($ex,1);
	
	$errors=json_decode($ex->getData());
	$responce['errors']=!empty($errors->error_description)?$errors->error_description:'some technical problem';
}


return $responce;

?>
