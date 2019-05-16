<?
	require_once($Prefix."classes/item.class.php");
	require_once($Prefix."classes/function.class.php");
	require_once('../php-excel-reader/excel_reader2.php');
	require_once('../php-excel-reader/SpreadsheetReader.php');
	require_once('../php-excel-reader/SpreadsheetReader_XLSX.php');

	$ModuleName = "Item";
	$objItem=new items();
	$objFunction=new functions();
       	$RedirectURL = "viewItem.php";

	if($_POST){
		if($_FILES['excel_file']['name'] != ''){		

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
			    if (php_sapi_name() == 'cli'){
			       $ErrorMsg=PLEASE_SPECIFY_FILENAME.PHP_EOL;
		             }else{
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
				$arrayItem=array();
				$Line=0;
				foreach ($Spreadsheet as $Key => $Row)
				{
				$Line++;	
				if($Line==1) continue;
				
	$Sku=$Row[0];
	$ItemName=$Row[1];
	
	if(!empty($Sku)){
		if($objItem->isItemNumberExists($Sku,'','')){
		    $SkuExist = 1;
		}else{
		   $SkuExist = 0;
		}
	}

   	if(!empty($Sku) && !empty($ItemName) && $SkuExist==0){
		unset($arrayItem);
		
		$arrayItem["Sku"]=$Row[0];
		$arrayItem["description"]=$Row[1];
		$arrayItem['procurement_method'][0] = 'SALE'; 
		$arrayItem["sell_price"]=$Row[2]; 
		$arrayItem["qty_on_hand"]=$Row[3];
		$arrayItem["long_description"]=$Row[4];
		$arrayItem["Status"] = (strtolower(trim($Row[5]))=='inactive')?(0):(1);
		$arrayItem['non_inventory'] = 'yes';
		
		$arrayItem["Manufacture"]=$Row[6];
		$arrayItem["Condition"]=$Row[7];
		$arrayItem["itemType"]=$Row[8];
		$arrayItem["evaluationType"]=$Row[9];
		//echo '<pre>'; print_r($arrayItem);exit;

		$ItemID=$objItem->addItem($arrayItem);	

		$Count++;
		
	  }
	
		$CurrentMem = memory_get_usage();
      }////end of for loop

		if($Uploaded == 1)unlink($FileDestination);


		if(!empty($ItemID)){
			$_SESSION['mess_item']=ITEM_IMPORTED;
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
	if( ValidateMandExcel(frm.excel_file,"Please upload sheet in excel format."))
          {
		
		ShowHideLoader('1','P');
		return true;	
	}else{
		return false;	
	}
	
}
</SCRIPT>
<a class="back" href="<?=$RedirectURL?>">Back</a>
<a href="dwn.php?file=../upload/Excel/ItemTemplate.xls" class="download" style="float:right">Download Template</a> 
<div class="had"><?=$MainModuleName?> &raquo; <span>
Import Item
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
                    <td  class="blackbold" valign="top" width="45%"  align="right"> Import Item Sheet :<span class="red">*</span></td>
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
		

	   


