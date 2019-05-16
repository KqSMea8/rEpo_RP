<?php 
	include_once("../includes/header.php");
	$_GET['att'] = (int)$_GET['att'];
	$EditUrl = 'editAttribW.php';
	include("../includes/html/box/view_attrib_warehouse.php");

	require_once("../includes/footer.php");
?>

