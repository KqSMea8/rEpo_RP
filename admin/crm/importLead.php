<?php	
	/**************************************************/
	$module = "Lead"; $EditPage = 1;
	$ThisPageName = 'viewLead.php?module=lead'; 		
	/**************************************************/
	require_once("../includes/header.php");
	require_once($Prefix."classes/lead.class.php");
	require_once($Prefix."classes/territory.class.php");
	require_once($Prefix."classes/employee.class.php");
	require_once($Prefix."classes/function.class.php");
	require_once('../php-excel-reader/excel_reader2.php');
	require_once('../php-excel-reader/SpreadsheetReader.php');
	require_once('../php-excel-reader/SpreadsheetReader_XLSX.php');
	
	 //By chetan 3Dec//
        require_once($Prefix."classes/field.class.php");
        $objField = new field();
        $Leadfields = $objField->getAllCustomFieldByModuleID('102');
        $fieldsName = array_filter(array_map(function($arr){ return $arr['fieldname']; },$Leadfields));
        $fieldsLabel = array_filter(array_map(function($arr){return $arr['fieldlabel'];},$Leadfields));
        $fieldsArray = array_combine($fieldsName,$fieldsLabel);
        $fieldsArray = array_merge($fieldsArray,array("OtherCity" => "City","OtherState" => "State"));
        //End//

	$objLead=new lead();
	$objTerritory=new territory();
	$objEmployee=new employee();
	$objFunction=new functions();
    $RedirectURL = $ThisPageName;
	
	$AssignTo = "";
	if($_SESSION['AdminType'] == "employee") {	
		$AssignTo = $_SESSION['AdminID'];
	}


	$Config['Online']=0;  //To stop email  

	/*$DbColumnArray = array(
		"FirstName" => "First Name",
		"LastName" => "Last Name",
		"company" => "Company Name",
		"primary_email" => "Primary Email",
		"LandlineNumber" => "Landline Number",
		"designation" => "Title",		
		//"type" => "Lead Type",
		"LeadDate" => "Lead Date [YYYY-MM-DD]",
		"ProductID" => "Product",
		"product_price" => "Product Price",
		"Website" => "Website",
		"Address" => "Address",
		"ZipCode" => "Zip Code",
		"OtherCity" => "City",	
		"OtherState" => "State",
		"Country" => "Country",
		"Mobile" => "Mobile",		
		"Industry" => "Industry",
		"AnnualRevenue" => "Annual Revenue",
		"NumEmployee" => "Number of Employee",
		"lead_source" => "Lead Source",
		"lead_status" => "Lead Status",
		"description" => "Description",
		"lead_source" => "Lead Source"

	);*/

	$DbColumnArray =  $fieldsArray;          //By chetan 3Dec//
	$DbColumn = sizeof($DbColumnArray);

	$DbUniqueArray = array(
		"FirstName,LastName,company" => "First Name, Last Name & Company Name",
		"FirstName,LastName" => "First Name & Last Name",		
		"company" => "Company Name",
		"primary_email" => "Primary Email",
		"LandlineNumber" => "Landline Number"
	);

	
// added by sanjiv
	$folderList = $objConfig->getFolderList('',$_SESSION['AdminID'],$_SESSION['CmpID'],$_SESSION['ModuleParentID']);


	if($_POST){

		if(isset($_POST['saveTemplateSubmit'])){
			$ArryLeadImport=$objLead->updateLeadImport($_POST);	
		}
	// added by sanjiv
		if(isset($_POST['Complete'])){
			$objLead->MoveRecordToMasterTable();	
			$objLead->SendMailForImport($_POST);	
			$ErrorMsg = 'Leads '.MODULE_ADDED;
			unset($_SESSION['TotalImport']);
			unset($_SESSION['EXCEL_TOTAL']);
			unset($_SESSION['process']);
			unset($_SESSION['pid']); 
		}
		// added by sanjiv
		if(isset($_POST['Cancel'])){
			posix_kill($_SESSION['pid'], 9); 
			$objLead->DropTempTableForImport();	
			unset($_SESSION['TotalImport']);
			unset($_SESSION['EXCEL_TOTAL']);
			unset($_SESSION['process']);
			unset($_SESSION['pid']); 
			$ErrorMsg = 'Process has been aborded successfully.';
		}

		/*******************************/
		/*******************************/
		if(isset($_POST['FileDestination']) && $_POST['FileDestination'] != ''){

	
			/*------------------- Added By sanjiv -------------------*/
			$post_data = array();
			$post_data[] = urlencode('CmpID') . '=' . urlencode($_SESSION['CmpID']);
			$post_data[] = urlencode('AdminID') . '=' . urlencode($_SESSION['AdminID']);
			$post_data[] = urlencode('AdminType') . '=' . urlencode($_SESSION['AdminType']);
			$post_data[] = urlencode('ExcelFile') . '=' . urlencode($_SESSION['ExcelFile']);
			$post_data[] = urlencode('DuplicayColumn') . '=' . urlencode($_SESSION['DuplicayColumn']);
			$post_data[] = urlencode('TotalImport') . '=' . urlencode($_SESSION['TotalImport']);
			$post_data[] = urlencode('LocationCountry') . '=' . urlencode($arryCurrentLocation[0]['Country']);
			foreach ($_POST as $k => $v)
			   {
				   $post_data[] = urlencode($k) . '=' . urlencode($v);
			   }
			$post_data = implode('&', $post_data);
//echo 'php /var/www/html/erp/cron/ImportLead.php "'.$post_data.'" > /dev/null & echo $!;';die;
			$pid = exec('php /var/www/html/erp/cron/ImportLead.php "'.$post_data.'" > /dev/null & echo $!;', $output, $return); 
			
			//var_dump($pid);
			//print_r($output);
			if (!$return) {
				$ErrorMsg = "Process is running";
				$_SESSION['pid'] = $pid;
			} else {
				$ErrorMsg = "Failed! Please try again.";
				unset($_SESSION['pid']);
			}
			//exit;
			/*------------------------------------------------------*/
			
			


}else if($_FILES['excel_file']['name'] != ''){
			
			$objLead->DropTempTableForImport();
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
				$arrayLead=array();
				foreach ($Spreadsheet as $Key => $Row){
	
				if(!empty($Row[0]) || !empty($Row[1]) || !empty($Row[2])){	
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
			if($fileExt=='csv')	
				$_SESSION['EXCEL_TOTAL'] = count(file($MainDir.$_SESSION['ExcelFile'])); 
			else
			 	$_SESSION['EXCEL_TOTAL']=count($Spreadsheet);
			
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


$ArryLeadImport=$objLead->GetLeadImport();



$_GET['Status']=1;$_GET['Division']='5,7';
$arryEmployee = $objEmployee->GetEmployeeList($_GET);


//echo 'Excel file: '.$_SESSION['ExcelFile'];



$DownloadFile = 'upload/Excel/LeadTemplate.xls';
$NumMandatory = 2;


include("../includes/html/box/import_lead_form.php");
include_once("../includes/footer.php"); 
?>
