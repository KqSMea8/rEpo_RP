<?php 
 	include_once("includes/header.php");
	require_once($Prefix."classes/webcms.class.php");
        
	 $webcmsObj=new webcms();
	  
	 if (is_object($webcmsObj)) {
	 	$CustomerID=  $_GET['CustomerID'];
	 	
	 	$arrySetting=$webcmsObj->getSetting($CustomerID);
		$num=$webcmsObj->numRows();
		
		if(empty($arrySetting[0]['Id'])){
			$arrySetting = $objConfigure->GetDefaultArrayValue('web_setting');
		}



		$arryMenutype=$webcmsObj->getMenutype();
		
		if ($_POST) {
			$ModuleName = 'Setting';			
			$_SESSION['mess_Page'] = $ModuleName.UPDATED;	
			$ListUrl    = "setting.php?&CustomerID=".$CustomerID;

			
			$webcmsObj->updateSetting($_POST);
		
			if($_FILES['Logo']['name']!=''){
				
				$MainDir = $Prefix."upload/company/logo/";                         
								if (!is_dir($MainDir)) {
									mkdir($MainDir);
									chmod($MainDir,0777);
								}
				$ImageExtension = GetExtension($_FILES['Logo']['name']); 
				$ImageId=$_SESSION['CmpID'].'_'.$CustomerID;
				$imageName = $ImageId.".".$ImageExtension;	
							
				$ImageDestination = $MainDir.$imageName; 
				
				if(!empty($_POST['OldImage']) && file_exists($_POST['OldImage'])){
							$OldImageSize = filesize($_POST['OldImage'])/1024; //KB
							unlink($_POST['OldImage']);		
						}			
				if(@move_uploaded_file($_FILES['Logo']['tmp_name'], $ImageDestination)){
					$webcmsObj->UpdateImage($imageName,$CustomerID);
					$objConfigure->UpdateStorage($ImageDestination,$OldImageSize,0);
					
				}
			}
			
			header("location:".$ListUrl);
			
			exit;
			
		}
	
       }
    $RedirectURL = "dashboard.php?curP=".$_GET['curP'];     
  $MainModuleName='Setting';
  require_once("includes/footer.php");
  
?>
