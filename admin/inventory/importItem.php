<?php 
	/**************************************************/
	$ThisPageName = 'viewItem.php';  
	/**************************************************/
	include_once("../includes/header.php");
	require_once($Prefix."classes/item.class.php");
	require_once($Prefix."classes/function.class.php");
	require_once($Prefix.'admin/php-excel-reader/excel_reader2.php');
	require_once($Prefix.'admin/php-excel-reader/SpreadsheetReader.php');
	require_once($Prefix.'admin/php-excel-reader/SpreadsheetReader_XLSX.php');

	$ModuleName = "Item";
	$objItem=new items();
	$objFunction=new functions();
       	$RedirectURL = "viewItem.php";
        
        //By Chetan 16Dec//
        $DbColumnArray = array(
            "Sku" => "Sku",
            "description" => "Item Description",
            "non_inventory" => "Track Inventory",
            "sell_price" => "Price",
            "itemType" => "Item Type",
            "Condition" => "Condition",	
            "Manufacture" => "Manufacture",	
            "Status" => "Status"
            
        );
       $DbColumn = sizeof($DbColumnArray);

        if($_POST)
        {   
		// added by sanjiv
		if(isset($_POST['Complete'])){
			$objItem->MoveRecordToMasterTable();	
			$ErrorMsg = 'Items '.MODULE_ADDED;
			unset($_SESSION['TotalImport']);
			unset($_SESSION['EXCEL_TOTAL']);
			unset($_SESSION['process']);
			unset($_SESSION['pid']); 
		}
		// added by sanjiv
		if(isset($_POST['Cancel'])){
			posix_kill($_SESSION['pid'], 9); 
			$objItem->DropTempTableForImport();	
			unset($_SESSION['TotalImport']);
			unset($_SESSION['EXCEL_TOTAL']);
			unset($_SESSION['process']);
			unset($_SESSION['pid']); 
			$ErrorMsg = 'Process has been aborded successfully.';
		}

		/*******************************/
		/*******************************/
		if($_POST['FileDestination'] != ''){

	
			/*------------------- Added By sanjiv -------------------*/
			$post_data = array();
			$post_data[] = urlencode('CmpID') . '=' . urlencode($_SESSION['CmpID']);
			$post_data[] = urlencode('AdminID') . '=' . urlencode($_SESSION['AdminID']);
			$post_data[] = urlencode('AdminType') . '=' . urlencode($_SESSION['AdminType']);
			$post_data[] = urlencode('ExcelFile') . '=' . urlencode($_SESSION['ExcelFile']);
			$post_data[] = urlencode('TotalImport') . '=' . urlencode($_SESSION['TotalImport']);
			foreach ($_POST as $k => $v)
			   {
				   $post_data[] = urlencode($k) . '=' . urlencode($v);
			   }
			$post_data = implode('&', $post_data);
//echo 'php /var/www/html/erp/cron/ImportItem.php "'.$post_data.'" > /dev/null & echo $!;';die;
			$pid = exec('php /var/www/html/erp/cron/ImportItem.php "'.$post_data.'" > /dev/null & echo $!;', $output, $return); 
			
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

            
           
/* if($_POST['submit'] = 'Save'){
                
                if($_POST['FileDestination'] != '')
                {
                    if(!empty($_POST['FileName']) && file_exists($_POST['FileDestination'])){
                        
                        $Filepath = $_POST['FileDestination'];
			$Spreadsheet = new SpreadsheetReader($Filepath);
			
			$Sheets = $Spreadsheet -> Sheets();
			$Count = 0;
			$ItemAddedCount = 0;
			$ItemCount = 0;
			$arrayItem=array();
			foreach ($Sheets as $Index => $Name){
				$Time = microtime(true);
				$Spreadsheet -> ChangeSheet($Index);
				
				foreach ($Spreadsheet as $Key => $Row){
					//echo "<pre>";	print_r($Row);echo "</pre>";exit;
					unset($arrayLead[$Count]);	
					foreach($DbColumnArray as $Key => $Heading){ 
						$i = $_POST[$Key];
                                              
                                                /*if($Key == 'Status')
                                                {
                                                    $Row[$i] = ($Row[$i] == 'Active')? '1':'';
                                                }*
						$arrayItem[$Count][$Key]=trim($Row[$i]);
					}
                                        $Count++;
				}        
                        }   
                        
                        $arrayItem = array_values(array_filter(array_map('array_filter', $arrayItem)));
                        
                        $NumItem=sizeof($arrayItem);
			$Count = $NumItem;

                        if($NumItem > 0)
                        {   
                            for($i=1;$i<$NumItem;$i++){
                                
                                $Res = $objItem->checkItemSku($arrayItem[$i]['Sku']);
                                if(empty($Res))
                                {	
				    $arrayItem[$i] = array_merge($arrayItem[$i],array('Status'=>'1'));	
                                    $ItemID=$objItem->addItem($arrayItem[$i]);
                                    $ItemAddedCount++;
                                }    
                            }
                            unlink($_POST['FileDestination']);
			}
			
			$mess_lead = "Total Item to import from excel sheet : ".($Count-1);
			$mess_lead .= "<br>Total Item imported into database : ".$ItemAddedCount;
			$mess_lead .= "<br>Item already exist in database : ".($Count-1-$ItemAddedCount);


			if(!empty($ItemID)){								
				$_SESSION['mess_product'] = $mess_lead;				
				header("Location:".$RedirectURL);
				exit;
			}else{
				$ErrorMsg = $mess_lead;			
			}
                        
                        
                                        
                    }
                }
                
            }
*/
            
            
            
                  } else if($_FILES['excel_file']['name'] != ''){		

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

				if(!empty($_SESSION['ExcelFile']) && file_exists($MainDir.$_SESSION['ExcelFile']))			{		
					$Uploaded = 1;
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
				if($fileExt=='xls'){	
					$Filepath =getcwd()."/".$FileDestination;
				}else{ 
					$ErrorMsg = UPLOAD_ERROR_EXT;
				}
		
                        if(empty($ErrorMsg))
                        {
                            $Spreadsheet = new SpreadsheetReader($Filepath);			
                            $Sheets = $Spreadsheet -> Sheets();
                            $Count = 0;
                            foreach ($Sheets as $Index => $Name)
                            {
                                    $Time = microtime(true);
                                    $Spreadsheet -> ChangeSheet($Index);
                                    $arrayHeader=array();
                                    foreach ($Spreadsheet as $Key => $Row){

                                    if(!empty($Row[0])){	
                                            foreach ($Row as $val){
                                                    $arrayHeader[]=$val;
                                            }
                                            $Count++;
                                            break;		
                                    }

                                    if($Count==1) break;
                                    }////end of for loop

                                    /**********************************/		
                                    $NumHeader=sizeof($arrayHeader);		
                                    /**********************************/

                                    if($NumHeader>0){
                                            //Ready for selection
					//Added  by chetan 29Aug2017//		
					if($fileExt=='csv')	
						$_SESSION['EXCEL_TOTAL'] = count(file($MainDir.$_SESSION['ExcelFile'])); 
					else
						$_SESSION['EXCEL_TOTAL'] = count($Spreadsheet);
					//End//	
                                    }else{

                                            $ErrorMsg=SHEET_NOT_UPLOADED;
                                    }

                            }
                        }

    }else{  unset($_SESSION['ExcelFile']);
	    //unlink($FileDestination); 
	}


}else{

	$MainDir = "upload/Excel/".$_SESSION['CmpID']."/";			
	if(!empty($_SESSION['ExcelFile']) && file_exists($MainDir.$_SESSION['ExcelFile'])){
		unlink($MainDir.$_SESSION['ExcelFile']);
	}
	unset($_SESSION['ExcelFile']);

}
        //End//
  	require_once("../includes/footer.php");
?>

