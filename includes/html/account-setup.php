<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left"  width="100%" valign="top"><table cellspacing="0" cellpadding="0" width="100%" align="center">
      <tr>
        <td height="32" align="left" valign="middle" class="pagenav"><span ><?=$Nav_Home?>  <?=$Nav_MemberPortal?> </span>  <?=SETUP_YOUR_ACCOUNT?></td>
      </tr>
      <tr>
        <td  align="left" valign="middle" class="heading"><?=SETUP_YOUR_ACCOUNT?></td>
      </tr>
      <tr>
        <td height="15"></td>
      </tr>
	 
      <tr>
        <td height="32" >
		  <form action=""  method="post" enctype="multipart/form-data" name="formRegistration" id="formRegistration" >
		<table width="50%" border="0" cellspacing="0" cellpadding="0" class="generaltxt_inner">
         
		 <? if($_SESSION['WebsiteStoreOption']!='w' && $_SESSION['WebsiteStoreOption']!='ws'){?>
		  <tr>
            <td width="4%" height="30" align="left" valign="middle" ><input type="radio" name="WebsiteStoreOption"  value="w" checked /></td>
            <td  height="30" align="left" valign="middle">
              <?=OPTION_WEBSITE?>  for <b><?=round($arrayConfig[0]['WebsitePrice'],2).' '.$Config['Currency']; ?></b>
              </td>
          </tr>
		 
		  
		  <? } if($_SESSION['WebsiteStoreOption']!='s' && $_SESSION['WebsiteStoreOption']!='ws'){?>
          <tr>
            <td height="30" align="left" valign="middle" ><input type="radio" name="WebsiteStoreOption"   value="s" checked/></td>
            <td height="30" align="left" valign="middle">
              <?=OPTION_ONLINE_STORE?> for <b><?=round($arrayConfig[0]['StorePrice'],2).' '.$Config['Currency']; ?></b>
              </td>
          </tr>
		  <? } if($_SESSION['WebsiteStoreOption']==''){?>
          <tr>
            <td  height="30" align="left" valign="middle"><input type="radio" name="WebsiteStoreOption"   value="ws" checked/></td>
            <td  height="30" align="left" valign="middle">
              <?=OPTION_WEBSITE_ONLINE_STORE?> for <b><?=round($arrayConfig[0]['WebsiteStorePrice'],2).' '.$Config['Currency']; ?></b>
              </td>
          </tr>
		  <? } ?>
          <tr>
            <td height="30" colspan="2" align="left" valign="middle" >&nbsp;</td>
            </tr>
          <tr>
            <td height="30" colspan="2" align="left" valign="middle" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="20%" align="left"><input name="SubmitButton" id="SubmitButton" type="image" value=" " src="images/continue.jpg" width="112" height="30" /></td>
                <td width="80%" align="left">
                    <input type="hidden" name="MemberID" id="MemberID" value="<? echo $_SESSION['MemberID']; ?>" />
                    <input type="hidden" name="UpdateSetup" id="UpdateSetup" value="1" />                </td>
              </tr>
            </table></td>
            </tr>
        </table>
		</form>
          </td>
      </tr>
    </table></td>
    <td align="right" valign="top"><? require_once("includes/html/box/right.php"); ?>
    </td>
  </tr>
</table>
</td>
</tr>
</table>
