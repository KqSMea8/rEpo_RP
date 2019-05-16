	<?php
	
	    $url = 'https://sandbox-api.postmen.com/v3/rates';
	    $method = 'POST';
	    $headers = array(
	        "content-type: application/json",
	        "postmen-api-key: 5da2f7d5-320f-4ae5-872e-99bae1a6aa7a"
	    );
	    $body = '{"async":false,"shipper_accounts":[{"id":"6f257593-c770-484f-8dbd-c696fae2d78b"}],"is_document":false,"shipment":{"ship_from":{"contact_name":"Elmira Zulauf","company_name":"Kemmer-Gerhold","street1":"662 Flatley Manors","country":"HKG","type":"business"},"ship_to":{"contact_name":"Dr. Moises Corwin","phone":"1-140-225-6410","email":"Giovanna42@yahoo.com","street1":"28292 Daugherty Orchard","city":"Beverly Hills","postal_code":"90209","state":"CA","country":"USA","type":"residential"},"parcels":[{"description":"iMac (Retina 5K, 27-inch, Late 2014)","box_type":"custom","weight":{"value":9.54,"unit":"kg"},"dimension":{"width":65,"height":52,"depth":21,"unit":"cm"},"items":[{"description":"iMac (Retina 5K, 27-inch, Late 2014)","origin_country":"USA","quantity":1,"price":{"amount":1999,"currency":"USD"},"weight":{"value":9.54,"unit":"kg"},"sku":"imac2014"}]}]}}';
	
	    $curl = curl_init();
	
	    curl_setopt_array($curl, array(
	        CURLOPT_RETURNTRANSFER => true,
	        CURLOPT_URL => $url,
	        CURLOPT_CUSTOMREQUEST => $method,
	        CURLOPT_HTTPHEADER => $headers,
			CURLOPT_POSTFIELDS => $body
	    ));
	
	    $response = curl_exec($curl);
	    $err = curl_error($curl);
	
	    curl_close($curl);
	
	    if ($err) {
	    	echo "cURL Error #:" . $err;
	    } else {
	    	echo $response;
	    }
	?>
	