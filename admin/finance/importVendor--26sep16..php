<?php

	/**************************************************/
	$ThisPageName = 'viewSupplier.php';  
	/**************************************************/
	include_once("../includes/header.php"); 

	require_once($Prefix."classes/supplier.class.php"); 
	require_once($Prefix."classes/function.class.php");
	require_once('../php-excel-reader/excel_reader2.php');
	require_once('../php-excel-reader/SpreadsheetReader.php');
	require_once('../php-excel-reader/SpreadsheetReader_XLSX.php');

//ini_set('display_errors',1);
$ModuleName = "Vendor";
	$objSupplier=new supplier();
	$objFunction=new functions();
       	$RedirectURL = "viewSupplier.php";

      
	
	
	if($_SESSION['AdminType'] == "employee") {	
		$AssignTo = $_SESSION['AdminID'];
	}


	$Config['Online']=0;  //To stop email

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
       $DbUniqueArray = array(
		
		"CompanyName" => "Company Name",
		"Email" => "Email"
		
	);
    

	



	if($_POST){
		/*******************************/
		/*******************************/
		if($_POST['FileDestination'] != ''){
			
			/********Connecting to main database*********/
			$Config['DbName'] = $Config['DbMain'];
			$objConfig->dbName = $Config['DbName'];
			$objConfig->connect();
			/*******************************************/

			$MainDir = "upload/Excel/".$_SESSION['CmpID']."/";			
			if(!empty($_SESSION['ExcelFile']) && file_exists($MainDir.$_SESSION['ExcelFile'])){
			

			$Filepath = $MainDir.$_SESSION['ExcelFile'];
			#echo '<pre>';print_r($_POST);exit;
			$Spreadsheet = new SpreadsheetReader($Filepath);
			
			$Sheets = $Spreadsheet -> Sheets();
			$Count = 0;
			$VendorAddedCount = 0;

			$VendorCount = 0;

			foreach ($Sheets as $Index => $Name){
				$Time = microtime(true);
				$Spreadsheet -> ChangeSheet($Index);
				$arrayVendor=array();
				foreach ($Spreadsheet as $Key => $Row){
					//echo "<pre>";	print_r($Row);echo "</pre>";exit;
					unset($arrayVendor[$Count]);	
					foreach($DbColumnArray as $Key => $Heading){ 
						$i = $_POST[$Key];
						$arrayVendor[$Count][$Key]=addslashes($Row[$i]);
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
        
						if($arrayVendor[$Count]['country_id'] > 0 && $arrayVendor[$Count]["main_state_id"] > 0 && !empty($arrayVendor[$Count]["OtherCity"])){		
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
			#echo "<pre>";print_r($arrayVendor);echo "</pre>";exit;
			$NumLead=sizeof($arrayVendor);
			if($NumLead>0){	
				/******Connecting to company database*******/
				$Config['DbName'] = $_SESSION['CmpDatabase'];
				$objConfig->dbName = $Config['DbName'];
				$objConfig->connect();
				/*******************************************/		
				 for($i=1;$i<$NumLead;$i++){


			
			if(empty($arrayVendor[$i]["FirstName"]) && empty($arrayVendor[$i]["LastName"])){
				$arrayVendor[$i]["FirstName"]='Unknown';$arrayVendor[$i]["LastName"]='Unknown';
			}


					if(!empty($arrayVendor[$i]["FirstName"]) || !empty($arrayVendor[$i]["LastName"])){
	/*
	$primary_email = $arrayVendor[$i]["primary_email"];
	$ValidEmail = 0;				
	if(!empty($primary_email)){
		if (preg_match("/^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/",$primary_email))
		{
		    if(!$objSupplier->isprimary_emailExists($primary_email,'')){
			$ValidEmail = 1;	
		    }

		}
	}
	$ValidLead = 0;
	if(!$objSupplier->isLeadExist($arrayVendor[$i]["FirstName"],$arrayVendor[$i]["LastName"],$arrayVendor[$i]["company"],'')){
		$ValidLead = 1;	
	} 
	*/
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
//echo "bhoodev"; exit;
$VendorID=$objSupplier->AddSupplier($arrayVendor[$i]);
//By chetan 12Feb//    
$arrayVendor[$i]['PrimaryContact']=1;
//$AddID = $objSupplier->addSupplierAddress($arrayVendor[$i],$VendorID,'contact');
$billingID = $objSupplier->addSupplierAddress($arrayVendor[$i],$VendorID,'billing');	
		$shippingID = $objSupplier->addSupplierAddress($arrayVendor[$i],$VendorID,'shipping');
$arrayVendor[$i]["Country"]=$arrAdd[$i]["CountryName"];
$arrayVendor[$i]["State"]=$arrAdd[$i]["StateName"];
$arrayVendor[$i]["City"]=$arrAdd[$i]["CityName"];

$objSupplier->UpdateAddCountryStateCity($arrayVendor[$i],$billingID);
$objSupplier->UpdateAddCountryStateCity($arrayVendor[$i],$shippingID);
$VendorAddedCount++;
//End//


						


					   }

					}


				 }
			}		
			/**********************************/
			
				unlink($MainDir.$_SESSION['ExcelFile']);
			}
			
			unset($_SESSION['ExcelFile']);

			$mess_vendor = "Total Vendor to import from excel sheet : ".$Count;
			$mess_vendor .= "<br>Total Vendor imported into database : ".$VendorAddedCount;
			$mess_vendor .= "<br>Vendor already exist in database : ".($Count-$VendorAddedCount);


			if(!empty($VendorID)){								
				$_SESSION['mess_supplier']= $mess_vendor;				
				header("Location:".$RedirectURL);
				exit;
			}else{
				$ErrorMsg = $mess_vendor;			
			}
		
		/*******************************/
		/*******************************/
		}else if($_FILES['excel_file']['name'] != ''){
			
	               $FileArray = $objFunction->CheckUploadedFile($_FILES['excel_file'],"Excel");
			
                       if(empty($FileArray['ErrorMsg'])){
				$fileExt = $FileArray['Extension']; 
				$fileName = rand(1,100).".".$fileExt;	
		                $MainDir = "upload/Excel/".$_SESSION['CmpID']."/";						
				 if (!is_dir($MainDir)) {
					mkdir($MainDir);
					chmod($MainDir,0777);
				 }
		            	$FileDestination = $MainDir.$fileName;
			if(!empty($_SESSION['ExcelFile']) && file_exists($MainDir.$_SESSION['ExcelFile'])){		$Uploaded = 1;
				$FileDestination = $MainDir.$_SESSION['ExcelFile'];
	
			}else if(@move_uploaded_file($_FILES['excel_file']['tmp_name'], $FileDestination)){
					$Uploaded = 1;
					chmod($FileDestination,0777);
					$_SESSION['ExcelFile']=$fileName;
			}
		       }else{
			     $ErrorMsg = $FileArray['ErrorMsg'];
			}
		 }
		

		if($fileName!="" && file_exists($FileDestination)){	
			$_SESSION['DuplicayColumn']=$_POST['DuplicayColumn'];	
			
  	
                	$Filepath = $FileDestination;			
			$mimeType=mime_content_type($Filepath);
		  
			$Spreadsheet = new SpreadsheetReader($Filepath);			
			$Sheets = $Spreadsheet -> Sheets();
			$Count = 0;
		        foreach ($Sheets as $Index => $Name){
				$Time = microtime(true);
				$Spreadsheet -> ChangeSheet($Index);
				$arrayVendor=array();
				foreach ($Spreadsheet as $Key => $Row){
	
				if(!empty($Row[0]) && !empty($Row[1]) && !empty($Row[2])){	
					foreach ($Row as $val){
						$arrayHeader[]=$val;
					}
					$Count++;
					break;		
				}
	
		
		if($Count==1) break;
      }////end of for loop


		
		/**********************************/		
		//echo '<pre>';print_r($arrayHeader);exit; 
		$NumHeader=sizeof($arrayHeader);		
		/**********************************/


		if($NumHeader>0){
			//Ready for selection		
			
		}else{
			
			$ErrorMsg=SHEET_NOT_UPLOADED;
		}
		

       
      
      }

}else{
	unset($_SESSION['ExcelFile']);
	//unset($_SESSION['DuplicayColumn']);
	
}

/*******************************/
/*******************************/	


}else{

	$MainDir = "upload/Excel/".$_SESSION['CmpID']."/";			
	if(!empty($_SESSION['ExcelFile']) && file_exists($MainDir.$_SESSION['ExcelFile'])){
		unlink($MainDir.$_SESSION['ExcelFile']);
	}
	unset($_SESSION['ExcelFile']);
	//unset($_SESSION['DuplicayColumn']);
	
}	







//echo 'Excel file: '.$_SESSION['ExcelFile'];



//$DownloadFile = 'upload/Excel/LeadTemplate.xls';
$NumMandatory = 2;



include_once("../includes/footer.php"); 
?>
