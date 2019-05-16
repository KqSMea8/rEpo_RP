<?php
	/**************************************************/
	$module = $_GET['module']; $EditPage = 1;
	$ThisPageName = 'viewManageBin.php'; 	
	/**************************************************/
	require_once("../includes/header.php");
	require_once($Prefix . "classes/warehouse.class.php");
	require_once($Prefix."classes/function.class.php");
	require_once('../php-excel-reader/excel_reader2.php');
	require_once('../php-excel-reader/SpreadsheetReader.php');
	require_once('../php-excel-reader/SpreadsheetReader_XLSX.php');


	$objWarehouse = new warehouse();
	$objFunction=new functions();
       	$RedirectURL = $ThisPageName;

	$_POST['FileDestination'] = 'binlocation.xls';
	$_SESSION['ExcelFile'] = $_POST['FileDestination'];
	if($_POST){
		/*******************************/
		/*******************************/
		if($_POST['FileDestination'] != ''){

			/********Connecting to main database*********
			$Config['DbName'] = $Config['DbMain'];
			$objConfig->dbName = $Config['DbName'];
			$objConfig->connect();
			/*******************************************/

			$MainDir = "upload/";			
			if(!empty($_SESSION['ExcelFile']) && file_exists($MainDir.$_SESSION['ExcelFile'])){
			

			$Filepath = $MainDir.$_SESSION['ExcelFile'];
		
			$Spreadsheet = new SpreadsheetReader($Filepath);
			
			$Sheets = $Spreadsheet -> Sheets();
			$Count = 0;
			foreach ($Sheets as $Index => $Name){
				$Time = microtime(true);
				$Spreadsheet -> ChangeSheet($Index);
				$arrayLead=array();
				foreach ($Spreadsheet as $Key => $Row){
					
					//echo "<pre>";	print_r($Row);echo "</pre>";exit;
					if($Count>0 && $Row[1]!='null'){ 
						$arrayLead[$Count]["PARTNumber"]=trim($Row[0]); 
						$arrayLead[$Count]["binlocation"]=trim($Row[1]); 
						$arrayLead[$Count]["warehouse_id"]='1'; 
						$arrayLead[$Count]["Status"]='1';
						$arrayLead[$Count]["warehouse_name"]='1';
						 if(!$objWarehouse->isBinExists($arrayLead[$Count]["binlocation"],'',$arrayLead[$Count]["warehouse_name"])){
							$objWarehouse->AddBinLocation($arrayLead[$Count]);
						 }	
 					}


					$Count++;
				}
					
			}
			
 			echo 'done';exit;
			//echo "<pre>";print_r($arrayLead);echo "</pre>";exit;
			 
			 
				
			}
			exit;

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
