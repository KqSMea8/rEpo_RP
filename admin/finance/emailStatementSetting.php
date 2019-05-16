<?php 
	$HideNavigation = 1;
	include_once("../includes/header.php");
	require_once($Prefix."classes/finance.class.php");
	$objCommon = new common();
	 
	if(!empty($_POST)){
		CleanPost();
		if($objCommon->UpdateCronSettings($_POST,'EmailStatement')){
			$_SESSION['mess_st_setting'] = EMAIL_STATEMENT_SETTING_UPDATED;
		}
		header("location: emailStatementSetting.php");
		exit;
	}
		
	$arryAdmin = $objCommon->GetCronSettings('EmailStatement');	
	require_once("../includes/footer.php"); 	
