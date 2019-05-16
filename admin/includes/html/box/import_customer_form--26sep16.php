<?php 
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
    var mand = 0;
    
    $('select').each(function(){
        
        if($(this).val() != '')
        {
            mand++;
        }
       
    });
	
     if(mand < 2)
    {
        alert('Two fields are mandatory');
        return false;
    }    


	$arr = [];


	$('select option:selected').each(function(){

  		$arr.push($(this).val());
	})
	if( $arr.length != jQuery.unique($arr).length && $arr.length > 0)
	{
		 alert('Duplicate Header has been selected.');
        	return false;
	}

        
}
</SCRIPT>
<a class="back" href="<?=$RedirectURL?>">Back</a>


<!--a href="dwn.php?file=<?=$DownloadFile?>" class="download" style="float:right">Download Template</a--> 

<div class="had"><?=$MainModuleName?> &raquo; <span>
Import <?=ucfirst($ModuleName)?>
</span>
</div>


<div align="center" id="ErrorMsg" class="redmsg"><br><?=$ErrorMsg?></div>


<div id="prv_msg_div" style="display:none"><img src="images/loading.gif">&nbsp;Loading..............</div>
<div id="preview_div" >	
 
<?php if($NumHeader>0){?>
    <form name="form1" method="post" onSubmit="return ValidateColumn(this);" enctype="multipart/form-data">
<table width="100%"  border="0" cellpadding="0" cellspacing="0" >
             
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
      		<?php 
		$Count=0;
		foreach($DbColumnArray as $Key => $Heading){ 
		$Line = $Count+1;
		//$mand = ($Count<$NumMandatory)?('<span class="red">*</span>'):('');

		?>
                    
                    <td  class="blackbold" valign="top" height="40"  align="right"> <?=$Heading?> : <?=$mand?></td>
                    <td  align="center"   class="blacknormal" valign="top">

<?php
$DropDown = str_replace("HeaderIndex",$Key,$DropDownHTML);
echo $DropDown = str_replace("HeaderID",$Key,$DropDown);
?>



	                 </td>
			
		<?php 
			if($Line%2==0) echo '</tr><tr>';

			
			$Count++;
		} ?>
		</tr>
             </table>


</td>
                </tr>
				 <tr><td align="center">
	 <input name="Submit" type="submit" class="button" value="Save" />
<input name="FileDestination" id="FileDestination" type="hidden"  value="<?=$FileDestination?>" />
<input name="FileName" id="FileName" type="hidden"  value="<?=$fileName?>" />
<input name="DbColumn" id="DbColumn" type="hidden"  value="<?=$DbColumn?>" />


				  </td></tr> 
				
              </form>
          </table>

<?php }else{ ?>
        <form name="form1" action method="post" onSubmit="return ValidateForm(this);" enctype="multipart/form-data">
<table width="100%"  border="0" cellpadding="0" cellspacing="0" >
              
              
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
				
              
          </table>
<?php } ?>
</form>

</div>
		
<?php echo '<script>SetInnerWidth();</script>'; ?>
	   

