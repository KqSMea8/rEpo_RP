<?php
	require_once($Prefix."classes/sales.customer.class.php");
	require_once($Prefix."classes/function.class.php");
	require_once('../php-excel-reader/excel_reader2.php');
	require_once('../php-excel-reader/SpreadsheetReader.php');
	require_once('../php-excel-reader/SpreadsheetReader_XLSX.php');
        
	//By chetan 22Dec//
        require_once($Prefix."classes/field.class.php");ini_set('display_error',1);
        $objField = new field();
        $Cusfields = $objField->getAllCustomFieldByModuleID('2015');
        $AddField = $objField->getFormField('',16,'1'); 
	$Narry = array_map(function($arr){
            if($arr['fieldname'] == 'Landline' || $arr['fieldname'] == 'Mobile' || $arr['fieldname'] == 'contact')
            {
                unset($arr);
            }else{
                return $arr;
            }
        },$AddField);
        $AddField = array_filter($Narry);

        $Allfields = array_merge($Cusfields,$AddField);
        $fieldsName = array_filter(array_map(function($arr){ return $arr['fieldname']; },$Allfields));
        $fieldsLabel = array_filter(array_map(function($arr){return $arr['fieldlabel'];},$Allfields));
        $fieldsArray = array_combine($fieldsName,$fieldsLabel);
        $fieldsArray = array_merge($fieldsArray,array("OtherCity" => "City","OtherState" => "State"));
        //End//
              
       
        $ModuleName = "Customer";
	$objCustomer=new Customer();
	$objFunction=new functions();
       	$RedirectURL = "viewCustomer.php";
        
        $DbColumnArray =  $fieldsArray;          
        $DbColumn = sizeof($DbColumnArray);
       
        
	if($_POST){
            	$post = array_filter($_POST,function($var){  if(($var != '') && ($var >= 0)){ return true;}  });
		unset($post['Submit']);
		unset($post['FileDestination']);
		unset($post['FileName']);
		unset($post['DbColumn']);
                if($_POST['submit'] = 'Save'){
                
                if($_POST['FileDestination'] != '')
                {

/********Connecting to main database*********/
			$Config['DbName'] = $Config['DbMain'];
			$objConfig->dbName = $Config['DbName'];
			$objConfig->connect();
			/*******************************************/
                    if(!empty($_POST['FileName']) && file_exists($_POST['FileDestination'])){
                        
                        $Filepath = $_POST['FileDestination'];
			$Spreadsheet = new SpreadsheetReader($Filepath);
			
			$Sheets = $Spreadsheet -> Sheets();
			$Count = 0;
			$CusAddedCount = 0;
			$CusCount = 0;
			$arrayCust=array();
			foreach ($Sheets as $Index => $Name){				$Time = microtime(true);
				$Spreadsheet -> ChangeSheet($Index);
				
				foreach ($Spreadsheet as $Key => $Row){
					//echo "<pre>";	print_r($Row);echo "</pre>";exit;
					unset($arrayCust[$Count]);	
					foreach($post as $Key => $val){ 
						//$i = $_POST[$Key];
                                              
                                                if($Key == 'Status')
                                                {
                                                    $Row[$val] = ($Row[$val] == 'Active')? 'Yes':'';
                                                }
							
						$arrayCust[$Count][$Key]=addslashes(trim($Row[$val]));
      
            /************updated by chetan12feb************/                                    
    if(!empty($arrayCust[$Count]["country_id"])){
	unset($arryCountry); unset($arryState); unset($arryCity);
	$arryCountry = $objRegion->GetCountryID($arrayCust[$Count]["country_id"]); 
        if(empty($arryCountry))
        { 
            $arryCountry = $objRegion->getCountryByCode($arrayCust[$Count]["country_id"]); 
        }
	$arrayCust[$Count]["country_id"] = (int)$arrayCust[$Count]["country_id"];
        if(empty($arrayCust[$Count]["country_id"])){
           $arrayCust[$Count]["country_id"] = $arryCountry[0]['country_id'];
           $arrAdd[$Count]["CountryName"] = $arryCountry[0]['name'];
        }  
        
	if($arrayCust[$Count]['country_id'] > 0 && !empty($arrayCust[$Count]["OtherState"])){		
            $arryState = $objRegion->GetStateID($arrayCust[$Count]["OtherState"], $arrayCust[$Count]['country_id']);
            if(empty($arryState))
            {
                $arryCodeState = $objRegion->GetStateByCode($arrayCust[$Count]["OtherState"], $arrayCust[$Count]['country_id']);
                $arryState = $arryCodeState;
            }
		$arrayCust[$Count]["country_id"] = (int)$arrayCust[$Count]["country_id"];
            if(!empty($arrayCust[$Count]['country_id']) ){
                $arrayCust[$Count]["main_state_id"] = $arryState[0]['state_id'];//set
                $arrAdd[$Count]["StateName"] = $arryState[0]['name'];
                $arrayCust[$Count]["State"] = ($arrayCust[$Count]["main_state_id"]) ? $arryState[0]["name"]  : '';
                
                $arrayCust[$Count]["OtherState"] = ($arrayCust[$Count]["main_state_id"]) ? '':$arrayCust[$Count]["OtherState"]; 
            }    
	}
        
	if($arrayCust[$Count]['country_id'] > 0 && $arrayCust[$Count]["main_state_id"] > 0 
                && !empty($arrayCust[$Count]["OtherCity"])){		
		$arryCity = $objRegion->GetCityIDSt($arrayCust[$Count]["OtherCity"], $arrayCust[$Count]["main_state_id"], $arrayCust[$Count]['country_id']); 
  		
                $arrayCust[$Count]["main_city_id"]=$arryCity[0]['city_id'];//set
                $arrAdd[$Count]["CityName"] = $arryCity[0]['name'];
                $arrayCust[$Count]["City"] = $arrayCust[$Count]["OtherCity"];
                $arrayCust[$Count]["OtherCity"] = ($arrayCust[$Count]["main_city_id"]) ? '':$arrayCust[$Count]["OtherCity"]; 
	}
	
    }                                           
             //End//                                                                                
					}
                                        $Count++;
				}        
                        }  
                        
                        $arrayCust = array_values(array_filter(array_map('array_filter', $arrayCust)));
                      
                       $NumCust=sizeof($arrayCust);
                        $Count = $NumCust;
                        if($NumCust > 0)
                        {   
                            /******Connecting to company database*******/
				$Config['DbName'] = $_SESSION['CmpDatabase'];
				$objConfig->dbName = $Config['DbName'];
				$objConfig->connect();
				/*******************************************/		
                            for($i=1;$i<$NumCust;$i++){
                                $EmailExist = 0;
                                $CustCodeExist = 0;
                                  $NameExist  = 0;
                                if($arrayCust[$i]["Email"] !=''
                                    && (!preg_match("/^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/",$arrayCust[$i]["Email"]) 
                                     ||  $objCustomer->isEmailExists($arrayCust[$i]["Email"],'')) )
                                {
                                    $EmailExist=1;	
                                }
                                if($arrayCust[$i]["CustCode"]!='' && $objCustomer->isCustCodeExists($arrayCust[$i]["CustCode"])){
                                     $CustCodeExist=1;	
                                }
                                 
                                if(($arrayCust[$i]["FirstName"]!='' && $arrayCust[$i]["LastName"]!='') && 
                                        $objCustomer->isCustomerExist($arrayCust[$i]["FirstName"],$arrayCust[$i]["LastName"]))
                                {
                                    $NameExist = 1;
                                }
                                
                                if($EmailExist == 0 && $CustCodeExist ==0 && $NameExist == 0)
                                {
                                    $CustomerId=$objCustomer->addCustomer($arrayCust[$i]);
                                    $arrayCust[$i]['PrimaryContact']=1;
                                    $AddID = $objCustomer->addCustomerAddress($arrayCust[$i],$CustomerId,'shipping');
																		$AddID2 = $objCustomer->addCustomerAddress($arrayCust[$i],$CustomerId,'billing');

                                     //By chetan 12Feb//    
                                    $arrayCust[$i]["Country"]=$arrAdd[$i]["CountryName"];
                                    $arrayCust[$i]["State"]=$arrAdd[$i]["StateName"];
                                    $arrayCust[$i]["City"]=$arrAdd[$i]["CityName"];
																		$arrayCust[$i]["Address"]=$arrAdd[$i]["Address"];
                                    //End//
                                    $objCustomer->UpdateShippingWithImport($arrayCust[$i],$AddID);
                                    $objCustomer->UpdateBillingWithImport($arrayCust[$i],$AddID2);
                                    $CusAddedCount++;

                                }
                             
                            }
                            unlink($_POST['FileDestination']);
			}
	 		
			$mess_Cus = "Total Customer to import from excel sheet : ".($Count-1);
			$mess_Cus .= "<br>Total Customer imported into database : ".$CusAddedCount;
			$mess_Cus .= "<br>Customer already exist in database : ".($Count-1-$CusAddedCount);


			if(!empty($CustomerId)){								
				$_SESSION['mess_cust'] = $mess_Cus;				
				header("Location:".$RedirectURL);
				exit;
			}else{
				$ErrorMsg = $mess_Cus;			
			}
                        
                        
                                        
                    }
                }
                
            }
            
            
            
            
            
                if($_POST['submit'] = 'upload'){
		if($_FILES['excel_file']['name'] != ''){		
                        
                    
                        /********Connecting to main database*********/
			$Config['DbName'] = $Config['DbMain'];
			$objConfig->dbName = $Config['DbName'];
			$objConfig->connect();
			/*******************************************/
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
			}
		       }else{
			     $ErrorMsg = $FileArray['ErrorMsg'];
			}
		 }
                
			if($fileName!="" && file_exists($FileDestination)){			
 
			   if($fileExt=='xls'){	
			      $Filepath =getcwd()."/".$FileDestination;
			    }
			 else{ 

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
                                    $arrayLead=array();
                                    foreach ($Spreadsheet as $Key => $Row){

                                    if(!empty($Row[0]) && !empty($Row[1]) && !empty($Row[2])){	
                                            foreach ($Row as $val){
                                                     if(trim($val)!=''){
                                                    $arrayHeader[]=$val;
                                                }
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
                                       
                                    }else{

                                            $ErrorMsg=SHEET_NOT_UPLOADED;
                                    }

                            }
                        }

    }else{  unlink($FileDestination); }
            }
            
                
		
			
    }

include("../includes/html/box/import_customer_form.php");
include_once("../includes/footer.php");
?>



<!--<SCRIPT LANGUAGE=JAVASCRIPT>

function ValidateForm(frm)
{
	if( ValidateMandExcel(frm.excel_file,"Please upload customer sheet in excel format."))
          {
		
		ShowHideLoader('1','P');
		return true;	
	}else{
		return false;	
	}
	
}
</SCRIPT>
<a class="back" href="<?=$RedirectURL?>">Back</a>
<a href="dwn.php?file=../upload/Excel/CustomerTemplate.xls" class="download" style="float:right">Download Template</a> 
<div class="had"><?=$MainModuleName?> &raquo; <span>
Import Customer
</span>
</div>


<div align="center" id="ErrorMsg" class="redmsg"><br><?=$ErrorMsg?></div>


<div id="prv_msg_div" style="display:none"><img src="images/loading.gif">&nbsp;Loading..............</div>
<div id="preview_div" >	

<table width="100%"  border="0" cellpadding="0" cellspacing="0" >
              <form name="form1" action method="post" onSubmit="return ValidateForm(this);" enctype="multipart/form-data">
              
                <tr>
                  <td align="center"  >

				  <table width="100%" border="0" cellpadding="5" cellspacing="1"  class="borderall">
                  

                    <tr>
                    <td  class="blackbold" valign="top" width="45%"  align="right"> Import Customer Sheet :<span class="red">*</span></td>
                    <td  align="left"   class="blacknormal" valign="top" height="80"><input name="excel_file" type="file" class="inputbox"  id="excel_file"  onkeypress="javascript: return false;" onkeydown="javascript: return false;" oncontextmenu="return false" ondragstart="return false" onselectstart="return false" />
					<br>
					<?=IMPORT_SHEET_FORMAT_MSG?>
	                 </td>
					</tr>	
             </table></td>
                </tr>
				 <tr><td align="center">
	 <input name="Submit" type="submit" class="button" value="Upload" />
				  
				  </td></tr> 
				
              </form>
          </table>

</div>-->
		

	   



