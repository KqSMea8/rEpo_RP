<?php
	/**************************************************/
	$EditPage = 1;
	/**************************************************/
	require_once("includes/header.php");
	
	$RedirectUrl = "mngDashboard.php?d=".$_GET['d'];

	if ($_POST) {
		if(!empty($_POST['numModule'])) {
			$objConfigure->updateDashboardSettings($_POST);
			$_SESSION['mess_dash'] = DASH_ICON_UPDATED;
		}
		header("location: ".$RedirectUrl);
		exit;
	}


	 if($_GET["d"]>0){
		$arryDepartmentInfo = $objConfigure->GetDepartmentInfo($_GET["d"]);
		$Department = strtolower(stripslashes($arryDepartmentInfo[0]["Department"]));
		
		$arryDashboardIcon = $objConfigure->GetDashboardIcon($_GET['d'],'1','');
		$numModule = sizeof($arryDashboardIcon);
	 }



	require_once("includes/footer.php");  
 ?>