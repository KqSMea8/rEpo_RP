<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left"  width="100%" valign="top"><table cellspacing="0" cellpadding="0" width="100%" align="center">
      <tr>
        <td height="32" align="left" valign="middle" class="pagenav"><span ><?=$Nav_Home?> </span> Login</td>
      </tr>
   
	  
	    <tr>
        <td  align="left" valign="middle" class="heading">Login</td>
      </tr>
      <tr>
        <td height="15"></td>
      </tr>
	  
	 <? if(!empty($errMsg)){ ?>
			 <tr>
			   <td colspan="2"  class="redtxt" height="50"  align="center" ><?=$errMsg?></td>
			 </tr>
			 <? } ?>  
	  
	
		<tr>
			<td height="44" valign="top" class="generaltxt_inner"><?=LOGIN_TOP_MSG?></td>
		</tr>
	
     
 <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="50%" align="center" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="graybox_login">
                  <tr>
                    <td><table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
                      <form name="LoginForm1" action="login.php"  method="post" onSubmit="return validateLogin(this);">
					  <tr>
                        <td height="25" align="center" valign="middle" class="smalltxt"><?=ALREADY_WEBO_CUSTOMER?></td>
                      </tr>
                      <tr>
                        <td height="49" align="center" valign="middle"><img src="images/buyer.jpg"  /></td>
                      </tr>
                      <tr>
                        <td><table width="88%" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td width="41%" height="30" align="left" valign="middle" >Email  :</td>
                            <td width="59%" height="30" align="left" valign="middle">
                              <input name="LoginEmail" type="text"  class="txtfield_contact" size="20" maxlength="50"/>
                            </td>
                          </tr>
                          <tr>
                            <td height="30" align="left" valign="middle"><span >Password  :</span></td>
                            <td align="left" valign="middle" class="small_txt">
                              <input name="LoginPassword" type="password"  class="txtfield_contact" size="20" maxlength="20"/>
                            </td>
                          </tr>
                          <tr>
                            <td height="30" align="left" valign="middle">&nbsp;</td>
                            <td align="left" valign="middle" class="small_txt"><a href="forgot.php" class="bluetxt_link"><?=FORGOT_YOUR_PASSWORD?></a></td>
                          </tr>
                        </table></td>
                      </tr>
                      <tr>
                        <td height="50" align="center" valign="middle">
						
						<input type="image" src="images/Login-Page_login.jpg" alt="Login"  width="70" height="31" value=" " />
						
						<input type="hidden" name="LoginType"  value="Buyer" />
						<input type="hidden" name="ContinueUrl" id="ContinueUrl" value="<?=$_GET['ref']?>" />
						</td>
                      </tr>
					  </form>
                    </table></td>
                  </tr>
                </table></td>
                <td width="50%" align="center" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="graybox_login">
                  <tr>
                    <td><table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
                 <form name="LoginForm2" action=""  method="post" onSubmit="return validateLogin(this);">

					    <tr>
                          <td height="25" align="center" valign="middle" class="smalltxt"><?=ALREADY_WEBO_CUSTOMER?></td>
                        </tr>
                        <tr>
                          <td height="49" align="center" valign="middle"><img src="images/seller.jpg" /></td>
                        </tr>
                        <tr>
                          <td><table width="88%" border="0" align="center" cellpadding="0" cellspacing="0">
                              <tr>
                                <td width="41%" height="30" align="left" valign="middle" >Email  :</td>
                                <td width="59%" height="30" align="left" valign="middle">
                                   <input name="LoginEmail" type="text"  class="txtfield_contact" size="20" maxlength="50"/>
                                </td>
                              </tr>
                              <tr>
                                <td height="30" align="left" valign="middle"><span >Password  :</span></td>
                                <td align="left" valign="middle" class="small_txt">
                                   <input name="LoginPassword" type="password"  class="txtfield_contact" size="20" maxlength="20"/>
                                </td>
                              </tr>
                              <tr>
                                <td height="30" align="left" valign="middle">&nbsp;</td>
                                <td align="left" valign="middle" class="small_txt"><a href="forgot.php" class="bluetxt_link"><?=FORGOT_YOUR_PASSWORD?></a></td>
                              </tr>
                          </table></td>
                        </tr>
                        <tr>
                          <td height="50" align="center" valign="middle">						  
			<input type="image" src="images/Login-Page_login.jpg" alt="Login"  width="70" height="31" value=" " />
	  <input type="hidden" name="LoginType"  value="Seller" />
	  <input type="hidden" name="ContinueUrl" id="ContinueUrl" value="<?=$_GET['ref']?>" />
						  </td>
                        </tr>
						</form>
                    </table></td>
                  </tr>
                </table></td>
              </tr>
            </table></td>
   </tr>
		  

 <tr>
        <td height="15"></td>
      </tr>		  
		  
		  
	<tr>
            <td align="left" valign="top" class="generaltxt_inner"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="55%" valign="top">
				
				<?=LOGIN_BOTTOM_MSG?>
					
					
					
					</td>
                <td width="45%" align="right" valign="bottom"><a href="signup.php"><img src="images/register_button.jpg" width="103" height="31" border="0" /></a></td>
              </tr>
            </table></td>
          </tr>	  
		  
		  
          <tr>
            <td height="25" align="left" valign="bottom" class="generaltxt_inner">&nbsp;</td>
          </tr>	 
	 
	 
	 
	 
    </table></td>
    <td align="right" valign="top"><? require_once("includes/html/box/right.php"); ?>
    </td>
  </tr>
</table>
</td>
</tr>
</table>
