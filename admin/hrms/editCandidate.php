<?php 
	/**************************************************/
	$ThisPageName = 'viewCandidate.php'; $EditPage = 1;
	/**************************************************/

	include_once("../includes/header.php");
	require_once($Prefix."classes/candidate.class.php");	
	require_once($Prefix."classes/hrms.class.php");
	require_once($Prefix."classes/function.class.php");
	$objFunction=new functions();
	$objCommon=new common();
	$objCandidate=new candidate();
	$ModuleName = "Candidate";	$module = $_GET['module'];
	/**************/
	$ModuleArray = array('Manage','Shortlisted','Offered'); 
	if(!in_array($_GET['module'],$ModuleArray)){
		header("location:home.php");die;		 
	}
	/**************/

	$RedirectURL = "viewCandidate.php?module=".$module."&curP=".$_GET['curP'];

	if($module!="Manage"){
		$RedirectURL = "viewCandidate.php?module=Manage&curP=".$_GET['curP'];
		header("location: ".$RedirectURL);
		exit;
	}


	
	/*********  Multiple Actions To Perform **********/
	 if(!empty($_GET['multiple_action_id'])){
	 	$multiple_action_id = rtrim($_GET['multiple_action_id'],",");
		
		$mulArray = explode(",",$multiple_action_id);
	
		switch($_GET['multipleAction']){
			case 'delete':
					foreach($mulArray as $del_id){
						$objCandidate->RemoveCandidate($del_id);
					}
					$_SESSION['mess_candidate'] = CANDIDATE_REMOVED;
					break;
			case 'active':
					$objCandidate->MultipleCandidateStatus($multiple_action_id,1);
					$_SESSION['mess_candidate'] = CANDIDATE_STATUS_CHANGED;
					break;
			case 'inactive':
					$objCandidate->MultipleCandidateStatus($multiple_action_id,0);
					$_SESSION['mess_candidate'] = CANDIDATE_STATUS_CHANGED;
					break;				
		}
		header("location: ".$RedirectURL);
		exit;
		
	 }
	
	/*********  End Multiple Actions **********/		

	if($_GET['del_id'] && !empty($_GET['del_id'])){
		$_SESSION['mess_candidate'] = CANDIDATE_REMOVED;
		$objCandidate->RemoveCandidate($_GET['del_id']);
		header("Location:".$RedirectURL);
		exit;
	}
	

	 if($_GET['active_id'] && !empty($_GET['active_id'])){
		$_SESSION['mess_candidate'] = CANDIDATE_STATUS_CHANGED;
		$objCandidate->changeCandidateStatus($_GET['active_id']);
		header("Location:".$RedirectURL);
		exit;
	}
	

	
	 if ($_POST) {
			CleanPost(); 

			 if (empty($_POST['Email']) && empty($_POST['CanID'])) {
				$errMsg = ENTER_EMAIL;
			 } else {
				if (!empty($_POST['CanID'])) {
					$LastInsertId = $_POST['CanID'];
					$objCandidate->UpdateCandidate($_POST);
					$_SESSION['mess_candidate'] = CANDIDATE_UPDATED;
				} else {	
					if($objCandidate->isEmailExists($_POST['Email'],'')){
						$_SESSION['mess_candidate'] = EMAIL_ALREADY_REGISTERED;
					}else{	
						$LastInsertId = $objCandidate->AddCandidate($_POST); 
						$_SESSION['mess_candidate'] = CANDIDATE_ADDED;
					}
				}
				
				$_POST['CanID'] = $LastInsertId; 



				/************************************/
				if($_FILES['Resume']['name'] != ''){

					$FileInfoArray['FileType'] = "Resume";
					$FileInfoArray['FileDir'] = $Config['CandResumeDir'];
					$FileInfoArray['FileID'] = $LastInsertId;
					$FileInfoArray['OldFile'] = $_POST['OldResume'];
					$FileInfoArray['UpdateStorage'] = '1';
					$ResponseArray = $objFunction->UploadFile($_FILES['Resume'], $FileInfoArray);
					if($ResponseArray['Success']=="1"){  
						$objCandidate->UpdateResume($ResponseArray['FileName'],$LastInsertId);
						 
					}else{
						$ErrorMsg = $ResponseArray['ErrorMsg'];
					}

 
					if(!empty($ErrorMsg)){
						if(!empty($_SESSION['mess_candidate'])) $ErrorPrefix = '<br><br>';
						$_SESSION['mess_candidate'] .= $ErrorPrefix.$ErrorMsg;
					}

				}

				/************************************/
				if($_FILES['Image']['name'] != ''){

					$FileInfoArray['FileType'] = "Image";
					$FileInfoArray['FileDir'] = $Config['CandidateDir'];
					$FileInfoArray['FileID'] = $LastInsertId;
					$FileInfoArray['OldFile'] = $_POST['OldImage'];
					$FileInfoArray['UpdateStorage'] = '1';
					$ResponseArray = $objFunction->UploadFile($_FILES['Image'], $FileInfoArray);
					if($ResponseArray['Success']=="1"){  
						$objCandidate->UpdateImage($ResponseArray['FileName'],$LastInsertId);
				 	}else{
						$ErrorMsg = $ResponseArray['ErrorMsg'];
					}

 

					if(!empty($ErrorMsg)){
						if(!empty($_SESSION['mess_candidate'])) $ErrorPrefix = '<br><br>';
						$_SESSION['mess_candidate'] .= $ErrorPrefix.$ErrorMsg;
					}

				}
				/************************************/


				


				header("Location:".$RedirectURL);
				exit;



				
			}
		}
		

	if (!empty($_GET['edit'])) {
		$arryCandidate = $objCandidate->GetCandidate($_GET['edit'],'');
		$PageHeading = 'Edit Candidate: '.stripslashes($arryCandidate[0]['UserName']);
		$CanID   = $_GET['edit'];	
	}
				
	if($arryCandidate[0]['Status'] != ''){
		$CandidateStatus = $arryCandidate[0]['Status'];
	}else{
		$CandidateStatus = 1;
	}				
		
	$arryVacancy = $objCandidate->GetVacancy('','Approved');
	$numVacancy = sizeof($arryVacancy);
	$arrySalaryFrequency = $objCommon->GetAttributeValue('SalaryFrequency','');
	$arryInterviewStatus = $objCommon->GetFixedAttribute('InterviewStatus','');		
	$arryInterviewTest = $objCommon->GetAttribValue('InterviewTest','');

	require_once("../includes/footer.php"); 	 
?>
