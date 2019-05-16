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

	$EditUrl = "editCompany.php?edit=".$_GET["edit"]."&curP=".$_GET["curP"]."&tab="; 
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

	$_POST['Department'] = implode(",",$_POST['Department']);
	

	 if (empty($_POST['Email']) && empty($_POST['CmpID'])) {
		$errMsg = ENTER_EMAIL;
	 } else {
		if (!empty($_POST['CmpID'])) {
			$ImageId = $_POST['CmpID'];
			/*
			$objCompany->UpdateCompany($_POST);
			$_SESSION['mess_company'] = COMPANY_UPDATED;
			*/
			/***************************/
			switch($_GET['tab']){
				case 'company':

				/*************************/
				$ValidateData = array(        
					array("name" => "CompanyName", "label" => "Company Name" , "min" => "3"),
					array("name" => "ZipCode", "label" => "Zip Code"),
					array("name" => "AlternateEmail", "label" => "Alternate Email" , "type" => "email" , "opt" => "1"),
				
					array("name" => "LandlineNumber", "label" => "Landline Number" , "min" => "10", "max" => "20", "type" => "number")
							
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
					break;
				case 'account':
				/*************************/
				$ValidateData = array(	
					array("name" => "Email", "label" => "Login Email" , "type" => "email"),
					array("name" => "Password", "label" => "New Password", "min" => "5", "opt" => "1"),
					array("name" => "ConfirmPassword", "label" => "Confirm Password" , "opt" => "1")			
				);

				$ValidateErrorMsg = $objFunction->ValidatePostData($ValidateData);
				if(!empty($_POST['Password']) && $_POST['Password']!=$_POST['ConfirmPassword']){
					$ValidateErrorMsg .= '<br>'.CONFIRM_PASSWORD_NOT_MATCH;
				}

				if(!empty($ValidateErrorMsg)){
					$_SESSION['mess_company'] = $ValidateErrorMsg;
					header("Location:".$ActionUrl);
					exit;
				}
				/*************************/
					$objCompany->UpdateAccount($_POST);
					$objCompany->defaultInventoryCompanyUpdate($_POST['CmpID'],$_POST['DefaultInventoryCompany']); //inventory sync setting
					$objCompany->defaultCompanyUpdate($_POST['CmpID'],$_POST['DefaultCompany']);
					
					$_SESSION['mess_company'] = ACCOUNT_UPDATED;
					break;
				case 'permission':
				/*************************/
				$ValidateData = array(	
					array("name" => "MaxUser", "label" => "Allowed Number Of Users" , "min" => "1", "type" => "number"),
					array("name" => "StorageLimit", "label" => "Data Storage Limit" , "min" => "1", "type" => "number")
					
				);

				$ValidateErrorMsg = $objFunction->ValidatePostData($ValidateData);
				
				if(!empty($ValidateErrorMsg)){
					$_SESSION['mess_company'] = $ValidateErrorMsg;
					header("Location:".$ActionUrl);
					exit;
				}
				/*************************/



					$objCompany->UpdatePermission($_POST);
					$UpdateAdminMenu = 1;
					$_SESSION['mess_company'] = PERMISSION_UPDATED;
					break;
				case 'currency':
					$ArrayCompany=$objCompany->GetCompany($_POST['CmpID'],1);
					 $DbName2 = $Config['DbName']."_".$ArrayCompany[0]['DisplayName'];	
					$objCompany->UpdateCurrency($_POST);
					$objConfig->dbName = $DbName2;
					$objConfig->connect();											
					$objConfigure->UpdateLocationCurrency($_POST);
					$_SESSION['mess_company'] = CURRENCY_UPDATED;
					break;
				case 'DateTime':
					$objCompany->UpdateDateTime($_POST);
					$UpdateAdminDateTime = 1;
					$_SESSION['mess_company'] = DATETIME_UPDATED;
					break;
				 /*case 'default':
					$objCompany->defaultCompanyUpdate($_POST['CmpID'],$_POST['DefaultCompany']);
					break;*/
	/* Inventory sync setting by karishma  */
			case 'syncInventory':
				$AutomaticSyncAction=json_encode($_POST['AutomaticSyncAction']); 
				$syncInventorySetting= json_encode($_POST['syncInventory']);
				$objCompany->UpdatesyncInventorySetting($_POST['CmpID'],$syncInventorySetting,$AutomaticSyncAction);
				$url="http://www.eznetcrm.com/erp/superadmin/curlSyncCompanyInventory.php?CmpID=".$_POST['CmpID'];
				$ch = curl_init($url);
				curl_setopt($ch, CURLOPT_HEADER, 0);
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				$result = curl_exec($ch);      
				curl_close($ch);
//$objCompany->syncInventoryCompany($_POST['CmpID']);



				$_SESSION['mess_company'] = SYNCSETTING_UPDATED;
			break;
	/* End Sync setting */

					case 'InvSetting':

							$objCompany->UpdateInvSettingOther($_POST);
							$objCompany->UpdateSelectItem($_POST);

							/********Connecting to main database*********/
							$ArrayCompany=$objCompany->GetCompany($_POST['CmpID'],1);
							$DbName2 = $Config['DbName']."_".$ArrayCompany[0]['DisplayName'];	
							//$objCompany->UpdateCurrency($_POST);
							$objConfig->dbName = $DbName2;
							$objConfig->connect();	
							/*******************************************/

							$objCompany->UpdateInventoryModules($_POST['CmpID'],$_POST['TrackInventory']);	
							if($_POST['SelectOneItem']!='')	{
										$objCompany->UpdateStandardModules($_POST['CmpID'],$_POST['SelectOneItem']);	
							}
							$_SESSION['mess_company'] = INV_UPDATED;
							break;

case 'warehouse':

							$objCompany->UpdateWarehouseSetting($_POST);
							

							
							$_SESSION['mess_company'] = W_UPDATED;
							break;
				

				case 'Call':
				
				 
			if(!empty($_POST['CallServerUpdate'])){
				 
				//print_r($_POST);	exit;
				#delete data of call_country_code
				$objphone->delete('call_country_code', array('company_id'=>$_POST['CmpID']));


				#insert data in call_country_code tbl
				foreach($_POST['country_code'] as $code) {
				$objphone->insert('call_country_code', array('company_id'=>$_POST['CmpID'],'country_id'=>$code));
				}
					
					
					if(empty($DbName)){
						$comdata=$objCompany->GetCompanyDisplayName($_POST['CmpID']);						
						$DbName = $Config['DbName']."_".$comdata[0]['DisplayName'];
					}
					$Config['DbName'] = $DbName;
					$objConfig->dbName = $Config['DbName'];
					$objConfig->connect();														
					 $name = $comdata[0]['DisplayName'];
					 
					 
					 
					 
					 
						
						if(empty($_POST['call_setting_id'])){
							
							 
							
							
							$responce=$objphone->CreateGroup($name,$_POST['server']);
							
							if(!empty($responce['error'])){
								$_SESSION['mess_company']=$responce['error'];				
							}else{
								$_SESSION['mess_company']=$responce['success'];	
								header("Location:editCompany.php?edit=".$_GET['edit']."&curP=".$_GET['curP']."&tab=".$_GET['tab']);
							}
						}else{	

              
								
							
							if($_POST['old_server']!=$_POST['server']){
								
								$parm = "acl_group.php?action=groupadd&group=".$name."&description=".$name;				
				   				//$data  = $this->api($parm,array(),$_POST['server']);




   				//if(!empty($data->id)){ 
		   			$_POST['old_server'];		   			
		   			$parm = "acl_group.php?action=groupdelete&group_id=".$_POST['old_group_id'];
		   			//$res  = $this->api($parm,array(),$_POST['server']);
					$objphone->update('c_call_setting',array('server_id'=>$_POST['server'],'group_id'=>$data->id),array('id'=>$_POST['call_setting_id']));
					$_SESSION['mess_company']='Update Successfully';	
					header("Location:editCompany.php?edit=".$_GET['edit']."&curP=".$_GET['curP']."&tab=".$_GET['tab']);
	   			/*}else{
					$_SESSION['mess_company']=$data->error;						
				}*/
			   			}
					}
				
				}
				break;
			}
			/***************************/
		} else {

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
				$ActionUrl = 'editCompany.php';			
				header("Location:".$ActionUrl);
				exit;
			}
			/*************************/
			

			$ImageId = $objCompany->AddCompany($_POST);
			$_SESSION['mess_company'] = COMPANY_ADDED;	
			$AddDatabase = 1; 
			$UpdateAdminMenu = 1;
			$_POST['TrackInventory'] = 1;
			
		}
		
		$_POST['CmpID'] = $ImageId;
		
		
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
		/************************************/
		/************************/
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

			$objCompany->UpdateHostbillMenu($_POST['CmpID'],$_POST['Hostbill']);	

		}
		/************************/

		/************************/
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






		if (!empty($_GET['edit'])) {
			header("Location:".$ActionUrl);
			exit;
		}else{
			header("Location:".$RedirectURL);
			exit;
		}


		
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


