<?php
 $DbColumnArray = array(
							"SuppCode" => "Vendor Code",
							"SuppType" => "Vendor Type",
							"CompanyName" => "Company Name",
							"Currency" => "Currency",
							"PaymentTerm" => "Payment Term",
							"PaymentMethod" => "Payment Method",
							"FirstName" => "First Name",
							"LastName" => "Last Name",
							"Email" => "Email",
							"Address" => "Address",
							"Country" => "Country",
							"OtherCity" => "City",	
							"OtherState" => "State",
							"ZipCode" => "Zip Code",
							"Mobile" => "Mobile",
							"Landline" => "Landline Number",
							"Fax" => "Fax",
							"Website" => "Website URL"
);
$DbColumn = sizeof($DbColumnArray);

/********Connecting to main database*********/
$Config['DbName'] = $Config['DbMain'];
$objConfig->dbName = $Config['DbName'];
$objConfig->connect();
/*******************************************/

$MainDir = $Prefix."admin/finance/upload/Excel/".$parameters['CmpID']."/";

if(!empty($parameters['ExcelFile']) && file_exists($MainDir.$parameters['ExcelFile'])){
		

	$Filepath = $MainDir.$parameters['ExcelFile'];
	
	$Spreadsheet = new SpreadsheetReader($Filepath);
		
	$Sheets = $Spreadsheet -> Sheets();
	$Count = 0;
	$VendorAddedCount = 0;
	$VendorCount = 0;
	$arrayVendor=array();
	foreach ($Sheets as $Index => $Name){
		$Time = microtime(true);
		$Spreadsheet -> ChangeSheet($Index);

		foreach ($Spreadsheet as $Key => $Row){
			//echo "<pre>";	print_r($Row);echo "</pre>";exit;
			unset($arrayVendor[$Count]);
			foreach($DbColumnArray as $Key => $Heading){
				$i = $parameters[$Key];
				$arrayVendor[$Count][$Key]=addslashes($Row[$i]);
			}
			
			/************************/
			if(empty($arrayVendor[$Count]["Country"])){
				$arrayVendor[$Count]["Country"] = $parameters['LocationCountry'];
			}




			/************************/
if(!empty($arrayVendor[$Count]["Country"])){
	unset($arryCountry); unset($arryState); unset($arryCity);
	$arryCountry = $objRegion->GetCountryID($arrayVendor[$Count]["Country"]); 
        if(empty($arryCountry))
        { 
            $arryCountry = $objRegion->getCountryByCode($arrayVendor[$Count]["Country"]); 
        }
	$arrayVendor[$Count]["Country"] = (int)$arrayVendor[$Count]["Country"];
        if(empty($arrayVendor[$Count]["Country"])){
           $arrayVendor[$Count]["country_id"] = $arryCountry[0]['country_id'];
           $arrAdd[$Count]["CountryName"] = $arryCountry[0]['name'];
        }  
        
	if($arrayVendor[$Count]['country_id'] > 0 && !empty($arrayVendor[$Count]["OtherState"])){		
            $arryState = $objRegion->GetStateID($arrayVendor[$Count]["OtherState"], $arrayVendor[$Count]['country_id']);
            if(empty($arryState))
            {
                $arryCodeState = $objRegion->GetStateByCode($arrayVendor[$Count]["OtherState"], $arrayVendor[$Count]['country_id']);
                $arryState = $arryCodeState;
            }
		     $arrayVendor[$Count]["country_id"] = (int)$arrayVendor[$Count]["country_id"];	
            if(!empty($arrayVendor[$Count]['country_id']) ){
                $arrayVendor[$Count]["main_state_id"] = $arryState[0]['state_id'];//set
                $arrAdd[$Count]["StateName"] = $arryState[0]['name'];
                $arrayVendor[$Count]["State"] = ($arrayVendor[$Count]["main_state_id"]) ? $arryState[0]["name"]  : '';
                
                $arrayVendor[$Count]["OtherState"] = ($arrayVendor[$Count]["main_state_id"]) ? '':$arrayVendor[$Count]["OtherState"]; 
            }    
	}
        
	if($arrayVendor[$Count]['country_id'] > 0 && $arrayVendor[$Count]["main_state_id"] > 0 && !empty($arrayVendor[$Count]["OtherCity"]))	{		
	$arryCity = $objRegion->GetCityIDSt($arrayVendor[$Count]["OtherCity"], $arrayVendor[$Count]["main_state_id"], $arrayVendor[$Count]['country_id']); 

	$arrayVendor[$Count]["main_city_id"]=$arryCity[0]['city_id'];//set
	$arrAdd[$Count]["CityName"] = $arryCity[0]['name'];
	$arrayVendor[$Count]["City"] = $arrayVendor[$Count]["OtherCity"];
	$arrayVendor[$Count]["OtherCity"] = ($arrayVendor[$Count]["main_city_id"]) ? '':$arrayVendor[$Count]["OtherCity"]; 
	}

}
/************************/


			$Count++;
		}
			
	}


	$arrayVendor = array_values(array_filter(array_map('array_filter', $arrayVendor)));		
	$NumVendor=sizeof($arrayVendor);
	//echo $NumVendor."<pre>";print_r($arrayVendor);//echo "</pre>";exit;
	if($NumVendor>0){
		/******Connecting to company database*******/
		$Config['DbName'] = $Config['CmpDatabase'];
		$objConfig->dbName = $Config['DbName'];
		$objConfig->connect();
		/*******************************************/
		//$objSupplier->CreateTempTableForImport();

		for($i=1;$i<$NumVendor;$i++){

				$ValidVendor = 0;

				if($_SESSION['DuplicayColumn'] == 'SuppCode' && $arrayVendor[$i]["SuppCode"]!=''){
				    if($objSupplier->isVendorCodeExists($arrayVendor[$i]["SuppCode"])){
					    $ValidVendor = 1;	
				    }
				}
				else if($_SESSION['DuplicayColumn'] == 'CompanyName' && $arrayVendor[$i]["CompanyName"]!=''){
				    if($objSupplier->isCompanyExists($arrayVendor[$i]["CompanyName"])){
					    $ValidVendor = 1;	
				    }
				}else if($_SESSION['DuplicayColumn'] == 'Email' && $arrayVendor[$i]["Email"]!=''){
				    if($objSupplier->isEmailExist($arrayVendor[$i]["Email"])){
					    $ValidVendor = 1;	
				    }
				}
				if($ValidVendor==0){
					//$objSupplier->importToTemp($arrayVendor[$i]);
					$arrayVendor[$i]['PID']			=	1;
					$arrayVendor[$i]['AdminType'] 		= 	$_SESSION['AdminType'];
					$arrayVendor[$i]['AdminID'] 		= 	$_SESSION['AdminID'];
					$arrayVendor[$i]['Status'] 		= 	0;
					$VendorID	=	$objSupplier->AddSupplier($arrayVendor[$i]); 
					$arrayVendor[$i]['PrimaryContact']=1;			
					$billingID 	= 	$objSupplier->addSupplierAddress($arrayVendor[$i],$VendorID,'billing');	
					$shippingID 	= 	$objSupplier->addSupplierAddress($arrayVendor[$i],$VendorID,'shipping');
					$arrayVendor[$i]["Country"]	=	$arrAdd[$i]["CountryName"];
					$arrayVendor[$i]["State"]	=	$arrAdd[$i]["StateName"];
					$arrayVendor[$i]["City"]	=	$arrAdd[$i]["CityName"];

					$objSupplier->UpdateAddCountryStateCity($arrayVendor[$i],$billingID);
					$objSupplier->UpdateAddCountryStateCity($arrayVendor[$i],$shippingID);
					$VendorAddedCount++;

				}

			}


		}
	/**********************************/
	$parameters['TotalImport'] = $VendorAddedCount;
	unlink($MainDir.$parameters['ExcelFile']).'--result';
	//$objSupplier->DropDataOFImport();
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
