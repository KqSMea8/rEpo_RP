<?php
    /**************************************************/
    $ThisPageName = 'viewZipCodes.php'; $EditPage = 1; 
    /**************************************************/
	require_once("includes/header.php");
	require_once("../classes/region.class.php");
	require_once("../classes/function.class.php");	
	require_once("../admin/language/english.php");	
	require_once("../admin/php-excel-reader/excel_reader2.php");	
	require_once("../admin/php-excel-reader/SpreadsheetReader.php");	
	require_once("../admin/php-excel-reader/SpreadsheetReader_CSV.php");

	$BackUrl = "viewZipCodes.php?country_id=".$_GET['country_id']."&state_id=".$_GET['state_id']."&city_id=".$_GET['city_id']."&curP=".$_GET['curP'];

	$ModuleName = "ZipCode";	
	$objRegion=new region();
	$objFunction=new functions();
	/************************************/
	$_POST['country_id']= 2;
	$_POST['state_id']= 1280;
	$fileExt = 'csv';
	$fileName = $_GET['fileName']; //'ABpostcodes.csv';
	$MainDir = "upload/Excel/UK/";	
	$FileDestination = $MainDir.$fileName;
	/************************************/
	if(empty($fileName)){
		$files1 = scandir($MainDir);
		foreach($files1 as $fl){
			if(strlen($fl)>3)
			echo '<a href="?fileName='.$fl.'">'.$fl.'</a><br><br>';
		}
		exit;
	}
	/************************************/

	//if($_POST['country_id']>0 && $_POST['state_id']>0){
	if($_POST['country_id']>0 && !empty($_GET['fileName'])){
		
			if($fileName!="" && file_exists($FileDestination)){			

			   if($fileExt=='csv'){	
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

if($Line==1){					
	continue;
}

$InUse= 'Yes';

$ZipCode = trim($Row[0]);
//$InUse = trim($Row[1]);
$CityName = trim($Row[6]);
$StateName = trim($Row[8]);

/*
$ZipCodeArray = explode(" ",$ZipCode);
if(!empty($ZipCodeArray[1])){	 
	$ZipCode = trim($ZipCodeArray[0]);
}*/
if($InUse=='Yes'){ 
	//echo $ZipCode.' '.$CityName.' '.$StateName.'<br>'; 
	//echo '<pre>';print_r($Row);exit;
}

	$state_id=0;

   	if($InUse=='Yes' && !empty($ZipCode) && !empty($CityName)  && !empty($StateName)){				
		unset($arryRegion);	
		/************************/  
		$arryRegion["country_id"]=$_POST['country_id']; //set
		/**************/
		$arryState = $objRegion->GetStateID($StateName, $_POST['country_id']); 
 
		/************************
		$arryState = $objRegion->GetStateID($StateName, $_POST['country_id']); 		
		if(empty($arryState[0]['state_id'])){
			$arryRegion["name"]=$StateName; //set	
			$state_id = $objRegion->addState($arryRegion); 			
		}else{
			$state_id = $arryState[0]['state_id'];
		}
		/***********/	
		$state_id = $arryState[0]['state_id'];

		if($state_id>0 && $state_id==$_POST['state_id']){

			$arryCity = $objRegion->GetCityIDSt($CityName, $state_id, $_POST['country_id']); 

			if(empty($arryCity[0]['city_id'])){
				$arryRegion["name"]=$CityName; //set	
				$arryRegion["main_state_id"]=$state_id; //set
				//$city_id = $objRegion->addCity($arryRegion); 
echo $CityName.'#'.$StateName.'<br>'; 			
			}else{
				$city_id = $arryCity[0]['city_id'];
			}
		
			/************************/

			if(!$objRegion->isZipCodeExists($ZipCode,$city_id,'')){
				/**************/
				$arryRegion["main_state_id"]=$state_id;
				$arryRegion["main_city_id"]=$city_id;

				$arryRegion["zip_code"]=$ZipCode; //set	
				//$zipcode_id = $objRegion->addZip($arryRegion); 
				$Count++;		
				/************************/
			}
			//if($Count==20){exit;}

		}
		 
		
	  }
	

		$CurrentMem = memory_get_usage();
      }////end of for loop


		if($Uploaded == 1)
		unlink($FileDestination);
		
		if($Count>0){
	
			$_SESSION['mess_zipcode']=EXCEL_DATA_IMPORTED;
			 
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


echo $_SESSION['mess_zipcode'].'<br>'.$Count.' record updated.';
 exit;
	 
 ?>
