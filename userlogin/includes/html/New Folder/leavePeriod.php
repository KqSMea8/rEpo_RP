<SCRIPT LANGUAGE=JAVASCRIPT>

function ValidateForm(frm)
{
	if( ValidateForSelect(frm.LeaveStart, "Leave Start Date") 
		&& ValidateForSelect(frm.LeaveEnd, "Leave End Date")
	){
		if(frm.LeaveEnd.value<=frm.LeaveStart.value){
			alert("End Date should be greater than Start Date.");
			return false;
		}

		return true;
	}else{
		return false;	
	}	
	
}

</SCRIPT>
<div class="had">Edit Leave Period</div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_leave_pr'])) {echo $_SESSION['mess_leave_pr']; unset($_SESSION['mess_leave_pr']); }?></div>

<TABLE WIDTH=500   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	  <form name="form1" action="" method="post" onSubmit="return ValidateForm(this);" enctype="multipart/form-data">
		
		<tr>
		  <td align="center" style="padding-top:80px">
		  <table width="100%"  border="0" cellpadding="0" cellspacing="0" >
            
               
                <tr>
                  <td align="center" valign="top" >
				  
				  <table width="100%" border="0" cellpadding="5" cellspacing="1" class="borderall" >
                  
                   <tr>
                      <td width="45%" align="right"  class="blackbold">
					  Leave Start Date :<span class="red">*</span>
					  </td>
                      <td align="left">
<? if($arryLeavePeriod[0]['LeaveStart']>0) $LeaveStart = $arryLeavePeriod[0]['LeaveStart'];  ?>				
<script type="text/javascript">
$(function() {
	$('#LeaveStart').datepick(
		{
		dateFormat: 'yyyy-mm-dd', 
		yearRange: '1950:<?=date("Y")?>', 
		defaultDate: '<?=$LeaveStart?>'
		}
	);
});
</script>
<input id="LeaveStart" name="LeaveStart" readonly="" class="disabled" size="10" value="<?=$LeaveStart?>"  type="text" > 
		 
					  </td>
                    </tr>
                    <tr>
                      <td  align="right"   class="blackbold"> 
					Leave End Date :<span class="red">*</span>

					  </td>
                      <td  align="left" valign="top">
<? if($arryLeavePeriod[0]['LeaveEnd']>0) $LeaveEnd = $arryLeavePeriod[0]['LeaveEnd'];  ?>				

<script type="text/javascript">
$(function() {
	$('#LeaveEnd').datepick(
		{
		dateFormat: 'yyyy-mm-dd', 
		yearRange: '1950:<?=date("Y")?>', 
		defaultDate: '<?=$LeaveEnd?>'
		}
	);
});
</script>
<input id="LeaveEnd" name="LeaveEnd" readonly="" class="disabled" size="10" value="<?=$LeaveEnd?>"  type="text" > 


					  </td>
                    </tr>
					
					<? if(!empty($LeaveStart) && !empty($LeaveEnd)){ ?>
				<tr>
                      <td  align="right"   class="blackbold"> 
					Current Leave Period :

					  </td>
                      <td  align="left" valign="top">
					<? echo date("j M Y", strtotime($LeaveStart))." - ".date("j M Y", strtotime($LeaveEnd)); ?>

					  </td>
                    </tr>
					<? } ?>
                  
                   
                  </table>
				  
				  
				  </td>
                </tr>
				
          
          </table>
		  
		  
		  </td>
	    </tr>
		<tr>
				<td align="center" valign="top"><br>
				
				<input name="Submit" type="submit" class="button" id="SubmitButton" value=" Submit " />&nbsp;
				  <input type="reset" name="Reset" value="Reset" class="button" /></td>
		  </tr>
	    </form>
</TABLE>
