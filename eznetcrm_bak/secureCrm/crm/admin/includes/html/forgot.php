<SCRIPT LANGUAGE=JAVASCRIPT>
function validateForm(frm)
{	
	if( ValidateLoginEmail(frm.Email, '<?=ENTER_EMAIL?>', '<?=VALID_EMAIL?>')
	){
		document.getElementById("msg_div").innerHTML = 'Processing...';
		return true;	
	}else{
		return false;	
	}
}
</SCRIPT>

<div style="height:220px;">
<div class="had">Forgot Password ?</div>

<? if(empty($ErrorMsg)){ ?>
		<form name="form1" action="" method="post" onSubmit="return validateForm(this);">
		  <table width="100%"  border="0" cellpadding="4" cellspacing="1">
 <tr>
              <td colspan="2" class="blacknormal" ><?=FORGOT_MESSAGE?>
			  </td>
            </tr>
			<tr>
              <td colspan="2" class="blackbold" height="20"><div class="message"  id="msg_div" ><? if(!empty($_SESSION['mess_forgot'])) {echo $_SESSION['mess_forgot']; unset($_SESSION['mess_forgot']); }?></div></td>
            </tr>
            <!--tr>
              <td width="30%" align="right" valign="top"   class="blackbold">User Type : </td>
              <td  align="left" >  
			 <select name="UserType" id="UserType" class="inputbox">
					<option value="admin" <? if($_POST['UserType']=="admin") echo "Selected"; ?>>Administrator</option>
					<option value="employee" <? if($_POST['UserType']=="employee") echo "Selected"; ?>>Employee</option>
				</select>
				
			  </td>
            </tr-->
            <tr>
              <td align="right" valign="top"  class="blackbold">Email : </td>
              <td align="left" valign="top" class="blacknormal"><input name="Email" type="text"
						 class="inputbox" id="Email"  value="" maxlength="80" onkeypress="ClearMsg();" onmousedown="ClearMsg();"  autocomplete="off"/>
                 </td>
            </tr>
          
            <tr>
              <td align="right"   class="blackbold">&nbsp;</td>
              <td align="left" ><input name="Submit" type="submit" value="Submit" class="button" />
			  
			  <input type="hidden" name="CmpID" id="CmpID" value="<?=$arryCompany[0]["CmpID"]?>" />	
			  </td>
            </tr>
			 <tr>
              <td colspan="2"   class="blackbold">&nbsp;</td>
            </tr>
          </table>
		  	
</form>   
<? }else{ ?>
	<div class="redmsg" style="text-align:center; padding-top:100px;"><?=$ErrorMsg?></div>
<? } ?>
	
</div>
