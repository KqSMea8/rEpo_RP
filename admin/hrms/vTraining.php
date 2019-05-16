<?php 
	$ThisPageName = 'viewTraining.php'; 
	/*****************************/
	/*****************************/

	include_once("../includes/header.php");
	require_once($Prefix."classes/training.class.php");	
	
	$objTraining=new training();
	
	$ModuleName = "Training";	
	$RedirectURL = "viewTraining.php?curP=".$_GET['curP'];
	$EditUrl = "editTraining.php?edit=".$_GET['view']."&curP=".$_GET['curP'];

	if (!empty($_GET['view'])) {
		$arryTraining = $objTraining->GetTraining($_GET['view'],'');
		$PageHeading = 'Training for Course: '.stripslashes($arryTraining[0]['CourseName']);	
	}else{
		header('location:'.$RedirectURL);
		exit;
	}

	require_once("../includes/footer.php"); 	 
?>
