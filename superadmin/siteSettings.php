<?php
	require_once("includes/header.php");
	require_once("../classes/function.class.php");
	$objFunction=new functions();
	$objAdmin = new admin();

	

	if($_POST) {   
		CleanPost();

		if($objAdmin->UpdateSiteSettings($_POST)){
			$_SESSION['mess_setting'] = SETTING_UPDATED;
		}
		 
		
		/*********************************************/
		
		if($_FILES['SiteLogo']['name'] != ''){
			$imageName = "site_logo";
			$FileInfoArray['FileType'] = "Image";
			$FileInfoArray['FileDir'] = $Config['SiteLogoDir'];
			$FileInfoArray['FileID'] = $imageName;
			$FileInfoArray['OldFile'] = $_POST['OldImage'];
			$ResponseArray = $objFunction->UploadFile($_FILES['SiteLogo'], $FileInfoArray);			  
			if($ResponseArray['Success']=="1"){  
				$objAdmin->UpdateImage($ResponseArray['FileName'],'SiteLogo');
			 }else{
				$ErrorMsg = $ResponseArray['ErrorMsg'];
			}
			if(!empty($ErrorMsg)){
				if(!empty($_SESSION['mess_setting'])) $ErrorPrefix = '<br><br>';
				$_SESSION['mess_setting'] .= $ErrorPrefix.$ErrorMsg;
			}
			 
		}
	
		 
		 		
		 		
		
		header("location: siteSettings.php");
		exit;
	}
	
	
	$arryAdmin = $objAdmin->GetSiteSettings(1);

	#$arrayPaymentGateways = $objAdmin->GetPaymentGateways();

	if($_SESSION['AdminType']=="user"){ 
		$CurrPageName = 'siteSettings.php';
		$arrayPageDt = $objUserConfig->GetSIteMenuByLink($_SESSION['AdminID'],$CurrPageName);
	}else{
		$arrayPageDt[0]['ModifyLabel']=1;
	}
	
	require_once("includes/footer.php"); 
 
 ?>
