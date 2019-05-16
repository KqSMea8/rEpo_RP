<?php
    /**************************************************/
    $ThisPageName = 'viewZipCodes.php'; $EditPage = 1; 
    /**************************************************/
	require_once("includes/header.php");
	require_once("../classes/region.class.php");
	require_once("../classes/function.class.php");	 
	require_once("../admin/php-excel-reader/excel_reader2.php");	
	require_once("../admin/php-excel-reader/SpreadsheetReader.php");	
	require_once("../admin/php-excel-reader/SpreadsheetReader_XLSX.php");

	(empty($_GET['country_id']))?($_GET['country_id']=1):(""); 
	(empty($_GET['state_id']))?($_GET['state_id']=''):(""); 
	(empty($_GET['city_id']))?($_GET['city_id']=''):(""); 
	$ErrorMsg='';

	$BackUrl = "viewZipCodes.php?country_id=".$_GET['country_id']."&state_id=".$_GET['state_id']."&city_id=".$_GET['city_id']."&curP=".$_GET['curP'];

	$ModuleName = "ZipCode";	
	$objRegion=new region();
	$objFunction=new functions();
	/************************************/
	if(!empty($_POST['country_id'])){
		if(!empty($_FILES['excel_file']['name'])){

			
	               $FileArray = $objFunction->CheckUploadedFile($_FILES['excel_file'],"Excel");
			
                       if(empty($FileArray['ErrorMsg'])){
				$fileExt = $FileArray['Extension']; 
				$fileName = rand(1,100).".".$fileExt;	
		                $MainDir = "upload/Excel/";					
				
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
		$flag=0;
		    try{
			$Spreadsheet = new SpreadsheetReader($Filepath);
			$BaseMem = memory_get_usage();
			$Sheets = $Spreadsheet -> Sheets();
			$Count = 0; 
		        foreach ($Sheets as $Index => $Name){

				$Time = microtime(true);
				$Spreadsheet -> ChangeSheet($Index);
				$arrayLead=array();
				$Line=0;
			foreach ($Spreadsheet as $Key => $Row){
				$Line++;

if($Line==1 && substr_count(strtolower(trim($Row[0])),'zip')>0){					
	continue;
}
$ZipCode=trim($Row[0]);
//echo $ZipCode.'<br>'; 

   	if(!empty($ZipCode)){				
		unset($arryRegion);	
		/************************/  
		$arryRegion["country_id"]=$_POST['country_id']; //set	
		$arryRegion["main_state_id"]=$_POST['main_state_id'];	
		$arryRegion["main_city_id"]=$_POST['main_city_id'];	
		$arryRegion["zip_code"]=$ZipCode; //set	
		$zipcode_id = $objRegion->addZip($arryRegion); 
		$Count++;		
		/************************/
		
		
	  }
	

		$CurrentMem = memory_get_usage();
      }////end of for loop


		if($Uploaded == 1)
		unlink($FileDestination);
		
		if($Count>0){
	
			$_SESSION['mess_zipcode']=EXCEL_DATA_IMPORTED;
			$RedirectURL = "viewZipCodes.php?country_id=".$_POST['country_id']."&state_id=".$_POST['main_state_id']."&city_id=".$_POST['main_city_id'];
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



	/************************************/
	if(!empty($country_id)){
		$CountrySelected = $country_id  ; 
	}else{
		$CountrySelected = $_GET['country_id'];
	}
	
	if(empty($state_id)){
		$state_id = $_GET['state_id'];
	}
	
	if(empty($city_id)){
		$city_id = $_GET['city_id'];
	}

	$arryCountry = $objRegion->getCountry('','');

	 require_once("includes/footer.php"); 
	 
 ?>
