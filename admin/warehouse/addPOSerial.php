<?php

/* * *********************************************** */
$ThisPageName = 'recieveOrder.php';
/* * *********************************************** */
$HideNavigation = 1;


/**************************************************/
#ini_set('max_input_vars', 3000);
	include_once("../includes/header.php");
	require_once($Prefix."classes/item.class.php");
	require_once($Prefix."classes/function.class.php");
	require_once($Prefix.'admin/php-excel-reader/excel_reader2.php');
require_once($Prefix.'admin/php-excel-reader/SpreadsheetReader_XLSX.php');
	require_once($Prefix.'admin/php-excel-reader/SpreadsheetReader.php');
	

	$ModuleName = "Receipt";
	$objItem=new items();
	$objFunction=new functions();
       	$RedirectURL = "addPoSerial.php";
        
        
   
//     
     if(isset($_POST['submit'])){


echo ' <script language="JavaScript1.2" type="text/javascript">';
echo '$(document).ready(function() {';
echo 'window.parent.document.getElementById("serial_value'.$_POST['lineNumber'].'").value = '.$arrs.';';
		//echo 	'window.parent.document.getElementById("serialdesc" + lineNumber).value = allserdesc;';
			echo 'parent.$.fancybox.close();';
echo '});';
echo '</script>';


//         
//         
//          
//          
//        $addSerial= $objItem->AddSerialNumber($_POST,$_GET['sku']);
//     //print_r($addSerial);die;
      }
//             
            
            if($_POST['submit'] = 'upload'){
               
       
		if($_FILES['excel_file']['name'] != ''){		

	               $FileArray = $objFunction->CheckUploadedFile($_FILES['excel_file'],"Excel");
                    
                      
                       if(empty($FileArray['ErrorMsg'])){
                           
				$fileExt = $FileArray['Extension']; 
				$fileName = rand(1,100).".".$fileExt;	
                              
		                $MainDir = "../inventory/upload/Excel/".$_SESSION['CmpID']."/";
                            
                                
				 if (!is_dir($MainDir)) {
					mkdir($MainDir);
					chmod($MainDir,0777);
				 }
		          $FileDestination = $MainDir.$fileName; 
                                   

			if(@move_uploaded_file($_FILES['excel_file']['tmp_name'], $FileDestination)){
					$Uploaded = 1;
					chmod($FileDestination,0777);
                                      
                                      
			} else{


}  
		       }else{
			     $ErrorMsg = $FileArray['ErrorMsg'];
                             
			}
		 }
                  
                            
			if($fileName!="" && file_exists($FileDestination)){	
                        
                             
 #echo $fileExt; exit;
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
                               //print_r($Name);die;
                                
                                    $Time = microtime(true);
                                    $Spreadsheet -> ChangeSheet($Index);
                                    $arrayHeader=array();
                               
                                   
                                    foreach ($Spreadsheet as $Key => $Row){
                                   
                                    //$Row = trim($Row);
//trim(iconv("UTF-8","ISO-8859-1",$sheet->getCell('B'.$Row )->getValue())," \t\n\r\0\x0B\xA0")
                                    if(!empty($Row)){	
                                           
                                                    $arrayHeader[]=$Row;
                                                  
                                          
                                           	
                                    }
                                       
                                           
                                    if($Count==1) break;
                                    }////end of for loop

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
//foreach ($arrayHeader as $Key => $values){
for($i=0;sizeof($arrayHeader)>$i;$i++){

$j = $i-1;
$arrySerial[$i]['serialNo'] = $arrayHeader[$i][0];
$arrySerial[$i]['price']=$arrayHeader[$i][1];
$arrySerial[$i]['description']=$arrayHeader[$i][2];
}

//$NumLine =sizeof($arrySerial);


}
//$arrs =  serialize($arrayHeader); 

/*echo ' <script language="JavaScript1.2" type="text/javascript">';
echo '$(document).ready(function() {';
echo 'window.parent.document.getElementById("serial_value'.$_POST['lineNumber'].'").value = '.$arrs.';';
		echo 	'window.parent.document.getElementById("serialdesc" + lineNumber).value = allserdesc;';
			echo 'parent.$.fancybox.close();';
echo '});';
echo '</script>';*/
/*echo "<pre>";
print_r($_POST);
echo "</pre>";*/


/*echo "<pre>";
print_r($arrySerial);
exit;*/

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

/*echo '<script language="JavaScript1.2" type="text/javascript">';
echo '$(document).ready(function() {';
echo 'window.parent.document.getElementById("AdjustID").value = '.$_POST['AdjustID'].';';
		echo 	'window.parent.document.getElementById("qty'.$_POST['lineNumber'].'").value = '.$importQty.';';
		echo 	'window.parent.document.getElementById("price'.$_POST['lineNumber'].'").value = '.$UnitPrice.';';
			echo 'parent.$.fancybox.close();';
echo '});';
echo '</script>';*/



//$arrson =  json_decode($arrs);
//echo '<pre>' ; print_r($arrson);die;
                        }

  }else{  unlink($FileDestination); }
            }


require_once("../includes/footer.php");
?>
