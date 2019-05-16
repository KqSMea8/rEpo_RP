
<script type="text/javascript" src="js/password_strength.js"></script>
<SCRIPT LANGUAGE=JAVASCRIPT>
  
function validate(frm)
{	
        
       
        var isvaldd=$('#isvalidate').val();
	if( ValidateMandRangeMsg(frm.OldPassword, "Old Password", 5, 15)
	   && ValidateMandRangeMsg(frm.Password, "New Password", 5, 15) 
	){
               if(isvaldd != '1'){
			document.getElementById("msg_div").innerHTML = "Please Enter Valid Password.";
			return false;	
	       }



		if(frm.OldPassword.value==frm.Password.value){
			document.getElementById("msg_div").innerHTML = "Old Password and New Password should not be same.";
			return false;	
		}
		if(!ValidateForPasswordConfirmMsg(frm.Password,frm.ConfirmPassword)){
			return false;	
		}


		document.getElementById("msg_div").innerHTML = 'Processing...';
		return true;	
	}else{
            
		return false;	
	}
}
</SCRIPT>
<div class="had">Change Password</div>
		<form name="form1" action="" method="post" onSubmit="return validate(this);">
		  <table width="100%"  border="0" cellpadding="4" cellspacing="1">
            <tr>
              <td colspan="2" class="blackbold" height="30"><div class="message"  id="msg_div" ><? if(!empty($_SESSION['mess_conf'])) {echo $_SESSION['mess_conf']; unset($_SESSION['mess_conf']); }?></div></td>
            </tr>
            <tr>
              <td width="45%" align="right"   class="blackbold">Old Password :<span class="red">*</span> </td>
              <td  align="left" ><input name="OldPassword" type="password" class="inputbox" id="OldPassword"  value="" maxlength="20" onkeypress="ClearMsg();" onmousedown="ClearMsg();"  autocomplete="off"/>              </td>
            </tr>
            <tr>
              <td align="right" valign="top"  class="blackbold">New Password :<span class="red">*</span> </td>
              <td align="left" valign="top" class="blacknormal"><input name="Password" type="password"
						 class="inputbox" id="Password"  value="" maxlength="20" onkeypress="ClearMsg();" onmousedown="ClearMsg();"  autocomplete="off"/>
                  <span class="passmsg">
                    <?=PASSWORD_LIMIT?>
                  </span>
                  <?php require_once("includes/html/box/password_strength_html.php"); ?>
                  
              </td>
            </tr>
            <tr>
              <td align="right"   class="blackbold">Confirm Password  :<span class="red">*</span> </td>
              <td align="left" ><input name="ConfirmPassword" type="password" class="inputbox" id="ConfirmPassword"  value="" maxlength="20" onkeypress="ClearMsg();" onmousedown="ClearMsg();"  autocomplete="off"/></td>
            </tr>
            <tr>
              <td align="right"   class="blackbold">&nbsp;</td>
              <td align="left" ><input name="Submit" type="submit" value="Update" class="button" /></td>
            </tr>
			 <tr>
              <td colspan="2"   class="blackbold">&nbsp;</td>
            </tr>
          </table>
		  	
</form>   

	

