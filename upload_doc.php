<? 
	require_once("includes/header.php"); 
	ValidateMemberSession($ThisPage);

	if($_POST){
			if($_FILES['csv_file']['name'] != ''){
				$fileExt = strtolower(GetExtension($_FILES['csv_file']['name']));
				$fileName = rand(1,100).".".$fileExt;	
				$FileDestination = "upload/Excel/temp/".$fileName;
				if(@move_uploaded_file($_FILES['csv_file']['tmp_name'], $FileDestination)){
					$Uploaded = 1;
				}
			}
	
			if(!empty($_POST["ProjectName"]) && $Uploaded == 1){
				$_POST['MemberID'] = $_SESSION['MemberID'];
				$_POST['Status'] = '1';
				$projectID = $objProject->addProject($_POST); 
				$MainDir = "project/";
				/*$MainDir = "upload/project/".$projectID."/";
				if (!is_dir($MainDir)) {
					mkdir($MainDir);
					chmod($MainDir,0777);
				}*/
			}

			if($fileName!="" && file_exists($FileDestination)){			
				/********* START EXCEL FILE ************/
				if($fileExt=='xls'){
					require_once 'classes/reader.php';
					$data = new Spreadsheet_Excel_Reader();
					// Set output Encoding.
					$data->setOutputEncoding('CP1251');
					$data->read($FileDestination);



					$cnt = 0; $SheetNo=0;
					for ($i = 2; $i <= $data->sheets[$SheetNo]['numRows']; $i++) {
						for ($j = 1; $j <= $data->sheets[$SheetNo]['numCols']; $j++) {
							$val = $data->sheets[0]['cells'][$i][$j];
							/*********************/
							if($j==6 && !empty($val)){
								$arryImages[$cnt]["SKU"] = $data->sheets[0]['cells'][$i][$j-5];
								//$arryImageUrl[] = $val;
								$Ext = strtolower(GetExtension($val));
								$ImageName = $projectID."_".rand(1,999).".".$Ext;
								$arryImages[$cnt]["Image"] = $ImageName;

								$sql = "insert into project_image (projectID, Image, Sku) values('".$projectID."','".addslashes($ImageName)."','".addslashes($arryImages[$cnt]["SKU"])."')";
								$objProject->query($sql,0);
								
								$ImgContent='';
								$ImgContent = file_get_contents($val);
								
								file_put_contents($MainDir.$ImageName, $ImgContent);
								#copy($val, $MainDir.$ImageName);
								$cnt++;
							
								

							}
							/*********************/							
                         } //end for j
							
							//if($cnt==2) break;

					}//end for i
					#echo '<pre>'; print_r($arryImages); exit;
					unlink($FileDestination);

					header("location: project_detail.php?p=".$projectID);
					exit;

					
				}else{
					echo "Invalid excel file."; exit;
				}				
	
		}
		

			

		
	}


	require_once("includes/html/upload_doc.php");
	require_once("includes/footer.php");
?>




