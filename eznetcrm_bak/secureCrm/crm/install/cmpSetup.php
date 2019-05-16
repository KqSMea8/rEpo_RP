<?php
	require_once("includes/header.php");

	if(empty($_SESSION['LicenseKey'])){		
		header('location: index.php');
		exit;
	}
	if(empty($_SESSION['DisplayDbName'])){		
		header('location: dbSetup.php');
		exit;
	}


	$Config['DbHost'] = $_SESSION['DbHost'];
	$Config['DbUser'] = $_SESSION['DbUser'];
	$Config['DbPassword'] = $_SESSION['DbPassword'];
	$Config['DbName'] = $Config['DbMain'];

	$objConfig = new admin();
	$objCompany=new company();
	$objRegion=new region();
	/************************/
	 if(!empty($_POST['Email'])) {
		//need to get from license key database
		$MaxUser = 100000;  
		$StorageLimit = ''; $StorageLimitUnit = ''; 
		$ExpiryDate = '';
		/////////////

		$_POST['Department'] = 5;
		$_POST["Status"]= '1';
		$_POST["Timezone"]= '-04:00';
		$_POST["DateFormat"]= 'j M, Y';
		$_POST["currency_id"]= '9';
		$_POST["MaxUser"]= $MaxUser; 
		$_POST['StorageLimit'] = $StorageLimit;
		$_POST['StorageLimitUnit'] = $StorageLimitUnit;
		$_POST["ExpiryDate"]= $ExpiryDate;

		if($objConfig->isCmpEmailExists($_POST['Email'],'')){
			$_SESSION['mess_cmp'] = EMAIL_ALREADY_REGISTERED;		
		}else{	
			/*******Create Config File********/	
			$PageArry = explode("install", $_SERVER['HTTP_REFERER']);			
			$contents = file_get_contents("includes/config_sample.php");
			$contents = str_replace("[DATABASE_HOST]",$_SESSION['DbHost'], $contents);
			$contents = str_replace("[DATABASE_USER]",$_SESSION['DbUser'], $contents);
			$contents = str_replace("[DATABASE_PASSWORD]",$_SESSION['DbPassword'], $contents);
			$contents = str_replace("[DATABASE_NAME]",$Config['DbMain'], $contents);
			$contents = str_replace("[ERP_URL]",$PageArry[0], $contents);
			chmod("../includes/",0777);
			file_put_contents("../includes/config.php", $contents);
			if(!file_exists("../includes/config.php")){
				echo ERROR_CONFIG; exit;
			}		
			/*********Add Company******/
			$_POST['DisplayName'] = $_SESSION['DisplayDbName'];		
			$CmpID = $objCompany->AddCompany($_POST); 
			$objCompany->UpdateCompanyLicense($CmpID,$_SESSION['LicenseKey']); 
			/*********Update CRM Menu*********/
			$DbName = $Config['DbMain']."_".$_SESSION['DisplayDbName'];						
			$Config['DbName'] = $DbName;
			$objConfig->dbName = $Config['DbName'];
			$objConfig->connect();		
			$objCompany->UpdateAdminModules($CmpID,$_POST['Department']);
			/*********Folder Permission************	
			FullPermission("../upload/");
			FullPermission("../admin/upload");	
			FullPermission("../admin/crm/upload");					
			/**************************************/	
			$_SESSION['mess_installed'] = INSTALLED_SUCCESS;				
			header('location: cmpSetup.php');
			exit;
		}
	}
	/************************/
	
	$arryCountry = $objRegion->getCountry('','');

	require_once("includes/footer.php"); 
  ?>
