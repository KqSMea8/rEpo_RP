<?php
    /**************************************************/
    $ThisPageName = 'viewCities.php'; $EditPage = 1; 
    /**************************************************/
    
	$ModuleID = 22;
	require_once("includes/header.php");
	require_once("../classes/region.class.php");
	
	$ModuleName = "City";
	(empty($_GET['country_id']))?($_GET['country_id']=1):(""); 
	(empty($_GET['state_id']))?($_GET['state_id']=''):(""); 
	(empty($major_city))?($major_city=''):("");


	$RedirectUrl = "viewCities.php?country_id=".$_GET['country_id']."&state_id=".$_GET['state_id']."&curP=".$_GET['curP'];

	$objRegion=new region();


	 if($_GET['del_id'] && !empty($_GET['del_id'])){
		$_SESSION['mess_city'] = $ModuleName.$MSG[103];
		$objRegion->deleteCity($_REQUEST['del_id']);
		header("location: ".$RedirectUrl);
		exit;
	}


	 if($_GET['active_id'] && !empty($_GET['active_id'])){
		$_SESSION['mess_city'] = $ModuleName.$MSG[104];
		$objRegion->changeCityStatus($_REQUEST['active_id']);
		header("location: ".$RedirectUrl);
		exit;
	}
	
	

	if (!empty($_POST)) {
		CleanPost();
		if (!empty($_POST['city_id'])) {
			$objRegion->updateCity($_POST);
			$city_id=$_POST['city_id'];
			$_SESSION['mess_city'] = $ModuleName.$MSG[102];
		} else { 	
			$city_id=$objRegion->addCityMulti($_POST);
			$_SESSION['mess_city'] = $ModuleName.$MSG[101];
		}
		//$objRegion->AddUpdateMajorCity($city_id,$_POST['major_city']);

		$RedirectUrl = "viewCities.php?country_id=".$_POST['country_id']."&state_id=".$_POST['main_state_id']."&curP=".$_GET['curP'];
		header("location: ".$RedirectUrl);
		exit;
		
	}
	
	$Status = 1;
	if($_GET['edit']>0)
	{
		$arryRegion = $objRegion->getCity($_GET['edit'],'');
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
	
	
	$arryState = $objRegion->getStateByCountry($CountrySelected);
	



 require_once("includes/footer.php"); 
 
 ?>
