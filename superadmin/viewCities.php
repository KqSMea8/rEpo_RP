<?php 
 	include_once("includes/header.php");
	require_once("../classes/region.class.php");
	$objRegion=new region();	
	(empty($_GET['country_id']))?($_GET['country_id']=1):(""); 
	(empty($_GET['state_id']))?($_GET['state_id']=''):(""); 

 	 $ModuleName = "City";

	$RedirectUrl = "viewCities.php?country_id=".$_GET['country_id']."&state_id=".$_GET['state_id']."&curP=".$_GET['curP'];

	if(!empty($_POST)){
		CleanPostID();
		if(sizeof($_POST['city_id']>0)){
			$city = implode(",",$_POST['city_id']);
		
			$_SESSION['mess_city'] = 'Cities'.$MSG[103];
			$objRegion->deleteMultiCity($city);			
			header("location:".$RedirectUrl);
			exit;
		}
	}

	$NoState='';
	if(!$objRegion->isStateInCountry($_GET['country_id'])){
	   $NoState = 1;
	} 
	

	if(!empty($_GET['state_id']) || $NoState==1){			 
		$arryRegion=$objRegion->getCityList($_GET['state_id'],$_GET['country_id']);
		$num=$objRegion->numRows();

		/* $pagerLink=$objPager->getPager($arryRegion,$RecordsPerPage,$_GET['curP']);
		(count($arryRegion)>0)?($arryRegion=$objPager->getPageRecords()):("");*/
		$ShowRecord = 1;
	}
	 		 
	 $arryCountry = $objRegion->getCountry('','');	
	 	 
	 require_once("includes/footer.php");
	 
?>
