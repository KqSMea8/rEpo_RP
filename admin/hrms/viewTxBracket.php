<?php 
 	include_once("../includes/header.php");
	require_once($Prefix."classes/hrms.class.php");
	$objCommon=new common();

	if(empty($_GET['y'])) $_GET['y'] = date('Y');


	$arryBracket=$objCommon->getTaxBracket('',$_GET['y']);
	$num=$objCommon->numRows();

	$arryFiling=$objCommon->getFiling('','1');
	require_once("../includes/footer.php");
?>


