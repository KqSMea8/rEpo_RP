<?php 
	/**************************************************/
	$ThisPageName = 'databaseBackup.php';  $EditPage = 1; 
	/**************************************************/
	include_once("includes/header.php");
	$objAdmin = new admin();
	 
	if($_POST){
		CleanPost();
		if($objAdmin->UpdateDatabaseCronSetting($_POST)){
			$_SESSION['mess_cron'] = DBCRON_SETTING_UPDATED;
		}
		header("location: databaseCronSetting.php");
		exit;
	}
		
	$arryAdmin = $objAdmin->GetSiteSettings(1);		
	require_once("includes/footer.php");
?>


