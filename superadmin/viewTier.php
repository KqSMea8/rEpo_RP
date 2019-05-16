<?php 
 	include_once("includes/header.php");
	require_once("../classes/commonsuper.class.php");
	$objCommon=new common();

	$arryTier=$objCommon->getTier('','');
	$num=$objCommon->numRows();

	require_once("includes/footer.php");
?>


