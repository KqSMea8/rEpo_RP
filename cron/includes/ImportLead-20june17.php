<?

$Leadfields = $objField->getAllCustomFieldByModuleID('102');
$fieldsName = array_filter(array_map(function($arr){ return $arr['fieldname']; },$Leadfields));
$fieldsLabel = array_filter(array_map(function($arr){return $arr['fieldlabel'];},$Leadfields));
$fieldsArray = array_combine($fieldsName,$fieldsLabel);
$fieldsArray = array_merge($fieldsArray,array("OtherCity" => "City","OtherState" => "State"));

$DbColumnArray =  $fieldsArray;          //By chetan 3Dec//
$DbColumn = sizeof($DbColumnArray);

if($parameters['AssignTo']>0) {
	$AssignTo = $parameters['AssignTo'];
}
/********Connecting to main database*********/
$Config['DbName'] = $Config['DbMain'];
$objConfig->dbName = $Config['DbName'];
$objConfig->connect();
/*******************************************/

$MainDir = $Prefix."admin/crm/upload/Excel/".$parameters['CmpID']."/";
//echo file_exists($MainDir.$parameters['ExcelFile']);
if(!empty($parameters['ExcelFile']) && file_exists($MainDir.$parameters['ExcelFile'])){
		

	$Filepath = $MainDir.$parameters['ExcelFile'];
	#echo '<pre>';print_r($_POST);exit;
	$Spreadsheet = new SpreadsheetReader($Filepath);
		
	$Sheets = $Spreadsheet -> Sheets();
	$Count = 0;
	$LeadAddedCount = 0;
	$LeadCount = 0;
	$arrayLead=array();
	foreach ($Sheets as $Index => $Name){
		$Time = microtime(true);
		$Spreadsheet -> ChangeSheet($Index);

		foreach ($Spreadsheet as $Key => $Row){
			//echo "<pre>";	print_r($Row);echo "</pre>";exit;
			unset($arrayLead[$Count]);
			foreach($DbColumnArray as $Key => $Heading){
				$i = $parameters[$Key];
				$arrayLead[$Count][$Key]=$Row[$i];
			}
			$arrayLead[$Count]["AssignTo"]=$AssignTo;
			$arrayLead[$Count]["AssignType"]='User';

			/************************/
			if(empty($arrayLead[$Count]["Country"])){
				$arrayLead[$Count]["Country"] = $arryCurrentLocation[0]['Country'];
			}




			if(!empty($arrayLead[$Count]["Country"])){
				unset($arryCountry); unset($arryState); unset($arryCity);
				$arryCountry = $objRegion->GetCountryID($arrayLead[$Count]["Country"]);
				$arrayLead[$Count]["country_id"]=$arryCountry[0]['country_id']; //set
				if($arryCountry[0]['country_id']>0 && !empty($arrayLead[$Count]["OtherState"])){
					$arryState = $objRegion->GetStateID($arrayLead[$Count]["OtherState"], $arryCountry[0]['country_id']);
					$arrayLead[$Count]["main_state_id"]=$arryState[0]['state_id'];//set
				}
				if($arryCountry[0]['country_id']>0 && $arryState[0]['state_id']>0 && !empty($arrayLead[$Count]["OtherCity"])){
					$arryCity = $objRegion->GetCityIDSt($arrayLead[$Count]["OtherCity"], $arryState[0]['state_id'], $arryCountry[0]['country_id']);
					$arrayLead[$Count]["main_city_id"]=$arryCity[0]['city_id'];//set
				}
				////////
				$arrayLead[$Count]["State"] = $arrayLead[$Count]["OtherState"];
				$arrayLead[$Count]["City"] = $arrayLead[$Count]["OtherCity"];


			}
			/************************/


			$Count++;
		}
			
	}


		
	$NumLead=sizeof($arrayLead);
	//echo $NumLead."<pre>";print_r($arrayLead);echo "</pre>";exit;
	if($NumLead>0){
		/******Connecting to company database*******/
		$Config['DbName'] = $Config['CmpDatabase'];
		$objConfig->dbName = $Config['DbName'];
		$objConfig->connect();
		/*******************************************/
		//Added by Sanjiv
		$objLead->CreateTempTableForImport();

		for($i=1;$i<$NumLead;$i++){


				
			if(empty($arrayLead[$i]["FirstName"]) && empty($arrayLead[$i]["LastName"])){
				$arrayLead[$i]["FirstName"]='Unknown';$arrayLead[$i]["LastName"]='Unknown';
			}


			if(!empty($arrayLead[$i]["FirstName"]) || !empty($arrayLead[$i]["LastName"])){

				$ValidLead = 1;


			/*	if($parameters['DuplicayColumn'] == 'FirstName,LastName,company'){
					if(!$objLead->isLeadNameCompanyExist($arrayLead[$i]["FirstName"],$arrayLead[$i]["LastName"],$arrayLead[$i]["company"])){
						$ValidLead = 1;
					}
				}else if($parameters['DuplicayColumn'] == 'FirstName,LastName'){
					if(!$objLead->isLeadNameExist($arrayLead[$i]["FirstName"],$arrayLead[$i]["LastName"],'')){
						$ValidLead = 1;
					}
				}else if($parameters['DuplicayColumn'] == 'company'){
					if(!$objLead->isLeadCompanyExist($arrayLead[$i]["company"],'')){
						$ValidLead = 1;
					}
				}else if($parameters['DuplicayColumn'] == 'primary_email'){
					if(!$objLead->isLeadEmailExist($arrayLead[$i]["primary_email"],'')){
						$ValidLead = 1;
					}
				}else if($parameters['DuplicayColumn'] == 'LandlineNumber'){
					if(!$objLead->isLeadLandlineExist($arrayLead[$i]["LandlineNumber"],'')){
						$ValidLead = 1;
					}
				}*/



				if($ValidLead==1){
					/*********************/
					if($arrayLead[$i]["country_id"]>0){ //territory
						$arryTerritoryAssign = $objTerritory->TerritoryRuleLocation($arrayLead[$i]["country_id"],$arrayLead[$i]["main_state_id"],$arrayLead[$i]["main_city_id"]);
						$arrayLead[$i]["TerritoryAssign"] = $arryTerritoryAssign;
					}

					/*********************/

					//$leadId=$objLead->AddImportLead($arrayLead[$i]);	//By Chetan 18Sep//
					//$LeadAddedCount++;
					//$objLead->UpdateCountyStateCity($arrayLead[$i],$leadId);

					$arrayLead[$i]["FolderID"] = $parameters['FolderID'];
					$objLead->importToTemp($arrayLead[$i]);
					//sleep(10);
					$LeadAddedCount++;

				}

			}


		}
			
	}
	/**********************************/
	$parameters['TotalImport'] = $LeadAddedCount;
	unlink($MainDir.$parameters['ExcelFile']);
}

unset($parameters['ExcelFile']);

/*unset($parameters['ExcelFile']);

$mess_lead = "Total lead to import from excel sheet : ".$Count;
$mess_lead .= "<br>Total lead imported into database : ".$LeadAddedCount;
$mess_lead .= "<br>Lead already exist in database : ".($Count-$LeadAddedCount);


if(!empty($leadId)){
$parameters['mess_lead']= $mess_lead;
header("Location:".$RedirectURL);
exit;
}else{
$ErrorMsg = $mess_lead;
}
*/
/*******************************/
/*******************************/

?>
