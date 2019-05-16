<?php 

	/**************************************************/
	$ThisPageName = 'headerMenu.php'; $EditPage = 1; 
	/**************************************************/

	include_once("includes/header.php");

	require_once("../classes/superAdminCms.class.php");
	require_once("../classes/class.validation.php");
	require_once("../classes/function.class.php");

	$objFunction	=	new functions();	 
	$supercms = new supercms();
	$id = isset($_GET['edit'])?$_GET['edit']:"";
               
          if ( !empty($id)) {$ModuleTitle = "Edit Page";}else{$ModuleTitle = "Add Page";}
                $ModuleName = 'Social Link';
                $ListTitle  = 'Pages';
                $ListUrl    = "footerSocialLinksList.php?curP=".$_GET['curP'];
               
       
            if (!empty($id)) 
            {
                $arryPage = $supercms->getsocialLinkById($id);
            }else{
		$arryPage = $objConfigure->GetDefaultArrayValue('social_link');
	   }

			
		 	 
         if(!empty($_GET['active_id'])){
		$_SESSION['mess_footer_link'] = FOOTER_SOCIAL_STATUS_CHANGED;
		$supercms->changeSocialStatus($_REQUEST['active_id']);
		header("location:".$ListUrl);
		exit;
	 }
	

	 if(!empty($_GET['del_id'])){             
		$_SESSION['mess_footer_link'] = FOOTER_SOCIAL_REMOVED;
		$supercms->deleteSocialLink($_GET['del_id']);
		header("location:".$ListUrl);
		exit;
	}
		


 	if (is_object($supercms)) {	
		 
		 if (!empty($_POST)) {
		 	CleanPost();
     $data=array();

	$data=$_POST;

 

	if($_FILES['Icon']['name'] != ''){					
		/*$imageName = time(). $_FILES['Icon']['name'];						
		$ImageDestinatiobvn = "../images/".$imageName;
		@move_uploaded_file($_FILES['Icon']['tmp_name'], $ImageDestinatiobvn);*/

		$imageFile = escapeSpecial($_FILES['Icon']['name']); 
		$FileInfoArray['FileType'] = "Image";
		$FileInfoArray['FileDir'] = $Config['SiteIconDir'];
		$FileInfoArray['FileID'] = $imageFile;
		$FileInfoArray['OldFile'] = $_POST['OldIcon'];
		$ResponseArray = $objFunction->UploadFile($_FILES['Icon'], $FileInfoArray);	

		if($ResponseArray['Success']=="1"){  
			$imageName = $ResponseArray['FileName']; 
		}else{
			$ErrorMsg = $ResponseArray['ErrorMsg'];
		}
				
	}
									
	$errors=array();
	$validatedata=array(	
		'priority'=>array(array('rule'=>'notempty','message'=>'Please Enter The Priority')),
		'uri'=>array(array('rule'=>'notempty','message'=>'Please Enter The UTI'))
		)	;
		$objVali->requestvalue=$data;
		$errors  =	$objVali->validate($validatedata);
 
		if(empty($errors)){

			if(!empty($id)) {
				$_SESSION['mess_footer_link'] = FOOTER_SOCIAL_UPDATED;

				$supercms->updateSocialLink($_POST,$imageName);    
			}else{	   
				$_SESSION['mess_footer_link'] = FOOTER_SOCIAL_ADDED;
				$lastShipId = $supercms->addSocialLink($_POST,$imageName);	  
			}

			if(!empty($ErrorMsg)){
				if(!empty($_SESSION['mess_footer_link'])) $ErrorPrefix = '<br><br>';
				$_SESSION['mess_footer_link'] .= $ErrorPrefix.$ErrorMsg;
			}

			header("location:".$ListUrl);
			exit;

		}
		
                         
			
	}
		

	
	
		
		if($arryPage[0]['Status'] == "No"){
			$PageStatus = "No";
		}else{
			$PageStatus = "Yes";
		}
		
                
                              
}
	

	
		
	require_once("includes/footer.php"); 	 
?>


