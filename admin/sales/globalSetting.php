<?php
	/**************************************************/
	$EditPage = 1;
	/**************************************************/
	include_once("../includes/header.php");
	require_once($Prefix."classes/finance.class.php");
	$objCommon = new common();
	$ListUrl = "globalSetting.php";
		 
	if(!empty($_POST)){
		if(empty($_POST['SO_APPROVE'])) $_POST['SO_APPROVE']=0;

		CleanPost();                                        
		$_SESSION['mess_setting'] = GLOBAL_UPDATED;
		$objCommon->updateSettingsFields($_POST);

		header("location:".$ListUrl);
		exit;		
	}

	$arrySettingFields = $objCommon->getSettingsFields($CurrentDepID,$group_id=1);



	require_once("../includes/footer.php"); 
  
 ?>
