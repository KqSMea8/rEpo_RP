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
                        <td align="right" valign="top"  class="blackbold">New Password :<span class="red">*</span>  </td>
                        <td align="left" valign="top" class="blacknormal"><input name="Password" type="Password"
						 class="inputbox" id="Password"  value="" maxlength="20"> <span><?=$MSG[150]?></span>
				<span id='npasserror'></span>
				</td>
                      </tr>
					  <tr>
                        <td align="right" valign="middle"  class="blackbold">Confirm Password  :<span class="red">*</span>  </td>
                        <td align="left" valign="middle"><input name="ConfirmPassword" type="Password" class="inputbox" id="ConfirmPassword"  value="" maxlength="20">
<span id='cpasserror'></span>
<span id='compaire'></span>	
	</td>
                      </tr>
					    
                     
                  </table>
				 
				  
				  </td>
                </tr>
             
          </table> </td>
        </tr>
		
		<tr>
		<td align="center">
		<br> 
		<input name="Submit" type="submit" value="Update" class="button" id="chbutton">
		</td>
		</tr>
		
      </table></TD>
  </TR>
	 </form>
</TABLE>
<script type='text/javascript'>
$(document).ready(function(){
	$('#chbutton').on('click',function(){
	var npass=$('#Password').val();
	//alert('npass'+npass);
	var cpass=$('#ConfirmPassword').val();
	//alert('cpass'+cpass);
		if(npass==''){
			$('#npasserror').html('New password is required');
			$('#Password').css('border','1px solid #ff0000');
			return false;
		} else {
			$('#npasserror').hide();
			$('#Password').css('border','1px solid #dae1e8');
		}
		if(cpass==''){
			$('#cpasserror').html('Confirm password is required');
			$('#ConfirmPassword').css('border','1px solid #ff0000');
			return false;
		} else {
			$('#cpasserror').hide();
			$('#ConfirmPassword').css('border','1px solid #dae1e8');
		}
		if(npass!=cpass){
			$('#compaire').html(' password is not matching');
			$('#ConfirmPassword').css('border','1px solid #ff0000');
			return false;
		}else {
			$('#compaire').hide();
			$('#ConfirmPassword').css('border','1px solid #dae1e8');
		}
	
	});

});
</script>
