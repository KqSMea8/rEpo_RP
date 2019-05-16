<?php
	/**************************************************/
	$module = $_GET['module']; $EditPage = 1;
	if($module=='lead'){
		$ThisPageName = 'viewLead.php'; 
	}else{
		header('location:home.php');
		exit;
	}
	
	/**************************************************/
	require_once("../includes/header.php");
	require_once($Prefix."classes/lead.class.php");
	require_once($Prefix."classes/function.class.php");
	require_once('../php-excel-reader/excel_reader2.php');
	require_once('../php-excel-reader/SpreadsheetReader.php');
	require_once('../php-excel-reader/SpreadsheetReader_XLSX.php');


	$objLead=new lead();
	$objFunction=new functions();
       	$RedirectURL = $ThisPageName;


	if($_SESSION['AdminType'] == "employee") {	
		$AssignTo = $_SESSION['AdminID'];
	}


	$DbColumnArray = array(
		"FirstName" => "First Name",
		"LastName" => "Last Name",
		"primary_email" => "Primary Email",
		"designation" => "Title",
		"company" => "Company",
		"type" => "Lead Type",
		"ProductID" => "Product",
		"product_price" => "Product Price",
		"Website" => "Website",
		"Address" => "Address",
		"ZipCode" => "Zip Code",
		"OtherCity" => "City",	
		"OtherState" => "State",
		"Country" => "Country",
		"Mobile" => "Mobile",
		"LandlineNumber" => "LandlineNumber",
		"Industry" => "Industry",
		"AnnualRevenue" => "Annual Revenue",
		"NumEmployee" => "Number of Employee",
		"lead_source" => "Lead Source",
		"lead_status" => "Lead Status",
		"description" => "Description",
		"lead_source" => "Lead Source"

	);
	$DbColumn = sizeof($DbColumnArray);

	

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
			foreach ($Sheets as $Index => $Name){
				$Time = microtime(true);
				$Spreadsheet -> ChangeSheet($Index);
				$arrayLead=array();
				foreach ($Spreadsheet as $Key => $Row){
					//echo "<pre>";	print_r($Row);echo "</pre>";exit;
					unset($arrayLead[$Count]);	
					foreach($DbColumnArray as $Key => $Heading){ 
						$i = $_POST[$Key];
						$arrayLead[$Count][$Key]=$Row[$i];
					}
					$arrayLead[$Count]["AssignTo"]=$AssignTo; 

/************************/
if(!empty($arrayLead[$Count]["Country"])){
	$arryCountry = $objRegion->GetCountryID($arrayLead[$Count]["Country"]);  
	$arrayLead[$Count]["country_id"]=$arryCountry[0]['country_id']; //set	
	if($arryCountry[0]['country_id']>0 && !empty($arrayLead[$Count]["OtherState"])){		
		$arryState = $objRegion->GetStateID($arrayLead[$Count]["OtherState"], $arryCountry[0]['country_id']); 
		$arrayLead[$Count]["main_state_id"]=$arryState[0]['state_id'];//set
	}
	if($arryCountry[0]['country_id']>0 && !empty($arrayLead[$Count]["OtherCity"])){		
		$arryCity = $objRegion->GetCityID($arrayLead[$Count]["OtherCity"], $arryCountry[0]['country_id']); 
		$arrayLead[$Count]["main_city_id"]=$arryCity[0]['city_id'];//set
	}
}
/************************/


					$Count++;
				}
					
			}


			#echo "<pre>";print_r($arrayLead);echo "</pre>";exit;
			$NumLead=sizeof($arrayLead);
			if($NumLead>0){	
				/******Connecting to company database*******/
				$Config['DbName'] = $_SESSION['CmpDatabase'];
				$objConfig->dbName = $Config['DbName'];
				$objConfig->connect();
				/*******************************************/		
				 for($i=1;$i<$NumLead;$i++){
					if(!empty($arrayLead[$i]["FirstName"]) && !empty($arrayLead[$i]["LastName"]) && !empty($arrayLead[$i]["primary_email"])){
					$primary_email = $arrayLead[$i]["primary_email"];
					if(!empty($primary_email)){
						if (preg_match("/^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/",$primary_email))
						{
						    	$ValidEmail = 1;
						}else{
						   $ValidEmail = 0;
						}
					}

					   //$ValidEmail = 1; //temporaray

					   if($ValidEmail==1 && !$objLead->isprimary_emailExists($arrayLead[$i]["primary_email"],'')){
						$leadId=$objLead->AddLead($arrayLead[$i]);	
					   }

					}


				 }
			}		
			/**********************************/
			
				unlink($MainDir.$_SESSION['ExcelFile']);
			}
			
			unset($_SESSION['ExcelFile']);
			if(!empty($leadId)){				
				$_SESSION['mess_lead']=LEAD_DATA_IMPORTED;
				header("Location:".$RedirectURL);
				exit;
			}else{
				$ErrorMsg = SHEET_NOT_UPLOADED;				
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
                	$Filepath = $FileDestination;			
			$mimeType=mime_content_type($Filepath);
		  
			$Spreadsheet = new SpreadsheetReader($Filepath);			
			$Sheets = $Spreadsheet -> Sheets();
			$Count = 0;
		        foreach ($Sheets as $Index => $Name){
				$Time = microtime(true);
				$Spreadsheet -> ChangeSheet($Index);
				$arrayLead=array();
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
}

/*******************************/
/*******************************/	


}	





include("../includes/html/box/import_form.php");
include_once("../includes/footer.php"); 
?>
