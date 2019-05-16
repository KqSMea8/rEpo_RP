<?php
	/**************************************************/
	$EditPage = 1; $_GET['edit']=999;
	/**************************************************/
	require_once("includes/header.php");
	

	
	
	//$RedirectUrl = "inventorySetting.php?d=".$_GET['d'];
	$arryDashboardIcon=$objConfigure->GetInventryMenuItems();
	
	
	$numModule = sizeof($arryDashboardIcon);
	
	$arrySubmenu=$objConfigure->GetInventrySumMenuItems();
	//echo "<pre>"; print_r($arrySubmenu);exit;

	$numModule1 = sizeof($arrySubmenu);
	
	
	$RedirectUrl = "inventorySetting.php";
	
	
	if ($_POST) 
	{	CleanPost();
		if(!empty($_POST['numModule']))
		 {
		 	//echo "<pre>"; print_r($_POST);exit;
		 	$objConfigure->updateInventorySettingSumenu($_POST);
			$objConfigure->updateInventorySettings($_POST);
			
			
			
			
			$_SESSION['mess_dash'] = INV_SETTING_UPDATED;
		}
		header("location: ".$RedirectUrl);
		exit;
	}

	


	require_once("includes/footer.php");  
 ?>
