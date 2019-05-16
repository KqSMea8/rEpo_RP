<?php 
	/**************************************************/
	$ThisPageName = 'viewNews.php'; $EditPage = 1;
	/**************************************************/
	
	require_once("../includes/header.php"); 
	require_once($Prefix."classes/hrms.class.php");
	require_once($Prefix."classes/function.class.php");
	$objFunction=new functions();
	$objCommon=new common();
	
	$ModuleName = "Announcement";
	
	$RedirectUrl = "viewNews.php?curP=".$_GET['curP'];


	$EditUrl = "editNews.php?edit=".$_GET['edit'].'&tab=';
	$ActionUrl = $EditUrl.$_GET['tab'];



	if(!empty($_GET['del_doc'])){
		$_SESSION['mess_news'] = DOC_REMOVED;
		$objCommon->RemoveNewsDoc($_GET['del_doc'],'');
		header("Location:".$ActionUrl);
		exit;
	}

	if($_GET['del_id'] && !empty($_GET['del_id'])){
		$_SESSION['mess_news'] = NEWS_REMOVED;
		$objCommon->deleteNews($_GET['del_id']);
		header("location:".$RedirectUrl);
		exit;
	}
	
	if($_GET['active_id'] && !empty($_GET['active_id'])){
		$_SESSION['mess_news'] = NEWS_STATUS_CHANGED;
		$objCommon->changeNewsStatus($_GET['active_id']);
		header("location:".$RedirectUrl);
		exit;
	}	

	if ($_POST) { 
		
		if($_GET['tab']=='document') {
			/**********************/
			CleanPost(); 
			$LastInsertId = $_GET['edit'];
			if($_FILES['Document']['name'] != ''){
				
				$DocumentTitle = escapeSpecial($_POST['DocumentTitle']); 

				$FileInfoArray['FileType'] = $_POST['DocType'];
				$FileInfoArray['FileDir'] = $Config['NewsDir'];
				$FileInfoArray['FileID'] =  $DocumentTitle.$LastInsertId;
				$FileInfoArray['OldFile'] = $_POST['OldDocument'];
				$FileInfoArray['UpdateStorage'] = '1';
				$ResponseArray = $objFunction->UploadFile($_FILES['Document'], $FileInfoArray);
				if($ResponseArray['Success']=="1"){  
					$objCommon->AddNewsDoc($LastInsertId, $ResponseArray['FileName'], 'News' , $_POST['DocumentTitle']);	
					$_SESSION['mess_news'] = DOC_UPLOADED;				 
				}else{
					$ErrorMsg = $ResponseArray['ErrorMsg'];
				}  

				if(!empty($ErrorMsg)){
					if(!empty($_SESSION['mess_news'])) $ErrorPrefix = '<br><br>';
					$_SESSION['mess_news'] .= $ErrorPrefix.$ErrorMsg;
				}

				header("location:".$ActionUrl);
				exit;
			}
			/**********************/
		}else if(!empty($_POST['newsID'])) {
			$objCommon->updateNews($_POST);
			$ImageId = $_POST['newsID'];
			$_SESSION['mess_news'] = NEWS_UPDATED;
			
		}else {		
			$ImageId = $objCommon->addNews($_POST);
			$_SESSION['mess_news'] = NEWS_ADDED;
		}		
		
		/************************************/
		if($_FILES['Image']['name'] != ''){

			$FileInfoArray['FileType'] = "Image";
			$FileInfoArray['FileDir'] = $Config['NewsDir'];
			$FileInfoArray['FileID'] =  $ImageId;
			$FileInfoArray['OldFile'] = $_POST['OldImage'];
			$FileInfoArray['UpdateStorage'] = '1';
			$ResponseArray = $objFunction->UploadFile($_FILES['Image'], $FileInfoArray);
			if($ResponseArray['Success']=="1"){  
				$objCommon->UpdateImage($ResponseArray['FileName'],$ImageId); 
			}else{
				$ErrorMsg = $ResponseArray['ErrorMsg'];
			}
 
			if(!empty($ErrorMsg)){
				if(!empty($_SESSION['mess_news'])) $ErrorPrefix = '<br><br>';
				$_SESSION['mess_news'] .= $ErrorPrefix.$ErrorMsg;
			}

		}
		/************************************/
	
		header("location:".$RedirectUrl);
		exit;
		
	}
	

	$PageTitle = $ModuleName;
	$Status = 1;
	if($_GET['edit']>0)
	{
		$arryNews = $objCommon->getNews($_GET['edit'],'');
		$PageHeading = 'Edit Announcement: '.stripslashes($arryNews[0]['heading']);
		$Status   = $arryNews[0]['Status'];
		$newsID   = $arryNews[0]['newsID'];

		if($_GET['tab']=='document'){
			$PageTitle = 'Documents';
		}


	}

	
	

	require_once("../includes/footer.php");  
 ?>
