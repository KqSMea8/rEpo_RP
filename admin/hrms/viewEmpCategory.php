<?php 
	include_once("../includes/header.php");
	include_once($Prefix."classes/hrms.class.php");
	$ModuleName = 'Category';	
	$objCommon=new common();
	$RedirectUrl ="viewEmpCategory.php";
			
	$arryCategory=$objCommon->GetEmpCategoryList();
	$num=sizeof($arryCategory);	 	  
 
	require_once("../includes/footer.php");
?>
