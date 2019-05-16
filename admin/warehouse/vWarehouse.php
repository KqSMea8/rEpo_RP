<?php   if(!empty($_GET['pop']))$HideNavigation = 1;
        /**************************************************/
	$ThisPageName = 'viewWarehouse.php'; 
	/**************************************************/

	include_once("../includes/header.php");
	require_once($Prefix."classes/crm.class.php");
	require_once($Prefix."classes/warehouse.class.php");
	require_once($Prefix."classes/employee.class.php");
	require_once($Prefix."classes/contact.class.php");
	require_once($Prefix."classes/company.class.php");

        $Module="Warehouse";
	$objwarehouse=new warehouse();
	$objEmployee=new employee();
	$objContact=new contact();
	$objCommon=new common();
	$objCompany=new company();
	
	$ModuleName = "Warehouse";
	$RedirectURL = "viewWarehouse.php?curP=".$_GET['curP'];
	if(empty($_GET['tab'])) $_GET['tab']="warehouse";

	$EditUrl = "editWarehouse.php?edit=".$_GET["view"]."&curP=".$_GET["curP"]."&tab=".$_GET['tab']; 
	$ViewUrl = "vWarehouse.php?view=".$_GET["view"]."&curP=".$_GET["curP"]."&tab="; 
	
	


		if(!empty($_GET['select_del_id'])){
			$_SESSION['mess_ticket'] = LEAD_REMOVE;
			$objwarehouse->RemoveSelectCompaign($_GET['select_del_id']);
			header("Location:".$ViewUrl.$_GET['tab']);
			exit;
		}


		if (!empty($_GET['view'])) {
		 $arryWarehouse = $objwarehouse->GetWarehouse($_GET['view'],'');
		 $WID   = $_GET['view'];	
 
		if($arryWarehouse[0]['created_by']=='admin'){
		 if($arryWarehouse[0]['created_id']>0){
		  $createdEMP[0]['UserName']="Administrator";
		 }
		//print_r($createdEMP);
        
		}else{

		$createdEMP=  $objEmployee->GetEmployeeBrief($arryWarehouse[0]['created_id']);
		}
		

		
	}else{
		header('location:'.$RedirectURL);
		exit;
	}

	


		/*******Connecting to main database********/
		$Config['DbName'] = $Config['DbMain'];
		$objConfig->dbName = $Config['DbName'];
		$objConfig->connect();
		/*******************************************/
		if($arryWarehouse[0]['country_id']>0){
		$arryCountryName = $objRegion->GetCountryName($arryWarehouse[0]['country_id']);
		$CountryName = stripslashes($arryCountryName[0]["name"]);
		}
		$CityName = $StateName='';
		if(!empty($arryWarehouse[0]['state_id'])) {
		$arryState = $objRegion->getStateName($arryWarehouse[0]['state_id']);
		$StateName = stripslashes($arryState[0]["name"]);
		}else if(!empty($arryWarehouse[0]['OtherState'])){
		$StateName = stripslashes($arryWarehouse[0]['OtherState']);
		}

		if(!empty($arryWarehouse[0]['city_id'])) {
		$arryCity = $objRegion->getCityName($arryWarehouse[0]['city_id']);
		$CityName = stripslashes($arryCity[0]["name"]);
		}else if(!empty($arryWarehouse[0]['OtherCity'])){
		$CityName = stripslashes($arryWarehouse[0]['OtherCity']);
		}


	require_once("../includes/footer.php"); 	 
?>


