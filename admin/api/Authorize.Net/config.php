<?
//http://developer.authorize.net/api/reference/

//$auth_net_login_id = "5KP3u95bQpv";
//$auth_net_tran_key = "4Ktq966gC55GAX7S";

//$TEST_MODE = TRUE;

$auth_net_login_id = $arryProvider[0]['anApiLoginId'];
$auth_net_tran_key =  $arryProvider[0]['anTransactionKey'];

if($TEST_MODE == TRUE){
	$auth_net_url	= "https://test.authorize.net/gateway/transact.dll";
	$XML_URL	= "https://apitest.authorize.net/xml/v1/request.api";
}else{
	$auth_net_url	= "https://secure.authorize.net/gateway/transact.dll";
	$XML_URL	= "https://api.authorize.net/xml/v1/request.api";
}

$auth_version = "3.1";	
$auth_delim_char = "|";	
$auth_delim_data = "TRUE";	
?>
