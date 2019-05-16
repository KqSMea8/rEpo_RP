<?php 
	$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'globalSetting.php';
	/**************************************************/
	include_once("../includes/header.php");	
	require_once($Prefix."classes/finance.class.php");
		
	$objCommon = new common();

	if(!empty($_GET["cur"]) && !empty($_GET["mod"])){
		$arryCurrencyLog = $objCommon->getCurrencyLog($_GET["mod"],$_GET["cur"],$Config['Currency']);
		$num = sizeof($arryCurrencyLog);		
	}else{
		$ErrorMSG = INVALID_REQUEST;
	}
	require_once("../includes/footer.php"); 	 
?>


