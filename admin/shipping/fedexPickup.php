<?

		require_once($strPath.'classes/class.fedex.pickup.php');
		
		
		$objPickup = new fedexPickup();
			
		$objPickup->requestType("pickup");
		if($Config['live']==1){  
			$objPickup->wsdl_root_path = "wsdl-live/";
		}else{
			$objPickup->wsdl_root_path = "wsdl-test/";
		}



		    $client = new SoapClient($objPickup->wsdl_root_path . $objPickup->wsdl_path, array('trace' => 1)); // Refer to http://us3.php.net/manual/en/ref.soap.php for more information


		        $aryPickup['PackageLocation']= $_POST['pickLocation'];
			$aryPickup['ReadyTimestamp'] = $_POST['pickDate'].'T'.$_POST['pickReadyTime'];
			$aryPickup['CompanyCloseTime'] = $_POST['pickCloseTime'];
			$aryPickup['PackageCount'] = $_POST['NoOfPackages'];
			$aryPickup['TotalWeight'] = $_POST['pickWeight'];
			$aryPickup['TotalWeightUnit'] = $_POST['pickWeightUnit'];

			if($_POST['ShippingMethod']=='FEDEX_EXPRESS_SAVER'){
				$aryPickup['CarrierCode'] = 'FDXE';
				
			}else if($_POST['ShippingMethod']=='FEDEX_GROUND'){

				$aryPickup['CarrierCode'] = 'FDXG';

			}else{
				$aryPickup['CarrierCode'] = '';
			}
			
			$aryPickup['CourierRemarks'] = $_POST['CourierRemarks'];
			
		
		    #echo 'test<pre>'; print_r($aryPickup);exit;
		
		    $request = $objPickup->pickupRequest($aryPickup);
		
		   #echo 'test<pre>'; print_r($request);exit;
		

		
			//$request = array();
		
		
		     try
                	{
                		if ($objPickup->setEndpoint('changeEndpoint'))
                		{
                			$newLocation = $client->__setLocation(setEndpoint('endpoint'));
                		}

                		$response = $client->createPickup($request); // FedEx web service invocation

 #echo 'test<pre>'; print_r($response);exit;


if ($response->HighestSeverity != 'FAILURE' && $response->HighestSeverity != 'ERROR'){

$error ="";
}else{
$error = $response->Notifications->Message;
}

						//getPickupAvailability

                		
                	}
                	catch (SoapFault $exception)
                	{
                		$error = $objPickup->requestError($exception, $client);
                	}
                	

?>

