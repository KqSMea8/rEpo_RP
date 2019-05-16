<?php 
	/**************************************************/
	$ThisPageName = 'viewCandidate.php?module=Manage'; $EditPage = 1; $HideNavigation = 1;
	/**************************************************/

	include_once("../includes/header.php");
	require_once($Prefix."classes/candidate.class.php");	
	require_once($Prefix."classes/hrms.class.php");
	require_once($Prefix."classes/function.class.php");
	$objFunction=new functions();
	$objCommon=new common();
	$objCandidate=new candidate();
	$ModuleName = "Candidate";	$module = "Manage";
	$RedirectURL = "viewCandidate.php?module=".$module."&curP=".$_GET['curP'];

	
	   if($_POST){
			 CleanPost(); 
			 if (empty($_POST['Email']) && empty($_POST['CanID'])) {
				$errMsg = ENTER_EMAIL;
			 } else {
				if($objCandidate->isEmailExists($_POST['Email'],'')){
					$_SESSION['mess_candidate'] = EMAIL_ALREADY_REGISTERED;
				}else{	
					$LastInsertId = $objCandidate->AddCandidate($_POST); 
					$_SESSION['mess_candidate'] = CANDIDATE_ADDED;
				}

				//header("Location:".$RedirectURL);
				echo '<script>window.parent.location.href="'.$RedirectURL.'";</script>';
				exit;
				
			}
		}
		
		
	$CandidateStatus = 1;			
		
	$arryVacancy = $objCandidate->GetVacancy('','Approved');
	$numVacancy = sizeof($arryVacancy);
	$arrySalaryFrequency = $objCommon->GetAttributeValue('SalaryFrequency','');
	$arryInterviewStatus = $objCommon->GetFixedAttribute('InterviewStatus','');		
	$arryInterviewTest = $objCommon->GetAttribValue('InterviewTest','');

	require_once("../includes/footer.php"); 	 
?>
