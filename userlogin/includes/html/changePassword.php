<SCRIPT LANGUAGE=JAVASCRIPT>
function validate(frm)
{	
	if( ValidateMandRange(frm.OldPassword, "Old Password", 5, 15)
	   && ValidateMandRange(frm.Password, "New Password", 5, 15)
	   && ValidateForPasswordConfirm(frm.Password,frm.ConfirmPassword)
	){
		document.getElementById("msg_div").innerHTML = 'Processing...';
		return true;	
	}else{
		return false;	
	}
}
</SCRIPT>
<div class="had">Change Password</div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<form name="form1" action="" method="post" onSubmit="return validate(this);"><TR>
	  <TD align="center" ><table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td align="center" style="padding-top:100px;"  >
		  <div class="message"  id="msg_div" ><? if(!empty($_SESSION['mess_conf'])) {echo $_SESSION['mess_conf']; unset($_SESSION['mess_conf']); }?></div>
		    <table width="100%" border="0" cellpadding="0" cellspacing="0" >
              
               
                <tr>
                  <td align="center" valign="top" ><table width="100%"  border="0" align="right" cellpadding="4" cellspacing="1">
                      
                      <tr>
                        <td width="45%" align="right" valign="middle"  class="blackbold">Old Password :<span class="red">*</span>  </td>
                        <td width="55%" align="left" valign="middle">
                        <input name="OldPassword" type="Password" class="inputbox" id="OldPassword"  value="" maxlength="20">                        </td>
                      </tr>
                      <tr>
                        <td align="right" valign="top"  class="blackbold">New Password :<span class="red">*</span>  </td>
                        <td align="left" valign="top" class="blacknormal"><input name="Password" type="Password"
						 class="inputbox" id="Password"  value="" maxlength="20">  <span><?=PASSWORD_LIMIT?></span></td>
                      </tr>
					  <tr>
                        <td align="right" valign="middle"  class="blackbold">Confirm Password  :<span class="red">*</span>  </td>
                        <td align="left" valign="middle"><input name="ConfirmPassword" type="Password" class="inputbox" id="ConfirmPassword"  value="" maxlength="20"></td>
                      </tr>
					    
                     
                  </table>
				 
				  
				  </td>
                </tr>
             
          </table> </td>
        </tr>
		
		<tr>
		<td align="center">
	
		<input name="Submit" type="submit" value="Update" class="button">
		</td>
		</tr>
		
      </table></TD>
  </TR>
	 </form>
</TABLE>