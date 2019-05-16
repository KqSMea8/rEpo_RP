<?php
        $Cusfields = $objField->getAllCustomFieldByModuleID('2015');
        $AddField = $objField->getFormField('',16,'1'); 
	$Narry = array_map(function($arr){
            if($arr['fieldname'] == 'Landline' || $arr['fieldname'] == 'Mobile' || $arr['fieldname'] == 'contact')
            {
                unset($arr);
            }else{
                return $arr;
            }
        },$AddField);
        $AddField = array_filter($Narry);

        $Allfields = array_merge($Cusfields,$AddField);
        $fieldsName = array_filter(array_map(function($arr){ return $arr['fieldname']; },$Allfields));
        $fieldsLabel = array_filter(array_map(function($arr){return $arr['fieldlabel'];},$Allfields));
        $fieldsArray = array_combine($fieldsName,$fieldsLabel);
        $fieldsArray = array_merge($fieldsArray,array("OtherCity" => "City","OtherState" => "State"));            
       
        $ModuleName = "Customer";
       	$RedirectURL = "viewCustomer.php";       
        $DbColumnArray =  $fieldsArray;


/********Connecting to main database*********/
$Config['DbName'] = $Config['DbMain'];
$objConfig->dbName = $Config['DbName'];
$objConfig->connect();
/*******************************************/

$MainDir = $Prefix."admin/crm/upload/Excel/".$parameters['CmpID']."/";

if(!empty($parameters['ExcelFile']) && file_exists($MainDir.$parameters['ExcelFile'])){
		
 	$Filepath = $MainDir.$parameters['ExcelFile'];
	$Spreadsheet = new SpreadsheetReader($Filepath);
		
	$Sheets = $Spreadsheet -> Sheets();
	$Count = 0;
	$CusAddedCount = 0;
	$CusCount = 0;
	$arrayCust=array();
			
	foreach ($Sheets as $Index => $Name){
		$Time = microtime(true);
		$Spreadsheet -> ChangeSheet($Index);

		foreach ($Spreadsheet as $Key => $Row){
			//echo "<pre>";	print_r($Row);echo "</pre>";exit;
			unset($arrayCust[$Count]);
			foreach($DbColumnArray as $Key => $Heading){
				$i = $parameters[$Key];
				$arrayCust[$Count][$Key]=addslashes(trim($Row[$i]));
			}
			
			$arrayCust[$Count]["Country"] = $arrayCust[$Count]["country_id"];
			
			/************************/
			if(empty($arrayCust[$Count]["Country"])){
				$arrayCust[$Count]["Country"] = $parameters['LocationCountry'];
			}

			/*if(empty($arrayCust[$Count]["Company"]) && empty($arrayCust[$Count]["FirstName"]) && empty($arrayCust[$Count]["LastName"]) && empty($arrayCust[$Count]["Email"])){
				unset($arrayCust[$Count]);
			}*/


			/************************/
if(!empty($arrayCust[$Count]["Country"])){
	 
	//print_r($arrayCust[$Count]); 

	unset($arryCountry); unset($arryState); unset($arryCity);
	 /************************/
	$arryCountry = $objRegion->GetCountryID($arrayCust[$Count]["Country"]); 
        if(empty($arryCountry))
        { 
            $arryCountry = $objRegion->getCountryByCode($arrayCust[$Count]["Country"]); 
        }
	$arrayCust[$Count]["Country"] = (int)$arrayCust[$Count]["Country"];
        if(empty($arrayCust[$Count]["Country"])){
           $arrayCust[$Count]["country_id"] = $arryCountry[0]['country_id'];
           $arrAdd[$Count]["CountryName"] = $arryCountry[0]['name'];
        }  
        /************************/
	if($arrayCust[$Count]['country_id'] > 0 && !empty($arrayCust[$Count]["OtherState"])){		
            $arryState = $objRegion->GetStateID($arrayCust[$Count]["OtherState"], $arrayCust[$Count]['country_id']);
            if(empty($arryState))
            {
                $arryCodeState = $objRegion->GetStateByCode($arrayCust[$Count]["OtherState"], $arrayCust[$Count]['country_id']);
                $arryState = $arryCodeState;
            }
		     $arrayCust[$Count]["country_id"] = (int)$arrayCust[$Count]["country_id"];	
            if(!empty($arrayCust[$Count]['country_id']) ){
                $arrayCust[$Count]["main_state_id"] = $arryState[0]['state_id'];//set
		$StateName = (!empty($arryState[0]['name']))?($arryState[0]['name']):($arrayCust[$Count]["OtherState"]);
		

                $arrAdd[$Count]["StateName"] = $StateName;
                $arrayCust[$Count]["State"] = ($arrayCust[$Count]["main_state_id"]) ? $arryState[0]["name"]  : '';
                
                $arrayCust[$Count]["OtherState"] = ($arrayCust[$Count]["main_state_id"]) ? '':$arrayCust[$Count]["OtherState"]; 
            }    
	}
         /************************/
	if($arrayCust[$Count]['country_id'] > 0 && !empty($arrayCust[$Count]["OtherCity"])){	
		if($arrayCust[$Count]["main_state_id"] > 0 ){
			$arryCity = $objRegion->GetCityIDSt($arrayCust[$Count]["OtherCity"], $arrayCust[$Count]["main_state_id"], $arrayCust[$Count]['country_id']); 
		}else{
			unset($arryCity);
		}
	$CityName = (!empty($arryCity[0]['name']))?($arryCity[0]['name']):($arrayCust[$Count]["OtherCity"]);
	$arrayCust[$Count]["main_city_id"]=$arryCity[0]['city_id'];//set
	$arrAdd[$Count]["CityName"] = $CityName;
	$arrayCust[$Count]["City"] = $arrayCust[$Count]["OtherCity"];
	$arrayCust[$Count]["OtherCity"] = ($arrayCust[$Count]["main_city_id"]) ? '':$arrayCust[$Count]["OtherCity"]; 

	}

}
/************************/


			$Count++;
		}
			
	}


	$arrayCust = array_values(array_filter(array_map('array_filter', $arrayCust)));	
	//added by chetan on 9Aug2017//
	$arrayCust = array_map(function($arr){  
						if(count($arr) == 1){
							if(key($arr) != 'country_id'){ return $arr; }
						}else{
							return $arr;
						}
					}, $arrayCust);	
	$arrayCust = array_filter($arrayCust);	
	//End//	
	$NumCust=sizeof($arrayCust);
	//echo $NumCust."<pre>";print_r($arrayCust);echo "</pre>";exit;
	if($NumCust>0){
		/******Connecting to company database*******/
		$Config['DbName'] = $Config['CmpDatabase'];
		$objConfig->dbName = $Config['DbName'];
		$objConfig->connect();
		/*******************************************/
		//$objSupplier->CreateTempTableForImport();
		 

		for($i=1;$i<$NumCust;$i++){

                                $ValidCust = 0;
				//updated by chetan on 9Aug2017///
                                if($arrayCust[$i]["Email"] !=''
                                    && (!preg_match("/^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/",$arrayCust[$i]["Email"]) 
                                     ||  $objCustomer->isEmailExists($arrayCust[$i]["Email"],'')) )
                                {
                                    //$ValidCust=1;	
					$arrayCust[$i]["Email"] = '';
                                }
                                /*if($arrayCust[$i]["CustCode"]!='' && $objCustomer->isCustCodeExists($arrayCust[$i]["CustCode"])){
                                     $ValidCust=1;	
                                }
                                 
                                if(($arrayCust[$i]["FirstName"]!='' && $arrayCust[$i]["LastName"]!='') && 
                                        $objCustomer->isCustomerExist($arrayCust[$i]["FirstName"],$arrayCust[$i]["LastName"]))
                                {
                                    $ValidCust = 1;
                                }*/
                                //End//
				

                                if($ValidCust == 0)
                                {
			            	$arrayCust[$i]['PID']			=	1;
					$arrayCust[$i]['Status'] 		= 	'No';	
					if($arrayCust[$i]['CustomerType']=='')
					{
						$arrayCust[$i]['CustomerType'] = 'Company';
					}
                                    $CustomerId=$objCustomer->addCustomFieldCustomer($arrayCust[$i]); //updated on 3Aug2017 by chetan//
					unset($arrayCust[$i]['PID']);
					unset($arrayCust[$i]['CustomerType']);
                                    $arrayCust[$i]['PrimaryContact']	=	1;
				
                                    //$AddID = $objCustomer->addCustomerAddress($arrayCust[$i],$CustomerId,'shipping');
				    //$AddID2 = $objCustomer->addCustomerAddress($arrayCust[$i],$CustomerId,'billing');			
		            $AddID = $objCustomer->AddContactByCustomer($arrayCust[$i],$CustomerId,'shipping');//added on 3Aug2017 by chetan//
			    $AddID2 = $objCustomer->AddContactByCustomer($arrayCust[$i],$CustomerId,'billing');//added on 3Aug2017 by chetan//

					 
                                    $arrayCust[$i]["Country"]	=	$arrAdd[$i]["CountryName"];
                                    $arrayCust[$i]["State"]	=	$arrAdd[$i]["StateName"];
                                    $arrayCust[$i]["City"]	=	$arrAdd[$i]["CityName"];
					

															 
                                    $objCustomer->UpdateShippingCountyStateCity($arrayCust[$i],$CustomerId); //update by chetan 20Sep 2016//
                                    $objCustomer->UpdateBillingCountyStateCity($arrayCust[$i],$CustomerId);  //update by chetan 20Sep 2016//
                                    $CusAddedCount++;

                                }
                            
                            }		
			


		}
	/**********************************/
	$parameters['TotalImport'] = $CusAddedCount;
	//unlink($MainDir.$parameters['ExcelFile']);
	//$objCustomer->MoveRecordToMasterTable();
	}
	

//unset($parameters['ExcelFile']);

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
