<div class="had"> <?= $ModuleTitle; ?></div>
<form name="form1" action="" method="post"  enctype="multipart/form-data">
    <table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center" valign="top">
                <table width="100%"  border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td align="center" valign="middle">
                            <div  align="right"><a href="<?= $ListUrl ?>" class="back">Back</a>&nbsp;</div><br>
                            <table width="100%"  border="0" cellpadding="0" cellspacing="0" class="borderall">


                                <tr>
                                    <td align="center" valign="top" ><table width="100%" border="0" cellpadding="5" cellspacing="1" >
                                            <tr>
                                                <td width="30%" align="right" valign="top"  class="blackbold"> 
                                                    Email :<span class="red">*</span> </td>
                                                <td width="56%"  align="left" valign="top">
                                                    <input  name="Email" id="Email" value="<?= stripslashes($arrySubcriber[0]['Email']) ?>" type="text" class="inputbox"  size="50" />
                                                </td>
                                            </tr>

                                            <tr>
                                                <td align="right" valign="middle"  class="blackbold"> Status :  </td>
                                                <td align="left" class="blacknormal">
                                                    <table width="151" border="0" cellpadding="0" cellspacing="0"  class="blacknormal margin-left">
                                                        <tr>
                                                            <td width="20" align="left" valign="middle"><input name="Status" type="radio" value="1" <?= ($SubcriberStatus == "Yes") ? "checked" : "" ?> /></td>
                                                            <td width="48" align="left" valign="middle">Active</td>
                                                            <td width="20" align="left" valign="middle"><input name="Status" type="radio" <?= ($SubcriberStatus == "No") ? "checked" : "" ?> value="0" /></td>
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
                            <? if ($_GET['edit'] > 0) {
                                $ButtonTitle = 'Update';
                            } else {
                                $ButtonTitle = 'Submit';
                            } ?>
                            <input type="hidden" name="EmailId" id="EmailId" value="<?= $EmailId; ?>" />
                            <input name="Submit" type="submit" class="button" id="UpdateSubscriber" value=" <?= $ButtonTitle ?> " />&nbsp;
                        </td>
                    </tr>

                </table>
            </td>
        </tr>

    </table>
</form>