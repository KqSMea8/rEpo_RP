<?php 
	if($_GET['pop']==1)$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'viewUser.php'; 
	/**************************************************/
	include_once("../includes/header.php");
	include("../includes/html/box/v_user.php");

	require_once("../includes/footer.php"); 	 
?>


