<?php 
	include_once("../includes/header.php");
	require_once($Prefix."classes/candidate.class.php");
	require_once($Prefix."classes/employee.class.php");
	require_once($Prefix."classes/hrms.class.php");
	require_once($Prefix."classes/user.class.php");
	include_once("includes/FieldArray.php");
	$objCommon=new common();
	$objCandidate=new candidate();
	$objEmployee=new employee();
	$objUser=new user();



	$ModuleName = "Candidate";	$module = $_GET['module'];
	/**************/
	$ModuleArray = array('Manage','Shortlisted','Offered'); 
	if(!in_array($_GET['module'],$ModuleArray)){
		header("location:home.php");die;		 
	}
	/**************/

	$ViewUrl = "viewCandidate.php?module=".$module;
	$AddUrl = "editCandidate.php?module=".$module;
	$EditUrl = "editCandidate.php?module=".$module."&curP=".$_GET['curP'];
	$ViewUrl = "vCandidate.php?module=".$module."&curP=".$_GET['curP'];

	$RedirectURL = "viewCandidate.php?module=".$module;


	if(!empty($_GET['shortlist'])){
		$_SESSION['mess_candidate'] = CANDIDATE_SHORTLISTED;
		$objCandidate->changeCandidateStatus($_GET['shortlist'],'Shortlisted');
		header("Location:".$RedirectURL);
		exit;
	}

	if(!empty($_GET['move_id'])){
		$_SESSION['mess_candidate'] = CANDIDATE_MOVED;
		$objCandidate->changeCandidateStatus($_GET['move_id'],'');
		header("Location:".$RedirectURL);
		exit;
	}

	if(!empty($_POST['JoinCanID'])){
		$arryCand = $objCandidate->GetCandidate($_POST['JoinCanID'],'');
		
		if($arryCand[0]['CanID']>0){
			$arryCand[0]['Status'] = 1;
			$arryCand[0]['Role'] = "Other";
			$arryCand[0]['main_city_id'] = $arryCand[0]['city_id'];
			$arryCand[0]['main_state_id'] = $arryCand[0]['state_id'];
			$arryCand[0]['JoiningDate'] = $_POST['JoiningDate'];
			$arryCand[0]['Department'] = $_POST['Department'];
			$arryCand[0]['JobTitle'] = $_POST['JobTitle'];
			$arryCand[0]['JobType'] = $_POST['JobType'];
			$arryCand[0]['Password'] = substr(md5(rand(3000,10000)),0,5);

			$LastInsertId = $objEmployee->AddEmployee($arryCand[0]); 
 
			/****** Add To User Table******/
			/*******************************/
			$arryCand[0]['UserType'] = "employee";
			$UserID = $objUser->AddUser($arryCand[0]);
			$objEmployee->query("update h_employee set UserID=".$UserID." where EmpID=".$LastInsertId, 0);
			/*******************************/
			/*******************************/


                        $FromDir = "upload/resume_cand/".$_SESSION['CmpID']."/";
                        $ToDir = "upload/resume/".$_SESSION['CmpID']."/";
			if($arryCand[0]['Resume'] !='' && file_exists($FromDir.$arryCand[0]['Resume']) ){
				$ResumeExtension = GetExtension($arryCand[0]['Resume']);
				$ResumeName = $LastInsertId.".".$ResumeExtension;				
				if(@copy($FromDir.$arryCand[0]['Resume'],$ToDir.$ResumeName)){
					$objEmployee->UpdateResume($ResumeName,$LastInsertId);
					unlink($FromDir.$arryCand[0]['Resume']);
				}
			}

                        $FromDir = "upload/candidate/".$_SESSION['CmpID']."/";
                        $ToDir = "upload/employee/".$_SESSION['CmpID']."/";
			if($arryCand[0]['Image'] !='' && file_exists($FromDir.$arryCand[0]['Image']) ){ 
				$ImageExtension = GetExtension($arryCand[0]['Image']); 
				$imageName = $LastInsertId.".".$ImageExtension;					
				if(@copy($FromDir.$arryCand[0]['Image'], $ToDir.$imageName)){
					$objEmployee->UpdateImage($imageName,$LastInsertId);
					unlink($FromDir.$arryCand[0]['Image']);
				}
			}

			$objCandidate->UpdateVacancyAfterJoining($arryCand[0]['Vacancy']);
			$objCandidate->RemoveCandidate($_POST['JoinCanID']);
			$_SESSION['mess_candidate'] = CANDIDATE_JOINED;
			header("Location:".$RedirectURL);
			exit;
		}
	}







	

	 if($_POST){
			if($_FILES['OfferLetter']['name'] != ''){
				$documentExtension = GetExtension($_FILES['OfferLetter']['name']);
				$heading = escapeSpecial($_FILES['OfferLetter']['name']);
				$OfferLetterName = $heading."_".$_POST['CanID'].".".$documentExtension;	
                                $MainDir = "upload/offer_letter/".$_SESSION['CmpID']."/";						
                                if (!is_dir($MainDir)) {
                                        mkdir($MainDir);
                                        chmod($MainDir,0777);
                                }                         
                               	$OfferLetterPath = $MainDir.$OfferLetterName;
				if(@move_uploaded_file($_FILES['OfferLetter']['tmp_name'], $OfferLetterPath)){
                                  	/************************/
					$objCandidate->sendOfferLetter($_POST, $OfferLetterName);
					/************************/
					unlink($OfferLetterPath);	
					$_SESSION['mess_candidate'] = CANDIDATE_OFFERED;
				}else{
					$_SESSION['mess_candidate'] = FILE_NOT_UPLOADED;
				}
			}
			$RedirectURL = "viewCandidate.php?module=Offered";
			header("Location:".$RedirectURL);
			exit;
	 }




	/******Get Candidate Records***********/	
	$Config['RecordsPerPage'] = $RecordsPerPage;
	$arryCandidate=$objCandidate->ListCandidate($_GET);
	/**********Count Records**************/	
	$Config['GetNumRecords'] = 1;
        $arryCount=$objCandidate->ListCandidate($_GET);
	$num=$arryCount[0]['NumCount'];	
	$pagerLink=$objPager->getPaging($num,$RecordsPerPage,$_GET['curP']);	
	/*************************/	

	require_once("../includes/footer.php"); 	 
?>


