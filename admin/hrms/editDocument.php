<?php
	/**************************************************/
	$ThisPageName = 'viewDocument.php'; $EditPage = 1;
	/**************************************************/

	require_once("../includes/header.php");
	require_once($Prefix."classes/hrms.class.php");
	require_once($Prefix."classes/function.class.php");
	$objFunction=new functions();
	$objCommon=new common();
	
	$ModuleName = "Document";
	$RedirectURL = "viewDocument.php?curP=".$_GET['curP'];


	 if(!empty($_GET['del_id'])){
		$_SESSION['mess_document'] = DOC_REMOVED;
		$objCommon->deleteDocument($_GET['del_id']);
		header("Location:".$RedirectURL);
		exit;
	}


	 if(!empty($_GET['active_id'])){
		$objCommon->changeDocumentPublish($_GET['active_id']);
		header("Location:".$RedirectURL);
		exit;
	}


	if ($_POST) {
		CleanPost(); 
		if (!empty($_POST['documentID'])) {
			$objCommon->updateDocument($_POST);
			$documentID = $_POST['documentID'];
			$_SESSION['mess_document'] = DOC_UPDATED;
			
		} else {		
			$documentID = $objCommon->addDocument($_POST);
			$_SESSION['mess_document'] = DOC_ADDED;
		}
		

		/*****************************************/
		if($_FILES['document']['name'] != ''){
			$heading = escapeSpecial($_POST['heading']);			 

			$FileInfoArray['FileType'] = "Document";
			$FileInfoArray['FileDir'] = $Config['H_DocumentDir'];
			$FileInfoArray['FileID'] =  $heading."_".$documentID;
			$FileInfoArray['OldFile'] = $_POST['OldDocument'];
			$FileInfoArray['UpdateStorage'] = '1';
			$ResponseArray = $objFunction->UploadFile($_FILES['document'], $FileInfoArray);
			if($ResponseArray['Success']=="1"){  
				$objCommon->UpdateDocumentFile($ResponseArray['FileName'],$documentID); 
			}else{
				$ErrorMsg = $ResponseArray['ErrorMsg'];
			}

			if(!empty($ErrorMsg)){
				if(!empty($_SESSION['mess_document'])) $ErrorPrefix = '<br><br>';
				$_SESSION['mess_document'] .= $ErrorPrefix.$ErrorMsg;
			}

		}

		/*********************************************/

		
		
	
		header("Location:".$RedirectURL);
		exit;
		
	}
	
	$Status = 1;
	if($_GET['edit']>0)
	{
		$arryDocument = $objCommon->getDocument($_GET['edit'],0,'');
		$PageHeading = 'Edit Document: '.stripslashes($arryDocument[0]['heading']);
	}

	


  require_once("../includes/footer.php"); 

?>

