<?
	$HideNavigation = 1;$EditPage = 1; $ThisPageName = 'viewEmployee.php';
	include_once("../includes/header.php");
	require_once($Prefix."classes/employee.class.php");
	$objEmployee=new employee();


	if(!empty($_POST['EmpID'])) {
		CleanPost();
		if(!empty($_POST['contactID'])) {
			$_SESSION['mess_employee'] = EMERGENCY_UPDATED;
			$objEmployee->UpdateEmergency($_POST);		
			$contactID = $_POST['contactID'];
		}else{
			$_SESSION['mess_employee'] = EMERGENCY_ADDED;
			$contactID = $objEmployee->UpdateEmergency($_POST);
		}
		

		/*****ADD COUNTRY/STATE/CITY NAME****/
		$Config['DbName'] = $Config['DbMain'];
		$objConfig->dbName = $Config['DbName'];
		$objConfig->connect();
		/***********************************/

		$arryCountry = $objRegion->GetCountryName($_POST['Country']);
		$arryRgn['Country']= stripslashes($arryCountry[0]["name"]);

		if(!empty($_POST['main_state_id'])) {
			$arryState = $objRegion->getStateName($_POST['main_state_id']);
			$arryRgn['State']= stripslashes($arryState[0]["name"]);
		}else if(!empty($_POST['OtherState'])){
			 $arryRgn['State']=$_POST['OtherState'];
		}

		if(!empty($_POST['main_city_id'])) {
			$arryCity = $objRegion->getCityName($_POST['main_city_id']);
			$arryRgn['City']= stripslashes($arryCity[0]["name"]);
		}else if(!empty($_POST['OtherCity'])){
			 $arryRgn['City']=$_POST['OtherCity'];
		}


		/***********************************/
		$Config['DbName'] = $_SESSION['CmpDatabase'];
		$objConfig->dbName = $Config['DbName'];
		$objConfig->connect();

		$objEmployee->UpdateEmergencyCountryStateCity($arryRgn,$contactID);
				
		/**************END COUNTRY NAME*********************/

 

		//$RedirectURL = "editEmployee.php?edit=".$_POST['EmpID'].'&tab=emergency';

		$RedirectURL =  $_POST['RedirectURL']; 
		echo '<script>window.parent.location.href="'.$RedirectURL.'";</script>';
		exit;


	}




	if(empty($_GET['EmpID'])){ 		
		$ErrorExist=1;
		echo '<div class="redmsg" align="center">'.INVALID_GET.'</div>';
	}else if(!empty($_GET['contactID'])) {
		$ArryEmergency = $objEmployee->GetEmergencyDetail($_GET['EmpID'],$_GET['contactID']);
				
		if($ArryEmergency[0]['contactID']<=0){
			$ErrorExist=1;
			echo '<div class="redmsg" align="center">'.NOT_EXIST_DATA.'</div>';
		}
	}
	/*************************/


	if(empty($ErrorExist)){ 
		if(!empty($_GET['contactID'])) {
			$PageAction = 'Edit';
			$ButtonAction = 'Update';
		}else{
			$PageAction = 'Add';
			$ButtonAction = 'Submit';
		}

	}

	 

	require_once("../includes/footer.php");  

?>
