<?php 
	include_once("../includes/header.php");
	require_once($Prefix."classes/training.class.php");
	require_once($Prefix."classes/employee.class.php");
	include_once("includes/FieldArray.php");
	$objTraining=new training();
	$objEmployee=new employee();
	$ModuleName = "Participant";	

	$RedirectURL = "viewParticipant.php?t=".$_GET["t"];

	if($_POST){
	
		if (!empty($_POST['Feedback'])) {
			$objTraining->UpdateParticipantFeedback($_POST);
			$_SESSION['mess_part'] = PARTICIPANT_FEEDBACK_UPDATED;
		}
		header("Location:".$RedirectURL);
		exit;
	}



	 if($_GET["t"]>0){
		$arryParticipant=$objTraining->GetParticipant('',$_GET['t']);
		$num=$objTraining->numRows();

		$arryTraining = $objTraining->GetTraining($_GET["t"],'');
	 }

	/*$arryTrainingAll = $objTraining->GetTraining('',1);
	$numTraining = $objTraining->numRows();*/

	$arryEmployee = $objEmployee->GetEmployeeBrief('');

	$_SESSION["DateFormat"] = $Config['DateFormat'];

	require_once("../includes/footer.php"); 	 
?>


