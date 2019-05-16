

<?php
//if(isset($_GET['sb']))
	//{

		

  require_once('../../ebay/keys.php');
	require_once('../../ebay/eBaySession.php');
	
	
	$prev_date='';
	$tdate=date("Y-m-d");
	


	if($syncOders==0)
	{
	
	//$date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');
   $prev_date = date('Y-m-d', strtotime($tdate .' -45 day'));
   
  
//$next_date = date('Y-m-d', strtotime($date .' +1 day'));	
	}
	else
	{
		$prev_date='2015-01-01';
	}


   $fdate=$_GET['f'];




//SiteID must also be set in the Request's XML
//SiteID = 0  (US) - UK = 3, Canada = 2, Australia = 15, ....
//SiteID Indicates the eBay site to associate the call with
$siteID = 0;
//the call being made:
$verb = 'GetOrders';

//Time with respect to GMT
//by default retreive orders in last 30 minutes
//$CreateTimeFrom = gmdate("Y-m-d\TH:i:s",time()-1800); //current time minus 30 minutes
//$CreateTimeTo = gmdate("Y-m-d\TH:i:s");

$CreateTimeFrom = gmdate("2015-01-01T20:34:44.000Z",time()-1800); //current time minus 30 minutes
$CreateTimeTo = gmdate("2016-12-01T20:34:44.000Z");



//If you want to hard code From and To timings, Follow the below format in "GMT".
//$CreateTimeFrom = YYYY-MM-DDTHH:MM:SS; //GMT
//$CreateTimeTo = YYYY-MM-DDTHH:MM:SS; //GMT


///Build the request Xml string
$requestXmlBody = '<?xml version="1.0" encoding="utf-8" ?>';
$requestXmlBody .= '<GetOrdersRequest xmlns="urn:ebay:apis:eBLBaseComponents">';
$requestXmlBody .= '<DetailLevel>ReturnAll</DetailLevel>';
//$requestXmlBody .= "<CreateTimeFrom>2015-12-25</CreateTimeFrom><CreateTimeTo>$tdate</CreateTimeTo>";
$requestXmlBody .= "<CreateTimeFrom>".$prev_date."</CreateTimeFrom><CreateTimeTo>".$tdate."</CreateTimeTo>";
$requestXmlBody .= '<OrderRole>Seller</OrderRole><OrderStatus>All</OrderStatus>';
$requestXmlBody .= "<RequesterCredentials><eBayAuthToken>$userToken</eBayAuthToken></RequesterCredentials>";
$requestXmlBody .= '</GetOrdersRequest>';



//Create a new eBay session with all details pulled in from included keys.php
$session = new eBaySession($userToken, $devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $verb);

//send the request and get response
//echo $requestXmlBody;exit;
$responseXml = $session->sendHttpRequest($requestXmlBody);


if (stristr($responseXml, 'HTTP 404') || $responseXml == '')
    die('<P>Error sending request');

//Xml string is parsed and creates a DOM Document object
$responseDoc = new DomDocument();
$responseDoc->loadXML($responseXml);


//get any error nodes
$errors = $responseDoc->getElementsByTagName('Errors');
$response = simplexml_import_dom($responseDoc);

//echo "<pre>";print_r($response);
die;


$entries = $response->PaginationResult->TotalNumberOfEntries;

//if there are error nodes
if ($errors->length > 0) 
	{
    echo '<P><B>eBay returned the following error(s):</B>';
    //display each error
    //Get error code, ShortMesaage and LongMessage
    $code = $errors->item(0)->getElementsByTagName('ErrorCode');
    $shortMsg = $errors->item(0)->getElementsByTagName('ShortMessage');
    $longMsg = $errors->item(0)->getElementsByTagName('LongMessage');
    
    //Display code and shortmessage
    echo '<P>', $code->item(0)->nodeValue, ' : ', str_replace(">", "&gt;", str_replace("<", "&lt;", $shortMsg->item(0)->nodeValue));
    $EditUrl = "viewOrder.php";
					   
		$EditUrl= $EditUrl.$_GET["tab"];
		header("Location:".$EditUrl);
    //if there is a long message (ie ErrorLevel=1), display it
    if (count($longMsg) > 0)
        echo '<BR>', str_replace(">", "&gt;", str_replace("<", "&lt;", $longMsg->item(0)->nodeValue));
}
else 
{ //If there are no errors, continue
    if(isset($_GET['debug']))
    {  
       header("Content-type: text/xml");
      //'<pre>'; print_r($responseXml);

	 // echo "<pre>"; print_r($responseXml);
    }
	else

     {
	$orders = $response->OrderArray->Order;

    if ($orders != null) 
		{
		
        foreach ($orders as $order) 
			{


            echo "Order Information:\n";
            echo "OrderID ->" . $order->OrderID . "\n";
            echo "Order -> Status:" . $orderStatus = $order->OrderStatus . "\n";




            if ($orderStatus)
				{

                // get the amount paid
                $AmountPaid = $order->AmountPaid;
                $AmountPaidAttr = $AmountPaid->attributes();
               // echo "AmountPaid : " . $AmountPaid . " "  .$AmountPaidAttr["currencyID"]. "\n";

			      $AmountPaid1=$AmountPaid." ".$AmountPaidAttr["currencyID"];
				//echo $AmountPaid1;exit;
                // get the payment method 
                if($order->PaymentMethod)
                echo "PaymentMethod : " . $order->PaymentMethod . "\n";
 //$AmountPaid999 = $order->CreatedTime;

 //echo $AmountPaid999;exit;


                // get the checkout message left by the buyer, if any
               // if ($order->BuyerCheckoutMessage)
				//	{
                  // echo "BuyerCheckoutMsg : " . $order->BuyerCheckoutMessage . "\n";
                   //}

                 $SalesTaxAmount = $order->ShippingDetails->SalesTax->SalesTaxAmount;
                 $SalesTaxAmountAttr = $SalesTaxAmount->attributes();
                 echo "SalesTaxAmount : " . $SalesTaxAmount. " " .$SalesTaxAmountAttr["currencyID"] .  "\n";




				//$externalTransaction = $order->ExternalTransaction;
              //  if ($externalTransaction) 
				//	{
                  //  echo "ExternalTransactionID  : " . $externalTransaction->ExternalTransactionID . "\n";
                  //  echo "ExternalTransactionTime  : " . $externalTransaction->ExternalTransactionTime . "\n";
                  //  $externalTransactionFeeAttr = $externalTransaction->FeeOrCreditAmount->attributes();
                  //  echo "ExternalFeeOrCreditAmount  : " . $externalTransaction->FeeOrCreditAmount . " " .$externalTransactionFeeAttr["currencyID"]  . " \n";
                 //   echo "ExternalTransactionPaymentOrRefundAmount   : " . $externalTransaction->PaymentOrRefundAmount . " " //.$externalTransactionFeeAttr["currencyID"]  . " \n";
               // }
				 // $ShippingServiceSelected = $order->ShippingServiceSelected;
              //  if($ShippingServiceSelected){
              //  echo "Shipping Service Selected  : " . $ShippingServiceSelected->ShippingService . " \n";
              //  $ShippingCostAttr = $ShippingServiceSelected->ShippingServiceCost->attributes();
              //  echo "ShippingServiceCost  : " . $ShippingServiceSelected->ShippingServiceCost . " " . $ShippingCostAttr["currencyID"] . "\n";
              //  }

 
	            $Subtotal = $order->Subtotal;
				
			 	$passorderid = $order->OrderID;
                $Total = $order->Total;
				//echo "Buyer BuyerUserID nafees Khan: " . $$order->BuyerUserID. "\n";

				 $shippingAddress = $order->ShippingAddress;
                $adsName = $shippingAddress->Name;

                if ($shippingAddress->Street1 != null) 
					{
                    $Street1 =  $shippingAddress->Street1 ;
                     }
                if ($shippingAddress->Street2 != null)
					{
                    $Street2 =  $shippingAddress->Street2;
                }
                if ($shippingAddress->CityName != null) {
                    $CityName = 
                            $shippingAddress->CityName;
                }
                if ($shippingAddress->StateOrProvince != null) {
                    $StateOrProvince = 
                            $shippingAddress->StateOrProvince;
                }
                if ($shippingAddress->PostalCode != null) {
                    $PostalCode = 
                            $shippingAddress->PostalCode;
                }
                if ($shippingAddress->CountryName != null) {
                    $CountryName = 
                            $shippingAddress->CountryName;
                }
                if ($shippingAddress->Phone != null) {
                    $Phone =  $shippingAddress->Phone;
                }
		$address = $Street1.', '.$Street2;
                if($address)
					
				{
                 echo "Shipping Address : " . $address;
               
				}
				else echo "Shipping Address: Null" . "\n";
				
		//echo '<pre>';print_r($order);exit;					
				
		$BuyerEmail = $order->TransactionArray->Transaction->Buyer->Email[0];
		if(empty($BuyerEmail) || $BuyerEmail=='Invalid Request') $BuyerEmail='';

		
		$EbayTaxAmount = $order->TransactionArray->Transaction->Taxes->TotalTaxAmount;
		
				
			 $strSQLQry11 = "select OrderID from e_orders where AmazonOrderId ='".$order->OrderID."' ";
			  $arryEbayOrder = $objProduct->query($strSQLQry11);			 
			  $ExistingOrderID =  $arryEbayOrder[0]['OrderID'];



				
if(empty($ExistingOrderID)){				
	$sql="INSERT IGNORE  INTO e_orders(Currency,OrderDate, OrderComplatedDate, SubTotalPrice, TotalPrice, TotalQuantity, BillingName, BillingAddress, BillingCity,BillingState, BillingCountry,BillingZip, Phone,ShippingName,ShippingAddress, ShippingCity,ShippingState,ShippingCountry,ShippingZip, ShippingPhone,OrderStatus,AmazonOrderId, AmazonAccountID,OrderType, SellerChannel,Email, PaymentGateway, Tax,ShippingMethod,Shipping) VALUES('".$AmountPaidAttr["currencyID"]."','".$order->CreatedTime."','".$order->CreatedTime."','".$Subtotal."','".$Total."','".$qty."','".$adsName."','".$address."','".$CityName."','".$StateOrProvince."','".$CountryName."','".$PostalCode."','".$Phone."','".$adsName."','".$address."','".$CityName."','".$StateOrProvince."','".$CountryName."','".$PostalCode."','".$Phone."','".$order->OrderStatus."','" . $order->OrderID ."','0','Ebay','Ebay.com','".$BuyerEmail."','".$order->PaymentMethods."','".$EbayTaxAmount."','".$order->ShippingServiceSelected->ShippingService."','".$order->ShippingServiceSelected->ShippingServiceCost ."')";

	$objProduct->query($sql, 0);
	$lastInsertId = $objProduct->lastInsertId();
}else{
	$sqlquery  ="update e_orders set OrderStatus='".$order->OrderStatus."' where OrderID='".$ExistingOrderID."'"; 
	$objProduct->query($sqlquery, 0);
	$lastInsertId = 0;
}
				
               $transactions = $order->TransactionArray;
                if ($transactions) 
					{
                    echo "Transaction Array \n";
                    // iterate through each transaction for the order
                    foreach ($transactions->Transaction as $transaction)
						{
                        // get the OrderLineItemID, Quantity, buyer's email and SKU

                       // echo "OrderLineItemID : " . $transaction->OrderLineItemID . "\n";
                       //echo "QuantityPurchased  : " . $transaction->QuantityPurchased . "\n";
                        echo "Buyer Email : " . $transaction->Buyer->Email . "\n";
                        $SKU = $transaction->Item->SKU;
						 $qty = $transaction->QuantityPurchased;
						  $title =  $transaction->Item->Title;
						 
						      $ItemID = $transaction->Item->ItemID;

						   

                      //  if ($SKU) 
						//	{
                         //   echo "Transaction -> SKU  :" . $SKU ."\n";
                         //    }

                        
                        // if the item is listed with variations, get the variation SKU
                       // $VariationSKU = $transaction->Variation->SKU;
                       // if ($VariationSKU != null)
							//{
                           // echo "Variation SKU  : " . $VariationSKU. "\n";
                     //   }
                      //  echo "TransactionID: " . $transaction->TransactionID . "\n";
                      //  $transactionPriceAttr = $transaction->TransactionPrice->attributes();
                        echo "TransactionPrice : " . $transaction->TransactionPrice . " " . $transactionPriceAttr["currencyID"] . "\n";
                        echo "Platform : " . $transaction->Platform . "\n";

                        $textis= $transaction->Platform->Taxes->TotalTaxAmount . "\n";
				 
				 
                   
						if($lastInsertId>0)
						{
						
					      $sql1="INSERT  IGNORE INTO e_orderdetail(OrderID,Quantity,Price,ProductName,AmazonSku,OrderItemId,ebayorderid) VALUES ('".$lastInsertId."' ,'".$qty."','".$transaction->TransactionPrice."','".$title."','".$SKU."','".$transaction->OrderLineItemID."','".$order->OrderID."')";
					      $objProduct->query($sql1, 0);
						}
						  
						//  $LId = $objProduct->lastInsertId();
						 // if(($LId>0) && ($lastInsertId==0))
						  //{
							
							// $sql1="INSERT   INTO e_orderdetail(OrderID,Quantity,Price,ProductName,AmazonSku,OrderItemId,ebayorderid) VALUES ('".$LId."' ,'".$qty."','".$transaction->TransactionPrice."','".$title."','".$SKU."','".$transaction->OrderLineItemID."','".$order->OrderID."')";
					     // $objProduct->query($sql1, 0);  
						 // }
						  
		
						
						
						
					
	  
                    }

					
                }
				
				//   $sql="INSERT IGNORE  INTO e_orders(Currency,OrderDate,OrderComplatedDate,SubTotalPrice,TotalPrice,TotalQuantity,BillingName,BillingAddress,BillingCity,BillingState,BillingCountry,BillingZip,Phone,ShippingName,ShippingAddress,ShippingCity,ShippingState,ShippingCountry,ShippingZip,ShippingPhone,OrderStatus,AmazonOrderId,AmazonAccountID,OrderType,SellerChannel,Email,
                   //   PaymentGateway,Tax,ShippingMethod,Shipping) VALUES('".$AmountPaidAttr["currencyID"]."','".$order->CreatedTime."','".$order->CreatedTime."','".$Subtotal."','".$Total."','".$qty."','".$adsName."','".$address."','".$CityName."','".$StateOrProvince."','".$CountryName."','".$PostalCode."','".$Phone."','".$adsName."','".$address."','".$CityName."','".$StateOrProvince."','".$CountryName."','".$PostalCode."','".$Phone."','".$order->OrderStatus."','" . $order->OrderID ."','0','Ebay','Ebay.com','".$transaction->Buyer->Email."','".$order->PaymentMethods."','".$transaction->Taxes->TotalTaxAmount."','".$order->ShippingDetails->ShippingServiceOptions->ShippingService."','".$order->ShippingServiceSelected->ShippingServiceCost ."' )"; 
					  
					  // $sql="INSERT IGNORE  INTO e_orders(Currency,OrderDate,OrderComplatedDate,SubTotalPrice,TotalPrice,TotalQuantity,BillingName,BillingAddress,BillingCity,BillingState,BillingCountry,BillingZip,Phone,ShippingName,ShippingAddress,ShippingCity,ShippingState,ShippingCountry,ShippingZip,ShippingPhone,OrderStatus,AmazonOrderId,AmazonAccountID,OrderType,SellerChannel,Email,
                      //PaymentGateway,Tax,ShippingMethod,Shipping,BuyerUserID) VALUES('".$AmountPaidAttr["currencyID"]."','".$order->CreatedTime."','".$order->CreatedTime."','".$Subtotal."','".$Total."','".$qty."','".$adsName."','".$address."','".$CityName."','".$StateOrProvince."','".$CountryName."','".$PostalCode."','".$Phone."','".$adsName."','".$address."','".$CityName."','".$StateOrProvince."','".$CountryName."','".$PostalCode."','".$Phone."','".$order->OrderStatus."','" . $order->OrderID ."','0','Ebay','Ebay.com','".$transaction->Buyer->Email."','".$order->PaymentMethods."','".$transaction->Taxes->TotalTaxAmount."','".$order->ShippingServiceSelected->ShippingService."','".$order->ShippingServiceSelected->ShippingServiceCost ."','".$order->BuyerUserID."' )"; 
					  
					   // $objProduct->query($sql, 0);
						//$lastInsertId = $objProduct->lastInsertId();
						//if($lastInsertId>0)
						//{
							// $sql1="update e_orderdetail set OrderID='".$lastInsertId."' where ebayorderid='" . $order->OrderID ."'"; //   (OrderID,Quantity,Price,ProductName,AmazonSku,OrderItemId) VALUES ('".$lastid."','".$qty."','".$AmountPaid."','".$title."','".$SKU."','". $order->OrderID."')"; 
					 //  $objProduct->query($sql1, 0);
						//}


			if($lastInsertId>0){
				$sq2 = "SELECT * FROM e_orders where OrderID='" . addslashes($lastInsertId). "' ";
				$orderres =$objProduct->query($sq2, 1);
				//if(!empty($orderres[0]['Email'])){
					$objProduct->SyncAmazonOrderInSalesOrder($orderres,$lastInsertId );   
				//}
			}

 // $sql="INSERT IGNORE  INTO e_orders(Currency,OrderDate,OrderComplatedDate,SubTotalPrice,TotalPrice,TotalQuantity,BillingName,BillingAddress,BillingCity,BillingState,BillingCountry,BillingZip,Phone,ShippingName,ShippingAddress,ShippingCity,ShippingState,ShippingCountry,ShippingZip,ShippingPhone,OrderStatus,AmazonOrderId,AmazonAccountID,OrderType,SellerChannel,Email,
        // PaymentGateway,Tax) VALUES('".$AmountPaidAttr["currencyID"]."','".$order->CreatedTime."','".$order->CreatedTime."','".$Subtotal."','".$Total."','".$qty."','".$adsName."','".$address."','".$CityName."','".$StateOrProvince."','".$CountryName."','".$PostalCode."','".$Phone."','".$adsName."','".$address."','".$CityName."','".$StateOrProvince."','".$CountryName."','".$PostalCode."','".$Phone."','".$order->OrderStatus."','" . $order->OrderID ."','0','Ebay','Ebay.com','". $order->SellerEmail ."','".$order->PaymentMethods."','".$textis."' )"; 
					 
		// $objProduct->query($sql, 0);
			//$lastInsertId = $objProduct->lastInsertId();
			
		

				// $sql1="INSERT IGNORE  INTO e_orderdetail(OrderID,Quantity,Price,ProductName,AmazonSku,OrderItemId) VALUES ('".$lastInsertId."','".$qty."','".$AmountPaid."','".$title."','".$SKU."','". $order->OrderID."')"; 
				//$objProduct->query($sql1, 0);


 
			
					
				echo "---------------------------------------------------- \n";
				}
				 
  

			}
		
			
	    

		}
		 
		 
	

 }
}
	//}
				   
		 $_SESSION['mess_order'] = 'Ebay orders are synced successfully.';
		header("Location:viewOrder.php");
		exit;

	

?>




