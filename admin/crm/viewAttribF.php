<?php 
	include_once("../includes/header.php");
	$_GET['att'] = (int)$_GET['att'];


	$EditUrl = 'editAttribF.php';
	include("../includes/html/box/view_attrib_finance.php");

	require_once("../includes/footer.php");
?>

