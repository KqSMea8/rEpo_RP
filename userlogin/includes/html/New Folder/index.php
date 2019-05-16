<SCRIPT LANGUAGE=JAVASCRIPT>
function validate(frm)
{	
	if( ValidateForBlank(frm.LoginUsername, "Username")
	   && ValidateForBlank(frm.LoginPassword, "Password")
	){
		return true;	
	}else{
		return false;	
	}
}
</SCRIPT>
<table width="100%"  border="0" cellspacing="0" cellpadding="0" align="center">
      
      <tr>
        <td height="350" >	
                    <table width="300"  border="0" cellpadding="0" cellspacing="1" align="center"    >
                      <form action="" method="post" name="form1" id="form1" onsubmit="return validate(this);">
                        <tr>
                          <td height="23" align="left" valign="middle" > <div class="message" align="center"><?=$mess?></div></td>
                        </tr>
                        <tr>
                          <td align="center" valign="top" class="memberbg"><table width="96%"  border="0" cellspacing="1" cellpadding="1">
                              <tr>
								<td colspan="2"><h1>Please login here</h1></td>
							  </tr>
								
                             
                             
                              <tr>
                                <td width="41%" align="right" valign="middle" class="blackbold">Username : </td>
                                <td  align="left" valign="middle"><input name="LoginUsername" type="text" class="inputbox" id="LoginUsername" size="20" maxlength="25" />                                </td>
                              </tr>
                              <tr>
                                <td colspan="2" height="5"></td>
                              </tr>
                              <tr>
                                <td align="right" valign="middle" class="blackbold">Password : </td>
                                <td align="left" valign="middle"><input name="LoginPassword" type="password" class="inputbox" id="LoginPassword" size="20" maxlength="25" /></td>
                              </tr>
							 <tr>
                                <td colspan="2" height="5"></td>
                              </tr>
                              <tr>
                                <td height="32" class="blackbold">&nbsp;</td>
                                <td><input name="Submit" type="submit" width="60" height="26"  value=" Login "  class="button"/>
								 <input type="hidden" name="ContinueUrl" id="ContinueUrl" value="<?=$_GET['ref']?>" />								</td>
                              </tr>
                              <tr>
                                <td colspan="2" align="left" valign="middle" class="blackbold" height="8"></td>
                              </tr>
                          </table></td>
                        </tr>
                      </form>
                    </table>
                    <br />
          <br />
          <br />
          <br />
          <br /> <br />
                   
                    
         </td>
      </tr>
     
      </table>