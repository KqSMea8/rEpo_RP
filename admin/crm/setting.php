<?php   $ThisPageName = 'viewCustomer.php'; $EditPage = 1;
 	include_once("../includes/header.php");
	require_once($Prefix."classes/webcms.class.php");
	require_once($Prefix."classes/function.class.php");
        
	$webcmsObj=new webcms();
	$objFunction=new functions();
	  
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
		
		if($webcmsObj->isSitenameExists($_POST['Sitename'],$CustomerID)){
			$_SESSION['mess_Page']='Site Name Already Exist';
		}else{
			
		$webcmsObj->updateSetting($_POST);
	
		/*if($_FILES['Logo']['name']!=''){
			
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
		}*/
		if($_FILES['Logo']['name'] != ''){

			$FileInfoArray['FileType'] = "Image";
			$FileInfoArray['FileDir'] = $Config['CmpDir'];
			$FileInfoArray['FileID'] = $_SESSION['CmpID'].'_'.$CustomerID;
			$FileInfoArray['OldFile'] = $_POST['OldImage'];
			$FileInfoArray['UpdateStorage'] = '1';
			$ResponseArray = $objFunction->UploadFile($_FILES['Logo'], $FileInfoArray);
			if($ResponseArray['Success']=="1"){	 
				
				$webcmsObj->UpdateImage($ResponseArray['FileName'],$CustomerID);			
			}else{
				$ErrorMsg = $ResponseArray['ErrorMsg'];
			}

			if(!empty($ErrorMsg)){
				$_SESSION['mess_Page'] .= '<br><br>'.$ErrorMsg;
			}

		}

		}
		
		
		
		header("location:".$ListUrl);
		
		exit;
		
	}
	
       
  $MainModuleName='Setting';
  require_once("../includes/footer.php");
  
?>
