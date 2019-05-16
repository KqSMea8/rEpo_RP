<?php 
	if(!empty($_GET['pop']))$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'viewCustomer.php'; 
	/**************************************************/
	include_once("../includes/header.php");
	include("../includes/html/box/v_customer.php");
 
	require_once("../includes/footer.php"); 	
?>
