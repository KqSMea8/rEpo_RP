<?php 
 	include_once("includes/header.php");
	

	$objAdmin=new admin();	
	

	
	$arryAdmin=$objAdmin->ListAdmin('',$_GET['key'],$_GET['sortby'],$_GET['asc']);
	$num=$objAdmin->numRows();
	 
	 
	 require_once("includes/footer.php");
	 
?>



