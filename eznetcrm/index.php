<?php

header("location: https://www.eznetcrm.com/");
exit;

/*
if(isset($_GET) && strpos($_SERVER['REQUEST_URI'],'slug') !== false && count($_GET)<2 && empty($_POST)){
	$url =  'http://'.$_SERVER['HTTP_HOST'].'/erp/eznetcrm/'.$_GET['slug'];
	Header( "HTTP/1.1 301 Moved Permanently" );
	header("Location: ".$url);
	exit;
}


if(substr_count($_SERVER['HTTP_HOST'],"www.")!=1){
	$url_red =  'http://www.eznetcrm.com/erp/eznetcrm/'.$_GET['slug'];
	Header( "HTTP/1.1 301 Moved Permanently" );
	header("Location: ".$url_red);
	exit;
}
*/



include ('includes/header.php');

if(!empty($datah['template'])){
	include_once($datah['template']);
}else{
	include_once('content.php');
}
include ('includes/footer.php');
?>
