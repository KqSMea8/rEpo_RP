<?php
    /**************************************************/
    $ThisPageName = 'viewZipCodes.php'; $EditPage = 1; 
    /**************************************************/
    
    
	$ModuleID = 22;
	require_once("includes/header.php");
	require_once("../classes/region.class.php");
	
	$ModuleName = "Zip Code";
	
	(empty($_GET['country_id']))?($_GET['country_id']=1):(""); 
	(empty($_GET['state_id']))?($_GET['state_id']=''):(""); 
	(empty($_GET['city_id']))?($_GET['city_id']=''):(""); 


	$RedirectUrl = "viewZipCodes.php?country_id=".$_GET['country_id']."&state_id=".$_GET['state_id']."&city_id=".$_GET['city_id']."&curP=".$_GET['curP'];

	$objRegion=new region();

	if($_GET['del_id'] && !empty($_GET['del_id'])){
		$_SESSION['mess_zipcode'] = $ModuleName.$MSG[103];
		$objRegion->deleteZipCode($_GET['del_id']);
		header("location: ".$RedirectUrl);
		exit;
	}

	if($_GET['active_id'] && !empty($_GET['active_id'])){
		$_SESSION['mess_zipcode'] = $ModuleName.$MSG[104];
		$objRegion->changeZipCodeStatus($_REQUEST['active_id']);
		header("location: ".$RedirectUrl);
		exit;
	}
	

	if(!empty($_POST)){	
		CleanPost();
		if(!empty($_POST['zipcode_id'])) {
			$objRegion->updateZipCode($_POST);
			$city_id=$_POST['zipcode_id'];
			$_SESSION['mess_zipcode'] = $ModuleName.$MSG[102];
		} else {		
			$city_id=$objRegion->addZipCode($_POST);
			$_SESSION['mess_zipcode'] = $ModuleName.$MSG[101];
		}
		$RedirectUrl = "viewZipCodes.php?country_id=".$_POST['country_id']."&state_id=".$_POST['main_state_id']."&city_id=".$_POST['main_city_id']."&curP=".$_GET['curP'];
		header("location: ".$RedirectUrl);
		exit;
		
	}
	
	$Status = 1;$zip_code='';
	if($_GET['edit']>0){
		$arryRegion = $objRegion->getZipCode($_GET['edit'],'');
		extract($arryRegion[0]);
	}

	$arryCountry = $objRegion->getCountry('','');

	if(!empty($country_id)){
		$CountrySelected = $country_id; 
	}else{
		$CountrySelected = $_GET['country_id'];
	}
	
	if(empty($state_id)){
		$state_id = $_GET['state_id'];
	}	
	if(empty($city_id)){
		$city_id = $_GET['city_id'];
	}
	
	require_once("includes/footer.php"); 
  ?>
