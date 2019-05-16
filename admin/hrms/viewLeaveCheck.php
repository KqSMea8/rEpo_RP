<?php 
 	include_once("../includes/header.php");
	require_once($Prefix."classes/hrms.class.php");
	include_once("includes/FieldArray.php");
	$objCommon=new common();

	$arryLeaveCheck=$objCommon->getLeaveCheck('','');
	$num=$objCommon->numRows();

	require_once("../includes/footer.php");
?>


