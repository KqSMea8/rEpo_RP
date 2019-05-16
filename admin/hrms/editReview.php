<?php
	/**************************************************/
	$ThisPageName = 'viewReview.php'; $EditPage = 1;
	/**************************************************/

	require_once("../includes/header.php");
	require_once($Prefix."classes/performance.class.php");
	require_once($Prefix."classes/employee.class.php");
	$objPerformance=new performance();
	$objEmployee=new employee();

	$ModuleName = "Review";
	$RedirectURL = "viewReview.php?curP=".$_GET['curP'];


	if(!empty($_GET['del_id'])){
		$_SESSION['mess_review'] = REVIEW_REMOVED;
		$objPerformance->deleteReview($_GET['del_id']);
		header("Location:".$RedirectURL);
		exit;
	}

	if($_POST){
		CleanPost(); 
		if (!empty($_POST['reviewID'])) {
			$objPerformance->updateReview($_POST);
			$reviewID = $_POST['reviewID'];
			$_SESSION['mess_review'] = REVIEW_UPDATED;
		}else{		
			$_POST['EmpID'] = $_POST['MainEmpID'];
			$reviewID = $objPerformance->addReview($_POST);
			$_SESSION['mess_review'] = REVIEW_ADDED;
		}
		header("Location:".$RedirectURL);
		exit;
	}
	
	$Status = 1;
	if($_GET['edit']>0){
		$arryReview = $objPerformance->getReview($_GET['edit']);
		$arryKra = $objPerformance->getKraByJobTitle($arryReview[0]['JobTitle']);
		$numKra = sizeof($arryKra);

		$arryComponent=$objPerformance->getComponent('',1);

		$catID = $arryReview[0]['catID'];

		$PageHeading = 'Edit KRA Review for Employee: '.stripslashes($arryReview[0]['UserName']);
	}else{	
		$arryReview[0]['Department']='';
	}	

	

	$arryEmployee = $objEmployee->GetEmployeeBrief('');
	if(sizeof($arryEmployee)<=0){
		$HideSubmit=1;
	}

    require_once("../includes/footer.php"); 

?>
