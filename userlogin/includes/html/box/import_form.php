<?
if($NumHeader>0){
	//Ready for selection
	$DropDownHTML = '<select name="HeaderIndex" id="HeaderID" class="inputbox"><option value="">--- Select Excel Header ---</option>';
	for ($i=0;$i<$NumHeader;$i++){
		$DropDownHTML .= '<option value="'.$i.'">'.$arrayHeader[$i].'</option>';
	}
	$DropDownHTML .= '</select>';
	
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


function ValidateColumn(frm)
{
	var NumLine = parseInt($("#DbColumn").val());
	var NumMandatory = $("#NumMandatory").val();

	for(var i=1;i<=NumMandatory;i++){
		if(document.getElementById("Field"+i) != null){
			if(!ValidateForSelect(document.getElementById("Field"+i), "All Mandatory Fields")){
				return false;
			}		

		}
	}

	var Duplicate = 0; DupIndex=0;
	for(var i=1;i<=NumLine;i++){
		for(var j=1;j<=NumLine;j++){
			if(i!=j && document.getElementById("Field"+i).value!=''){
				if(document.getElementById("Field"+i).value == document.getElementById("Field"+j).value){
					Duplicate=1; DupIndex=j;
					break;
				}
			}
		}

		if(Duplicate==1){
			break;	
		}

	}



	if(Duplicate==1){
		alert("Duplicate Header has been selected.");
		document.getElementById("Field"+DupIndex).focus();
		return false;
	}

	ShowHideLoader('1','P');
	return true;		
}


</SCRIPT>
<a class="back" href="<?=$RedirectURL?>">Back</a>


<!--a href="dwn.php?file=<?=$DownloadFile?>" class="download" style="float:right">Download Template</a--> 

<div class="had"><?=$MainModuleName?> &raquo; <span>
Import <?=ucfirst($module)?>
</span>
</div>


<div align="center" id="ErrorMsg" class="redmsg"><br><?=$ErrorMsg?></div>


<div id="prv_msg_div" style="display:none"><img src="images/loading.gif">&nbsp;Loading..............</div>
<div id="preview_div" >	

<? if($NumHeader>0){?>
<table width="100%"  border="0" cellpadding="0" cellspacing="0" >
              <form name="form1" action method="post" onSubmit="return ValidateColumn(this);" enctype="multipart/form-data">
         <tr>
                  <td align="left"  >
<?=EXCEL_MAP_MSG?> 

		</td>
		</tr>    
         
                <tr>
                  <td align="center"  >

	 <table width="100%" border="0" cellpadding="10" cellspacing="1"  class="borderall">
         <tr>
		<td   class="head" width="20%"  align="right">Database Column  </td>
		<td   class="head" width="25%" align="center"  >
		Imported Excel Sheet Header
		</td>
		<td   class="head"   align="right">Database Column  </td>
		<td   class="head" width="25%" align="center"  >
		Imported Excel Sheet Header
		</td>
		</tr>    
		<tr>
      		<? 
		$Count=0;
		foreach($DbColumnArray as $Key => $Heading){ 
		$Line = $Count+1;
		$mand = ($Count<$NumMandatory)?('<span class="red">*</span>'):('');

		?>
                    
                    <td  class="blackbold" valign="top" height="40"  align="right"> <?=$Heading?> : <?=$mand?></td>
                    <td  align="center"   class="blacknormal" valign="top">

<?
$DropDown = str_replace("HeaderIndex",$Key,$DropDownHTML);
echo $DropDown = str_replace("HeaderID","Field".$Line,$DropDown);
?>



	                 </td>
			
		<? 
			if($Line%2==0) echo '</tr><tr>';

			
			$Count++;
		} ?>
		</tr>
             </table>


</td>
                </tr>
				 <tr><td align="center">
	 <input name="Submit" type="submit" class="button" value=" Save " />
<input name="FileDestination" id="FileDestination" type="hidden"  value="<?=$FileDestination?>" />

<input name="NumMandatory" id="NumMandatory" type="hidden"  value="<?=$NumMandatory?>" />				  

<input name="DbColumn" id="DbColumn" type="hidden"  value="<?=$DbColumn?>" />


				  </td></tr> 
				
              </form>
          </table>

<? }else{ ?>
<table width="100%"  border="0" cellpadding="0" cellspacing="0" >
              <form name="form1" action method="post" onSubmit="return ValidateForm(this);" enctype="multipart/form-data">
              
                <tr>
                  <td align="center"  >

				  <table width="100%" border="0" cellpadding="5" cellspacing="1"  class="borderall">
                  

                    <tr>
                    <td  class="blackbold" valign="top" width="45%"  align="right"> Import Excel Sheet :<span class="red">*</span></td>
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
<? } ?>


</div>
		
<? echo '<script>SetInnerWidth();</script>'; ?>
	   

