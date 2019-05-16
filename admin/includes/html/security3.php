
<script language="JavaScript1.2" type="text/javascript">
 

function validateForm(frm){

	if(  ValidateForSimpleBlank(frm.EmailSecurityCode, "Verification code sent to your email")
		)
                {    
			ShowHideLoader(1,'P');
			return true;		
		}
      else{
					return false;	
			}	
}

</script>
 

<div class="had_big">Security Authentication Step <?=$Step?> of <?=$NumSecurity?></div>
<div class="message"><? if(!empty($_SESSION['mess_sms'])) {echo $_SESSION['mess_sms']; unset($_SESSION['mess_sms']); }?></div>

<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<form name="form1" method="post" onSubmit="return validateForm(this);">
	<tr>
		<td align="center" height="50" >&nbsp;</td>
			</tr>


	<tr>
		<td align="center" valign="top">
		 
		<table width="80%" border="0" cellpadding="5" cellspacing="0"
			class="borderall">
			<tr>
				<td colspan="2" align="left" class="head">Email Verification</td>
			</tr>
		
		<tr>
				<td colspan="2" align="left"  > &nbsp;</td>
			</tr>	

         <tr>   
                <td align="right" valign="top" class="blackbold" > </td>
				<td align="left">  </td>
			</tr>

 


<tr>   
                <td align="right" valign="top" class="blackbold" > </td>
				<td align="left">  </td>
			</tr>

			<tr>
        <td  align="right" valign="top"  class="blackbold" width="45%"> <strong>Enter Verification Code : </strong></td>

<td align="left"> 
	<input name="EmailSecurityCode" type="text" class="inputbox" id="EmailSecurityCode" value=""  maxlength="50" autocomplete="off" /> 
&nbsp; &nbsp; 
 
<a class="fancybox action_bt fancybox.iframe" href="sendSecurityCode.php">Send Security Code</a> 

 <br>
<?=EMAIL_AUTH_MSG?>
 

         </td>
      </tr>
			
<tr>
				<td colspan="2" align="left"  > &nbsp;</td>
			</tr>
			


		</table>
		</td>
	</tr>
	<tr>
			<td colspan=2 align="center">
			<input name="Submit" type="submit" class="button" id="SubmitButton" value="Submit" />
			 	
					</td>
			</tr>
	</form>
</table>
 
