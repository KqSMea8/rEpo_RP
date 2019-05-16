<?php 
	/**************************************************/
	$ThisPageName = 'viewVacancy.php'; $EditPage = 1;
	/**************************************************/
	include_once("../includes/header.php");
	require_once($Prefix."classes/candidate.class.php");	
	require_once($Prefix."classes/employee.class.php");
	require_once($Prefix."classes/hrms.class.php");
	$objCandidate=new candidate();
	$objEmployee=new employee();
	$objCommon=new common();
	
	$ModuleName = "Vacancy";
	$RedirectURL = "viewVacancy.php?curP=".$_GET['curP'];

	
	/*********  Multiple Actions To Perform **********/
	 if(!empty($_GET['multiple_action_id'])){
	 	$multiple_action_id = rtrim($_GET['multiple_action_id'],",");
		
		$mulArray = explode(",",$multiple_action_id);
	
		switch($_GET['multipleAction']){
			case 'delete':
					foreach($mulArray as $del_id){
						$objCandidate->RemoveVacancy($del_id);
					}
					$_SESSION['mess_vac'] = VACANCY_REMOVED;
					break;
			case 'active':
					$objCandidate->MultipleVacancyStatus($multiple_action_id,1);
					$_SESSION['mess_vac'] = VACANCY_STATUS_CHANGED;
					break;
			case 'inactive':
					$objCandidate->MultipleVacancyStatus($multiple_action_id,0);
					$_SESSION['mess_vac'] = VACANCY_STATUS_CHANGED;
					break;				
		}
		header("location: ".$RedirectURL);
		exit;
		
	 }
	
	/*********  End Multiple Actions **********/		

	 if($_GET['del_id'] && !empty($_GET['del_id'])){
		$_SESSION['mess_vac'] = VACANCY_REMOVED;
		$objCandidate->RemoveVacancy($_GET['del_id']);
		header("Location:".$RedirectURL);
	}
	

	 if($_GET['active_id'] && !empty($_GET['active_id'])){
		$_SESSION['mess_vac'] = VACANCY_STATUS_CHANGED;
		$objCandidate->changeVacancyStatus($_GET['active_id']);
		header("Location:".$RedirectURL);
	}
		
	 if($_POST) {
			CleanPost(); 
			if (!empty($_POST['vacancyID'])) {
				$vacancyID = $_POST['vacancyID'];
				$objCandidate->UpdateVacancy($_POST);
				$_SESSION['mess_vac'] = VACANCY_UPDATED;
			} else {	
				$vacancyID = $objCandidate->AddVacancy($_POST); 
				$_SESSION['mess_vac'] = VACANCY_ADDED;
			}	

			if($_POST['OldStatus']!=$_POST['Status']){
				$objCandidate->sendVacancyEmail($vacancyID);
			}


		header("Location:".$RedirectURL);
		exit;

	}
		

	if(!empty($_GET['edit'])) {
		$arryVacancy = $objCandidate->GetVacancy($_GET['edit'],'');
		$PageHeading = 'Edit Vacancy : '.stripslashes($arryVacancy[0]['JobTitle']).' for '.stripslashes($arryVacancy[0]['Name']);
		$vacancyID   = $_GET['edit'];	
	}

	//if(empty($arryVacancy[0]['Status'])) $arryVacancy[0]['Status'] = "On Hold";
			
		
	$arryJobTitle = $objCommon->GetAttributeValue('JobTitle','');
	$arryEmployee = $objEmployee->GetEmployeeBrief('');
	$arryVacancyStatus = $objCommon->GetFixedAttribute('VacancyStatus','');

	$arryQualification = $objCommon->GetAttribMultiple("'UnderGraduate', 'Graduation', 'PostGraduation', 'Doctorate', 'ProfessionalCourse'", "");
	

	require_once("../includes/footer.php"); 	 
?>
