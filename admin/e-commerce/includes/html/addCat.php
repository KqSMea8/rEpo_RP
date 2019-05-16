<div class="had"><?php echo  $ModuleName; ?>
</div>
<table width="98%"  border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center" valign="top">
               <form name="form1" action="" method="post" enctype="multipart/form-data">
                <table width="100%"  border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td align="center" valign="middle" >
                            <table width="100%"  border="0" cellpadding="0" cellspacing="0" class="borderall">
                                <tr>
                                    <td align="center" valign="top" ><table width="100%" border="0" cellpadding="5" cellspacing="1" >
                                            <tr>
                                                <td width="30%" align="right" valign="top"  class="blackbold"> 
                                                    Select Parent Category : <span class="red">*</span> </td>
                                                <td width="56%"  align="left" valign="top">
                                                    <select name="ParentID" id="ParentID" class="inputbox">
                                                        <option value="0">Category Root</option>
                                                        <?php
                                                        $objCategory->getCategories(0, 0, $_GET['ParentID']);
                                                        ?>
                                                    </select>	

                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="30%" align="right" valign="top"  class="blackbold"> 
                                                    <?= $ModuleName ?> Name : <span class="red">*</span> </td>
                                                <td width="56%"  align="left" valign="top">
                                                    <input  name="Name" id="Name" value="<? if(isset($arryCategory[0]['Name'])) echo  stripslashes($arryCategory[0]['Name']) ?>" type="text" class="inputbox"  size="50" />
                                                </td>
                                            </tr>
                                          
                                       
                                            <tr>
                                                <td align="right" valign="middle"  class="blackbold">Status : </td>
                                                <td align="left" class="blacknormal">
                                                    <table width="151" border="0" cellpadding="0" cellspacing="0" class="margin-left"  class="blacknormal">
                                                        <tr>
                                                            <td width="20" align="left" valign="middle"><input name="Status" type="radio" value="1" <?= ($CategoryStatus == 1) ? "checked" : "" ?> /></td>
                                                            <td width="48" align="left" valign="middle">Active</td>
                                                            <td width="20" align="left" valign="middle"><input name="Status" type="radio" <?= ($CategoryStatus == 0) ? "checked" : "" ?> value="0" /></td>
                                                            <td width="63" align="left" valign="middle">Inactive</td>
                                                        </tr>
                                                    </table>                      
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
                            <? if ($_GET['edit'] > 0) $ButtonTitle = 'Update'; else $ButtonTitle = 'Submit'; ?>
                            <input type="hidden" name="CategoryID" id="CategoryID" value="<?php echo $_GET['edit']; ?>">   
                            <input name="Submit" type="submit" class="button" id="addCategory" value="<?= $ButtonTitle ?>" />&nbsp;
                        </td>
                    </tr>
                </table>
               </form>
            </td>
          
        </tr>
    
</table>
