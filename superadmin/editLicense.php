<?php 
    /**************************************************/
    $ThisPageName = 'viewLicense.php'; $EditPage = 1; 
    /**************************************************/
	require_once("includes/header.php");
	require_once("../classes/license.class.php");
	
	$ModuleName = "License Key";
	$RedirectURL = "viewLicense.php?curP=".$_GET['curP'];

	$EditUrl = "editLicense.php?edit=".$_GET["edit"]."&curP=".$_GET["curP"];
	$ActionUrl = $EditUrl.$_GET["tab"];
	$objLicense=new license();
	

	if($_GET['del_id'] && !empty($_GET['del_id'])){
		$_SESSION['mess_license'] = LICENSE_REMOVED;
		$objLicense->RemoveLicense($_GET['del_id']);
		header("Location:".$RedirectURL);
		exit;
	}
	

	 if($_GET['active_id'] && !empty($_GET['active_id'])){
		$_SESSION['mess_license'] = LICENSE_STATUS_CHANGED;
		$objLicense->changeLicenseStatus($_GET['active_id']);
		header("Location:".$RedirectURL);
		exit;
	}
	

	
	 if($_POST){	
			CleanPost();
			 if(empty($_POST['DomainName']) && empty($_POST['LicenseID'])) {
				$errMsg = ENTER_DOMAIN;
			 } else {
				if(!empty($_POST['LicenseID'])) {
					$LicenseID = $_POST['LicenseID'];			
					$objLicense->UpdateLicenseExpiry($_POST);
					$_SESSION['mess_license'] = LICENSE_UPDATED;
				}else{	
					if($objLicense->isDomainExists($_POST['DomainName'],'')){
						$_SESSION['mess_license'] = DOMAIN_ALREADY_EXIST;
					}else if($objLicense->isLicenseKeyExists($_POST['LicenseKey'],'')){
						$_SESSION['mess_license'] = LICENSE_KEY_ALREADY_EXIST;
					}else{	
						$LicenseID = $objLicense->AddLicense($_POST); 
						$_SESSION['mess_license'] = LICENSE_ADDED;
					}
				}				


				header("Location:".$RedirectURL);
				exit;
				/*if (!empty($_GET['edit'])) {
					header("Location:".$RedirectURL);
					exit;
				}else{
					header("Location:".$RedirectURL);
					exit;
				}*/


				
			}
		}
		

	/************************
	$arryLicenseKey['DomainName'] = '66.55.22.11';
	$arryLicenseKey['LicenseKey'] = GenerateKeyString();
	$arryLicenseKey['ExpiryDate'] = '2014-02-09';
	$arryLicenseKey['Status'] = '1';
	$arryLicenseKey['MaxUser'] = '55';
	$LicenseID = $objLicense->AddLicense($arryLicenseKey); 
	/************************/






	$LicenseID = $ExpiryDate= $BoxReadOnly = $DisabledClass = ''; 

	if(!empty($_GET['edit'])) {
		$arryLicense = $objLicense->GetLicense($_GET['edit'],'');
		$LicenseID   = $_GET['edit'];
		$BoxReadOnly = 'readonly';
		$DisabledClass = 'disabled'; 
	}
				
	if($arryLicense[0]['Status'] != ''){
		$LicenseStatus = $arryLicense[0]['Status'];
	}else{
		$LicenseStatus = 1;
	}
	require_once("includes/footer.php"); 
?>


