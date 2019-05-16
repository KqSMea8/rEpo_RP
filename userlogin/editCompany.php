<?php 
	require_once("includes/header.php");

	$Config['DbName'] = $Config['DbMain'];
	$objConfig->dbName = $Config['DbName'];
	$objConfig->connect();
	


	$ModuleName = "Company";
	if(empty($_GET['tab'])) $_GET['tab']="company";

	$EditUrl = "editCompany.php?tab="; 
	$ActionUrl = $EditUrl.$_GET["tab"];

	 if ($_POST) {
				$_POST['CmpID'] = $_SESSION['CmpID'];
				if (!empty($_POST['CmpID'])) {
					
					switch($_GET['tab']){
						case 'company':
							$objCompany->UpdateCompanyProfile($_POST);
							$_SESSION['mess_company'] = COMPANY_PROFILE_UPDATED;

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

							break;

						/*case 'account':
							$objCompany->UpdateAccount($_POST);
							$_SESSION['mess_company'] = COMPANY_ACCOUNT_UPDATED;
							break;

						case 'currency':
							$objCompany->UpdateCurrency($_POST);
							$_SESSION['mess_company'] = CURRENCY_UPDATED;
							break;

						case 'DateTime':
							$objCompany->UpdateDateTime($_POST);
							$_SESSION['mess_company'] = DATETIME_UPDATED;
							break;*/
						case 'global':
							$objCompany->UpdateCurrency($_POST);
							$objCompany->UpdateDateTime($_POST);
							$objCompany->UpdateGlobalOther($_POST);

						/********Connecting to main database*********/
						$Config['DbName'] = $_SESSION['CmpDatabase'];
						$objConfig->dbName = $Config['DbName'];
						$objConfig->connect();
						/*******************************************/


							$objCompany->UpdateInventoryModules($_POST['CmpID'],$_POST['TrackInventory']);		

							$_SESSION['mess_company'] = GLOBAL_UPDATED;
							break;


					}
					/***************************/
				}		




				$ImageId = $_POST['CmpID'];
				if($_FILES['Image']['name'] != ''){
					$ImageExtension = GetExtension($_FILES['Image']['name']); 
					$imageName = $ImageId.".".$ImageExtension;	
					$ImageDestination = "../upload/company/".$imageName;
					if(@move_uploaded_file($_FILES['Image']['tmp_name'], $ImageDestination)){
						$objCompany->UpdateImage($imageName,$ImageId);
					}
				}


				/********Connecting to main database*********/
				$Config['DbName'] = $_SESSION['CmpDatabase'];
				$objConfig->dbName = $Config['DbName'];
				$objConfig->connect();

				switch($_GET['tab']){
						case 'company':
							$objConfigure->UpdateLocationProfile($_POST);
							break;
						/*case 'currency':
							$objConfigure->UpdateLocationCurrency($_POST);
							break;
						case 'DateTime':
							$objConfigure->UpdateLocationDateTime($_POST);
							break;*/
						case 'global':
						
							$objConfigure->UpdateLocationCurrency($_POST);
							$objConfigure->UpdateLocationDateTime($_POST);
							break;
				}
				/*******************************************/







			header("Location:".$ActionUrl);
			exit;
	}
		
		


	$arryCompany = $objCompany->GetCompany($_SESSION['CmpID'],'');
	
	$arrayDateFormat = $objConfig->GetDateFormat();

	$arryCountry = $objRegion->getCountry('','');
	$arryCurrency = $objRegion->getCurrency('',1);



	if($_GET['tab']=='company'){
		$SubHeading = 'Company Details';
	}else{
		$SubHeading = ucfirst($_GET['tab']).' Settings';
	}


	require_once("includes/footer.php"); 
?>


