<?php
	/**************************************************/
	$ThisPageName = 'viewLocation.php'; $EditPage = 1;
	/**************************************************/
	require_once("includes/header.php");
	
	$ModuleName = "Location";
	$RedirectUrl = "viewLocation.php";

	if($_GET['del_id'] && !empty($_GET['del_id'])){
		$_SESSION['mess_loc'] = LOCATION_REMOVED;
		$objConfigure->deleteLocation($_REQUEST['del_id']);
		header("location: ".$RedirectUrl);
		exit;
	}


	 if($_GET['active_id'] && !empty($_GET['active_id'])){
		$_SESSION['mess_loc'] = LOCATION_STATUS_CHANGED;
		$objConfigure->changeLocationStatus($_REQUEST['active_id']);
		header("location: ".$RedirectUrl);
		exit;
	}
	
	

	if ($_POST) {

		/*************************/
		/*************************/

		$Config['DbName'] = $Config['DbMain'];
		$objConfig->dbName = $Config['DbName'];
		$objConfig->connect();

		/*************************/
		/*************************/

		$arryCountry = $objRegion->GetCountryName($_POST['country_id']);
		$_POST['Country']= stripslashes($arryCountry[0]["name"]);
		$_POST['state_id'] = $_POST['main_state_id'];
		$_POST['city_id'] = $_POST['main_city_id'];

		if(!empty($_POST['state_id'])) {
			$arryState = $objRegion->getStateName($_POST['state_id']);
			$_POST['State']= stripslashes($arryState[0]["name"]);
		}else if(!empty($_POST['OtherState'])){
			 $_POST['State']=$_POST['OtherState'];
		}

		if(!empty($_POST['city_id'])) {
			$arryCity = $objRegion->getCityName($_POST['city_id']);
			$_POST['City']= stripslashes($arryCity[0]["name"]);
		}else if(!empty($_POST['OtherCity'])){
			 $_POST['City']=$_POST['OtherCity'];
		}

		/*************************/
		/*************************/

		$Config['DbName'] = $_SESSION['CmpDatabase'];
		$objConfig->dbName = $Config['DbName'];
		$objConfig->connect();

		/*************************/
		/*************************/
		if (!empty($_POST['locationID'])) {
			$objConfigure->updateLocation($_POST);
			$_SESSION['mess_loc'] = LOCATION_UPDATED;
		} else {		
			$objConfigure->addLocation($_POST);
			$_SESSION['mess_loc'] = LOCATION_ADDED;
		}
	
		header("location: ".$RedirectUrl);
		exit;
		/*************************/
		/*************************/
	}
	
	if($_GET['edit']>0)
	{
		$arryLocation = $objConfigure->GetLocation($_GET['edit'],'');
	}else{
		$arryNumLoc=$objConfigure->CountLocation();
		
		if($arryNumLoc[0]["NumLocation"]>=$Config['NumLocation']){
			$LimitReached = str_replace("[NumLocation]",$Config['NumLocation'],LOCATION_LIMIT_REACHED);
			$ErrorMsg=$LimitReached;
		}
	}



	$Config['DbName'] = $Config['DbMain'];
	$objConfig->dbName = $Config['DbName'];
	$objConfig->connect();

	$arryCurrency = $objRegion->getCurrency('',1);

	require_once("includes/footer.php");  
 ?>