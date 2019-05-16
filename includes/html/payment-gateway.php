<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left"  width="100%" valign="top"><table cellspacing="0" cellpadding="0" width="100%" align="center">
     
	 <tr>
        <td  align="left" valign="middle" class="heading"><?=MEMBERSHIP_PAYMENT?></td>
      </tr>
	  <tr>
        <td height="32" align="left" valign="middle" class="pagenav"><span ><?=$Nav_Home?> 
          <?=$Nav_MemberPortal?>
          
          <a href="upgrade-membership.php"><?=UPGRADE_MEMBERSHIP?></a>
          </span>
              <?=MEMBERSHIP_PAYMENT?></td>
      </tr>
      
      <tr>
        <td height="15"></td>
      </tr>
	    <tr>
        <td height="15"  class="skytxt" align="right">
		<? if(!empty($_GET['pkID'])){ ?>
                      <a href="Javascript: window.history.back(-1);">
                        <?=BACK?>
                        </a>
                      <? } ?>
		</td>
      </tr>
	 
	   <tr>
            <td class="graybox"><?=MEMBERSHIP_DETAILS?></td>
          </tr>
      <tr>
        <td height="32" ><table width="100%" border="0" align="center" cellpadding="3" cellspacing="2" >
          <tr>
            <td align="right" valign="top"  nowrap="nowrap"><?=MEMBERSHIP?>
              : </td>
            <td align="left"   class="verdan11"><?=stripslashes($Name)?></td>
          </tr>
          <tr>
            <td align="right" valign="top"   ><?=PRICE?> 
              : </td>
            <td align="left"   class="verdan11">
            <?=display_price($Price,'','',$arryCurrency[0]['symbol_left'],$arryCurrency[0]['symbol_right'])?></td>
          </tr>
          <tr>
            <td width="14%" align="right" valign="top"   ><?=VALIDITY?>
              : </td>
            <td width="86%" align="left"  class="verdan11"><?=$Validity?>
              days </td>
          </tr>
          <tr>
            <td align="right" valign="top"   ><?=DESCRIPTION?>
              : </td>
            <td align="left"  class="verdan11"><?=stripslashes($Description)?>
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
                      <td width="497"><input type="hidden" name="Membership" id="Membership" value="<?=stripslashes($Name)?>" />
                          <input type="hidden" name="packageID" id="packageID" value="<?=$_SESSION['membership_id']?>" />
                          <input type="hidden" name="MemberID" id="MemberID" value="<?=$_SESSION['member_id']?>" />
                          <input type="hidden" name="price" id="price" value="<?=round($Price,2)?>" /></td>
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

