<SCRIPT LANGUAGE=JAVASCRIPT>
function validate(frm)
{	
	if( ValidateForSimpleBlank(frm.Email, "Email")
		&& isEmail(frm.Email)
	){
		document.getElementById("msg_div").innerHTML = 'Processing...';
		return true;	
	}else{
		return false;	
	}
}
</SCRIPT>
<div class="had"><?php echo 'Re-Send Activation Email';?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<form name="form1" action="" method="post" onSubmit="return validate(this);"><TR>
	  <TD align="center" ><table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td align="center"  >
<br><br>
		  <div class="message"  id="msg_div" ><? if(!empty($_SESSION['mess_conf'])) {echo $_SESSION['mess_conf']; unset($_SESSION['mess_conf']); }?></div>
		    <table width="80%" border="0" cellpadding="0" cellspacing="0" class="borderall">
              
               
                <tr>
                  <td align="center" valign="top" ><table width="100%"  border="0" align="right" cellpadding="4" cellspacing="1">
                      
                      <tr>
                        <td width="46%" align="right" valign="middle"  class="blackbold">Email-Id :<span class="red">*</span>  </td>
                        <td align="left" valign="middle">
                        <input name="Email" type="email" class="disabled_inputbox" readonly id="Email"  value="<?=$compDetail[0]['Email']?>">                        </td>
                      </tr>
                      
		     
					    
                     
                  </table>
				 
				  
				  </td>
                </tr>
             
          </table> </td>
        </tr>
		
		<tr>
		<td align="center">
	
		<input name="Submit" type="submit" value="Submit" class="button">
<br><br>
		</td>
		</tr>
		
      </table></TD>
  </TR>
	 </form>
</TABLE>
