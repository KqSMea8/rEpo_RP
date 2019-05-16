<?php 
	/**************************************************/
	$ThisPageName = 'viewFaq.php'; $EditPage = 1; 
	/**************************************************/

	include_once("includes/header.php");

	require_once("../classes/superAdminCms.class.php");
	//require_once("../classes/class.validation.php");
	require_once("../classes/function.class.php");
	$objFunction	=	new functions();
	$supercms=new supercms();

	$_GET['edit'] = (int)$_GET['edit'];
  	$FaqID = (int)$_GET['edit'];
	$_GET['active_id'] = (int)$_GET['active_id'];
	$_GET['del_id'] = (int)$_GET['del_id'];
	$ModuleName = 'FAQ';
	
	$ListUrl    = "viewFaq.php?curP=".$_GET['curP'];

  	if(!empty($_GET['active_id'])){
		$_SESSION['mess_faq'] = FAQ_STATUS_CHANGED;
		$supercms->changeFaqStatus($_GET['active_id']);
		header("location:".$ListUrl);
		exit;
	 }
	

	 if(!empty($_GET['del_id'])){             
                $_SESSION['mess_faq'] = FAQ_REMOVED;
                $supercms->deleteFaq($_GET['del_id']);
                header("location:".$ListUrl);
                exit;
	}

 
		 
	 if (!empty($_POST)) {

		$Content = $_POST['Content'];
		CleanPost(); 
		$_POST['Content'] = $Content;

		if($_FILES['Image']['name'] != ''){		
			/*$imageName = time(). $_FILES['Image']['name'];						
			$ImageDestinatiobvn = "../upload/faq/".$imageName; 
			move_uploaded_file($_FILES['Image']['tmp_name'], $ImageDestinatiobvn);*/
			
			$imageFile = escapeSpecial($_FILES['Image']['name']); 
			$FileInfoArray['FileType'] = "Image";
			$FileInfoArray['FileDir'] = $Config['FaqDir'];
			$FileInfoArray['FileID'] = $imageFile;
			$FileInfoArray['OldFile'] = $_POST['OldImage'];
			$ResponseArray = $objFunction->UploadFile($_FILES['Image'], $FileInfoArray);	

			if($ResponseArray['Success']=="1"){  
				$imageName = $ResponseArray['FileName']; 
			}else{
				$ErrorMsg = $ResponseArray['ErrorMsg'];
			}

		}     
		if (!empty($FaqID)) {
			$_SESSION['mess_faq'] = FAQ_UPDATED;
			$supercms->updateFaq($_POST,$imageName);				
		} else {   
			$_SESSION['mess_faq'] = FAQ_ADDED;
			$lastShipId = $supercms->addFaq($_POST,$imageName);	
		}

		if(!empty($ErrorMsg)){
			if(!empty($_SESSION['mess_faq'])) $ErrorPrefix = '<br><br>';
			$_SESSION['mess_faq'] .= $ErrorPrefix.$ErrorMsg;
		}
		header("location:".$ListUrl);
		exit;

	}
      


    if (!empty($FaqID)){
		$arryeditFaq = $supercms->getFaqById($FaqID);
     		
	}
	
	if($arryeditFaq[0]['Status'] == "0"){
		$FaqStatus = "0";
	}else{
		$FaqStatus = "1";
	}                           

	
		
	require_once("includes/footer.php"); 	 
?>


