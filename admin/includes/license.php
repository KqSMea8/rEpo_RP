<?
/******************************************/
/*******Curl request for license **********/

/* // Curl GET Method //

$url = "http://192.168.1.138/erp/processLicense.php?DomainName=".$_SERVER['SERVER_NAME'];
if($ValidateLicense==1){
	$url .= "&ValidateLicense=1&LicenseKey=".$LicenseKey;
}

#echo $url;exit;
$cinit = curl_init();
curl_setopt($cinit, CURLOPT_URL, $url);
curl_setopt($cinit, CURLOPT_HEADER,0);
curl_setopt($cinit, CURLOPT_USERAGENT, "MozillaXYZ/1.0");
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

//echo '<pre>';print_r($info); 
//echo '<br><br>httpCode:'. $httpCode;

if($err){
	echo '<br><br>Error: '.$err; exit;
}else{
	echo '<br><br>Response: '.$response; exit;
}
*/

/************************/
/************************/

$URL = "http://66.55.11.23/erp/processLicense.php";
$xml_data = '<?xml version="1.0"?>
<licensedetail>
<domain>' . $_SERVER['SERVER_NAME']. '</domain>
<validatelicense>' . $ValidateLicense . '</validatelicense>
<licensekey>' . $LicenseKey . '</licensekey>
</licensedetail>';
$ch = curl_init($URL);

curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, array('xmldata' => $xml_data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$output = curl_exec($ch);
$response = $output;
//$xml = simplexml_load_string($output);
//echo 'Response: '.$response; exit;
unset($_SESSION['MaxAllowedUser']);
if($response=='0' || $response=='3' || empty($response)){
	if($response=='0'){
		echo '<div align="center" class="redmsg">No License Key exists for this domain.</div>';
		if($Config['Install']!=1){
			header('location:../install/index.php');			
		}
		exit;
	}else{
		echo '<div align="center" class="redmsg">Invalid License Key.<br><a href="Javascript:window.history.go(-1);">Back</a></div>';
		exit;
	}
}else{
	$arryResponse = explode("#",$response);
	$_SESSION['MaxAllowedUser'] = $arryResponse[1]; 
}
/***********************/
/***********************/
?>
