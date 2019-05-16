
<?php

/* * *********************************************** */
$ThisPageName = 'generateInvoice.php';
/* * *********************************************** */
$HideNavigation = 1;


	/**************************Ganesh 4 jan 2016************************/

	/**************************************************/
#ini_set('max_input_vars', 3000);
	include_once("../includes/header.php");
	require_once($Prefix."classes/item.class.php");
	require_once($Prefix."classes/function.class.php");
	require_once($Prefix.'admin/php-excel-reader/excel_reader2.php');
	require_once($Prefix.'admin/php-excel-reader/SpreadsheetReader.php');
	require_once($Prefix.'admin/php-excel-reader/SpreadsheetReader_XLSX.php');

	$ModuleName = "Stock Transfer";
	$objItem=new items();
	$objFunction=new functions();
       	$RedirectURL = "editSerial.php";
        
	if(!isset($_GET['serial_value_sel'])) $_GET['serial_value_sel']='';
        
   
    
    if(isset($_POST['submit'])){
         echo ' <script language="JavaScript1.2" type="text/javascript">';
         echo '$(document).ready(function() {';
         echo 'window.parent.document.getElementById("serial_value'.$_POST['lineNumber'].'").value = '.$arrs.';';
         //echo 	'window.parent.document.getElementById("serialdesc" + lineNumber).value = allserdesc;';
         echo 'parent.$.fancybox.close();';
         echo '});';
         echo '</script>';


    }
            

    if($_POST['Submit'] == 'Upload'){
            if(!empty($_FILES['excel_file']['name'])){		
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
                      if(@move_uploaded_file($_FILES['excel_file']['tmp_name'], $FileDestination)){
                          $Uploaded = 1;
                          chmod($FileDestination,0777);
                      }else{
                      
                      }  
                   }else{
                      $ErrorMsg = $FileArray['ErrorMsg'];
                   }
            }


            if(!empty($fileName) && file_exists($FileDestination)){	


                 
                 if($fileExt=='xls'){	
                 $Filepath =getcwd()."/".$FileDestination;
                 //echo $Filepath;                    
                 }else if($fileExt=='xlsx'){

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
                                 if(!empty($Row)){	
                                       $arrayHeader[]=$Row;
                                 }
                                 if($Count==1) break;
                            }
                            /**********************************/		
                            $NumHeader=sizeof($arrayHeader);	
                            /**********************************/
                                if($NumHeader>0){
                                }else{
                                $ErrorMsg=SHEET_NOT_UPLOADED;
                                }
                        }


                        if(!empty($arrayHeader)){
                            $arrySerial=array();
                            for($i=0;sizeof($arrayHeader)>$i;$i++){
                                $j = $i-1;
                                $arrySerial[$i]['serialNo'] = $arrayHeader[$i][0];
                                $arrySerial[$i]['price']=$arrayHeader[$i][1];
                                $arrySerial[$i]['description']=$arrayHeader[$i][2];
                            }
                        }


                        $importQty = count($arrySerial);
                        $LastID = $objItem->GetMaxLastId();
                        
                        if($_POST['AdjustID']!=''){
                           $objItem->DelSerialNum($_POST['AdjustID']);
                        }else{
                           $_POST['AdjustID'] = $LastID[0]['MaxAutoID'];
                        }
                        
                        if($_POST['totalQtySerial'] == $importQty ){
                            foreach($arrySerial as $value){
                            $TotalUsnitCost += $value['price'];
                            }
                            $UnitPrice =  $TotalUsnitCost/$importQty;
                        //$addSerial= $objItem->AddSerialNumberByImport($_POST,$arrySerial);
                        }else{

                            $_SESSION['mess_Serial'] = "Total Serial Number qty are not same as adjust qty.";
                        }


                 }

    }else{  unlink($FileDestination); }
            }


        
        //End//
  	require_once("../includes/footer.php");
?>




