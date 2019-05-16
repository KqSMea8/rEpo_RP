<?php
	/**************************************************/
	$ThisPageName = 'viewReview.php'; 
	/**************************************************/

	require_once("../includes/header.php");
	require_once($Prefix."classes/performance.class.php");
	$objPerformance=new performance();

	$ModuleName = "Review";
	$EditURL = "editReview.php?edit=".$_GET['view']."&curP=".$_GET['curP'];
	$RedirectURL = "viewReview.php?curP=".$_GET['curP'];

	
	if($_GET['view']>0){
		$arryReview = $objPerformance->getReview($_GET['view']);
		$arryKra = $objPerformance->getKraByJobTitle($arryReview[0]['JobTitle']);
		$numKra = sizeof($arryKra);

		$arryComponent=$objPerformance->getComponent('',1);

		$catID = $arryReview[0]['catID'];
		if($catID > 0){
			$arryWeightage = $objPerformance->GetComponentWeightage($catID,'');
		}
		$PageHeading = 'KRA Review for Employee: '.stripslashes($arryReview[0]['UserName']);

	}else{
		header("Location:".$RedirectURL);
		exit;
	}

    require_once("../includes/footer.php"); 
?>
