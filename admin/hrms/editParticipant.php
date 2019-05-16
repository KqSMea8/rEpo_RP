<?php 
	/**************************************************/
	$ThisPageName = 'viewParticipant.php'; $EditPage = 1;
	/**************************************************/
	include_once("../includes/header.php");
	require_once($Prefix."classes/training.class.php");
	require_once($Prefix."classes/employee.class.php");
	$objTraining=new training();
	$objEmployee=new employee();
	$ModuleName = "Participant";
	$RedirectURL = "viewParticipant.php?t=".$_GET['t'];
		
	$numEmployee='';

	if($_GET['del_id'] && !empty($_GET['del_id'])){
		$_SESSION['mess_part'] = PARTICIPANT_REMOVED;
		$objTraining->RemoveParticipant($_GET['del_id']);
		header("Location:".$RedirectURL);
		exit;
	}


	if($_POST){
		CleanPost(); 
		$_SESSION['mess_part'] = PARTICIPANT_ADDED;
		$objTraining->AddParticipant($_POST);
		header("Location:".$RedirectURL);
		exit;
	}





	if(empty($_GET['t'])){
		header("Location:".$RedirectURL);
		exit;
	}



	 if($_GET["t"]>0){
		$arryTraining = $objTraining->GetTraining($_GET["t"],'');
	 }

	 if($_GET["d"]>0){
		$_GET["Department"] = $_GET["d"];
		$_GET["ExistingEmployee"]=1;
		$_GET["Status"]=1;
		$arryEmployee = $objEmployee->GetEmployeeList($_GET);
		$numEmployee = sizeof($arryEmployee);
		if($numEmployee>100){
			$ScrollStyle = 'height:400px; overflow:auto;';
		}
	 }


	require_once("../includes/footer.php"); 	 
?>
