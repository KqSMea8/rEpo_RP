<?php


	/**************************************************/
	$ThisPageName = 'viewCustomer.php'; $EditPage = 1;
	/**************************************************/
	include_once '../../define.php';
 	include_once("includes/header.php");  	
	
	include("includes/html/box/edit_customer.php");


	
   	require_once("includes/footer.php"); 
 ?>
<? if($_GET["tab"]=="contact" || $_GET["tab"]=="billing" || $_GET["tab"]=="shipping"){ ?>
	StateListSend();
<? } ?>
</SCRIPT>