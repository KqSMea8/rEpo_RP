<?php
	/**************************************************/
	$ThisPageName = 'viewAttrib.php'; $EditPage = 1;
	/**************************************************/
	require_once("../includes/header.php");
	
	$_GET['att'] = (int)$_GET['att'];
	$_GET['edit'] = (int)$_GET['edit'];

	$RedirectUrl ="viewAttrib.php?att=".$_GET['att'];
	include("../includes/html/box/edit_attrib_warehouse.php");

	require_once("../includes/footer.php"); 
?>
