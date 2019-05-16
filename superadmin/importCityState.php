<?php
	require_once("includes/header.php");
	require_once("../classes/region.class.php");
	require_once("../classes/function.class.php");
	require_once("../admin/language/english.php");
	require_once('../admin/php-excel-reader/excel_reader2.php');
	require_once('../admin/php-excel-reader/SpreadsheetReader.php');
	require_once('../admin/php-excel-reader/SpreadsheetReader_XLSX.php');

	$ModuleName = "State";	
	$objRegion=new region();
	$objFunction=new functions();
	/************************************/
	if($_POST['country_id']>0){
		if($_FILES['excel_file']['name'] != ''){

			
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
				foreach ($Spreadsheet as $Key => $Row)
					{
					$Line++;
					if($Line==1) continue;
  	//echo "<pre>";	print_r($Row);echo "</pre>";exit;			
	$CityName=$Row[1];
	$StateName=$Row[2];	
   	if(!empty($CityName) && !empty($StateName)){				
		unset($arryRegion);	
		/************************/  
		$arryRegion["country_id"]=$_POST['country_id']; //set	
				
		$arryState = $objRegion->GetStateID($StateName, $_POST['country_id']); 
		
		if(empty($arryState[0]['state_id'])){
			$arryRegion["name"]=$StateName; //set	
			$state_id = $objRegion->addState($arryRegion); 
			$Count++;
		}else{
			$state_id = $arryState[0]['state_id'];
		}
		/***********/		
		$arryCity = $objRegion->GetCityIDSt($CityName, $state_id, $_POST['country_id']); 
		if(empty($arryCity[0]['city_id'])){
			$arryRegion["name"]=$CityName; //set	
			$arryRegion["main_state_id"]=$state_id; //set
			$objRegion->addCity($arryRegion); 
			$Count++;
		}
		
		/************************/
		
		
	  }
	
		$CurrentMem = memory_get_usage();
      }////end of for loop


		if($Uploaded == 1)unlink($FileDestination);
		
		
		if($Count>0){
			$_SESSION['mess_city']=EXCEL_DATA_IMPORTED;
			$RedirectURL = "importCityState.php?country=".$_POST['country_id'];
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
	if($_GET['country']>0){
		$CountrySelected = $_GET['country'] ; 
	}else{
		//$CountrySelected = 1;
	}

	$arryCountry = $objRegion->getCountry('','');

	 require_once("includes/footer.php"); 
	 
 ?>
