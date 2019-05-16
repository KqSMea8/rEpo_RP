<?php
	require_once("includes/header.php");
	$objAdmin = new admin();
	if($_POST) {
		CleanPost();
		if($objAdmin->UpdateSiteSettings($_POST)){
			$_SESSION['mess_setting'] = SETTING_UPDATED;
		}
		
		/*
		if($_FILES['tutorial']['name'] != ''){
			$tutorialExtension = GetExtension($_FILES['tutorial']['name']);
			$tutorialName = 'tutorial_'.rand(1,20).".".$tutorialExtension;	
			$tutorialDestination = "../includes/".$tutorialName;
			if(@move_uploaded_file($_FILES['tutorial']['tmp_name'], $tutorialDestination)){
				$objAdmin->UpdateTutorialFile($tutorialName,$_POST['OldTutorial']);
			}
			
		}*/
		
		/*********************************************/
		
		if($_FILES['SiteLogo']['name'] != ''){
			$ImageExtension = GetExtension($_FILES['SiteLogo']['name']);
			$imageName = "site_logo.".$ImageExtension;	
			$ImageDestination = "../images/".$imageName;
			if(@move_uploaded_file($_FILES['SiteLogo']['tmp_name'], $ImageDestination)){
				$objAdmin->UpdateImage($imageName,'SiteLogo');
			}
		}
	
		/*********************************************/
		if($_POST['DelBodyBg']!='' && file_exists($_POST['DelBodyBg'])){
			unlink($_POST['DelBodyBg']);
		}
		
		if($_FILES['BodyBg']['name'] != ''){
			$ImageExtension = GetExtension($_FILES['BodyBg']['name']);
			$imageName = "bodybg.".$ImageExtension;	
			$ImageDestination = "../images/".$imageName;
			if(@move_uploaded_file($_FILES['BodyBg']['tmp_name'], $ImageDestination)){
				$objAdmin->UpdateImage($imageName,'BodyBg');
			}
		}
		/*********************************************/
		if($_POST['DelHomeImage']!='' && file_exists($_POST['DelHomeImage'])){
			unlink($_POST['DelHomeImage']);
		}
		
		if($_FILES['HomeImage']['name'] != ''){
			$ImageExtension = GetExtension($_FILES['HomeImage']['name']);
			$imageName = "flashimage.".$ImageExtension;	
			$ImageDestination = "../images/".$imageName;
			if(@move_uploaded_file($_FILES['HomeImage']['tmp_name'], $ImageDestination)){
				$objAdmin->UpdateImage($imageName,'HomeImage');
			}
		}		
		/*********************************************/
		if($_FILES['HomeFlash']['name'] != ''){
			$ImageExtension = GetExtension($_FILES['HomeFlash']['name']);
			$imageName = "flash".rand(1,100).".".$ImageExtension;	
			$ImageDestination = "../flash/".$imageName;
			if(@move_uploaded_file($_FILES['HomeFlash']['tmp_name'], $ImageDestination)){
				$objAdmin->UpdateFlash($imageName,$_POST['OldFlash']);
			}
		}		
		
		header("location: siteSettings.php");
		exit;
	}
	
	
	$arryAdmin = $objAdmin->GetSiteSettings(1);

	#$arrayPaymentGateways = $objAdmin->GetPaymentGateways();
	
	require_once("includes/footer.php"); 
 
 ?>
