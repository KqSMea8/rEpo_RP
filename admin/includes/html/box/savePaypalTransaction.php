<?php 
require_once($Prefix."lib/paypal/sdk/vendor/paypal/rest-api-sdk-php/sample/bootstrap.php");	
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
require_once($Prefix."lib/paypal/paypal_pro.inc.php");

$apiContext = getApiContext($clientId, $clientSecret);

	$refreshToken=$PaypalToken;
	
 try{
  $invoice->updateAccessToken($refreshToken, $apiContext);
}catch (Exception $ex){


}
$where=" AND OrderPaid=0";
if(!empty($refreshOrderID)){
$where=" AND OrderID='".$refreshOrderID."'";

}

$sql="Select OrderID,paypalInvoiceId,paypalInvoiceNumber,TotalAmount,CustomerCurrency FROM s_order WHERE MODULE ='Order' AND paypalInvoiceId IS NOT NULL  $where";

$responce=$objpaypalInvoice->query($sql, 1);
$processresponce=array();
$processresponce['error']=0;



	if(!empty($responce)){
		foreach($responce as $result){		
			$invoice->setId($result['paypalInvoiceId']);
		//pr($result['paypalInvoiceId']);
		 
			try{
   		 $invoice = Invoice::get($result['paypalInvoiceId'], $apiContext);
   		 //echo 'sdfsdfsd';
   		 $status=$invoice->getStatus();
		   		
			}catch (Exception $ex) {
			
			
				$processresponce['error']=1;
			}
		
		if(!empty($refreshOrderID)){
		//pr($invoice,1);
		}
    
  /*if($status=='PAID' && empty($refreshOrderID)){
	   
	      			 $transactionid=$invoice->getPayments()[0]->getTransactionId();
					  $nvpRecurring = '';
		              $methodToCall = 'GetTransactionDetails';
					  $tid=$transactionid;
					  $nvpstr = '&TRANSACTIONID=' . $tid . $nvpRecurring;
					  $Username = 	$PaymentProviderData[0]['paypalUsername'];				//'sales_api1.eoptionsonline.com';
		              $APIPassword = 	$PaymentProviderData[0]['paypalPassword'];	 //'ECPJMAX6GQP6LX89';
		              $APISignature = $PaymentProviderData[0]['paypalSignature'];//'AFcWxV21C7fd0v3bYYYRCpSSRl31A41wW5IRN8pCSZsqiIcthTuJ4CRc';
		              $isonline=true;
			         if(!empty($_GET['testmode'])){
			         	$isonline=false;
			         }

		              $paypalPro = new paypal_pro($Username, $APIPassword, $APISignature, '', '', $isonline, false);
		            
		              $resArray = $paypalPro->hash_call($methodToCall, $nvpstr);		    
		               
		 
		              
		              		$arryTr['OrderID'] = $result['OrderID'];
							$arryTr['ProviderID'] = 1;
							$arryTr['TransactionID'] = $resArray['TRANSACTIONID'];
							$arryTr['TransactionType'] = 'Invoice Payment';
							$arryTr['TotalAmount'] = $result['TotalAmount'];
							$arryTr['Currency'] = $result['CustomerCurrency'];
							$arryTr['PaymentTerm'] = 'PayPal';	
							     
	
								if(!empty($resArray['TRANSACTIONID'])){
								//	echo $IPAddress = GetIPAddress().'sdfsdfsdf';
								//echo '<br>';
								
									$objCard->SaveCardProcess($arryTr);	
								    $sql="Update s_order SET OrderPaid=1 , Fee='".$resArray['FEEAMT']."' WHERE OrderID='".$result['OrderID']."'";
									    $objpaypalInvoice->query($sql,1);	
								}
								
							
							
							
		           
	      
	    
	    }else */

	  if(in_array($status, array('PAID','REFUNDED','PARTIALLY_REFUNDED'))){

	    				$transactionid=$invoice->getPayments()[0]->getTransactionId();


	    				$sendArray=array();				
				$sendArray['PayPalTransactionID']=$transactionid;
				$sendArray['startDate']=$invoice->getPayments()[0]->date;
				$transactionData=$objpaypalInvoice->getFeebyTransactionSearch($sendArray);
				//pr($transactionData,1);
				$Totalfee=0;
				$addamount=0;
				$subamount=0;
				$numberofTransaction=0;
				foreach($transactionData as $key=>$value){					
					if(strpos($key, 'L_FEEAMT')===0){
						if($value > 0){
							$subamount += abs($value);
						}else{						
							$addamount += abs($value);
						}
					}
					if(strpos($key, 'L_TRANSACTIONID')===0){
						$numberofTransaction +=1;
					}

					
				}			
				
				$Totalfee=$addamount-$subamount;
			

			$orderPaid=0;
			$TransactionType="";
			$TransactionType="";
			if($status=='PAID'){
				$orderPaid=1;				
			}else if($status=='REFUNDED'){
				$orderPaid=2;				
			}else if($status=='PARTIALLY_REFUNDED'){
				$orderPaid=3;				
			}else if($status=='PARTIALLY_PAID'){
				$orderPaid=4;				
			}

						for($i=($numberofTransaction-1);$i>=0; $i--){

							//echo $i;
							//echo '<br/>';
							//echo $transactionData['L_TRANSACTIONID'.$i];
							$transactiondetail=$objCard->GetTransactionByTransactionID($transactionData['L_TRANSACTIONID'.$i]);


							if(empty($transactiondetail)){
								$TransactionType="";
								 
							if($transactionData['L_TYPE'.$i]){
								if($transactionData['L_TYPE'.$i]=='Payment'){
									//$orderPaid=1;
									$TransactionType="Invoice Payment";
								}else if($transactionData['L_TYPE'.$i]=='Refund'){
								//	$orderPaid=2;
									$TransactionType="Invoice Refund";
								}

							}


							$arryTr=array();
							$arryTr['OrderID'] = $result['OrderID'];
							$arryTr['ProviderID'] = 1;
							$arryTr['TransactionID'] = $transactionData['L_TRANSACTIONID'.$i];
							$arryTr['TransactionType'] = $TransactionType;
							$arryTr['TotalAmount'] =abs($transactionData['L_AMT'.$i]);
							$arryTr['Currency'] = $transactionData['L_CURRENCYCODE'.$i];
							$arryTr['PaymentTerm'] = 'PayPal';	
							$objCard->SaveCardProcess($arryTr);	
								
							}

							$sql="Update s_order SET OrderPaid='".$orderPaid."' , Fee='".$Totalfee."' WHERE OrderID='".$result['OrderID']."'";
							$objpaypalInvoice->query($sql,1);

						}

	    					$processresponce['error']=0;
	    					$processresponce['status']=2;
							


	    }else{

	    	$processresponce['error']=0;
	    	$processresponce['status']=1;
	    }

		
		}
		
		}
		
	
?>
