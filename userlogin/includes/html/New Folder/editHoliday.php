
<SCRIPT LANGUAGE=JAVASCRIPT>
function ValidateForm(frm)
{
	if(  ValidateForSimpleBlank(frm.heading, "Holiday Name")
		&& ValidateForSelect(frm.holidayDate, "Holiday Date")
	){
		var Url = "isRecordExists.php?HolidayName="+escape(document.getElementById("heading").value)+"&editID="+document.getElementById("holidayID").value;
		SendExistRequest(Url,"heading","Holiday Name");
		return false;
	}else{
		return false;	
	}
	

	
	
}

</SCRIPT>
  <div  align="right" class="back"><a href="<?=$RedirectUrl?>" >Back</a></div>
<div class="had">Manage <?=$ModuleName?> &raquo; <strong>
<? 
$MemberTitle = (!empty($_GET['edit']))?(" Edit ") :(" Add ");
echo $MemberTitle.$ModuleName;
?>
</strong>
</div>
<TABLE WIDTH=500   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	  <form name="form1" action="" method="post" onSubmit="return ValidateForm(this);" enctype="multipart/form-data">
		
		<tr>
		  <td align="center" style="padding-top:80px">
		  <table width="100%"  border="0" cellpadding="0" cellspacing="0" >
            
               
                <tr>
                  <td align="center" valign="top" >
				  
				  <table width="100%" border="0" cellpadding="5" cellspacing="1" class="borderall" >
                  
                   
                    <tr>
                      <td width="30%" align="right" valign="top" class="blackbold"> 
					  Holiday Name :<span class="red">*</span> </td>
                      <td width="56%"  align="left" valign="top"><input  name="heading" id="heading" value="<?=stripslashes($arryHoliday[0]['heading'])?>" type="text" class="inputbox" maxlength="40" />
					  </td>
                    </tr>
					
					 <tr>
                      <td align="right"  class="blackbold">
					 Holiday Date :<span class="red">*</span>
					  </td>
                      <td align="left">
<? if($arryHoliday[0]['holidayDate']>0) $holidayDate = $arryHoliday[0]['holidayDate'];  ?>				
<script type="text/javascript">
$(function() {
	$('#holidayDate').datepick(
		{
		dateFormat: 'yyyy-mm-dd', 
		yearRange: '1950:<?=date("Y")?>', 
		defaultDate: '<?=$holidayDate?>'
		}
	);
});
</script>
<input id="holidayDate" name="holidayDate" readonly="" class="disabled" size="10" value="<?=$holidayDate?>"  type="text" > 
		 
					  </td>
                    </tr>				
                  
	
					
                    <tr >
                      <td align="right" valign="middle"  class="blackbold">Status :</td>
                      <td align="left" >
        <table width="151" border="0" cellpadding="0" cellspacing="0"  class="blacknormal">
          <tr>
            <td width="20" align="left" valign="middle"><input name="Status" type="radio" value="1" <?=($Status==1)?"checked":""?> /></td>
            <td width="48" align="left" valign="middle">Active</td>
            <td width="20" align="left" valign="middle"><input name="Status" type="radio" <?=($Status==0)?"checked":""?> value="0" /></td>
            <td width="63" align="left" valign="middle">Inactive</td>
          </tr>
        </table>                      </td>
                    </tr>
                   
                  </table>
				  
				  
				  </td>
                </tr>
				
          
          </table>
		  
		  
		  </td>
	    </tr>
		<tr>
				<td align="center" valign="top"><br>
			<? if(isset($_GET['edit']) && $_GET['edit'] >0 ) $ButtonTitle = 'Update'; else $ButtonTitle =  'Submit';?>

 	<input type="hidden" name="holidayID" id="holidayID" value="<?=$_GET['edit']?>">   
 
				
				<input name="Submit" type="submit" class="button" id="SubmitButton" value=" <?=$ButtonTitle?> " />&nbsp;
				  <input type="reset" name="Reset" value="Reset" class="button" /></td>
		  </tr>
	    </form>
</TABLE>
