<div class="had"><?= $ModuleName; ?></div>
  <table width="98%"  border="0" align="center" cellpadding="0" cellspacing="0">
  
        <tr>
            <td align="center" valign="top">
              <form name="form1" action="" method="post"  enctype="multipart/form-data">
                <table width="100%"  border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td align="center" class="message"><?php if($_SESSION['mess_cart'] != ""){?><?=$_SESSION['mess_cart']; unset($_SESSION['mess_cart']);?><?php }?></td></tr>
                    <tr>
                        <td align="center" valign="middle" >
                            <table width="100%"  border="0" cellpadding="0" cellspacing="0" class="borderall">    
                                <tr>
                                    <td align="center" valign="top" ><table width="100%" border="0" cellpadding="5" cellspacing="1" >
                                            <tr>
                                                <td width="30%" align="right" valign="top"  class="blackbold"> 
                                                     Facebook Like Button on a product page </td>
                                                <td width="56%"  align="left" valign="top">
                                                    <select name="FacebookLikeButton" id="FacebookLikeButton"  class="inputbox">
                                                        <option value="No" <? if ($arryCartSetting[0]['FacebookLikeButton'] == 'No') echo 'selected'; ?>>No</option>
                                                        <option value="Yes" <? if ($arryCartSetting[0]['FacebookLikeButton'] == 'Yes') echo 'selected'; ?>>Yes</option>
                                                    </select> 
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="30%" align="right" valign="top"  class="blackbold"> 
                                                     Twitter Account  </td>
                                                <td width="56%"  align="left" valign="top">
                                                    <input  name="TwitterAccount" id="TwitterAccount" value="<?= stripslashes($arryCartSetting[0]['TwitterAccount']) ?>" type="text" class="inputbox"  size="50" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td  align="right" valign="top"   class="blackbold">
                                                    Tweet button on a product page  </td>
                                                <td align="left" valign="top">
                                                    <select name="TwitterTweetButton" id="TwitterTweetButton"  class="inputbox">
                                                        <option value="No" <? if ($arryCartSetting[0]['TwitterTweetButton'] == 'No') echo 'selected'; ?>>No</option>
                                                        <option value="Yes" <? if ($arryCartSetting[0]['TwitterTweetButton'] == 'Yes') echo 'selected'; ?>>Yes</option>
                                                    </select> 
                                                </td>
                                            </tr>
                                            <tr>
                                                <td  align="right" valign="top"   class="blackbold"> 
                                                    Post to Google Plus from a product page  </td>
                                                <td align="left" valign="top">
                                                    <select name="GooglePlusButton" id="GooglePlusButton"  class="inputbox">
                                                        <option value="No" <? if ($arryCartSetting[0]['GooglePlusButton'] == 'No') echo 'selected'; ?>>No</option>
                                                        <option value="Yes" <? if ($arryCartSetting[0]['GooglePlusButton'] == 'Yes') echo 'selected'; ?>>Yes</option>
                                                    </select> 
                                                </td>
                                            </tr>
                                        </table>

                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" height="135" valign="top"><br>
                            <input name="Submit" type="submit" class="button" value="Save" />&nbsp;
                        </td>
                    </tr>
                </table>
               </form>
            </td>
        </tr>
   
</table>
