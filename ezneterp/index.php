<?php 
/*
if(isset($_GET) && strpos($_SERVER['REQUEST_URI'],'slug') !== false && count($_GET)<2 && empty($_POST)){
	$url =  'http://'.$_SERVER['HTTP_HOST'].'/'.$_GET['slug'];
	Header( "HTTP/1.1 301 Moved Permanently" );
	header("Location: ".$url);
	exit;
}


if(substr_count($_SERVER['HTTP_HOST'],"www.")!=1){
	$url_red =  'http://www.eznetcrm.com/'.$_GET['slug'];
	Header( "HTTP/1.1 301 Moved Permanently" );
	header("Location: ".$url_red);
	exit;
}
*/



include ('includes/header.php');

if(!empty($datah['template'])){ 
	include_once($datah['template']);//echo 'helooooooooooooooooooooooooooooooooooooooooooo';
}else{
	include_once('content.php');//echo 'helooooooooooooooooooooooooooooooooooooooooooo';
}
include ('includes/footer.php');
?>
