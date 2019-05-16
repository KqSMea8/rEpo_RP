<?php
	/**************************************************/
	$EditPage = 1; $_GET['edit']=999;
	/**************************************************/
	require_once("includes/header.php");
	(empty($_GET['d']))?($_GET['d']=""):("");
	$RedirectUrl = "mngDashboard.php?d=".$_GET['d'];
	
	if ($_POST) {
		CleanPost();
		if(!empty($_POST['numModule'])) {
			$objConfigure->updateDashboardSettings($_POST);
			$_SESSION['mess_dash'] = DASH_ICON_UPDATED;
		}
		header("location: ".$RedirectUrl);
		exit;
	}
	
	$_GET["d"]=(int)$_GET["d"];
	$numModule=0;
	 if($_GET["d"]>0){
		$arryDepartmentInfo = $objConfigure->GetDepartmentInfo($_GET["d"]);
		$Department = strtolower(stripslashes($arryDepartmentInfo[0]["Department"]));
		
		$arryDashboardIcon = $objConfigure->GetDashboardIcon($_GET['d'],'1','');
		$numModule = sizeof($arryDashboardIcon);
	 }



	require_once("includes/footer.php");  
 ?>
