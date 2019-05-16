<?php 
	/**************************************************/
	$EditPage = 1; $_GET['edit']=999;
	/**************************************************/
	require_once("includes/header.php");
	require_once("../classes/function.class.php");
	$objFunction=new functions();

	if($_GET["tab"]=="global"){ 
		$NumPaymentTable = $objConfigure->NumPaymentTable();
	 
		if($NumPaymentTable>0){
			$ClassName = 'disabled_inputbox';
			$Disabled = 'Disabled';
			$DisablesMsg =  CURRENCY_DISABLE_MSG;
		}else{
			$ClassName = 'inputbox';
		}
	}



	$Config['DbName'] = $Config['DbMain'];
	$objConfig->dbName = $Config['DbName'];
	$objConfig->connect();
	


	$ModuleName = "Company";
	if(empty($_GET['tab'])) $_GET['tab']="company";

	$EditUrl = "editCompany.php?tab="; 
	$ActionUrl = $EditUrl.$_GET["tab"];



	 if(!empty($_GET['FileExist'])){  
		$objCompany->RemoveImage($_SESSION['CmpID']);
		header("Location:".$ActionUrl);
		exit;
	}

	 if(!empty($_POST)){		
		CleanPost();
		
			
				$_POST['CmpID'] = $_SESSION['CmpID'];
				if (!empty($_POST['CmpID'])) {
					
					switch($_GET['tab']){
						case 'company':

						/*************************/
						$ValidateData = array(        
							array("name" => "CompanyName", "label" => "Company Name" ),
							array("name" => "ZipCode", "label" => "Zip Code" ),
							array("name" => "AlternateEmail", "label" => "Alternate Email", "opt" => "1", "type" => "email"),	
							array("name" => "Mobile", "label" => "Mobile Number" , "type" => "number" , "min" => "10" , "max" => "20" )		
						);

						$ValidateErrorMsg = $objFunction->ValidatePostData($ValidateData);
						if(!empty($ValidateErrorMsg)){
							$_SESSION['mess_company'] = $ValidateErrorMsg;
							header("Location:".$ActionUrl);
							exit;
						}
						/*************************/


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
							//$objCompany->UpdateSelectItem($_POST);
							$objCompany->UpdateSpiff($_POST);
						/********Connecting to main database*********
						$Config['DbName'] = $_SESSION['CmpDatabase'];
						$objConfig->dbName = $Config['DbName'];
						$objConfig->connect();
						*******************************************/


							//$objCompany->UpdateInventoryModules($_POST['CmpID'],$_POST['TrackInventory']);		

											//$objCompany->UpdateStandardModules($_POST['CmpID'],$_POST['SelectOneItem']);	
								

							$_SESSION['mess_company'] = GLOBAL_UPDATED;
							break;


					}
					/***************************/
				}		




				$ImageId = $_POST['CmpID'];
				
				/************************************
				if($_FILES['Image']['name'] != ''){
					$FileArray = $objFunction->CheckUploadedFile($_FILES['Image'],"Image");

					if(empty($FileArray['ErrorMsg'])){
						$ImageExtension = GetExtension($_FILES['Image']['name']); 
						$imageName = $ImageId.".".$ImageExtension;	
						$ImageDestination = "../upload/company/".$imageName;

						if(!empty($_POST['OldImage']) && file_exists($_POST['OldImage'])){
							unlink($_POST['OldImage']);		
						}

						if(@move_uploaded_file($_FILES['Image']['tmp_name'], $ImageDestination)){
							$objCompany->UpdateImage($imageName,$ImageId);
						}
					}else{
						$ErrorMsg = $FileArray['ErrorMsg'];
					}

					if(!empty($ErrorMsg)){
						if(!empty($_SESSION['mess_company'])) $ErrorPrefix = '<br><br>';
						$_SESSION['mess_company'] .= $ErrorPrefix.$ErrorMsg;
					}

				}
				************************************/

			if($_FILES['Image']['name'] != ''){
				$FileInfoArray['FileType'] = "Image";
				$FileInfoArray['FileDir'] = $Config['CmpDir'];
				$FileInfoArray['FileID'] = $ImageId;
				$FileInfoArray['OldFile'] = $_POST['OldImage'];
				$FileInfoArray['UpdateStorage'] = '1';
				$ResponseArray = $objFunction->UploadFile($_FILES['Image'], $FileInfoArray);

				if($ResponseArray['Success']=="1"){
					 $objCompany->UpdateImage($ResponseArray['FileName'],$ImageId);					
				}else{
					$ErrorMsg = $ResponseArray['ErrorMsg'];
				}
						 

				if(!empty($ErrorMsg)){
					$_SESSION['mess_company'] .= '<br><br>'.$ErrorMsg;
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
							if(isset($_POST['currency_id'])){
								$objConfigure->UpdateLocationCurrency($_POST);
							}
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


