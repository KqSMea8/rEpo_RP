<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left"  width="100%" valign="top"><table cellspacing="0" cellpadding="0" width="100%" align="center">
      <tr>
        <td height="32" align="left" valign="middle" class="pagenav"><span ><?=$Nav_Home?> 
          <?=$Nav_MemberPortal?>
          
          <a href="account-setup.php"><?=SETUP_YOUR_ACCOUNT?></a>
          </span>
              <?=ACCOUNT_SETUP_PAYMENT?></td>
      </tr>
      <tr>
        <td  align="left" valign="middle" class="heading"><?=ACCOUNT_SETUP_PAYMENT?></td>
      </tr>
      <tr>
        <td height="15"></td>
      </tr>
	   
	 
      <tr>
        <td height="32" ><table width="100%" border="0" align="center" cellpadding="3" cellspacing="2" >
          <tr>
            <td width="14%" align="right" valign="top" nowrap="nowrap" class="generaltxt_inner">
			<b>Selected Account Type : </b><?=stripslashes($SetupType)?> for <u><?=round($AccountPrice,2).' '.$Config['Currency']; ?></u>
               </td>
            
          </tr>
        
        </table>
        <table width="100%" border="0" cellspacing="0" cellpadding="1" align="center">
            <form action="" method="post" name="form1" id="form1">
              <tr>
                <td><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
                    <tr>
                      <td width="236" height="24"  class="whit-txt" nowrap="nowrap"><?=PLEASE_SELECT_PAYMENT_GATEWAY?>
                      </td>
                      <td width="497">
					  
					  		<input type="hidden" name="SetupType" id="SetupType" value="<?=stripslashes($SetupType)?>" />
                          <input type="hidden" name="MemberID" id="MemberID" value="<?=$_SESSION['MemberID']?>" />
                          <input type="hidden" name="AccountPrice" id="AccountPrice" value="<?=round($AccountPrice,2)?>" />
						   <input type="hidden" name="WebsiteStoreOption" id="WebsiteStoreOption" value="<? echo $_GET['ws']; ?>"  />
						  
						  </td>
                    </tr>
                  </table>
                   <? include("includes/html/box/payment_box.php"); ?>
                  </td>
              </tr>
            </form>
          </table></td>
      </tr>
    </table></td>
    <td align="right" valign="top"><? require_once("includes/html/box/right.php"); ?>
    </td>
  </tr>
</table>
</td>
  </tr>
</table>
