<?php 
	include_once("../includes/header.php");

	$EditUrl = 'editAttrib.php';
	$_GET['att'] = (int)$_GET['att'];
	include("../includes/html/box/view_attrib_warehouse.php");

	require_once("../includes/footer.php");
?>

