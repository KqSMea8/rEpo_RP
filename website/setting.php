<?php 
 	include_once("../includes/header.php");
	require_once($Prefix."classes/webcms.class.php");
        
	 $webcmsObj=new webcms();
	  
	 if (is_object($webcmsObj)) {
	 	$arrySetting=$webcmsObj->getSetting();
		$num=$webcmsObj->numRows();
		
		$arryMenutype=$webcmsObj->getMenutype();
		
		if ($_POST) {
			$ModuleName = 'Template';			
			$_SESSION['mess_Page'] = $ModuleName.UPDATED;	
			$ListUrl    = "setting.php";

			
			$webcmsObj->updateSetting($_POST);
		
			if($_FILES['Logo']['name']!=''){
				
				$MainDir = $Prefix."upload/company/logo/";                         
								if (!is_dir($MainDir)) {
									mkdir($MainDir);
									chmod($MainDir,0777);
								}
				$ImageExtension = GetExtension($_FILES['Logo']['name']); 
				$ImageId=$_SESSION['CmpID'];
				$imageName = $ImageId.".".$ImageExtension;	
							
				$ImageDestination = $MainDir.$imageName; 
				
				if(!empty($_POST['OldImage']) && file_exists($_POST['OldImage'])){
							$OldImageSize = filesize($_POST['OldImage'])/1024; //KB
							unlink($_POST['OldImage']);		
						}			
				if(@move_uploaded_file($_FILES['Logo']['tmp_name'], $ImageDestination)){
					$webcmsObj->UpdateImage($imageName);
					$objConfigure->UpdateStorage($ImageDestination,$OldImageSize,0);
					
				}
			}
			
			header("location:".$ListUrl);
			
			exit;
			
		}
	
       }
  
  require_once("../includes/footer.php");
  
?>
