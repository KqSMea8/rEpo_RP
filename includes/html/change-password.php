
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left"  width="100%" valign="top"><table cellspacing="0" cellpadding="0" width="100%" align="center">
     
	  <tr>
        <td  align="left" valign="middle" class="heading"><?=CHANGE_PASSWORD?></td>
      </tr>
	  <tr>
        <td height="32" align="left" valign="middle" class="pagenav"><span ><?=$Nav_Home?>  <?=$Nav_MemberPortal?> </span>  <?=CHANGE_PASSWORD?></td>
      </tr>
     
      <tr>
        <td height="15"></td>
      </tr>
	   <? //if(!empty($_SESSION['mess_password'])) { ?>
	   <tr>
              <td align="center" valign="top" class="redtxt" height="35">
			  		<?
			  		echo $_SESSION['mess_password'];
					unset($_SESSION['mess_password']); 
					?>
			  </td>
       </tr>
	  <? //} ?> 
	  
      <tr>
        <td height="32" class="graybox_forgot"><table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" >
         		<form name="formForgot" action=""  method="post" onSubmit="return validate(this);" enctype="multipart/form-data">	

		 
		  <tr>
		    <td align="right"  style="text-align:right">&nbsp;</td>
		    <td colspan="2" align="left" >&nbsp;</td>
		    </tr>
		  <tr>
            <td align="right"  style="text-align:right"><?=OLD_PASSWORD?></td>
            <td colspan="2" align="left" ><input name="OldPassword" id="OldPassword" value="" type="password" class="txtfield"  maxlength="15" /></td>
          </tr>
          <tr>
            <td align="right"  style="text-align:right"><?=NEW_PASSWORD?></td>
            <td width="16%" align="left" ><input name="Password" type="password" class="txtfield" id="Password" value=""  maxlength="15" /></td>
            <td width="40%" align="left" class="generaltxt_inner">
              <?=PASSWORD_LIMIT?>           </td>
          </tr>
          <tr>
            <td align="right"  style="text-align:right"><?=CONFIRM_PASSWORD?></td>
            <td colspan="2" align="left" ><input name="ConfirmPassword" type="password" class="txtfield" id="ConfirmPassword" value=""  maxlength="15" /></td>
          </tr>
          <tr>
            <td width="44%"  height="65" align="right" >&nbsp;</td>
            <td colspan="2" align="left" >
			
			<input type="submit" name="Reset"  value="Submit" class="button" />
                      <input type="hidden" name="MemberID" id="MemberID" value="<?php echo $_SESSION['MemberID']; ?>" />
                      <input type="hidden" name="Email" id="Email" value="<?php echo $_SESSION['Email']; ?>" />
                      <input type="hidden" name="OldPasswordHidden" id="OldPasswordHidden" value="<?php echo $arryMember[0]['Password']; ?>" />
                      <input type="hidden" name="ChangePassword" id="ChangePassword" value="1" />
                  <input type="hidden" name="Name" id="Name" value="<?php echo $_SESSION['Name']; ?>" />					</td>
          </tr>
		  </form>
        </table></td>
      </tr>
    </table></td>
    <td align="right" valign="top"><? require_once("includes/html/box/right.php"); ?>
    </td>
  </tr>
</table>
