<?php
	/**************************************************/
	$ThisPageName = 'viewWeightage.php'; $EditPage = 1;
	/**************************************************/

	require_once("../includes/header.php");
	require_once($Prefix."classes/performance.class.php");
	$objPerformance=new performance();
	
	$RedirectURL = "viewWeightage.php";

	if(!empty($_POST['catID'])) {
		CleanPost(); 
		$objPerformance->updateComponentWeightage($_POST);
		$_SESSION['mess_weight'] = COMPONENT_WEIGHTAGE_UPDATED;
		header("Location:".$RedirectURL);
		exit;
	}

	if($_GET['edit']>0){
		$arryWeightage = $objPerformance->GetComponentWeightage($_GET['edit'],'');

		$PageHeading = 'Edit Weightage for Category: '.stripslashes($arryWeightage[0]['catName']);
		$arryComponent=$objPerformance->getComponent('',1);
	}else{
		header("Location:".$RedirectURL);
		exit;
	}


   require_once("../includes/footer.php"); 

?>

