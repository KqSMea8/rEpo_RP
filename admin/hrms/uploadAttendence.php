<?php
	/**************************************************/
	$ThisPageName = 'viewAttendence.php'; $EditPage = 1;
	/**************************************************/
	require_once("../includes/header.php");
	require_once($Prefix."classes/time.class.php");
	require_once($Prefix."classes/function.class.php");
	require_once($Prefix."classes/hrms.class.php");
	$objCommon=new common();
	$objFunction=new functions();
	$objTime=new time();

	$RedirectUrl ="uploadAttendence.php";

	/***************************/
	foreach($arryCurrentLocation[0] as $key=>$values){
		$Config[$key] = $values;
	}
	if(empty($Config['LableLeave'])) $Config['LableLeave']='L';
	if(empty($Config['OvertimeRate'])) $Config['OvertimeRate']=1;
	
	if(!empty($Config['WorkingHourStart']) && !empty($Config['WorkingHourEnd'])){
		$Config['WorkingHour'] = $objTime->GetTimeDifference($Config['WorkingHourStart'],$Config['WorkingHourEnd'],1);
	}
	/***************************/




	if($_POST){
	
			/************************************/
			if($_FILES['excel_file']['name'] != ''){
				$FileArray = $objFunction->CheckUploadedFile($_FILES['excel_file'],"Excel");

				if(empty($FileArray['ErrorMsg'])){
					$fileExt = $FileArray['Extension']; 
					$fileName = rand(1,100).".".$fileExt;	
                                        $MainDir = "upload/attendance/".$_SESSION['CmpID']."/";						
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


					$StartCol = 3; $EndCol = 65; 

					$cnt = 0; 
					for ($i = $RowNo; $i <= $data->sheets[$SheetNo]['numRows']; $i++) {
						//unset($EmpCode);
						for ($j = 1; $j <= $data->sheets[$SheetNo]['numCols']; $j++) {							
							
							
							/*********************/
							if($j==1){
								$EmpCode = trim($data->sheets[0]['cells'][$i][$j]);
								$arryAtt[$EmpCode]["EmpCode"] = $EmpCode;
							}
						
							if($j>=$StartCol && $j<=$EndCol && !empty($EmpCode)){
								if(!empty($data->sheets[0]['cells'][$i][$j])){
									$Day = $data->sheets[0]['cells'][1][$j]; 
									$dayArry = explode("(",$Day);
									$d = trim($dayArry[0]);

									$InTime = ''; $OutTime = ''; unset($InTimeArry); unset($OutTimeArry);


									$InTime = trim($data->sheets[0]['cells'][$i][$j]);
									$OutTime = trim($data->sheets[0]['cells'][$i][$j+1]);
									
									/********************/									
									$InTimeArry = explode("(",$InTime);
									$InTime = str_replace(" ","",$InTimeArry[0]); $InComment = str_replace(")","",$InTimeArry[1]);
									if((int)$InTime == ''){ $InTime=''; $InComment = $InTimeArry[0]; }

									$InTime = strtolower($InTime);
									if(!empty($InTime)){
										if(strpos($InTime,'am') != false) {
											$InTime = str_replace("am","",$InTime);
											$InTime = date("H:i",strtotime($InTime));
										}else if(strpos($InTime,'pm') != false) {
											$InTime = str_replace("pm","",$InTime);
											if((int)$InTime != 12 ){ 
												$TwelveHour = 3600*12; 
											}else{
												$TwelveHour = 0;
											}
											$InTime = date("H:i",strtotime($InTime)+($TwelveHour)); 
										}else{
											$InTime = date("H:i",strtotime($InTime));
										}
									}
									

									/********************/									
									$OutTimeArry = explode("(",$OutTime);
									$OutTime = str_replace(" ","",$OutTimeArry[0]); $OutComment = str_replace(")","",$OutTimeArry[1]);									
									if((int)$OutTime == ''){ $OutTime=''; $OutComment = $OutTimeArry[0]; }

									$OutTime = strtolower($OutTime);
									
									if(!empty($OutTime)){
										if(strpos($OutTime,'am') != false) {
											$OutTime = str_replace("am","",$OutTime);
											$OutTime = date("H:i",strtotime($OutTime));
										}else if(strpos($OutTime,'pm') != false) {
											$OutTime = str_replace("pm","",$OutTime);
											if((int)$OutTime != 12 ){ 
												$TwelveHour = 3600*12; 
											}else{
												$TwelveHour = 0;
											}	
											$OutTime = date("H:i",strtotime($OutTime)+($TwelveHour)); 
										}else{
											$OutTime = date("H:i",strtotime($OutTime));
										}
									}
									



									$arryAtt[$EmpCode]["InTime"][$d] = $InTime;
									$arryAtt[$EmpCode]["InComment"][$d] = $InComment;
									$arryAtt[$EmpCode]["OutTime"][$d] = $OutTime;
									$arryAtt[$EmpCode]["OutComment"][$d] = $OutComment;
									$j++; 
								}
								 
							}

							/*********************/							
                         } //end for j	
						
						if(!empty($arryAtt['13SAK171']['EmpCode'])){
							//echo '<pre>'; print_r($arryAtt['13SAK171']); exit;
						}
						

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
	

	$arryShift=$objCommon->getShift('','1');
	$numShift=sizeof($arryShift);

	$arryGlobal = $objConfigure->GetLocation($_SESSION['locationID'],'');
	require_once("../includes/footer.php"); 
?>
