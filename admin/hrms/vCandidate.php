<?php 
	$ThisPageName = 'viewCandidate.php'; 
	/*****************************/
	/*****************************/

	include_once("../includes/header.php");
	require_once($Prefix."classes/candidate.class.php");	
	

	$objCandidate=new candidate();
	
	$ModuleName = "Candidate";	$module = $_GET['module'];
	/**************/
	$ModuleArray = array('Manage','Shortlisted','Offered'); 
	if(!in_array($_GET['module'],$ModuleArray)){
		header("location:home.php");die;		 
	}
	/**************/

	$RedirectURL = "viewCandidate.php?module=".$module."&curP=".$_GET['curP'];
	$EditUrl = "editCandidate.php?module=".$module."&edit=".$_GET['view']."&curP=".$_GET['curP'];

	if (!empty($_GET['view'])) {
		$arryCandidate = $objCandidate->GetCandidate($_GET['view'],'');
		$PageHeading = 'Candidate: '.stripslashes($arryCandidate[0]['UserName']);
	}else{
		header('location:'.$RedirectURL);
		exit;
	}




	/********Connecting to main database*********/
	$Config['DbName'] = $Config['DbMain'];
	$objConfig->dbName = $Config['DbName'];
	$objConfig->connect();
	/*******************************************/
	if($arryCandidate[0]['country_id']>0){
		$arryCountryName = $objRegion->GetCountryName($arryCandidate[0]['country_id']);
		$CountryName = stripslashes($arryCountryName[0]["name"]);
	}

	if(!empty($arryCandidate[0]['state_id'])) {
		$arryState = $objRegion->getStateName($arryCandidate[0]['state_id']);
		$StateName = stripslashes($arryState[0]["name"]);
	}else if(!empty($arryCandidate[0]['OtherState'])){
		 $StateName = stripslashes($arryCandidate[0]['OtherState']);
	}

	if(!empty($arryCandidate[0]['city_id'])) {
		$arryCity = $objRegion->getCityName($arryCandidate[0]['city_id']);
		$CityName = stripslashes($arryCity[0]["name"]);
	}else if(!empty($arryCandidate[0]['OtherCity'])){
		 $CityName = stripslashes($arryCandidate[0]['OtherCity']);
	}

	/*******************************************/



	require_once("../includes/footer.php"); 	 
?>
