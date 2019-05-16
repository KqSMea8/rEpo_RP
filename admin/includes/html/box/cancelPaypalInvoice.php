<?php
	require_once($Prefix."lib/paypal/sdk/vendor/paypal/rest-api-sdk-php/sample/bootstrap.php");
use PayPal\Api\CancelNotification;
	use PayPal\Api\BillingInfo;
	use PayPal\Api\Currency;
	use PayPal\Api\Invoice;
	use PayPal\Api\InvoiceAddress;
	use PayPal\Api\InvoiceItem;
	use PayPal\Api\MerchantInfo;
	use PayPal\Api\PaymentTerm;
	use PayPal\Api\ShippingInfo;
	use PayPal\Api\RefundDetail;

	
	
	
	
	$invoice = new Invoice();   
	$refreshToken =$PaypalToken;
	
			$invoice->setId($arrySale[0]['paypalInvoiceId']);	
			if($arrySale[0]['OrderPaid']==0){			
				try {
				  $invoice->updateAccessToken($refreshToken, $apiContext);
				   $notify = new CancelNotification();
					    $notify
					        ->setSubject("Past due")
					        ->setNote("Canceling invoice")
					        ->setSendToMerchant(true)
					        ->setSendToPayer(true);
					         $cancelStatus = $invoice->cancel($notify, $apiContext);
				  
				  
				} catch (Exception $ex) {
					//print_r($ex);die;
					$errors=json_decode($ex->getData());
					$responce['errors'][]=($errors->error_description)?$errors->error_description:'Paypal Invoice not cancel due to some technical problem';
			  
					}
			
			}else{	

				$res = $objCard->GetLastSalesTransaction($arrySale[0]['OrderID'],'Invoice Payment',"PayPal");	
				
				if(!empty($res[0]['TransactionID'])){
				
				try {
					    
					    
					$invoice->updateAccessToken($refreshToken, $apiContext);				
				    $refund = new RefundDetail(
				        '{
				          "date" : "'.date('Y-m-d H:i:s T').'",
				          "note" : "Refund provided by cash."
				        }'
				    );
 
					    $refundStatus = $invoice->recordRefund($refund, $apiContext);
					        $arryTr['OrderID'] = $res[0]['OrderID'];
							$arryTr['ProviderID'] = 1;
							$arryTr['TransactionID'] = $res[0]['TransactionID'];
							$arryTr['TransactionType'] = 'Invoice Refund';
							$arryTr['TotalAmount'] = $res[0]['TotalAmount'];
							$arryTr['Currency'] = 	$res[0]['Currency'];
							$arryTr['PaymentTerm'] = 'PayPal';
							$arryTr['Fee'] = $res[0]['Fee'];
							$objCard->SaveCardProcess($arryTr);		
					    
					} catch (Exception $ex) {
					    // NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
					     $errors=json_decode($ex->getData());
						 $responce['errors'][]=($errors->error_description)?$errors->error_description:'Paypal Invoice not cancel due to some technical problem';
					}
				
				}
			
			}
			
		

?>
