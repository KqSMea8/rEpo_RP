<div class="main-container">
  <div class="mid_wraper clearfix">
    <?php //include_once("includes/left.php"); ?>
    <div class="right_pen">
    <?php if (!empty($_SESSION['successMsg'])) { ?>
<div class="successMsg">
    <?php echo $_SESSION['successMsg']; ?>
    <?php unset($_SESSION['successMsg']);?>
</div>
<?php } ?>
<?php if (!empty($_SESSION['errorMsg'])) { ?>
<div class="warningMsg">
       <?php echo $_SESSION['errorMsg']; ?>
       <?php unset($_SESSION['errorMsg']);?>
</div>
<?php } ?>
<div class="account">
 <h3>Reset Password</h3>
      <div id="reset_Passowrd" class="right_pen addressbook">
        <form name="formForgot" action=""  method="post" enctype="multipart/form-data">
          <table width="100%" border="0" cellspacing="0" cellpadding="0" align="left">
            <tr>
              <td  align="center" valign="middle" class="memberbg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td colspan="2" align="left">
                     <p> To reset your password please enter your email address below. A new password will be sent to the e-mail you provided at registration.</p></td>
                  </tr>
                  
                  <tr>
                    <td width="12%" height="30" align="left" valign="middle" class="blacktxt">Email Address :<span class="red">*</span></td>
                    <td width="63%" height="30" align="left" valign="middle" class="mailinput"><input name="forgotEmail" type="text" class="txtfield_normal" id="forgotEmail" size="30" maxlength="80" />
                    </td>
                  </tr>
                  <tr>
                    <td colspan="2" align="left">&nbsp;</td>
                  </tr>
                  <tr>
                    <td><input type="submit" class="btn btn-info button" id="resetPassword" value="Submit"  /></td>
                    <td align="left" class="btn" >&nbsp;
                    </td>
                  </tr>
                  <tr>
                    <td colspan="2" align="left">&nbsp;</td>
                  </tr>
                </table></td>
            </tr>
          </table>
        </form>
      </div>
</div>
     
    </div>
  </div>
</div>
