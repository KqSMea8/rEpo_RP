 
<script language="JavaScript1.2" type="text/javascript">

function ShowSecurityCode(){
	$("#SecurityTxt").show();
}

function validateForm(frm){

	if(	 ValidatePhoneNumber(frm.Mobile,"Mobile Number",10,20)
		&&  ValidateForSimpleBlank(frm.SecurityCode, "Verification code sent to your mobile")
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
				<td colspan="2" align="left" class="head">SMS Verification</td>
			</tr>
		
		<tr>
				<td colspan="2" align="left"  > &nbsp;</td>
			</tr>	

         <tr>   
                <td align="right" valign="top" class="blackbold" > </td>
				<td align="left">  </td>
			</tr>

<tr>
        <td  align="right" valign="top"  class="blackbold" width="45%"> <strong>Mobile Number : </strong></td>

<td align="left"> 
	<input name="Mobile" type="text" class="inputbox" id="Mobile" value=""  maxlength="50" autocomplete="off" /> 
&nbsp; &nbsp; 
<a href="#" class="action_bt" onclick="Javascript:ShowSecurityCode()">Send Verification Code</a> 
 
<span id="SecurityTxt" style="display:none">
 <? echo '[<strong>'.$_SESSION['SecurityCode'].'</strong>]';?>
</span>
         </td>
      </tr>


<tr>   
                <td align="right" valign="top" class="blackbold" > </td>
				<td align="left">  </td>
			</tr>

			<tr>
        <td  align="right" valign="top"  class="blackbold" width="45%"> <strong>Enter Verification Code : </strong></td>

<td align="left"> 
	<input name="SecurityCode" type="text" class="inputbox" id="SecurityCode" value=""  maxlength="50" autocomplete="off" /> 
&nbsp; &nbsp; 
 
 

<?=SMS_AUTH_MSG?>
 

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
 
