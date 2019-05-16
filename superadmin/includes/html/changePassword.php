
<!-------------------------Amit Singh----------------------------->

<script type="text/javascript" src="js/password_strength.js"></script>
<style>
    #pswd-info-wrap, #pswd-retype-info-wrap {
       right: 129px !important;
       margin-top: 281px;
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
<div class="had"><?php echo 'Change Password';?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<form name="form1" action="" method="post" onSubmit="return validate(this);"><TR>
	  <TD align="center" ><table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td align="center" style="padding-top:100px;"  >
		  <div class="message"  id="msg_div" ><? if(!empty($_SESSION['mess_conf'])) {echo $_SESSION['mess_conf']; unset($_SESSION['mess_conf']); }?></div>
		    <table width="80%" border="0" cellpadding="0" cellspacing="0" class="borderall">
              
               
                <tr>
                  <td align="center" valign="top" ><table width="100%"  border="0" align="right" cellpadding="4" cellspacing="1">
                      
                      <tr>
                        <td width="46%" align="right" valign="middle"  class="blackbold">Old Password :<span class="red">*</span>  </td>
                        <td align="left" valign="middle">
                        <input name="OldPassword" type="Password" class="inputbox" id="OldPassword"  value="" maxlength="20">                        </td>
                      </tr>
                      <tr>
                        <td align="right" valign="top"  class="blackbold">New Password :<span class="red">*</span>  </td>
                        <td align="left" valign="top" class="blacknormal">
                            <input name="Password" type="Password"
						 class="inputbox" id="Password"  value="" maxlength="20"> <span class="passmsg"><?=$MSG[150]?></span>
                            <!---------------------------------------------------------------->
                            <!--span class="passmsg"><?=PASSWORD_LIMIT?></span-->
                            <?php require_once("password_strength_html.php"); ?>
                            <!---------------------------------------------------------------->
                        </td>
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
		<br> 
		<input name="Submit" type="submit" value="Update" class="button">
		</td>
		</tr>
		
      </table></TD>
  </TR>
	 </form>
</TABLE>
