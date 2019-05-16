<?php
	error_reporting(E_ALL);
	ini_set('display_errors', true); 
	require_once("includes/header.php"); 
	require_once("classes/template.class.php"); 
	
	$objtemplate=new template();
	
	$arryTemplate=$objtemplate->ListTemplates();
	
	$num=$objtemplate->num_rows;
	 
	 require_once("includes/footer.php");	 
?>

