<?php
	/**************************************************/
	$ThisPageName = 'viewAttendence.php'; $EditPage = 1;
	/**************************************************/
	require_once("../includes/header.php");
	require_once($Prefix."classes/time.class.php");
	$objTime=new time();

	$RedirectUrl ="uploadAttendence.php";

	if($_POST){
			if($_FILES['excel_file']['name'] != ''){
				$fileExt = strtolower(GetExtension($_FILES['excel_file']['name']));
				$fileName = rand(1,100).".".$fileExt;	
				$FileDestination = "upload/attendance/".$fileName;
				if(@move_uploaded_file($_FILES['excel_file']['tmp_name'], $FileDestination)){
					$Uploaded = 1;
				}
			}
			
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


					$StartCol = 3; $EndCol = 65; 

					$cnt = 0; 
					for ($i = $RowNo; $i <= $data->sheets[$SheetNo]['numRows']; $i++) {
						//unset($EmpCode);
						for ($j = 1; $j <= $data->sheets[$SheetNo]['numCols']; $j++) {							
							
							
							/*********************/
							if($j==1){
								$EmpCode = $data->sheets[0]['cells'][$i][$j];
								$arryAtt[$EmpCode]["EmpCode"] = $EmpCode;
							}
						
							if($j>=$StartCol && $j<=$EndCol && !empty($EmpCode)){
								if(!empty($data->sheets[0]['cells'][$i][$j])){
									$Day = $data->sheets[0]['cells'][1][$j]; 
									$dayArry = explode("(",$Day);
									$d = trim($dayArry[0]);
									$arryAtt[$EmpCode]["InTime"][$d] = $data->sheets[0]['cells'][$i][$j];
									$arryAtt[$EmpCode]["OutTime"][$d] = $data->sheets[0]['cells'][$i][$j+1];
									$j++; 
								}
								 
							}

							/*********************/							
                         } //end for j	
						
						//echo '<pre>'; print_r($arryAtt); exit;

					}//end for i

					
					unlink($FileDestination);
					if(sizeof($arryAtt)>0){
						//echo '<pre>'; print_r($arryAtt); exit;
						$NumUploaded = $objTime->UploadAttendance($arryAtt,$_POST['Year'],$_POST['Month']);
						if($NumUploaded>0){
							$_SESSION['mess_att'] = ATT_UPLOADED;
							$RedirectUrl ="viewAttendence.php?y=".$_POST['Year']."&m=".$_POST['Month'];
							header("location: ".$RedirectUrl);
							exit;
						}else{
							$ErrorMsg = ATT_NOT_UPLOADED;
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
