<?php ob_start();
session_start();	
	require_once("includes/settings.php");	
	require_once("../classes/user.class.php");
	$objUser=new user();

	if(!empty($_SESSION['UserID']) && !empty($_SESSION['AdminType'])){
		$objUser->UserLogout($_SESSION['UserID'],$_SESSION['AdminType']);
	}
	
	#if($_SESSION['AdminType']=='employee') $url_suffix .= '&t=e';
	if($_GET['ref']) $url_suffix .= '&ref='.$_GET['ref'];

	$DisplayName = $_COOKIE["DisplayNameCookie"]; //$_SESSION['DisplayName'];
	if (isset($_SESSION['AdminID'])) { unset($_SESSION['AdminID']); }
		if (isset($_COOKIE[session_name()])) {
	  setcookie(session_name(), '', time()-42000, '/');
	}
	session_destroy();	

	$RedirectUrl = "index.php?logout=".$DisplayName5.$url_suffix;
	if($_SESSION['CmpLogin']==1){
		$RedirectUrl = "../crm/index.php?logout=";
	}

	header("location: ".$RedirectUrl);
	ob_end_flush();
?>
