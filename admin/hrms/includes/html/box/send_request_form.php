<SCRIPT LANGUAGE=JAVASCRIPT>


function ValidateForm(frm)
{

	if( ValidateForSimpleBlank(frm.request_subject, "Subject") 
		&& ValidateForSimpleBlank(frm.request_message, "Message")
	){
		ShowHideLoader(1,'S');
		
	}else{
		return false;	
	}
	
}
</SCRIPT>
<div class="redmsg" align="center"><?=$ErrorMsg?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	  <form name="form1" action="" method="post" onSubmit="return ValidateForm(this);" enctype="multipart/form-data">
		<tr>
		  <td align="center">
		  
		  <table width="100%" border="0" cellpadding="5" cellspacing="1" class="borderall" >
             <tr>
			<td colspan="2">&nbsp;</td>
			</tr>     
			<tr>
			<td  align="right"   class="blackbold" width="45%">Subject :<span class="red">*</span></td>
			<td  align="left" valign="top">
			<input type="text" maxlength="100" value="" id="request_subject" class="inputbox" name="request_subject">
			</td>
			</tr>                
	      <tr>
          <td align="right"   class="blackbold" valign="top">Message  :<span class="red">*</span></td>
          <td  align="left" >
            <textarea name="request_message" type="text" class="bigbox" id="request_message" onkeypress="return isAlphaKey(event);"></textarea>	
			
			</td>
        </tr>
		 <tr>
			<td colspan="2">&nbsp;</td>
			</tr> 
 </table>
		  

		</td>
	    </tr>
		<tr>
		  <td align="center" valign="top"><br>
		  <input type="hidden" name="EmpID" value="<?=$EmpID?>">
	        <input name="Submit" type="submit" class="button" id="SubmitButton" value="Send" />		    
			</td>
		  </tr>
	    </form>
</TABLE>
