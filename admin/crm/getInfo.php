<?php
session_start();
if($_GET['do']=='info')
{
	info();
}
if($_GET['do']=='logOut')
{
	logOut();
}
// function to retrieve
function info(){
	$accessToken = strip_tags($_GET['accesstocken']);
	$response = file_get_contents("https://api.instagram.com/v1/users/self/?access_token=".$accessToken);
        //echo "https://api.instagram.com/v1/users/self/?access_token=".$accessToken;die;
	$as=$response;
	$jfo = json_decode($as);
//        print_r($jfo);
	$_SESSION['accessToken']=$accessToken;
	echo "NAMe:".$_SESSION['username']=$jfo->data->username;
	$_SESSION['id']=$jfo->data->id;
	$_SESSION['full_name']=$jfo->data->full_name;
	//$_SESSION['id']=$response['id'];*/
	echo $response;
}
function logOut()
{
	//echo "<script>alert('logout..**********');<script>";
	$bac=file_get_contents("https://instagram.com/accounts/logout/");
	$_SESSION['username']=NULL;
	$_SESSION['accessToken']=NULL;
	$_SESSION['id']=NULL;
	$_SESSION['full_name']=NULL;
	echo $bac;
}

?>