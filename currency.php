<?
	
 

	function CurrencyConvertor($amount,$from,$to){
		
		$get = file_get_contents("https://www.google.com/finance/converter?a=".$amount."&from=".$from."&to=".$to."");
		$get = explode("<span class=bld>",$get);
		$get = explode("</span>",$get[1]);  
		$converted_amount = preg_replace("/[^0-9\.]/", null, $get[0]);
		return $converted_amount;
	}

	function CurrencyConvertorCurl($amount,$from,$to){
		/*$req_url = 'https://v3.exchangerate-api.com/pair/6de99c3c6a956e0f1ee4c82f/USD/INR';
		$response_json = file_get_contents($req_url); 
		$jsonCardArray = json_decode($response_json, true);			
		return $jsonCardArray['rate'];*/

		  $today = date("Y-m-d");
		 $url = "https://xecdapi.xe.com/v1/convert_to.json/?to=USD&from=INR&amount=1&date=".$today;
 
		
		$cinit = curl_init();
		curl_setopt($cinit, CURLOPT_URL, $url);
		curl_setopt($cinit, CURLOPT_HEADER,0);
		curl_setopt($cinit, CURLOPT_USERAGENT, "MozillaXYZ/1.0");
		curl_setopt($cinit, CURLOPT_USERAGENT, $_SERVER["HTTP_USER_AGENT"]);
		curl_setopt($cinit, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($cinit, CURLOPT_TIMEOUT, 30);
		curl_setopt($cinit, CURLOPT_CUSTOMREQUEST, 'GET');  
		curl_setopt($cinit, CURLOPT_USERPWD, "virtualstackssystemsllc303099069:p6g9avhdeo5kic0h20l5fsji63");
		curl_setopt($cinit, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
 
		$response = curl_exec($cinit);
		$httpCode = curl_getinfo($cinit, CURLINFO_HTTP_CODE); 
		$info = curl_getinfo($cinit);
		$err = curl_error($cinit);  
		curl_close($cinit); 
		if($err){
			echo '<br><br>Error in Currency Conversion: '.$err; exit;
		}else{
			$jsonCardArray = json_decode($response, true);	
			echo $converted_amount = $jsonCardArray['from'][0]['mid'];
			echo '<pre>';print_r($jsonCardArray);die;

			echo '<br><br>Response: '.$response; die;
	  		$get = explode("<span class=bld>",$response);

			$get = explode("</span>",$get[1]);  
			#$converted_amount = preg_replace("/[^0-9\.]/", null, $get[0]);
			$converted_amount = (float)trim($get[0]);
			return $converted_amount;
		}
	}

        //require_once("includes/function.php");
	echo CurrencyConvertorCurl(1,'USD','INR');

	echo '<br><br>IP : '. GetIPAddress();

	/*
	$url = 'http://www.google.com/finance/converter?a=1&from=USD&to=INR';

	$cinit = curl_init();
	curl_setopt($cinit, CURLOPT_URL, $url);
	curl_setopt($cinit, CURLOPT_HEADER,0);
	curl_setopt($cinit, CURLOPT_USERAGENT, "MozillaXYZ/1.0");
	curl_setopt($cinit, CURLOPT_USERAGENT, $_SERVER["HTTP_USER_AGENT"]);
	curl_setopt($cinit, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($cinit, CURLOPT_TIMEOUT, 30);
	curl_setopt($cinit, CURLOPT_CUSTOMREQUEST, 'GET');  

	$response = curl_exec($cinit);
	$httpCode = curl_getinfo($cinit, CURLINFO_HTTP_CODE); 
	$info = curl_getinfo($cinit);
	$err = curl_error($cinit);  
	curl_close($cinit); 

	//echo '<pre>';print_r($info); 
	//echo '<br><br>httpCode:'. $httpCode;

	if($err){
		echo '<br><br>Error in Currency Conversion: '.$err; exit;
	}else{
		echo '<br><br>Response: '.$response; 
		$get = explode("<span class=bld>",$response);
		$get = explode("</span>",$get[1]);  
		$converted_amount = preg_replace("/[^0-9\.]/", null, $get[0]);
		echo $converted_amount;
	}


	exit;*/

?>
