<?
	require_once($Prefix."classes/sales.customer.class.php");
	require_once($Prefix."classes/function.class.php");
	require_once('../php-excel-reader/excel_reader2.php');
	require_once('../php-excel-reader/SpreadsheetReader.php');
	require_once('../php-excel-reader/SpreadsheetReader_XLSX.php');

	$ModuleName = "Customer";
	$objCustomer=new Customer();
	$objFunction=new functions();
       	$RedirectURL = "viewCustomer.php";

	if($_POST){
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
		                $MainDir = "../upload/Excel/".$_SESSION['CmpID']."/";						
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
			    if (php_sapi_name() == 'cli')
			      {
			       $ErrorMsg=PLEASE_SPECIFY_FILENAME.PHP_EOL;
		        }
			  else{
			     $ErrorMsg=SPECIFY_FILENAME_HTTP_GET_PARAMETER;
			}
			exit;
		}
		
                
			date_default_timezone_set('UTC');
			$StartMem = memory_get_usage();
			$mimeType=mime_content_type($Filepath);

		if($mimeType=='application/zip'){
		   try{
			     $Spreadsheet = new SpreadsheetReader_XLSX($Filepath);
			     $BaseMem = memory_get_usage();

	               while($Spreadsheet->valid()){

		        print_r($Spreadsheet->next());
		       }
		    }  
		     catch (Exception $E){
		           echo $E -> getMessage();
		     } 
		}
		else{
		    try{
			$Spreadsheet = new SpreadsheetReader($Filepath);
			$BaseMem = memory_get_usage();
			$Sheets = $Spreadsheet -> Sheets();
			$Count = 0;
		        foreach ($Sheets as $Index => $Name){
				$Time = microtime(true);
				$Spreadsheet -> ChangeSheet($Index);
				$arrayCust=array();
				foreach ($Spreadsheet as $Key => $Row)
					{
  	#echo "<pre>";	print_r($Row);echo "</pre>";exit;				
	$CustCode=$Row[0];
	$FirstName=$Row[1];
	$Email=$Row[3];
	if(!empty($Email)){
		if (preg_match("/^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/",$Email))
		{
		    $ValidEmail = 1;
		}else{
		   $ValidEmail = 0;
		}
	}

   	if(!empty($FirstName) && !empty($Email) && $ValidEmail==1){
		unset($arrayCust[$Count]);
		
		$arrayCust[$Count]["CustCode"]=$Row[0];
		$arrayCust[$Count]["FirstName"]=$Row[1];
		$arrayCust[$Count]["LastName"]=$Row[2];    
		$arrayCust[$Count]["Email"]=$Row[3]; 
		$arrayCust[$Count]["Gender"]=$Row[4];
		$arrayCust[$Count]["CustomerType"]=$Row[5];
		$arrayCust[$Count]["Company"]=$Row[6];
		$arrayCust[$Count]["Country"]=$Row[7];
		$arrayCust[$Count]["OtherState"]=$Row[8];
		$arrayCust[$Count]["OtherCity"]=$Row[9];
		$arrayCust[$Count]["Address"]=$Row[10];
		$arrayCust[$Count]["ZipCode"]=$Row[11];
		$arrayCust[$Count]["Mobile"]=$Row[12];
		$arrayCust[$Count]["Landline"]=$Row[13];
		$arrayCust[$Count]["Fax"]=$Row[14];
		$arrayCust[$Count]["Website"]=$Row[15];  
	
		$arrayCust[$Count]["CountryName"]=$arrayCust[$Count]["Country"];
		$arrayCust[$Count]["StateName"]=$arrayCust[$Count]["OtherState"];
		$arrayCust[$Count]["CityName"]=$arrayCust[$Count]["OtherCity"];
			
/************************/
if(!empty($arrayCust[$Count]["Country"])){
	$arryCountry = $objRegion->GetCountryID($arrayCust[$Count]["Country"]);  
	$arrayCust[$Count]["country_id"]=$arryCountry[0]['country_id']; //set	
	$arrayCust[$Count]["Country"]=$arryCountry[0]['country_id']; //set	
	if($arryCountry[0]['country_id']>0 && !empty($arrayCust[$Count]["OtherState"])){		
		$arryState = $objRegion->GetStateID($arrayCust[$Count]["OtherState"], $arryCountry[0]['country_id']); 
		$arrayCust[$Count]["main_state_id"]=$arryState[0]['state_id'];//set
		$arrayCust[$Count]["State"]=$arryState[0]['state_id'];//set
	}
	if($arryCountry[0]['country_id']>0 && !empty($arrayCust[$Count]["OtherCity"])){		
		$arryCity = $objRegion->GetCityID($arrayCust[$Count]["OtherCity"], $arryCountry[0]['country_id']); 
		$arrayCust[$Count]["main_city_id"]=$arryCity[0]['city_id'];//set
		$arrayCust[$Count]["City"]=$arryCity[0]['city_id'];//set
	}
}
/************************/
		$Count++;
		
	  }
	
		$CurrentMem = memory_get_usage();
      }////end of for loop


		if($Uploaded == 1)unlink($FileDestination);
		/**********************************/		
		//echo '<pre>';print_r($arrayCust);exit; 
		$NumCust=sizeof($arrayCust);
		if($NumCust>0){	
			/******Connecting to company database*******/
			$Config['DbName'] = $_SESSION['CmpDatabase'];
			$objConfig->dbName = $Config['DbName'];
			$objConfig->connect();
			/*******************************************/		
			 for($i=0;$i<$NumCust;$i++){
			   if($objCustomer->isEmailExists($arrayCust[$i]["Email"],'')){
				$EmailExist=1;	
			   }else  if($arrayCust[$i]["CustCode"]!='' && $objCustomer->isCustCodeExists($arrayCust[$i]["CustCode"])){
				$CustCodeExist=1;	
			   }else{
					
				$CustomerId=$objCustomer->addCustomer($arrayCust[$i]);
				$arrayCust[$i]['PrimaryContact']=1;
				$AddID = $objCustomer->addCustomerAddress($arrayCust[$i],$CustomerId,'contact');

				$arrayCust[$i]["Country"]=$arrayCust[$i]["CountryName"];
				$arrayCust[$i]["State"]=$arrayCust[$i]["StateName"];
				$arrayCust[$i]["City"]=$arrayCust[$i]["CityName"];	
				$objCustomer->UpdateCountryStateCity($arrayCust[$i],$AddID);
				
	
			   }
			 }
		}		
		/**********************************/


		if(!empty($CustomerId)){
			$_SESSION['mess_cust']=CUSTOMER_DATA_IMPORTED;
			header("Location:".$RedirectURL);
			exit;
		}else{
			$ErrorMsg=SHEET_NOT_UPLOADED;
		}
		

         }
       }
	catch (Exception $E)
	{

	echo $E -> getMessage();
	}
      }
    }
}



?>



<SCRIPT LANGUAGE=JAVASCRIPT>

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

</div>
		

	   


