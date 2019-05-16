<div class="had"><?= $ModuleName; ?></div>
<TABLE WIDTH=768   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
    <form name="form1" action="" method="post"  enctype="multipart/form-data"><TR>
            <TD align="center" valign="top"><table width="100%"  border="0" cellpadding="0" cellspacing="0">
                    <tr><td align="center" class="message"><?php if($_SESSION['mess_cart'] != ""){?><?=$_SESSION['mess_cart']; unset($_SESSION['mess_cart']);?><?php }?></td></tr>
                    <tr>
                        <td align="center" valign="middle" >
                            <table width="100%"  border="0" cellpadding="0" cellspacing="0" class="borderall">
                                
                                <tr>
                                    <td align="center" valign="top" ><table width="100%" border="0" cellpadding="5" cellspacing="1" >
                                            <tr>
                                                <td width="30%" align="right" valign="top" =""  class="blackbold"> 
                                                    Store Name  <span class="red">*</span> </td>
                                                <td width="56%"  align="left" valign="top">
                                                    <input  name="StoreName" id="StoreName" value="<?= stripslashes($arryCartSetting[0]['StoreName']) ?>" type="text" class="inputbox"  size="50" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="30%" align="right" valign="top"  class="blackbold"> 
                                                    Store Notification Email <span class="red">*</span> </td>
                                                <td width="56%"  align="left" valign="top">
                                                    <input  name="StoreNotificationEmail" id="StoreNotificationEmail" value="<?= stripslashes($arryCartSetting[0]['StoreNotificationEmail']) ?>" type="text" class="inputbox"  size="50" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td  align="right" valign="top"   class="blackbold"> Store Support Email <span class="red">*</span> </td>
                                                <td align="left" valign="top">
                                                    <input  name="StoreSupportEmail" id="StoreSupportEmail" value="<?= stripslashes($arryCartSetting[0]['StoreSupportEmail']) ?>" type="text" class="inputbox"  size="30" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td  align="right" valign="top"   class="blackbold"> Enable  Https Url  for Checkout </td>
                                                <td align="left" valign="top">
                                                    <select name="HttpsUrlEnable" id="HttpsUrlEnable"  class="inputbox">
                                                        <option value="No" <? if ($arryCartSetting[0]['HttpsUrlEnable'] == 'No') echo 'selected'; ?>>No</option>
                                                        <option value="Yes" <? if ($arryCartSetting[0]['HttpsUrlEnable'] == 'Yes') echo 'selected'; ?>>Yes</option>
                                                    </select> 
                                                </td>
                                            </tr>

                                            <tr> 
                                                <td   align="right" valign="top"    class="blackbold">Store Closed </td>
                                                <td   align="left" valign="top" class="blacknormal"> 
                                                    <select name="StoreClosed" id="StoreClosed"  class="inputbox">
                                                        <option value="No" <? if ($arryCartSetting[0]['StoreClosed'] == 'No') echo 'selected'; ?>>No</option>
                                                        <option value="Yes" <? if ($arryCartSetting[0]['StoreClosed'] == 'Yes') echo 'selected'; ?>>Yes</option>
                                                    </select> 
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="right" class="blackbold" valign="top">Store Closed Message   </td>
                                                <td align="left" class="blacknormal">
                                                    <textarea  name="StoreClosedMessage" id="StoreClosedMessage" class="inputbox"><?= stripslashes($arryCartSetting[0]['StoreClosedMessage']) ?></textarea>               
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
                            <? if ($_GET['edit'] > 0) $ButtonTitle = 'Update'; else $ButtonTitle = 'Save'; ?>
                            <input type="hidden" name="CartSettingId" id="CartSettingId" value="<?php echo $CartSettingId; ?>">
                            <input name="Submit" type="submit" class="button" id="SaveCartSettings" value=" <?= $ButtonTitle ?> " />&nbsp;

                    </tr>

                </table></TD>
        </TR>
    </form>
</TABLE>
<script language="JavaScript1.2" type="text/javascript">

    $(document).ready(function() {
        $("#SaveCartSettings").click(function(){
       
            var StoreName = $.trim($("#StoreName").val());
            var StoreNotificationEmail = $.trim($("#StoreNotificationEmail").val());
            var StoreSupportEmail = $.trim($("#StoreSupportEmail").val());
           
            if(StoreName == "")
            {
                alert("Please enter store name");
                $("#StoreName").focus();
                return false;
            }
       
            if(StoreNotificationEmail == "")
            {
                alert("Please enter store notification email");
                $("#StoreNotificationEmail").focus();
                return false;
            }
            
            if(StoreSupportEmail == "")
            {
                alert("Please enter store support email");
                $("#StoreSupportEmail").focus();
                return false;
            }
     
   
        });
    }); 
</script>