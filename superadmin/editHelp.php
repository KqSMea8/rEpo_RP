<?php 

	/**************************************************/
	$ThisPageName = 'viewHelp.php'; $EditPage = 1; 
	/**************************************************/
	require_once("includes/header.php");
	require_once("../classes/help.class.php");
	require_once("../classes/function.class.php");

	$objFunction	=	new functions();
	$objHelp	=	new help();

	(empty($_GET['depID']))?($_GET['depID']=''):(""); 


	$ModuleName = "Help";
	$RedirectURL = "viewHelp.php?depID=".$_GET['depID'];

	$arryDepartmentName = $objHelp->GetDepartmentName('');
	$arryCategoryName = $objHelp->GetHelpCategory('','');


	$arraydepartById = $objHelp->departById($_GET['edit']);
	$arraycategoryNametById = $objHelp->categoryNametById($_GET['edit']);


	$EditUrl = "editHelp.php?edit=".$_GET["edit"]."&curP=".$_GET["curP"]; 
	

	if($_GET['del_id'] && !empty($_GET['del_id'])){
		$_SESSION['mess_help'] = WORKFLOW_REMOVED;
		$objHelp->RemoveHelp($_GET['del_id']);
		header("Location:".$RedirectURL);
		exit;
	}
	

	 if($_GET['active_id'] && !empty($_GET['active_id'])){
		$_SESSION['mess_help'] = WORKFLOW_STATUS_CHANGED;
		$objHelp->changeHelpStatus($_GET['active_id']);
		header("Location:".$RedirectURL);
		exit;
	}
	

	
	 if($_POST){
	 	/*******************/
		$Content = $_POST['Content'];
		CleanPost(); 
		$_POST['Content'] = $Content;
		/*******************/
	
	        if (empty($_POST['Heading'])) {
				$errMsg = ENTER_HEADING;
			 } 
				
			 
		        	if (!empty($_GET['edit'])) {
		        	
					$WsID = $_GET['edit'];
					$objHelp->UpdateHelp($_POST);
 
					$_SESSION['mess_help'] = WORKFLOW_UPDATED;
				} else {	
					$WsID = $objHelp->AddHelp($_POST); 
					$_SESSION['mess_help'] = WORKFLOW_ADDED;
				}			
			 
			
	 	if($_FILES['UploadDoc']['name'] != ''){
	 		
			/*$FileArray = $objFunction->CheckUploadedFile($_FILES['UploadDoc'],"Document");			

				if(empty($FileArray['ErrorMsg'])){
					$documentExtension = GetExtension($_FILES['UploadDoc']['name']);
					$heading = escapeSpecial($_FILES['UploadDoc']['name']);
					$documentName = $heading."_".$WsID.".".$documentExtension;	
					$MainDir = "../upload/help/document/";	

					if (!is_dir($MainDir))
					 {
					 	
						mkdir($MainDir);
						chmod($MainDir,0777);
				
					}
					$documentDestination = $MainDir.$documentName;	
					   
					if(!empty($_POST['UploadDoc']) && file_exists($_POST['UploadDoc'])){
					$OldFileSize = filesize($_POST['UploadDoc'])/1024; //KB
					unlink($_POST['UploadDoc']);		
					}


				if(@move_uploaded_file($_FILES['UploadDoc']['tmp_name'], $documentDestination)){

				    $objHelp->UpdateDocWorkFlow($documentName,$WsID);
				    
			     	} else{
					$ErrorMsg = $_FILES["UploadDoc"]["error"];
				}
			}else{
				$ErrorMsg = $FileArray['ErrorMsg'];
			}
			if(!empty($_SESSION['mess_help'])) $ErrorPrefix = '<br><br>';
			$_SESSION['mess_help'] .= $ErrorPrefix.$ErrorMsg;*/

			$heading = escapeSpecial($_FILES['UploadDoc']['name']);
			$documentName = $heading."_".$WsID;
			$FileInfoArray['FileType'] = "Document";
			$FileInfoArray['FileDir'] = $Config['HelpDoc'];
			$FileInfoArray['FileID'] = $documentName;
			$FileInfoArray['OldFile'] = $_POST['OldUploadDoc'];
			$ResponseArray = $objFunction->UploadFile($_FILES['UploadDoc'], $FileInfoArray);
 
			if($ResponseArray['Success']=="1"){  
				 $objHelp->UpdateDocWorkFlow($ResponseArray['FileName'],$WsID);
			}else{
				$ErrorMsg = $ResponseArray['ErrorMsg'];
			}
			if(!empty($ErrorMsg)){
				if(!empty($_SESSION['mess_help'])) $ErrorPrefix = '<br><br>';
				$_SESSION['mess_help'] .= $ErrorPrefix.$ErrorMsg;
			}
		}
	
			
	      /************************* Video Upload Start *********************************/
			
	 	if($_FILES['Videolink']['name'] != ''){
	 	
	 		/*$VideoFileArray = $objFunction->CheckUploadedFile($_FILES['Videolink'],"Video");	
                     
					if(empty($VideoFileArray['ErrorMsg'])){
						$documentExtensionVideo = GetExtension($_FILES['Videolink']['name']);
						$headingvideo = escapeSpecial($_FILES['Videolink']['name']);
						$documentVideoName = $headingvideo."_".$WsID.".".$documentExtensionVideo;	
						$MainDirVideo = "../upload/help/video/";	
			            //echo "<pre>";print_r($MainDirVideo);die;
						if (!is_dir($MainDirVideo))
						 {						 
							mkdir($MainDirVideo);
							chmod($MainDirVideo,0777);
							
						}
						$documentDestinationVideo = $MainDirVideo.$documentVideoName;	
	                   
if(!empty($_POST['Videolink']) && file_exists($_POST['Videolink'])){
	$OldFileSize = filesize($_POST['Videolink'])/1024; //KB
	unlink($_POST['Videolink']);		
}
					if(@move_uploaded_file($_FILES['Videolink']['tmp_name'], $documentDestinationVideo)){
					
				            $objHelp->UpdateVideoWorkFlow($documentVideoName,$WsID);
					   
			             	} else{
						$ErrorMsg = $_FILES["Videolink"]["error"];
					}
				}else{
					$ErrorMsg = $VideoFileArray['ErrorMsg'];
				}

				if(!empty($_SESSION['mess_help'])) $ErrorPrefix = '<br><br>';


				$_SESSION['mess_help'] .= $ErrorPrefix.$ErrorMsg;*/

			$heading = escapeSpecial($_FILES['Videolink']['name']);
					$vedioName = $heading."_".$WsID;
					$FileInfoArray['FileType'] = "Video";
					$FileInfoArray['FileDir'] = $Config['HelpVedio'];
					$FileInfoArray['FileID'] = $vedioName;
					$FileInfoArray['OldFile'] = $_POST['OldVideolink'];
					$ResponseArray = $objFunction->UploadFile($_FILES['Videolink'], $FileInfoArray);	

					if($ResponseArray['Success']=="1"){  
						
						$objHelp->UpdateVideoWorkFlow($ResponseArray['FileName'],$WsID);
					}else{
						$ErrorMsg = $ResponseArray['ErrorMsg'];
					}
					if(!empty($ErrorMsg)){
						if(!empty($_SESSION['mess_help'])) $ErrorPrefix = '<br><br>';
						$_SESSION['mess_help'] .= $ErrorPrefix.$ErrorMsg;
						}

			}
			
			$RedirectURL = "viewHelp.php?depID=".$_POST['Department'];
			header("Location:".$RedirectURL);
			exit;
				
			/**/
			
		}
		
	$WsID   = (int)$_GET['edit'];	
	if (!empty($_GET['edit'])) {
		$arryHelp = $objHelp->GetHelp($WsID,'');
		
		//print_r($arryHelp);
		
		
		/***************/
		if(empty($arryHelp[0]['WsID'])){
			header("Location:".$RedirectURL);
			exit;
		}
		/***************/	
	}else{
		$arraydepartById[0]['depID']   = $_GET['depID'];	
	}
				
	if($arryHelp[0]['Status'] != ''){
		$HelpStatus = $arryHelp[0]['Status'];
	}else{
		$HelpStatus = 1;
	}		
	
	/***************/	
	



	require_once("includes/footer.php"); 
?>


