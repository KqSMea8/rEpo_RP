<?php
	/**************************************************/
	$ThisPageName = 'viewLead.php?module=lead'; $EditPage = 1;
	/**************************************************/
	require_once("../includes/header.php");
	require_once($Prefix."classes/lead.class.php");
	require_once($Prefix."classes/function.class.php");
	require_once('../php-excel-reader/excel_reader2.php');
	require_once('../php-excel-reader/SpreadsheetReader.php');
	require_once('../php-excel-reader/SpreadsheetReader_XLSX.php');

	$ModuleName = "Lead";
	$objLead=new lead();
	$objFunction=new functions();
       	$RedirectURL = "viewLead.php?curP=".$_GET['curP']."&module=lead";


	if($_SESSION['AdminType'] == "employee") {	
		$AssignTo = $_SESSION['AdminID'];
	}



	if($_POST){
		if($_FILES['excel_file']['name'] != ''){

			/********Connecting to main database*********/
			$Config['DbName'] = $Config['DbMain'];
			$objConfig->dbName = $Config['DbName'];
			$objConfig->connect();
			/*******************************************/

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

			if(@move_uploaded_file($_FILES['excel_file']['tmp_name'], $FileDestination)){
					$Uploaded = 1;
					chmod($FileDestination,0777);
			}
		       }else{
			     $ErrorMsg = $FileArray['ErrorMsg'];
			}
		 }
			if($fileName!="" && file_exists($FileDestination)){			

			   if($fileExt=='xls'){	
			      $Filepath =getcwd()."/".$FileDestination;
			    }
			 else{
			    if (php_sapi_name() == 'cli')
			      {
			       $ErrorMsg=PLEASE_SPECIFY_FILENAME.PHP_EOL;
		        }
			  else{
			     $ErrorMsg=SPECIFY_FILENAME_HTTP_GET_PARAMETER;
			}
			exit;
		}
		
                
			date_default_timezone_set('UTC');
			$StartMem = memory_get_usage();
			$mimeType=mime_content_type($Filepath);

		if($mimeType=='application/zip'){
		   try{
			     $Spreadsheet = new SpreadsheetReader_XLSX($Filepath);
			     $BaseMem = memory_get_usage();

	               while($Spreadsheet->valid()){

		        print_r($Spreadsheet->next());
		       }
		    }  
		     catch (Exception $E){
		           echo $E -> getMessage();
		     } 
		}
		else{
		    try{
			$Spreadsheet = new SpreadsheetReader($Filepath);
			$BaseMem = memory_get_usage();
			$Sheets = $Spreadsheet -> Sheets();
			$Count = 0;
		        foreach ($Sheets as $Index => $Name){
				$Time = microtime(true);
				$Spreadsheet -> ChangeSheet($Index);
				$arrayLead=array();
				foreach ($Spreadsheet as $Key => $Row)
					{
  	/*echo "<pre>";	print_r($Row);echo "</pre>";*/					
	$FirstName=$Row[0];
	$LastName=$Row[1];
	$primary_email=$Row[2];

	$ValidEmail = 1; //temp
	if(!empty($primary_email)){
		if (preg_match("/^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/",$primary_email))
		{
		   $ValidEmail = 1;
		}else{
		   $ValidEmail = 0;
		}
	}

   	if(!empty($FirstName) && !empty($LastName) && $ValidEmail==1){
		unset($arrayLead[$Count]);
		
		$arrayLead[$Count]["FirstName"]=$Row[0];
		$arrayLead[$Count]["LastName"]=$Row[1];
		$arrayLead[$Count]["primary_email"]=$Row[2];
		$arrayLead[$Count]["designation"]=$Row[3];
		$arrayLead[$Count]["company"]=$Row[4];
		$arrayLead[$Count]["type"]=$Row[5];
		$arrayLead[$Count]["ProductID"]=$Row[6];
		$arrayLead[$Count]["product_price"]=$Row[7];
		$arrayLead[$Count]["Website"]=$Row[8];
                $arrayLead[$Count]["Address"]=$Row[9];

		$arrayLead[$Count]["OtherCity"]=$Row[10];
		$arrayLead[$Count]["OtherState"]=$Row[11];
		$arrayLead[$Count]["Country"]=$Row[12];

		$arrayLead[$Count]["ZipCode"]=$Row[13];
		$arrayLead[$Count]["Mobile"]=$Row[14];
		$arrayLead[$Count]["LandlineNumber"]=$Row[15];		
		$arrayLead[$Count]["Industry"]=$Row[16];
		$arrayLead[$Count]["AnnualRevenue"]=$Row[17];

		$arrayLead[$Count]["NumEmployee"]=$Row[18];

		$arrayLead[$Count]["lead_source"]=$Row[19];
		$arrayLead[$Count]["lead_status"]=$Row[20];   		
		$arrayLead[$Count]["description"]=$Row[21];		
			
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
	
		$CurrentMem = memory_get_usage();
      }////end of for loop


		if($Uploaded == 1)unlink($FileDestination);
		/**********************************/		
	//echo '<pre>';print_r($arrayLead);exit; 
		$NumLead=sizeof($arrayLead);
		if($NumLead>0){	
			/******Connecting to company database*******/
			$Config['DbName'] = $_SESSION['CmpDatabase'];
			$objConfig->dbName = $Config['DbName'];
			$objConfig->connect();
			/*******************************************/		
			 for($i=0;$i<$NumLead;$i++){
			   //if(!$objLead->isprimary_emailExists($arrayLead[$i]["primary_email"],'')){
					$leadId=$objLead->AddLead($arrayLead[$i]);	
			   //}
			 }
		}		
		/**********************************/


		if(!empty($leadId)){
			$_SESSION['mess_lead']=LEAD_DATA_IMPORTED;
			header("Location:".$RedirectURL);
			exit;
		}else{
			$ErrorMsg=SHEET_NOT_UPLOADED;
		}
		

         }
       }
	catch (Exception $E)
	{

	echo $E -> getMessage();
	}
      }
    }
}	
@require_once("../includes/footer.php"); 
?>
