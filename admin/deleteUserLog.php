<?php 
	$HideNavigation = 1;
	include_once("includes/header.php");
	require_once("../classes/user.class.php");
	$objUser=new user();

	$RedirectUrl = 'viewUserLog.php';	
			
	if(!empty($_POST['DeleteBefore'])){
		CleanPost();
		$objUser->RemoveUserLog($_POST);
		echo '<script>window.parent.location.href="'.$RedirectUrl.'";</script>';
		exit;
	}
	
	require_once("includes/footer.php"); 	 
?>

