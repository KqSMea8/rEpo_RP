<?php 
	require_once("../includes/header.php");
	require_once($Prefix."classes/hrms.class.php");
	include_once("includes/FieldArray.php");
	$objCommon=new common();

	$arryDocument=$objCommon->ListDocument('','',$_GET['key'],$_GET['sortby'],$_GET['asc']);
	$num=$objCommon->numRows();

	require_once("../includes/footer.php"); 
	 
?>



