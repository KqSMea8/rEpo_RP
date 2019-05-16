<?php 
	if($_GET['pop']==1)$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'viewCustomer.php'; 
	$InnerPage=1;

	/**************************************************/
	
	
	include_once("includes/header.php");
	
print_r($_SESSION);
	include("includes/html/box/v_customer.php");
 
	require_once("includes/footer.php"); 	
?>
