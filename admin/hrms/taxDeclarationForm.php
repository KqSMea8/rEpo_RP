<?php
	/**************************************************/
	$EditPage = 1;
	/**************************************************/

	require_once("../includes/header.php");
	require_once($Prefix."classes/hrms.class.php");
	require_once($Prefix."classes/function.class.php");
	$objFunction=new functions();
	$objCommon=new common();
	
	$ModuleName = "Document";
	$RedirectURL = "viewDocument.php?curP=".$_GET['curP'];


	 if(!empty($_GET['del_id'])){
		$_SESSION['mess_tax'] = DOC_REMOVED;
		$objCommon->deleteDocument($_GET['del_id']);
		header("Location:".$RedirectURL);
		exit;
	}

	if($_POST){

		$documentID = $objCommon->updateTaxDocument($_POST);
		$_SESSION['mess_tax'] = DOC_UPDATED;

		/*****************************************/
		if($_FILES['document']['name'] != ''){
			$arrHeading=explode(".",$_FILES['document']['name']);
			$heading = escapeSpecial($arrHeading[0]);

			$FileInfoArray['FileType'] = "Document";
			$FileInfoArray['FileDir'] = $Config['DeclarationDir'];
			$FileInfoArray['FileID'] = $heading."_".$documentID;
			$FileInfoArray['OldFile'] = $_POST['OldDocument'];
			$FileInfoArray['UpdateStorage'] = '1';
			$ResponseArray = $objFunction->UploadFile($_FILES['document'], $FileInfoArray);
			if($ResponseArray['Success']=="1"){  
				$objCommon->UpdateTaxFile($ResponseArray['FileName'],$documentID);
		 	}else{
				$ErrorMsg = $ResponseArray['ErrorMsg'];
			}
 
			if(!empty($ErrorMsg)){
				if(!empty($_SESSION['mess_tax'])) $ErrorPrefix = '<br><br>';
				$_SESSION['mess_tax'] .= $ErrorPrefix.$ErrorMsg;
			}

		}
		
		
		header("Location: taxDeclarationForm.php");
		exit;
		
	}
	
	
	$arryDocument = $objCommon->getTaxDocument('','','');
	$publish = $arryDocument[0]['publish'];
	if(empty($arryDocument[0]['documentID'])) $publish=1;


    require_once("../includes/footer.php"); 

?>
