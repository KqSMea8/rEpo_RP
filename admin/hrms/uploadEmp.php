<?php
	/**************************************************/
	$ThisPageName = 'viewEmployee.php'; $EditPage = 1;
	/**************************************************/
	require_once("../includes/header.php");
	require_once($Prefix."classes/employee.class.php");
	require_once($Prefix."classes/user.class.php");
	require_once($Prefix."classes/function.class.php");
	require_once($Prefix."classes/hrms.class.php");

	$objFunction=new functions();
	$objEmployee=new employee();
	$objUser=new user();
	$objCommon=new common();

	$RedirectUrl ="viewEmployee.php";



	if($_POST){
	
			/************************************/
			if($_FILES['excel_file']['name'] != ''){
				$FileArray = $objFunction->CheckUploadedFile($_FILES['excel_file'],"Excel");

				if(empty($FileArray['ErrorMsg'])){
					$fileExt = $FileArray['Extension']; 
					$fileName = rand(1,100).".".$fileExt;	
                                        $MainDir = "upload/employee/".$_SESSION['CmpID']."/";						
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

			
			/************************************/

			if($fileName!="" && file_exists($FileDestination)){			
				/********* START EXCEL FILE ************/
				if($fileExt=='xls'){
					require_once '../../classes/reader.php';
					$data = new Spreadsheet_Excel_Reader();
					// Set output Encoding.
					$data->setOutputEncoding('CP1251');
					$data->read($FileDestination);


					$SheetNo = ($_POST['SheetNo']!='')?($_POST['SheetNo']-1):("0");
					$RowNo = ($_POST['RowNo']!='')?($_POST['RowNo']):("2");


					//$StartCol = 1; $EndCol = 2; 
					//echo '<pre>';print_r($data->sheets[0]['cells'][12]); exit;
					
$cnt = 0; 
					for ($i = $RowNo; $i <= $data->sheets[$SheetNo]['numRows']; $i++) {
						
						for ($j = 1; $j <= $data->sheets[$SheetNo]['numCols']; $j++) {							
							
							
							/*********************/
							if(!empty($data->sheets[0]['cells'][$i][$j])){
			        $val=mysql_real_escape_string(strip_tags(trim($data->sheets[0]['cells'][$i][$j])));
		//echo $val.$i.$j; exit;
		if($j==2)$arryEmpData[$cnt]["EmpCode"] = $val;
		if($j==3)$arryEmpData[$cnt]["FirstName"] = $val;
		if($j==4)$arryEmpData[$cnt]["LastName"] = $val;
		if($j==5)$arryEmpData[$cnt]["Father"] = $val;   
		if($j==6)$arryEmpData[$cnt]["MotherFirstName"] = $val;
		if($j==7)$arryEmpData[$cnt]["MotherLastName"] = $val;
		if($j==8)$arryEmpData[$cnt]["UnitBranch"] = $val; //No Use
		if($j==9)$arryEmpData[$cnt]["DepartmentName"] = $val;
		if($j==10)$arryEmpData[$cnt]["JobTitle"] = $val;
		if($j==11)$arryEmpData[$cnt]["Grade"] = $val; //No Use
		if($j==12)$arryEmpData[$cnt]["DateOfJoining"] = $val;
		if($j==13)$arryEmpData[$cnt]["DateOfBirth"] = $val;	
		if($j==14)$arryEmpData[$cnt]["RetirementDate"] = $val;	//No Use
		if($j==15)$arryEmpData[$cnt]["DateOfLeaving"] = $val;
		if($j==16)$arryEmpData[$cnt]["Gender"] = $val;
		if($j==17)$arryEmpData[$cnt]["Shift"] = $val; //No Use

		if($j==18)$arryEmpData[$cnt]["WeekelyOff"] = $val; //No Use	
		if($j==19)$arryEmpData[$cnt]["CardNo"] = $val;	 //No Use
		if($j==20)$arryEmpData[$cnt]["OvertimeAllowed"] = $val;	 //No Use
		if($j==21)$arryEmpData[$cnt]["BonusFormat"] = $val; //No Use	
		if($j==22)$arryEmpData[$cnt]["BonusPer"] = $val; //No Use		
		if($j==23)$arryEmpData[$cnt]["PaymentMode"] = $val; //No Use		
		if($j==24)$arryEmpData[$cnt]["PF_NO"] = $val; //No Use	
		if($j==25)$arryEmpData[$cnt]["PF_Status"] = $val; //No Use				
							
		if($j==26)$arryEmpData[$cnt]["ESI_NO"] = $val;	 //No Use
		if($j==27)$arryEmpData[$cnt]["ESI_Status"] = $val; //No Use
		if($j==28)$arryEmpData[$cnt]["Dispensary"] = $val; //No Use
		if($j==29)$arryEmpData[$cnt]["TDS_No"] = $val; //No Use
		if($j==30)$arryEmpData[$cnt]["PensionStatus"] = $val; //No Use

		if($j==31)$arryEmpData[$cnt]["AccountNumber"] = $val; //No Use, payroll salary
		if($j==32)$arryEmpData[$cnt]["BankName"] = $val; //No Use, payroll salary
		if($j==33)$arryEmpData[$cnt]["IFSCCode"] = $val; //No Use, payroll salary
		if($j==34)$arryEmpData[$cnt]["BankBranch"] = $val; //No Use, payroll salary

		if($j==35)$arryEmpData[$cnt]["MaritalStatus"] = $val;
		if($j==36)$arryEmpData[$cnt]["BloodGroup"] = $val;
		if($j==37)$arryEmpData[$cnt]["Address"] = $val;
		if($j==38)$arryEmpData[$cnt]["Address1"] = $val; //No Use

		if($j==39)$arryEmpData[$cnt]["PostalAddress"] = $val; //No Use
		if($j==40)$arryEmpData[$cnt]["PostalAddress1"] = $val; //No Use
		if($j==41)$arryEmpData[$cnt]["BirthPlace"] = $val; //No Use
		if($j==42)$arryEmpData[$cnt]["LandlineNumber"] = $val;
		if($j==43)$arryEmpData[$cnt]["Mobile"] = $val;
		if($j==44)$arryEmpData[$cnt]["Email"] = $val;
		if($j==45)$arryEmpData[$cnt]["SS_NO"] = $val;  //No Use
		if($j==46)$arryEmpData[$cnt]["Nationality"] = $val;
		if($j==47)$arryEmpData[$cnt]["Religion"] = $val;  //No Use
		if($j==48)$arryEmpData[$cnt]["SocialStatus"] = $val; //No Use
		//if($j==49)$arryEmpData[$cnt]["Gross"] = $val;  //No Use of Payroll data
							
}
						
							

		/*********************/							
                         } //end for j	
						
					$cnt++;	
						

					}//end for i

					
					unlink($FileDestination);
					if(sizeof($arryEmpData)>0){
						//echo '<pre>'; print_r($arryEmpData); exit;
						$NumUploaded = $objEmployee->UploadEmpData($arryEmpData);					

						if($NumUploaded>0){
							$_SESSION['mess_employee'] = EMP_UPLOADED;
						
							header("location: ".$RedirectUrl);
							exit;
						}else{
							$ErrorMsg = EMP_NOT_UPLOADED;
						}

					}else{
						$ErrorMsg = NO_DATA_IN_SHEET;
					}
				

				}else{
					$ErrorMsg = INVALID_EXCEL_FILE; 
				}				
	
		}
		
		
	}
	

	require_once("../includes/footer.php"); 
?>
