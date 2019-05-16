<? if (empty($_SESSION['UserName']) && empty($_SESSION['MemberID'])) { ?>

				<table width="100%" border="0" cellspacing="0" cellpadding="0">
				 <tr>
					<td class="panel_top"><div class="heading">
					  <?=LOGIN?>
					</div></td>
				  </tr>

                  <tr>
                    <td align="center"  class="panel_middle" >
					<form name="LoginForm" action="login.php"  method="post" onSubmit="return validateLogin(this);">
					<table width="90%" border="0" cellspacing="0" cellpadding="0">
					<?	if($_SESSION['mess_invalid'] != ''){ ?>
						<tr>
                        <td height="22" align="left" valign="middle" class="redtxt">
						<? echo $_SESSION['mess_invalid']; unset($_SESSION['mess_invalid']);?>
						</td>
                      </tr>
					<? } ?>
							
                      <tr>
                        <td height="22" align="left" valign="middle" class="generaltxt">Email Address:</td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle">
						<input name="LoginEmail" id="LoginEmail" type="text"  class="txtfield_search" size="24" maxlength="70"/>
						</td>
                      </tr>
                      <tr>
                        <td height="22" align="left" valign="middle" class="generaltxt">Password:</td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle">
						 <input name="LoginPassword" id="LoginPassword" type="password"  class="txtfield_search" size="24"/>
						</td>
                      </tr>
                      <tr>
                        <td height="25" align="left" valign="middle"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td width="32%">
						<input type="image" src="<?=$TemplateFolder?>images/login_button.png" alt="Login"  value=" " />	
							</td>
                            <td width="68%" align="left" valign="middle">
							<a href="<?=$Config['Url']?>forgot.php" class="forgot_link"><?=FORGOT_PASSWORD?></a> <input type="hidden" name="LoginType" id="LoginType" value="" />
							<input type="hidden" name="ContinueUrl" id="ContinueUrl" value="<?=$ContinueUrl?>" />
							
							</td>
                          </tr>
                        </table></td>
                      </tr>
                    </table>
					</form>
					
					
					</td>
                  </tr>
			  <tr>
				<td class="panel_bottom"></td>
			  </tr>
                </table>
				
				<? }else{ ?>
				
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<form name="LoginForm" action="login.php"  method="post" onSubmit="return validateLogin(this);">
				 <tr>
					<td class="panel_top"><div class="heading">
					  <?=MY_ACCOUNT?>
					</div></td>
				  </tr>
                  <tr>
                    <td align="center" class="panel_middle">
					
					<table width="96%" border="0" cellspacing="0" cellpadding="4">
						 <tr>
						<td align="left" valign="middle"><a href="<?=$Config['Url']?>member-area.php" class="forgot_link"><?=MEMBER_PORTAL?></a></td>
						</tr>
						<tr>
						<td align="left" valign="middle"><a href="<?=$Config['Url']?>account.php" class="forgot_link"><?=MY_ACCOUNT?></a></td>
						</tr>
						<tr>
						<td align="left" valign="middle"><a href="<?=$Config['Url']?>logout.php?Website=<?=$_SESSION['StoreUserName']?>" class="forgot_link"><?=LOG_OUT?></a></td>
						</tr>
						
	<?  if($_SESSION['MemberID']!=$_SESSION['StoreID']){		   ?>	
					 
					 	<? if(!$objBulk->isMemberSubscribed($_SESSION['MemberID'],$_SESSION['StoreID'],'email')){ ?>			
						<tr>
						<td align="left" valign="middle">
						<?
						echo '<a class="forgot_link" href="'.$Config['Url'].'subscribe.php?Type=email&MemberID='.$_SESSION['MemberID'].'&StoreID='.$_SESSION['StoreID'].'&pId='.$_GET['id'].'&UserName='.$_SESSION['StoreUserName'].'" onclick="return confDel(\''.SUSBCRIBE_FOR_EMAIL_ALERT2.'\')">'.SUSBCRIBE_FOR_EMAIL.'</a> ';
						?>		
						
						</td>
						</tr>
						<? } 
						if(!$objBulk->isMemberSubscribed($_SESSION['MemberID'],$_SESSION['StoreID'],'sms')){
						?>
						
						<tr>
						<td align="left" valign="middle">
						<?
						echo ' <a class="forgot_link" href="'.$Config['Url'].'subscribe.php?Type=sms&MemberID='.$_SESSION['MemberID'].'&StoreID='.$_SESSION['StoreID'].'&pId='.$_GET['id'].'&UserName='.$_SESSION['StoreUserName'].'" onclick="return confDel(\''.SUSBCRIBE_FOR_SMS_ALERT2.'\')">'.SUSBCRIBE_FOR_SMS.'</a> ';
						?>
						</td>
						</tr>
						<? } ?>
		<? } ?>
	
						
                    </table></td>
                  </tr>
				  </form>
  <tr>
    <td class="panel_bottom"></td>
  </tr>
                </table>			
				
				
				
				<? } ?>
				<br style="line-height:8px;">