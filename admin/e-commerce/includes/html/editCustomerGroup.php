<div class="had"> <?=$ModuleTitle;?><a href="<?= $ListUrl ?>" class="back">Back</a></div>
  <table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center" valign="top">
               <form name="form1" action="" method="post" id="customerGroupForm"  enctype="multipart/form-data">
                <table width="100%"  border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td align="center" valign="middle">
                           
                            <table width="100%"  border="0" cellpadding="0" cellspacing="0" class="borderall">


                                <tr>
                                    <td align="center" valign="top" ><table width="100%" border="0" cellpadding="5" cellspacing="1" >
                                            <tr>
                                                <td width="30%" align="right" valign="top" class="blackbold"> 
                                               Group Name : <span class="red">*</span> </td>
                                                <td width="56%"  align="left" valign="top">
                                                    <input  name="GroupName" id="GroupName" value="<? if(isset($arryCustomerGroup[0]['GroupName'])) echo stripslashes($arryCustomerGroup[0]['GroupName']); ?>" type="text" class="inputbox"  maxlength='50' />
                                                </td>
                                            </tr>
                                         
                                            <tr>
                                                <td align="right" valign="middle"  class="blackbold"> Status :  </td>
                                                <td align="left" class="blacknormal">
                                                    <table width="151" border="0" cellpadding="0" cellspacing="0"  class="blacknormal margin-left">
                                                        <tr>
                                                            <td width="20" align="left" valign="middle"><input name="Status" type="radio" value="1" <?= ($CustomerGroupStatus == "Yes") ? "checked" : "" ?> /></td>
                                                            <td width="48" align="left" valign="middle">Active</td>
                                                            <td width="20" align="left" valign="middle"><input name="Status" type="radio" <?= ($CustomerGroupStatus == "No") ? "checked" : "" ?> value="0" /></td>
                                                            <td width="63" align="left" valign="middle">Inactive</td>
                                                        </tr>
                                                    </table>                      
                                                </td>
                                            </tr>
                                           
                                           

                                        </table>
                                        
                                    </td>
                                </tr>


                            </table></td>
                    </tr>
                    <tr>
                        <td align="center" height="135" valign="top"><br>
                           <? if ($_GET['edit'] > 0) {?>
                            <input type="hidden" name="customerGroupId" id="customerGroupId" value="<?=$customerGroupID;?>" />
                            <input name="Submit" type="Submit" class="button" id="UpdateCustomerGroup" value="Update" />
                           <?php } else{?>
                            <input name="Submit" type="button" class="button" id="SaveCustomerGroup" value="Submit" />
                            <?php }?>
                        </td>
                    </tr>

                </table>
                 </form>   
            </td>
        </tr>
</table>
