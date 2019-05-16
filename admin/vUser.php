<?php 
	if(!empty($_GET['pop']))$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'viewUsers.php'; 
	/**************************************************/
	include_once("includes/header.php");
	include("includes/html/box/v_user.php");

	require_once("includes/footer.php"); 	 
?>


