<?php
/*
$ipaddress = $_GET['ip']; //$_SERVER["REMOTE_ADDR"];
$iptolocation = 'http://api.hostip.info/country.php?ip=' . $ipaddress;
$creatorlocation = file_get_contents($iptolocation);
print_r($creatorlocation);
echo '<br><br><br>----------------------------------------<br><br>';
*/


$ipaddress =  $_SERVER["REMOTE_ADDR"]; //$_GET['ip'];
$xml = simplexml_load_file("http://www.geoplugin.net/xml.gp?ip=".$ipaddress);
#echo "<pre>" ; print_r($xml);
$CountyCode=$xml->geoplugin_countryCode;
if($CountyCode=="US"){
	$Mobile = '013489534975934';
}else if($CountyCode=="IN"){
	$Mobile = '93489534975934';
}
echo $Mobile;

?>
