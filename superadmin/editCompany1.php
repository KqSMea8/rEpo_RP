<?php 

    /**************************************************/
    $ThisPageName = 'viewCompany.php'; if(empty($_GET["edit"]))$EditPage = 1; 
    /**************************************************/
	require_once("includes/header.php");
	require_once("../classes/company.class.php");
	require_once("../classes/region.class.php");
	require_once("../classes/configure.class.php");
	require_once("../classes/dbfunction.class.php");
	require_once("../classes/phone.class.php");
	require_once("../classes/reseller.class.php");
	require_once("../classes/function.class.php");

	$objphone=new phone();	
	$objConfigure=new configure();
	$objFunction=new functions();
	$objReseller=new reseller();
	$ModuleName = "Company";
	$RedirectURL = "viewCompany.php?curP=".$_GET['curP'];
	if(empty($_GET['tab'])) $_GET['tab']="company";

	$EditUrl = "editCompany1.php?edit=".$_GET["edit"]."&curP=".$_GET["curP"]."&tab="; 
	$ActionUrl = $EditUrl.$_GET["tab"];


	$objCompany=new company();
	$objRegion=new region();
	
	$_GET['edit'] = (int)$_GET['edit'];	
	$_GET['active_id'] = (int)$_GET['active_id'];

	

	 if($_GET['active_id'] && !empty($_GET['active_id'])){
		$_SESSION['mess_company'] = COMPANY_STATUS_CHANGED;
		$objCompany->changeCompanyStatus($_GET['active_id']);
		header("Location:".$RedirectURL);
		exit;
	}
	

	
if ($_POST){	
	CleanPost();
print_r($_POST);
	$_POST['Department'] = implode(",",$_POST['Department']);
	

	 if (empty($_POST['Email']) && empty($_POST['CmpID'])) {
		$errMsg = ENTER_EMAIL;
	 } else {
		if (!empty($_POST['CmpID'])) {
			$ImageId = $_POST['CmpID'];
		}else{

			/*************************/
			$ValidateData = array(        
				array("name" => "CompanyName", "label" => "Company Name" , "min" => "3"),
				array("name" => "AlternateEmail", "label" => "Alternate Email" , "type" => "email" , "opt" => "1"),
				array("name" => "ZipCode", "label" => "Zip Code"),
				array("name" => "LandlineNumber", "label" => "Landline Number" , "min" => "10", "max" => "20", "type" => "number"),
				array("name" => "MaxUser", "label" => "Allowed Number Of Users" , "min" => "1", "type" => "number"),
				array("name" => "DisplayName", "label" => "Display Name" , "min" => "3"),
				
				array("name" => "Email", "label" => "Login Email" , "type" => "email"),
				array("name" => "Password", "label" => "Password", "min" => "5"),
				array("name" => "ConfirmPassword", "label" => "Confirm Password")			
			);

			$ValidateErrorMsg = $objFunction->ValidatePostData($ValidateData);
			if(!empty($_POST['Password']) && $_POST['Password']!=$_POST['ConfirmPassword']){
				$ValidateErrorMsg .= '<br>'.CONFIRM_PASSWORD_NOT_MATCH;
			}
			if($objConfig->isCmpEmailExists($_POST['Email'],'')){
				$ValidateErrorMsg .= '<br>'. EMAIL_ALREADY_REGISTERED;
			}
			if($objCompany->isDisplayNameExists($_POST['DisplayName'],'')){
				$ValidateErrorMsg .= '<br>'. DISPLAY_ALREADY_REGISTERED;
			}

			if(!empty($ValidateErrorMsg)){
				$_SESSION['mess_company'] = $ValidateErrorMsg;
				$ActionUrl = 'editCompany1.php';			
				header("Location:".$ActionUrl);
				exit;
			}
			/*************************/
			

			//$ImageId = $objCompany->AddCompany($_POST);
			$_SESSION['mess_company'] = COMPANY_ADDED;	
			$AddDatabase = 1; 
			$UpdateAdminMenu = 1;
			$_POST['TrackInventory'] = 1;
			
		}
					
		
		/************************************/
		/************************
		if($AddDatabase == 1){
			$DbName = $objCompany->AddDatabse($_POST['DisplayName']); 
			if(!empty($DbName)){
				ImportDatabase($Config['DbHost'],$DbName,$Config['DbUser'],$Config['DbPassword'],'sql/erp_company.sql');
			}
		}   
		
		
		if($UpdateAdminMenu == 1){
			if(empty($DbName)){
				$arryCmp = $objCompany->GetCompanyDisplayName($_POST['CmpID']);
			
				$DbName = $Config['DbName']."_".$arryCmp[0]['DisplayName'];
			}
			$Config['DbName'] = $DbName;
			$objConfig->dbName = $Config['DbName'];
			$objConfig->connect();
						
			$objCompany->UpdateAdminModules($_POST['CmpID'],$_POST['Department']);		

			
			#$objCompany->UpdateAdminSubModules($_POST['CmpID'],$_POST['Department'],$PaymentPlan);	//Temporary For CRM Frontend Integration


			$objCompany->UpdateInventoryModules($_POST['CmpID'],$_POST['TrackInventory']);		


		}
		
		if($UpdateAdminDateTime == 1){
			if(empty($DbName)){
				$arryCmp = $objCompany->GetCompanyDisplayName($_POST['CmpID']);
			
				$DbName = $Config['DbName']."_".$arryCmp[0]['DisplayName'];
			}
			$Config['DbName'] = $DbName;
			$objConfig->dbName = $Config['DbName'];
			$objConfig->connect();
						
			$objCompany->UpdateLocationDateTime($_POST);				
		}
		/************************/

		/*if (!empty($_GET['edit'])) {
			header("Location:".$ActionUrl);
			exit;
		}else{
			header("Location:".$RedirectURL);
			exit;
		}*/


		
	}
}


	if (!empty($_GET['edit'])) {
		$arryCompany = $objCompany->GetCompany($_GET['edit'],'');
		$CmpID   = $_GET['edit'];	
		
		
		/***************/
		if(empty($arryCompany[0]['CmpID'])){
			header("Location:".$RedirectURL);
			exit;
		}

		if($_SESSION['AdminType']=="user"){ 
			$arrayCmpCheck = $objCompany->CheckUserCmp($_SESSION['AdminID'],$_GET['edit']);
			if(!empty($arrayCmpCheck[0]['id'])){
				header("Location:".$RedirectURL);
				exit;
			}
		}
		/***************/
		if($_GET['tab']=="account"){ 
			$arryReseller=$objReseller->GetResellerBrief('');
		}

		/******* Sync Inventory Seting********/
		
		
		if($_REQUEST['tab']=='syncInventory'){
		$totalItems=$objCompany->TotalExportItems();
		$totalCategory=$objCompany->TotalExportCategory();
		$totalRequiredItems=$objCompany->TotalExportRequiredItems();
		$totalAliasItems=$objCompany->TotalExportAliasItems();
		$totalBOM=$objCompany->TotalExportBOM();
		
		$totalGlobalAttribute=$objCompany->TotalExportGlobalAttribute();
		$totalProcurement=$objCompany->TotalExportSettingType('Procurement');
		$totalEvaluation=$objCompany->TotalExportSettingType('EvaluationType');
		$totalAdjReason=$objCompany->TotalExportSettingType('AdjReason');
		$totalGeneration=$objCompany->TotalExportSettingType('Generation');
		$totalExtended=$objCompany->TotalExportSettingType('Extended');
		$totalManufacture=$objCompany->TotalExportSettingType('Manufacture');
		$totalReorder=$objCompany->TotalExportSettingType('Reorder');
		$totalUnit=$objCompany->TotalExportSettingType('Unit');
		$totalItemType=$objCompany->TotalExportSettingType('ItemType');
		
		$totalPrefixes=$objCompany->TotalExportPrefixes();
		$totalModel=$objCompany->TotalExportModel();
		$totalCondition=$objCompany->TotalExportCondition();
		
		$AllManufacture=$objCompany->SelectAttribute('Manufacture');
		
		
		$SyncCountArray=array(  
		'category'=>$totalCategory,
		'items'=>$totalItems,
		'dimensions'=>$totalItems,
		'required items'=>$totalRequiredItems,
		'alias items'=>$totalAliasItems,
		'BOM'=>$totalBOM,
		'global attributes'=>$totalGlobalAttribute,
		'procurement'=>$totalProcurement,
		'valuation type'=>$totalEvaluation,
		'adjustment reason'=>$totalAdjReason,
		'manage prefixes'=>$totalPrefixes,
		'manage model'=>$totalModel,
		'manage generation'=>$totalGeneration,
		'manage extended'=>$totalExtended,
		'manage manufacture'=>$totalManufacture,
		'manage condition'=>$totalCondition,
		'reorder method'=>$totalReorder,
		'manage unit'=>$totalUnit,	
		'item type'=>$totalItemType									
		);

	}
	/******* End Sync Inventory Seting********/


		

	
	}
				
	if($arryCompany[0]['Status'] != ''){
		$CompanyStatus = $arryCompany[0]['Status'];
	}else{
		$CompanyStatus = 1;
	}
		
	$arrayDateFormat = $objConfig->GetDateFormat();
	$arryDepartment = $objConfig->GetDepartment();
	$arryCountry = $objRegion->getCountry('','');
	$arryCurrency = $objRegion->getCurrency('',1);

	//$HideModule = 'Style="display:none"';
	require_once("includes/footer.php"); 
?>


