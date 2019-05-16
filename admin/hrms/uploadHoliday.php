<?php
	/**************************************************/
	$ThisPageName = 'viewHoliday.php'; $EditPage = 1;
	/**************************************************/
	require_once("../includes/header.php");
	require_once($Prefix."classes/leave.class.php");	
	require_once($Prefix."classes/function.class.php");

	$objFunction=new functions();
	$objLeave=new leave();

	$RedirectUrl ="viewHoliday.php";



	if($_POST){
	
			/************************************/
			if($_FILES['excel_file']['name'] != ''){
				$FileArray = $objFunction->CheckUploadedFile($_FILES['excel_file'],"Excel");

				if(empty($FileArray['ErrorMsg'])){
					$fileExt = $FileArray['Extension']; 
					$fileName = rand(1,100).".".$fileExt;	
                                        $MainDir = "upload/holiday/".$_SESSION['CmpID']."/";						
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


					$StartCol = 1; $EndCol = 2; 

					$cnt = 0; 
					for ($i = $RowNo; $i <= $data->sheets[$SheetNo]['numRows']; $i++) {
						
						for ($j = 1; $j <= $data->sheets[$SheetNo]['numCols']; $j++) {							
							
							
							/*********************/
							if(!empty($data->sheets[0]['cells'][$i][$j])){
							$val=$data->sheets[0]['cells'][$i][$j];

							if($j==1){								
								$arryHoliday[$cnt]["heading"] = $val;
							}
							if($j==2){								
								$arryHoliday[$cnt]["holidayDate"] = $val;
							}
							
}
						
							

							/*********************/							
                         } //end for j	
						
					$cnt++;	
						

					}//end for i

					
					unlink($FileDestination);
					if(sizeof($arryHoliday)>0){
						//echo '<pre>'; print_r($arryHoliday); exit;
						$NumUploaded = $objLeave->UploadHoliday($arryHoliday);
						if($NumUploaded>0){
							$_SESSION['mess_holiday'] = HOLIDAY_UPLOADED;
						
							header("location: ".$RedirectUrl);
							exit;
						}else{
							$ErrorMsg = HOLIDAY_NOT_UPLOADED;
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
