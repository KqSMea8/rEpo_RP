<?
	$url = 'http://66.55.11.23/erp/processCmp.php';

	$cinit = curl_init();
	curl_setopt($cinit, CURLOPT_URL, $url);
	curl_setopt($cinit, CURLOPT_HEADER,0);
	curl_setopt($cinit, CURLOPT_USERAGENT, "MozillaXYZ/1.0");
	//curl_setopt($cinit, CURLOPT_PROXY,"66.55.11.23:80");
	curl_setopt($cinit, CURLOPT_USERAGENT, $_SERVER["HTTP_USER_AGENT"]);
	curl_setopt($cinit, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($cinit, CURLOPT_TIMEOUT, 30);

	curl_setopt($cinit, CURLOPT_CUSTOMREQUEST, 'GET');  
	//curl_setopt($cinit, CURLOPT_NOBODY, true); 

	$response = curl_exec($cinit);
	$httpCode = curl_getinfo($cinit, CURLINFO_HTTP_CODE); 
	$info = curl_getinfo($cinit);
	$err = curl_error($cinit);  
	curl_close($cinit); 

	echo '<pre>';
	//print_r($info); 
	//echo '<br><br>httpCode:'. $httpCode;

	if($err){
		echo '<br><br>Error: '.$err; exit;
	}else{
		echo '<br><br>Response: '.$response; exit;
	}


	exit;

?>
