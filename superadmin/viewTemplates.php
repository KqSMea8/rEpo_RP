<?php
	
	require_once("includes/header.php");
	require_once("../classes/commonsuper.class.php");
	//require_once("../classes/region.class.php");

	$objcommon=new common();
	
	$arryTemplate=$objcommon->ListTemplates();
	$num=$objcommon->numRows();
	 
	 require_once("includes/footer.php");	 
?>

