<?php 
	$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'viewVacancy.php'; 
	/**************************************************/

	include_once("../includes/header.php");

	require_once($Prefix."classes/candidate.class.php");	

	$objCandidate=new candidate();


	if(!empty($_GET['view'])) {
		$arryVacancy = $objCandidate->GetVacancy($_GET['view'],'');
		$PageHeading = 'Vacancy : '.stripslashes($arryVacancy[0]['JobTitle']).' for '.stripslashes($arryVacancy[0]['Name']);
	}else{
		echo '<div class="redmsg" align="center">'.INVALID_REQUEST.'</div>';
	}


	require_once("../includes/footer.php"); 	 
?>


