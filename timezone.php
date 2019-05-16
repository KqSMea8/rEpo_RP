<?
require_once("includes/function.php");
///////////////////////////////////////
//////////////////////////////////////



function UpdateUpdateTimezone($country,$state,$city)
{
	$address = '';
	if(!empty($city)) $address .= $city.", ";
	if(!empty($state)) $address .= $state.", ";
	$address .= $country;

	$address = str_replace(" ","+",$address);
	$url            = "http://maps.googleapis.com/maps/api/geocode/json?address=$address&sensor=false";

	/*
	$get_map        = file_get_contents($url);
	$google_map     = json_decode($get_map);	
	*/

	$cit = curl_init();
	curl_setopt($cit, CURLOPT_URL, $url);
	curl_setopt($cit, CURLOPT_HEADER,0);
	//url_setopt($cit, CURLOPT_USERAGENT, "MozillaXYZ/1.0");
	//curl_setopt($cit, CURLOPT_PROXY,"66.55.11.23:80");
	curl_setopt($cit, CURLOPT_USERAGENT, $_SERVER["HTTP_USER_AGENT"]);
	curl_setopt($cit, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($cit, CURLOPT_TIMEOUT, 30);
	curl_setopt($cit, CURLOPT_CUSTOMREQUEST, 'GET');  
	//curl_setopt($cit, CURLOPT_NOBODY, true); 
	$responseLatLong = curl_exec($cit);
	$httpCode = curl_getinfo($cit, CURLINFO_HTTP_CODE); 
	$info = curl_getinfo($cit);
	$err = curl_error($cit);  
	curl_close($cit); 
	/*********************/

	$google_map     = json_decode($responseLatLong);	
	 

	$lat            = $google_map->results[0]->geometry->location->lat;
	$long           = $google_map->results[0]->geometry->location->lng;



	$query_string='/'.$lat.'/'.$long;
	$url = 'http://www.earthtools.org/timezone-1.1'.$query_string;
	/****************************
	//Google 
#https://maps.googleapis.com/maps/api/timezone/xml?location=39.6034810,-119.6822510&timestamp=1331161200&sensor=false&key=AIzaSyCd-BjtsrBF-3sLhBM4UOesLAvnLAzvxnw

	$CurrentTime = time();
	$GoogleAPI = 'AIzaSyCd-BjtsrBF-3sLhBM4UOesLAvnLAzvxnw';
	$url = 'https://maps.googleapis.com/maps/api/timezone/xml?location='.$lat.','.$long.'&amp;timestamp='. $CurrentTime.'&sensor=false&key='.$GoogleAPI; 
	*********************/

	$url = 'http://api.geonames.org/timezone?lat='.$lat.'&lng='.$long.'&username=parwez'; //http://www.geonames.org/


	$cinit = curl_init();
	curl_setopt($cinit, CURLOPT_URL, $url);
	curl_setopt($cinit, CURLOPT_HEADER,0);
	//url_setopt($cinit, CURLOPT_USERAGENT, "MozillaXYZ/1.0");
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

	$AraryResponse = xml2array($response);
	
	$Offset = $AraryResponse['geonames']['timezone']['dstOffset']['value']; // for geonames.org


	//$Offset = $AraryResponse["timezone"]["offset"]['value'];
	$TimezonePlusMinus = ($Offset>0)?("+"):("-");
	$Offset= str_replace("-","",$Offset);
	$Timezone = SecondToHrMin($Offset*3600);
	 $Timezone = $TimezonePlusMinus.$Timezone;

	return $Timezone;
    
}




echo $Timezone = UpdateUpdateTimezone("United States");







/*
function get_lat_long($address){

    $address = str_replace(" ", "+", $address);

    $json = file_get_contents("http://maps.google.com/maps/api/geocode/json?address=$address&sensor=false&region=$region");
    $json = json_decode($json);

    $lat = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
    $long = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
    return $lat.','.$long;
}

 //echo $latlong    =   get_lat_long("Alachua, Florida, United States");exit;

//////////////////////////////////////	
	$url = 'http://www.earthtools.org/timezone-1.1/22.572646/88.363895'; //india
	//$url = 'http://www.earthtools.org/timezone-1.1/29.7938144/-82.4944226'; //us

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


	//print_r($info); 
	//echo '<br><br>httpCode:'. $httpCode;

	if($err){
		
		echo '<br><br>Error: '.$err;
		 exit;
	}else{
		//echo '<br><br>Response: '.$response; exit;
		$AraryResponse = xml2array($response);
		$Offset = $AraryResponse["timezone"]["offset"]['value'];
		$TimezonePlusMinus = ($Offset>0)?("+"):("-");
		$Offset= str_replace("-","",$Offset);
		$Timezone = SecondToHrMin($Offset*3600);

		echo $Timezone = $TimezonePlusMinus.$Timezone;

		//echo '<pre>'; print_r($AraryResponse);
	}


	exit;
*/
?>
