<!-------------------------Amit Singh----------------------------->

<script type="text/javascript" src="js/password_strength.js"></script>
<style>
    #pswd-info-wrap, #pswd-retype-info-wrap {
       right: 191px !important;
    //top: 855px !important;
    }
</style>
<!---------------------------------------------------------------->

<SCRIPT LANGUAGE=JAVASCRIPT>
function validate(frm)
{	
    
     //****************Amit Singh*******************/
                var isvaldd=$('#isvalidate').val();
                //alert(isvaldd);
                if(isvaldd != '1'){ 
                    alert("Please Enter Valid Password.");
                    //document.getElementById("msg_div").innerHTML = "Please Enter Valid Password.";
                    return false;	
                }
     //*********************************************/
	if( ValidateMandRangeMsg(frm.OldPassword, "Old Password", 5, 15)
	   && ValidateMandRangeMsg(frm.Password, "New Password", 5, 15)
	){
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
              <td align="right" valign="top"  class="blackbold" width="40%">New Password :<span class="red">*</span> </td>
              <td align="left" valign="top" class="blacknormal">
                    <input name="Password" type="password"
                        class="inputbox" id="Password"  value="" maxlength="20" onkeypress="ClearMsg();" onmousedown="ClearMsg();"  autocomplete="off"/>
                    <span class="passmsg">
                      <?=PASSWORD_LIMIT?>
                    </span>
                    <?php require_once("password_strength_html.php"); ?>
              </td>
            </tr>
            <tr>
              <td align="right"   class="blackbold">Confirm Password  :<span class="red">*</span> </td>
              <td align="left" ><input name="ConfirmPassword" type="password" class="inputbox" id="ConfirmPassword"  value="" maxlength="20" onkeypress="ClearMsg();" onmousedown="ClearMsg();"  autocomplete="off"/></td>
            </tr>
	 <!--tr>
              <td align="right"   class="blackbold"> </td>
              <td align="left" ><input type='checkbox' name='sendEmail' value='1'> Send Email Notification<br> </td>
            </tr-->
            <tr>
              <td align="right"   class="blackbold">&nbsp;</td>
              <td align="left" ><input name="Submit" type="submit" value="Update" class="button" />
              <input name="custId" type="hidden" value="<?php echo $_GET['custId']?>" class="button" />
              <input name="custloginId" type="hidden" value="<?php echo $_GET['custloginId']?>" class="button" />
              </td>
            </tr>
			 <tr>
              <td colspan="2"   class="blackbold">&nbsp;</td>
            </tr>
          </table>
		  	
</form>   

	

