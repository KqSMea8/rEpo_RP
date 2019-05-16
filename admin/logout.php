<?php  	
	require_once("includes/settings.php");	
	require_once("../classes/user.class.php");
	$objUser=new user();

	if(!empty($_SESSION['UserID']) && !empty($_SESSION['AdminType'])){
		$objUser->UserLogout($_SESSION['UserID'],$_SESSION['AdminType']);
	}
 	$url_suffix='';
	$DisplayName = '';

	#if($_SESSION['AdminType']=='employee') $url_suffix .= '&t=e';
	if(isset($_GET['ref'])) $url_suffix .= '&ref='.$_GET['ref'];

	
	//$DisplayName = $_COOKIE["DisplayNameCookie"]; //$_SESSION['DisplayName'];
	if (isset($_SESSION['AdminID'])) { unset($_SESSION['AdminID']); }
		if (isset($_COOKIE[session_name()])) {
	  setcookie(session_name(), '', time()-42000, '/');
	}
	session_destroy();	
 
	$RedirectUrl = "index.php?logout=".$DisplayName.$url_suffix;
	if(!empty($_SESSION['CmpLogin'])){
		$RedirectUrl = "../crm/index.php?logout=";
	}

	header("location: ".$RedirectUrl);
	ob_end_flush();
?>
