<?php
	$upsRate = new upsRate($upsConnect);
	# Shop for different services
	#$upsRate->request(array('Shop' => true));
	# Return a specific service rate
	$upsRate->request(array());

	$upsRate->shipper(array('name' => $_POST['FirstnameFrom'].'-'.$_POST['LastnameFrom'],
							 'phone' => $_POST['PhonenoFrom'], 
							 'shipperNumber' => '123456', 
							 'address1' => $_POST['Address1From'], 
							 'address2' => $_POST['Address2From'], 
							 'address3' => '', 
							 'city' => $_POST['CityFrom'], 
							 'state' => $_POST['StateFrom'], 
							 'postalCode' => $_POST['ZipFrom'], 
							 'country' => $_POST['CountryCgFrom']));

	$upsRate->shipTo(array('companyName' => $_POST['CompanyTo'], 
							'attentionName' => $_POST['FirstnameTo'].'-'.$_POST['LastnameTo'], 
							'phone' => $_POST['PhoneNoTo'], 
							'address1' => $_POST['Address1To'], 
							'address2' => $_POST['Address2To'], 
							'address3' => '', 
							'city' => $_POST['CityTo'], 
							'state' => $_POST['StateTo'], 
							'postalCode' => $_POST['ZipTo'],
							'countryCode' => $_POST['CountryCgTo']));
	
	$description='UPS Shipment Rate';
	$ShippingMethod=$_POST['ShippingMethod'];
	$packageType=$_POST['packageType'];
 	
	for($i=1;$i<=$NumLine;$i++){ 
		
		$Weight = $_POST['Weight'.$i];
		$wtUnit = $_POST['wtUnit'.$i];
		$Length = $_POST['Length'.$i];
		$Width = $_POST['Width'.$i];
		$Height = $_POST['Height'.$i];
		$htUnit = $_POST['htUnit'.$i];
		
	  $upsRate->package(array('description' => $description, 
									'weight' => $Weight,
									'code' => $packageType,
									'length' => $Length,
									'width' => $Width,
									'height' => $Height,
									));
	}
	
	
	// $upsRate->rateInformation(array('NegotiatedRatesIndicator' => 'yes')); // Add for negotiated rates

	$upsRate->shipment(array('description' => $description,'serviceType' => $ShippingMethod));

	$rateFromUPS = $upsRate->sendRateRequest();
	
	$response = $upsRate->returnResponseArray();
	
	#echo '<pre>'; print_r($upsRate->returnResponseArray()); echo '</pre>';

	// echo $upsRate->returnRate();
	
	$totalFreight =	$response['RatingServiceSelectionResponse']['RatedShipment']['TotalCharges']['MonetaryValue']['VALUE'];
	
	$error = $response['RatingServiceSelectionResponse']['Response']['Error']['ErrorDescription']['VALUE'];
	

?>

